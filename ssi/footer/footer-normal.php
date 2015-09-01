<div class="footer-default <?php if ($vars['editmode']) echo 'editmode' ?>">
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 md-margin-bottom-40">
                    <!-- About -->
                    <div class="headline"><h2>About</h2></div>
                    <p class="margin-bottom-25 md-margin-bottom-40">
                        <?php echo $component->text2 ?>
                    </p>
                    <!-- End About -->

                    <!-- Monthly Newsletter -->
                    <!--                <div class="headline"><h2>Monthly Newsletter</h2></div>-->
                    <!--                <p>Subscribe to our newsletter and stay up to date with the latest news and deals!</p>-->
                    <!---->
                    <!--                <form class="footer-subsribe">-->
                    <!--                    <div class="input-group">-->
                    <!--                        <input type="text" class="form-control" placeholder="Email Address">                            -->
                    <!--                            <span class="input-group-btn">-->
                    <!--                                <button class="btn-u" type="button">Subscribe</button>-->
                    <!--                            </span>-->
                    <!--                    </div>-->
                    <!--                </form>-->
                    <!-- End Monthly Newsletter -->
                </div>
                <!--/col-md-4-->

                <div class="col-md-4 md-margin-bottom-40">
                    <!-- Recent Blogs -->
                    <div class="posts">
                        <div class="headline"><h2>Recent News Entries</h2></div>
                        <?php
                        $holder = new Component_Data();
                        $datas = $holder->searchAllFromComm('', 0, 0, 3);
                        foreach ($datas['results'] as $data) {
                            $comp = new Component();
                            if ($data->component == 104)
                                $url = '/page/faq/questions/'.$data->id;
                            elseif ($data->component == 105)
                                $url = '/page/faq/tutorials/'.$data->id;
                            else {
                                $comp->getByType(0, $data->component);
                                $url = '/page/'.$comp->text2.'/'.$data->id;
                            }
                            echo '<dl class="dl-horizontal">';
                            if ($data->image)
                                echo '<dt><a href="' . $url . '"><img src="/upload/community-components/' . $data->image . '" alt=""></a></dt>';
                            else
                                echo '<dt><a href="' . $url . '"><img src="/images/scicrunch.png" alt=""></a></dt>';
                            echo '<dd><p><a href="' . $url . '">' . $data->title . '</a></p></dd>';
                            echo '</dl>';
                        }
                        ?>
                    </div>
                    <!-- End Recent Blogs -->
                </div>
                <!--/col-md-4-->

                <div class="col-md-4">
                    <!-- Contact Us -->
                    <div class="headline"><h2>Contact Us</h2></div>
                    <address class="md-margin-bottom-40">
                        <?php echo $component->text1 ?>
                    </address>
                    <!-- End Contact Us -->

                    <!-- Social Links -->
                    <div class="headline"><h2>Stay Connected</h2></div>
                    <ul class="social-icons">
                        <li><a href="#" data-original-title="Feed" class="social_rss"></a></li>
                        <li><a href="#" data-original-title="Facebook" class="social_facebook"></a></li>
                        <li><a href="#" data-original-title="Twitter" class="social_twitter"></a></li>
                        <li><a href="#" data-original-title="Goole Plus" class="social_googleplus"></a></li>
                        <li><a href="#" data-original-title="Pinterest" class="social_pintrest"></a></li>
                        <li><a href="#" data-original-title="Linkedin" class="social_linkedin"></a></li>
                        <li><a href="#" data-original-title="Vimeo" class="social_vimeo"></a></li>
                    </ul>
                    <!-- End Social Links -->
                </div>
                <!--/col-md-4-->
            </div>
        </div>
    </div>
    <!--/footer-->
    <!--=== End Footer ===-->

    <!--=== Copyright ===-->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <a target="_blank" href="/">About SciCrunch</a> | <a href="/page/privacy">Privacy
                            Policy</a> | <a href="/page/terms">Terms of Service</a>
                    </p>
                </div>
                <div class="col-md-6">
                    <a href="index.html">
                        <a href="/" class="pull-right">
                            <h3 class="pull-right" style="display: inline-block;color:#fff">SciCrunch</h3>
                            <img class="pull-right" style="height:30px" src="/images/scicrunch.png" alt="">

                        </a>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if ($vars['editmode']) {
        echo '<div class="body-overlay"><h3>' . $component->component_ids[$component->component] . '</h3>';
        echo '<div class="pull-right">';
        echo '<button class="btn-u btn-u-default edit-body-btn" componentType="other" componentID="' . $component->id . '"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button></div>';
        echo '</div>';
    } ?>
</div>
<div class="notifications">
</div>
<div class="note-load" style="display: none"></div>
<script type="text/javascript">
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='//v2.zopim.com/?2CsONjIPURBMECjYLIRkz9JVf7erv9vw';z.t=+new Date;$.
            type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
    $zopim(function() {
        $zopim.livechat.addTags("zopim", "livechatAPI");
    });
</script>