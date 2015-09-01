<?php

class Challenge extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $component;
    public $position;
    public $type;
    public $image;
    public $text1, $text2, $text3;
    public $color1, $color2, $color3;
    public $icon1, $icon2, $icon3;
    public $disabled;
    public $time;

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->component = $vars['component'];
        $this->position = $vars['position'];
        $this->image = $vars['image'];
        $this->title = $vars['title'];
        $this->icon = $vars['icon'];
        $this->description = $vars['description'];
        $this->content = $vars['content'];
        $this->link = $vars['link'];
        $this->color = $vars['color'];
        $this->start = $vars['start'];
        $this->end = $vars['end'];

        $this->views = 0;
        $this->disabled = 0;
        $this->time = time();
        $this->anonymous = $vars['anonymous'];
    }



	public function insertChallengeDB() {
        
        $this->connect();
        $this->id = $this->insert('challenge_data', 'iiiii', array(null, $this->uid, $this->anonymous, $this->component, $this->time));
        $this->close();
	}



	public function checkRegistration($uid, $component) {
        $this->connect();
        $return = $this->select('challenge_data', array('id'), 'ii', array($uid, $component), 'where uid=? and component=? limit 1');
        $this->close();

		if (count($return))
			return "registered";
		else
			return "not registered";	
	}

}


?>