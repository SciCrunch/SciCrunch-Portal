<?php

/*
 * Community Class
 *   Class that handles everything pertaining to Communities within SciCrunch. Communities are User created entities
 *   the create webpages for a user defined community
 *
 * @internal DBTable: communities
 * @vars     DBColumns: id,uid,name,description,portalName,url,shortName,logo,private,access,resourceView,dataView,
 *     literatureView,time (iissssssiiiiii)
 */

class Community extends Connection
{

    public $id;
    public $uid;
    public $name;
    public $description;
    public $portalName;
    public $address;
    public $url;
    public $shortName;
    public $logo;
    public $private;
    public $access;
    public $resourceView;
    public $dataView;
    public $literatureView;
    public $time;
    public $about_home_view;
    public $about_sources_view;

    public $components;

    public $categoryLabels;
    public $urlTree;
    public $categoryTree;
    public $savedSqls;
    public $wiki;
    public $resourceType;
    public $relationships;
    public $meta;
    public $views;
    public static $banned = array(
        "'94.19.%'",
        "'199.58%'",
        "'127.0%'",
        "'27.159%'",
        "'144.76%'",
        "'46.165%'",
        "'178.137%'",
        "'86.7.%'",
        "'204.15%'",
        "'66.249%'",
        "'5.10%'",
        "'63.147%'",
        "'208.107%'",
        "'74.112%'",
        "'173.208%'",
        "'108.59%'",
        "'83.149%'",
        "'171.65%'",
        "'202.244%'",
        "'24.239%'");

    public $dbTypes = 'iisssssssiiiiiiii';

    public function create($vars)
    {
        $this->uid = $vars['uid'];
        $this->name = $vars['name'];
        $this->shortName = $vars['shortName'];
        $this->description = $vars['description'];
        $this->address = $vars['address'];
        $this->portalName = $vars['portalName'];
        $this->url = $vars['url'];
        $this->private = $vars['private'];
        $this->logo = $vars['logo'];
        $this->resourceView = $vars['resourceView'];
        $this->dataView = $vars['dataView'];
        $this->literatureView = $vars['literatureView'];
        $this->about_home_view = $vars['about_home_view'];
        $this->about_sources_view = $vars['about_sources_view'];
        $this->access = $vars['access'];
    }

    /*
     * public edit
     *   Function to edit the current community object to later update the DB table with
     *
     * @param  array[] vars key:value pair where keys relate to the columns in the table
     * @return void
     */

    public function edit($vars)
    {
        $this->name = $vars['name'];
        $this->shortName = $vars['shortName'];
        $this->description = $vars['description'];
        $this->address = $vars['address'];
        $this->url = $vars['url'];
        $this->private = $vars['private'];
        $this->logo = $vars['logo'];
        $this->resourceView = $vars['resourceView'];
        $this->dataView = $vars['dataView'];
        $this->literatureView = $vars['literatureView'];
        $this->about_home_view = $vars['about_home_view'];
        $this->about_sources_view = $vars['about_sources_view'];
        $this->access = $vars['access'];
    }

    public function createFromRow($row)
    {
        $this->id = $row['id'];
        $this->uid = $row['uid'];
        $this->name = $row['name'];
        $this->shortName = $row['shortName'];
        $this->description = $row['description'];
        $this->address = $row['address'];
        $this->portalName = $row['portalName'];
        $this->url = $row['url'];
        $this->private = $row['private'];
        $this->access = $row['access'];
        $this->logo = $row['logo'];
        $this->resourceView = $row['resourceView'];
        $this->dataView = $row['dataView'];
        $this->literatureView = $row['literatureView'];
        $this->about_home_view = $row['about_home_view'];
        $this->about_sources_view = $row['about_sources_view'];
        $this->time = $row['time'];
    }

    public function insertDB()
    {
        $this->connect();
        $this->id = $this->insert('communities', $this->dbTypes, array($this->id, $this->uid, $this->name, $this->description, $this->address, $this->portalName, $this->url, $this->shortName, $this->logo, $this->private, $this->access, $this->resourceView, $this->dataView, $this->literatureView, $this->about_home_view, $this->about_sources_view, time()));
        $this->close();
    }

