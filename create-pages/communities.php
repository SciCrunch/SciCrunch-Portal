<div class="breadcrumbs-v3">
    <div class="container">
        <h1 class="pull-left">Create Community</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">Community</li>
        </ul>
    </div>
</div>
<!--=== End Breadcrumbs v3 ===-->
<div class="container first-container">
    <?php if (isset($_SESSION['user'])) { ?>
        <form action="/forms/community-forms/create-community.php" method="post" class="sky-form create-form" enctype="multipart/form-data">
            <header>Create New Community</header>
            <fieldset>
                <section>
                    <p>All new communities are private by default and thus not visible to the general public. You can
                        change this after creating your community on your community admin page.</p>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <label class="label">Full Community Name</label>
                    <label class="input">
                        <i class="icon-prepend fa fa-asterisk" style="color:#bb0000"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" placeholder="Focus to view the tooltip" required="required" name="name">
                        <b class="tooltip tooltip-top-right">The full name of your community</b>
                    </label>
                </section>
                <section>
                    <label class="label">Short Community Name (Used in URL)</label>
                    <label class="input">
                        <i class="icon-prepend fa fa-asterisk" style="color:#bb0000"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <input type="text" class="portal" placeholder="Focus to view the tooltip" name="short">
                        <b class="tooltip tooltip-top-right">An acronym or abbreviation of your community name that must
                            be
                            unique as it is used in your url</b>
                    </label>
                </section>
                <section>
                    <label class="label">Contact Information</label>
                    <label class="textarea">
                        <i class="icon-prepend fa fa-asterisk" style="color:#bb0000"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <textarea rows="3" placeholder="Focus to view the tooltip" name="address"></textarea>
                        <b class="tooltip tooltip-top-right">Address or another form of contact information for your community</b>
                    </label>
                </section>
                <section>
                    <label class="label">Description</label>
                    <label class="textarea">
                        <i class="icon-prepend fa fa-asterisk" style="color:#bb0000"></i>
                        <i class="icon-append fa fa-question-circle"></i>
                        <textarea rows="3" placeholder="Focus to view the tooltip" name="description"></textarea>
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
                        <input type="url" name="url" placeholder="Focus to view the tooltip">
                        <b class="tooltip tooltip-top-right">The URL of your community's website</b>
                    </label>
                </section>
                <section>
                    <label class="label">Who Can Join this Community?</label>
                    <label class="select">
                        <i class="icon-append fa fa-question-circle"></i>
                        <select name="join">
                            <option value="0">Everyone</option>
                            <option value="1">Can Request Access</option>
                            <option value="2">Invite Only</option>
                            <option value="3">No One</option>
                        </select>
                        <b class="tooltip tooltip-top-right">This will affect who can join your community through
                            SciCrunch</b>
                    </label>
                </section>
            </fieldset>

            <fieldset>
                <div class="row">
                    <section class="col col-3">
                        <label class="label">Default Logo</label>

                        <div class="default-logo">

                        </div>
                    </section>
                    <section class="col col-9">
                        <label class="label">Logo</label>
                        <label for="file" class="input input-file">
                            <div class="button"><input type="file" id="file" name="file"
                                                       onchange="$(this).parent().next().val($(this).val());">Browse
                            </div>
                            <input type="text" readonly>
                        </label>
                    </section>
                </div>
            </fieldset>

            <footer>
                <button type="submit" class="btn-u btn-u-default">Submit</button>
            </footer>
        </form>
    <?php } else { ?>
        <form method="post" class="sky-form" style="border:0" action="/forms/login.php">
            <header>Create New Community</header>
            <fieldset>
                <section>
                    <p>You must be logged in to create a community, log in below or <a href="/register">Register here</a> to create a community</p>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <div class="input">
                        <i class="fa fa-envelope icon-prepend" style="top: 1px;height: 32px;font-size: 14px;line-height: 33px;background: inherit;color:#b3b3b3;background:#fff;left:1px;padding-left:6px;"></i>
                        <input type="text" class="form-control" name="email" placeholder="Email">
                    </div>
                </section>
                <div class="input">
                    <i class="fa fa-lock icon-prepend" style="top: 1px;height: 32px;font-size: 14px;line-height: 33px;background: inherit;color:#b3b3b3;background:#fff;left:1px;padding-left:6px;"></i>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <hr style="margin:18px 0">

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <button type="submit" class="btn-u btn-block">Log In</button>
                    </div>
                </div>
            </fieldset>
        </form>
    <?php } ?>
</div>