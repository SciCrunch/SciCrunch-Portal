<?php

class ResourceTest extends Test {

    public $initVars = array(
        'id' => 100,
        'uid' => 1,
        'email' => 'test@test.com',
        'cid' => '1',
        'rid' => 'NewID',
        'version'=>2,
        'original_id' => 'oldID',
        'pid' => 1,
        'parent' => 'Something',
        'type' => 'Resource',
        'typeID' => 1,
        'status' => 'Curated',
        'insert_time'=>1,
        'edit_time' => 1,
        'curate_time' => 1
    );

    public $columnVars = array(
        'id' => 100,
        'version' => 2,
        'name' => 'Resource Name',
        'value' => 'My Resource Name',
        'link' => 'otherID',
        'time' => 1
    );

    function __construct($output, $dependencies) {
        parent::__construct($output, $dependencies);
    }

    public function runTests($isXML) {
        $html = '';
        $this->dependencyChecks();
        if ($isXML) {
            $html .= '<class><name>Resource Class</name><relies></relies><uses><class>Category Class</class></uses><tests>';
            $html .= $this->outputXML($this->initTest());
            $html .= $this->outputXML($this->dbInitTest());
            $html .= $this->outputXML($this->dbCompareTest());
            $html .= '</tests></class>';
        } else {
            $html .= $this->setUpOutputTable('Resource and Column Class', array(), array());
            $html .= $this->outputResult($this->initTest());
            $html .= $this->outputResult($this->dbInitTest());
            $html .= $this->outputResult($this->dbCompareTest());
            $html .= $this->closeTable();
        }
        return $html;
    }

    public function initTest() {
        $vars['title'] = 'Constructor Test';
        $vars['description'] = 'Tests the constructor of the resource and column class to make sure variables properly link to the
            right members.';

        $resource = new Resource();
        $resource->create($this->initVars);

        $column = new Columns();
        $column->create($this->columnVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($key == 'id' || $key == 'insert_time' || $key == 'edit_time' || $key == 'curate_time' || $key == 'status' || $key == 'version' || $key == 'rid') {
                if ($resource->$field == $value) {
                    if ($vars['status'] > 0)
                        $vars['status'] = 1;
                    $vars['reason'] .= "Initializer set $key when it wasn't supposed to.<br/>";
                }
            } else {
                if ($resource->$field != $value) {
                    $vars['status'] = 0;
                    $vars['reason'] .= "The variable $field didn't match.<br/>";
                }
            }
        }

        foreach ($this->columnVars as $key => $value) {
            $field = $this->mapping($key);
            if ($key == 'id' || $key == 'time') {
                if ($column->$field == $value) {
                    if ($vars['status'] > 0)
                        $vars['status'] = 1;
                    $vars['reason'] .= "Initializer set $key when it wasn't supposed to.<br/>";
                }
            } else {
                if ($column->$field != $value) {
                    $vars['status'] = 0;
                    $vars['reason'] .= "The variable $field didn't match.<br/>";
                }
            }
        }

        if ($vars['reason'] == '')
            $vars['reason'] = 'Constructor output matches expectations.';

        return $vars;
    }

    public function dbInitTest() {
        $vars['title'] = 'DB Constructor Test';
        $vars['description'] = 'Tests the constructor for data from the database of the community class to make sure variables properly link to the
            right members.';

        $resource = new Resource();
        $resource->createFromRow($this->initVars);

        $column = new Columns();
        $column->createFromRow($this->columnVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($resource->$field != $value) {
                $vars['status'] = 0;
                $vars['reason'] .= "The variable $field didn't match.<br/>";
            }
        }

        foreach ($this->columnVars as $key => $value) {
            $field = $this->mapping($key);
            if ($column->$field != $value) {
                $vars['status'] = 0;
                $vars['reason'] .= "The variable $field didn't match.<br/>";
            }
        }

        if ($vars['reason'] == '')
            $vars['reason'] = 'Constructor output matches expectations.';

        return $vars;
    }

    public function dbCompareTest() {
        $vars['title'] = 'Check DB Structure';
        $vars['description'] = 'Checks the db backend to make sure the expected columns and ordering is set correctly.';

        $vars['reason'] = '';

        $db = new Connection();
        $db->connect();
        $columns = $db->show('resources');
        $columns2 = $db->show('resource_columns');
        $db->close();

        $resource = new Resource();
        $column = new Columns();
        $type = '';
        $isset = true;

        foreach ($columns as $row) {
            if (!isset($this->initVars[$row['Field']]))
                $isset = false;
            if ($row['Type'] == 'int(11)')
                $type .= 'i';
            elseif ($row['Type'] == 'text' || $row['Type']=='varchar(64)')
                $type .= 's';
        }

        if ($isset = false) {
            $vars['status'] = 0;
            $vars['reason'] .= "One of the columns was not expected<br/>";
        }
        if ($type != $resource->dbTypes) {
            $vars['status'] = 0;
            $vars['reason'] .= "The type ordering for Resource did not match<br/>";
        }

        $type = '';

        foreach ($columns2 as $row) {
            if (!isset($this->columnVars[$row['Field']]))
                $isset = false;
            if ($row['Type'] == 'int(11)')
                $type .= 'i';
            elseif ($row['Type'] == 'text' || $row['Type']=='varchar(64)')
                $type .= 's';
        }

        if ($isset = false) {
            $vars['status'] = 0;
            $vars['reason'] .= "One of the columns was not expected<br/>";
        }
        if ($type != $column->dbTypes) {
            $vars['status'] = 0;
            $vars['reason'] .= "The type ordering for Column did not match<br/>";
        }

        if ($vars['reason'] == '') {
            $vars['status'] = 2;
            $vars['reason'] = 'The DB structure matches expectations.';
        }

        return $vars;
    }

}

?>