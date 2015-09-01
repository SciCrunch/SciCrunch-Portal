<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/classes.php");

class CommunityTest extends UnitTestCase{

    public $initVars = array(
        'id' => 100,
        'uid' => 1,
        'name' => 'Test Community',
        'shortName' => 'Test',
        'description' => 'Some testing community',
        'address' => 'test st',
        'portalName' => 'test',
        'url' => 'http://test.com',
        'private' => 1,
        'access' => 1,
        'logo' => 'test.png',
        'resourceView' => 1,
        'dataView' => 1,
        'about_home_view' => 1,
        'about_sources_view' => 1,
        'literatureView' => 1,
        'time' => 1
    );

    public function testInit() {
        // Constructor Test
        // Tests the constructor of the community class to make sure variables properly link to the right members.

        $community = new Community();
        $community->create($this->initVars);

        foreach ($this->initVars as $key => $value) {
            if ($key == 'id' || $key == 'active' || $key == 'time')
                $this->assertFalse($community->$key == $value);
            else
                $this->assertEqual($community->$key, $value);
        }
    }

    public function testDbInit() {
        // DB Constructor Test
        // Tests the constructor for data from the database of the community class to make sure variables properly link to the right members.

        $community = new Community();
        $community->createFromRow($this->initVars);

        foreach ($this->initVars as $key => $value) {
            $this->assertEqual($community->$key, $value);
        }
    }

    public function testDbCompare() {
        // Check DB Structure
        // Checks the db backend to make sure the expected columns and ordering is set correctly.

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

        $this->assertTrue($isset);
        $this->assertEqual($type, $community->dbTypes);
    }
}

?>
