<?php

class Event extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $type;
    public $name;
    public $content;
    public $notice;
    public $start;
    public $end;
    public $submitTime;
    public $time;

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->type = $vars['type'];
        $this->name = $vars['name'];
        $this->content = $vars['content'];
        $this->notice = $vars['notice'];
        $this->start = $vars['start'];
        $this->end = $vars['end'];
        $this->submitTime = time();
    }

    public function createFromRow($row) {
        $this->id = $row['id'];
        $this->uid = $row['uid'];
        $this->cid = $row['cid'];
        $this->type = $row['type'];
        $this->name = $row['name'];
        $this->content = $row['content'];
        $this->notice = $row['notice'];
        $this->start = $row['start'];
        $this->end = $row['end'];
        $this->submitTime = $row['time'];
    }

    public function insertIntoDB() {
        $this->connect();
        $this->id = $this->insert('scicrunch_events', 'iiisssiiii', array(null, $this->uid, $this->cid, $this->type, $this->name, $this->content, $this->notice, $this->start, $this->end, $this->submitTime));
        $this->close();
    }

    public function updateDB() {
        $this->connect();
        $this->update('scicrunch_events', 'sssiiii', array('type', 'name', 'content', 'notice', 'start', 'end'), array($this->type, $this->name, $this->content, $this->notice, $this->start, $this->end, $this->id), 'where id=?');
        $this->close();
    }

    public function checkNoticeEvents($cids) {

        foreach ($cids as $cid) {
            $where[] = 'cid=' . $cid;
        }

        $this->connect();

        $this->time = strtotime(date("Y-m-d H:i:s"));
        $return = $this->select('scicrunch_events', array('*'), 'ii', array($this->time, $this->time), 'where notice=? and end>? and (' . join(' or ', $where) . ')');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $event = new Event();
                $event->createFromRow($row);
                $finalArray[] = $event;
            }
        }

        return $finalArray;
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('scicrunch_events', array('*'), 'i', array($id), 'where id=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getOngoingEvents() {
        $this->connect();
        $return = $this->select('scicrunch_events', array('*'), 'iiis', array($this->time, $this->time, $this->cid, $this->type), 'where notice<? and end>? and cid=? and type=? limit 1');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function checkActiveEvents() {
        $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $this->time = strtotime(date("Y-m-d H:i:s"));
        $stmt = $mysqli->prepare("select * from scicrunch_events where start<? and end>? limit 1");
        $stmt->bind_param('ii', $this->time, $this->time);
        /* execute prepared statement */
        $return = $stmt->execute();

        /* Fetch the value */
        $meta = $stmt->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = & $row[$field->name];
        }

        call_user_func_array(array($stmt, 'bind_result'), $params);

        while ($stmt->fetch()) {
            foreach ($row as $key => $val) {
                $c[$key] = $val;
            }
            $this->createFromRow($c);
        }
        /* close statement and connection */
        //print_r($this);
        $stmt->close();
        return;
    }

    public function getAllEvents($cids) {
        $this->connect();

        foreach ($cids as $cid) {
            $where[] = 'cid=' . $cid;
        }

        $this->time = strtotime(date("Y-m-d H:i:s"));
        $return = $this->select('scicrunch_events', array('*'), null, array(), 'where (' . join(' or ', $where) . ') order by start desc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $event = new Event();
                $event->createFromRow($row);
                $finalArray[] = $event;
            }
        }
        /* close statement and connection */
        //print_r($this);
        return $finalArray;
    }

}

?>
