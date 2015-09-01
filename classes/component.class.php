<?php

class Component extends Connection {

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
    
    public $visibility;
    public $rules;
	public $start;
	public $end;
    
    public $icons = array(
        'fa-adjust', 'fa-arrows-h', 'fa-ban', 'fa-bars', 'fa-bolt', 'fa-bookmark-o', 'fa-building-o',
        'fa-calendar', 'fa-caret-square-o-up', 'fa-check-circle-o', 'fa-circle', 'fa-clock-o', 'fa-code','fa-comments',
        'fa-check-circle','fa-crop','fa-cloud-upload','fa-dot-circle-o','fa-ellipsis-v','fa-arrows','fa-terminal',
        'fa-wrench','fa-user','fa-unlock','fa-signal','fa-star','fa-plus-circle','fa-male','fa-rss','fa-inbox',
        'fa-square-o','fa-share-square-o','fa-search-minus','fa-search-plus','fa-share-alt','fa-question','fa-bars',
        'fa-cogs', 'fa-comments-o', 'fa-crosshairs', 'fa-tachometer', 'fa-envelope', 'fa-exchange', 'fa-external-link',
        'fa-fax', 'fa-fire-extinguisher', 'fa-folder-open', 'fa-gavel', 'fa-glass', 'fa-hdd-o', 'fa-history', 'fa-info',
        'fa-keyboard-o', 'fa-location-arrow', 'fa-share', 'fa-map-marker', 'fa-minus', 'fa-mobile', 'fa-paper-plane-o',
        'fa-pencil-square-o', 'fa-picture-o', 'fa-plus-square', 'fa-puzzle-piece', 'fa-quote-left', 'fa-refresh',
        'fa-retweet', 'fa-rss-square', 'fa-paper-plane', 'fa-share-alt-square', 'fa-shopping-cart', 'fa-sort-alpha-asc',
        'fa-sort-asc', 'fa-sort-numeric-desc', 'fa-star-half', 'fa-star-o', 'fa-tablet', 'fa-tasks', 'fa-thumbs-down',
        'fa-ticket', 'fa-tint', 'fa-caret-square-o-up', 'fa-truck', 'fa-unlock-alt', 'fa-users', 'fa-volume-up', 'fa-anchor',
        'fa-arrows-v', 'fa-beer', 'fa-briefcase', 'fa-bullhorn', 'fa-calendar-o', 'fa-caret-square-o-down', 'fa-certificate',
        'fa-check-square', 'fa-circle-o', 'fa-cloud', 'fa-code-fork', 'fa-comment', 'fa-compass', 'fa-database', 'fa-exclamation',
        'fa-external-link-square','fa-female','fa-film','fa-flag','fa-flask','fa-folder-open-o','fa-cog','fa-globe',
        'fa-headphones','fa-home','fa-info-circle','fa-lock','fa-reply','fa-meh-o','fa-minus-circle','fa-mobile','fa-music',
        'fa-phone','fa-plane','fa-plus-square-o','fa-qrcode','fa-sort-alpha-desc','fa-sort-desc','fa-sort-asc','fa-square',
        'fa-star-half-o','fa-suitcase','fa-times','fa-caret-square-o-down','fa-trash-o','fa-umbrella','fa-sort',
        'fa-exclamation-triangle','fa-archive','fa-asterisk'
    );

    public $component_ids = array(
        0 => 'Header Condensed',
        1 => 'Header Boxed',
        2 => 'Header Float',
        10 => 'Parralax Slider',
        11 => 'Parralax Counter',
        12 => 'Search Banner',
        13 => 'Image Slider',
        14 => 'Dark Parralax Counter',
        21 => 'Goto Block',
        22 => 'News Thumbnails',
        23 => 'Calendar Block',
        24 => 'Search Bar',
        25 => 'Text Block',
        26 => 'Video Text',
        27 => 'RSS Feed',
        30 => 'Categories Block',
        31 => 'Services Block',
        32 => 'White Services Block',
        33 => 'Works Thumbnails',
        34 => 'Page Box',
        35 => 'Dynamic Services',
        36 => 'Image Search Box',
        90 => 'Dark Footer',
        91 => 'Light Footer',
        92 => 'Base Footer',
        100 => 'Bread Crumbs'
    );

