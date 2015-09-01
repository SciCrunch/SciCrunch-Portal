<?php


$theData = new Component_Data();
$theData->getByID($arg3);

$holder = new Extended_Data();
$datas = $holder->getByData($arg3,false);

//print_r($community);

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
    echo Connection::createBreadCrumbs('File Manager',array('Home','Account','Manage SciCrunch'),array($profileBase,$profileBase.'account',$profileBase.'account/scicrunch?tab=content'),'File Manager');
else
    echo Connection::createBreadCrumbs('File Manager',array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=content'),'File Manager');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <div class="profile-body">
                <!--Service Block v3-->
                <?php
                if($community->id==0)
                    echo Connection::createProfileTabs(1,$profileBase.'account/scicrunch',null);
                else
                    echo Connection::createProfileTabs(1,$profileBase.'account/communities/'.$community->portalName,$profileBase);
                ?>

                <div class="pull-right" style="margin-bottom:20px;">
                    <button type="button" class="btn-u btn-u-purple file-add" file="Document"
                            community="<?php echo $community->id ?>"
                            component="<?php echo $component->component ?>">Add Document
                    </button>
                    <button type="button" class="btn-u file-add" file="File" community="<?php echo $community->id ?>"
                            component="<?php echo $component->component ?>">Add File
                    </button>
                </div>

                <!--Table Search v2-->
                <div class="table-search-v2 margin-bottom-20">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>File Name</th>
                                <th class="hidden-sm">Description</th>
                                <th>Extension</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            if (count($datas) > 0) {
                                foreach ($datas as $data) {
                                    echo '<tr>';
                                    echo '<td>' . $data->name . '</td>';
                                    echo '<td class="td-width">';
                                    echo $data->description;
                                    echo '</td>';
                                    echo '<td>'.$data->extension.'</td>';
                                    echo '<td>' . number_format($data->views) . '</td>';
                                    echo '<td><div class="btn-group pull-right" style="margin-top:-4px;">
                                    <button class="btn-u btn-u-default btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                                    <i class="fa fa-cog"></i>
                                    <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                    	<li><a href="/forms/component-forms/extended-data-delete.php?data=' . $data->id . '">
                                    		<i class="fa fa-times"></i>
                                    		Delete
                                    		</a>
                                    	</li>
                                    </ul>
                                    </div>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td>No Files</td><td></td><td></td><td></td></tr>';
                            }

                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--End Table Search v2-->
            </div>
        </div>
    </div>
</div>

<div class="background"></div>
<div class="file-load back-hide no-padding">
    <div class="close dark less-right">X</div>
    <form action="/forms/component-forms/extended-data-add.php?data=<?php echo $arg3?>" method="post"
          class="sky-form create-form" enctype="multipart/form-data">
        <header>
            Add <span class="file-name"></span>
        </header>
        <fieldset>
            <input type="hidden" name="type" class="file-type"/>
            <section>
                <label class="label"><span class="file-name"></span> Name</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" placeholder="Focus to view the tooltip" name="name" required="required">
                    <b class="tooltip tooltip-top-right">The name of the file you are uploading.</b>
                </label>
            </section>
            <section>
                <label class="label">Description</label>
                <label class="textarea">
                    <i class="icon-append fa fa-question-circle"></i>
                    <textarea rows="3" placeholder="Focus to view the tooltip" name="description" required></textarea>
                    <b class="tooltip tooltip-top-right">A Short Description of the <span class="file-name"></span> and what it is used for</b>
                </label>
            </section>
            <section>
                <label class="label">Link to Data</label>
                <label class="input">
                    <i class="icon-append fa fa-question-circle"></i>
                    <input type="text" placeholder="Focus to view the tooltip" name="link">
                    <b class="tooltip tooltip-top-right">The link to the data if you are not uploading it</b>
                </label>
            </section>
            <section>
                <label class="label">File</label>
                <label for="file" class="input input-file">
                    <div class="button"><input type="file" id="file" name="file"
                                               onchange="$(this).parent().next().val($(this).val());">Browse
                    </div>
                    <input type="text" readonly>
                </label>
            </section>
        </fieldset>
        <footer>
            <button class="btn-u btn-u-default" type="submit">Add <span class="file-name"></span></button>
        </footer>
    </form>
</div>
