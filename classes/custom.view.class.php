<?php

class View extends Connection {

    public $id,$uid,$cid;
    public $view;
    public $title;
    public $description;
    public $time;

    public function create($vars){
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->view = $vars['view'];
        $this->title = $vars['title'];
        $this->description = $vars['description'];
        $this->time = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->view = $vars['view'];
        $this->title = $vars['title'];
        $this->description = $vars['description'];
        $this->time = $vars['time'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('custom_views','iiisssi',array(null,$this->uid,$this->cid,$this->view,$this->title,$this->description,$this->time));
        $this->close();
    }

    public function getByCommView($cid,$view){
        $this->connect();
        $return = $this->select('custom_views',array('*'),'is',array($cid,$view),'where (cid=? or cid=0) and view=? order by cid desc limit 1');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

}

class View_Column extends Connection {

    public $id,$uid,$cid,$vid;
    public $type;
    public $field;
    public $x,$y,$z;
    public $time;

    public function create($vars){
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->vid = $vars['vid'];
        $this->type = $vars['type'];
        $this->field = $vars['field'];
        $this->x = $vars['x'];
        $this->y = $vars['y'];
        $this->z = $vars['z'];
        $this->time = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->vid = $vars['vid'];
        $this->type = $vars['type'];
        $this->field = $vars['field'];
        $this->x = $vars['x'];
        $this->y = $vars['y'];
        $this->z = $vars['z'];
        $this->time = $vars['time'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('custom_columns','iiiissiiii',array(null,$this->uid,$this->cid,$this->vid,$this->type,$this->field,$this->x,$this->y,$this->z,$this->time));
        $this->close();
    }

    public function getByCustom($vid){
        $this->connect();
        $return = $this->select('custom_columns',array('*'),'i',array($vid),'where vid=? order by x asc,y asc,z asc');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $column = new View_Column();
                $column->createFromRow($row);
                if($column->type != 'literature-link')
                    $finalArray['tiles'][$column->x][$column->y][$column->z] = $column;
                else
                    $finalArray['literature'][] = $column;
            }
        }
        return $finalArray;
    }

}

?>