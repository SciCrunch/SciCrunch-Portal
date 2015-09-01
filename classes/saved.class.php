<?php

class Saved extends Connection {

    public $id;
    public $uid;
    public $name;
    public $cid;
    public $category;
    public $subcategory;
    public $nif;
    public $query;
    public $display;
    public $params;
    public $weekly;
    public $time;

    public function create($vars){
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->name = $vars['name'];
        $this->category = $vars['category'];
        $this->subcategory = $vars['subcategory'];
        $this->nif = $vars['nif'];
        $this->query = $vars['query'];
        $this->display = $vars['display'];
        $this->params = $vars['params'];
        $this->weekly = $vars['weekly'];
        $this->time = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->name = $vars['name'];
        $this->cid = $vars['cid'];
        $this->category = $vars['category'];
        $this->subcategory = $vars['subcategory'];
        $this->nif = $vars['nif'];
        $this->query = $vars['query'];
        $this->display = $vars['display'];
        $this->params = $vars['params'];
        $this->weekly = $vars['weekly'];
        $this->time = $vars['time'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('saved_searches','iisissssssii',array(null,$this->uid,$this->name,$this->cid,$this->category,$this->subcategory,$this->nif,$this->query,$this->display,$this->params,$this->weekly,$this->time));
        $this->close();
    }

    public function returnURL(){
        $community = new Community();
        $community->getByID($this->cid);
        $url = '/'.$community->portalName.'/'.$this->category;
        if($this->subcategory){
            $url .= '/'.$this->subcategory;
        }
        if($this->nif){
            $url .= '/source/'.$this->nif;
        }
        $url .= '/search?q='.$this->query.$this->params;
        return $url;
    }

    public function getByID($id){
        $this->connect();
        $return = $this->select('saved_searches',array('*'),'i',array($id),'where id=?');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

    public function updateName($name){
        $this->connect();
        $this->update('saved_searches','si',array('name'),array($name,$this->id),'where id=?');
        $this->close();
    }

    public function checkExist($vars){
        $this->connect();
        $return = $this->select('saved_searches',array('id','name'),'iisssss',array($vars['uid'],$vars['cid'],$vars['category'],$vars['subcategory'],$vars['nif'],$vars['query'],$vars['params']),'where uid=? and cid=? and category=? and subcategory=? and nif=? and query=? and params=?');
        $this->close();

        if(count($return)>0){
            $saved = new Saved();
            $saved->createFromRow($return[0]);
            return $saved;
        } else {
            return false;
        }
    }

    public function getUserSearches($uid){
        $this->connect();
        $return = $this->select('saved_searches',array('*'),'i',array($uid),'where uid=?');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $saved = new Saved();
                $saved->createFromRow($row);
                $finalArray[] = $saved;
            }
        }

        return $finalArray;
    }

    public function deleteDB(){
        $this->connect();
        $this->delete('saved_searches','i',array($this->id),'where id=?');
        $this->close();
    }

}

?>