<!DOCTYPE html>
<html>
    <head>
        <title>Sekolahku</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>manifest/bootstrap/css/bootstrap.min.css">
        <style type="text/css">
            #map-canvas { min-height: 325px; }
        </style>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCprEkmn5_AWMYHETXDgLD2sBlipH8jZWo&sensor=true"></script>
        
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">SekolahKu</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Pencarian</a></li>
                        <li><a href="#" onclick="keTentang()">Tentang Aplikasi</a></li>
                        <li><a href="#" onclick="keLuar()">Keluar</a></li>  
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid" style="margin-top: 55px;">
            <?php
            foreach($data as $row){
                $latlong = $row->latitude.",".$row->longitude;
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $row->nama_sekolah; ?></div>
                </div>
                <div class="panel-body">
                    <div id="map-canvas"></div>
                    <i>Marker 'A' adalah posisi Anda, Marker 'B' adalah tujuan Anda.</i>
                    <p></p>
                    <p></p>
                    
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#detail" data-toggle="tab">Detail</a></li>
                        <li><a href="#direction" data-toggle="tab">Petunjuk Arah</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content" style="padding: 5px;">
                        <div class="tab-pane active" id="detail">
                            <div class="row">
                                <div class="col-lg-3 col-xs-3 col-sm-3">
                                    <img src="<?php echo base_url();?>uploads/<?php echo $row->foto;?>" style="width: 100%">
                                </div>
                                <div class="col-lg-9 col-xs-9 col-sm-9">
                                    <form role="form">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama Sekolah</label>
                                            <input type="text" class="form-control" disabled value="<?php echo $row->nama_sekolah; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Akreditasi</label>
                                            <input type="text" class="form-control" disabled value="<?php echo $row->akreditasi; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Keterangan</label>
                                            <textarea disabled class="form-control"><?php echo $row->keterangan ?></textarea> 
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea disabled class="form-control"><?php echo $row->alamat. " Kelurahan/Desa ".$row->kelurahan. " Kecamatan ". $row->kecamatan ." (Web : " . $row->url ." email : " . $row->email . ")"; ?></textarea> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="direction">
                            <div id="arahan"></div>
                        </div>
                    </div>
                    <div id="warnings_panel"></div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        
        <script>
            var map;
            var directionsDisplay;
            var directionsService;
            var stepDisplay;
            var markerArray = [];

            function initialize() {
                directionsService = new google.maps.DirectionsService();
                var pusat = new google.maps.LatLng(<?php echo $this->uri->segment(3) . "," . $this->uri->segment(4); ?>);
                var mapOptions = {
                    zoom: 10,
                    center: pusat
                }
                map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);// Create a renderer for directions and bind it to the map.
                var rendererOptions = {
                    map: map
                }
                directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions)// Instantiate an info window to hold step text.
                stepDisplay = new google.maps.InfoWindow();
                calcRoute();
            }

            function calcRoute() {
                for (var i = 0; i < markerArray.length; i++) {
                    markerArray[i].setMap(null);
                }
                markerArray = [];
                var start = new google.maps.LatLng(<?php echo $this->uri->segment(3) . "," . $this->uri->segment(4); ?>);
                var end = new google.maps.LatLng(<?php echo $latlong; ?>);
                var request = {
                    origin: start,
                    destination: end,
                    travelMode: google.maps.TravelMode.DRIVING
                };

                
                directionsService.route(request, function(response, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        var warnings = document.getElementById('warnings_panel');
                        warnings.innerHTML = '<b>' + response.routes[0].warnings + '</b>';
                        directionsDisplay.setDirections(response);
                        //showSteps(response);
                        
                        //-------------
                        var directionResult = response;
                        var myRoute = directionResult.routes[0].legs[0];
                        var arahan = '';
                        for (var i = 0; i < myRoute.steps.length; i++) { 
                            arahan +=  '<li class="list-group-item">'+ myRoute.steps[i].instructions +'</li>';
                            console.log(arahan);
                        }
                    }
                    document.getElementById('arahan').innerHTML = arahan.toString();
                    //alert(arahan);
                });
            }

            function showSteps(directionResult) {
                var myRoute = directionResult.routes[0].legs[0];
                var arahan = '';
                for (var i = 0; i < myRoute.steps.length; i++) {
                    var marker = new google.maps.Marker({
                        position: myRoute.steps[i].start_location,
                        map: map});
                    attachInstructionText(marker, myRoute.steps[i].instructions);
                    arahan +=  myRoute.steps[i].instructions;
                    markerArray[i] = marker;;
                }
            }

            function attachInstructionText(marker, text) {
                google.maps.event.addListener(marker, 'click', function() {
                stepDisplay.setContent(text);
                stepDisplay.open(map, marker);});
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/jquery.min.js"></script> 
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/docs.min.js"> </script>
    </body>
</html>


