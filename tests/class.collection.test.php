<?php

class CollectionTest extends Test {

    public $initVars = array(
        'id' => 100,
        'uid' => 1,
        'name' => 'My Collection',
        'count' => 5,
        'time' => 1
    );

    public $itemVars = array(
        'id' => 100,
        'uid' => 1,
        'collection' => 1,
        'view' => 'nlx_144509-1',
        'uuid' => '23-45-67',
        'community' => 1,
        'snippet' => '<result><title>My Title</title><description>Some description of this item</description><url>http://scicrunch.com</url></result>',
        'time' => 1
    );

    function __construct($output, $dependencies) {
        parent::__construct($output, $dependencies);
    }

    public function runTests($isXML) {
        $html = '';
        $this->dependencyChecks();
        $testOutput = array($this->initTest(),$this->dbInitTest(),$this->dbCompareTest());
        $success = 2;
        if ($isXML) {
            $html .= '<class><name>Collection and Item Class</name><relies></relies><uses></uses><tests>';
            foreach($testOutput as $vars){
                if($vars['status']<$success)
                    $success = $vars['success'];
                $html .= $this->outputXML($vars);
            }
            $html .= '</tests><overall>'.$success.'</overall></class>';
        } else {
            $html .= $this->setUpOutputTable('Collection and Item Class', array(), array());
            foreach($testOutput as $vars){
                if($vars['status']<$success)
                    $success = $vars['success'];
                $html .= $this->outputResult($vars);
            }
            $html .= $this->closeTable();
        }
        return $html;
    }

    public function initTest() {
        $vars['title'] = 'Constructor Test';
        $vars['description'] = 'Tests the constructor of the collection and item classes to make sure variables properly link to the
            right members.';

        $collection = new Collection();
        $collection->create($this->initVars);

        $item = new Item();
        $item->create($this->itemVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($key == 'id' || $key == 'time') {
                if ($collection->$field == $value) {
                    if ($vars['status'] > 0)
                        $vars['status'] = 1;
                    $vars['reason'] .= "Initializer set $key when it wasn't supposed to.<br/>";
                }
            } else {
                if ($collection->$field != $value) {
                    $vars['status'] = 0;
                    $vars['reason'] .= "The variable $field didn't match.<br/>";
                }
            }
        }

        foreach ($this->itemVars as $key => $value) {
            $field = $this->mapping($key);
            if ($key == 'id' || $key == 'time') {
                if ($item->$field == $value) {
                    if ($vars['status'] > 0)
                        $vars['status'] = 1;
                    $vars['reason'] .= "Initializer set $key when it wasn't supposed to.<br/>";
                }
            } else {
                if ($item->$field != $value) {
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
        $vars['description'] = 'Tests the constructor for data from the database of the category class to make sure variables properly link to the
            right members.';

        $collection = new Collection();
        $collection->createFromRow($this->initVars);

        $item = new Item();
        $item->createFromRow($this->itemVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($collection->$field != $value) {
                $vars['status'] = 0;
                $vars['reason'] .= "The variable $field didn't match.<br/>";
            }
        }

        foreach ($this->itemVars as $key => $value) {
            $field = $this->mapping($key);
            if ($item->$field != $value) {
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
        $columns = $db->show('collections');
        $columns1 = $db->show('collected');
        $db->close();

        $collection = new Collection();
        $item = new Item();
        $type = '';
        $isset = true;

        foreach ($columns as $row) {
            if (!isset($this->initVars[$row['Field']]))
                $isset = false;
            if ($row['Type'] == 'int(11)')
                $type .= 'i';
            elseif ($row['Type'] == 'text')
                $type .= 's';
        }

        if ($isset = false) {
            $vars['status'] = 0;
            $vars['reason'] .= "One of the collection columns was not expected<br/>";
        }
        if ($type != $collection->dbTypes) {
            $vars['status'] = 0;
            $vars['reason'] .= "The collection type ordering did not match<br/>";
        }

        $type = '';
        $isset = true;

        foreach ($columns1 as $row) {
            if (!isset($this->initVars[$row['Field']]))
                $isset = false;
            if ($row['Type'] == 'int(11)')
                $type .= 'i';
            elseif ($row['Type'] == 'text')
                $type .= 's';
        }

        if ($isset = false) {
            $vars['status'] = 0;
            $vars['reason'] .= "One of the columns was not expected<br/>";
        }
        if ($type != $item->dbTypes) {
            $vars['status'] = 0;
            $vars['reason'] .= "The type ordering did not match<br/>";
        }

        if ($vars['reason'] == '') {
            $vars['status'] = 2;
            $vars['reason'] = 'The DB structure matches expectations.';
        }

        return $vars;
    }
}