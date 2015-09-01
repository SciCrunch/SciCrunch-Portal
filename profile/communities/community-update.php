<?php

include 'vars/dataSource.php';

$community->getCategories();

if (!$section) {
    $section = 'information';
}

//print_r($community);

?>
<?php
echo Connection::createBreadCrumbs('Update '.$community->shortName,array('Home','Account','Communities',$community->shortName),array($profileBase,$profileBase.'account',$profileBase.'account/communities',$profileBase.'account/communities/'.$community->portalName.'?tab=information'),'Update');
?>
<div class="profile container content">
    <div class="row">
        <!--Left Sidebar-->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/profile/left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <?php echo Connection::createProfileTabs(0,$profileBase.'account/communities/'.$community->portalName,$profileBase); ?>
            <form action="/forms/community-forms/edit-community.php?cid=<?php echo $community->id?>" method="post" class="sky-form create-form" enctype="multipart/form-data">

                <fieldset>
                    <section>
                        <label class="label">Full Community Name</label>
                        <label class="input">
                            <i class="icon-prepend fa fa-asterisk" style="color:#bb0000"></i>
                            <i class="icon-append fa fa-question-circle"></i>
                            <input type="text" placeholder="Focus to view the tooltip" required="required" name="name"
                                   value="<?php echo $community->name ?>">
                            <b class="tooltip tooltip-top-right">The full name of your community</b>
                        </label>
                    </section>
                    <section>
                        <label class="label">Short Community Name</label>
                        <label class="input">
                            <i class="icon-prepend fa fa-asterisk" style="color:#bb0000"></i>
                            <i class="icon-append fa fa-question-circle"></i>
                            <input type="text" placeholder="Focus to view the tooltip" name="short"
                                   value="<?php echo $community->shortName ?>">
                            <b class="tooltip tooltip-top-right">An Abbreviation or shortened name to use for your
                                community. Will not update the url.</b>
                        </label>
                    </section>
                    <section>
                        <label class="label">Description</label>
                        <label class="textarea">
                            <i class="icon-prepend fa fa-asterisk" style="color:#bb0000"></i>
                            <i class="icon-append fa fa-question-circle"></i>
                            <textarea rows="3" placeholder="Focus to view the tooltip"
                                      name="description"><?php echo $community->description ?></textarea>
                            <b class="tooltip tooltip-top-right">A few sentences describing your community and what it
                                does</b>
                        </label>
                    </section>
                </fieldset>

                <fieldset>
                    <section>
                        <label class="label">Community Website</label>
                        <label class="input">
                            <i class="icon-append fa fa-question-circle"></i>
                            <input type="url" name="url" placeholder="Focus to view the tooltip"
                                   value="<?php echo $community->url ?>">
                            <b class="tooltip tooltip-top-right">The URL of your community's website</b>
                        </label>
                    </section>
                    <section>
                        <label class="label">Who Can Join this Community?</label>
                        <label class="select">
                            <i class="icon-append fa fa-question-circle"></i>
                            <select name="join">
                                <option value="0" <?php if ($community->access == 0) echo 'selected' ?>>Everyone
                                </option>
                                <option value="1" <?php if ($community->access == 1) echo 'selected' ?>>Can Request
                                    Access
                                </option>
                                <option value="2" <?php if ($community->access == 2) echo 'selected' ?>>Invite Only
                                </option>
                                <option value="3" <?php if ($community->access == 3) echo 'selected' ?>>No One</option>
                            </select>
                            <b class="tooltip tooltip-top-right">This will affect who can join your community through
                                SciCrunch</b>
                        </label>
                    </section>
                </fieldset>

                <fieldset>
                    <div class="row">
                        <section class="col col-3">
                            <label class="label">Current Logo</label>

                            <div class="current-logo">
                                <img src="/upload/community-logo/<?php echo $community->logo?>"/>
                            </div>
                        </section>
                        <section class="col col-9">
                            <label class="label">Logo</label>
                            <label for="file" class="input input-file">
                                <div class="button"><input type="file" id="file" name="file"
                                                           onchange="$(this).parent().next().val($(this).val())">Browse
                                </div>
                                <input type="text" readonly value="<?php echo $community->logo ?>">
                            </label>
                        </section>
                    </div>
                </fieldset>
                <fieldset>
                    <section>
                        <label class="label">Privacy Setting</label>
                        <label class="select">
                            <i class="icon-append fa fa-question-circle"></i>
                            <select name="private">
                                <option value="0" <?php if ($community->private == 0) echo 'selected' ?>>Open To All
                                </option>
                                <option value="1" <?php if ($community->private == 1) echo 'selected' ?>>Closed To All
                                    but Current Members
                                </option>
                            </select>
                        </label>
                    </section>
                    <section>
                        <label class="label">Data Views</label>

                        <div class="row">
                            <div class="col col-4">
                                <label class="checkbox"><input type="checkbox" name="resource" <?php if($community->resourceView) echo 'checked="checked"'?>><i></i>Community Resources</label>
                            </div>
                            <div class="col col-4">
                                <label class="checkbox"><input type="checkbox" name="data" <?php if($community->dataView) echo 'checked="checked"'?>><i></i>More Resources</label>
                            </div>
                            <div class="col col-4">
                                <label class="checkbox"><input type="checkbox" name="lit" <?php if($community->literatureView) echo 'checked="checked"'?>><i></i>Literature</label>
                            </div>
                        </div>
                    </section>
                    <section>
                        <label class="label">About Menu Views</label>

                        <div class="row">
                            <div class="col col-4">
                                <label class="checkbox"><input type="checkbox" name="about_home_view" <?php if($community->about_home_view) echo 'checked="checked"'?>><i></i>Home</label>
                            </div>
                            <div class="col col-4">
                                <label class="checkbox"><input type="checkbox" name="about_sources_view" <?php if($community->about_sources_view) echo 'checked="checked"'?>><i></i>Sources</label>
                            </div>
                        </div>
                    </section>
                </fieldset>

                <footer>
                    <button type="submit" class="btn-u btn-u-default">Submit</button>
                </footer>
            </form>
        </div>
    </div>
</div>