    public function updateDB()
    {
        $this->connect();
        $this->update('communities', 'sssssisiiiiiii',
            array('name', 'shortName', 'description', 'address', 'url', 'private', 'logo', 'resourceView', 'dataView', 'literatureView', 'about_home_view', 'about_sources_view', 'access'),
            array($this->name, $this->shortName, $this->description, $this->address, $this->url, $this->private, $this->logo, $this->resourceView, $this->dataView, $this->literatureView, $this->about_home_view, $this->about_sources_view, $this->access, $this->id),
            'where id=?');
        $this->close();
    }

    /*
     * public join
     *   Handles the joining of a user to this community
     *
     * @internal DBTable: community_access
     * @param int    id    the ID of the user
     * @param String name  the name of the User
     * @param int    level the level at which to insert the user as
     *
     * @return void
     */

    public function join($id, $name, $level)
    {
        $this->connect();
        $return = $this->select('community_access', array('*'), 'ii', array($id, $this->id), 'where uid=? and cid=?');
        if (count($return) == 0)
            $this->insert('community_access', 'iisiii', array(null, $id, $name, $this->id, $level, time()));
        $this->close();
    }

    /*
     * public updateUser
     *   function to handle updating a user's level in this community
     *
     * @internal DBTable: community_access
     * @param int uid   the user ID to update
     * @param int level the level to update the user to
     *
     * @return void
     */

    public function updateUser($uid, $level)
    {
        $this->connect();
        $return = $this->select('community_access', array('id'), 'ii', array($uid, $this->id), 'where uid=? and cid=?');
        if (count($return) > 0) {
            $id = $return[0]['id'];
            $this->update('community_access', 'ii', array('level'), array($level, $id), 'where id=?');
        }
        $this->close();
    }

    /*
     * public removeUser
     *   function to remove the user from the community
     *
     * @internal DBTable: community_access
     * @param int uid the user ID of the user to delete from the community
     *
     * @return void
     */

    public function removeUser($uid)
    {
        $this->connect();
        $this->delete('community_access', 'ii', array($uid, $this->id), 'where uid=? and cid=?');
        $this->close();
    }

    public function getCommCount()
    {
        $this->connect();
        $return = $this->select('communities', array('count(id)'), null, array(), '');
        $count = $return[0]['count(id)'];
        $this->close();

        return $count;
    }

    public function getUserCount()
    {
        $this->connect();
        $return = $this->select('community_access', array('count(id)'), 'i', array($this->id), 'where cid=?');
        $count = $return[0]['count(id)'];
        $this->close();

        return $count;
    }

    public function getUsers()
    {
        $this->connect();
        $return = $this->select('community_access', array('*'), 'i', array($this->id), 'where cid=?');
        $this->close();

        return $return;
    }

    public function getUser($uid){
        $this->connect();
        $return = $this->select('community_access', array('*'), 'ii', array($this->id, $uid), 'where cid=? and uid=?');
        $this->close();

        return $return;
    }

    public function getByID($id)
    {
        $this->connect();
        $return = $this->select('communities', array('*'), 'i', array($id), 'where id=?');
        if (count($return) > 0) {
            $this->createFromRow($return[0]);
            $meta = $this->select('community_metadata', array('*'), 'i', array($this->id), 'where cid=? and active=1');
            if (count($meta) > 0) {
                foreach ($meta as $row) {
                    $this->meta[(string)$row['name']] = $row['value'];
                }
            }
            $this->close();
            return true;
        } else {
            $this->close();
            return false;
        }
    }

    public function getByPortalName($name)
    {
        $this->connect();
        $return = $this->select('communities', array('*'), 's', array($name), 'where portalName=?');
        if (count($return) > 0) {
            $this->createFromRow($return[0]);
            $meta = $this->select('community_metadata', array('*'), 'i', array($this->id), 'where cid=? and active=1');
            if (count($meta) > 0) {
                foreach ($meta as $row) {
                    $this->meta[(string)$row['name']] = $row['value'];
                }
            }
            $this->close();
            return true;
        } else {
            $this->close();
            return false;
        }
    }

