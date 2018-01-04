    <nav class="navbar navbar-default .navbar-fixed-top" style="height:60px; margin-bottom:0px;">
    <!-- <?php //echo $_session['progress']; ?> -->
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" style="font-size:20px;padding-top:0px;padding-bottom:5px;">
                    <!-- <img src="" alt=""> -->
                    <img src="https://www.kioson.com/wp-content/uploads/2017/10/logo-web-color.png" height="60px"/>
                </a>
            </div>

            <!-- munculkan Pills jika authority=1 (ASM) -->
            <?php if($_SESSION['authority'] == 1){ echo 
                '<ul class="nav nav-pills">
                    <li role="presentation"';
                    if($_SESSION['mode']  == 'external'){ 
                        echo  'class="active"><a style=" text-align: center; width:150px;">External KCC</a></li>';
                    }
                    else {
                        echo  'class="btn-ber-loading"><a style=" text-align: center; width:150px;" href="'; echo base_url(); echo'index.php/insentif_cont/kcc_external">External KCC</a></li>';
                    }
                    
                    echo
                    '<li role="presentation"';
                    if($_SESSION['mode']  == 'internal'){ 
                        echo  'class="active"><a style=" text-align: center; width:150px;">Internal KCC</a></li>';
                    }
                    else {
                        echo  'class="btn-ber-loading"><a style=" text-align: center; width:150px;" href="'; echo base_url(); echo'index.php/insentif_cont/kcc_internal">Internal KCC</a></li>';
                    }

                    echo
                    '<li role="presentation"';
                    if($_SESSION['mode']  == 'asm'){ 
                        echo  'class="active"><a style=" text-align: center; width:150px;">ASM</a></li>';
                    }
                    else {
                        echo  'class="btn-ber-loading"><a style=" text-align: center; width:150px;" href="'; echo base_url(); echo'index.php/insentif_cont/asm">ASM</a></li>';
                    }  
                    
                    echo
                    '<li role="presentation"';
                    if($_SESSION['mode']  == 'superkcc'){ 
                        echo  'class="active"><a style=" text-align: center; width:150px;">Super KCC</a></li>';
                    }
                    else {
                       echo  'class="btn-ber-loading"><a style=" text-align: center; width:150px;" href="'; echo base_url(); echo'index.php/insentif_cont/kcc_super">Super KCC</a></li>';
                    }

                    echo
                    '<div class="navbar-right">
                        <a style=" text-align: center; width:150px;" href="';?><?php echo base_url(); ?><?php echo 'index.php/auth_cont/logout">
                            <button type="button" class="btn btn-default navbar-btn btn-logout">Sign Out</button>
                        </a>
                    </div>
                </ul>';
            }  else{ echo 
                '<div class="navbar-right">
                    <a href="';?><?php echo base_url(); ?><?php echo 'index.php/auth_cont/logout">
                        <button type="button" class="btn btn-default navbar-btn btn-logout">Sign Out</button>
                    </a>
                </div>';
            } ?>
            
            
        </div>
    </nav>

    <div id="loader" class="loader"></div> 
    <!-- <div id="loader2" class="loader"></div>  -->

    <div class="kontener***">