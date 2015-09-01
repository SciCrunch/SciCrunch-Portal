<?php

/*
 * Class Definition for Collections
 *    This class outlines the translation of the DB table collections to a PHP usable object. Collections are
 *    a way for users to store records from sources together in a single place to refer back to later
 *
 * @internal DBTable: collections
 * @vars DBColumns: id,uid,name,count,time (i,i,s,i,i)
 */

class Collection extends Connection {

    public $id;    // The Unique ID of the collection
    public $uid;   // The user ID of the user creating the collection
    public $name;  // The name of the collection
    public $count; // The number of items in the collection
    public $time;  // The Unix time this collection was created

    public $dbTypes = 'iisii';

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->name = $vars['name'];
        $this->count = $vars['count'];
        $this->time = time();
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->name = $vars['name'];
        $this->count = $vars['count'];
        $this->time = $vars['time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('collections', $this->dbTypes, array(null, $this->uid,$this->name, $this->count, $this->time));
        $this->close();
    }

    /*
     * public getCollectionsByUser
     *   A function to get all the collections a specific user has created
     *
     * @param int uid : the User ID of the user to get the collections from
     *
     * @return Collection[] finalArray: an array of collection objects that belong to that user
     */

    public function getCollectionsByUser($uid) {
        $this->connect();
        $return = $this->select('collections', array('*'), 'i', array($uid), 'where uid=? order by id asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $collection = new Collection();
                $collection->createFromRow($row);
                $finalArray[] = $collection;
            }
        }

        return $finalArray;
    }

    public function rename($name){
        $this->connect();
        $this->update('collections','si',array('name'),array($name,$this->id),'where id=?');
        $this->close();
        $this->name = $name;
    }

    public function deleteCollection(){
        $this->connect();
        $this->delete('collected','i',array($this->id),'where collection=?');
        $this->delete('collections','i',array($this->id),'where id=?');
        $this->close();
    }

    public function clearDuplicates(){
        $this->connect();
        $this->delete('collected using collected,collected c1','ii',array($this->id,$this->id),'where collected.collection=? and c1.collection=? and collected.id>c1.id and collected.uuid=c1.uuid');
        $return = $this->select('collected',array('count(*)'),'i',array($this->id),'where collection=?');
        $this->update('collections','ii',array('count'),array($return[0]['count(*)'],$this->id),'where id=?');
        $this->count = $return[0]['count(*)'];
        $this->close();
    }

    public function moveFromDefault(){
        $this->connect();
        $return = $this->select('collected',array('count(*)'),'i',array($this->uid),'where uid=? and collection=0');
        $this->update('collected','i',array('collection'),array($this->id),'where collection=0 and uid='.$_SESSION['user']->id);
        $this->count += $return[0]['count(*)'];
        $this->update('collections','ii',array('count'),array($return[0]['count(*)'],$this->id),'where id=?');
        $this->close();
    }

    public function moveToDefault(){
        $this->connect();
        $this->update('collected','ii',array('collection'),array(0,$this->id),'where collection=? and uid='.$_SESSION['user']->id);
        $this->close();
    }

}

class Item extends Connection {

    public $id;
    public $uid;
    public $collection;
    public $community;
    public $view;
    public $uuid;
    public $snippet;
    public $time;

    public $dbTypes = 'iiiisssi';

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->collection = $vars['collection'];
        $this->view = $vars['view'];
        $this->uuid = $vars['uuid'];
        $this->snippet = $vars['snippet'];
        $this->community = $vars['community'];
        $this->time = time();
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->collection = $vars['collection'];
        $this->view = $vars['view'];
        $this->uuid = $vars['uuid'];
        $this->snippet = $vars['snippet'];
        $this->community = $vars['community'];
        $this->time = $vars['time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('collected', $this->dbTypes, array(null, $this->uid, $this->collection, $this->community, $this->view, $this->uuid, $this->snippet, $this->time));
        $this->increment('collections','ii',array('count'),array(1,$this->collection),'where id=?');
        $this->close();
    }

    public function checkRecord($uid,$uuid){
        $this->connect();
        $return = $this->select('collected', array('*'), 'is', array($uid,$uuid), 'where uid=? and uuid=?');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $collect = new Item();
                $collect->createFromRow($row);
                $finalArray[$collect->collection] = $collect;
            }
        }
        return $finalArray;
    }

    public function checkExistence($uid,$collection,$uuid){
        $this->connect();
        $return = $this->select('collected',array('count(*)'),'iis',array($uid,$collection,$uuid),'where uid=? and collection=? and uuid=?');
        $this->close();

        if($return && $return[0]['count(*)']>0){
            return true;
        } else {
            return false;
        }
    }

    public function getFromCollection($uid,$collection,$uuid){
        $this->connect();
        $return = $this->select('collected',array('*'),'iis',array($uid,$collection,$uuid),'where uid=? and collection=? and uuid=?');
        $this->close();

        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('collected', array('*'), 'i', array($id), 'where id=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getByCollection($collection, $uid) {
        $this->connect();
        $return = $this->select('collected', array('*'), 'ii', array($collection, $uid), 'where collection=? and uid=?');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $collect = new Item();
                $collect->createFromRow($row);
                $finalArray[] = $collect;
            }
        }
        return $finalArray;
    }

    public function deleteItem(){
        $this->connect();
        $this->delete('collected','i',array($this->id),'where id=?');
        $this->increment('collections','ii',array('count'),array(-1,$this->collection),'where id=?');
        $this->close();
    }

}
?>
