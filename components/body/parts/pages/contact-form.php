<!-- Google Map -->
<?php
if($thisComp->image){
    $splits = explode(':',$thisComp->image);
    $lat = $splits[0];
    $lng = $splits[1];
} else {
    $lat = 0;
    $lng = 0;
}
?>
<!---/map-->
<!-- End Google Map -->

<!--=== Content Part ===-->
<div class="container content">
    <div class="row margin-bottom-30">
        <div class="col-md-9 mb-margin-bottom-30">
            <div class="headline"><h2>Contact Form</h2></div>
            <p><?php echo $thisComp->text3 ?></p><br/>

            <form class="captcha-form" action="/forms/community-forms/contact-community.php?cid=<?php echo $community->id ?>" method="post">
                <label>Name</label>

                <div class="row margin-bottom-20">
                    <div class="col-md-7 col-md-offset-0">
                        <input type="text" name="name" <?php if(isset($_SESSION['user'])) echo 'value="'.$_SESSION['user']->getFullName().'"' ?> class="form-control">
                    </div>
                </div>

                <label>Email <span class="color-red">*</span></label>

                <div class="row margin-bottom-20">
                    <div class="col-md-7 col-md-offset-0">
                        <input type="text" name="email" class="form-control" <?php if(isset($_SESSION['user'])) echo 'value="'.$_SESSION['user']->email.'"' ?>>
                    </div>
                </div>

                <label>Message</label>

                <div class="row margin-bottom-20">
                    <div class="col-md-11 col-md-offset-0">
                        <textarea rows="8" name="message" class="form-control"></textarea>
                    </div>
                </div>

                <div class="g-recaptcha"
                     data-sitekey="recaptcha_site_key"></div>

                <br/>
                <p>
                    <button type="submit" class="btn-u">Send Message</button>
                </p>
            </form>
        </div>
        <!--/col-md-9-->

        <div class="col-md-3">
            <div id="map" class="map" lat="<?php echo $lat?>" lng="<?php echo $lng?>" addr="<?php echo $thisComp->color1 ?>">
            </div>
            <!-- Contacts -->
            <div class="headline"><h2>Contacts</h2></div>
            <?php echo $thisComp->color2 ?>

			<?php if (!(  (empty($thisComp->color3)) || ($thisComp->color3 == '<p><br></p>')  )): ?>
            <!-- Business Hours -->
            <div class="headline"><h2>Business Hours</h2></div>
            <?php echo $thisComp->color3;
            	endif;
            ?>

        </div>
        <!--/col-md-3-->
    </div>
    <!--/row-->
</div>
