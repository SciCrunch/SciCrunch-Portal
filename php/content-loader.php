<?php

include '../classes/classes.php';

$cid = filter_var($_GET['cid'], FILTER_SANITIZE_NUMBER_INT);
$comp = filter_var($_GET['comp'], FILTER_SANITIZE_NUMBER_INT);
$num = filter_var($_GET['num'], FILTER_SANITIZE_NUMBER_INT);

$community = new Community();
$community->getByID($cid);

$thisComp = new Component();
$thisComp->getByType($cid, $comp);

$holder = new Component_Data();
$datas = $holder->getByComponentNewest($comp, $cid, $num, 10);

$baseURL = '/' . $community->portalName . '/about/';

if ($thisComp->icon1 == 'timeline1') {
    foreach ($datas as $i => $data) {
        if ($i % 2 == 0)
            echo '<li>';
        else echo '<li class="timeline-inverted">';

        echo '<div class="timeline-badge primarya"><i class="glyphicon glyphicon-record"></i></div>';
        echo '<div class="timeline-panel">';

        if ($data->icon1) {
            echo '<div class="timeline-heading">
                    <img class="img-responsive" src="/upload/component-data/' . $data->icon1 . '" alt=""/>
                </div>';
        }
        echo '<div class="timeline-body text-justify">';
        echo '<h2><a href="/page/' . $thisComp->text2 . '/' . $data->id . '">' . $data->title . '</a></h2>';
        echo '<p>' . $data->description . '</p>';
        echo '<a class="btn-u btn-u-sm" href="' . $baseURL . $thisComp->text2 . '/' . $data->id . '">Read More</a>';
        echo '</div>';

        echo '<div class="timeline-footer">
                    <ul class="list-unstyled list-inline blog-info">
                        <li><i class="fa fa-clock-o"></i> ' . date('h:ia F j, Y', $data->time) . '</li>
                    </ul>
                    <a class="likes" href="' . $baseURL . $thisComp->text2 . '/' . $data->id . '"><i class="fa fa-eye"></i>' . number_format($data->views) . '</a>
                </div>';
    }
} elseif ($thisComp->icon1 == 'timeline2') {
    foreach ($datas as $data) {
        ?>
        <li>
            <time class="cbp_tmtime" datetime="">
                <a href="<?php echo $baseURL . $thisComp->text2 . '/' . $data->id ?>">
                    <span><?php echo date('l', $data->time) . ' the ' . date('jS', $data->time) ?></span><span><?php echo date('F Y', $data->time) ?></span>
                </a>
            </time>
            <i class="cbp_tmicon rounded-x hidden-xs"></i>

            <div class="cbp_tmlabel">
                <h2><a href="<?php echo $baseURL . $thisComp->text2 . '/' . $data->id ?>"><?php echo $data->title ?></a>
                </h2>

                <p><?php echo $data->description ?></p>
            </div>
        </li>
    <?php
    }

}

?>