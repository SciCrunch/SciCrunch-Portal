<?php

class Sources extends Connection {

    public $id;
    public $nif;
    public $source;
    public $view;
    public $description;
    public $image;
    public $data;
    public $created;
    public $updated;

    public function create($vars){
        $this->nif = $vars['nif'];
        $this->source = $vars['source'];
        $this->view = $vars['view'];
        $this->description = $vars['description'];
        $this->image = $vars['image'];
        $this->data = $vars['data'];

        $this->created = time();
    }

    public function updateData($vars){
        $this->nif = $vars['nif'];
        $this->source = $vars['source'];
        $this->view = $vars['view'];
        $this->description = $vars['description'];
        $this->image = $vars['image'];
        $this->data = $vars['data'];

        $this->updated = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->nif = $vars['nif'];
        $this->source = $vars['source'];
        $this->view = $vars['view'];
        $this->description = $vars['description'];
        $this->image = $vars['image'];
        $this->data = $vars['data'];
        $this->created = $vars['created'];
        $this->updated = $vars['updated'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('scicrunch_sources','isssssiii',array(null,$this->nif,$this->source,$this->view,$this->description,$this->image,$this->data,$this->created,$this->updated));
        $this->close();
    }

    public function updateDB(){
        $this->connect();
        $this->update('scicrunch_sources','sssssiii',array('nif','source','view','description','image','data','updated'),array($this->nif,$this->source,$this->view,$this->description,$this->image,$this->data,$this->updated,$this->id),'where id=?');
        $this->close();
    }

    public function getAllSources(){
        $this->connect();
        $return = $this->select('scicrunch_sources',array('*'),null,array(),'order by source asc, view asc');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $source = new Sources();
                $source->createFromRow($row);
                $finalArray[$source->nif] = $source;
            }
            return $finalArray;
        } else return array();
    }

    public function getTitle(){
        return $this->source.': '.$this->view;
    }

    public function getRecentlyAdded($offset,$limit){
        $this->connect();
        $return = $this->select('scicrunch_sources',array('*'),null,array(),'order by created desc limit '.$offset.','.$limit);
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $source = new Sources();
                $source->createFromRow($row);
                $finalArray[] = $source;
            }
            return $finalArray;
        } else return array();
    }

    public function getByView($nif){
        $this->connect();
        $return = $this->select('scicrunch_sources',array('*'),'s',array($nif),'where nif=? order by id desc limit 1');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

}

?>