    public function getCategories()
    {
        $this->urlTree = array();
        $categories = Category::getCategories($this->id);
        if ($categories) {
            foreach ($categories as $category) {
                if ($category->source) {
                    if ($category->subcategory) {
                        $this->urlTree[$category->category]['subcategories'][$category->subcategory]['urls'][] = ENVIRONMENT . '/v1/federation/data/' . $category->source . '.xml?orMultiFacets=true' . $category->filter . $category->facet;
                        $this->urlTree[$category->category]['subcategories'][$category->subcategory]['nif'][] = $category->source;
                        $this->urlTree[$category->category]['subcategories'][$category->subcategory]['objects'][] = $category;
                        $this->views[$category->source] = true;
                    } else {
                        $this->urlTree[$category->category]['urls'][] = ENVIRONMENT . '/v1/federation/data/' . $category->source . '.xml?orMultiFacets=true' . $category->filter . $category->facet;
                        $this->urlTree[$category->category]['nif'][] = $category->source;
                        $this->urlTree[$category->category]['objects'][] = $category;
                        $this->views[$category->source] = true;
                    }
                }
            }
        }
    }

    public function getAllCategories()
    {
        $categories = Category::getCategories($this->id);
        if ($categories) {
            foreach ($categories as $category) {
                if ($category->subcategory) {
                    $this->urlTree[$category->category]['subcategories'][$category->subcategory]['urls'][] = ENVIRONMENT . '/v1/federation/data/' . $category->source . '.xml?orMultiFacets=true' . $category->filter . $category->facet;
                    $this->urlTree[$category->category]['subcategories'][$category->subcategory]['nif'][] = $category->source;
                    $this->urlTree[$category->category]['subcategories'][$category->subcategory]['objects'][] = $category;
                    $this->views[$category->source] = true;
                } else {
                    $this->urlTree[$category->category]['urls'][] = ENVIRONMENT . '/v1/federation/data/' . $category->source . '.xml?orMultiFacets=true' . $category->filter . $category->facet;
                    $this->urlTree[$category->category]['nif'][] = $category->source;
                    $this->urlTree[$category->category]['objects'][] = $category;
                    $this->views[$category->source] = true;
                }
            }
        }
    }

    public function searchCommunities($cids, $query, $offset, $limit)
    {
        if ($cids) {
            foreach ($cids as $cid) {
                $cis[] = 'id=' . $cid;
            }
            $where = ' or ' . join(' or ', $cis);
        } else $where = '';
        $case = "IF(comm.name LIKE ?,  20, IF(name LIKE ?, 10, 0)) +
                          IF(comm.description LIKE ?, 5,  0) +
                          IF(comm.portalName   LIKE ?, 15,  0)  AS weight";
        $this->connect();
        $return = $this->select('communities as comm', array('SQL_CALC_FOUND_ROWS *', $case), 'sssssss', array($query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%', '%' . $query . '%'), "where (comm.name LIKE ? OR
                             comm.description LIKE ? OR
                             comm.portalName  LIKE ?) and (private=0" . $where . ")
                             order by weight desc limit $offset,$limit");
        $finalArray['count'] = $this->getTotal();
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $community = new Community();
                $community->createFromRow($row);
                $finalArray['results'][] = $community;
            }
        }

        return $finalArray;
    }



// (192 - 64) / 16 = 8
// 8 ^ 3 = 512 colors

    public function communityColor()
    {
        define(COL_MIN_AVG, 64);
        define(COL_MAX_AVG, 192);
        define(COL_STEP, 16);
        $range = COL_MAX_AVG - COL_MIN_AVG;
        $factor = $range / 256;
        $offset = COL_MIN_AVG;

        $base_hash = substr(md5($this->portalName), 0, 6);
        $b_R = hexdec(substr($base_hash, 0, 2));
        $b_G = hexdec(substr($base_hash, 2, 2));
        $b_B = hexdec(substr($base_hash, 4, 2));

        $f_R = floor((floor($b_R * $factor) + $offset) / COL_STEP) * COL_STEP;
        $f_G = floor((floor($b_G * $factor) + $offset) / COL_STEP) * COL_STEP;
        $f_B = floor((floor($b_B * $factor) + $offset) / COL_STEP) * COL_STEP;

        return sprintf('#%02x%02x%02x', $f_R, $f_G, $f_B);
    }

    static function isVisible($cid, $user){
        // boolean if user can see the community id
        $comm = new Community();
        $comm->getByID($cid);
        if($comm->private == 0) return true;
        $users = $comm->getUser($user->id);
        if(isset($users)) return true;
        return false;
    }

}

