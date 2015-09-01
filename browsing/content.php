<?php
$holder = new Component_Data();
$splits = explode(':', $query);
if (strtolower($splits[0]) == 'tag') {
    $search = $splits[1];
    $theTag = $splits[1];
} else {
    $search = $query;
}

if ($filter) {
    switch ($filter) {
        case 'tutorials':
            $component = 105;
            $title = 'Tutorials';
            break;
        case 'questions':
            $component = 104;
            $title = 'Questions';
            break;
        default:
            $component = $holds->component;
            $title = $holds->text1;
            break;
    }
    if ($theTag)
        $results = $holder->tagSearch($search, 0, $component, (($page - 1) * 20), 20);
    else
        $results = $holder->searchData($search, 0, $component, (($page - 1) * 20), 20);
} else {
    if ($theTag)
        $results = $holder->tagSearch($search, 0, false, (($page - 1) * 20), 20);
    else
        $results = $holder->searchAllFromComm($search, 0, (($page - 1) * 20), 20);

}

?>
<span class="results-number">Showing <?php echo (($page-1)*20+1).' - '.(($page-1)*20+count($results['results'])) ?>
    out of <?php echo number_format($results['count']) ?> Articles on page <?php echo $page ?></span>
<!-- Begin Inner Results -->

<?php
$compList = array();
foreach ($results['results'] as $data) {
    if (isset($compList[$data->component])) {
        $compTitle = $compList[$data->component]['title'];
        $compURL = $compList[$data->component]['url'];
    } else {
        $dataComp = new Component();
        if ($data->component < 200) {
            $compTitle = $dataComp->component_ids[$data->component];
            $compURL = '/browse/content?query=' . $query . '&filter=' . $dataComp->component_urls[$data->component];
        } else {
            $dataComp->getByType(0, $data->component);
            $compTitle = $dataComp->text1;
            $compURL = '/browse/content?query=' . $query . '&filter=' . $dataComp->text2;
        }
        $compList[$data->component] = array('title' => $compTitle, 'url' => $compURL);
    }
    $user = new User();
    $user->getByID($data->uid);
    $tags = $data->getTags();
    echo '<div class="inner-results">';
    echo '<h3><a href="/versions/' . $data->id . '">' . $data->title . '</a></h3>';
    echo '<ul class="list-unstyled list-inline blog-tags">';
    echo '<li><i class="fa fa-tags"></i>';
    if ($filter) {
        $params = '&filter=' . $filter;
    } else {
        $params = '';
    }
    foreach ($tags as $tag) {
        if (($theTag && $theTag == $tag->tag)||($search && $search!=''&&strpos($tag->tag,$search) !== false))
            echo '<a class="active" href="/browse/content?query=tag:' . $tag->tag . $params . '">' . $tag->tag . '</a>';
        else
            echo '<a href="/browse/content?query=tag:' . $tag->tag . $params . '">' . $tag->tag . '</a>';
    }
    echo '</li>‎';
    echo '</ul>';
    echo '<div class="overflow-h">';
    if($search && $search!='')
        echo '<p>' . preg_replace('/('.$search.')/i','<b>$1</b>',$data->description) . '</p>';
    else
        echo '<p>'.$data->description.'</p>';
    echo '<ul class="list-inline down-ul">';
    echo '<li><a href="' . $compURL . '">' . $compTitle . '</a></li>';
    echo '<li>' . Connection::longTimeDifference($data->time) . ' - by ' . $user->getFullName() . '</li>';
    echo '</ul>';
    echo '</div></div>';
    echo '<hr/>';
}
?>



<div class="margin-bottom-30"></div>

<div class="text-left">
    <?php
    echo '<ul class="pagination">';

    if ($filter)
        $params = 'query=' . $query . '&filter=' . $filter;
    else
        $params = 'query=' . $query;
    $max = ceil($results['count'] / 20);

    if ($page > 1)
        echo '<li><a href="/browse/content/page/' . ($page - 1) . '?' . $params . '">«</a></li>';
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
        echo '<li><a href="/browse/content/page/1?' . $params . '">1</a></li>';
        echo '<li><a href="/browse/content/page/2?' . $params . '">2</a></li>';
        echo '<li><a href="javascript:void(0)">..</a></li>';
    }

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            echo '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
        } else {
            echo '<li><a href="/browse/content/page/' . $i . '?' . $params . '">' . number_format($i) . '</a></li>';
        }
    }

    if ($end < $max - 3) {
        echo '<li><a href="javascript:void(0)">..</a></li>';
        echo '<li><a href="/browse/content/page/' . ($max - 1) . '?' . $params . '">' . number_format($max - 1) . '</a></li>';
        echo '<li><a href="/browse/content/page/' . $max . '?' . $params . '">' . number_format($max) . '</a></li>';
    }

    if ($page < $max)
        echo '<li><a href="/browse/content/page/' . ($page + 1) . '?' . $params . '">»</a></li>';
    else
        echo '<li><a href="javascript:void(0)">»</a></li>';


    echo '</ul>';
    ?>
</div>