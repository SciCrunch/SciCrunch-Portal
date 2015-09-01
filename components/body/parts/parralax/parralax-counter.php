<style>
    <?php if($component->image){ ?>
    .parallax-counter {
        background:url('/upload/community-components/<?php echo $component->image ?>') 50% 0 fixed;
    }
    <?php } else { ?>
    .parallax-counter {
        background:url('/upload/community-components/default-11.jpg') 50% 0 fixed;
    }
    <?php } ?>
    .parallax-counter span.counter {
        font-size: 38px;
    }
</style>

<?php
if($community->id==0){
    include $_SERVER['DOCUMENT_ROOT'] . '/vars/overview.php';
}
?>

<!--=== Parallax Counter ===-->
<div class="parallax-counter parallaxBg <?php if($vars['editmode']) echo 'editmode' ?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <div class="counters">
                    <?php if($community->id==0){
                        $holder = new Community();
                        $count = $holder->getCommCount();
                        ?>
                        <span class="counter"><?php echo number_format($count) ?></span>
                        <h4>Communities</h4>
                    <?php } else { ?>
                    <span class="counter"><?php echo number_format(count($community->views)) ?></span>
                    <h4>Data Sources</h4>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="counters">
                    <?php if($community->id==0){
                        $holder = new User();
                        $count = $holder->getUserCount();
                        ?>
                        <span class="counter"><?php echo number_format($count) ?></span>
                        <h4>Users</h4>
                    <?php } else {
                        $count = $community->getUserCount();?>
                    <span class="counter"><?php echo number_format($count) ?></span>
                    <h4>Users</h4>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="counters">
                    <?php if($community->id==0){
                        ?>
                        <span class="counter"><?php echo number_format($stats['data']) ?></span>
                        <h4>Data</h4>
                    <?php } else {
                        $holder = new Component_Data();
                    $count = $holder->getCountByComm($community->id)?>
                    <span class="counter"><?php echo number_format($count) ?></span>
                    <h4>Articles</h4>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div class="counters">
                    <?php if($community->id==0){
                        ?>
                        <span class="counter"><?php echo number_format($stats['resources']) ?></span>
                        <h4>Resources</h4>
                    <?php } else {
                        $holder = new Resource();
                        $count = $holder->getResourceCountByComm($community->id);?>
                    <span class="counter"><?php echo number_format($count) ?></span>
                    <h4>Resources</h4>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>' . $component->component_ids[$component->component] . '</h3>';
        echo '<div class="pull-right">';
        if ($componentCount > 0)
            echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=up"><i class="fa fa-angle-up"></i><span class="button-text"> Shift Up</span></a>';
        if ($componentCount != $componentTotal - 1)
            echo '<a class="btn-u btn-u-blue" href="/forms/component-forms/body-component-shift.php?component=' . $component->id . '&cid=' . $component->cid . '&direction=down"><i class="fa fa-angle-down"></i><span class="button-text"> Shift Down</span></a>';
        echo '<button class="btn-u btn-u-default edit-body-btn" componentType="body" componentID="'.$component->id.'"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="'.$component->id.'" community="'.$community->id.'" class="btn-u btn-u-red component-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
        echo '</div>';
    } ?>
</div>
<!--=== End Parallax Counter ===-->