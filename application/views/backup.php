
    





    <!-- navbar lama (dropdown)-->
    <?php if($_SESSION['authority'] == 1){ echo 
    '<div class="navbar-left">
        <form method="post" accept-charset="utf-8" action="';?><?php echo site_url("insentif_cont"); ?> <?php echo '">
            <select name="mode" id="mode" onchange="this.form.submit()" class="form" style="margin-top:20px;">
                <option';?> <?php if($this->uri->segment(2) == "kcc_external"){ echo "selected"; } ?> <?php echo 'value="external_kcc">External KCC</option>
                <option';?> <?php if($this->uri->segment(2) == "kcc_internal"){ echo "selected"; } ?> <?php echo 'value="internal_kcc">Internal KCC (SPV)</option>
                <option';?> <?php if($this->uri->segment(2) == "asm"){ echo "selected"; } ?> <?php echo 'value="asm">ASM</option>
            </select>
        </form>
    </div>'; } ?>
<!-- selector-bar external kcc view 2017 -->
<div class="row">
    <div class="col-md-3" style="padding:0px; margin-top:30px; font-size:20px">
        TOTAL INCENTIVE AMOUNT
        <form method="post" accept-charset="utf-8" action="<?php echo site_url("insentif_cont/kcc_external"); ?>">
            Month :
            <select name="Bulan" id="Bulan" class="dropdown-ber-loading" onchange="this.form.submit()" class="form">
                <?php for($i=10; $i<13; $i++) {?>
                    <option <?php if($i == $bulan){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
            Year :  
            <select name="Tahun" id="Tahun" class="dropdown-ber-loading" onchange="this.form.submit()" class="form">
                <?php for($i=2017; $i<=date('Y'); $i++) {?>
                    <option <?php if($i == $tahun){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>

    </div>
    <div class="col-md-5" style="padding:0px; margin-top:30px; font-size:20px">
        <!-- <form method="post" accept-charset="utf-8" action="<?php //echo site_url("insentif_cont"); ?>"> -->
            <select name="Dist_id" id="Dist_id" class="dropdown-ber-loading" onchange="this.form.submit()" class="form" style="margin-right:25px;">
                <option value=null>Select Distributor</option>
                <?php foreach ($distributor as $dist) {?>
                    <option <?php if($dist_id == $dist["distributor_id"]){ echo "selected"; } ?> value="<?php echo $dist["distributor_id"]; ?>"><?php echo $dist["distributor_id"]." - ".$dist["first_name"]." ".$dist["last_name"]; ?></option>
                <?php } ?>
            </select>
        </form>
    </div>
    <div class="col-md-2" style="padding:0px; margin-top:30px; font-size:20px">
        <?php echo "Rp ".number_format((($net_acq_calc*45000)+(($topupSum1*0.005)+($topupSum2*0.0075)+($topupSum3*0.01)) + (($transSum1*0.005)+($transSum2*0.0075)+($transSum3*0.01))),2,",","."); ?>
    </div>
</div>