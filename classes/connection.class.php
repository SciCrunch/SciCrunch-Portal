<?php

/*
 * Connection Class
 *   Handles the DB accessing for the site, all connection and querying goes through here
 */

class Connection {

    public $mysqli;

    /*
     * PUBLIC CONNECT
     *
     * handles the connecting to the MySQL server, must be done before any querying can happen
     *
     * @return void
     */

    public function connect() {
        $this->mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
		$this->mysqli->set_charset("utf8");
    }

    /*
     * PUBLIC INSERT
     *
     * Handles the insert queries into the DB
     *
     * @requires Connection::connect called prior
     *
     * @param String    table the table to insert into
     * @param String    types a string representation of the types being inserted (i for int, s for string)
     *                    ex. 'iiissii' if params has 3 ints, then 2 strings, then 2 ints
     * @param String[]  An Array of values to be inserted into the table (must match number of columns in the table)
     *
     * @return int id  the insert ID of the object you just inserted
     */

    public function insert($table, $types, $params) {
        $ref[0] = $types;
        foreach ($params as $i => $param) {
            $paramList[] = '?';
            $ref[$i + 1] = & $params[$i];
        }
        $sql = "INSERT INTO $table VALUES (" . join(', ', $paramList) . ")";
        //echo $sql;
        $stmt = $this->mysqli->prepare($sql);
        call_user_func_array(array($stmt, "bind_param"), $ref);
        $stmt->execute();
        //echo $mysqli->error;

        $id = $stmt->insert_id;

        /* close statement and connection */
        //echo("Statement failed: ". $stmt->error . "<br>");
        $stmt->close();
        return $id;
    }

    /*
     * PUBLIC UPDATE
     *
     * Handles the update queries to the DB
     *
     * @requires Connection::connect called prior to this
     *
     * @param String   table           the table containing the record(s) to update
     * @param String   types           the string representation of the types to be parameterized ('iissii')
     * @param String[] columns         an array of columns to update in the table
     * @param String[] params          an array of parameters used in the statement (includes where variables)
     * @param String   whereStatement  the where statement of the update (everything after the sets)
     *
     * @return void
     */

    public function update($table, $types, $columns, $params, $whereStatement) {
        //print_r($params);
        foreach ($columns as $column) {
            $paramList[] = $column . '=?';
        }
        $ref[0] = $types;
        foreach ($params as $i => $param) {
            $ref[$i + 1] = & $params[$i];
        }
        $sql = "UPDATE $table set " . join(',', $paramList) . ' ' . $whereStatement;
        //echo $sql;
        //print_r($ref);
        $stmt = $this->mysqli->prepare($sql);
        if ($types) {
            call_user_func_array(array($stmt, "bind_param"), $ref);
        }
        $stmt->execute();
        echo $this->mysqli->error;

        /* close statement and connection */
        $stmt->close();
    }

    public function updateSalt($table, $types, $columns, $params,$salt, $whereStatement) {
        //print_r($params);
        foreach ($columns as $column) {
            $paramList[] = $column . '=md5(concat(?,\''.$salt.'\'))';
        }
        $ref[0] = $types;
        foreach ($params as $i => $param) {
            $ref[$i + 1] = & $params[$i];
        }
        $sql = "UPDATE $table set " . join(',', $paramList) . ' ' . $whereStatement;
        //echo $sql;
        $stmt = $this->mysqli->prepare($sql);
        if ($types) {
            call_user_func_array(array($stmt, "bind_param"), $ref);
        }
        $stmt->execute();
        //echo $mysqli->error;

        /* close statement and connection */
        $stmt->close();
    }

    /*
     * PUBLIC INCREMENT
     *
     * Function handles a specific case of UPDATE that is a different structure. Will increment the columns in the
     * columns array by the values in params (if negative will decrement).
     *
     * @requires Connection::connect called before running a query
     *
     * @param String   table           the table to increment the records in
     * @param String   types           the variable types of the params ('iiisiiis')
     * @param String[] columns         an array of columns to increment
     * @param String[] params          the params that fill the ? in the statement
     * @param String   whereStatement  the statement that follows the update sets
     *
     * @return void
     */

    public function increment($table, $types, $columns, $params, $whereStatement) {
        foreach ($columns as $column) {
            $paramList[] = $column . '=' . $column . '+?';
        }
        $ref[0] = $types;
        foreach ($params as $i => $param) {
            $ref[$i + 1] = & $params[$i];
        }
        $sql = "UPDATE $table set " . join(',', $paramList) . ' ' . $whereStatement;
        //echo $sql;
        $stmt = $this->mysqli->prepare($sql);
        if ($types) {
            call_user_func_array(array($stmt, "bind_param"), $ref);
        }
        $stmt->execute();
        //echo $mysqli->error;

        /* close statement and connection */
        $stmt->close();
    }