class Category extends Connection
{

    public $id;
    public $uid;
    public $cid;
    public $x, $y, $z;
    public $category;
    public $subcategory;
    public $source;
    public $filter;
    public $facet;
    public $active;
    public $time;

    public $dbTypes = 'iiiiiisssssii';

    public function create($vars)
    {
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->x = $vars['x'];
        $this->y = $vars['y'];
        $this->z = $vars['z'];
        $this->category = $vars['category'];
        $this->subcategory = $vars['subcategory'];
        $this->source = $vars['source'];
        $this->filter = $vars['filter'];
        $this->facet = $vars['facet'];
        $this->active = 1;
        $this->time = time();
    }

    public function createFromRow($vars)
    {
        $this->id = $vars['id'];
        $this->uid = $vars['uid'];
        $this->cid = $vars['cid'];
        $this->x = $vars['x'];
        $this->y = $vars['y'];
        $this->z = $vars['z'];
        $this->category = $vars['category'];
        $this->subcategory = $vars['subcategory'];
        $this->source = $vars['source'];
        $this->filter = $vars['filter'];
        $this->facet = $vars['facet'];
        $this->active = $vars['active'];
        $this->time = $vars['time'];
    }

    public function insertDB()
    {
        $this->connect();
        $this->id = $this->insert('community_structure', $this->dbTypes, array(null, $this->uid, $this->cid, $this->x, $this->y, $this->z, $this->category, $this->subcategory, $this->source, $this->filter, $this->facet, $this->active, $this->time));
        $this->close();
    }

    public function updateDB()
    {
        $this->connect();
        $this->update('community_structure', 'sssi',
            array('source', 'filter', 'facet'),
            array($this->source, $this->filter, $this->facet, $this->id),
            'where id=?');
        $this->close();
    }

