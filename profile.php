<?php
require_once('header.php');
$getData = $_SESSION['user']['id'];

?>
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center mb-4">
                            <img class="mr-3" src="images/avatar/11.png" width="80" height="80" alt="">
                            <div class="media-body">

                                <?php
                                // $stm = $connection->prepare('SELECT name,username,mobile,business_name,address,gender,date_of_birth,status FROM users WHERE id=?');
                                // $stm->execute(array($_SESSION['user']['id']));
                                // $userData = $stm->fetch(PDO::FETCH_ASSOC);
                                // print_r($userData);
                                $userData = userdata($getData);
                                ; ?>
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
                                <div class="badge badge-success text-white">
                                    <?php echo $userData['status']; ?>
                                </div>
                            </li>
                        </ul>
                        <div class="col-12 text-center">
                            <button class="btn btn-danger px-5">Update Profile</button>
                        </div>
                        <br>
                        <div class="col-12 text-center">
                            <button class="btn btn-warning px-5 text-white">Change Password</button>
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
<?php require_once('footer.php'); ?>