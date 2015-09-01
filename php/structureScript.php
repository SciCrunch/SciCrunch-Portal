<?php

include '../classes/classes.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);
$db = new Connection();
$db->connect();
$return = $db->select('community_categories',array('*'),null,array(),'order by id asc');

$nameMap = array();

$cid=0;
$prevCat = '';$prevSub = '';
$x=0;$y=0;$z=0;
if(count($return)>0){
    foreach($return as $row){
        if($cid!=$row['cid']){
            $prevCat = '';
            $x=0;$y=0;
        }
        if($row['category']!=$prevCat && ($row['parent']==null || $row['parent']=='') && $prevCat!=''){
            $x++;
            $y=0;
        } elseif($prevCat != $row['parent'] && $prevCat!=''){
            $y++;
        }
        $cid = $row['cid'];
        $nameMap[(string)$row['name']] = (string)$row['title'];
        $category = new Category();
        $vars = array();
        $vars['cid'] = $row['cid'];
        $vars['uid'] = 451;
        $vars['active'] = 1;
        if(!$row['parent']||$row['parent']==''){
            $prevCat = $row['title'];
            $vars['category'] = $row['title'];
            $vars['subcategory'] = null;
        } else {
            $prevCat = $nameMap[(string)$row['parent']];
            $vars['category'] = $nameMap[(string)$row['parent']];
            $vars['subcategory'] = $row['title'];
        }
        $ids = explode('|',$row['nifIDs']);
        $urls = explode('|',$row['urls']);
        $z = 0;
        foreach($ids as $i=>$id){
            if($id=='')
                continue;
            $vars['x'] = $x;
            $vars['y'] = $y;
            $vars['z'] = $z;
            $vars['source'] = $id;
            $splits = explode('cets=true',$urls[$i]);
            $vars['facet'] = $splits[1];
            $category->createFromRow($vars);
            $category->insertDB();
            $z++;
        }
    }
}


?>