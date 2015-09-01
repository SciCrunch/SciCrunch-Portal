<?php

include '../classes/classes.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

set_time_limit(600);

$db = new Connection();
$db->connect();
$return = $db->select('resources',array('*'),null,array(),'');
//$return = $db->select('resources',array('*'),null,array(),'where original_id="nlx_inv_1005082" or original_id="nif-0000-10208" or original_id="nlx_145859" or original_id="nlx_145380"');
$db->close();

$file = "e_uid\tresource_name\tabbrev\tdescription\tcurationstatus\turl\tresource_type\tparent_organization\tdate_updated\tsupercategory\tsynonym\n";
if(count($return)>0){
    foreach($return as $row){
        $resource = new Resource();
        $resource->createFromRow($row);
        $resource->getColumns();

        //echo rawurlencode($resource->columns['Description']);
        //echo "\n\n";

        $file .= $resource->original_id."\t\"".str_replace('"','\\"',$resource->columns['Resource Name'])."\"\t";
        if($resource->columns['Abbreviation']==null || $resource->columns['Abbreviation']=='')
            $file .= "NULL\t";
        else
            $file .= "\"".$resource->columns['Abbreviation']."\"\t";
        if($resource->columns['Description']==null || $resource->columns['Description']=='')
            $file .= "NULL\t";
        else
            $file .= "\"".str_replace('"','\\"',str_replace("\r"," ",str_replace("\n"," ",strip_tags($resource->columns['Description']))))."\"\t";
        if($resource->columns['Curation Status']==null || $resource->columns['Curation Status']=='')
            $file .= "NULL\t";
        else
            $file .= str_replace("\n"," ",str_replace("\n"," ",$resource->columns['Curation Status']))."\t";
        if($resource->columns['Resource URL']==null || $resource->columns['Resource URL']=='')
            $file .= "NULL\t";
        else
            $file .= str_replace("\r"," ",str_replace("\n"," ",$resource->columns['Resource URL']))."\t";
        if($resource->columns['Resource Type']==null || $resource->columns['Resource Type']=='')
            $file .= "NULL\t";
        else
            $file .= "\"".str_replace("\r"," ",str_replace("\n"," ",$resource->columns['Resource Type']))."\"\t";
        if($resource->columns['Parent Organization']==null || $resource->columns['Parent Organization']=='')
            $file .= "NULL\t";
        else
            $file .= "\"".str_replace("\r"," ",str_replace("\n"," ",$resource->columns['Parent Organization']))."\"\t";
        if($resource->edit_time==null)
            $file .= "NULL\t";
        else
            $file .= date("H:i:s m:d:Y",$resource->edit_time)."\t";
        if($resource->columns['Supercategory']==null || $resource->columns['Supercategory']=='')
            $file .= "NULL\t";
        else
            $file .= $resource->columns['Supercategory']."\t";
        if($resource->columns['Synonyms']==null || $resource->columns['Synonyms']=='')
            $file .= "NULL";
        else
            $file .= "\"".str_replace("\r"," ",str_replace("\n"," ",$resource->columns['Synonyms']))."\"";
        $file .= "\n";
    }
}
echo file_put_contents('registry.tsv',$file);

?>