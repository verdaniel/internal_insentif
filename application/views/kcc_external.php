<div id="loader" class="loader"></div> 

<div style="display:none;" id="myDiv" class="animate-bottom">
    <div class="col-md-12" style="color:red;text-align:center;">
        <?php 
            date_default_timezone_set('Asia/Bangkok');
            echo "Time of Data Retrieval: ".date('d-m-Y')." ".date('H:i:s'); 
        ?>
    </div>
    <div class="row" style= "font-size:20px; padding:10px;">
        KCC External's KPI
        <div class="selector-bar">
            <div>
                <form method="post" accept-charset="utf-8" action="<?php echo site_url("insentif_cont/kcc_external"); ?>">
                    <select name="Dist_id" id="Dist_id" class="form" style="margin-right:25px;">
                        <option value=null>Select Distributor</option>
                        <?php foreach ($distributor as $dist) {?>
                            <option <?php if($dist_id == $dist["distributor_id"]){ echo "selected"; } ?> value="<?php echo $dist["distributor_id"]; ?>"><?php echo $dist["distributor_id"]." - ".$dist["first_name"]." ".$dist["last_name"]; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo "Rp ".number_format((($net_acq_calc*45000)+(($topupSum1*0.005)+($topupSum2*0.0075)+($topupSum3*0.01)) + (($transSum1*0.005)+($transSum2*0.0075)+($transSum3*0.01))),2,",","."); ?>
            </div>
            <div style= "margin-top:10px;">
                <!-- <form method="post" accept-charset="utf-8" action="<?php //echo site_url("insentif_cont"); ?>"> -->
                    Month :
                    <select name="Bulan" id="Bulan" class="form">
                        <?php for($i=10; $i<13; $i++) {?>
                            <option <?php if($i == $bulan){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    Year :  
                    <select name="Tahun" id="Tahun" class="form">
                        <?php for($i=2017; $i<=date('Y'); $i++) {?>
                            <option <?php if($i == $tahun){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    <button id="search-button" type="button" class="btn btn-primary btn-ber-loading" onclick="this.form.submit()">Search</button> 
                </form>
            </div>
        </div>
    </div>

    <!-- ##### konten ##### -->
    <div class="konten">
        <div class="row akuisisi">
            <h3>NET ACQUISITION</h3>
            <table id="akuisisi" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>New Acquisition (Top up >= Rp 200,000)</th>
                        <th>Churn</th>
                        <th>Net Acquisition</th>
                        <th>Incentive Per Acquisition</th>
                        <th>Incentive Amount</th>
                        <th class="kolom7">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $jumlah_acq; ?></td>
                        <td><?php echo count($churn); ?></td>
                        <td><?php echo $net_acq; ?></td>
                        <td><?php echo "Rp ".number_format(45000,2,",","."); ?></td>
                        <td><?php echo "Rp ".number_format(($net_acq_calc*45000),2,",","."); ?></td>
                        <td>
                            <button onclick="document.getElementById('modal-acq').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row topup">
            <h3>KCP MONTHLY TOP UP AMOUNT</h3>
            <table id="topup" class="table table-bordered table-hover">
                <tr>
                    <th class="kolom1">Slabs</th>
                    <th class="kolom2">Jumlah KCP Melakukan TOP UP Sesuai Slab</th>
                    <th class="kolom3">Qty Top Up</th>
                    <th class="kolom4">Top Up Amount</th>
                    <th class="kolom5">Incentive %</th>
                    <th class="kolom6">Incentive Amount</th>
                    <th class="kolom7">Action</th>
                </tr>
                <tr>
                    <td>< Rp 1,500,000</td>
                    <td><?php echo $topupPerson1; ?></td>
                    <td><?php echo $topupQty1; ?></td>
                    <td><?php echo "Rp ".number_format($topupSum1,2,",","."); ?></td>
                    <td>0.50%</td>
                    <td><?php echo "Rp ".number_format(($topupSum1*0.005),2,",","."); ?></td>
                    <td>
                        <button onclick="document.getElementById('modal-tu1').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>Rp 1,500,000 s/d 3,999,999</td>
                    <td><?php echo $topupPerson2; ?></td>
                    <td><?php echo $topupQty2; ?></td>
                    <td><?php echo "Rp ".number_format($topupSum2,2,",","."); ?></td>
                    <td>0.75%</td>
                    <td><?php echo "Rp ".number_format(($topupSum2*0.0075),2,",","."); ?></td>
                    <td>
                        <button onclick="document.getElementById('modal-tu2').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>>= Rp 4,000,000</td>
                    <td><?php echo $topupPerson3; ?></td>
                    <td><?php echo $topupQty3; ?></td>
                    <td><?php echo "Rp ".number_format($topupSum3,2,",","."); ?></td>
                    <td>1.00%</td>
                    <td><?php echo "Rp ".number_format(($topupSum3*0.01),2,",","."); ?></td>
                    <td>
                        <button onclick="document.getElementById('modal-tu3').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?php echo $topupPerson1+$topupPerson2+$topupPerson3; ?></td>
                    <td><?php echo $topupQty1+$topupQty2+$topupQty3; ?></td>
                    <td><?php echo "Rp ".number_format(($topupSum1+$topupSum2+$topupSum3),2,",","."); ?></td>
                    <td></td>
                    <td><?php echo "Rp ".number_format((($topupSum1*0.005)+($topupSum2*0.0075)+($topupSum3*0.01)),2,",","."); ?></td>
                    <td></td>
                </tr>
            </table>
        </div>


        <div class="row transaksi">
            <h3>KCP MONTHLY TRANSACTION AMOUNT</h3>
            <table id="transaksi" class="table table-bordered table-hover">
                <tr>
                    <th class="kolom1">Slabs</th>
                    <th class="kolom2">Jumlah KCP Melakukan Transaction Sesuai Slab (Exc.Money Transfer)</th>
                    <th class="kolom3">Qty Transaction</th>
                    <th class="kolom4">Transaction Amount (Exc.Money Transfer)</th>
                    <th class="kolom5">Incentive %</th>
                    <th class="kolom6">Incentive Amount</th>
                    <th class="kolom7">Action</th>
                </tr>
                <tr>
                    <td>< Rp 1,500,000</td>
                    <td><?php echo $transPerson1; ?></td>
                    <td><?php echo $transQty1; ?></td>
                    <td><?php echo "Rp ".number_format($transSum1,2,",","."); ?></td>
                    <td>0.50%</td>
                    <td><?php echo "Rp ".number_format(($transSum1*0.005),2,",","."); ?></td>
                    <td>
                        <button onclick="document.getElementById('modal-trans1').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>Rp 1,500,000 s/d 3,999,999</td>
                    <td><?php echo $transPerson2; ?></td>
                    <td><?php echo $transQty2; ?></td>
                    <td><?php echo "Rp ".number_format($transSum2,2,",","."); ?></td>
                    <td>0.75%</td>
                    <td><?php echo "Rp ".number_format(($transSum2*0.0075),2,",","."); ?></td>
                    <td>
                        <button onclick="document.getElementById('modal-trans2').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>>= Rp 4,000,000</td>
                    <td><?php echo $transPerson3; ?></td>
                    <td><?php echo $transQty3; ?></td>
                    <td><?php echo "Rp ".number_format($transSum3,2,",","."); ?></td>
                    <td>1.00%</td>
                    <td><?php echo "Rp ".number_format(($transSum3*0.01),2,",","."); ?></td>
                    <td>
                        <button onclick="document.getElementById('modal-trans3').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?php echo $transPerson1+$transPerson2+$transPerson3; ?></td>
                    <td><?php echo $transQty1+$transQty2+$transQty3; ?></td>
                    <td><?php echo "Rp ".number_format(($transSum1+$transSum2+$transSum3),2,",","."); ?></td>
                    <td></td>
                    <td><?php echo "Rp ".number_format((($transSum1*0.005)+($transSum2*0.0075)+($transSum3*0.01)),2,",","."); ?></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- modal -->
<?php include 'kcc_external_modal.php'; ?>