<?php

class Resource extends Connection {

    public $id;
    public $uid;
    public $email;
    public $image;
    public $cid;
    public $version;
    public $rid;
    public $original_id;
    public $pid;
    public $parent;
    public $type;
    public $typeID;
    public $status;
    public $insert_time;
    public $edit_time;
    public $curate_time;
    public $score;

    public $columns;
    public $dbTypes = 'iisiississisiii';

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->email = $vars['email'];
        $this->cid = $vars['cid'];
        $this->pid = $vars['pid'];
        $this->original_id = $vars['original_id'];
        $this->parent = $vars['parent'];
        $this->type = $vars['type'];
        $this->typeID = $vars['typeID'];
        $this->status = 'Pending';
        $this->insert_time = time();

        $this->version = 1;
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->email = $vars['email'];
        $this->cid = $vars['cid'];
        $this->rid = $vars['rid'];
        $this->version = $vars['version'];
        $this->original_id = $vars['original_id'];
        $this->pid = $vars['pid'];
        $this->parent = $vars['parent'];
        $this->type = $vars['type'];
        $this->typeID = $vars['typeID'];
        $this->status = $vars['status'];
        $this->insert_time = $vars['insert_time'];
        $this->edit_time = $vars['edit_time'];
        $this->curate_time = $vars['curate_time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('resources', $this->dbTypes, array(null, $this->uid, $this->email, $this->cid, $this->version, $this->rid, $this->original_id, $this->pid, $this->parent, $this->type, $this->typeID, $this->status, $this->insert_time, $this->edit_time, $this->curate_time));
        $this->rid = 'SCR_' . sprintf("%06d", $this->id);
        if (!$this->original_id) {
            $this->original_id = 'SCR_' . sprintf("%06d", $this->id);
        }
        $this->update('resources', 'ssi', array('rid', 'original_id'), array($this->rid, $this->original_id, $this->id), 'where id=?');
        $this->insert('resource_versions', 'iisiiisi', array(null, $this->uid, $this->email, $this->cid, $this->id, $this->version, 'Pending', $this->insert_time));
        $this->close();
    }

