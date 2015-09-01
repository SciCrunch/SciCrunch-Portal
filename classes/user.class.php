<?php

class User extends Connection {

    public $id;
    private $password;
    public $email;
    public $firstname;
    public $middleInitial;
    public $lastname;
    public $role;
    public $organization;
    public $verified;
    public $verify_string;

    public $levels;
    public $mod;
    public $preferences;
    public $stats;
    public $keys;
    public $salt;
    public $created;
    public $banned;
    public $maxLevel = 0;
    public $rids;
    public $collections;
    public $items;

    public $onlineUsers;
    public $MAGIC = 215;

    public $last_check;

    public function create($vars) {
        $this->firstname = $vars['firstname'];
        $this->lastname = $vars['lastname'];
        $this->email = $vars['email'];
        $this->organization = $vars['organization'];

        $this->salt = str_replace('.', '', uniqid(mt_rand(), true));
        $this->password = $vars['password'];
        $this->role = 0;
        $this->banned = 0;
        $this->created = time();
        $this->verified = 0;

        $this->connect();
        do{
            $this->verify_string = str_replace('.', '', uniqid(mt_rand(), true));
        } while(count($this->select('users', array('verify_string'), 's', array($this->verify_string), 'where verify_string=?')) > 0);	// make sure verify string is unique
        $this->close();
    }

    public function createFromRow($row) {
        if (!$row || $row['guid'] == null || $row['guid'] == '') {
            $this->id = false;
        } else
            $this->id = $row['guid'];

        $this->email = $row['email'];
        $this->firstname = $row['firstName'];
        $this->lastname = $row['lastName'];
        $this->organization = $row['organization'];
        $this->middleInitial = $row['middleInitial'];
        $this->role = $row['level'];
        $this->banned = $row['banned'];
        $this->created = $row['created'];
        $this->verified = $row['verified'];
        $this->verify_string = $row['verify_string'];
    }

    public function getByName($name){
        $this->connect();
        $return = $this->select('users', array('guid'), 'ss', array($name[0],$name[1]), 'where firstName=? and lastName=? order by id asc limit 1');
        if (count($return) == 1) {
            $this->createFromRow($return[0]);
        }
        $this->close();
    }

    public function getByEmail($email){
        $this->connect();
        $return = $this->select('users', array('guid,email,firstName,lastName'), 's', array($email), 'where email=? order by id asc limit 1');
        if (count($return) == 1) {
            $this->createFromRow($return[0]);
        }
        $this->close();
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('users', array('*'), 'i', array($id), 'where guid=?');
        if (count($return) == 1) {
            $this->createFromRow($return[0]);
            $access = $this->select('community_access', array('*'), 'i', array($this->id), 'where uid=?');
            $resources = $this->select('community_log', array('*'), 'i', array($this->id), 'where uid=?');
            if (count($access) > 0) {
                foreach ($access as $row) {
                    $this->levels[$row['cid']] = $row['level'];
                }
            }
            if (count($resources) > 0) {
                foreach ($resources as $row) {
                    $this->preferences[$row['cmid']][$row['euid']][$row['action']] = true;
                }
            }
        }
        $this->close();
    }

    public function getUserCount(){
        $this->connect();
        $return = $this->select('users', array('count(id)'), null, array(), 'where email like "%@%"');
        $count = $return[0]['count(id)'];
        $this->close();

        return $count;
    }

    public function deleteDB(){
        $this->connect();
        $this->delete('users','i',array($this->id),'where guid=?');
        $this->delete('community_access','i',array($this->id),'where uid=?');
        $this->close();
    }

