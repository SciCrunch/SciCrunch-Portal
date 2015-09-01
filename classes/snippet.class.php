<?php

class Snippet extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $view;
    public $sourceName;
    public $snippet;
    public $raw;
    public $using;
    public $time;

    public function create($vars){
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->view = $vars['view'];
        $this->sourceName = $vars['sourceName'];
        $this->time = time();
    }

    public function setSnippet($vars){
        $title = '<a class="fullrecord" style="text-decoration:underline;display:inline;margin-right:5px;cursor:pointer" view="' . $this->view . '" uuid="${v_uuid}" title="See Full Record">' . strip_tags($vars['title']) . '</a>';
        $this->raw = '<?xml version="1.0" encoding="UTF-8"?><result><title>' . htmlentities($title) . '</title><description>' . htmlentities($vars['description']) . '</description><citation>' . htmlentities($vars['citation']) . '</citation><url>' . htmlentities($vars['url']) . '</url></result>';
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->view = $vars['view'];
        $this->sourceName = $vars['sourceName'];
        $this->raw = $vars['snippet'];
        $this->time = $vars['time'];
    }

    public function splitParts(){
        $xml = simplexml_load_string($this->using);
        if ($xml) {
            $this->snippet['title'] = html_entity_decode($xml->title);
            $this->snippet['description'] = html_entity_decode($xml->description);
            $this->snippet['citation'] = html_entity_decode($xml->citation);
            $this->snippet['url'] = html_entity_decode($xml->url);
        } else {
            $split = explode('</title>', $this->using);
            $this->snippet['title'] = html_entity_decode(end(explode('<title>', $split[0])));
            $splits = explode('<citation>', $split[1]);
            if (count($splits) > 1) {
                $splitter = explode('</citation>', $splits[1]);
                $this->snippet['citation'] = html_entity_decode($splitter[0]);
            } else {
                $this->snippet['citation'] = false;
            }
            $desc = $splits[0];
            $this->snippet['description'] = html_entity_decode(trim(str_replace('<description>', '', str_replace('</description>', '', $desc))));
        }
        return true;
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('snippets','iiisssi',array(null,$this->uid,$this->cid,$this->view,$this->sourceName,$this->raw,$this->time));
        $this->close();
    }

    public function updateDB() {
        $this->connect();
        $this->update('snippets','issi',array('uid','sourceName','snippet'),array($this->uid,$this->sourceName,$this->raw,$this->id),'where id=?');
        $this->close();
    }

    public function getSnippetByView($cid,$view){
        $this->connect();
        $return = $this->select('snippets',array('snippet'),'is',array($cid,$view),'where cid=? and view=?');
        if(count($return)>0){
            $this->raw = $return[0]['snippet'];
        } else {
            $return = $this->select('snippets',array('snippet'),'s',array($view),'where cid=0 and view=?');
            if(count($return)>0){
                $this->raw = $return[0]['snippet'];
            }
        }
        $this->close();
    }

    public function getCommunityVersion($cid,$view){
        $this->connect();
        $return = $this->select('snippets',array('*'),'is',array($cid,$view),'where cid=? and view=?');
        $this->close();
        if(count($return)>0){
            $this->createFromRow($return[0]);
        }
    }

    public function resetter(){
        $this->using = $this->raw;
        $this->snippet = '';
    }

    public function replace($name,$value){
        $this->using = str_replace('${' . (string)$name . '}', htmlentities($value), $this->using);
    }

}

?>