<?php
$user = new User();
$user->getByID($data->uid);

// prepare some $data to minimize tinkering with blog template
$data->title = $thisComp->text1;
$data->content = $thisComp->text3;
$data->component = $thisComp->component;
$data->uid = $_SESSION['user']->id;

// Get information from Component_Data
$c_data = new Component_Data;
$c_data_array = $c_data->getByLink($thisComp->cid, $thisComp->text2);
list($a, $visibility) = explode(":", $c_data_array[0]->icon);
list($a, $rulesURL) = explode(":", $c_data_array[0]->color);

// put Component_Data into $data for form to use
$data->icon = 'visibility:' . $visibility;
$data->start = $c_data_array[0]->start;
$data->end = $c_data_array[0]->end;
$data->link = $c_data_array[0]->link;
$data->description = $c_data_array[0]->description;
$data->id = $c_data_array[0]->id;
$data->component = $c_data_array[0]->component;

// $thisComp->image acquired from /communities/component-data.php
$data->image = $thisComp->image;
$data->color = $thisComp->color;

// Get RULES information 
$r_data = new Component;
$r_data->getPageByType($thisComp->cid, $rulesURL);

if ($_SESSION['user']->id) {
	$ch_data = new Challenge;
	$isRegistered = $ch_data->checkRegistration($data->uid, $data->component);
} else 
	$isRegistered = "not registered";

	
?>

<!--=== Content Part ===-->
<div class="container content">
    <div class="row blog-page blog-item">
        <!-- Left Sidebar -->
        <div class="col-md-8 md-margin-bottom-60 <?php if($vars['editmode']) echo 'editmode' ?>">
            <!--Blog Post-->
                <div class="blog margin-bottom-40">
<!--                    <h2><?php echo $data->title ?></h2> -->

                    <?php echo $data->content ?>
                </div>
            <!--End Blog Post-->

            <hr>

            <!-- Recent Comments -->

            <!-- End Comment Form -->

            <?php if ($vars['editmode']) {
                echo '<div class="body-overlay"><h3>Article Options</h3>';
                echo '<div class="pull-right">';
                echo '<button class="btn-u btn-u-default edit-body-btn" componentType="data" componentID="'.$data->id.'"><i class="fa fa-cogs"></i><span class="button-text"> Edit</span></button><a href="javascript:void(0)" componentID="'.$data->id.'" community="'.$community->id.'" class="btn-u btn-u-red article-delete-btn"><i class="fa fa-times"></i><span class="button-text"> Delete</span></a></div>';
                echo '</div>';
                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        $tagText[] = $tag->tag;
                    }
                    $tt = join(', ', $tagText);
                } else {
                    $tt = '';
                }

                ?>


                <div class="custom-form back-hide no-padding">
                    <div class="close dark less-right">X</div>
                    <style>
                        .servive-block-default {
                            cursor: pointer;
                        }

                        .panel-dark .panel-heading {
                            background: #555;
                            color: #fff;
                        }
                    </style>
                    <form method="post" action="/forms/component-forms/component-update.php?id=<?php echo $data->id ?>"
                          id="header-component-form" class="sky-form" enctype="multipart/form-data">
                        <div class="row margin-bottom-10">
                            <fieldset>
                                <?php

                                echo $data->getContainerDataForm($thisComp->icon1, $tt);
                                ?>
                            </fieldset>
                        </div>

                        <footer>
                            <button type="submit" class="btn-u btn-u-default" style="width:100%">Submit</button>
                        </footer>
                    </form>
                </div>
                <div class="article-delete back-hide">
                    <div class="close dark">X</div>
                    <h2 style="margin-bottom: 40px">Are you sure you want to delete this article?</h2>
                    <a href="javascript:void(0)" class="btn-u close-btn">No</a>
                    <a href="/forms/component-forms/body-data-delete.php?cid=<?php echo $community->id ?>&component=<?php echo $data->id ?>" class="btn-u btn-u-default" style="">Yes</a>

                </div>
            <?php } ?>
        </div>
        <!-- End Left Sidebar -->

        <!-- Right Sidebar -->
        <div class="col-md-4 magazine-page">

            <!-- Join the Challenge -->
            <?php
            	if (trim($visibility) == 'public'):
            ?>	
            <div class="headline headline-md"><h2>Join the Challenge</h2>
            	<div id="joinchallenge">
            		<?php
						if ($isRegistered == 'registered') {
							echo "You are already registered!";
						} else {
							if (!(isset($_SESSION['user']))):
								echo '<div id="join1">Step 1: Create New D3R Account and/or <a class="btn-login" href="#">Login</a></div>';
							else:
								echo '<div id="join1">Step 1: Create New D3R Account and/or Login</div>';
						?>	
					
						<div id="join2" >Step 2: Read the <a href data-toggle="modal" data-target="#myModal">Rules and Procedures</a></div>
						<div id="join2" >Step 3: </div>

						<div style="padding-left: 50px;">
							<button class="btn btn-info" data-toggle="modal" data-target="#myModal2">Join Challenge</button> 
						</div>                
							<?php                
							endif;
						}	
							?>              
                </div>
            </div>
            <?php 
            	endif;
            ?>	
            <!-- End Join the Challenge -->
        </div>
        <!-- End Right Sidebar -->
    </div>
    <!--/row-->
</div><!--/container-->


<!--=== End Content Part ===-->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $r_data->text1; ?></h4>
      </div>
      <div class="modal-body">
		<?php echo $r_data->text3; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-2" role="dialog" aria-labelledby="myModalLabel2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel2"><?php echo $r_data->text1; ?></h4>
      </div>
      <div class="modal-body">
		<?php echo $r_data->text3; ?>
      </div>
      <div class="modal-footer">
      
<!--		<form method="post" action="/forms/component-forms/challenges.php" id="myForm_" > -->
    <form class="form-horizontal well" data-async data-target="#rating-modal" action="/forms/component-forms/challenges.php" method="POST">
			<input type="hidden" id="component" name="component" value="<?php echo $data->component; ?>" />
			<input type="hidden" id="uid" name="uid" value="<?php echo $data->uid; ?>" />
			<input type="checkbox" id="isAnonymous" name="isAnonymous" value="1" /> <span class="anony">I'd like to remain anonymous</span><br />
			<button class="btn btn-default" id="simple-post">Join Challenge</button>
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
      </div>
    </div>
  </div>
</div>

<!--=== End Modal Part ===-->
