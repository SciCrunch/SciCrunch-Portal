<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

require_once($_SERVER['DOCUMENT_ROOT'] . "/simpletest/simpletest/autorun.php");

class AllTests extends TestSuite{
    function AllTests(){
        $this->TestSuite("All tests");
        $this->addFile($_SERVER['DOCUMENT_ROOT'] . "/simpletest/category_class.php");
        $this->addFile($_SERVER['DOCUMENT_ROOT'] . "/simpletest/community_class.php");
        $this->addFile($_SERVER['DOCUMENT_ROOT'] . "/simpletest/search_class.php");
        $this->addFile($_SERVER['DOCUMENT_ROOT'] . "/simpletest/collection_class.php");
        $this->addFile($_SERVER['DOCUMENT_ROOT'] . "/simpletest/resource_class.php");
    }
}

?>
