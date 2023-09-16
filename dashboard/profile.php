<?php
require_once('../config.php');
get_header();
$getData = $_SESSION['user']['id'];

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <?php $userData = userdata($getData); ?>
                        <div class="media align-items-center mb-4 profile">
                            <?php if ($userData['photo'] != NULL): ?>
                                <img class="mr-3" src="../uploads/profile/<?php echo $userData['photo']; ?>" width="80"
                                    height="80" alt="">
                            <?php else: ?>
                                <img class="mr-3" src="../images/avatar/11.png" width="80" height="80" alt="">
                            <?php endif; ?>
                            <div class="media-body">

                                <h3 class="mb-0">
                                    <?php echo $userData['name']; ?>
                                </h3>
                                <p class="text-muted mb-0">
                                    <?php echo $userData['username']; ?>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col">
                                <div class="card card-profile text-center">
                                    <span class="mb-1 text-primary"><i class="icon-people"></i></span>
                                    <h3 class="mb-0">263</h3>
                                    <p class="text-muted px-4">Following</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card card-profile text-center">
                                    <span class="mb-1 text-warning"><i class="icon-user-follow"></i></span>
                                    <h3 class="mb-0">263</h3>
                                    <p class="text-muted">Followers</p>
                                </div>
                            </div>

                        </div>

                        <h4>About Me</h4>
                        <ul class="card-profile__info">
                            <li><strong class="text-dark mr-4">Mobile</strong> <span>
                                    <?php echo $userData['mobile']; ?>
                                </span></li>
                            <li><strong class="text-dark mr-4">Business Name</strong> <span>
                                    <?php echo $userData['business_name']; ?>
                                </span></li>
                            <li><strong class="text-dark mr-4">Address</strong> <span>
                                    <?php echo $userData['address']; ?>
                                </span></li>
                            <li><strong class="text-dark mr-4">Gender</strong> <span>
                                    <?php echo $userData['gender']; ?>
                                </span></li>
                            <li><strong class="text-dark mr-4">Date of birth</strong> <span>
                                    <?php echo $userData['date_of_birth']; ?>
                                </span></li>
                            <li><strong class="text-dark mr-4">Status</strong>
                                <div>
                                    <?php if ($userData['status'] == 'verified'): ?>
                                        <div class="badge bg-success text-white">
                                            <?php echo 'Active' ?>
                                        </div>
                                    <?php elseif ($userData['status'] == 'pending'): ?>
                                        <div class="badge bg-warning text-white">
                                            <?php echo 'Pending'; ?>
                                        </div>
                                    <?php elseif ($userData['status'] == 'blocked'): ?>
                                        <div class="badge bg-danger text-white">
                                            <?php echo 'Blocked'; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        </ul>
                        <div class="col-12 text-center">
                            <a href="<?php APP_URL(); ?>/dashboard/update-profile.php"><button
                                    class="btn btn-danger px-5">Update Profile</button></a>
                        </div>
                        <br>
                        <div class="col-12 text-center">
                            <a href="change-password.php"><button class="btn btn-warning px-5 text-white">Change
                                    Password</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
<?php get_footer(); ?>