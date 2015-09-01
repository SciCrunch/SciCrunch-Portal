<?php

class Error extends Connection {

    public $id;
    public $uid;
    public $type;
    public $message;
    public $seen;
    public $time;

    public function create($vars){
        $this->uid = $vars['uid'];
        $this->type = $vars['type'];
        $this->message = $vars['message'];
        $this->seen = 0;
        $this->time = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->type = $vars['type'];
        $this->message = $vars['message'];
        $this->seen = $vars['seen'];
        $this->time = $vars['time'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('error_notifications','iissii',array(null,$this->uid,$this->type,$this->message,$this->seen,$this->time));
        $this->close();
    }

    public function getByID($id){
        $this->connect();
        $return = $this->select('error_notifications',array('*'),'i',array($id),'where id=? and seen=0');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

    public function setSeen(){
        $this->connect();
        $this->update('error_notifications','ii',array('seen'),array(1,$this->id),'where id=?');
        $this->close();
    }
}

?>