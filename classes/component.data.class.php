<?php

class Component_Data extends Connection {

    public $id;
    public $uid;
    public $cid;
    public $component;
    public $position;
    public $image;
    public $title;
    public $icon;
    public $description;
    public $content;
    public $link;
    public $color;
    public $disabled;
    public $views;
    public $start;
    public $end;
    public $time;

    public $tags;

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

    public function createFromRow($vars) {
        $this->id = $vars['id'];
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
        $this->views = $vars['views'];
        $this->start = $vars['start'];
        $this->end = $vars['end'];
        $this->disabled = $vars['disabled'];
        $this->time = $vars['time'];
    }

    public function updateData($vars) {
        $this->image = $vars['image'];
        $this->title = $vars['title'];
        $this->icon = $vars['icon'];
        $this->description = $vars['description'];
        $this->content = $vars['content'];
        $this->link = $vars['link'];
        $this->color = $vars['color'];
		$this->start = $vars['start'];
        $this->end = $vars['end'];
    }

    public function getTitle() {
        return $this->title;
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('component_data', 'iiiiisssssssiiiii', array(null, $this->uid, $this->cid, $this->component, $this->position, $this->image, $this->title, $this->icon, $this->description, $this->content, $this->link, $this->color, $this->disabled, $this->views, $this->start, $this->end, $this->time));
        $this->close();
    }

    public function updateDB() {
        $this->connect();
        $this->update('component_data', 'sssssssiiii', array('image', 'title', 'icon', 'description', 'content', 'link', 'color', 'start', 'end', 'disabled'), array($this->image, $this->title, $this->icon, $this->description, $this->content, $this->link, $this->color, $this->start, $this->end, $this->disabled, $this->id), 'where id=?');
        $this->close();
    }

    public function shiftAll($pos, $cid, $num, $comp) {
        $this->connect();
        $this->increment('component_data', 'iiii', array('position'), array($num, $cid, $pos, $comp), 'where cid=? and position>? and component=?');
        $this->close();
    }

    public function getCountByComm($cid) {
        $this->connect();
        $return = $this->select('component_data', array('count(id)'), 'i', array($cid), 'where cid=?');
        $count = $return[0]['count(id)'];
        $this->close();

        return $count;
    }

    public function swap($direction) {
        $this->connect();
        if ($direction == 'up') {
            if ($this->position > 0) {
                $this->update('component_data', 'iiii', array('position'), array($this->position, $this->cid, (int)($this->position - 1), $this->component), 'where cid=? and position=? and component=?');
                $this->update('component_data', 'ii', array('position'), array((int)($this->position - 1), $this->id), 'where id=?');
            }
        } else {
            $this->update('component_data', 'iiii', array('position'), array($this->position, $this->cid, (int)($this->position + 1), $this->component), 'where cid=? and position=? and component=?');
            $this->update('component_data', 'ii', array('position'), array((int)($this->position + 1), $this->id), 'where id=?');
        }
        $this->close();
    }

