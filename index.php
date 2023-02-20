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
            <h1 class="display-5 mb-5">Heatmap Details</h1>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <label for="customRange1" class="form-label">Slider value : </label>&nbsp;<span>30</span><br>
                <input type="range" class="form-range" min="30" max="110" value="30" id="customRange1" oninput="displaySliderValue(this);">
            </div>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4wokwcNfImtenTMmynieuKr7H5QUpdm8&callback=initMap&libraries=visualization&v=weekly"
            defer
    ></script>
    <script type="text/javascript">
        heatMapData = [];
        var heatmap;
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
                        // heatMapData.push({location: new google.maps.LatLng(arr[i].latitude, arr[i].longitude), weight: 1});

                        bounds.extend(new google.maps.LatLng(parseFloat(arr[i].latitude), parseFloat(arr[i].longitude)));
                    }

                    var centerLocation = new google.maps.LatLng(39.4861217, -76.1590323);

                    map = new google.maps.Map(document.getElementById('map'), {
                        center: centerLocation,
                        zoom: 13,
                        mapTypeId: 'satellite'
                    });
                    map.fitBounds(bounds);

                    heatmap = new google.maps.visualization.HeatmapLayer({
                        data: heatMapData,
                        maxIntensity: 30,
                        opacity: 0.5,
                    });
                    heatmap.setMap(map);

                }
            });
        }

        function displaySliderValue(eSlider){   
            eSlider.parentElement.querySelector('span').textContent = eSlider.value;

            heatmap.set("maxIntensity", eSlider.value);
        }
    </script>
</body>

</html>