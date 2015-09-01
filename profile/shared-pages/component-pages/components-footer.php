<?php

include '/vars/dataSource.php';

if(!$community){
$community = new Community();
$community->getByPortalName($arg1);
$community->getCategories();
}

$holder = new Component();
$components = $holder->getByCommunity($community->id);

//print_r($community);

$component = $components['footer'][0];

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

<?php
if($community->id==0)
    echo Connection::createBreadCrumbs('Footer Components',array('Home','Account','Manage SciCrunch','Components'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=appearance',$profileBase.'account/scicrunch/components'),'Footer');
else
    echo Connection::createBreadCrumbs('Footer Components',array('Home','Account','Communities',$community->shortName,'Components'),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=appearance',$profileBase.'account/communities/'.$community->portalName.'/components'),'Footer');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <?php
            if($community->id==0)
                echo Connection::createProfileTabs(2,$profileBase.'account/scicrunch',null);
            else
                echo Connection::createProfileTabs(2,$profileBase.'account/communities/'.$community->portalName,$profileBase);
            ?>

            <form method="post" action="/forms/component-forms/footer-components.php?cid=<?php echo $community->id ?>" id="header-component-form" class="sky-form" enctype="multipart/form-data">
                <div class="row margin-bottom-10">
                    <div class="panel panel-dark">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="display: inline-block"><i class="fa fa-tasks"></i> Footer
                            </h3>
                            <label class="pull-right">Type:
                                <select name="footer-select" class="footer-select" style="color:#000;">
                                    <option value="normal" <?php if($component->component==92) echo 'selected'?>>Normal</option>
                                    <option value="dark" <?php if($component->component==91) echo 'selected'?>>Dark</option>
                                    <option value="light" <?php if($component->component==90) echo 'selected'?>>Light</option>
                                </select>
                            </label>
                        </div>
                        <div class="panel-body">
                            <?php
                            if($component->component==90)
                                $image = 'footer-dark';
                            elseif($component->component==91)
                                $image = 'footer-light';
                            elseif($component->component==92)
                                $image = 'footer-normal';
                            ?>

                            <fieldset>
                                <section>
                                    <label class="label">Template</label>
                                    <img class="img-responsive footer-image" src="/images/components/<?php echo $image ?>.jpg"
                                         style="border: 1px solid #888"/>
                                </section>
                                <section>
                                    <label class="label">About Text</label>

                                        <textarea rows="3" placeholder="Focus to view the tooltip" class="summer-text" name="footer-text2"><?php echo $component->text2 ?></textarea>

                                </section>
                                <section>
                                    <label class="label">Contact Text</label>

                                        <textarea rows="3" placeholder="Focus to view the tooltip" class="summer-text" name="footer-text1"><?php echo $component->text1 ?></textarea>

                                </section>
                                <section>
                                    <label class="label">Link and Header Color</label>
                                    <label class="input">
                                        <i class="icon-prepend fa fa-circle" style="color:<?php echo '#'. $component->color1 ?>"></i>
                                        <i class="icon-append fa fa-question-circle"></i>
                                        <input type="text" name="footer-color1" class="color-input" placeholder="Focus to view the tooltip" value="<?php echo $component->color1 ?>">
                                        <b class="tooltip tooltip-top-right">The Hover color of Links, and underline
                                            color</b>
                                    </label>
                                </section>
                                <section>
                                    <label class="label">Footer Background Color</label>
                                    <label class="input">
                                        <i class="icon-prepend fa fa-circle" style="color:<?php echo '#'. $component->color2 ?>"></i>
                                        <i class="icon-append fa fa-question-circle"></i>
                                        <input type="text" name="footer-color2" class="color-input" placeholder="Focus to view the tooltip" value="<?php echo $component->color2 ?>">
                                        <b class="tooltip tooltip-top-right">The Hover color of Links, and underline
                                            color</b>
                                    </label>
                                </section>
                                <section>
                                    <label class="label">Copyright Background Color</label>
                                    <label class="input">
                                        <i class="icon-prepend fa fa-circle" style="color:<?php echo '#'. $component->color3 ?>"></i>
                                        <i class="icon-append fa fa-question-circle"></i>
                                        <input type="text" name="footer-color3" class="color-input" placeholder="Focus to view the tooltip" value="<?php echo $component->color3 ?>">
                                        <b class="tooltip tooltip-top-right">The Hover color of Links, and underline
                                            color</b>
                                    </label>
                                </section>
                            </fieldset>
                        </div>
                    </div>
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