    public $component_descs = array(
        10 => 'A slider with a single background image that shifts a little with each slide. New slides consist of
               a title, description, and small image that links elsewhere.',
        11 => 'An unchangable counter that you can set the image for. The stats shown are dynamic stats related to
               your community.',
        12 => 'A search bar above a background image you upload so direct users to the proper place in Community
               Resources.',
        13 => 'A traditional slider where each slide has a different background image. Each slide has a title,
               description, and background image to link to elsewhere.',
        14 => 'An unchangable counter that you can set the image for that is better for darker backgrounds. The stats
               shown are dynamic stats related to your community.',
        21 => 'A component to provide a clear button for a user to go to. Useful for directing to join the community
               or find something specific.',
        22 => 'Displays 8 articles that you have to add separately to the component. Useful for showing off recent
               news or events.',
        23 => 'A simple block that is half calendar, half youtube video.',
        24 => 'A small search bar that can be placed anywhere for searching through Community Resources',
        25 => 'Simple text block that you can upload an image next to and set the background color.',
        26 => 'Another simple text block that has an image next to it instead.',
        27 => 'Half text block next to an RSS feed.',
        30 => 'A dynamic category section with a small twitter feed to the right. Categories have to be added
               separately to the component and provide an icon.',
        31 => '3 link boxes where you control the text, icons, and link for each box.',
        32 => '3 static boxes that show just the text.',
        33 => '4 thumbnails that you add separately with an image, text, and a link.',
        34 => 'Full page text, preferably short and simple.',
        35 => 'A 4 block text where you control the color and add the blocks dynamically to the component.',
        36 => 'A simple search bar with an image you provide above it.'
    );

    public $dynamic_titles = array(
        10 => 'Add Slider Item',
        13 => 'Add Slider Item',
        22 => 'Add News Item',
        30 => 'Add Category Option',
        33 => 'Add Works Item',
        102 => 'Add Release Notes',
        103 => 'Add News',
        104 => 'Ask a Question',
        105 => 'Add Tutorial'
    );

    public $container_titles = array(
        'timeline1' => '2 Column Timeline',
        'timeline2' => '1 Column Timeline',
        'static' => 'Static Content Page',
        'event1' => 'Event Description Page',
        'files1' => 'File Viewer and Distribution',
        'blog1' => 'Blog Layout',
        'gallery1' => 'File Gallery Layout',
        'slideshow1' => 'Slide Share Gallery',
        'contact1' => 'Contact Form',
        'table1' => 'Dynamic Table',
        'series1' => 'Challenge Series'
//        'challenge1' => 'Challenge'
        );

    public $container_descs = array(
        'timeline1' => 'A 2 column timeline for displaying dynamic articles from newest entered to oldest. Each article
             links to a full version of the article.',
        'timeline2' => 'A single column timeline that focuses on the inserted time moreso than order. Each article will
             open a full version of the article.',
        'static' => 'A static HTML page where you\'ll have full control over the content on the page. The page is not
             dynamic and all changes you\'ll have to update the HTML',
        'event1' => 'A page that will sort based on nearest ending event to past events. Useful when presenting data
             that has a start and end date.',
        'files1' => 'A table view that allows you to add files to download for users. Useful for presenting a list of
             files to download or data files and documents.',
        'blog1' => 'Basic Blog layout that takes an image to display next to the articles. Useful for general blogs
             or articles that prefer to have an image.',
        'gallery1' => 'A gallery for showing and downloading images or files. Useful for showing off images or showing
             and downloading PDFs or charts.',
        'slideshow1' => 'A gallery for showing Slide Share slideshows specifically.',
        'contact1' => 'Contact form page for having users send emails out to the moderators.',
        'table1' => 'A table that you can dynamically add data to. Useful for showing table data like presentations.',
        'series1' => 'A page where you can setup a Challenge Series'
        /*
		To do: see "container articles" above ...
        ,'challenge1' => 'A page where you can setup an individual Challenge'
        */
    );