    /*
     * PUBLIC SELECT
     *
     * Function that handles querying select statements from the DB. Will return an array of results or false if none
     *
     * @requires Connection::connect called before querying
     *
     * @param String   table           the table to get records from
     * @param String[] columns         an array of columns to get from the table array('*') is acceptable
     * @param String   types           the variable types of the params ('iiisiiis')
     * @param String[] params          the params that fill the ? in the statement
     * @param String   whereStatement  the where, order, and limit statements in a string
     *
     * @return String[][] finalArray   an array of records in a key:value pair array (column:value)
     */

    public function select($table, $columns, $types, $vars, $whereStatement) {

        if ($types) {
            $ref[0] = $types;
            foreach ($vars as $i => $param) {
                $ref[$i + 1] = & $vars[$i];
            }
        }
        $sql = "SELECT " . join(',', $columns) . " FROM $table " . $whereStatement;
        //echo $sql;
        $stmt = $this->mysqli->prepare($sql);
        if ($types) {
            call_user_func_array(array($stmt, "bind_param"), $ref);
        }
        $stmt->execute();
        //echo $mysqli->error;

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
            $finalArray[] = $c;
        }
        /* close statement and connection */
        //print_r($this);
        $stmt->close();
        return $finalArray;
    }

    public function show($table) {

        $sql = "SHOW COLUMNS FROM $table";
        //echo $sql;
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        //echo $mysqli->error;

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
            $finalArray[] = $c;
        }
        /* close statement and connection */
        //print_r($this);
        $stmt->close();
        return $finalArray;
    }

    /*
     * PUBLIC GETTOTAL
     *
     * A secondary function that would follow a select statement that uses SQL_CALC_FOUND_ROWS to get the total
     * results found in the query
     *
     * @requires Connection::connect called prior to this
     * @requires SQL_CALC_FOUND_ROWS be used in a statement called before this
     *
     * @return int finalArray the number of results found in the previous statement
     */

    public function getTotal() {

        $sql = "SELECT FOUND_ROWS() as a";
        //echo $sql;
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        //echo $mysqli->error;

        /* Fetch the value */
        $meta = $stmt->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = & $row[$field->name];
        }

        call_user_func_array(array($stmt, 'bind_result'), $params);

        $finalArray = array();
        while ($stmt->fetch()) {
            foreach ($row as $key => $val) {
                $c[$key] = $val;
            }
            $finalArray = $c['a'];
        }
        /* close statement and connection */
        //print_r($this);
        $stmt->close();
        return (int)$finalArray;
    }

    /*
     * PUBLIC DELETE
     *
     * A function to handle delete statements sent to the DB. Will delete whatever it is told to delete, so be careful
     * with what is passed into the function
     *
     * @requires Connection::connect called prior to this
     *
     * @param String   table           the table to delete records from
     * @param String   types           the variable types of the params ('iiisiiis')
     * @param String[] params          the params that fill the ? in the statement
     * @param String   whereStatement  the where statement for what to delete
     *
     * @return void
     */

    public function delete($table, $types, $params, $whereStatement) {
        if ($whereStatement != '') {
            $ref[0] = $types;
            foreach ($params as $i => $param) {
                $ref[$i + 1] = & $params[$i];
            }
            //print_r($ref);
            $sql = "DELETE FROM $table " . $whereStatement;
            //echo $sql;
            $stmt = $this->mysqli->prepare($sql);
            if ($types) {
                call_user_func_array(array($stmt, "bind_param"), $ref);
            }
            $stmt->execute();
            //echo $mysqli->error;

            /* close statement and connection */
            $stmt->close();
        }
    }

    /*
     * PUBLIC CLOSE
     *
     * Used to close the connection opened up by Connection::connect
     *
     * @requires Connection::connect be called before this and still open
     */

    public function close() {
        mysqli_close($this->mysqli);
    }

    /*
     * PUBLIC TIMEDIFFERENCE
     *
     * Function to get a shorted representation of the time since something happened. Examples: 2h 1m, 3w 16h 24m
     *
     * @param int then  the UNIX time in the past to get the time since
     *
     * @return String the String representation of the time since then
     */

    public static function timeDifference($then) {
        $label = array('M', 'w', 'd', 'h', 'm');
        $timeArray = array(2419200, 604800, 86400, 3600, 60);
        $now = strtotime(date("Y-m-d H:i:s"));
        $diff = abs($now - $then);
        foreach ($timeArray as $i => $unit) {
            $since[$i] = floor($diff / $unit);
            $diff = $diff % $unit;
        }
        $return = '';
        foreach ($since as $i => $num) {
            if ($num > 0) {
                if ($return == '' && $i < 4)
                    $return .= $num . $label[$i] . ' ';
                else {
                    return $return . $num . $label[$i];
                }
            }
        }
        return '<1m';
    }

    /*
     * PUBLIC LONGTIMEDIFFERENCE
     *
     * Function to get a longer representation of the time since something happened. Will only stop at 2 largest values
     * Examples: 2 hours 1 month ago, 3 weeks 16 hours ago
     *
     * @param int then  the UNIX time in the past to get the time since
     *
     * @return String the String representation of the time since then
     */

    public static function longTimeDifference($then) {
        $label = array('year','month', 'week', 'day', 'hour', 'minute');
        $timeArray = array(29030400,2419200, 604800, 86400, 3600, 60);
        $now = strtotime(date("Y-m-d H:i:s"));
        $diff = abs($now - $then);
        foreach ($timeArray as $i => $unit) {
            $since[$i] = floor($diff / $unit);
            $diff = $diff % $unit;
        }
        $return = '';
        foreach ($since as $i => $num) {
            if ($num > 0) {
                if ($num > 1) {
                    return $num . ' ' . $label[$i] . 's ago';
                } else {
                    return $num . ' ' . $label[$i] . ' ago';
                }
            }
        }
        return '<1m';
    }

    /*
     * PUBLIC MULTI
     *
     * Function to perform URL Gets (calling a URL and getting the response; like XML) concurrently.
     *
     * @param String[] urls  the array of URLs to get concurrently
     *
     * @return String[] res  an array of files (XMLs, HTML, whatever was at the URL)
     */

    public static function multi($urls) {
        // Create get requests for each URL
        //echo 'here';
        $mh = curl_multi_init();
        foreach ($urls as $i => $url) {
            //echo $url;
            $ch[$i] = curl_init($url);
            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
            curl_multi_add_handle($mh, $ch[$i]);
        }

        // Start performing the request
        do {
            $execReturnValue = curl_multi_exec($mh, $runningHandles);
        } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
        // Loop and continue processing the request
        while ($runningHandles && $execReturnValue == CURLM_OK) {
            // Wait forever for network
            $numberReady = curl_multi_select($mh);
            if ($numberReady != -1) {
                // Pull in any new data, or at least handle timeouts
                do {
                    $execReturnValue = curl_multi_exec($mh, $runningHandles);
                } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
            }else {
                usleep(100000);
                do {
                    $execReturnValue = curl_multi_exec($mh, $runningHandles);
                } while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
            }
        }
        // Check for any errors
        if ($execReturnValue != CURLM_OK) {
            trigger_error("Curl multi read error $execReturnValue\n", E_USER_WARNING);
        }

        // Extract the content
        foreach ($urls as $i => $url) {
            // Check for errors
            $curlError = curl_error($ch[$i]);

            if ($curlError == "") {
                $res[$i] = curl_multi_getcontent($ch[$i]);
            } else {
                print "Curl error on handle $i: $curlError\n";
            }
            // Remove and close the handle
            curl_multi_remove_handle($mh, $ch[$i]);
            curl_close($ch[$i]);
        }
        // Clean up the curl_multi handle
        curl_multi_close($mh);

        // Print the response data
        return $res;
    }

    public static function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray = array();
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal = hexdec($hexStr);
            $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }

    /*
     * PUBLIC CREATEBREADCRUMBS
     *
     * A function to create a breadcrumbs component in HTML dynamically.
     *
     * @param String   title    the title used on the left of the Breadcrumbs component
     * @param String[] options  an array of the text breadcrumbs
     * @param String[] urls     an array of urls to use with the text
     * @param String   active   the current page in the breadcrumbs that has no link
     *
     * @return String  html     the HTML for the breadcrumbs component
     */

    public static function createBreadCrumbs($title,$options,$urls,$active) {
        $html = '<div class="breadcrumbs-v3">
                    <div class="container">
                        <h1 class="pull-left">'.$title.'</h1>
                        <ul class="pull-right breadcrumb">';
        if(count($options)>0){
            foreach($options as $i=>$opt){
                $html .= '<li><a href="'.$urls[$i].'">'.$opt.'</a></li>';
            }
        }
        $html .= '<li class="active">'.$active.'</li>
                        </ul>
                    </div>
                </div>';
        return $html;
    }

    /*
     * PUBLIC CREATEPROFILETABS
     *
     * Function to create the tabs used in on profile pages in Communities or SciCrunch pages
     *
     * @param int    active  the current active tab, 0-3 acceptable
     * @param String url     the base url that the tab should link to
     * @param String goto    A url only filled out if there should be a button to link to the community
     *
     * @return String html  the HTML to create the tabs
     */

    public static function createProfileTabs($active,$url,$goto,$vars){
        $titles = array('Information','Content','Appearance','Resources');
        $tabs = array('information','content','appearance','resources');
        $html = '<div class="tab-v1">
                    <ul class="nav nav-tabs margin-bottom-20">';
        for($i=0;$i<4;$i++){
            if($active==$i){
                $html .= '<li class="active"><a style="cursor: pointer" href="'.$url.'?tab='.$tabs[$i].'">'.$titles[$i].'</a></li>';
            } else {
                $html .= '<li><a href="'.$url.'?tab='.$tabs[$i].'">'.$titles[$i].'</a></li>';
            }
        }
        if($goto)
            $html .= '<li class="pull-right"><a href="'.$goto.'"><i class="fa fa-share"></i> Goto Community</a></li>';
        if(count($vars)>0){
            foreach($vars as $array){
                $html .= '<li class="pull-right"><a href="'.$array['url'].'"><i class="fa fa-share"></i> '.$array['name'].'</a></li>';
            }
        }
        $html .= '</ul></div>';
        return $html;
    }

}

?>
