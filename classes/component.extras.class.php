<?php

class Tag extends Connection {

    public $id;
    public $data_id;
    public $cid;
    public $component;
    public $tag;
    public $time;

    public function create($vars) {
        $this->data_id = $vars['data_id'];
        $this->cid = $vars['cid'];
        $this->component = $vars['component'];
        $this->tag = $vars['tag'];
        $this->time = time();
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->data_id = $vars['data_id'];
        $this->cid = $vars['cid'];
        $this->component = $vars['component'];
        $this->tag = $vars['tag'];
        $this->time = $vars['time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('component_tags', 'iiiisi', array(null, $this->data_id, $this->cid, $this->component, $this->tag, $this->time));
        $this->close();
    }

    public function getPopularTags($component, $cid, $offset, $limit) {
        $this->connect();
        if ($component)
            $return = $this->select('component_tags', array('tag', 'count(tag) as count'), 'ii', array($component, $cid), 'where component=? and cid=? and tag!="" group by tag order by count desc limit ' . $offset . ',' . $limit);
        else
            $return = $this->select('component_tags', array('tag', 'count(tag) as count'), 'i', array($cid), 'where cid=? and tag!="" group by tag order by count desc limit ' . $offset . ',' . $limit);
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $tag = new Tag();
                $tag->createFromRow($row);
                $finalArray[] = $tag;
            }
        }
        return $finalArray;
    }

}

class Extended_Data extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $component;
    public $data;
    public $type;
    public $name;
    public $description;
    public $link;
    public $file;
    public $extension;
    public $views;
    public $time;

    public function create($vars){
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->component = $vars['component'];
        $this->data = $vars['data'];
        $this->type = $vars['type'];
        $this->name = $vars['name'];
        $this->description = $vars['description'];
        $this->link = $vars['link'];
        $this->file = $vars['file'];
        $this->extension = $vars['extension'];

        $this->views = 0;
        $this->time = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->component = $vars['component'];
        $this->data = $vars['data'];
        $this->type = $vars['type'];
        $this->name = $vars['name'];
        $this->description = $vars['description'];
        $this->link = $vars['link'];
        $this->file = $vars['file'];
        $this->extension = $vars['extension'];
        $this->views = $vars['view'];
        $this->time = $vars['time'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('extended_data','iiiiissssssii',array(null,$this->uid,$this->cid,$this->component,$this->data,$this->type,$this->name,$this->description,$this->link,$this->file,$this->extension,$this->views,$this->time));
        $this->close();
    }

   	public function removeDB() {
        $this->connect();
        $this->delete('extended_data', 'i', array($this->id), 'where id=?');
        $this->close();
    }

    public function getByData($data,$separate){
        $this->connect();
        $return = $this->select('extended_data',array('*'),'i',array($data),'where data=?');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $extended = new Extended_Data();
                $extended->createFromRow($row);
                if($separate)
                    $finalArray[$extended->type][] = $extended;
                else
                    $finalArray[] = $extended;
            }
        }
        return $finalArray;
    }

    public function getByID($id){
        $this->connect();
        $return = $this->select('extended_data',array('*'),'i',array($id),'where id=?');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

    public function getCountOfType($data,$type){
        $this->connect();
        $return = $this->select('extended_data',array('count(*)'),'is',array($data,$type),'where data=? and type=?');
        $this->close();

        if(count($return)>0){
            return $return[0]['count(*)'];
        }
        return 0;
    }

}

?>
