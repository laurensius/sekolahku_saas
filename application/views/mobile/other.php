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
            <div class="col-lg-12">
                <div id="map-canvas"></div>
                <p><i>Geser Marker untuk menentukan posisi origin (Awal Pencarian)</i></p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Latitiude</label>
                        <div id="curr_lat"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Longitude</label>
                        <div id="curr_lng"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary form-control" onclick="keHasilOther();">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">                        
            window.onload = function() {
                var curr_lat = -6.976000;
                var curr_lng = 108.485831;
                var latlng = new google.maps.LatLng(curr_lat,curr_lng);
                var map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: latlng,
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });


                document.getElementById('curr_lat').innerHTML = "<input type=\"text\" id=\"lt\" name=\"latitude\" value=\""+curr_lat+"\" class=\"form-control\" disabled>";
                document.getElementById('curr_lng').innerHTML = "<input type=\"text\" id=\"lg\" name=\"longitude\" value=\""+curr_lng+"\" class=\"form-control\" disabled>";

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: 'Geser Marker ini pada lokasi tempat wisata',
                    draggable: true
                });

                google.maps.event.addListener(marker, 'dragend', function(a) {
                      var curr_lat = a.latLng.lat().toFixed(6);
                      var curr_lng = a.latLng.lng().toFixed(6);
                      document.getElementById('curr_lat').innerHTML = "<input type=\"text\" id=\"lt\" name=\"latitude\" value=\""+curr_lat+"\" class=\"form-control\" disabled>";
                      document.getElementById('curr_lng').innerHTML = "<input type=\"text\" id=\"lg\" name=\"longitude\" value=\""+curr_lng+"\" class=\"form-control\" disabled>";
                });
            };
            
            
            function keHasilOther(){
                var latitude = document.getElementById('lt').value;
                var longitude = document.getElementById('lg').value;
                JSInterface.keHasilOther(latitude,longitude);
            }
            
//            function keHasil(){
//                alert(document.getElementById('lt').value);
//                alert(document.getElementById('lg').value);
//            }
        </script>
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/jquery.min.js"></script> 
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/laurenslib.js"></script> 
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>manifest/bootstrap/js/docs.min.js"> </script>
    </body>
</html>