    public function removeDB() {
        $this->connect();
        $this->delete('component_data', 'i', array($this->id), 'where id=?');
        $this->delete('component_tags', 'i', array($this->id), 'where data_id=?');
        $this->close();
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('component_data', array('*'), 'i', array($id), 'where id=?');
        $this->close();


        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function addView() {
        $this->connect();
        $this->views++;
        $this->update('component_data', 'ii', array('views'), array($this->views, $this->id), 'where id=?');
        $this->close();
    }

    public function getByPopularity($component, $cid, $offset, $limit, $null) {
        $this->connect();
        if ($null)
            $return = $this->select('component_data', array('*'), 'ii', array($component, $cid), 'where component=? and cid=? and description is not null order by views desc limit ' . $offset . ',' . $limit);
        else
            $return = $this->select('component_data', array('*'), 'ii', array($component, $cid), 'where component=? and cid=? order by views desc limit ' . $offset . ',' . $limit);
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray[] = $data;
            }
        }
        return $finalArray;
    }

    public function getByLink($cid, $type) {
        $this->connect();
        $return = $this->select('component_data', array('*'), 'is', array($cid, $type), 'where cid=? and link=?');
        $this->close();

		if (count($return) > 0) {
			foreach ($return as $row) {
				$data = new Component_Data();
				$data->createFromRow($row);
				$finalArray[] = $data;
			}
		}
		return $finalArray;
	}

    public function getByComponent($component, $cid, $offset, $limit) {
        $this->connect();
        $return = $this->select('component_data', array('*'), 'ii', array($component, $cid), 'where component=? and cid=? order by position asc limit ' . $offset . ',' . $limit);
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray[] = $data;
            }
        }
        return $finalArray;
    }

    public function getDataByComms($cids) {
        $type = '';
        foreach($cids as $cid){
            $type .= 'i';
            $where[] = 'cid=?';
            $params[] = $cid;
        }
        $this->connect();
        $return = $this->select('component_data', array('*'), $type, $params, 'where '.join(' or ',$where).' order by id desc limit 20');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray[] = $data;
            }
        }
        return $finalArray;
    }

    public function getByComponentNewest($component, $cid, $offset, $limit) {
        $this->connect();
        if(!isset($offset) || !isset($limit)){
            $return = $this->select('component_data', array('*'), 'ii', array($component, $cid), 'where component=? and cid=? order by id desc');
        }else{
            $return = $this->select('component_data', array('*'), 'ii', array($component, $cid), 'where component=? and cid=? order by id desc limit ' . $offset . ',' . $limit);
        }
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray[] = $data;
            }
        }
        return $finalArray;
    }

    public function getCount($component, $cid) {
        $this->connect();
        $return = $this->select('component_data', array('count(*)'), 'ii', array($component, $cid), 'where component=? and cid=?');
        $this->close();

        if (count($return) > 0) {
            return $return[0]['count(*)'];
        }
        return false;
    }

    public function formObjects($type, $column, $label, $tooltip) {
        switch ($type) {
            case 'image':
                return '<section>
                            <label class="label">' . $label . '</label>
                            <label for="file" class="input input-file">
                                <div class="button"><input onchange="$(this).parent().next().val($(this).val());" name="' . $this->id . '-'.$column.'" type="file" id="file"
                                                           class="file-form">Browse
                                </div>
                                <input type="text" class="file-placeholder" readonly value="' . $this->image . '">
                            </label>
                        </section>';
                break;
            case 'text':
                return '<section>
                            <label class="label">' . $label . '</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="' . $this->id . '-' . $column . '" placeholder="Focus to view the tooltip" value="' . $this->$column . '">
                                <b class="tooltip tooltip-top-right">' . $tooltip . '</b>
                            </label>
                        </section>';
                break;
            case 'date':
                $html = '<section>
                            <label class="label">' . $label . '</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>';
                if($this->$column>0)
                     $html .= '<input type="text" class="date" name="' . $this->id . '-' . $column . '" value="' . date('H:i m/d/Y',$this->$column) . '">';
                else
                    $html .= '<input type="text" class="date" name="' . $this->id . '-' . $column . '">';
                $html .= '<b class="tooltip tooltip-top-right">' . $tooltip . '</b>
                            </label>
                        </section>';
                return $html;
                break;
            case 'color':
                return '<section>
                            <label class="label">' . $label . '</label>
                            <label class="input">
                                <i class="icon-prepend fa fa-circle" style="color:#' . $this->$column . '"></i>
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text" name="' . $this->id . '-' . $column . '" class="color-input" placeholder="Focus to view the tooltip" value="' . $this->$column . '">
                                <b class="tooltip tooltip-top-right">' . $tooltip . '</b>
                            </label>
                        </section>';
                break;
            case 'icon':
                if (!$this->$column)
                    $this->$column = 'fa fa-bars';
                $html = '<section>
                            <label class="label">' . $label . '</label>
                            <label class="input"><input type="hidden" class="' . $this->id . '-' . $column . '" name="' . $this->id . '-' . $column . '" value="' . $this->$column . '"/><div class="btn-group">
                            <button class="' . $this->id . '-' . $column . '-btn" data-toggle="dropdown"
                                    class="btn-u btn-u-default btn-u-split-default dropdown-toggle"
                                    type="button">
                                <i class="' . $this->$column . '"></i> ' . $this->$column . '
                            </button>
                            <ul role="menu" class="dropdown-menu icon-dropdown" name="' . $this->id . '-' . $column . '">';
                $component = new Component();
                foreach ($component->icons as $icon) {
                    $html .= '<li icon="fa ' . $icon . '"><a href="javascript:void(0);"><i class="fa ' . $icon . '"></i> ' . $icon . '</a></li>';
                }
                $html .= '</ul>
                        </div></label></section>';
                return $html;
                break;
            case 'template':
                return '<section>
                            <label class="label">Template</label>
                            <img class="img-responsive" src="/images/components/component-' . $this->component . '.jpg"
                                 style="border: 1px solid #888"/>
                        </section>';
                break;
            case 'textarea':
                return '<section>
                            <label class="label">' . $label . '</label>
                            <textarea rows="3" placeholder="Focus to view the tooltip" class="summer-text" name="' . $this->id . '-' . $column . '">' . htmlspecialchars($this->$column) . '</textarea>
                        </section>';
                break;
            case 'position':
                $html = '<section>';
                $html .= '<label class="label">' . $label . '</label>';
                $html .= '<label class="select"><i class="icon-append fa fa-question-circle"></i>';
                $html .= '<select name="' . $this->id . '-position">';
                $html .= '<option value="-1">Before ' . $column[0]->getTitle() . '</option>';
                foreach ($column as $component) {
                    $html .= '<option value="' . $component->position . '">After ' . $component->getTitle() . '</option>';
                }
                $html .= '</select></label></section>';
                return $html;
                break;
            case 'type':
                $html = '<section>';
                $html .= '<label class="label">' . $label . '</label>';
                $html .= '<label class="select"><i class="icon-append fa fa-question-circle"></i>';
                $html .= '<select name="' . $this->id . '-tagger">';
                $html .= '<option value="Data Sources">Data Sources</option>';
                $html .= '<option value="Community Help">Community Help</option>';
                if($tooltip=='question')
                    $html .= '<option value="Technical Support">Technical Support</option>';
                else
                    $html .= '<option value="My Account">My Account</option>';
                $html .= '</select></label></section>';
                return $html;
                break;
        }
    }

    public function getPanelHeader() {
        $html = '<div class="panel panel-dark">
                            <div class="panel-heading" style="border-bottom: 0">';
        if ($this->id)
            $html .= '<h3 class="panel-title" style="display: inline-block;cursor:pointer"><i class="clickable-icon fa fa-plus"></i> Edit Data </h3>';
        else
            $html .= '<h3 class="panel-title" style="display: inline-block;cursor:pointer"><i class="clickable-icon fa fa-plus"></i> Add New Data</h3>';
        $html .= '</label>
                            </div>
                            <div class="panel-body">';

        return $html;
    }

    public function getDataForm($data) {
        switch ($this->component) {
            case 10: //Parralax Slider
                $html = $this->getPanelHeader();
                $html .= '<fieldset>';
                if ($data && count($data) > 0) {
                    $html .= $this->formObjects('position', $data, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for this slide');
                $html .= $this->formObjects('text', 'description', 'Description', 'The description for the slide');
                $html .= $this->formObjects('image', 'image', 'Slide Image', 'The PNG shown to the right');
                $html .= $this->formObjects('text', 'link', 'URL', 'Where the article links to');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 13: //Parralax Slider
                $html = $this->getPanelHeader();
                $html .= '<fieldset>';
                if ($data && count($data) > 0) {
                    $html .= $this->formObjects('position', $data, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for this slide');
                $html .= $this->formObjects('text', 'description', 'Description', 'The description for the slide');
                $html .= $this->formObjects('image', 'image', 'Slide Image', 'The Background Image for this slide');
                $html .= $this->formObjects('color', 'color', 'Text Color', 'The color of the Slide text');
                $html .= $this->formObjects('text', 'link', 'URL', 'Where the article links to');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 22: //News Thumbnails',
                $html = $this->getPanelHeader();
                $html .= '<fieldset>';
                if ($data && count($data) > 0) {
                    $html .= $this->formObjects('position', $data, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for this section');
                $html .= $this->formObjects('image', 'image', 'News Image', 'The thumbnail for the article');
                $html .= $this->formObjects('text', 'link', 'URL', 'Where the article links to');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 30: //Categories Block',
                $html = $this->getPanelHeader();
                $html .= '<fieldset>';
                if ($data && count($data) > 0) {
                    $html .= $this->formObjects('position', $data, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for this section');
                $html .= $this->formObjects('text', 'description', 'Description', 'The description for this section');
                $html .= $this->formObjects('icon', 'icon', 'Category Icon', 'The icon for this category');
                $html .= $this->formObjects('text', 'link', 'URL', 'Where the article links to');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 33: //Works Thumbnails',
                $html = $this->getPanelHeader();
                $html .= '<fieldset>';
                if ($data && count($data) > 0) {
                    $html .= $this->formObjects('position', $data, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for this section');
                $html .= $this->formObjects('text', 'description', 'Description', 'The description for this section');
                $html .= $this->formObjects('image', 'image', 'News Image', 'The thumbnail for the article');
                $html .= $this->formObjects('text', 'link', 'URL', 'Where the article links to');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 35: //Dynamic Services,
                $html = $this->getPanelHeader();
                $html .= '<fieldset>';
                if ($data && count($data) > 0) {
                    $html .= $this->formObjects('position', $data, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for this section');
                $html .= $this->formObjects('text', 'description', 'Description', 'The description for this section');
                $html .= $this->formObjects('icon', 'icon', 'Section Icon', 'The icon for this section');
                $html .= $this->formObjects('text', 'link', 'URL', 'Where the section links to');
                $html .= $this->formObjects('color', 'color', 'Text Color', 'The color of the text and icon');
                $html .= $this->formObjects('color', 'image', 'Background Color', 'The color of the box background');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
        }
        return $html;
    }

    public function getContainerDataForm($type,$tags,$columns) {
        $this->tags = $tags;
        $html = '';
        switch ($type) {
            case 'timeline1': //Parralax Slider
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the article is about');
                $html .= $this->formObjects('textarea', 'content', 'Content', 'The full content of this article');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;
            case 'timeline2': //News Thumbnails',
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the article is about');
                $html .= $this->formObjects('textarea', 'content', 'Content', 'The full content of this article');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;
            case 'event1': //News Thumbnails',
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the article is about');
                $html .= $this->formObjects('date', 'start', 'Start Date', 'The time and date that this event starts');
                $html .= $this->formObjects('date', 'end', 'End Date', 'The time and date that this event ends');
                $html .= $this->formObjects('text', 'link', 'URL to Event', 'A url that points to the event in question.');
                $html .= $this->formObjects('text', 'content', 'Label:Value Field 1', 'Optional/Additional field that must be provided in Label:Value format');
                $html .= $this->formObjects('text', 'icon', 'Label:Value Field 2', 'Optional/Additional field that must be provided in Label:Value format');
                $html .= $this->formObjects('text', 'color', 'Label:Value Field 3', 'Optional/Additional field that must be provided in Label:Value format');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;
            case 'blog1': //News Thumbnails',
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the article is about');
                $html .= $this->formObjects('textarea', 'content', 'Content', 'The full content of this article');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;
            case 'gallery1': //News Thumbnails',
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the file');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the file');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the file contains');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= $this->formObjects('image', 'file', 'File', 'The file to download');
                $html .= '</fieldset>';
                break;
            case 'slideshow1': //News Thumbnails',
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the presentation');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the presentation');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the presentation is about');
                $html .= $this->formObjects('text', 'image', 'IFrame URL', 'The URL given in the IFrame code provided by Slide Share');
                $html .= '</fieldset>';
                break;
            case 'files1': //Works Thumbnails',
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the object');
                $html .= $this->formObjects('text', 'description', 'Description', 'The description of what it is for');
                $html .= $this->formObjects('text', 'color', 'View', 'The view to display');
                $html .= $this->formObjects('text', 'icon', 'Custom Column Data', 'The data, in comma separated list, to display in custom columns');
                $html .= $this->formObjects('text', 'link', 'URL', 'Where to download/get if external');
                $html .= '</fieldset>';
                break;
            case 'question':
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Question', 'The question asked');
                $html .= $this->formObjects('type', 'title', 'Question Type', 'question');
                $html .= $this->formObjects('textarea', 'description', 'Answer', 'The answer');
                $html .= '</fieldset>';
                break;
            case 'tutorial':
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('type', 'title', 'Tutorial Type', 'tutorial');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Where the article links to');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the article is about');
                $html .= $this->formObjects('textarea', 'content', 'Content', 'The full content of this article');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;
            case 'table1':
                $html .= '<fieldset>';
                $dbLabels = array('image','title','icon','description','content','link','color');
                foreach($columns as $i=>$array) {
                    $html .= $this->formObjects($array['type'], $dbLabels[$i], $array['label'], 'The value for this column');
                }
                $html .= '</fieldset>';
                break;

			case 'static':
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what the article is about');
                $html .= $this->formObjects('textarea', 'content', 'Content', 'The full content of this article');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;
			
            case 'series1': // assuming for now that it's closest to an "event",
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'Short text describing the challenge');
                $html .= $this->formObjects('date', 'start', 'Start Date', 'The time and date that this challenge starts');
                $html .= $this->formObjects('date', 'end', 'End Date', 'The time and date that this challenge ends');
                $html .= $this->formObjects('text', 'link', 'URL of Challenge', 'A url that points to the challenge in question.');
                $html .= $this->formObjects('textarea', 'content', 'Content', 'Full text describing the challenge');
                $html .= $this->formObjects('text', 'icon', 'visiblity:Value', 'Should this challenge be visible to the public yet?');
                $html .= $this->formObjects('text', 'color', 'rules:URL', 'If there is a rules page, give the URL');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;

           case 'challenge1': // assuming for now that it's closest to an "event",
                $html .= '<fieldset>';
                $html .= $this->formObjects('text', 'title', 'Title', 'The title for the Article');
                $html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
                $html .= $this->formObjects('textarea', 'description', 'Description', 'Short text describing the challenge');
                $html .= $this->formObjects('date', 'start', 'Start Date', 'The time and date that this challenge starts');
                $html .= $this->formObjects('date', 'end', 'End Date', 'The time and date that this challenge ends');
                $html .= $this->formObjects('text', 'link', 'URL of Challenge', 'A url that points to the challenge in question.');
                $html .= $this->formObjects('textarea', 'content', 'Content', 'Full text describing the challenge');
                $html .= $this->formObjects('text', 'icon', 'visiblity:Value', 'Should this challenge be visible to the public yet?');
                $html .= $this->formObjects('text', 'color', 'rules:URL', 'If there is a rules page, give the URL');
                $html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
                $html .= '</fieldset>';
                break;

        }
        return $html;
    }

    public function wipeTags() {
        $this->connect();
        $this->delete('component_tags', 'i', array($this->id), 'where data_id=?');
        $this->close();
    }

    public function insertTags($array) {
        foreach ($array as $text) {
            $tag = new Tag();
            $tag->create(array(
                'data_id' => $this->id,
                'cid' => $this->cid,
                'component' => $this->component,
                'tag' => trim($text)
            ));
            $tag->insertDB();
        }
    }

    public function getTags() {
        $this->connect();
        $return = $this->select('component_tags', array('*'), 'i', array($this->id), 'where data_id=?');
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

    public function searchAllFromComm($query, $cid, $offset, $limit) {
        $case = "IF(data.title LIKE ?,  20, IF(data.title LIKE ?, 10, 0)) +
                          IF(data.description LIKE ?, 15,  0) +
                          IF(data.content   LIKE ?, 5,  0) +
                          IF(tags.tag_list LIKE ?, 15, 0)  AS weight";
        $this->connect();
        $return = $this->select('component_data as data left join (select data_id,group_concat(tag) as tag_list from component_tags group by data_id) as tags on tags.data_id=data.id', array('SQL_CALC_FOUND_ROWS *', $case), 'sssssssssi', array($query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', $cid), "where (data.title LIKE ? OR
                             data.description LIKE ? OR
                             data.content  LIKE ? OR tags.tag_list like ?) and data.component>101 and data.cid=?
                             order by weight desc, id desc limit $offset,$limit");
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray['results'][] = $data;
            }
        }

        return $finalArray;
    }

    public function orderTime($component,$cid){
        $time = time();
        $case = "IF(data.start < ? and data.end > ?,  20 , 0) +
                 IF(data.start > ?, 10,  0) +
                 IF(data.end > ?, 15,  0)  AS weight";
        $this->connect();
        $return = $this->select('component_data as data', array('*', $case), 'iiiiii', array($time,$time,$time,$time,$component,$cid), "where data.component=? and data.cid=?
                             order by weight desc, end asc, start asc");
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray[] = $data;
            }
        }

        return $finalArray;
    }

    public function searchData($query, $cid, $component, $offset, $limit) {
        $case = "IF(data.title LIKE ?,  20, IF(data.title LIKE ?, 10, 0)) +
                          IF(data.description LIKE ?, 15,  0) +
                          IF(data.content   LIKE ?, 5,  0) +
                          IF(tags.tag_list LIKE ?, 15, 0)  AS weight";
        $this->connect();
        $return = $this->select('component_data as data left join (select data_id,group_concat(tag) as tag_list from component_tags group by data_id) as tags on tags.data_id=data.id', array('SQL_CALC_FOUND_ROWS *', $case), 'sssssssssii', array($query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', $component, $cid), "where (data.title LIKE ? OR
                             data.description LIKE ? OR
                             data.content  LIKE ? OR tags.tag_list like ?) and data.component=? and data.cid=?
                             order by weight desc, id desc limit $offset,$limit");
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray['results'][] = $data;
            }
        }

        return $finalArray;
    }

    public function tagSearch($tag, $cid, $component, $offset, $limit) {
        //print_r($tag);
        $this->connect();
        if ($component)
            $return = $this->select('component_data as data left join component_tags as tags on tags.data_id=data.id', array('SQL_CALC_FOUND_ROWS data.*'), 'sii', array($tag, $component, $cid), 'where tags.tag=? and data.component=? and data.cid=? order by id desc limit ' . $offset . ',' . $limit);
        else
            $return = $this->select('component_data as data left join component_tags as tags on tags.data_id=data.id', array('SQL_CALC_FOUND_ROWS data.*'), 'si', array($tag, $cid), 'where tags.tag=? and data.cid=? order by id desc limit ' . $offset . ',' . $limit);
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $data = new Component_Data();
                $data->createFromRow($row);
                $finalArray['results'][] = $data;
            }
        }
        return $finalArray;
    }

    public function dropdown($base,$type) {

        $html = '<div class="btn-group pull-right" style="margin-top:-4px;">
                                        <button type="button" class="btn-u btn-u-default btn-default dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
        if($type=='files1'){
            $html .= '<li><a href="'.$base.'/component/files/'.$this->id.'"><i class="fa fa-file-code-o"></i> File Manager</a></li>';
        }
        $html .= '<li><a href="' . $base . '/component/update/' . $this->id . '"><i class="fa fa-wrench"></i> Edit Article</a></li>';
        $html .= '<li><a href="/forms/component-forms/body-data-delete.php?cid=' . $this->cid . '&component=' . $this->id . '"><i class="fa fa-times"></i> Delete</a></li>
                                        </ul>
                                    </div>';
        return $html;
    }
}

?>
