<?php

class CommunityTest extends Test {

    public $initVars = array(
        'id' => 100,
        'uid' => 1,
        'name' => 'Test Community',
        'shortName' => 'Test',
        'description' => 'Some testing community',
        'portalName' => 'test',
        'url' => 'http://test.com',
        'private' => 1,
        'access' => 1,
        'logo' => 'test.png',
        'resourceView' => 1,
        'dataView' => 1,
        'literatureView' => 1,
        'time' => 1
    );

    function __construct($output, $dependencies) {
        parent::__construct($output, $dependencies);
    }

    public function runTests($isXML) {
        $html = '';
        $this->dependencyChecks();
        if ($isXML) {
            $html .= '<class><name>Community Class</name><relies></relies><uses><class>Category Class</class></uses><tests>';
            $html .= $this->outputXML($this->initTest());
            $html .= $this->outputXML($this->dbInitTest());
            $html .= $this->outputXML($this->dbCompareTest());
            $html .= '</tests></class>';
        } else {
            $html .= $this->setUpOutputTable('Community Class', array(), array('Category Class'));
            $html .= $this->outputResult($this->initTest());
            $html .= $this->outputResult($this->dbInitTest());
            $html .= $this->outputResult($this->dbCompareTest());
            $html .= $this->closeTable();
        }
        return $html;
    }

    public function initTest() {
        $vars['title'] = 'Constructor Test';
        $vars['description'] = 'Tests the constructor of the community class to make sure variables properly link to the
            right members.';

        $community = new Community();
        $community->create($this->initVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($key == 'id' || $key == 'active' || $key == 'time') {
                if ($community->$field == $value) {
                    if ($vars['status'] > 0)
                        $vars['status'] = 1;
                    $vars['reason'] .= "Initializer set $key when it wasn't supposed to.<br/>";
                }
            } else {
                if ($community->$field != $value) {
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

        $community = new Community();
        $community->createFromRow($this->initVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($community->$field != $value) {
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
        $columns = $db->show('communities');
        $db->close();

        $community = new Community();
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
            $vars['reason'] .= "One of the columns was not expected<br/>";
        }
        if ($type != $community->dbTypes) {
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

?>