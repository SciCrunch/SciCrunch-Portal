<?php
include '../classes/classes.php';
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$query = rawurldecode($_GET['term']);
$display = rawurldecode($_GET['display']);
$splits = explode('"', $query);
$ids = explode('"', $display);
if(count($splits)>1)
    $text = true;
else
    $text = false;



$spliter = split(':', $splits[count($splits) - 1]);
if (count($spliter) > 1) {
    $file = file_get_contents(APIURL.'/scigraph/vocabulary/autocomplete/' . rawurlencode($spliter[1]) . '.json?category=' . strtolower($spliter[0]));
} else {
    $file = file_get_contents(APIURL.'/scigraph/vocabulary/autocomplete/' . rawurlencode($splits[count($splits) - 1]).'.json');
}

$json = json_decode($file);
//print_r($json);

foreach ($json->list as $t) {
    if (count($spliter) > 1) {
        $splits[count($splits) - 1] = $spliter[0] . ':' . (string) $t->completion;
        $ids[count($splits) - 1] = $spliter[0].':'.(string)$t->concept->fragment;
        $autocomplete[] = array((string) $t->completion, (string) $t->concept->categories[0], (string) $t->concept->fragment, $spliter[0], (string) $t->type, '1', join('"', $splits),$text,join('"',$ids),(string)$t->type);
    } else {
        $splits[count($splits) - 1] = (string) $t->completion;
        $ids[count($splits) - 1] = (string)$t->concept->fragment;
        $autocomplete[] = array((string) $t->completion, (string) $t->concept->categories[0], (string) $t->concept->fragment, '', (string) $t->type, '0', join('"', $splits),$text,join('"',$ids),(string)$t->type);
    }
}
if (count($autocomplete) == 0) {

    $splits = explode(' ', $query);
    $ids = explode(' ', $display);
    $splits2 = explode('+', $splits[count($splits) - 1]);
    $spliter = split(':', $splits2[count($splits2) - 1]);
    if (count($spliter) > 1) {
        $file = file_get_contents(APIURL.'/scigraph/vocabulary/autocomplete/' . rawurlencode($spliter[1]) . '?category=' . strtolower($spliter[0]));
    } else {
        if(count($splits2)>1)
            $file = file_get_contents(APIURL.'/scigraph/vocabulary/autocomplete/' . rawurlencode($splits2[1]).'.json');
        else
            $file = file_get_contents(APIURL.'/scigraph/vocabulary/autocomplete/' . rawurlencode($splits2[0]).'.json');
    }
    $json = json_decode($file);
    foreach ($json->list as $t) {
        if (count($spliter) > 1) {
            if (count($splits2) > 1){
                $splits[count($splits) - 1] = '+' . $spliter[0] . ':' . (string) $t->completion;
                $ids[count($splits) - 1] = '+'.$spliter[0].':'.(string)$t->concept->fragment;
            } else {
                $splits[count($splits) - 1] = $spliter[0] . ':' .(string) $t->completion;
                $ids[count($splits) - 1] = $spliter[0].':'.(string)$t->concept->fragment;
            }
            $autocomplete[] = array((string) $t->completion, (string) $t->concept->categories[0], (string) $t->concept->fragment, $spliter[0], (string) $t->type, '1',join(' ',$splits),$text,join(' ',$ids),(string)$t->type);
        } else {
            if (count($splits2) > 1){
                $splits[count($splits) - 1] = '+' . (string) $t->completion;
                $ids[count($splits) - 1] = '+'.(string)$t->concept->fragment;
            } else {
                $splits[count($splits) - 1] = (string) $t->completion;
                $ids[count($splits) - 1] = (string)$t->concept->fragment;
            }
            $autocomplete[] = array((string) $t->completion, (string) $t->concept->categories[0], (string) $t->concept->fragment, '', (string) $t->type, '0',join(' ',$splits),$text,join(' ',$ids),(string)$t->type);
        }
    }
}
//echo $spliter[0];
echo json_encode($autocomplete);
?>
