<?php

include '/vars/dataSource.php';

if (!$community) {
    $community = new Community();
    $community->getByPortalName($arg1);
    $community->getCategories();
}

$holder = new Component();
$components = $holder->getByCommunity($community->id);

//print_r($community);

if ($components['header'][0]->component == 0) $image = 'header-normal';
elseif ($components['header'][0]->component == 1) $image = 'header-boxed';
elseif ($components['header'][0]->component == 2) $image = 'header-float';

function createBreadCrumbsComponentHeader($community, $profileBase){
    if($community->id==0){	// scicrunch community
        echo Connection::createBreadCrumbs('Header Components',array('Home','Account','Manage SciCrunch','Components'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=appearance',$profileBase.'account/scicrunch/components'),'Header');
    }else{
    echo Connection::createBreadCrumbs('Header Components',array('Home','Account','Communities',$community->shortName,'Components'),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=appearance',$profileBase.'account/communities/'.$community->portalName.'/components'),'Header');
    }
}

function createProfileTabsComponentHeader($community, $profileBase){
    if($community->id==0) echo Connection::createProfileTabs(2,$profileBase.'account/scicrunch',null);
    else echo Connection::createProfileTabs(2,$profileBase.'account/communities/'.$community->portalName,$profileBase);
}

########################################################################################################################################################################################################
########################################################################################################################################################################################################
?>
<style>
    .servive-block-default {
        cursor: pointer;
    }

    .panel-dark .panel-heading {
        background: #555;
        color: #fff;
    }
</style>

<?php createBreadCrumbsComponentHeader($community, $profileBase); ?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <?php createProfileTabsComponentHeader($community, $profileBase); ?>
            <form method="post" action="/forms/component-forms/header-components.php?cid=<?php echo $community->id ?>"
                  id="header-component-form" class="sky-form" enctype="multipart/form-data">
                <div class="row margin-bottom-10">
                    <div class="panel panel-dark">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i> Header
                            </h3>
                            <label class="pull-right">Type:
                                <select name="header-select" class="header-select" style="color:#000;">
                                    <option
                                        value="normal" <?php if ($components['header'][0]->component == 0) echo 'selected' ?>>
                                        Normal
                                    </option>
                                    <option
                                        value="boxed" <?php if ($components['header'][0]->component == 1) echo 'selected' ?>>
                                        Boxed
                                    </option>
                                    <option
                                        value="float" <?php if ($components['header'][0]->component == 2) echo 'selected' ?>>
                                        Float
                                    </option>
                                </select>
                            </label>
                        </div>
                        <div class="panel-body">
                            <fieldset>
                                <section>
                                    <label class="label">Template</label>
                                    <img class="img-responsive header-image"
                                         src="/images/components/<?php echo $image ?>.png"
                                         style="border: 1px solid #888"/>
                                </section>
                                <section>
                                    <label class="label">Highlight Color</label>
                                    <label class="input">
                                        <i class="icon-prepend fa fa-circle"
                                           style="color:<?php echo '#' . $components['header'][0]->color1 ?>"></i>
                                        <i class="icon-append fa fa-question-circle"></i>
                                        <input type="text" name="header-color1" class="color-input"
                                               placeholder="Focus to view the tooltip"
                                               value="<?php echo $components['header'][0]->color1 ?>">
                                        <b class="tooltip tooltip-top-right">The Hover color of Links, and underline
                                            color</b>
                                    </label>
                                </section>
                                <section>
                                    <label class="label">Logo to text</label>
                                    <label class="checkbox"><input type="checkbox" name="logosize" <?php if($components['header'][0]->icon1 == 'large') echo ' checked="checked"' ?>/><i></i>Large logo</label>
                                </section>
                            </fieldset>
                        </div>
                    </div>
                    <hr/>
                    <?php if ($community->id != 0) { ?>
                        <div class="panel panel-dark">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i>
                                    Breadcrumbs</h3>
                                <label class="pull-right toggle"><input type="checkbox"
                                                                        name="breadcrumbs-toggle" <?php if ($components['breadcrumbs'][0]->disabled == 0) echo 'checked' ?>><i
                                        class="rounded-4x"></i></label>
                            </div>
                            <div class="panel-body">
                                <fieldset>
                                    <section>
                                        <label class="label">Template</label>
                                        <img class="img-responsive" src="/images/components/breadcrumbs.png"
                                             style="border: 1px solid #888"/>
                                    </section>
                                    <section>
                                        <label class="label">Background Image</label>
                                        <label for="file" class="input input-file">
                                            <div class="button"><input name="breadcrumbs-image" type="file" id="file"
                                                                       onchange="this.parentNode.nextSibling.value = this.value">Browse
                                            </div>
                                            <input type="text" readonly
                                                   value="<?php echo $components['breadcrumbs'][0]->image ?>">
                                        </label>
                                    </section>
                                    <section>
                                        <label class="label">Background Color (Overrides Image)</label>
                                        <label class="input">
                                            <i class="icon-prepend fa fa-circle"
                                               style="color:<?php echo '#' . $components['breadcrumbs'][0]->color3 ?>"></i>
                                            <i class="icon-append fa fa-question-circle"></i>
                                            <input type="text" name="breadcrumbs-color3" class="color-input"
                                                   placeholder="Focus to view the tooltip"
                                                   value="<?php echo $components['breadcrumbs'][0]->color3 ?>">
                                            <b class="tooltip tooltip-top-right">The Background Color of the breadcrumbs
                                                section. Will override the image, leave empty if you want an image.</b>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="label">Text Color</label>
                                        <label class="input">
                                            <i class="icon-prepend fa fa-circle"
                                               style="color:<?php echo '#' . $components['breadcrumbs'][0]->color1 ?>"></i>
                                            <i class="icon-append fa fa-question-circle"></i>
                                            <input type="text" name="breadcrumbs-color1" class="color-input"
                                                   placeholder="Focus to view the tooltip"
                                                   value="<?php echo $components['breadcrumbs'][0]->color1 ?>">
                                            <b class="tooltip tooltip-top-right">The general text color of the
                                                breadcrumbs section</b>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="label">Highlight Color</label>
                                        <label class="input">
                                            <i class="icon-prepend fa fa-circle"
                                               style="color:<?php echo '#' . $components['breadcrumbs'][0]->color2 ?>"></i>
                                            <i class="icon-append fa fa-question-circle"></i>
                                            <input type="text" name="breadcrumbs-color2" class="color-input"
                                                   placeholder="Focus to view the tooltip"
                                                   value="<?php echo $components['breadcrumbs'][0]->color2 ?>">
                                            <b class="tooltip tooltip-top-right">The Color of the text for the page you
                                                are currently on.</b>
                                        </label>
                                    </section>
                                </fieldset>
                            </div>
                        </div>
                        <hr/>
                        <div class="panel panel-dark">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i> Search
                                    Box
                                </h3>
                                <label class="pull-right toggle"><input type="checkbox"
                                                                        name="search-toggle" <?php if ($components['search'][0]->disabled == 0) echo 'checked' ?>><i
                                        class="rounded-4x"></i></label>
                            </div>
                            <div class="panel-body">
                                <fieldset>
                                    <section>
                                        <label class="label">Template</label>
                                        <img class="img-responsive" src="/images/components/search-block.png"
                                             style="border: 1px solid #888"/>
                                    </section>
                                    <section>
                                        <label class="label">Search Box Text</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-question-circle"></i>
                                            <input type="text" name="search-text1"
                                                   placeholder="Focus to view the tooltip"
                                                   value="<?php echo $components['search'][0]->text1 ?>">
                                            <b class="tooltip tooltip-top-right">The Text shown above the search
                                                bar.</b>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="label">Search Box Text</label>
                                        <label class="input">
                                            <i class="icon-append fa fa-question-circle"></i>
                                            <input type="text" name="search-text2"
                                                   placeholder="Focus to view the tooltip"
                                                   value="<?php echo $components['search'][0]->text2 ?>">
                                            <b class="tooltip tooltip-top-right">The search tips text below the search
                                                box.</b>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="label">Text Color</label>
                                        <label class="input">
                                            <i class="icon-prepend fa fa-circle"
                                               style="color:<?php echo '#' . $components['search'][0]->color1 ?>"></i>
                                            <i class="icon-append fa fa-question-circle"></i>
                                            <input type="text" name="search-color1" class="color-input"
                                                   placeholder="Focus to view the tooltip"
                                                   value="<?php echo $components['search'][0]->color1 ?>">
                                            <b class="tooltip tooltip-top-right">Color of the text above the search
                                                bar</b>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="label">Icon Background Color</label>
                                        <label class="input">
                                            <i class="icon-prepend fa fa-circle"
                                               style="color:<?php echo '#' . $components['search'][0]->color2 ?>"></i>
                                            <i class="icon-append fa fa-question-circle"></i>
                                            <input type="text" name="search-color2" class="color-input"
                                                   placeholder="Focus to view the tooltip"
                                                   value="<?php echo $components['search'][0]->color2 ?>">
                                            <b class="tooltip tooltip-top-right">The Background Color of the search
                                                icon.</b>
                                        </label>
                                    </section>
                                </fieldset>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <footer>
                    <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                </footer>
            </form>

            <!--End Profile Body-->
        </div>
    </div>
    <!--/end row-->
</div><!--/container-->

<!--=== End Profile ===-->
