        <?php
        if($this->uri->segment(2)=="dashboard"){
            $dashboard = "active";
            $kelola = "";
        }else
        if($this->uri->segment(2)=="kelola"){
            $dashboard = "";
            $kelola = "active";
        }else{
            $dashboard = "";
            $kelola = "active";
        }
        ?>
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
                        <li class="<?php echo $dashboard;?>"><a href="<?php echo site_url(); ?>/user/dashboard"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
                        <li class="dropdown <?php echo $kelola;?>">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-list-alt"></span> 
                                Kelola Data Sekolah <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url(); ?>/user/kelola/lihat_data"><span class="glyphicon glyphicon-eye-open"></span> Lihat Data</a></li>
                                <li><a href="<?php echo site_url(); ?>/user/kelola/tambah_data"><span class="glyphicon glyphicon-plus"></span> Tambah Data</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo site_url(); ?>/user/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                    <!--form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form-->
                    <!--ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php echo site_url(); ?>/user/logout">
                            <span class="glyphicon glyphicon-log-out"></span> Logout
                            </a></li>
                    </ul-->
                </div><!-- /.navbar-collapse -->
            </div><!-- /.navbar-fluid-->
        </nav>

        <div class="container-fluid" style="margin-top: 60px;">
            <?php if($message!="") { ?>
            <div class="alert alert-info" style="margin-top: 5px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <?php echo $message; ?>
            </div>
            <?php } ?>
            <div class="row">
                <?php echo $child; ?>
            </div>
        </div>
        
        