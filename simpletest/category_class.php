<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/classes.php");

class CategoryTest extends UnitTestCase{

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

    public function testConsctructor() {
        // Constructor Test
        // Tests the constructor of the category class to make sure variables properly link to the right members.
        // when calling create for a Category, a new ID, active and time should be genearted, but the rest should stay the same

        $category = new Category();
        $category->create($this->initVars);

        foreach ($this->initVars as $key => $value) {
            if ($key == 'id' || $key == 'active' || $key == 'time')
                $this->assertFalse($category->$key == $value);
            else
                $this->assertEqual($category->$key, $value);
        }
    }

    public function testDbConstructor() {
        // DB Constructor Test
        // Tests the constructor for data from the database of the category class to make sure variables properly link to the right members.
        // when creating from row, then every value gets copied to the new Category

        $category = new Category();
        $category->createFromRow($this->initVars);

        foreach ($this->initVars as $key => $value) {
            $this->assertEqual($category->$key, $value);
        }   
    }

    public function testDbCompare() {
        // Check DB Structure
        // Checks the db backend to make sure the expected columns and ordering is set correctly.

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

        $this->assertTrue($isset);
        $this->assertEqual($type, $category->dbTypes);
    }

}

?>