    public function getByCommunity($cid, $status, $offset, $limit) {
        $this->connect();
        $return = $this->select('resources', array('SQL_CALC_FOUND_ROWS *'), 'is', array($cid, $status), 'where cid=? and status=? order by id desc limit ' . $offset . ',' . $limit);
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $resource = new Resource();
                $resource->createFromRow($row);
                $resource->getColumns();
                $finalArray[] = $resource;
            }
        }
        return $finalArray;
    }

    public function getResourceCountByComm($cid) {
        $this->connect();
        $return = $this->select('resources', array('count(id)'), 'i', array($cid), 'where cid=?');
        $count = $return[0]['count(id)'];
        $this->close();

        return $count;
    }

    public function getByUser($uid, $offset, $limit) {
        $this->connect();
        $return = $this->select('resources', array('SQL_CALC_FOUND_ROWS *'), 'i', array($uid), 'where uid=? order by id desc limit ' . $offset . ',' . $limit);
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $resource = new Resource();
                $resource->createFromRow($row);
                $resource->getColumns();
                $finalArray['results'][] = $resource;
            }
        }
        return $finalArray;
    }

    public function getByRID($rid) {
        $this->connect();
        $return = $this->select('resources', array('*'), 's', array($rid), 'where rid=? limit 1');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getByOriginal($rid) {
        $this->connect();
        $return = $this->select('resources', array('*'), 's', array($rid), 'where original_id=? limit 1');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getByName($rid) {
        $this->connect();
        $rids = $this->select('resource_columns', array('rid'), 's', array($rid), 'where name="Resource Name" and value=? limit 1');
        if(count($rids)>0)
            $return = $this->select('resources', array('*'), 'i', array($rids[0]['rid']), 'where id=? limit 1');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function searchColumns($query, $offset, $limit, $fields, $facets, $status, $id=NULL) {
        $this->connect();
        $sum = '';
        if ($status) {
            if($id) $return = $this->select('resources', array('SQL_CALC_FOUND_ROWS id as rid'), 'ss', array($status, $id), 'where status=? and uid=? order by rid desc limit ' . $offset. ',' . $limit);
            else $return = $this->select('resources', array('SQL_CALC_FOUND_ROWS id as rid'), 's', array($status), 'where status=? order by rid desc limit ' . $offset . ',' . $limit);
        } else {
            if (count($fields) > 0) {
                $sum = "(";
                foreach ($fields as $field) {
                    $summing[] = 'IF(name="' . $field->name . '",' . $field->weight . ',0)';
                }
                $sum .= join('+', $summing) . ')';
            }
            if ($query == ''){
                if($id) $return = $this->select('resources', array('SQL_CALC_FOUND_ROWS id as rid,0 as score'), 's', array($id), 'where uid=? order by rid desc limit ' . $offset . ',' . $limit);
                else $return = $this->select('resources', array('SQL_CALC_FOUND_ROWS id as rid,0 as score'), null, array(), 'order by rid desc limit ' . $offset . ',' . $limit);
            } else {
                if (strlen($query) < 4) {
                    if($id){
                        $return = $this->select(
                            'resource_columns LEFT OUTER JOIN resources ON resource_columns.rid=resources.id',
                            Array('SQL_CALC_FOUND_ROWS resource_columns.rid, SUM(' . $sum . ') as score'),
                            'ss',
                            array($id, $query),
                            'WHERE uid=? AND value=? GROUP BY resource_columns.rid ORDER BY SCORE DESC LIMIT ' . $offset . ',' . $limit
                        );
                    }
                    else{
                        $return = $this->select(
                            'resource_columns',
                            array('SQL_CALC_FOUND_ROWS rid,SUM(' . $sum . ') as score'),
                            's',
                            array($query), 'where value=? group by rid order by score desc limit ' . $offset . ',' . $limit
                        );
                    }
                } else {
                    if($id){
                        $return = $this->select(
                            'resource_columns LEFT OUTER JOIN resources ON resource_columns.rid=resources.id',
                            array('SQL_CALC_FOUND_ROWS resource_columns.rid,SUM(MATCH(value) AGAINST(? IN BOOLEAN MODE) * ' . $sum . ') as score'),
                            'sss',
                            array($query, $id, $query),
                            'where uid=? AND MATCH(value) AGAINST(? IN BOOLEAN MODE) group by resource_columns.rid order by score desc limit ' . $offset . ',' . $limit
                        );
                    }
                    else{
                        $return = $this->select(
                            'resource_columns',
                            array('SQL_CALC_FOUND_ROWS rid,SUM(MATCH(value) AGAINST(? IN BOOLEAN MODE) * ' . $sum . ') as score'),
                            'ss',
                            array($query, $query),
                            'where MATCH(value) AGAINST(? IN BOOLEAN MODE) group by rid order by score desc limit ' . $offset . ',' . $limit
                        );
                    }
                }
            }
        }
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $field) {
                $resource = new Resource();
                $resource->getByID($field['rid']);
                $resource->getColumns();
                $resource->score = $field['score'];
                $finalArray['results'][] = $resource;
            }
        }
        return $finalArray;
    }

    public function searchByComm($cid, $query, $type, $offset, $limit) {
        $this->connect();
        if ($type)
            $return = $this->select('resources as r left join resource_columns as c on (r.id=c.rid and r.version=c.version)', array('SQL_CALC_FOUND_ROWS r.*'), 'iss', array($cid, $type, '%' . $query . '%'), 'where r.cid=? and r.type=? and c.value like ? group by r.id limit ' . $offset . ',' . $limit);
        else
            $return = $this->select('resources as r left join resource_columns as c on (r.id=c.rid and r.version=c.version)', array('SQL_CALC_FOUND_ROWS r.*'), 'is', array($cid, '%' . $query . '%'), 'where r.cid=? and c.value like ? group by r.id limit ' . $offset . ',' . $limit);
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $field) {
                $resource = new Resource();
                $resource->createFromRow($field);
                $resource->getColumns();
                $finalArray['results'][] = $resource;
            }
        }
        return $finalArray;
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('resources', array('*'), 'i', array($id), 'where id=? limit 1');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getColumns() {
        $this->connect();
        $return = $this->select('resource_columns', array('*'), 'ii', array($this->id, $this->version), 'where rid=? and version=? order by id asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $column = new Columns();
                $column->createFromRow($row);
                $this->columns[$column->name] = $column->value;
            }
        }
    }

    public function getColumns2() {
        $this->connect();
        $return = $this->select('resource_columns', array('*'), 'ii', array($this->id, $this->version), 'where rid=? and version=? order by id asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $column = new Columns();
                $column->createFromRow($row);
                $this->columns[$column->name] = array($column->value, $column->link);
            }
        }
    }

    public function getVersionColumns($version) {
        $this->connect();
        $return = $this->select('resource_columns', array('*'), 'ii', array($this->id, $version), 'where rid=? and version=? order by id asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $column = new Columns();
                $column->createFromRow($row);
                $this->columns[$column->name] = $column->value;
            }
        }
    }

    public function getVersionInfo($version) {
        $this->connect();
        $return = $this->select('resource_versions', array('*'), 'ii', array($this->id, $version), 'where rid=? and version=? order by id asc limit 1');
        $this->close();

        return $return[0];
    }

    public function getLatestVersionNum() {
        $this->connect();
        $return = $this->select('resource_versions', array('version'), 'i', array($this->id), 'where rid=? order by version desc limit 1');
        $this->close();

        if (count($return) > 0) {
            return $return[0]['version'];
        } else {
            return 0;
        }
    }

    public function getVersions() {
        $this->connect();
        $return = $this->select('resource_versions', array('*'), 'i', array($this->id), 'where rid=? order by version desc');
        $this->close();

        return $return;
    }

    public function createVersion($vars) {
        $version = $this->getLatestVersionNum() + 1;
        $this->connect();
        $this->insert('resource_versions', 'iisiiisi', array(null, $vars['uid'], $vars['email'], $vars['cid'], $this->id, $version, 'Pending', time()));
        $this->close();
    }

    public function updateVersion($version) {
        $this->connect();
        $this->version = $version;
        $this->update('resources', 'ii', array('version'), array($this->version, $this->id), 'where id=?');
        $this->close();
    }

    public function updateStatus($status) {
        $this->connect();
        $this->status = $status;
        $this->update('resources', 'si', array('status'), array($status, $this->id), 'where id=?');
        $this->update('resource_versions', 'sii', array('status'), array($status, $this->version, $this->id), 'where version=? and rid=?');
        $this->close();
    }

    public function insertColumns() {
        $vars['uid'] = $this->uid;
        $vars['rid'] = $this->id;
        $vars['version'] = $this->getLatestVersionNum();
        foreach ($this->columns as $key => $value) {
            $vars['name'] = $key;
            $vars['value'] = $value;
            $column = new Columns();
            $column->create($vars);
            $column->insertDB();
        }
    }

    public function insertColumns2() {
        $vars['uid'] = $this->uid;
        $vars['rid'] = $this->id;
        $vars['version'] = $this->getLatestVersionNum();
        foreach ($this->columns as $key => $array) {
            $vars['name'] = $key;
            $vars['value'] = $array[0];
            $vars['link'] = $array[1];
            $column = new Columns();
            $column->create($vars);
            $column->insertDB();
        }
    }

}