    public function getUsers($offset,$limit){
        $this->connect();
        $return = $this->select('users', array('*'), null, array(), 'where email like "%@%" order by id desc limit '.$offset.','.$limit);
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $user = new User();
                $user->createFromRow($row);
                $finalArray[] = $user;
            }
        }
        return $finalArray;
    }

    public function getUsersQuery($query,$offset,$limit){
        $this->connect();
        $return = $this->select('users', array('SQL_CALC_FOUND_ROWS *'), 'ssss', array('%'.$query.'%','%'.$query.'%','%'.$query.'%','%'.$query.'%'), 'where (firstName like ? or lastName like ? or email like ? or concat(firstName," ",lastName) like ?) and email like "%@%" order by id desc limit '.$offset.','.$limit);
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $user = new User();
                $user->createFromRow($row);
                $finalArray['results'][] = $user;
            }
        }
        return $finalArray;
    }

    public function updateOnline() {
        $this->connect();
        $time = strtotime(date("Y-m-d H:i:s"));
        $end = $time + 160;
        $online = $this->select('online_users', array('*'), 'i', array($_SESSION['user']->id), 'where uid=?');
        if (count($online) == 1) {
            if ($online[0]['end'] < $time) {
                $this->update('online_users', 'iiii', array('start', 'last', 'end'), array($time, $time, $end, $online[0]['id']), 'where id=?');
            } else {
                $this->update('online_users', 'iii', array('last', 'end'), array($time, $end, $online[0]['id']), 'where id=?');
            }
        } else {
            $this->insert('online_users', 'iiiii', array(null, $_SESSION['user']->id, $time, $end, $time));
        }
        $this->close();
        return $end - 10;
    }

    public function updateLocation($cid,$url){
        //echo str_replace('/','|',$url);
        $this->connect();
        $this->update('online_users','isi',array('cid','page'),array($cid,$url,$this->id),'where uid=?');
        $this->close();
    }

    public function goOffline() {
        $this->connect();
        $time = strtotime(date("Y-m-d H:i:s"));
        $this->update('online_users', 'iii', array('last_time', 'end'), array($time, $time, $_SESSION['user']->id), 'where uid=?');
        $this->close();
    }

    public function getOnlineUsers(){
        $time = time();
        $this->connect();
        $return = $this->select('online_users',array('uid'),'ii',array($time,$time),'where last<=? and end>?');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $user = new User();
                $user->getByID($row['uid']);
                $finalArray[] = $user;
            }
        }
        return $finalArray;
    }

    public function login($email, $password) {
        $db = mysql_connect(HOSTNAME, USERNAME, PASSWORD) or die('I cannot connect to MySQL.');
        mysql_select_db(DATABASE_NAME);

        $query = "select * from users where convert(password, char(1024)) = convert(md5(concat('$password', salt)), char(1024)) and email = '$email'";
        //echo $query.'<br/>';
        $result = mysql_query($query);
        if ($result) {
            $row = mysql_fetch_assoc($result);
            $this->createFromRow($row);
        }

        mysql_close($db);
        if ($this->id) {
            $this->connect();
            $access = $this->select('community_access', array('*'), 'i', array($this->id), 'where uid=?');
            $collect0 = $this->select('collected', array('count(*)'), 'i', array($this->id), 'where uid=? and collection=0');
            $collections = $this->select('collections', array('*'), 'i', array($this->id), 'where uid=? order by id desc');
            if($this->role>0){
                $questions = $this->select('component_data',array('count(*)'),null,array(),'where component=104 and description is null');
                if((int)$questions[0]['count(*)']>0){
                    $notification = new Notification();
                    $notification->create(array(
                        'sender' => 0,
                        'receiver' => $this->id,
                        'view' => 0,
                        'cid' => 0,
                        'timed'=>0,
                        'start'=>time(),
                        'end'=>time(),
                        'type' => 'pending-questions',
                        'content' => 'There are '.$questions[0]['count(*)'].' questions unanswered.'
                    ));
                    $notification->insertDB();
                    $this->last_check = time();
                }
            }
            if (count($access) > 0) {
                foreach ($access as $row) {
                    $this->levels[$row['cid']] = $row['level'];
                }
            }
            $default = new Collection();
            $default->createFromRow(array('id' => 0, 'name' => 'Default Collection', 'count' => $collect0[0]['count(*)'], 'time' => 1400569200));
            $this->collections[0] = $default;

            if (count($collections) > 0) {
                foreach ($collections as $row) {
                    $collection = new Collection();
                    $collection->createFromRow($row);
                    $this->collections[$collection->id] = $collection;
                }
            }

            $this->log('logged in');
            $this->close();
        }

    }

    public function findUser($term){
        $this->connect();
        $return = $this->select('users',array('*'),'sss',array('%'.$term.'%','%'.$term.'%','%'.$term.'%'),'where firstName like ? or lastName like ? or email like ? and email like "%@%"');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $user = new User();
                $user->createFromRow($row);
                $finalArray[] = $user;
            }
        }
        return $finalArray;
    }

    public function checkPassword($password){
        $this->connect();
        $salt = $this->select('users',array('salt'),'i',array($this->id),'where guid=?');
        $return = $this->select('users',array('guid'),'is',array($this->id,$password),'where guid=? and password=md5(concat(?,\''.$salt[0]['salt'].'\'))');
        $this->close();

        if(count($return)>0){
            if($return[0]['guid']==$this->id)
                return true;
        }
        return false;
    }

    public function updateField($field,$value){
        if ($field == 'id' || $field == 'guid' || $field == 'created') {
            return false;
        }

        $this->connect();
        if($field=='password'){
            $salt = $this->select('users',array('salt'),'i',array($this->id),'where guid=?');
            $this->updateSalt('users','si',array('password'),array($value,$this->id),$salt[0]['salt'],'where guid=?');
        } elseif($field=='banned'||$field=='level') {
            $this->update('users','ii',array($field),array($value,$this->id),'where guid=?');
        } else {
            $this->update('users','si',array($field),array($value,$this->id),'where guid=?');
        }
        $this->close();
        $this->log('update field: '.$field);
    }

    public function insertIntoDB() {
        $this->connect();

        $this->created = strtotime(date("Y-m-d H:i:s"));
        $stmt = $this->mysqli->prepare("INSERT INTO users VALUES (?, ?, ?, md5(concat(?, '$this->salt')), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        //printf("Errormessage: %s\n", $mysqli->error);
        //print_r($this);
        $stmt->bind_param('iisssiissssiis', $a = null, $this->id, $this->email, $this->password, $this->salt, $this->banned, $this->role, $this->firstname, $this->middleInitial, $this->lastname, $this->organization, $this->created, $this->verified, $this->verify_string);
//printf("Errormessage: %s\n", $mysqli->error);
        /* execute prepared statement */

        $return = $stmt->execute();
        $id = $stmt->insert_id;
        $this->id = $id + $this->MAGIC;

        $this->update('users','ii',array('guid'),array($this->id,$id),'where id=?');

        $this->close();
        $this->log('registered');
        return $return;
    }

    public function log($action){
        $this->connect();
        $this->insert('user_log','iisssi',array(null,$this->id,$this->getFullName(),'SciCrunch',$action,time()));
        $this->close();
    }

    public function getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function resetPassword() {

        $password = $this->firstname . '_' . $this->lastname . rand(0, 1000);

        $this->updateField('password', $password);

        $to = $this->email;
        $subject = 'SciCrunch Password Reset';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
        $headers .= 'From: support@scicrunch.com' . "\r\n";
        $message = 'Hello,'."\r\n\r\n".'We\'ve received a request to reset your SciCrunch password. We have reset your password';
        $message .= ' to: '.$password."\r\n\r\n".'If you did not send this request, please contact us at <a href="mailto:support@scicrunch.com">support@scicrunch.com</a>';

        $message .= "\r\n\r\nSciCrunch Staff";
        $sent = mail($to, $subject, $message, $headers);

        $this->log('reset pw');

        if ($sent)
            return true;
        else
            return false;
    }

    public function getMyResources() {
        $this->connect();
        $finalArray = array();
        $return = $this->select('resources',array('SQL_CALC_FOUND_ROWS *'),'i',array($this->id),'where uid=?');
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $resource = new Resource();
                $resource->createFromRow($row);
                $resource->getColumns();
                $finalArray['data'][] = $resource;
            }
        }

        return $finalArray;

    }

    public function get_gravatar($s = 300, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $this->email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }


    public function verifyUser($ver_string){
        $this->connect();
        $this->update('users', 'is', array('verified'), array(1, $ver_string), 'where verify_string=?');
        $this->close();
    }

    public function sendVerifyEmail(){
        $level_keys = array_keys($this->levels);
        if(count($level_keys) == 1 && $level_keys[0] != 0){
            $comm = new Community();
            $comm->getByID($level_keys[0]);
            //$comm_message = 'SciCrunch and the community <a href="http://' . $_SERVER['HTTP_POST'] . '/' . $comm->portalName . '">' . $comm->name . '</a>';
            $comm_message = $comm->name;
            $alt = 1;
        }else{
            $comm_message = "SciCrunch";
            $alt = 0;
            $comm = NULL;
        }
        $message = Array('Thank you for registering with ' . $comm_message . '.  Please click <a href="http://' . $_SERVER['HTTP_HOST'] . '/verification/' . $this->verify_string . '">here</a> to verify your email.');
        \helper\sendEmail(Array($this->email), $message, "SciCrunch email verification", NULL, NULL, $alt, $comm);
    }

    public function emailExists($email){
        $this->connect();
        $return = $this->select('users', array('*'), 's', array($email), 'where email=?');
        $this->close();
        if(count($return) == 0) return false;
        return true;
    }
}

?>
