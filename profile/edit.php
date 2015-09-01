
<?php

echo Connection::createBreadCrumbs('Edit Information',array('Home','Account'),array($profileBase,$profileBase.'account'),'Edit Information');
?>

<div class="profile container content">
    <div class="row">
        <?php include 'left-column.php'; ?>
        <!--End Left Sidebar-->

        <div class="col-md-9">
            <!--Profile Body-->
            <div class="profile-body">
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="/forms/userInformation.php" id="sky-form4" class="reg-page-style sky-form user-information-form">
                            <header>Update Information</header>

                            <fieldset>

                                <section>
                                    <label type="label">Email</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Email address" value="<?php echo $_SESSION['user']->email ?>" required>
                                        <b class="tooltip tooltip-bottom-right">Update your email that you log in with</b>
                                    </label>
                                </section>
                                <div class="row">
                                    <section class="col col-6">
                                        <label type="label">First Name</label>
                                        <label class="input">
                                            <input type="text" name="firstname" placeholder="First name" value="<?php echo $_SESSION['user']->firstname ?>" required>
                                        </label>
                                    </section>
                                    <section class="col col-6">
                                        <label type="label">Last Name</label>
                                        <label class="input">
                                            <input type="text" name="lastname" placeholder="Last name" value="<?php echo $_SESSION['user']->lastname ?>" required>
                                        </label>
                                    </section>
                                </div>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn-u">Update</button>
                            </footer>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="post" action="/forms/updatePassword.php" id="sky-form4" class="reg-page sky-form">
                            <header>Change Password</header>

                            <fieldset>

                                <section>
                                    <label type="label">Current Password</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-lock"></i>
                                        <input type="password" name="original" placeholder="Original Password" required>
                                        <b class="tooltip tooltip-bottom-right">Your current password</b>
                                    </label>
                                </section>
                                <section>
                                    <label type="label">New Password</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-lock"></i>
                                        <input class="sign-up-password" type="password" name="password" placeholder="New Password" required>
                                        <b class="tooltip tooltip-bottom-right">The new password you'd like to use</b>
                                    </label>
                                </section>
                                <section>
                                    <label type="label">Retype New Password</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-lock"></i>
                                        <input class="sign-up-password" type="password" name="password2" placeholder="New Password Again" required>
                                        <b class="tooltip tooltip-bottom-right">The new password as entered before</b>
                                    </label>
                                </section>
                            </fieldset>


                            <footer>
                                <button type="submit" class="btn-u">Submit</button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
