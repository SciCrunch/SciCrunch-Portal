<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/classes.php");

class CollectionTest extends UnitTestCase{

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

    public function testInit() {
        // Constructor Test
        // Tests the constructor of the collection and item classes to make sure variables properly link to the right members.

        $collection = new Collection();
        $collection->create($this->initVars);

        $item = new Item();
        $item->create($this->itemVars);

        foreach ($this->initVars as $key => $value) {
            if ($key == 'id' || $key == 'time')
                $this->assertNotEqual($collection->$key, $value);
            else
                $this->assertEqual($collection->$key, $value);
        }

        foreach ($this->itemVars as $key => $value) {
            if ($key == 'id' || $key == 'time')
                $this->assertNotEqual($item->$key, $value);
            else
                $this->assertEqual($item->$key, $value);
        }
    }

    public function testDbInit() {
        // DB Constructor Test
        // Tests the constructor for data from the database of the category class to make sure variables properly link to the right members.

        $collection = new Collection();
        $collection->createFromRow($this->initVars);

        $item = new Item();
        $item->createFromRow($this->itemVars);

        $vars['status'] = 2;
        $vars['reason'] = '';

        foreach ($this->initVars as $key => $value) {
            $this->assertEqual($collection->$key, $value);
        }

        foreach ($this->itemVars as $key => $value) {
            $this->assertEqual($item->$key, $value);
        }
    }

    public function testDbCompare() {
        // Check DB Structure
        // Checks the db backend to make sure the expected columns and ordering is set correctly.

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

        $this->assertTrue($isset);
        $this->assertEqual($type, $collection->dbTypes);

        $type = '';
        $isset = true;

        foreach ($columns1 as $row) {
            if (!isset($this->itemVars[$row['Field']]))
                $isset = false;
            if ($row['Type'] == 'int(11)')
                $type .= 'i';
            elseif ($row['Type'] == 'text')
                $type .= 's';
        }

        $this->assertTrue($isset);
        $this->assertEqual($type, $item->dbTypes);

    }
}

?>
