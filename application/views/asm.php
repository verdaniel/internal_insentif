

<div style="display:none;" id="myDiv" class="animate-bottom">
    <div class="col-md-12" style="color:red;text-align:center;">
        <?php 
            date_default_timezone_set('Asia/Bangkok');
            echo "Time of Data Retrieval: ".date('d-m-Y')." ".date('H:i:s'); 
        ?>
    </div>
    <div class="row" style="padding:0px; margin-top:30px; font-size:20px">
        ASM's KPI       
    </div>
    <div class="row selector-bar" style="margin-bottom:30px;">
        <form method="post" accept-charset="utf-8" action="<?php echo site_url("insentif_cont/asm"); ?>">
            Region :
            <select name="region" id="region" class="form" style="margin-right:25px;">
                <option value=null>Select Region</option>
                <?php foreach ($region_returned as $rgn) {?>
                    <option <?php if($region_selected == $rgn["state"]){ echo "selected"; } ?> value="<?php echo $rgn["state"]; ?>"><?php echo $rgn["state"]; ?></option>
                <?php } ?>
            </select>
        <!-- </form> -->
        <!-- <form method="post" accept-charset="utf-8" action="<?php //echo site_url("insentif_cont/retailer"); ?>"> -->
            Month :
            <select name="Bulan" id="Bulan" class="form">
                <?php for($i=10; $i<13; $i++) {?>
                    <option <?php if($i == $bulan){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
            Year :  
            <select name="Tahun" id="Tahun" class="form">
                <?php for($i=2017; $i<= date('Y'); $i++) {?>
                    <option <?php if($i == $tahun){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <button id="search-button" type="button" class="btn btn-primary btn-ber-loading" onclick="this.form.submit()">Search</button> 
        </form>
    </div>



    <!-- konten -->
    <div class="row konten-cvs">
        <table id="topup" class="table table-bordered table-hover">
            <tr>
                <th rowspan="3">Supervisor</th>
                <th rowspan="3">KCC ID</th>
                <th rowspan="3">Canvaser</th>
                <th rowspan="3">CVS ID</th>
                <th colspan="14">TRESHOLD KPI VS ACTUAL</th>
                <th colspan="5">Achievement % </th>
                <th colspan="5">Achievement x Bobot %</th>
                <th rowspan="3">TOTAL KPI</th>
                <th rowspan="3">INCENTIVE</th>
            </tr>
            <tr>
                <th colspan="4">USR</th>
                <th colspan="2">DNL</th>
                <th colspan="4">TOP UP AMOUNT </th>
                <th colspan="2">TRX AMOUNT</th>
                <th colspan="2">USPR </th>
                <th rowspan="2">USR</th>
                <th rowspan="2">DNL</th>
                <th rowspan="2">TOP UP AMOUNT</th>
                <th rowspan="2">TRX AMOUNT</th>
                <th rowspan="2">USPR</th>
                <th rowspan="2">USR</th>
                <th rowspan="2">DNL</th>
                <th rowspan="2">TOP UP AMOUNT</th>
                <th rowspan="2">TRX AMOUNT</th>
                <th rowspan="2">USPR</th>
            </tr>
            <tr>
                <th>TARGET</th>
                <th>ACHIEVE</th>
                <th>KCP Minus</th>
                <th>ACTUAL</th>
                <th>TARGET</th>
                <th>ACTUAL</th>
                <th>TARGET</th>
                <th>ACHIEVE</th>
                <th>NEGATIVE BALANCE</th>
                <th>ACTUAL</th>
                <th>TARGET </th>
                <th>ACTUAL</th>
                <th>TARGET</th>
                <th>ACTUAL</th>
            </tr>
            <?php $dist_sebelumya="lala"; foreach ($cvs_returned as $cvs) { ?>
                <tr>
                    <?php if($cvs ['distributor_id'] != $dist_sebelumya) {?>
                        <td rowspan=<?php echo $kcc_counts[$cvs['distributor_id']]; ?> ><?php echo $cvs['dist_fn']." ".$cvs['dist_ln']; ?></td> <!-- supervisor -->
                        <td rowspan=<?php echo $kcc_counts[$cvs['distributor_id']]; ?> ><?php echo $cvs['distributor_id']; ?></td> <!-- KCC id -->
                    <?php } $dist_sebelumya = $cvs ['distributor_id']; ?>
                    <td><?php echo $cvs['cvs_fn']." ".$cvs['cvs_ln']; ?></td> <!-- canvaser -->
                    <td><?php echo $cvs['beatguy_id']; ?></td> <!-- canvaser id -->
                    <!-- ############# TRESHOLD KPI VS ACTUAL ############### -->
                    <td><?php echo $target_usr; ?></td> <!-- usr-target -->
                    <td>asd</td> <!-- usr-achieve -->
                    <td></td> <!-- usr-KCP minus -->
                    <td></td> <!-- usr-actual -->
                    <td><?php echo $target_dnl; ?></td> <!-- dnl-target -->
                    <td></td> <!-- dnl-actual -->
                    <td><?php echo number_format(($target_tu),2,",","."); ?></td> <!-- top up amount-target -->
                    <?php foreach ($cvs_tu as $tu) { ?>
                        <?php if($tu['beatguy_id'] == $cvs ['beatguy_id'] ) {?>
                            <td><?php echo number_format(($tu['total_tu']),2,",","."); ?></td> <!-- top up amount-achieve -->
                        <?php } ?>
                    <?php } ?>
                    <td></td> <!-- top up amount-negative balance -->
                    <td></td> <!-- top up amount-actual -->
                    <td><?php echo number_format(($target_tu),2,",","."); ?></td> <!-- trx-target -->
                    <td></td> <!-- trx-actual -->
                    <td><?php echo $target_uspr ?></td> <!-- uspr-target -->
                    <td></td> <!-- uspr-actual -->
                    <!-- ############## Achievement % ############## -->
                    <td></td> <!-- USR -->
                    <td></td> <!-- DNL -->
                    <td></td> <!-- TOP UP AMOUNT -->
                    <td></td> <!-- TRX AMOUNT -->
                    <td></td> <!-- USPR -->
                    <!-- ############## Achievement x Bobot % ############## -->
                    <td></td> <!-- USR -->
                    <td></td> <!-- DNL -->
                    <td></td> <!-- TOP UP AMOUNT -->
                    <td></td> <!-- TRX AMOUNT -->
                    <td></td> <!-- USPR -->
                    <td></td> <!-- Total KPI -->
                    <td></td> <!-- Incentive -->
                
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4">Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
             	  	  	  	  	  	  	  	   	  	 	 	  

        </table>
    </div>

</div>
