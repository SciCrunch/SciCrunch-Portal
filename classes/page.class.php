<?php

class Page extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $position;
    public $url;
    public $title;
    public $content;
    public $active;
    public $time;

    public function create($vars){
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->position = $vars['position'];
        $this->url = $vars['url'];
        $this->title = $vars['title'];
        $this->content = $vars['content'];

        $this->active = 1;
        $this->time = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->position = $vars['position'];
        $this->url = $vars['url'];
        $this->title = $vars['title'];
        $this->content = $vars['content'];
        $this->active = $vars['active'];
        $this->time = $vars['time'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('community_pages','iiiisssii',array(null,$this->uid,$this->cid,$this->position,$this->url,$this->title,$this->content,$this->active,$this->time));
        $this->close();
    }

    public function setInactive(){
        $this->connect();
        $this->update('community_pages','ii',array('active'),array(0,$this->id),'where id=?');
        $this->close();
    }

    public function getByID($id){
        $this->connect();
        $return = $this->select('community_pages',array('*'),'i',array($id),'where id=?');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

    public function getByURL($url,$cid){
        $this->connect();
        $return = $this->select('community_pages',array('*'),'si',array($url,$cid),'where url=? and cid=? and active=1');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

    public function getPages($cid){
        $this->connect();
        $return = $this->select('community_pages',array('*'),'i',array($cid),'where cid=? and active=1 order by position asc');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $page = new Page();
                $page->createFromRow($row);
                $finalArray[] = $page;
            }
        }
        return $finalArray;
    }

}

?>