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
        <div class="container-fluid" style="margin-top:55px;">
            <div class="col-lg-12">
                <ul class="list-group">
                <?php
                    $ctr = 0;
                    foreach($data as $row){
                        echo '<li class="list-group-item" onclick="keDetailOther('.$row->id.','.$this->uri->segment(3).','.$this->uri->segment(4).');">'
                                .$row->nama_sekolah
                                .'<span class="badge"><div id="distance_'.$ctr.'"><div></span>
                             </li>';
                        $dst[$ctr] = 'var destination_'.$ctr.' = new google.maps.LatLng('. $row->latitude .','. $row->longitude .');';
                        $ctr++;
                    }
                ?>
                </ul>   
                <script>
                    var map;
                    var geocoder;
                    var bounds = new google.maps.LatLngBounds();
                    var markersArray = [];

                    var origin = new google.maps.LatLng(<?php echo $this->uri->segment(3) . "," . $this->uri->segment(4); ?>);
        //            var destination = 'Jakarta';          

                    <?php
                        for($ctr_fetch=0;$ctr_fetch<$ctr;$ctr_fetch++){
                            echo $dst[$ctr_fetch];
                        }
                    ?>

                    var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
                    var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

                    function initialize() {
                        var opts = {
                            center: new google.maps.LatLng(<?php echo $this->uri->segment(3) . "," . $this->uri->segment(4); ?>),
                            zoom: 10
                        };
                        //map = new google.maps.Map(document.getElementById('map-canvas'), opts);
                        geocoder = new google.maps.Geocoder();
                        calculateDistances();
                    }

                    function calculateDistances() {
                        var service = new google.maps.DistanceMatrixService();
                        service.getDistanceMatrix({
        //                  origins: [origin1, origin2],
                          origins: [origin],
        //                  destinations: [destination],
                          destinations: [<?php
                                            for($x=0;$x<$ctr;$x++){
                                                echo "destination_$x";
                                                if($ctr - 1 != $x){
                                                    echo ",";
                                                }
                                            }
                                        ?>],
                          travelMode: google.maps.TravelMode.DRIVING,
                          unitSystem: google.maps.UnitSystem.METRIC,
                          avoidHighways: false,
                          avoidTolls: false
                        }, callback);
                    }

                    function callback(response, status) {
                        if (status != google.maps.DistanceMatrixStatus.OK) {
                            alert('Error was: ' + status);
                        } else {
                            var origins = response.originAddresses;
                            var destinations = response.destinationAddresses;
                            var outputDiv = document.getElementById('outputDiv');
                            outputDiv.innerHTML = '';
                            deleteOverlays();

                            for (var i = 0; i < origins.length; i++) {
                                var results = response.rows[i].elements;
                                addMarker(origins[i], false);
                                for (var j = 0; j < results.length; j++) {
                                    addMarker(destinations[j], true);
        //                            outputDiv.innerHTML += "Jarak dari " + origins[i] + " menuju " 
        //                                    + destinations[j] + " adalah " + results[j].distance.text 
        //                                    + " dalam waktu " + results[j].duration.text  ;
                                    document.getElementById('distance_' + j).innerHTML = results[j].distance.text ;
                                }
                            }
                        }
                    }

                    function addMarker(location, isDestination) {
                        var icon;
                        if (isDestination) {
                            icon = destinationIcon;
                        } else {
                            icon = originIcon;
                        }

                        geocoder.geocode({'address': location}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                bounds.extend(results[0].geometry.location);
                                map.fitBounds(bounds);
                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location,
                                    icon: icon
                                });
                                markersArray.push(marker);
                            } else {
                                alert('Geocode was not successful for the following reason: ' + status);
                            }
                        });
                    }

                    function deleteOverlays() {
                        for (var i = 0; i < markersArray.length; i++) {
                            markersArray[i].setMap(null);
                        }
                        markersArray = [];
                    }

                    google.maps.event.addDomListener(window, 'load', initialize);
                    
                    function keDetailOther(id,lat,lng){
                        JSInterface.keDetailOther(id,lat,lng);
                    }
                </script>
            </div>
        </div>
        
        <div id="outputDiv"></div>
        <div class="panel-body" id="map-canvas"></div>
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/jquery.min.js"></script> 
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/laurenslib.js"></script> 
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/docs.min.js"> </script>
    </body>
</html>

