<?php

class Notification extends Connection {

    public $id;
    public $sender;
    public $receiver;
    public $view;
    public $cid;
    public $type;
    public $content;
    public $seen;
    public $timed;
    public $start;
    public $end;
    public $time;

    public $icons = array(
        'update-header-components' => 'icon-bg-yellow fa fa-cogs',
        'update-footer-components' => 'icon-bg-yellow fa fa-cogs',
        'add-body-data' => 'icon-bg-yellow fa fa-plus',
        'edit-body-data' => 'icon-bg-yellow fa fa-pencil-square-o',
        'shift-body-data' => 'icon-bg-yellow fa fa-arrows-v',
        'delete-body-data' => 'icon-bg-yellow fa fa-times',
        'add-scicrunch-question' => 'icon-bg-yellow fa fa-plus',

        'edit-scicrunch-page' => 'icon-bg-red fa fa-pencil-square-o',
        'add-scicrunch-page' => 'icon-bg-red fa fa-file-word-o',
        'update-container-component' => 'icon-bg-red fa fa-pencil-square-o',
        'add-container-component' => 'icon-bg-red fa fa-plus',
        'add-container-content' => 'icon-bg-red fa fa-plus',
        'add-extended-data' => 'icon-bg-red fa fa-plus',

        'pending-questions' => 'icon-bg-orange fa fa-gavel',
        'community-create' => 'icon-bg-orange fa fa-plus',
        'user-add' => 'icon-bg-orange fa fa-user',
        'user-edit' => 'icon-bg-orange fa fa-user',
        'edited-in-scicrunch' => 'icon-bg-orange fa fa-group',
        'added-to-community' => 'icon-bg-orange fa fa-plus',
        'removed-from-community' => 'icon-bg-orange fa fa-times',

        'create-collection' => 'icon-bg-green fa fa-folder-open-o',
        'delete-collection' => 'icon-bg-green fa fa-trash-o',
        'save-search' => 'icon-bg-green fa fa-floppy-o',
        'edit-search' => 'icon-bg-green fa fa-pencil-square-o',
        'delete-search' => 'icon-bg-green fa fa-times',

        'add-scicrunch-content' => 'icon-bg-blue fa fa-plus',
        'update-scicrunch-content' => 'icon-bg-blue fa fa-pencil-square-o',
        'add-community-content' => 'icon-bg-blue fa fa-plus',
        'update-community-content' => 'icon-bg-blue fa fa-pencil-square-o',
        'add-scicrunch-data' => 'icon-bg-blue fa fa-plus',
        'update-scicrunch-data' => 'icon-bg-blue fa fa-pencil-square-o',
        'add-community-data' => 'icon-bg-blue fa fa-plus',
        'update-community-data' => 'icon-bg-blue fa fa-pencil-square-o',

        'resource-submit' => 'icon-bg-purple fa fa-plus',
        'resource-edit' => 'icon-bg-purple fa fa-pencil-square-o',
        'type-add' => 'icon-bg-purple fa fa-plus',
        'add-type-rel' => 'icon-bg-purple fa fa-plus',
        'type-edit' => 'icon-bg-purple fa fa-pencil-square-o',
        'type-delete' => 'icon-bg-purple fa fa-times',
        'relationship-delete' => 'icon-bg-purple fa fa-times',
        'field-add' => 'icon-bg-purple fa fa-plus',
        'field-shift' => 'icon-bg-purple fa fa-arrows-v',
        'field-edit' => 'icon-bg-purple fa fa-pencil-square-o',
        'field-delete' => 'icon-bg-purple fa fa-times',
    );

    public function create($vars){
        $this->sender = $vars['sender'];
        $this->receiver = $vars['receiver'];
        $this->view = $vars['view'];
        $this->cid = $vars['cid'];
        $this->type = $vars['type'];
        $this->content = $vars['content'];
        $this->seen = 0;
        $this->timed = $vars['timed'];
        $this->start = $vars['start'];
        $this->end = $vars['end'];
        $this->time = time();
    }

    public function createFromRow($vars){
        $this->id = $vars['id'];
        $this->sender = $vars['sender'];
        $this->receiver = $vars['receiver'];
        $this->view = $vars['view'];
        $this->cid = $vars['cid'];
        $this->type = $vars['type'];
        $this->content = $vars['content'];
        $this->seen = $vars['seen'];
        $this->timed = $vars['timed'];
        $this->start = $vars['start'];
        $this->end = $vars['end'];
        $this->time = $vars['time'];
    }

    public function insertDB(){
        $this->connect();
        $this->id = $this->insert('notifications','iiiiissiiiii',array(null,$this->sender,$this->receiver,$this->view,$this->cid,$this->type,$this->content,$this->seen,$this->timed,$this->start,$this->end,$this->time));
        $this->close();
    }

    public function checkNotifications($uid,$cid){
        $this->connect();
        $return = $this->select('notifications',array('*'),'ii',array($uid,$cid),'where receiver=? and seen=0 and (view=? or view=0)');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $note = new Notification();
                $note->createFromRow($row);
                $finalArray[] = $note;
            }
        }
        return $finalArray;
    }

    public function getRecentNotificationsByUser($uid){
        $this->connect();
        $return = $this->select('notifications',array('*'),'i',array($uid),'where receiver=? order by id desc limit 10');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $notification = new Notification();
                $notification->createFromRow($row);
                $finalArray[] = $notification;
            }
        }
        return $finalArray;
    }

    public function HTML(){
        $html = '<div class="alert alert-success fade in notification-alert" style="border:1px solid #666;padding:20px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4>Notification</h4>
                            <p>'.$this->content.'</p>
                        </div>';
        return $html;
    }

    public function setSeen(){
        $this->connect();
        $this->update('notifications','ii',array('seen'),array(1,$this->id),'where id=?');
        $this->close();
    }

    public function getNotificationCount($uid,$time){
        $this->connect();
        $return = $this->select('notifications',array('count(*)'),'ii',array($uid,$time),'where receiver=? and time>?');
        $this->close();

        return $return[0]['count(*)'];
    }

    public function getNotificationsByComms($cids){
        $type = '';
        foreach($cids as $cid){
            $type .= 'i';
            $where[] = 'cid=?';
            $params[] = $cid;
        }
        $this->connect();
        $return = $this->select('notifications',array('*'),$type,$params,'where ('.join(' or ',$where).') order by id desc limit 20');
        $this->close();

        if(count($return)>0){
            foreach($return as $row){
                $noti = new Notification();
                $noti->createFromRow($row);
                $finalArray[] = $noti;
            }
        }
        return $finalArray;
    }

}

?>