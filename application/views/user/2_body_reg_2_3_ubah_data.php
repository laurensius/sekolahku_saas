            <?php foreach($data as $row){ ?>
            <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Ubah Data</div>
                </div>
                <div class="panel-body">
                    <!--div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <center>
                                <img src="<?php echo base_url()."uploads/".$row->foto; ?>" alt="<?php echo $row->nama_sekolah; ?>" class="img-thumbnail" style="width: 50%">
                            </center>
                        </div>
                        <div class="col-lg-4"></div>
                    </div-->
                    <form method="post" action="<?php echo site_url();?>/user/update_data/<?php echo $row->id;?>" enctype="multipart/form-data">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="namaSekolah">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" class="form-control" id="namaSekolah" placeholder="Nama Sekolah" required value="<?php echo $row->nama_sekolah; ?>">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="akreditasi">Akreditasi</label>
                                    <input type="text" name="akreditasi" class="form-control" id="akreditasi" placeholder="Akreditasi, Misal  : A (Sangat Baik)"  required  value="<?php echo $row->akreditasi; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" name="foto" class="form-control" id="foto" placeholder="Foto / Screenshoot">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="url">URL Web</label>
                                    <input type="url" name="url" class="form-control" id="url" placeholder="URL" value="<?php echo $row->url; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email"  value="<?php echo $row->email; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="kelurahan">Desa / Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control" id="kelurahan" placeholder="Kelurahan" required value="<?php echo $row->kelurahan; ?>">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Kecamatan" required value="<?php echo $row->kecamatan; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <Textarea name="alamat" class="form-control" id="alamat" placeholder="Misal  : Jalan Raden Saleh No.47 RT.23 RW.007 Blok Lumbu" style="height: 90px;" required><?php echo $row->alamat; ?></Textarea>
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
                                        <input type="text" name="latitude"  class="form-control" placeholder="Latitude" required value="<?php echo $row->latitude; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Longitude :</label>
                                    <div id="curr_lng">
                                        <input type="text" name="longitude"  class="form-control" placeholder="Longitude" required value="<?php echo $row->longitude; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="keterangan">Keterangan / Informasi Lainnya</label>
                            <Textarea name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan / Informasi Lainnya. Misal : Fasilitas, Biaya Pendidikan, Ekstrakulikuler, dan lainnya." style="height: 90px;"><?php echo $row->keterangan; ?></Textarea>
                        </div>
                        <center>
                            <a href="<?php echo site_url();?>/user/kelola/lihat_data" class="btn btn-default">
                                <span class="glyphicon glyphicon-backward"></span> Kembali Ke Lihat Data 
                            </a>
                            <input type="submit" class="btn btn-primary" value="Perbaharui">
                        </center>
                    </div>
                    </form>
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

                    
                    document.getElementById('curr_lat').innerHTML = "<input type=\"text\" name=\"latitude\" value=\""+curr_lat+"\" class=\"form-control\">";
                    document.getElementById('curr_lng').innerHTML = "<input type=\"text\" name=\"longitude\" value=\""+curr_lng+"\" class=\"form-control\">";

         
                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title: 'Geser Marker ini pada lokasi tempat wisata',
                        draggable: true
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