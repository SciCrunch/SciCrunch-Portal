<?php

abstract class Test {

    public $output;
    public $dependecies;
    public $resultCodes = array(
        0 => array('type' => 'Failed', 'html' => '<span class="label label-danger">Failed</span>'),
        1 => array('type' => 'Warning', 'html' => '<span class="label label-warning">Warning</span>'),
        2 => array('type' => 'Success', 'html' => '<span class="label label-success">Success</span>')
    );

    function __construct($output, $dependencies) {
        $this->output = $output;
        $this->dependecies = $dependencies;
    }

    public function mapping($key) {
        return $key;
    }

    public function dependencyChecks() {
        if ($this->dependecies)
            return true;
        else return false;
    }

    abstract function runTests($isXML);

    public function setUpOutputTable($category, $relyArray, $useArray) {
        if (!$this->output)
            return '';
        $html = '<div class="table-search-v1 panel panel-dark margin-bottom-50">
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left"><a name="' . $category . '"><i class="fa fa-code"></i> ' . $category . '</a></h3>';
        if (count($relyArray) > 0 || count($useArray) > 0) {
            $html .= '<div class="pull-right">';
            if (count($relyArray) > 0) {
                $html .= '<div class="btn-group" style="margin:0 10px">
                        <button type="button" class="btn-u btn-u-blue dropdown-toggle" data-toggle="dropdown">
                            Relies On
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">';
                foreach ($relyArray as $class) {
                    $html .= '<li><a href="#' . $class . '">' . $class . '</a></li>';
                }

                $html .= '</ul>
                    </div>';
            }

            if (count($useArray) > 0) {
                $html .= '<div class="btn-group" style="margin:0 10px">
                        <button type="button" class="btn-u dropdown-toggle" data-toggle="dropdown">
                            Uses
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">';
                foreach ($useArray as $class) {
                    $html .= '<li><a href="#' . $class . '">' . $class . '</a></li>';
                }

                $html .= '</ul>
                    </div>';
            }

            $html .= '</div>';
        }

        $html .= '<div class="clearfix"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead><tr>
                                <th>Status</th>
                                <th>Test Name</th>
                                <th>Test Description</th>
                                <th>Test Result</th>
                            </tr></thead><tbody>';
        return $html;
    }

    public function outputResult($vars) {
        if (!$this->output)
            return '';
        $html = '<tr>';
        $html .= '<td>' . $this->resultCodes[$vars['status']]['html'] . '</td>';
        $html .= '<td>' . $vars['title'] . '</td>';
        $html .= '<td>' . $vars['description'] . '</td>';
        $html .= '<td>' . $vars['reason'] . '</td>';
        $html .= '</tr>';
        return $html;
    }

    public function outputXML($vars){
        $html = '<test>';
        $html .= '<status>'.$vars['status'].'</status>';
        $html .= '<title>'.$vars['title'].'</title>';
        $html .= '<description>'.$vars['description'].'</description>';
        $html .= '<reason>'.$vars['reason'].'</reason>';
        $html .= '</test>';
        return $html;
    }

    public function closeTable() {
        return '</tbody></table></div></div>';
    }

    public function doAllTests($isXML){
        $html = '';
        $total = 2;
        if($isXML)
            $html .= '<result><version>'.VERSION.'</version><time>'.date('h:ia F j, Y',time()).'</time><classes>';

        $test = new CategoryTest($this->output, $this->dependecies);
        $holder = $test->runTests($isXML);
        if($isXML){
            $xml = simplexml_load_string($holder);
            if($xml){
                if(isset($xml->overall) && (int)$xml->overall < $total)
                    $total = (int)$xml->overall;
            }
        }
        $html .= $holder;

        $test = new CommunityTest($this->output, $this->dependecies); $holder = $test->runTests($isXML);
        if($isXML){
            $xml = simplexml_load_string($holder);
            if($xml){
                if(isset($xml->overall) && (int)$xml->overall < $total)
                    $total = (int)$xml->overall;
            }
        }
        $html .= $holder;

        $test = new SearchTest($this->output, $this->dependecies); $holder = $test->runTests($isXML);
        if($isXML){
            $xml = simplexml_load_string($holder);
            if($xml){
                if(isset($xml->overall) && (int)$xml->overall < $total)
                    $total =(int) $xml->overall;
            }
        }
        $html .= $holder;

        $test = new CollectionTest($this->output, $this->dependecies); $holder = $test->runTests($isXML);
        if($isXML){
            $xml = simplexml_load_string($holder);
            if($xml){
                if(isset($xml->overall) && (int)$xml->overall < $total)
                    $total = (int)$xml->overall;
            }
        }
        $html .= $holder;

        $test = new ResourceTest($this->output, $this->dependecies); $holder = $test->runTests($isXML);
        if($isXML){
            $xml = simplexml_load_string($holder);
            if($xml){
                if(isset($xml->overall) && (int)$xml->overall < $total)
                    $total = (int)$xml->overall;
            }
        }
        $html .= $holder;

        if($isXML)
            $html .= '</classes><status>'.$total.'</status></result>';

        return $html;
    }

    public function parseXML($file){
        $xml = simplexml_load_string($file);
        if($xml){
            $html = '<h1 align="center" style="margin-top: 40px">SciCrunch Test Suite - v'.$xml->version.'</h1>

                <p style="margin:20px 0">
                    This is a prior test ran at '.$xml->time.'
                </p>';
            foreach($xml->classes->class as $class){
                $relyArray = array();$usesArray = array();
                foreach($class->relies->class as $rely) $relyArray[] = (string)$rely;
                foreach($class->uses->class as $use) $usesArray[] = (string)$use;
                $html .= $this->setUpOutputTable($class->name,$relyArray,$usesArray);
                foreach($class->tests->test as $test){
                    $vars['status'] = (string)$test->status;
                    $vars['title'] = (string)$test->title;
                    $vars['description'] = (string)$test->description;
                    $vars['reason'] = (string)$test->reason;
                    $html .= $this->outputResult($vars);
                }
                $html .= $this->closeTable();
            }
        }
        return $html;
    }

}