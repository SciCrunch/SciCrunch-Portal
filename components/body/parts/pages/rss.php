<?php
header('Content-Type: application/xml; charset=ISO-8859-1');

//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$holder = new Component_Data();
if($thisComp->icon1 == 'event1'){
    $datas = $holder->orderTime($thisComp->component,$community->id);
} else {
    $datas = $holder->getByComponentNewest($thisComp->component, $community->id, 0, 100);
}

$file = '<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">';
$file .= '<channel><title>'.$community->name.' '.$thisComp->text1.'</title>';
$file .= '<link>http://scicrunch.com/'.$community->portalName.'/about/'.$thisComp->text2.'</link>';
$file .= '<description>'.str_replace('&nbsp;',' ',$thisComp->text3).'</description>';
foreach($datas as $data){
    $file .= '<item>';
    $file .= '<title>'.$data->title.'</title>';
    if($data->link){
    $file .= '<link>'.htmlentities($data->link).'</link>';
    $file .= '<guid>'.htmlentities($data->link).'</guid>';
    } else {
        $file .= '<link>http://scicrunch.com/'.$community->portalName.'/about/'.$thisComp->text2.'/'.$data->id.'</link>';
        $file .= '<guid>http://scicrunch.com/'.$community->portalName.'/about/'.$thisComp->text2.'/'.$data->id.'</guid>';
    }
    $extras = '';

    $splits = explode(':',$data->content);

    if($data->content && count($splits)==2 && strlen($data->content)<100)
        $extras .= ' '.str_replace('&nbsp;',' ',$data->content).'.';
    if($data->icon)
        $extras .= ' '.str_replace('&nbsp;',' ',$data->icon).'.';
    if($data->color)
        $extras .= ' '.str_replace('&nbsp;',' ',$data->color).'.';

    $file .= '<description>'.str_replace('&nbsp;',' ',$data->description).$extras.'</description>';
    $file .= '<shortDesc>'.str_replace('&nbsp;',' ',$data->description).'</shortDesc>';

    if($data->content){
        $splits = explode(':',$data->content);
        if(count($splits)>1)
        $file .= '<'.str_replace(' ','_',$splits[0]).'>'.htmlentities(trim($splits[1])).'</'.str_replace(' ','_',$splits[0]).'>';
    }
    if($data->icon){
        $splits = explode(':',$data->icon);
        $file .= '<'.str_replace(' ','_',$splits[0]).'>'.htmlentities(trim($splits[1])).'</'.str_replace(' ','_',$splits[0]).'>';
    }
    if($data->color){
        $splits = explode(':',$data->color);
        $file .= '<'.str_replace(' ','_',$splits[0]).'>'.htmlentities(trim($splits[1])).'</'.str_replace(' ','_',$splits[0]).'>';
    }

    $file .= '</item>';
}
$file .= '</channel></rss>';

//echo $file;
$xml = simplexml_load_string($file);
echo $xml->asXML();

?>