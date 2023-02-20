<?php
    session_start();
    require_once './library/config.php';
    $connection = new createConnection();
    $connection->connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Heat Map</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="./assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="./assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="./assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">

        <?php include_once('./layouts/header.php'); ?>
    </div>
    <!-- Navbar End -->


    <!-- About Start -->
    <div class="container-xxl py-5" style="margin-top: 20px;">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="display-5 mb-5">Upload CSV</h1>
        </div>
        <?php 
            if(isset($_SESSION['msg']) && isset($_SESSION['status'])){
                if($_SESSION['status'] == 0){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?php echo $_SESSION['msg']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Opps!</strong> <?php echo $_SESSION['msg']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php }
            }
		?>
        <form action="update.php" method="post" class="text-center" enctype="multipart/form-data">
            <div class="row justify-content-center">
                
                <div class="col-lg-7">
                    <div class="bg-white border rounded p-4 p-sm-5 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="form-floating">
                                    <input type="file" class="form-control" id="file" name="file" placeholder="File" accept=".csv">
                                    <label for="subject">File</label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary w-100 py-3" type="submit" name="importSubmit">Submit Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- About End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4 fixed-bottom">
        <?php include_once('./layouts/footer.php'); ?>
    </div>
    <!-- Copyright End -->


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/lib/wow/wow.min.js"></script>
    <script src="./assets/lib/easing/easing.min.js"></script>
    <script src="./assets/lib/waypoints/waypoints.min.js"></script>
    <script src="./assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="./assets/lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="./assets/js/main.js"></script>
    <script type="text/javascript">
    </script>
</body>

</html>
<?php 
unset($_SESSION['msg']);
unset($_SESSION['status']);
unset($_SESSION['errors']);
?>