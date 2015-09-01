
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-34153437-2', 'auto');
    ga('send', 'pageview');

</script>
<?php if (!isset($_SESSION['user'])) { ?>
    <li><a href="#" class="btn-login">Login</a></li>
    <li><a href="/<?php echo $community->portalName ?>/join">Register</a></li>
<?php } else { ?>
    <?php
    if ($_SESSION['user']->levels[$community->id] > 1) {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $splits = explode('&', $actual_link);
        if (count($splits) > 1) {
            $base = str_replace('&editmode=true', '', $actual_link);
            $url = str_replace('&editmode=true', '', $actual_link) . '&';
        } else {
            $base = str_replace('?editmode=true', '', $actual_link);
            $url = '?';
        }
        if ($vars['editmode']) {
            if ($tab == 0 && $hl_sub == 0)
                echo '<li><a href="javascript:void(0)" class="component-add"><i class="fa fa-plus"></i> Add Component</a></li>';
            echo '<li><a href="' . $base . '"><i class="fa fa-times"></i> Exit Edit Mode</a></li>';
        } else
            echo '<li><a href="' . $url . 'editmode=true">Edit Mode</a></li>';
    }
    if ($_SESSION['user']->levels[$community->id] < 1) {
        echo '<li><a href="/forms/login.php?join=true&cid=' . $community->id . '">Join Community</a></li>';
    } else {
        echo '<li><a href="javascript:void(0)" class="simple-toggle" modal=".leave-comm">Leave Community</a></li>';
    }
    ?>
    <li><a href="/forms/logout.php">Logout</a></li>
<?php } ?>