class Columns extends Connection {

    public $id;
    public $rid;
    public $version;
    public $name;
    public $value;
    public $link;
    public $time;

    public $dbTypes = 'iiisssi';

    public function create($vars) {
        $this->rid = $vars['rid'];
        $this->version = $vars['version'];
        $this->name = $vars['name'];
        $this->value = $vars['value'];
        $this->link = $vars['link'];
        $this->time = time();
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->rid = $vars['rid'];
        $this->version = $vars['version'];
        $this->name = $vars['name'];
        $this->value = $vars['value'];
        $this->link = $vars['link'];
        $this->time = $vars['time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('resource_columns', $this->dbTypes, array(null, $this->rid, $this->version, $this->name, $this->value, $this->link, $this->time));
        $this->close();
    }

}

class Resource_Type extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $name;
    public $description;
    public $parent;
    public $facet;
    public $url;
    public $time;

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->name = $vars['name'];
        $this->description = $vars['description'];
        $this->parent = $vars['parent'];
        $this->facet = $vars['facet'];
        $this->url = $vars['url'];
        $this->time = time();
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->name = $vars['name'];
        $this->description = $vars['description'];
        $this->parent = $vars['parent'];
        $this->facet = $vars['facet'];
        $this->url = $vars['url'];
        $this->time = $vars['time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('resource_type', 'iiississi', array(null, $this->uid, $this->cid, $this->name, $this->description, $this->parent, $this->facet, $this->url, $this->time));
        $this->close();
    }

