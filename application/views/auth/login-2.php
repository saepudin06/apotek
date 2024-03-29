<?php
    $items = getCompany();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $items['subtitle'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font/font.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font/iconsmind/style.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
</head>

<body class="background show-spinner">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">

                            <!-- <p class=" text-white h2"><?php echo $items['name'];?></p> -->
                            <p class="h2"><?php echo $items['name'];?></p>

                            <!-- <p class="white mb-0"> -->
                            <p class="mb-0">
                                <?php echo $items['address'];?>
                                <br><?php echo "Email : ".$items['email'];?>
                            </p>
                        </div>
                        <div class="form-side">
                            <!-- <a href="javascript:;"> -->
                                <!-- <span class="logo-single"></span> -->
                                <!-- <img src="<?php echo base_url().$items['logo'];?>" alt="logo" width="40" height="40"> -->
                            <!-- </a> -->
                            <h6 class="mb-4">Login</h6>
                            <?php if($this->session->flashdata('error_message') != ""): ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo $this->session->flashdata('error_message'); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php endif; ?>
                            <form name="login_form" action="<?php echo $login_url;?>" method="post">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" autocomplete="off" name="username" placeholder="Masukan Username" />
                                    <span>Username</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" autocomplete="off" name="password" placeholder="Masukan Password" />
                                    <span>Password</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="javascript:;">&nbsp;</a>
                                    <button class="btn btn-secondary btn-lg btn-shadow" type="submit">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?php echo base_url(); ?>assets/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dore.script.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
</body>

</html>