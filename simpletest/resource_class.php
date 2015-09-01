<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/classes.php");

class ResourceTest extends UnitTestCase{

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
        'rid' => 200,
        'version' => 2,
        'name' => 'Resource Name',
        'value' => 'My Resource Name',
        'link' => 'otherID',
        'time' => 1
    );

    public function testInit() {
        // Constructor Test
        // Tests the constructor of the resource and column class to make sure variables properly link to the right members.

        $resource = new Resource();
        $resource->create($this->initVars);

        $column = new Columns();
        $column->create($this->columnVars);

        foreach ($this->initVars as $key => $value) {
            if ($key == 'id' || $key == 'insert_time' || $key == 'edit_time' || $key == 'curate_time' || $key == 'status' || $key == 'version' || $key == 'rid') 
                $this->assertNotEqual($resource->$key, $value);
            else
                $this->assertEqual($resource->$key, $value);
        }

        foreach ($this->columnVars as $key => $value) {
            if ($key == 'id' || $key == 'time') 
                $this->assertNotEqual($column->$key, $value);
            else
                $this->assertEqual($column->$key, $value);
        }
    }

    public function testDbInit() {
        // DB Constructor Test
        // Tests the constructor for data from the database of the community class to make sure variables properly link to the right members.

        $resource = new Resource();
        $resource->createFromRow($this->initVars);

        $column = new Columns();
        $column->createFromRow($this->columnVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $this->assertEqual($resource->$key, $value);
        }

        foreach ($this->columnVars as $key => $value) {
            $this->assertEqual($column->$key, $value);
        }
    }

    public function testDbCompare() {
        // Check DB Structure
        // Checks the db backend to make sure the expected columns and ordering is set correctly.

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

        $this->assertTrue($isset);
        $this->assertEqual($type, $resource->dbTypes);

        $type = '';

        foreach ($columns2 as $row) {
            if (!isset($this->columnVars[$row['Field']]))
                $isset = false;
            if ($row['Type'] == 'int(11)')
                $type .= 'i';
            elseif ($row['Type'] == 'text' || $row['Type']=='varchar(64)')
                $type .= 's';
        }

        $this->assertTrue($isset);
        $this->assertEqual($type, $column->dbTypes);
    }
}

?>
