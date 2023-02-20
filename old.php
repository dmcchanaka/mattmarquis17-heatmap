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

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
                <h1 class="display-5 text-primary m-0">Heat Map</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.html" class="nav-item nav-link active">Home</a>
                    <a href="about.html" class="nav-item nav-link">Upload</a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-xxl py-5" style="margin-top: 20px;">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="display-5 mb-5">Heatmap Details</h1>
        </div>
        <div class="row mt-3">
            <div class="form-group col-md-12">
                <div id="map" style="height: 500px;width: 100%;"></div>
                <div id="infowindow-content">
                    <img src="" width="16" height="16" id="place-icon" />
                    <span id="place-name" class="title"></span><br />
                    <span id="place-address"></span>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Facts Start -->
    <!-- Facts End -->


    <!-- Features Start -->
    <!-- Features End -->


    <!-- Service Start -->
    <!-- Service End -->


    <!-- Callback Start -->
    <!-- Callback End -->


    <!-- Projects Start -->
    <!-- Projects End -->


    <!-- Team Start -->
    <!-- Team End -->


    <!-- Testimonial Start -->
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright py-4 fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a
                    href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4wokwcNfImtenTMmynieuKr7H5QUpdm8&callback=initMap&libraries=visualization&v=weekly"
            defer
    ></script>
    <script type="text/javascript">
        heatMapData = [];
        function initMap() {
            var mapLayer = document.getElementById("map");
            var centerCoordinates = new google.maps.LatLng(37.450143, -92.778961);
            var defaultOptions = {center: centerCoordinates, zoom: 14};
            map = new google.maps.Map(mapLayer, defaultOptions);
            
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(map);

            show_heatmap();
        }

        function show_heatmap(){
            var bounds = new google.maps.LatLngBounds();
            $.ajax({
                type: "POST",
                url: "ajax_request.php",
                data: {
                    'type':'get_all_details'
                },
                cache: false,
                success: function(data){
                    var arr = JSON.parse(data);
                    for (var i = 0; i < arr.length; i++) {
                        // console.log(arr[i].latitude);
                        heatMapData.push(new google.maps.LatLng(arr[i].latitude, arr[i].longitude));
                        // heatMapData.push({location: new google.maps.LatLng(arr[i].latitude, arr[i].longitude), weight: arr[i].rssi});
                    }

                    // console.log(heatMapData);

                    // var heatMapData = [
                    // {location: new google.maps.LatLng(37.782, -122.447), weight: 0.5},
                    // new google.maps.LatLng(37.782, -122.445),
                    // {location: new google.maps.LatLng(37.782, -122.443), weight: 2},
                    // {location: new google.maps.LatLng(37.782, -122.441), weight: 3},
                    // {location: new google.maps.LatLng(37.782, -122.439), weight: 2},
                    // new google.maps.LatLng(37.782, -122.437),
                    // {location: new google.maps.LatLng(37.782, -122.435), weight: 0.5},

                    // {location: new google.maps.LatLng(37.785, -122.447), weight: 3},
                    // {location: new google.maps.LatLng(37.785, -122.445), weight: 2},
                    // new google.maps.LatLng(37.785, -122.443),
                    // {location: new google.maps.LatLng(37.785, -122.441), weight: 0.5},
                    // new google.maps.LatLng(37.785, -122.439),
                    // {location: new google.maps.LatLng(37.785, -122.437), weight: 2},
                    // {location: new google.maps.LatLng(37.785, -122.435), weight: 3}
                    // ];

                    var sanFrancisco = new google.maps.LatLng(39.4861217, -76.1590323);

                    map = new google.maps.Map(document.getElementById('map'), {
                    center: sanFrancisco,
                    zoom: 13,
                    mapTypeId: 'satellite'
                    });

                    var heatmap = new google.maps.visualization.HeatmapLayer({
                    data: heatMapData
                    });
                    heatmap.setMap(map);

                }
            });
        }
    </script>
</body>

</html>