    public $component_urls = array(
        102 => 'versions',
        103 => 'news',
        104 => 'questions',
        105 => 'tutorials'
    );

    public function getTitle() {
        return $this->component_ids[$this->component];
    }

    public function getAddTitle() {
        return $this->dynamic_titles[$this->component];
    }

    public function getURL() {
        return $this->component_urls[$this->component];
    }

    public function create($vars) {
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->component = $vars['component'];
        $this->position = $vars['position'];
        $this->image = $vars['image'];
        $this->text1 = $vars['text1'];
        $this->text2 = $vars['text2'];
        $this->text3 = $vars['text3'];
        $this->color1 = $vars['color1'];
        $this->color2 = $vars['color2'];
        $this->color3 = $vars['color3'];
        $this->icon1 = $vars['icon1'];
        $this->icon2 = $vars['icon2'];
        $this->icon3 = $vars['icon3'];
        $this->disabled = $vars['disabled'];
        $this->time = time();

        if ($this->component > 199)
            $this->type = 'page';
        elseif ($this->component == 100) {
            $this->type = 'breadcrumbs';
        } elseif ($this->component == 101) {
            $this->type = 'search';
        } elseif ($this->component < 10) {
            $this->type = 'header';
        } elseif ($this->component > 89)
            $this->type = 'footer';
        else
            $this->type = 'body';
    }

    public function updateData($vars) {
        $this->image = $vars['image'];
        $this->text1 = $vars['text1'];
        $this->text2 = $vars['text2'];
        $this->text3 = $vars['text3'];
        $this->color1 = $vars['color1'];
        $this->color2 = $vars['color2'];
        $this->color3 = $vars['color3'];
        $this->icon1 = $vars['icon1'];
        $this->icon2 = $vars['icon2'];
        $this->icon3 = $vars['icon3'];
        $this->disabled = $vars['disabled'];
    }

    public function createFromRow($vars) {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->component = $vars['component'];
        $this->position = $vars['position'];
        $this->type = $vars['type'];
        $this->image = $vars['image'];
        $this->text1 = $vars['text1'];
        $this->text2 = $vars['text2'];
        $this->text3 = $vars['text3'];
        $this->color1 = $vars['color1'];
        $this->color2 = $vars['color2'];
        $this->color3 = $vars['color3'];
        $this->icon1 = $vars['icon1'];
        $this->icon2 = $vars['icon2'];
        $this->icon3 = $vars['icon3'];
        $this->disabled = $vars['disabled'];
        $this->time = $vars['time'];
    }

    public function insertDB() {
        $this->connect();
        $this->id = $this->insert('community_components', 'iiiiisssssssssssii', array(null, $this->uid, $this->cid, $this->component, $this->position, $this->type, $this->image, $this->text1, $this->text2, $this->text3, $this->color1, $this->color2, $this->color3, $this->icon1, $this->icon2, $this->icon3, $this->disabled, $this->time));
        $this->close();
    }

    public function updateDB() {
        $this->connect();
        $this->update('community_components', 'issssssssssii', array('component', 'image', 'text1', 'text2', 'text3', 'color1', 'color2', 'color3', 'icon1', 'icon2', 'icon3', 'disabled'), array($this->component, $this->image, $this->text1, $this->text2, $this->text3, $this->color1, $this->color2, $this->color3, $this->icon1, $this->icon2, $this->icon3, $this->disabled, $this->id), 'where id=?');
        $this->close();
    }

    public function removeDB() {
        $this->connect();
        $this->delete('community_components', 'i', array($this->id), 'where id=?');
        $this->close();
    }

    public function shiftAll($pos, $cid, $num) {
        $this->connect();
        $this->increment('community_components', 'iii', array('position'), array($num, $cid, $pos), 'where cid=? and position>? and type="body"');
        $this->close();
    }

    public function shiftAllPages($pos, $cid, $num) {
        $this->connect();
        $this->increment('community_components', 'iii', array('position'), array($num, $cid, $pos), 'where cid=? and position>? and type="page"');
        $this->close();
    }