    public function updateDB() {
        $this->connect();
        $this->update('resource_type', 'ssissi', array('name', 'description', 'parent', 'facet', 'url'), array($this->name, $this->description, $this->parent, $this->facet, $this->url, $this->id), 'where id=?');
        $this->close();
    }

    public function deleteDB() {
        $this->connect();
        $this->delete('resource_type', 'i', array($this->id), 'where id=?');
        $this->delete('community_relationships', 'i', array($this->id), 'where rid=?');
        $this->close();
    }

    public function getAllNotMade($cid) {
        $this->connect();
        $return = $this->select('resource_type', array('*'), 'i', array($cid), 'where cid != ? order by name asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $type = new Resource_Type();
                $type->createFromRow($row);
                $finalArray[] = $type;
            }
        }
        return $finalArray;
    }

    public function getAll() {
        $this->connect();
        $return = $this->select('resource_type', array('*'), null, array(), 'order by name asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $type = new Resource_Type();
                $type->createFromRow($row);
                $finalArray[] = $type;
            }
        }
        return $finalArray;
    }

    public function getByCommunity($cid) {
        $this->connect();
        $return = $this->select('resource_type', array('*'), 'i', array($cid), 'where cid=?');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $type = new Resource_Type();
                $type->createFromRow($row);
                $finalArray[] = $type;
            }
        }
        return $finalArray;
    }

    public function getByName($name, $cid) {
        $this->connect();
        $return = $this->select('resource_type', array('*'), 'is', array($cid, $name), 'where cid=? and name=? limit 1');

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        } else {
            $return = $this->select('resource_type', array('*'), 's', array($name), 'where cid=0 and name=? limit 1');
            if (count($return) > 0)
                $this->createFromRow($return[0]);
        }
        $this->close();
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('resource_type', array('*'), 'i', array($id), 'where id=? limit 1');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }


}

class Resource_Fields extends Connection {

