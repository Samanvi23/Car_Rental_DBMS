<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>FastRide | CAR Rental</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!--Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!--FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- Google-Font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body style="background-color:white;">
<!--Header-->
<?php include('includes/header.php'); ?>
<!-- /Header -->

<center>
    <div class="page-heading">
        <br/><br/>
        <h1 style="color:black;">MY BOOKING</h1>
    </div>
</center>

<div class="container">
    <div class="user_profile_info gray-bg padding_4x4_40" style="background-color:#9CAF88;">
        <div class="upload_user_logo">
            <img src="assets/images/dealer-logo.png" alt="image">
        </div>
        <div class="dealer_info" style="color:black;">
            <?php
            $useremail = $_SESSION['login'];
            $sql = "SELECT * FROM tblusers WHERE EmailId = :useremail";
            $query = $dbh->prepare($sql);
            $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $result) { ?>
                    <h5><?php echo htmlentities($result->FullName); ?></h5>
                    <p><?php echo htmlentities($result->Address); ?><br>
                        <?php echo htmlentities($result->City); ?> &nbsp; <?php echo htmlentities($result->Country); ?></p>
                <?php }
            } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-3">
            <?php include('includes/sidebar.php'); ?>
        </div>
        <div class="col-md-6 col-sm-8" style="background-color:#white;">
            <div class="profile_wrap">
                <center>
                    <h5 class="uppercase underline" style="background-color:#9CAF88;">MY BOOKING</h5>
                </center>

                <ul class="vehicle_listing">
                    <?php
                    // Load SQL Query from the file
                    $useremail = $_SESSION['login'];
                    $sqlQueryFile = file_get_contents('queries/my_booking_query.sql'); // Load query from file
                    $query = $dbh->prepare($sqlQueryFile);
                    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>
                            <li>
                                <div class="vehicle_img">
                                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>">
                                        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="image">
                                    </a>
                                </div>
                                <div class="vehicle_title">
                                    <h6>
                                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>" style="color:black;">
                                            <?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?>
                                        </a>
                                    </h6>
                                    <p style="color:black;">
                                        <b>From Date:</b> <?php echo htmlentities($result->FromDate); ?><br/>
                                        <b>To Date:</b> <?php echo htmlentities($result->ToDate); ?>
                                    </p>
                                </div>
                                <?php if ($result->Status == 1) { ?>
                                    <div class="vehicle_status">
                                        <a href="#" class="btn outline btn-xs active-btn" style="background-color:black;">CONFIRMED</a>
                                        <div class="clearfix"></div>
                                    </div>
                                <?php } elseif ($result->Status == 2) { ?>
                                    <div class="vehicle_status">
                                        <a href="#" class="btn outline btn-xs" style="background-color:black;">CANCELLED</a>
                                        <div class="clearfix"></div>
                                    </div>
                                <?php } else { ?>
                                    <div class="vehicle_status" style="color:white;">
                                        <a href="#" class="btn outline btn-xs" style="background-color:black;">Not Confirmed</a>
                                        <div class="clearfix"></div>
                                    </div>
                                <?php } ?>
                                <div style="float: left">
                                    <p style="color:black;">
                                        <b>Message:</b> <?php echo htmlentities($result->message); ?>
                                    </p>
                                </div>
                            </li>
                        <?php }
                    } ?>
                </ul>

            </div>
        </div>
    </div>
</div>
<br/><br/>
<?php include('includes/footer.php'); ?>
<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
</body>
</html>
<?php } ?>
