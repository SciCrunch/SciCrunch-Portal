<?php
$holder = new Category();
$return = $holder->getUsed();

$communities = array();
$sources2 = array();
$colors = array();
$who = array();
foreach ($return as $cat) {
    if (!$communities[$cat->cid]) {
        $comm = new Community();
        $comm->getByID($cat->cid);
        $communities[$cat->cid] = $comm;
    }
    if ($communities[$cat->cid]->private == 1)
        continue;
    if (!isset($sources2[$cat->source]) || !in_array($cat->cid, $sources2[$cat->source])) {
        $sources2[$cat->source][] = $cat->cid;
        $colors[$cat->source][] = $communities[$cat->cid]->communityColor();
        $who[$cat->source][] = $communities[$cat->cid];
    }
}

$snippet = new Snippet();
?>
<div class="container content">
    <div class="row">
        <div class="col-md-9">
            <div class="tab-v5">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#sources" role="tab"
                                          data-toggle="tab"><?php echo $community->shortName ?> Sources</a></li>
                    <li><a href="#all" role="tab" data-toggle="tab">All Sources</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade in active" id="sources">

                        <?php

                        foreach ($community->views as $view => $bool) {
                            $sourceNames[$view] = $sources[$view]->getTitle();
                        }
                        asort($sourceNames);
                        foreach ($sourceNames as $view => $name) {

                            $snippet->getSnippetByView($community->id, $view);

                            echo '<div class="row clients-page">';
                            echo '<div class="col-md-2">';
                            if (strlen($sources[$view]->image) > 20)
                                $imageSrc = $sources[$view]->image;
                            else $imageSrc = 'http://nif-dev-web.crbs.ucsd.edu/images/Neurolex_DB_IMAGES_WITH_ID/notfound.gif';
                            echo '<img src="' . $imageSrc . '" class="img-responsive hover-effect" alt="" />';
                            echo '</div>';
                            echo '<div class="col-md-10">';
                            echo '<div class="the-title">';
                            echo '<a href="/' . $community->portalName . '/about/sources/' . $view . '"><h3 style="display:inline-block">' . $name . '</h3></a>';
                            if (count($colors[$view]) > 0) {
                                echo '<div class="circle-container body-hide"><div class="circle" style="display:inline-block;margin-left:10px;vertical-align:middle" id="circle-' . $view . '" num="' . count($colors[$view]) . '" colors="' . join(',', $colors[$view]) . '"></div>';
                                echo '<div class="who-container no-propagation shadow-effect-1"><h3 align="center" style="margin:0;text-decoration: underline">Used in</h3>';
                                foreach ($colors[$view] as $i => $color) {
                                    if ($who[$view][$i]->id == $community->id)
                                        echo '<div><i class="fa fa-square" style="color:' . $color . '"></i> ' . $who[$view][$i]->name . '</div>';
                                    else
                                        echo '<div><a target="_blank" href="/' . $who[$view][$i]->portalName . '"><i class="fa fa-square" style="color:' . $color . '"></i> ' . $who[$view][$i]->name . '</a></div>';
                                }
                                echo '</div></div>';
                            }
                            echo '</div>';
                            echo '
                    <ul class="list-inline">
                        <li><img src="/images/scicrunch.png" style="height:15px;width:15px;padding:0;margin:0;margin-top:-5px;border:0px;background:inherit"/> ' . number_format($sources[$view]->data) . ' records</li>';
                            if (isset($_SESSION['user']) && $_SESSION['user']->levels[$community->id] > 1) {
                                if ($snippet->raw) {
                                    echo '<li><i class="fa fa-check-circle" style="color:#009900"></i> Has Snippet</li>';
                                } else {
                                    echo '<li><i class="fa fa-exclamation-circle" style="color:#990000"></i> No Snippet</li>';
                                }
                            }
                            echo '</ul>';
                            echo '<p>' . $sources[$view]->description . '</p>';
                            echo '</div></div>';
                        }

                        ?>

                    </div>

                    <div class="tab-pane fade" id="all">
                        <?php
                        foreach ($sources as $view => $sour) {

                            $snippet->getSnippetByView($community->id, $view);

                            echo '<div class="row clients-page">';
                            echo '<div class="col-md-2">';
                            if (strlen($sources[$view]->image) > 20)
                                $imageSrc = $sources[$view]->image;
                            else $imageSrc = 'http://nif-dev-web.crbs.ucsd.edu/images/Neurolex_DB_IMAGES_WITH_ID/notfound.gif';
                            echo '<img src="' . $imageSrc . '" class="img-responsive hover-effect" alt="" />';
                            echo '</div>';
                            echo '<div class="col-md-10">';
                            echo '<div class="the-title">';
                            echo '<a href="/' . $community->portalName . '/about/sources/' . $view . '"><h3 style="display:inline-block">' . $sour->getTitle() . '</h3></a>';
                            if (count($colors[$view]) > 0) {
                                echo '<div class="circle-container body-hide"><div class="circle" style="display:inline-block;margin-left:10px;vertical-align:middle" id="circle-' . $view . '-2" num="' . count($colors[$view]) . '" colors="' . join(',', $colors[$view]) . '"></div>';
                                echo '<div class="who-container no-propagation shadow-effect-1"><h3 align="center" style="margin:0;text-decoration: underline">Used in</h3>';
                                foreach ($colors[$view] as $i => $color) {
                                    if ($who[$view][$i]->id == $community->id)
                                        echo '<div><i class="fa fa-square" style="color:' . $color . '"></i> ' . $who[$view][$i]->name . '</div>';
                                    else
                                        echo '<div><a target="_blank" href="/' . $who[$view][$i]->portalName . '"><i class="fa fa-square" style="color:' . $color . '"></i> ' . $who[$view][$i]->name . '</a></div>';
                                }
                                echo '</div></div>';
                            }
                            echo '</div>';
                            echo '
                    <ul class="list-inline">
                        <li><img src="/images/scicrunch.png" style="height:15px;width:15px;padding:0;margin:0;margin-top:-5px;border:0px;background:inherit"/> ' . number_format($sources[$view]->data) . ' records</li>';
                            if (isset($_SESSION['user']) && $_SESSION['user']->role > 0) {
                                if ($snippet->raw) {
                                    echo '<li><i class="fa fa-check-circle" style="color:#009900"></i> Has Snippet</li>';
                                } else {
                                    echo '<li><i class="fa fa-exclamation-circle" style="color:#990000"></i> No Snippet</li>';
                                }
                            }
                            echo '</ul>';
                            echo '<p>' . $sources[$view]->description . '</p>';
                            echo '</div></div>';
                        }

                        ?>
                    </div>
                </div>

                <!-- End Pagination -->
            </div>
        </div>
        <!--/col-md-9-->

        <div class="col-md-3">
            <!-- Our Services -->
            <h1>Category Breakdown</h1>

            <?php
            foreach ($community->urlTree as $category => $arr) {
                $catSources = array();
                if (count($arr['nif']) > 0) {
                    foreach ($arr['nif'] as $view) {
                        $catSources[$view] = $sources[$view]->getTitle();
                    }
                }
                if (count($arr['subcategories']) > 0) {
                    foreach ($arr['subcategories'] as $sub => $array) {
                        foreach ($array['nif'] as $i => $view) {
                            $catSources[$view] = $sources[$view]->getTitle();
                        }
                    }
                }

                echo '<div class="headline" style="margin-top:40px"><a href="/' . $community->portalName . '/' . $category . '/search"><h2>' . $category . '</h2></a></div>';
                asort($catSources);
                foreach ($catSources as $view => $name) {
                    echo '<p><a href="/' . $community->portalName . '/data/source/' . $view . '/search">' . $name . '</a></p>';
                }
            }
            ?>
        </div>
        <!--/col-md-3-->
    </div>
    <!--/row-->
</div>
<!--/container-->
<!--=== End Content Part ===-->