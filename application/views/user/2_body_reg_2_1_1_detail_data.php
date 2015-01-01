            <?php
            foreach($data as $row){
            ?>
            <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><a href="<?php echo site_url();?>/user/kelola/lihat_data">Lihat Data </a> / Detail Data</div>
                </div>
                <div class="panel-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="namaSekolah">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" class="form-control" id="namaSekolah" value="<?php echo $row->nama_sekolah; ?>" disabled>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="akreditasi">Akreditasi</label>
                                    <input type="text" name="akreditasi" class="form-control" id="akreditasi" value="<?php echo $row->akreditasi; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="url">URL Web</label>
                                    <input type="url" name="url" class="form-control" id="url" value="<?php echo $row->url; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" name="email" class="form-control" id="email" value="<?php echo $row->email; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="kelurahan">Desa / Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control" id="kelurahan" value="<?php echo $row->kelurahan; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" id="kecamatan" value="<?php echo $row->kecamatan; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <Textarea name="alamat" class="form-control" id="alamat"  style="height: 90px;" disabled><?php echo $row->alamat; ?></Textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="alamat">Lokasi Sekolah</label>
                            <div class="col-lg-12" style="min-height: 325px;">
                                <div id="map-canvas"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Latitude :</label>
                                    <div id="curr_lat">
                                        <input type="text" name="latitude"  class="form-control" value="<?php echo $row->latitude; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Longitude :</label>
                                    <div id="curr_lng">
                                        <input type="text" name="longitude"  class="form-control"  value="<?php echo $row->longitude; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="keterangan">Keterangan / Informasi Lainnya</label>
                            <Textarea name="keterangan" class="form-control" id="keterangan" style="height: 90px;" disabled><?php echo $row->keterangan; ?></Textarea>
                        </div>
                        <center>
                            <a href="<?php echo site_url();?>/user/kelola/lihat_data">
                                <button class="btn btn-default">
                                    <span class="glyphicon glyphicon-backward"></span> Kembali Ke Lihat Data 
                                </button>
                            </a>
                            <a href="<?php echo site_url();?>/user/kelola/ubah_data/<?php echo $row->id; ?>">
                            <button class="btn btn-warning">
                                <span class="glyphicon glyphicon-pencil"></span> Modifikasi / Ubah Data 
                            </button>
                        </center>
                    </div>
                </div>
            </div>
            </div>
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCprEkmn5_AWMYHETXDgLD2sBlipH8jZWo&sensor=true">
            </script>
            <script type="text/javascript">                        
                window.onload = function() {
                    var curr_lat = <?php echo $row->latitude; ?>;
                    var curr_lng = <?php echo $row->longitude; ?>;
                    var latlng = new google.maps.LatLng(curr_lat,curr_lng);
                    var map = new google.maps.Map(document.getElementById('map-canvas'), {
                        center: latlng,
                        zoom: 12,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

         
                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title: 'Geser Marker ini pada lokasi tempat wisata',
                        draggable: false
                    });

                    google.maps.event.addListener(marker, 'dragend', function(a) {
                          var curr_lat = a.latLng.lat().toFixed(6);
                          var curr_lng = a.latLng.lng().toFixed(6);
                          document.getElementById('curr_lat').innerHTML = "<input type=\"text\" name=\"latitude\" value=\""+curr_lat+"\" class=\"form-control\">";
                          document.getElementById('curr_lng').innerHTML = "<input type=\"text\" name=\"longitude\" value=\""+curr_lng+"\" class=\"form-control\">";
                    });
                };
            </script>
            <?php } ?>