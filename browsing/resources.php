<?php

$holder = new Resource();
$role = $_SESSION['user'] ? $_SESSION['user']->role : 0;
$results = $holder->searchColumns($query, ($page - 1) * 20, 20, $fields,$facets,$statusVar);	// last 2 arguments don't matter for old method


?>
<span class="results-number">Showing <?php echo count($results['results']) ?>
    out of <?php echo number_format($results['count']) ?> Resources on page <?php echo $page ?></span>
<!-- Begin Inner Results -->

<?php
function word_map($a) {
    return '\b' . preg_quote($a, "~") . '\b';
}

$comms = array();
$firstComm = new Community();
$firstComm->name = 'SciCrunch';
$firstComm->id = 0;
$comms[0] = $firstComm;

if(count($results['results']) > 0){
    foreach ($results['results'] as $data) {
        $user = new User();
        $user->getByID($data->uid);
        echo '<div class="inner-results">';
    
        $splits = explode(' ', $query);
    
        $str = preg_replace("~(" . implode("|", array_map('word_map', $splits)) . ")~i", "<strong>$1</strong>", $data->columns['Resource Name']);
        echo '<h3><a href="/browse/resources/' . $data->rid . '">' . $str . '</a>';
        if(isset($_SESSION['user']) && $_SESSION['user']->role>0) echo ' <span style="color:#aaa">(Score = '.$data->score.')</span>';
        echo '</h3>';
        echo '<div class="overflow-h">';
        $str = preg_replace("~(" . implode("|", array_map('word_map', $splits)) . ")~i", "<strong>$1</strong>", $data->columns['Description']);
        echo '<p>' . $str . '</p>';
        echo '<ul class="list-inline down-ul">';
        echo '<li>'.$data->type.'</li>';
        if(isset($comms[$data->cid])){
            $newComm = $comms[$data->cid];
        } else {
            $newComm = new Community();
            $newComm->getByID($data->cid);
            $comms[$data->cid] = $newComm;
        }
        if($newComm->id==0){
            echo '<li>'.$newComm->name.'</li>';
        } else {
            echo '<li><a href="/'.$newComm->portalName.'">'.$newComm->shortName.'</a></li>';
        }
        if ($data->uid == 0)
            echo '<li>' . Connection::longTimeDifference($data->insert_time) . ' - by Anonymous</li>';
        else
            echo '<li>' . Connection::longTimeDifference($data->insert_time) . ' - by ' . $user->getFullName() . '</li>';
        if(isset($_SESSION['user']) && $_SESSION['user']->role>0){
            echo '<li>Curation Status: '.$data->status.'</li>';
        }
        echo '</ul>';
        echo '</div></div>';
        echo '<hr/>';
    }
}
?>


<div class="margin-bottom-30"></div>

<div class="text-left">
    <?php
    echo '<ul class="pagination">';

    $params = 'query=' . $query;
    if($statusVar) $params .= "&status=" . $statusVar;
    $max = ceil($results['count'] / 20);

    if ($page > 1)
        echo '<li><a href="/browse/resources/page/' . ($page - 1) . '?' . $params . '">«</a></li>';
    else
        echo '<li><a href="javascript:void(0)">«</a></li>';

    if ($page - 3 > 0) {
        $start = $page - 3;
    } else
        $start = 1;
    if ($page + 3 < $max) {
        $end = $page + 3;
    } else
        $end = $max;

    if ($start > 2) {
        echo '<li><a href="/browse/resources/page/1?' . $params . '">1</a></li>';
        echo '<li><a href="/browse/resources/page/2?' . $params . '">2</a></li>';
        echo '<li><a href="javascript:void(0)">..</a></li>';
    }

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            echo '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
        } else {
            echo '<li><a href="/browse/resources/page/' . $i . '?' . $params . '">' . number_format($i) . '</a></li>';
        }
    }

    if ($end < $max - 3) {
        echo '<li><a href="javascript:void(0)">..</a></li>';
        echo '<li><a href="/browse/resources/page/' . ($max - 1) . '?' . $params . '">' . number_format($max - 1) . '</a></li>';
        echo '<li><a href="/browse/resources/page/' . $max . '?' . $params . '">' . number_format($max) . '</a></li>';
    }

    if ($page < $max)
        echo '<li><a href="/browse/resources/page/' . ($page + 1) . '?' . $params . '">»</a></li>';
    else
        echo '<li><a href="javascript:void(0)">»</a></li>';


    echo '</ul>';
    ?>
</div>