    public $id, $uid, $tid, $cid, $required, $position;
    public $name, $type, $display, $autocomplete, $alt;
    public $login, $curator, $hidden, $weight, $time;

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->tid = $vars['tid'];
        $this->cid = $vars['cid'];
        $this->required = $vars['required'];
        $this->position = $vars['position'];
        $this->name = $vars['name'];
        $this->type = $vars['type'];
        $this->display = $vars['display'];
        $this->autocomplete = $vars['autocomplete'];
        $this->alt = $vars['alt'];
        $this->login = $vars['login'];
        $this->curator = $vars['curator'];
        $this->hidden = $vars['hidden'];
        $this->weight = 1;
        $this->time = time();
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->tid = $vars['tid'];
        $this->cid = $vars['cid'];
        $this->required = $vars['required'];
        $this->position = $vars['position'];
        $this->name = $vars['name'];
        $this->type = $vars['type'];
        $this->display = $vars['display'];
        $this->autocomplete = $vars['autocomplete'];
        $this->alt = $vars['alt'];
        $this->login = $vars['login'];
        $this->curator = $vars['curator'];
        $this->hidden = $vars['hidden'];
        $this->weight = $vars['weight'];
        $this->time = $vars['time'];
    }

    public function updateData($vars) {
        $this->required = $vars['required'];
        $this->name = $vars['name'];
        $this->type = $vars['type'];
        $this->display = $vars['display'];
        $this->autocomplete = $vars['autocomplete'];
        $this->alt = $vars['alt'];
        $this->login = $vars['login'];
        $this->curator = $vars['curator'];
        $this->hidden = $vars['hidden'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('resource_fields', 'iiiiiisssssiiiii', array(null, $this->uid, $this->tid, $this->cid, $this->required, $this->position, $this->name, $this->type, $this->display, $this->autocomplete, $this->alt, $this->login, $this->curator, $this->hidden, $this->weight, $this->time));
        $this->close();
    }

    public function updateDB() {
        $this->connect();
        $this->update('resource_fields', 'sssssiiii', array('name', 'type', 'display', 'autocomplete', 'alt', 'login', 'curator', 'hidden', 'required'), array($this->name, $this->type, $this->display, $this->autocomplete, $this->alt, $this->login, $this->curator, $this->hidden, $this->required, $this->id), 'where id=?');
        $this->close();
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('resource_fields', array('*'), 'i', array($id), 'where id=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function shiftAll($num) {
        $this->connect();
        $this->increment('resource_fields', 'iiii', array('position'), array($num, $this->cid, $this->position, $this->tid), 'where cid=? and position>? and tid=?');
        $this->close();
        $this->position++;
    }

    public function swap($direction) {
        $this->connect();
        if ($direction == 'up') {
            if ($this->position > 0) {
                $this->update('resource_fields', 'iiii', array('position'), array($this->position, $this->cid, (int)($this->position - 1), $this->tid), 'where cid=? and position=? and tid=?');
                $this->update('resource_fields', 'ii', array('position'), array((int)($this->position - 1), $this->id), 'where id=?');
            }
        } else {
            $this->update('resource_fields', 'iiii', array('position'), array($this->position, $this->cid, (int)($this->position + 1), $this->tid), 'where cid=? and position=? and tid=?');
            $this->update('resource_fields', 'ii', array('position'), array((int)($this->position + 1), $this->id), 'where id=?');
        }
        $this->close();
    }

    public function getByType($tid, $cid) {
        $this->connect();
        $return = $this->select('resource_fields', array('*'), 'ii', array($tid, $cid), 'where (tid=0 or tid=?) and (cid=? or cid=0) order by tid asc,cid asc,position asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $field = new Resource_Fields();
                $field->createFromRow($row);
                $finalArray[] = $field;
            }
        }
        return $finalArray;
    }

    public function getPage1() {
        $this->connect();
        $return = $this->select('resource_fields', array('*'), null, array(), 'where tid=0 and cid=0 order by tid asc,cid asc,position asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $field = new Resource_Fields();
                $field->createFromRow($row);
                $finalArray[] = $field;
            }
        }
        return $finalArray;
    }

    public function getPage2($cid, $tid) {
        $this->connect();
        $return = $this->select('resource_fields', array('*'), 'iii', array($cid, $tid, $tid), 'where (cid=? and tid=?) or (cid=0 and tid=?) order by tid asc,cid asc,position asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $field = new Resource_Fields();
                $field->createFromRow($row);
                $finalArray[] = $field;
            }
        }
        return $finalArray;
    }

    public function getFormHTML($value, $extra, $type, $curator) {
        if ($this->curator && !$curator)
            return '';
        if ($this->required) {
            $attrs = 'required="required"';
            $req = '<span style="color:#bb0000">*</span>';
            $class = ' required';
        } else {
            $attrs = '';
            $req = '';
            $class = '';
        }
        switch ($this->type) {
            case 'text':
                if ($this->name == 'Resource Name')
                    $html = '<section><label class="label">' . $type->name . ' Name ' . $req . '</label>';
                else
                    $html = '<section><label class="label">' . $this->name . ' ' . $req . '</label>';
                $html .= '<label class="input">
                                <i class="icon-append fa fa-question-circle"></i>';


                if ($extra)
                    $html .= '<input ' . $extra . ' type="text" class="review-' . str_replace(' ', '_', $this->name) . $class . '" placeholder="Focus to view the tooltip" ' . $attrs . '>';
                elseif ($this->autocomplete) {
                    $html .= '<input type="text" class="resource-field field-autocomplete ' . str_replace(' ', '_', $this->name) . $class . '" category="' . $this->autocomplete . '" name="' . str_replace(' ', '_', $this->name) . '" placeholder="Focus to view the tooltip" value="' . $value . '" ' . $attrs . '>';
                    $html .= '<input type="hidden" class="autoValues" name="' . str_replace(' ', '_', $this->name) . '-val"/>';
                    $html .= '<div class="autocomplete_append auto" style="z-index:10"></div>';
                } else
                    $html .= '<input type="text" class="resource-field ' . str_replace(' ', '_', $this->name) . $class . '" name="' . str_replace(' ', '_', $this->name) . '" placeholder="Focus to view the tooltip" value="' . $value . '" ' . $attrs . '>';
                $html .= '<b class="tooltip tooltip-top-right">' . $this->alt . '</b>
                            </label>
                        </section>';
                return $html;
                break;
            case 'image':
                return '<section>
                            <label class="label">' . $this->name . '</label>
                            <label for="file" class="input input-file">
                                <div class="button"><input onchange="$(this).parent().next().val($(this).val());" name="' . $this->id . '-image" type="file" id="file"
                                                           class="file-form">Browse
                                </div>
                                <input type="text" class="file-placeholder" readonly value="' . $value . '">
                            </label>
                        </section>';
                break;
            case 'textarea':
                $html = '<section>';
                $html .= '<label class="label">' . $this->name . ' ' . $req . '</label>';
                $html .= '<label class="textarea">
                                            <i class="icon-append fa fa-question-circle"></i>';
                if ($extra)
                    $html .= '<textarea ' . $extra . ' rows="3" class="review-' . str_replace(' ', '_', $this->name) . $class . '" placeholder="Focus to view the tooltip" ' . $attrs . '></textarea>';
                else
                    $html .= '<textarea class="resource-field ' . str_replace(' ', '_', $this->name) . $class . '" rows="3" name="' . str_replace(' ', '_', $this->name) . '" placeholder="Focus to view the tooltip" ' . $attrs . '>' . $value . '</textarea>';
                $html .= '<b class="tooltip tooltip-top-right">' . $this->alt . '</b>
                                        </label>
                        </section>';
                return $html;
                break;
        }
    }

}

class Form_Relationship extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $rid;
    public $type;
    public $query;
    public $time;

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->rid = $vars['rid'];
        $this->type = $vars['type'];
        $this->query = $vars['query'];
        $this->time = time();
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->rid = $vars['rid'];
        $this->type = $vars['type'];
        $this->query = $vars['query'];
        $this->time = $vars['time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('community_relationships', 'iiiissi', array(null, $this->uid, $this->cid, $this->rid, $this->type, $this->query, $this->time));
        $this->close();
    }

    public function deleteDB() {
        $this->connect();
        $this->delete('community_relationships', 'i', array($this->id), 'where id=?');
        $this->close();
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('community_relationships', array('*'), 'i', array($id), 'where id=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getByRID($cid, $rid) {
        $this->connect();
        $return = $this->select('community_relationships', array('*'), 'ii', array($cid, $rid), 'where cid=? and rid=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getByCommunity($cid, $type) {
        $this->connect();
        $return = $this->select('community_relationships', array('*'), 'is', array($cid, $type), 'where cid=? and type=?');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $relationship = new Form_Relationship();
                $relationship->createFromRow($row);
                $finalArray[] = $relationship;
            }
        }
        return $finalArray;
    }

}

?>
