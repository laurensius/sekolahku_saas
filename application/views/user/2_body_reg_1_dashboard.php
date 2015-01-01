                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Data Sekolah </div>
                        </div>
                        <div class="panel-body">
                            <?php
                            if($data[0] == 0){
                                echo "Untuk saat ini tidak ada data sekolah tersimpan di database. Terima kasih!";
                            }else{
                                echo "Saat ini tersimpan $data[0] infomasi sekolah yang dipublikasikan pada Aplikasi SekolahKu, "
                                   . "dengan rincian sebagai berikut : ";
                                echo "<p></p>";
                                $ctr = 1;
                                $before_kecamatan = "";
                                echo "<table class='table table-hover'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Nama Sekolah</th>";
                                echo "<th>Alamat Sekolah</th>";
                                echo "<th>Jumlah Kunjungan User</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "</tbody>";
                                foreach($data[1] as $row){
                                   echo "<tr>";
                                   echo "<td>$ctr</td>";
                                   echo "<td>$row->nama_sekolah</td>";
                                   echo "<td>"
                                      . "$row->alamat"
                                      . ", Kecamatan ". str_ireplace("kecamatan", " ", $row->kecamatan) 
                                      . ", Kelurahan ". str_ireplace("kelurahan", " ", $row->kelurahan) ."</td>";
                                   $sum = $this->mod_visitor->cek_visitor($row->id);
                                   if($sum[0]==0){
                                       echo "<td> Belum ada pengunjung </td>";
                                   }else{
                                       foreach($sum[1] as $rows){
                                           echo "<td> Jumlah pengunjung $rows->jumlah </td>";
                                       }
                                   }
                                   echo "</tr>";
                                   $ctr++;
                                }
                                echo "</tbody>";
                                echo "</table>";
                            }
                            ?>
                        </div>
                    </div>
                </div>    
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">Tentang Sistem (Server)</div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $indicesServer = array(
                                    'GATEWAY_INTERFACE', 
                                    'SERVER_ADDR', 
                                    'SERVER_NAME', 
                                    'SERVER_SOFTWARE', 
                                    'SERVER_PROTOCOL', 
                                    'REQUEST_METHOD', 
                                    'HTTP_USER_AGENT', 
                                    'PATH_INFO') ; 

                                    echo '<table class="table table-hover">' ; 
                                    echo '<thead>' ; 
                                    echo '<tr>' ; 
                                    echo '<th>Variable Name</th>' ; 
                                    echo '<th>Value</th>' ; 
                                    echo '</tr>' ; 
                                    echo '</thead">' ; 
                                    echo '<tbody>' ; 
                                    foreach ($indicesServer as $arg) { 
                                        if (isset($_SERVER[$arg])) { 
                                            echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
                                        } 
                                        else { 
                                            echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
                                        } 
                                    }
                                    echo '</tbody>' ;
                                    echo '</table>' ;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">Terima Kasih Kepada : </div>
                                </div>
                                <div class="panel-body">
                                    <img src="<?php echo base_url();?>manifest/img/dev.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            
            
            
            
            
            
            