    public function swap($direction) {
        $this->connect();
        if ($direction == 'up') {
            if ($this->position > 0) {
                $this->update('community_components', 'iii', array('position'), array($this->position, $this->cid, (int)($this->position - 1)), 'where cid=? and position=? and type="body"');
                $this->update('community_components', 'ii', array('position'), array((int)($this->position - 1), $this->id), 'where id=?');
            }
        } else {
            $this->update('community_components', 'iii', array('position'), array($this->position, $this->cid, (int)($this->position + 1)), 'where cid=? and position=? and type="body"');
            $this->update('community_components', 'ii', array('position'), array((int)($this->position + 1), $this->id), 'where id=?');
        }
        $this->close();
    }

    public function getContainerSelectHTML($community) {
        $html = '';
        foreach ($this->container_titles as $key => $title) {
            $html .= '<div class="row" style="margin:0">';
            $html .= '<div class="col-md-5"><div class="img-responsive">
                     <img type="'.$key.'" community="' . $community . '" class="container-select-image"
                     src="/images/components/component-'.$key.'.jpg"/></div></div>';
            $html .= '<div class="col-md-7"><a href="javascript:void(0)" class="container-select-image" type="'.$key.'"
                      community="'.$community.'" style="border:0;margin:0;width:auto">
                      <h3>' . $title . '</h3><p>'.$this->container_descs[$key].'</p></a></div>';
            $html .= '</div><hr style="margin:15px 0;"/>';
        }
        return $html;
    }

    public function getComponentSelectHTML($community) {
        $html = '';
        foreach ($this->component_descs as $key => $title) {
            $html .= '<div class="row" style="margin:0">';
            $html .= '<div class="col-md-5"><div class="img-responsive">
                     <img component="'.$key.'" community="' . $community . '" class="component-select-image"
                     src="/images/components/component-'.$key.'.jpg"/></div></div>';
            $html .= '<div class="col-md-7"><a href="javascript:void(0)" class="component-select-image" component="'.$key.'"
                      community="'.$community.'" style="border:0;margin:0;width:auto">
                      <h3>' . $this->component_ids[$key] . '</h3><p>'.$title.'</p></a></div>';
            $html .= '</div><hr style="margin:15px 0;"/>';
        }
        return $html;

    }

    public function getDynamicStatus() {
        if ($this->component == 10 || $this->component == 13 || $this->component == 22 || $this->component == 30 || $this->component == 33 || $this->component == 35)
            return true;
        else return false;
    }

    public function swapContainer($direction) {
        $this->connect();
        if ($direction == 'up') {
            if ($this->position > 0) {
                $this->update('community_components', 'iii', array('position'), array($this->position, $this->cid, (int)($this->position - 1)), 'where cid=? and position=? and type="page"');
                $this->update('community_components', 'ii', array('position'), array((int)($this->position - 1), $this->id), 'where id=?');
            }
        } else {
            $this->update('community_components', 'iii', array('position'), array($this->position, $this->cid, (int)($this->position + 1)), 'where cid=? and position=? and type="page"');
            $this->update('community_components', 'ii', array('position'), array((int)($this->position + 1), $this->id), 'where id=?');
        }
        $this->close();
    }

    public function getByCommunity($cid) {
        $this->connect();
        $return = $this->select('community_components', array('*'), 'i', array($cid), 'where cid=? order by position asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $component = new Component();
                $component->createFromRow($row);
                $finalArray[$component->type][] = $component;
            }
        }

