            <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Lihat Data</div>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Sekolah</th>
                                <th>Akreditasi</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCprEkmn5_AWMYHETXDgLD2sBlipH8jZWo&sensor=true"></script>
                            <?php
                            $c = 1;
                            foreach($data as $row){
                                echo "<tr>";
                                echo "<td>" . $c ."</td>";
                                echo "<td>" . $row->nama_sekolah ."</td>";
                                echo "<td>" . $row->akreditasi ."</td>";
                                echo "<td>" . $row->alamat ."</td>";
                                echo "<td style='width:120px;'>"
                                
                                //-----Detail
                                    ."<a href='". site_url() ."/user/kelola/detail_data/".$row->id."'>"
                                    ."<button class='btn btn-primary btn-xs' style='margin:1px;'><span class='glyphicon glyphicon-align-justify'></span></button>"
                                    ."</a>"
                                //-----End Detail
                                //-----Edit
                                    ."<a href='". site_url() ."/user/kelola/ubah_data/".$row->id."'>"
                                    ."<button class='btn btn-warning btn-xs' style='margin:1px;'><span class='glyphicon glyphicon-pencil'></span></button>"
                                    ."</a>" 
                                //-----End Edit
                                //-----Delete
                                //data-toggle="modal" data-target="#myModal"
                                    ."<a href='#' data-toggle='modal' data-target='#myModal_".$c."'>"
                                    ."<button class='btn btn-danger btn-xs' style='margin:1px;'><span class='glyphicon glyphicon-remove'></span></button>"
                                    ."</a>"
                                //-----End Delete
                                    ."</td>";
                                echo "</tr>";
                                ?>
                                <div class="modal fade" id="myModal_<?php echo $c; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Konfirmasi Hapus Data <?php echo $row->nama_sekolah; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda akan menghapus data  <?php echo $row->nama_sekolah; ?> ? </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Tidak ! </button>
                                                <a href="<?php echo site_url() ?>/user/kelola/delete_data/<?php echo $row->id ?>">
                                                    <button type="button" class="btn btn-primary">Ya, Hapus!</button>
                                                </a>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <?php
                                $c++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>

            