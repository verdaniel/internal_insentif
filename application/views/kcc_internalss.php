

<div id="loader" class="loader"></div> 

<div style="display:none;" id="myDiv" class="animate-bottom">
    <div class="col-md-12" style="color:red;text-align:center;">
        <?php 
            date_default_timezone_set('Asia/Bangkok');
            echo "Time of Data Retrieval: ".date('d-m-Y')." ".date('H:i:s'); 
        ?>
    </div>
    <div class="row" style="padding:0px; margin-top:30px; font-size:20px">
        Supervisor's KPI       
    </div>
    <div class="row selector-bar" style="margin-bottom:30px;">
        <form method="post" accept-charset="utf-8" action="<?php echo site_url("insentif_cont/kcc_internalss"); ?>">
            Supervisor : <b><?php echo $_SESSION['identity']." - ".$name_returned[0]['name']; ?></b>
        <!-- </form> -->
        <!-- <form method="post" accept-charset="utf-8" action="<?php //echo site_url("insentif_cont/retailer"); ?>"> -->
            Month :
            <select name="Bulan" id="Bulan" class="form">
                <?php for($i=1; $i<13; $i++) {?>
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
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
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
            </thead>
            <tbody>
             
                <?php foreach ($cvs_returned as $cvs) { ?>
                    <tr>
                        <td><?php echo $cvs['first_name']." ".$cvs['last_name']; ?></td> <!-- canvaser -->
                        <td><?php echo $cvs['beatguy_id']; ?></td> <!-- canvaser id -->
                        <!-- ############# TRESHOLD KPI VS ACTUAL ############### -->
                        <td><?php echo $target_usr; ?></td> <!-- usr-target -->
                        <?php foreach ($cvs_usr_achieve_returned as $cvs_usr_achieve) { ?>
                            <?php if ($cvs_usr_achieve['beatguy_id'] ==$cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_usr_achieve['usr']),0,",","."); ?></td>  <!-- usr-achieve -->
                            <?php }  ?>
                        <?php }  ?>
                        <?php foreach ($cvs_usr_minus_returned as $cvs_usr_minus) { ?>
                            <?php if ($cvs_usr_minus['beatguy_id'] ==$cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_usr_minus['usr_minus']),0,",","."); ?></td>  <!-- usr-KCP minus -->
                            <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($cvs_usr_actual_returned as $cvs_usr_actual) { ?>
                            <?php if ($cvs_usr_actual['beatguy_id'] ==$cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_usr_actual['usr_actual']),0,",","."); ?></td>   <!-- usr-actual -->
                            <?php }  ?>
                        <?php }  ?> 
                        <td><?php echo $target_dnl; ?></td> <!-- dnl-target -->
                        <?php foreach ($cvs_dnl_actual_returned as $cvs_dnl_actual) { ?>
                            <?php if ($cvs_dnl_actual['beatguy_id'] ==$cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_dnl_actual['dnl']),0,",","."); ?></td>   <!-- dnl-actual -->
                            <?php }  ?>
                        <?php }  ?> 
                        <td><?php echo number_format(($target_tu),0,",","."); ?></td> <!-- top up amount-target -->
                        <?php foreach ($cvs_tu_achieve_returned as $cvs_tu_achieve) { ?>
                            <?php if ($cvs_tu_achieve['beatguy_id'] ==$cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_tu_achieve['topup']),0,",","."); ?></td> <!-- top up amount-achieve -->
                            <?php }  ?>
                        <?php }  ?>
                        <?php foreach ($cvs_tu_negative_balance_returned as $cvs_tu_negative_balance) { ?>
                            <?php if ($cvs_tu_negative_balance['beatguy_id'] ==$cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_tu_negative_balance['tu_negative_balance']),0,",","."); ?></td>  <!-- top up amount-negative balance -->
                            <?php }  ?>
                        <?php }  ?>
                        <?php foreach ($cvs_tu_actual_returned as $cvs_tu_actual) { ?>
                            <?php if ($cvs_tu_actual['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_tu_actual['tu_actual']),0,",","."); ?></td>   <!-- top up amount-actual -->
                            <?php }  ?>
                        <?php }  ?> 
                        <td><?php echo number_format(($target_trx),0,",","."); ?></td> <!-- trx-target -->
                        <?php foreach ($cvs_trx_actual_returned as $cvs_trx_actual) { ?>
                            <?php if ($cvs_trx_actual['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_trx_actual['trx_actual']),0,",","."); ?></td>    <!-- trx-actual -->
                            <?php }  ?>
                        <?php }  ?> 
                        <td><?php echo $target_uspr; ?></td> <!-- uspr-target -->
                        <?php foreach ($cvs_uspr_actual_returned as $cvs_uspr_actual) { ?>
                            <?php if ($cvs_uspr_actual['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($cvs_uspr_actual['uspr_actual']),0,",","."); ?></td>     <!-- uspr-actual -->
                            <?php }  ?>
                        <?php }  ?> 
                        <!-- ############## Achievement % ############## -->
                        <?php foreach ($achievement_usr as $a_usr) { ?>
                            <?php if ($a_usr['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_usr['achieve']),0,",","."); ?></td>     <!-- USR -->
                            <?php }  ?>
                        <?php }  ?>  
                        <?php foreach ($achievement_dnl as $a_dnl) { ?>
                        <?php if ($a_dnl['beatguy_id'] == $cvs['beatguy_id']) { ?>
                            <td><?php echo number_format(($a_dnl['achieve']),0,",","."); ?></td>     <!-- DNL -->
                        <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($achievement_tu as $a_tu) { ?>
                        <?php if ($a_tu['beatguy_id'] == $cvs['beatguy_id']) { ?>
                            <td><?php echo number_format(($a_tu['achieve']),0,",","."); ?></td>     <!-- TOP UP AMOUNT -->
                        <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($achievement_trx as $a_trx) { ?>
                            <?php if ($a_trx['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_trx['achieve']),0,",","."); ?></td>      <!-- TRX AMOUNT -->
                            <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($achievement_uspr as $a_uspr) { ?>
                            <?php if ($a_uspr['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_uspr['achieve']),0,",","."); ?></td>       <!-- USPR -->
                            <?php }  ?>
                        <?php }  ?> 
                        <!-- ############## Achievement x Bobot % ############## -->
                        <?php foreach ($achievement_usr as $a_usr) { ?>
                            <?php if ($a_usr['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_usr['achievementXbobot']),0,",","."); ?></td>     <!-- USR -->
                            <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($achievement_dnl as $a_dnl) { ?>
                            <?php if ($a_dnl['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_dnl['achievementXbobot']),0,",","."); ?></td>     <!-- DNL -->
                            <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($achievement_tu as $a_tu) { ?>
                            <?php if ($a_tu['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_tu['achievementXbobot']),0,",","."); ?></td>     <!-- TOP UP AMOUNT -->
                            <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($achievement_trx as $a_trx) { ?>
                            <?php if ($a_trx['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_trx['achievementXbobot']),0,",","."); ?></td>      <!-- TRX AMOUNT -->
                            <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($achievement_uspr as $a_uspr) { ?>
                            <?php if ($a_uspr['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($a_uspr['achievementXbobot']),0,",","."); ?></td>       <!-- USPR -->
                            <?php }  ?>
                        <?php }  ?> 
                        <?php foreach ($total_kpi_cvs as $kpi) { ?>
                            <?php if ($kpi['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($kpi['total_kpi_cvs']),0,",","."); ?></td>       <!-- Total KPI -->
                            <?php }  ?>
                        <?php }  ?>  
                        <?php foreach ($total_kpi_cvs as $kpi) { ?>
                            <?php if ($kpi['beatguy_id'] == $cvs['beatguy_id']) { ?>
                                <td><?php echo number_format(($kpi['insentif_cvs']),0,",","."); ?></td>       <!-- Incentive -->
                            <?php }  ?>
                        <?php }  ?>
                        <!-- taro backup disini -->
                    </tr>
                <?php } ?>         
                   
            </tbody>
            <!-- total/kcc_internal.php -->
            <tr>
                <td colspan="2">Total</td>
                <td><?php echo number_format(($total_target_usr),0,",","."); ?></td><!-- usr-target -->
                <td><?php echo number_format(($total_usr_achieve),0,",","."); ?></td><!-- usr-achieve -->
                <td><?php echo number_format(($total_usr_minus),0,",","."); ?></td><!-- usr-kcp minus -->
                <td><?php echo number_format(($total_usr_actual),0,",","."); ?></td><!-- usr-actual -->
                <td><?php echo number_format(($total_target_dnl),0,",","."); ?></td><!-- dnl-target -->
                <td><?php echo number_format(($total_dnl_actual),0,",","."); ?></td><!-- dnl-actual -->
                <td><?php echo number_format(($total_target_tu),0,",","."); ?></td><!-- tu-target -->
                <td><?php echo number_format(($total_tu_achieve),0,",","."); ?></td><!-- tu-achieve -->
                <td><?php echo number_format(($total_tu_negative_balance),0,",","."); ?></td><!-- tu-negative balance -->
                <td><?php echo number_format(($total_tu_actual),0,",","."); ?></td><!-- tu-actual -->
                <td><?php echo number_format(($total_target_trx),0,",","."); ?></td><!-- trx-target -->
                <td><?php echo number_format(($total_trx_actual),0,",","."); ?></td><!-- trx-actual -->
                <td><?php echo number_format(($total_target_uspr),0,",","."); ?></td><!-- uspr-target -->
                <td><?php echo number_format(($total_uspr_actual),0,",","."); ?></td><!-- uspr_actual -->
                <!-- ############## Achievement % ############## -->
                <td><?php echo number_format(($total_usr_achievement),0,",","."); ?></td> <!-- USR -->
                <td><?php echo number_format(($total_dnl_achievement),0,",","."); ?></td> <!-- DNL -->
                <td><?php echo number_format(($total_tu_achievement),0,",","."); ?></td> <!-- TOP UP AMOUNT -->
                <td><?php echo number_format(($total_trx_achievement),0,",","."); ?></td> <!-- TRX AMOUNT -->
                <td><?php echo number_format(($total_uspr_achievement),0,",","."); ?></td> <!-- USPR -->
                <!-- ############## Achievement x Bobot % ############## -->
                <td><?php echo number_format(($total_usr_achievementXbobot),0,",","."); ?></td> <!-- USR -->
                <td><?php echo number_format(($total_dnl_achievementXbobot),0,",","."); ?></td> <!-- DNL -->
                <td><?php echo number_format(($total_tu_achievementXbobot),0,",","."); ?></td> <!-- TOP UP AMOUNT -->
                <td><?php echo number_format(($total_trx_achievementXbobot),0,",","."); ?></td> <!-- TRX AMOUNT -->
                <td><?php echo number_format(($total_uspr_achievementXbobot),0,",","."); ?></td> <!-- USPR -->
                <td><?php echo number_format(($total_kpi_spv),0,",","."); ?></td> <!-- Total KPI -->
                <td><?php echo number_format(($insentif_spv),0,",","."); ?></td> <!-- Incentive -->
            </tr>
            
        </table>
    </div>
</div>
