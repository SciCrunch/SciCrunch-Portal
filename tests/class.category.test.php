<?php

class CategoryTest extends Test {

    public $initVars = array(
        'id' => 100,
        'uid' => 1,
        'cid' => 5,
        'x' => 2,
        'y' => 3,
        'z' => 4,
        'category' => 'My Category',
        'subcategory' => 'My Subcategory',
        'source' => 'nlx_144509-1',
        'filter' => '&filter=Something:hello',
        'facet' => '&facet=Other:bye',
        'active' => 2,
        'time' => 1
    );

    function __construct($output, $dependencies) {
        parent::__construct($output, $dependencies);
    }

    public function runTests($isXML) {
        $html = '';
        $this->dependencyChecks();
        if ($isXML) {
            $html .= '<class><name>Category Class</name><relies></relies><uses></uses><tests>';
            $html .= $this->outputXML($this->initTest());
            $html .= $this->outputXML($this->dbInitTest());
            $html .= $this->outputXML($this->dbCompareTest());
            $html .= '</tests></class>';
        } else {
            $html .= $this->setUpOutputTable('Category Class', array(), array());
            $html .= $this->outputResult($this->initTest());
            $html .= $this->outputResult($this->dbInitTest());
            $html .= $this->outputResult($this->dbCompareTest());
            $html .= $this->closeTable();
        }
        return $html;
    }

    public function initTest() {
        $vars['title'] = 'Constructor Test';
        $vars['description'] = 'Tests the constructor of the category class to make sure variables properly link to the
            right members.';

        $category = new Category();
        $category->create($this->initVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($key == 'id' || $key == 'active' || $key == 'time') {
                if ($category->$field == $value) {
                    if ($vars['status'] > 0)
                        $vars['status'] = 1;
                    $vars['reason'] .= "Initializer set $key when it wasn't supposed to.<br/>";
                }
            } else {
                if ($category->$field != $value) {
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

        $category = new Category();
        $category->createFromRow($this->initVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $field = $this->mapping($key);
            if ($category->$field != $value) {
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
        $columns = $db->show('community_structure');
        $db->close();

        $category = new Category();
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
        if ($type != $category->dbTypes) {
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