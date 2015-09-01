<style>
    <?php if($component->color3){?>
    .breadcrumbs-v3 {
        background: <?php echo '#'. $component->color3?>;
    }

    <?php } elseif($component->image){ ?>
    .breadcrumbs-v3 {
        background: url('/upload/community-components/<?php echo $component->image?>') 100% 100% no-repeat;
    }

    <?php } ?>
    <?php if($component->color1){?>
    .breadcrumbs-v3 h1, .breadcrumbs-v3 .breadcrumb li a {
        color: <?php echo '#'. $component->color1?>;
    }

    <?php } ?>
    <?php if($component->color2){?>
    .breadcrumbs-v3 .breadcrumb li a:hover, .breadcrumbs-v3 .breadcrumb li.active {
        color: <?php echo '#'. $component->color2?>;
    }

    <?php } ?>
</style>

<div class="breadcrumbs-v3 <?php if ($vars['editmode']) echo 'editmode' ?>">
    <div class="container">
        <?php
        if(isset($vars['stripped'])&&$vars['stripped']=='true')
            $para = '/stripped';
        else
            $para = '';
        if ($vars['type'] == 'about') {
            if ($vars['title'] == 'sources') {
                echo '<h1 class="pull-left">'.$community->shortName.' Sources</h1>';
                echo '<ul class="pull-right breadcrumb">';
                echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                if ($vars['id']) {
                    echo '<li><a href="/'.$community->portalName.$para.'/about/sources">Our Sources</a></li>';
                    echo '<li class="active">'.$sources[$vars['id']]->getTitle().'</li>';
                } else {
                    echo '<li class="active">Our Sources</li>';
                }
                echo '</ul>';
            } elseif($vars['title']=='registry'){
                if($vars['mode'] && $vars['mode']=='edit'){
                    echo '<h1 class="pull-left">Edit Resource</h1>';
                    echo '<ul class="pull-right breadcrumb">';
                    echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                    echo '<li><a href="/' . $community->portalName.$para . '/about/registry">'.$community->shortName.' Registry</a></li>';
                    echo '<li><a href="/' . $community->portalName.$para . '/about/registry/'.$vars['id'].'">View Resource</a></li>';
                    echo '<li class="active">Edit Resource</li>';
                    echo '</ul>';
                } elseif($vars['id']){
                    echo '<h1 class="pull-left">View Resource</h1>';
                    echo '<ul class="pull-right breadcrumb">';
                    echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                    echo '<li><a href="/' . $community->portalName.$para . '/about/registry">'.$community->shortName.' Registry</a></li>';
                    echo '<li class="active">View Resource</li>';
                    echo '</ul>';
                } else {
                    echo '<h1 class="pull-left">Search through '.$community->shortName.' Resources</h1>';
                    echo '<ul class="pull-right breadcrumb">';
                    echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                    echo '<li class="active">'.$community->shortName.' Registry</li>';
                    echo '</ul>';
                }
            } elseif ($vars['title'] == 'resource' && isset($vars['form'])) {
                echo '<h1 class="pull-left">Add a Resource</h1>';
                echo '<ul class="pull-right breadcrumb">';
                echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                echo '<li><a href="/' . $community->portalName.$para . '/about/resource">Resource Type Select</a></li>';
                echo '<li class="active">Resource Submission</li>';
                echo '</ul>';
            } elseif ($vars['title'] == 'resource' && isset($vars['submit'])) {
                echo '<h1 class="pull-left">Submission Successful</h1>';
                echo '<ul class="pull-right breadcrumb">';
                echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                echo '<li><a href="/' . $community->portalName.$para . '/about/resource">Resource Type Select</a></li>';
                echo '<li class="active">Submission Successful</li>';
                echo '</ul>';
            } elseif ($vars['title'] == 'resource') {
                echo '<h1 class="pull-left">Add a Resource</h1>';
                echo '<ul class="pull-right breadcrumb">';
                echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                echo '<li class="active">Select a Resource Type</li>';
                echo '</ul>';
            } elseif ($vars['title'] == 'search') {
                echo '<h1 class="pull-left">Browse Content</h1>';
                echo '<ul class="pull-right breadcrumb">';
                echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                echo '<li class="active">Browse Content</li>';
                echo '</ul>';
            } elseif ($vars['title'] == 'faq') {
                if ($faq) {
                    echo '<h1 class="pull-left">'.$theTitle.'</h1>';
                    echo '<ul class="pull-right breadcrumb">';
                    echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                    echo '<li><a href="/'.$community->portalName.$para.'/about/faqs">FAQs Home</a></li>';
                    echo '<li class="active">'.$theTitle.'</li>';
                    echo '</ul>';
                } else {
                    echo '<h1 class="pull-left">FAQs Page</h1>';
                    echo '<ul class="pull-right breadcrumb">';
                    echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                    echo '<li class="active">FAQs Page</li>';
                    echo '</ul>';
                }
            } else {
                if ($vars['id']) {
                    echo '<h1 class="pull-left">' . $thisComp->text1 . '</h1>';
                    echo '<ul class="pull-right breadcrumb">';
                    echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                    echo '<li><a href="/' . $community->portalName.$para . '/about/' . $thisComp->text2 . '">' . $thisComp->text1 . '</a></li>';
                    echo '<li class="active">' . $data->title . '</li>';
                    echo '</ul>';
                } else {
                    echo '<h1 class="pull-left">' . $thisComp->text1 . '</h1>';
                    echo '<ul class="pull-right breadcrumb">';
                    echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
                    echo '<li class="active">' . $thisComp->text1 . '</li>';
                    echo '</ul>';
                }
            }
        } elseif(isset($vars['view'])&&isset($vars['uuid'])){
            $holder = new Sources();
            $sources = $holder->getAllSources();
            echo '<h1 class="pull-left">Record View</h1>';
            echo '<ul class="pull-right breadcrumb">';
            echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';

            if ($vars['category']!='data'&&$vars['category']!='literature'&&$vars['category']!='Any') {
                $newVars = $vars;
                $newVars['nif'] = false;
                $newVars['subcategory'] = false;
                $newVars['view'] = false;
                $newVars['uuid'] = false;
                $newVars['category'] = 'Any';
                echo '<li><a href="' . $search->generateURL($newVars) . '">Any</a></li>';
            }

            if ($vars['category']) {
                $newVars = $vars;
                $newVars['nif'] = false;
                $newVars['subcategory'] = false;
                $newVars['view'] = false;
                $newVars['uuid'] = false;
                echo '<li><a href="' . $search->generateURL($newVars) . '">' . $vars['category'] . '</a></li>';
            }

            if ($vars['subcategory']) {
                $newVars = $vars;
                $newVars['nif'] = false;
                $newVars['view'] = false;
                $newVars['uuid'] = false;
                echo '<li><a href="' . $search->generateURL($newVars) . '">' . $vars['subcategory'] . '</a></li>';
            }

            if($vars['nif']){
                $newVars = $vars;
                $newVars['view'] = false;
                $newVars['uuid'] = false;
                echo '<li><a href="' . $search->generateURL($newVars) . '">' . $sources[$vars['nif']]->getTitle() . '</a></li>';
            }

            echo '<li class="active">Record View</li>';

            echo '</ul>';
        } elseif ($vars['nif']) {

            $holder = new Sources();
            $sources = $holder->getAllSources();
            echo '<h1 class="pull-left">' . $sources[$vars['nif']]->getTitle() . '</h1>';
            echo '<ul class="pull-right breadcrumb">';
            echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';

            if ($vars['category']!='data'&&$vars['category']!='literature'&&$vars['category']!='Any') {
                $newVars = $vars;
                $newVars['nif'] = false;
                $newVars['subcategory'] = false;
                $newVars['view'] = false;
                $newVars['uuid'] = false;
                $newVars['category'] = 'Any';
                echo '<li><a href="' . $search->generateURL($newVars) . '">Any</a></li>';
            }

            if ($vars['category']) {
                $newVars = $vars;
                $newVars['nif'] = false;
                $newVars['subcategory'] = false;
                if($vars['category']=='data')
                    echo '<li><a href="' . $search->generateURL($newVars) . '">More Resources</a></li>';
                else
                    echo '<li><a href="' . $search->generateURL($newVars) . '">' . $vars['category'] . '</a></li>';
            }

            if ($vars['subcategory']) {
                $newVars = $vars;
                $newVars['nif'] = false;
                echo '<li><a href="' . $search->generateURL($newVars) . '">' . $vars['subcategory'] . '</a></li>';
            }

            echo '<li class="active">' . $sources[$vars['nif']]->getTitle() . '</li>';

            echo '</ul>';
        } elseif ($vars['subcategory']) {
            echo '<h1 class="pull-left">' . $vars['subcategory'] . '</h1>';
            echo '<ul class="pull-right breadcrumb">';
            echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';

            if ($vars['category']!='data'&&$vars['category']!='literature'&&$vars['category']!='Any') {
                $newVars = $vars;
                $newVars['nif'] = false;
                $newVars['subcategory'] = false;
                $newVars['view'] = false;
                $newVars['uuid'] = false;
                $newVars['category'] = 'Any';
                echo '<li><a href="' . $search->generateURL($newVars) . '">Any</a></li>';
            }

            if ($vars['category']) {
                $newVars = $vars;
                $newVars['subcategory'] = false;
                echo '<li><a href="' . $search->generateURL($newVars) . '">' . $vars['category'] . '</a></li>';
            }

            echo '<li class="active">' . $vars['subcategory'] . '</li>';
            echo '</ul>';
        } elseif ($vars['category'] == 'data') {
            echo '<h1 class="pull-left">More Resources</h1>';
            echo '<ul class="pull-right breadcrumb">';
            echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
            echo '<li class="active">More Resources</li>';
            echo '</ul>';
        } elseif ($vars['category'] == 'literature') {
            echo '<h1 class="pull-left">Literature</h1>';
            echo '<ul class="pull-right breadcrumb">';
            echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';
            echo '<li class="active">Literature</li>';
            echo '</ul>';
        } elseif ($vars['category']) {
            echo '<h1 class="pull-left">' . $vars['category'] . '</h1>';
            echo '<ul class="pull-right breadcrumb">';
            echo '<li><a href="/' . $community->portalName.$para . '">Home</a></li>';


            if ($vars['category']!='data'&&$vars['category']!='literature'&&$vars['category']!='Any') {
                $newVars = $vars;
                $newVars['nif'] = false;
                $newVars['subcategory'] = false;
                $newVars['view'] = false;
                $newVars['uuid'] = false;
                $newVars['category'] = 'Any';
                echo '<li><a href="' . $search->generateURL($newVars) . '">Any</a></li>';
            }

            echo '<li class="active">' . $vars['category'] . '</li>';
            echo '</ul>';
        }

        ?>
    </div>

    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3 style="margin-left:10px;margin-top:10px">' . $component->component_ids[$component->component] . '</h3>';
        echo '<div class="pull-right">';
        echo '<button class="btn-u btn-u-default edit-body-btn" componentType="other" componentID="' . $component->id . '"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button></div>';
        echo '</div>';
    } ?>
</div>