        return $finalArray;
    }

    public function getByType($cid, $component) {
        $this->connect();
        $return = $this->select('community_components', array('*'), 'ii', array($cid, $component), 'where cid=? and component=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getPageByType($cid, $type) {
        $this->connect();
        $return = $this->select('community_components', array('*'), 'is', array($cid, $type), 'where cid=? and type="page" and text2=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getByID($id) {
        $this->connect();
        $return = $this->select('community_components', array('*'), 'i', array($id), 'where id=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function getMaxComponentID() {
        $this->connect();
        $return = $this->select('community_components', array('component'), null, array(), 'order by component desc limit 1');
        $this->close();

        if (count($return) > 0) {
            if ($return[0]['component'] < 200)
                return 200;
            else
                return $return[0]['component'];
        }
    }

    public function getName() {
        return $this->component_ids[$this->component];
    }

    public function formObjects($type, $column, $label, $tooltip) {
        switch ($type) {
            case 'image':
                return '<section>
                            <label class="label">' . $label . '</label>
                            <label for="file" class="input input-file">
                                <div class="button"><input onchange="$(this).parent().next().val($(this).val());" name="' . $this->id . '-image" type="file" id="file"
                                                           class="file-form">Browse
                                </div>
                                <input type="text" class="file-placeholder" readonly value="' . $this->image . '">
                            </label>
                        </section>';
                break;
            case 'text':
                if ($column == 'text2' && $this->type == 'page')
                    $class = ' class="cont-name" currName="' . $this->text2 . '"';
                else $class = '';
                return '<section>
                            <label class="label">' . $label . '</label>
                            <label class="input">
                                <i class="icon-append fa fa-question-circle"></i>
                                <input type="text"' . $class . ' name="' . $this->id . '-' . $column . '" placeholder="Focus to view the tooltip" value="' . $this->$column . '">
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
                            <ul role="menu" class="dropdown-menu icon-dropdown" name="' . $this->id . '-' . $column . '" style="width:260px;max-height:400px;overflow:auto">';
                foreach ($this->icons as $icon) {
                    $html .= '<li icon="fa ' . $icon . '" class="icon-table"><a href="javascript:void(0);"><i class="fa ' . $icon . '"></i></a></li>';
                }
                $html .= '</ul>
                        </div></label></section>';
                return $html;
                break;
            case 'template':
                $html = '<section>
                            <label class="label">Template</label>';
                if ($this->type == 'page')
                    $html .= '<img class="img-responsive" src="/images/components/component-' . $this->icon1 . '.jpg"
                                 style="border: 1px solid #888"/>';
                else
                    $html .= '<img class="img-responsive" src="/images/components/component-' . $this->component . '.jpg"
                                 style="border: 1px solid #888"/>';
                $html .= '</section>';
                return $html;
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
                $html .= '<select name="' . $this->id . '-position">';
                if ($this->type == 'page')
                    $html .= '<option value="-1">Before ' . $column[0]->text1 . '</option>';
                else
                    $html .= '<option value="-1">Before ' . $column[0]->getTitle() . '</option>';
                foreach ($column as $component) {
                    if ($this->type == 'page')
                        $html .= '<option value="' . $component->position . '">After ' . $component->text1 . '</option>';
                    else
                        $html .= '<option value="' . $component->position . '">After ' . $component->getTitle() . '</option>';
                }
                $html .= '</select></section>';
                return $html;
                break;
            case 'hide':
                $html = '<section>';
                $html .= '<label class="label">' . $label . '</label>';
                $html .= '<select name="' . $this->id . '-disabled">';
                if ($this->disabled == 0)
                    $html .= '<option value="0" selected="selected">Show Under About</option>';
                else
                    $html .= '<option value="0">Show Under About</option>';
                if ($this->disabled == 1)
                    $html .= '<option value="1" selected="selected">Don\'t Show Under About</option>';
                else
                    $html .= '<option value="1">Don\'t Show Under About</option>';
                $html .= '</select></section>';
                return $html;
                break;
        }
    }

    public function getPanelHeader($total, $num, $actions) {
        $html = '<div class="panel panel-dark">
                            <div class="panel-heading" style="border-bottom: 0;color:#fff;background:#555">';

        if ($actions) {
            if ($this->type != 'page')
                $html .= '<h3 class="panel-title clickable" style="display: inline-block;cursor:pointer"><i class="clickable-icon fa fa-plus"></i> ' . $this->component_ids[$this->component] . '
                                </h3>';
            else
                $html .= '<h3 class="panel-title clickable" style="display: inline-block;cursor:pointer"><i class="clickable-icon fa fa-plus"></i> ' . $this->container_titles[$this->icon1] . '
                                </h3>';
            $html .= '<label class="pull-right">
                                    <div class="btn-group" style="margin-top:-4px">
                                        <button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">
                                            Action
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">';
            if ($num > 0)
                $html .= '<li><a href="/forms/component-forms/body-component-shift.php?component=' . $this->id . '&cid=' . $this->cid . '&direction=up"><i class="fa fa-angle-up"></i> Shift Up</a></li>';
            if ($num != $total - 1)
                $html .= '<li><a href="/forms/component-forms/body-component-shift.php?component=' . $this->id . '&cid=' . $this->cid . '&direction=down"><i class="fa fa-angle-down"></i> Shift Down</a></li>';
            $html .= '<li><a href="/forms/component-forms/body-component-delete.php?component=' . $this->id . '&cid=' . $this->cid . '"><i class="fa fa-times"></i> Remove</a></li>
                                        </ul>
                                    </div>';
            $html .= '</label>
                            </div>
                            <div class="panel-body" style="display:none">';
        } else {
            if ($this->type != 'page')
                $html .= '<h3 class="panel-title" style="display: inline-block;"><i class="clickable-icon fa fa-plus"></i> ' . $this->component_ids[$this->component] . '
                                </h3>';
            elseif ($this->icon1 == "challenge1")
                $html .= '<h3 class="panel-title" style="display: inline-block;"><i class="clickable-icon fa fa-plus"></i> ' . 'Challenge' . '
                                </h3>';
			else
                $html .= '<h3 class="panel-title" style="display: inline-block;"><i class="clickable-icon fa fa-plus"></i> ' . $this->container_titles[$this->icon1] . '
                                </h3>';
            $html .= '</label>
                            </div>
                            <div class="panel-body">';
        }
        return $html;
    }

    public function otherComponents($type) {
        switch ($type) {
            case "header":
                break;
            case "breadcrumbs":
                break;
            case "search":
                break;
            case "footer":
                break;
        }
    }

    public function bodyComponentHTML($total, $num, $actions, $components) {
        switch ($this->component) {
            case 10: //Parralax Slider
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('image', 'image', 'Background Image', '');
                $html .= $this->formObjects('color', 'color1', 'Title Background Color', 'The background color of the title text on each slide');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 11: //Parralax Counter
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('image', 'image', 'Background Image', '');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 12: //Search Banner',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('image', 'image', 'Background Image', '');
                $html .= $this->formObjects('text', 'text1', 'Header Text', 'The text shown above the search box');
                $html .= $this->formObjects('text', 'text2', 'Placeholder Text', 'The text shown inside the search box');
                $html .= $this->formObjects('color', 'color1', 'Text Color', 'The color of basic text');
                $html .= $this->formObjects('color', 'color2', 'Search Icon Color', 'The color of the search Icon');
                $html .= $this->formObjects('color', 'color3', 'Save Search Icon Color', 'The color of the saved search icon');

                $html .= '</fieldset>';
                $html .= '</div></div>';

                break;
            case 13: //Parralax Slider
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 14: //Parralax Counter
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Title', 'The title of the counter block');
                $html .= $this->formObjects('textarea', 'text2', 'Description', 'The description under the title');
                $html .= $this->formObjects('image', 'image', 'Background Image', '');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 21: //Goto Block',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Title', 'The title for this section');
                $html .= $this->formObjects('text', 'text2', 'Description', 'The description shown under the title');
                $html .= $this->formObjects('icon', 'icon1', 'Button Icon', '');
                $html .= $this->formObjects('color', 'color1', 'Button Color', 'The background color of the button');
                $html .= $this->formObjects('color', 'color2', 'Button Hover Color', 'The background color of the button when it is hovered on');
                $html .= $this->formObjects('text', 'text3', 'Button Text', 'The text in the button');
                $html .= $this->formObjects('text', 'image', 'Button Link', 'The url the button takes you to');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 22: //News Thumbnails',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Title', 'The title for this section');
                $html .= $this->formObjects('text', 'text2', 'Description', 'The description shown under the title');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 23: //Calendar Block',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Calendar SRC', 'The source for the google calendar');
                $html .= $this->formObjects('text', 'text2', 'Video SRC', 'The source for the youtube embed');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 24:
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Search Placeholder', 'The text in the empty search box');
                $html .= $this->formObjects('text', 'text2', 'Search Button Text', 'The text in the search button');
                $html .= $this->formObjects('color', 'color1', 'Bar Color', 'The color of the search bar');
                $html .= $this->formObjects('color', 'color2', 'Button Color', 'The background color of the button');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 25: //Text Block
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Title', 'The section title');
                $html .= $this->formObjects('textarea', 'text2', 'Text', 'The main text shown');
                $html .= $this->formObjects('image', 'image', 'Image', 'The image to be shown');
                $html .= $this->formObjects('color', 'color1', 'Background Color', 'The color of the background');
                $html .= $this->formObjects('color', 'color2', 'Button Color', 'The background color of the button');
                $html .= $this->formObjects('color', 'color3', 'Text Color', 'The color of the text');
                $html .= $this->formObjects('text', 'text3', 'Button Text', 'The text shown on the button');
                $html .= $this->formObjects('icon', 'icon1', 'Button Icon', 'The icon in the button');
                $html .= $this->formObjects('text', 'icon2', 'Button URL', 'The url the button goes to');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 26: //Video Text
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'image', 'Video SRC', 'The source for the youtube embed');
                $html .= $this->formObjects('text', 'text1', 'Title', 'The title for this section');
                $html .= $this->formObjects('textarea', 'text2', 'Description', 'The description for this section');
                $html .= $this->formObjects('text', 'text3', 'Button Text', 'The source for the youtube embed');
                $html .= $this->formObjects('text', 'icon1', 'Button Link', 'Where the button links to');
                $html .= $this->formObjects('color', 'color1', 'Button Background Color', 'The background color for the button');
                $html .= $this->formObjects('color', 'color2', 'Background Color', 'The background color of the section');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 27: //Categories Block',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Text Section Header', 'The header for text portion of this component');
                $html .= $this->formObjects('textarea', 'text2', 'Text Section Text', 'The block of text shown next to the RSS feed');
                $html .= $this->formObjects('text', 'text3', 'RSS Feed Header', 'The header of the RSS feed');
                $html .= $this->formObjects('text', 'image', 'RSS Feed URL', 'The XML URL of the RSS feed');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 30: //Categories Block',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Section Header', 'The header for this section shown in the top left');
                $html .= $this->formObjects('text', 'text2', 'Twitter Handle', 'The handle of your twitter to link to.');
                $html .= $this->formObjects('text', 'text3', 'Twitter Widget ID', 'The widget ID for your twitter, preferred height is 380.');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 31: //Services Block',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('icon', 'icon1', 'First Box Icon', '');
                $html .= $this->formObjects('text', 'color1', 'First Box URL', '');
                $html .= $this->formObjects('textarea', 'text1', 'First Box Text', '');
                $html .= $this->formObjects('icon', 'icon2', 'Second Box Icon', '');
                $html .= $this->formObjects('text', 'color2', 'Second Box URL', '');
                $html .= $this->formObjects('textarea', 'text2', 'Second Box Text', '');
                $html .= $this->formObjects('icon', 'icon3', 'Third Box Icon', '');
                $html .= $this->formObjects('text', 'color3', 'Third Box URL', '');
                $html .= $this->formObjects('textarea', 'text3', 'Third Box Text', '');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 32: //White Services Block',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('icon', 'icon1', 'First Box Icon', '');
                $html .= $this->formObjects('color', 'color1', 'First Box Color', 'The icon color in the first box');
                $html .= $this->formObjects('textarea', 'text1', 'First Box Text', '');
                $html .= $this->formObjects('icon', 'icon2', 'Second Box Icon', '');
                $html .= $this->formObjects('color', 'color2', 'Second Box Color', 'The icon color in the second box');
                $html .= $this->formObjects('textarea', 'text2', 'Second Box Text', '');
                $html .= $this->formObjects('icon', 'icon3', 'Third Box Icon', '');
                $html .= $this->formObjects('color', 'color3', 'Third Box Color', 'The icon color in the third box');
                $html .= $this->formObjects('textarea', 'text3', 'Third Box Text', '');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 33: //Works Thumbnails',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Section Header', 'The header for this section shown in the top left');
                $html .= $this->formObjects('color', 'color1', 'Highlight Color', 'The color of the read more button and underline');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 34: //Page Box',
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Title', 'The title text');
                $html .= $this->formObjects('text', 'text2', 'Description', 'The description text');
                $html .= $this->formObjects('color', 'color1', 'Top Border Color', 'The top border color');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 35: //Dynamic Services,
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            case 36:
                $html = $this->getPanelHeader($total, $num, $actions);
                $html .= '<fieldset>';
                $html .= $this->formObjects('template', '', 'Template', '');
                if ($components && count($components) > 0) {
                    $html .= $this->formObjects('position', $components, 'Place Where', '');
                }
                $html .= $this->formObjects('text', 'text1', 'Display Text', 'The text shown on top of the image');
                $html .= $this->formObjects('text', 'text2', 'Search Placeholder', 'The text in the empty search box');
                $html .= $this->formObjects('text', 'text3', 'Search Button Text', 'The text in the search button');
                $html .= $this->formObjects('color', 'color1', 'Bar Color', 'The color of the search bar');
                $html .= $this->formObjects('color', 'color2', 'Button Color', 'The background color of the button');
                $html .= $this->formObjects('image', 'image', 'Background Image', 'The image behind the search box');
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
            default :
            	if ($this->icon1 == 'challenge1') {
					$html = $this->getPanelHeader($total, $num, $actions);
					$html .= '<fieldset>';
					$html .= $this->formObjects('template', '', 'Template', '');
            		$html .= $this->formObjects('text', 'text1', 'Title', 'The title for your new container');
					$html .= $this->formObjects('text', 'tags', 'Tags', 'Keywords about the article');
					$html .= $this->formObjects('textarea', 'description', 'Description', 'The description of what this container is for');
					$html .= $this->formObjects('date', 'start', 'Start Date', 'The time and date that this challenge starts');
					$html .= $this->formObjects('date', 'end', 'End Date', 'The time and date that this challenge ends');
					$html .= $this->formObjects('text', 'text2', 'URL of Challenge', 'A url that points to the challenge in question.');
					$html .= $this->formObjects('textarea', 'text3', 'Content', 'Full text describing the challenge');
					$html .= $this->formObjects('text', 'visibility', 'visiblity:Value', 'Should this challenge be visible to the public yet?');
					$html .= $this->formObjects('text', 'rules', 'rules:URL', 'If there is a rules page, give the URL');
					$html .= $this->formObjects('image', 'image', 'Image', 'An image for list display');
					} else {	
				
					$html = $this->getPanelHeader($total, $num, $actions);
					$html .= '<fieldset>';
					$html .= $this->formObjects('template', '', 'Template', '');
					if (!$this->id && $components && count($components) > 0) {
						$html .= $this->formObjects('position', $components, 'Place Where', '');
					}
					$html .= $this->formObjects('text', 'text1', 'Title', 'The title for your new container');
					$html .= $this->formObjects('text', 'text2', 'URL Name', 'The Unique URL friendly name of the container');
					$html .= $this->formObjects('hide', 'disabled', 'Show Under About', '');
					if ($this->icon1 == 'static')
						$html .= $this->formObjects('textarea', 'text3', 'Content', 'The Static content on the page');
					else
						$html .= $this->formObjects('textarea', 'text3', 'Description', 'The description of what this container is for');
					if ($this->icon1 == 'files1' || $this->icon1 == 'table1')
						$html .= $this->formObjects('text', 'icon2', 'Custom Columns', 'Comma separated columns for your file display table');
					if ($this->icon1 == 'table1')
						$html .= $this->formObjects('text', 'icon3', 'Custom Columns Types', 'Comma separated types for insertion: text or textarea');
					elseif ($this->icon1 == 'contact1') {
						$html .= $this->formObjects('text', 'color1', 'Address for map', 'The address of your business for use in the map');
						$html .= $this->formObjects('textarea', 'color2', 'Full Contact Information', 'Ways people can reach your community, email, phone, etc');
						$html .= $this->formObjects('textarea', 'color3', 'Business Hours', 'Hours people should expect a response');
					}
				}	
                $html .= '</fieldset>';
                $html .= '</div></div>';
                break;
        }
        return $html;
    }

}


?>