    public function getCategories($cid)
    {
        $this->connect();
        $return = $this->select('community_structure', array('*'), 'i', array($cid), 'where cid=? and active=1 order by x asc, y asc, z asc, id asc');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $category = new Category();
                $category->createFromRow($row);
                $finalArray[] = $category;
            }
        }

        return $finalArray;
    }

    public function getUsed()
    {
        $this->connect();
        $return = $this->select('community_structure', array('cid', 'source'), null, array(), 'where active=1');
        $this->close();

        if (count($return) > 0) {
            foreach ($return as $row) {
                $category = new Category();
                $category->createFromRow($row);
                $finalArray[] = $category;
            }
        }

        return $finalArray;
    }

    public function getByID($id)
    {
        $this->connect();
        $return = $this->select('community_structure', array('*'), 'i', array($id), 'where id=?');
        $this->close();

        if (count($return) > 0) {
            $this->createFromRow($return[0]);
        }
    }

    public function deleteType($type)
    {
        $this->connect();
        $rand = -rand(10, 100);
        if ($type == 'category') {
            $this->update('community_structure', 'iii', array('x'), array($rand, $this->x, $this->cid), 'where x=? and cid=?');
            $this->close();
            $this->shiftAll('x', -1, false);
            $this->connect();
            $this->delete('community_structure', 'ii', array($rand, $this->cid), 'where x=? and cid=?');
        } elseif ($type == 'subcategory') {
            $this->update('community_structure', 'iiii', array('y'), array($rand, $this->x, $this->y, $this->cid), 'where x=? and y=? and cid=?');
            $this->close();
            $this->shiftAll('y', -1, false);
            $this->connect();
            $this->delete('community_structure', 'iii', array($this->x, $rand, $this->cid), 'where x=? and y=? and cid=?');
        } elseif ($type == 'source') {
            $this->update('community_structure', 'iiiii', array('z'), array($rand, $this->x, $this->y, $this->z, $this->cid), 'where x=? and y=? and z=? and cid=?');
            $this->close();
            $this->shiftAll('z', -1, false);
            $this->connect();
            $this->delete('community_structure', 'iiii', array($this->x, $this->y, $rand, $this->cid), 'where x=? and y=? and z=? and cid=?');
        }
        $this->close();
    }

    public function getPanelHeader($sub, $x, $y, $total, $name, $cid, $category, $subcategory)
    {
        if (!$sub)
            $html = '<div class="panel panel-dark"><div class="panel-heading" style="border-bottom: 0">';
        else
            $html = '<div class="panel panel-grey"><div class="panel-heading" style="border-bottom: 0">';

        $html .= '<h3 class="panel-title clickable" style="display: inline-block;cursor:pointer"><i class="clickable-icon fa fa-plus"></i> ' . $name . '
                                </h3>';
        $html .= '<label class="pull-right">';
        $html .= '<div class="btn-group" style="margin-top:-4px">';
        $html .= '<button type="button" class="btn-u btn-default dropdown-toggle" data-toggle="dropdown">Action<i class="fa fa-angle-down"></i></button>';
        $html .= '<ul class="dropdown-menu" role="menu">';

        if ($x > 0 && $sub == null)
            $html .= '<li><a href="/forms/community-forms/category-shift.php?x=' . $x . '&cid=' . $cid . '&direction=up"><i class="fa fa-angle-up"></i> Shift Up</a></li>';
        elseif ($y > 0)
            $html .= '<li><a href="/forms/community-forms/category-shift.php?x=' . $x . '&y=' . $y . '&cid=' . $cid . '&direction=up"><i class="fa fa-angle-up"></i> Shift Up</a></li>';

        if (!$sub && $x < $total - 1)
            $html .= '<li><a href="/forms/community-forms/category-shift.php?x=' . $x . '&cid=' . $cid . '&direction=down"><i class="fa fa-angle-down"></i> Shift Down</a></li>';
        elseif ($y < $total - 1)
            $html .= '<li><a href="/forms/community-forms/category-shift.php?x=' . $x . '&y=' . $y . '&cid=' . $cid . '&direction=down"><i class="fa fa-angle-down"></i> Shift Down</a></li>';

        if (!$sub)
            $html .= '<li><a href="javascript:void(0)" class="category-name-btn" x="' . $x . '" cid="' . $cid . '" control="category-name" category="' . $category . '"><i class="fa fa-pencil"></i> Change Name</a></li>';
        else
            $html .= '<li><a href="javascript:void(0)" class="category-name-btn" x="' . $x . '" y="' . $y . '" cid="' . $cid . '" control="subcategory-name" category="' . $category . '" subcategory="' . $subcategory . '"><i class="fa fa-pencil"></i> Change Name</a></li>';

        if (!$sub)
            $html .= '<li><a href="javascript:void(0)" class="category-load-btn" x="' . $x . '" cid="' . $cid . '" control="add-sub" category="' . $category . '"><i class="fa fa-plus"></i> Add Subcategory</a></li>';

        if (!$sub)
            $html .= '<li><a href="javascript:void(0)" class="category-load-btn" x="' . $x . '" cid="' . $cid . '" control="add-source" category="' . $category . '" subcategory="' . $subcategory . '"><i class="fa fa-database"></i> Add Source</a></li>';
        else
            $html .= '<li><a href="javascript:void(0)" class="category-load-btn" x="' . $x . '" y="' . $y . '" cid="' . $cid . '" control="add-source" category="' . $category . '" subcategory="' . $subcategory . '"><i class="fa fa-database"></i> Add Source</a></li>';

        if (!$sub)
            $html .= '<li><a href="/forms/community-forms/category-delete?type=category&x=' . $x . '&cid=' . $cid . '"><i class="fa fa-times"></i> Remove</a></li>';
        else
            $html .= '<li><a href="/forms/community-forms/category-delete?type=subcategory&x=' . $x . '&y=' . $y . '&cid=' . $cid . '"><i class="fa fa-times"></i> Remove</a></li>';

        $html .= '</ul></div>';
        $html .= '</label></div><div class="panel-body" style="display:none">';

        return $html;
    }

    public function shiftAll($type, $num, $inc)
    {
        $this->connect();
        if ($type == 'z')
            $this->increment('community_structure', 'iiiii', array($type), array($num, $this->x, $this->y, $this->z, $this->cid), 'where x=? and y=? and z>? and cid=?');
        elseif ($type == 'y')
            $this->increment('community_structure', 'iiii', array($type), array($num, $this->x, $this->y, $this->cid), 'where x=? and y>? and cid=?');
        elseif ($type == 'x')
            $this->increment('community_structure', 'iii', array($type), array($num, $this->x, $this->cid), 'where x>? and cid=?');
        $this->close();
        if ($inc)
            $this->$type++;
    }

    public function swap($x, $y, $z, $direction, $cid)
    {
        $this->connect();
        $rand = -rand(10, 100);
        if (isset($z) && $z > -2) {
            if ($direction == 'up') {
                $this->update('community_structure', 'iiiii', array('z'), array($rand, $x, $y, $z, $cid), 'where x=? and y=? and z=? and cid=?');
                $this->update('community_structure', 'iiiii', array('z'), array($z, $x, $y, $z - 1, $cid), 'where x=? and y=? and z=? and cid=?');
                $this->update('community_structure', 'iiiii', array('z'), array($z - 1, $x, $y, $rand, $cid), 'where x=? and y=? and z=? and cid=?');
            } else {
                $this->update('community_structure', 'iiiii', array('z'), array($rand, $x, $y, $z, $cid), 'where x=? and y=? and z=? and cid=?');
                $this->update('community_structure', 'iiiii', array('z'), array($z, $x, $y, $z + 1, $cid), 'where x=? and y=? and z=? and cid=?');
                $this->update('community_structure', 'iiiii', array('z'), array($z + 1, $x, $y, $rand, $cid), 'where x=? and y=? and z=? and cid=?');
            }
            $this->close();
            return 'source';
        } elseif (isset($y) && $y > -2) {
            if ($direction == 'up') {
                $this->update('community_structure', 'iiii', array('y'), array($rand, $x, $y, $cid), 'where x=? and y=? and cid=?');
                $this->update('community_structure', 'iiii', array('y'), array($y, $x, $y - 1, $cid), 'where x=? and y=? and cid=?');
                $this->update('community_structure', 'iiii', array('y'), array($y - 1, $x, $rand, $cid), 'where x=? and y=? and cid=?');
            } else {
                $this->update('community_structure', 'iiii', array('y'), array($rand, $x, $y, $cid), 'where x=? and y=? and cid=?');
                $this->update('community_structure', 'iiii', array('y'), array($y, $x, $y + 1, $cid), 'where x=? and y=? and cid=?');
                $this->update('community_structure', 'iiii', array('y'), array($y + 1, $x, $rand, $cid), 'where x=? and y=? and cid=?');
            }
            $this->close();
            return 'subcategory';
        } elseif (isset($x) && $x > -2) {
            if ($direction == 'up') {
                $this->update('community_structure', 'iii', array('x'), array($rand, $x, $cid), 'where x=? and cid=?');
                $this->update('community_structure', 'iii', array('x'), array($x, $x - 1, $cid), 'where x=? and cid=?');
                $this->update('community_structure', 'iii', array('x'), array($x - 1, $rand, $cid), 'where x=? and cid=?');
            } else {
                $this->update('community_structure', 'iii', array('x'), array($rand, $x, $cid), 'where x=? and cid=?');
                $this->update('community_structure', 'iii', array('x'), array($x, $x + 1, $cid), 'where x=? and cid=?');
                $this->update('community_structure', 'iii', array('x'), array($x + 1, $rand, $cid), 'where x=? and cid=?');
            }
            $this->close();
            return 'category';
        }
    }

    public function updateName($cid, $type, $pastC, $pastS, $category, $subcategory)
    {
        $this->connect();
        if ($type == 'category-name') {
            $this->update('community_structure', 'ssi', array('category'), array($category, $pastC, $cid), 'where category=? and cid=?');
        } elseif ($type == 'subcategory-name') {
            $this->update('community_structure', 'sssi', array('subcategory'), array($subcategory, $pastC, $pastS, $cid), 'where category=? and subcategory=? and cid=?');
        }
    }

    public function checkName($name, $parent, $cid)
    {
        $this->connect();
        if ($parent)
            $return = $this->select('community_structure', array('id'), 'ssi', array($parent, $name, $cid), 'where category=? and subcategory=? and cid=?');
        else
            $return = $this->select('community_structure', array('id'), 'si', array($name, $cid), 'where category=? and cid=?');
        $this->close();

        if (count($return) > 0)
            return true;
        else
            return false;
    }

}
