<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FastRide | CAR Rental</title>
    <link rel="stylesheet" href="/car_rental/assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/car_rental/assets/css/style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
</head>

<body>
    <!--Header-->
    <?php include('includes/header.php'); ?>
    <!-- /Header -->
    
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="result-sorting-wrapper">
                    <?php
                    try {
                        $sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles
                                JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        
                        $cnt = $query->rowCount();
                        echo "<p><center><span>$cnt CARS</span></center></p>";
                        
                        if ($cnt > 0) {
                            foreach ($results as $result) {
                                ?>
                                <div class="product-listing-m gray-bg">
                                    <div class="product-listing-img">
                                        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="Image">
                                    </div>
                                    <div class="product-listing-content">
                                        <h5><?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></h5>
                                        <p class="list-price" style="color:black;">₹<?php echo htmlentities($result->PricePerDay); ?> Per Day Rental</p>
                                        <ul>
                                        <li style="color: black;"><i class="fa fa-user" aria-hidden="true"></i> <?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
                                        <li style="color: black;"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlentities($result->ModelYear); ?> model</li>
                                        <li style="color: black;"><i class="fa fa-car" aria-hidden="true"></i> <?php echo htmlentities($result->FuelType); ?></li>
                                        </ul>

                                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">View Details</a>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No cars available.</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="col-md-3">
                <div class="sidebar_widget">
                    <h5>Find Your Car</h5>
                    <form action="search-carresult.php" method="post">
                        <div class="form-group select">
                            <select class="form-control" name="brand">
                                <option>Select Brand</option>
                                <?php
                                $sql = "SELECT * FROM tblbrands";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $brands = $query->fetchAll(PDO::FETCH_OBJ);
                                
                                foreach ($brands as $brand) {
                                    echo "<option value='" . htmlentities($brand->id) . "'>" . htmlentities($brand->BrandName) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group select">
                            <select class="form-control" name="fueltype">
                                <option>Select Fuel Type</option>
                                <option value="Petrol">Petrol</option>
                                <option value="Diesel">Diesel</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-block">SEARCH</button>
                    </form>
                </div>
            </aside>
            <!-- End Sidebar -->
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="/car_rental/assets/js/jquery.min.js"></script>
    <script src="/car_rental/assets/js/bootstrap.min.js"></script>
</body>
</html>
