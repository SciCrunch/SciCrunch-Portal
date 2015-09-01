<?php
$holder = new Community();

if(isset($_SESSION['user']))
    $results = $holder->searchCommunities(array_keys($_SESSION['user']->levels),$query, ($page - 1) * 20, 20);
else
    $results = $holder->searchCommunities(false,$query, ($page - 1) * 20, 20);
?>
<span class="results-number">Showing <?php echo count($results['results']) ?>
    out of <?php echo number_format($results['count']) ?> Communities on page <?php echo $page ?></span>
<!-- Begin Inner Results -->

<?php
foreach ($results['results'] as $community) {
    $user = new User();
    $user->getByID($community->uid);
    echo '<div class="inner-results">';
    if($community->private==1)
        echo '<h3><i class="fa fa-lock"></i><a href="/' . $community->portalName . '">' . $community->name . '</a></h3>';
    else
        echo '<h3><a href="/' . $community->portalName . '">' . $community->name . '</a></h3>';
    echo '<ul class="list-inline up-ul">';
    echo '<li>' . $community->url . '‎</li>';
    echo '</ul>';
    echo '<div class="overflow-h">';
    echo '<img src="/upload/community-logo/' . $community->logo . '" alt="">';
    echo '<div class="overflow-a">';
    if ($query && $query != '')
        echo '<p>' . preg_replace('/(' . $query . ')/i', '<b>$1</b>', $community->description) . '</p>';
    else
        echo '<p>' . $community->description . '</p>';
    echo '<ul class="list-inline down-ul">
            <li>' . Connection::longTimeDifference($community->time) . ' - by ' . $user->getFullName() . '</li>';
    echo '</ul>';
    echo '</div></div></div>';
    echo '<hr/>';
}
?>



<div class="margin-bottom-30"></div>

<div class="text-left">
    <?php
    echo '<ul class="pagination">';

    $params = 'query=' . $query;
    $max = ceil($results['count'] / 20);

    if ($page > 1)
        echo '<li><a href="/browse/communities/page/' . ($page - 1) . '?' . $params . '">«</a></li>';
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
        echo '<li><a href="/browse/communities/page/1?' . $params . '">1</a></li>';
        echo '<li><a href="/browse/communities/page/2?' . $params . '">2</a></li>';
        echo '<li><a href="javascript:void(0)">..</a></li>';
    }

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) {
            echo '<li class="active"><a href="javascript:void(0)">' . number_format($i) . '</a></li>';
        } else {
            echo '<li><a href="/browse/communities/page/' . $i . '?' . $params . '">' . number_format($i) . '</a></li>';
        }
    }

    if ($end < $max - 3) {
        echo '<li><a href="javascript:void(0)">..</a></li>';
        echo '<li><a href="/browse/communities/page/' . ($max - 1) . '?' . $params . '">' . number_format($max - 1) . '</a></li>';
        echo '<li><a href="/browse/communities/page/' . $max . '?' . $params . '">' . number_format($max) . '</a></li>';
    }

    if ($page < $max)
        echo '<li><a href="/browse/communities/page/' . ($page + 1) . '?' . $params . '">»</a></li>';
    else
        echo '<li><a href="javascript:void(0)">»</a></li>';


    echo '</ul>';
    ?>
</div>