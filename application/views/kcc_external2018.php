<div id="loader" class="loader"></div> 

<div style="display:none;" id="myDiv" class="animate-bottom fixed-position">
    <div class="col-md-12" style="color:red;text-align:center;">
        <?php 
            date_default_timezone_set('Asia/Bangkok');
            echo "Time of Data Retrieval: ".date('d-m-Y')." ".date('H:i:s'); 
        ?>
    </div>
    <div class="row topper">
        <div class="col-md-3" style="padding:0px; margin-top:30px; font-size:20px">
            TOTAL INCENTIVE AMOUNT
            <form method="post" accept-charset="utf-8" action="<?php echo site_url("insentif_cont/kcc_external"); ?>">
                Month :
                <select name="Bulan" id="Bulan" onchange="this.form.submit()" class="form">
                    <?php for($i=1; $i<13; $i++) {?>
                        <option <?php if($i == $bulan){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
                Year :  
                <select name="Tahun" id="Tahun" onchange="this.form.submit()" class="form">
                    <?php for($i=2017; $i<=2018; $i++) {?>
                        <option <?php if($i == $tahun){ echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>

<!-- $$$$ buat next $$$$ -->
                <!-- <select name="Tahun" id="Tahun" onchange="this.form.submit()" class="form">
                    <?php //for($i=2017; $i<=date('Y'); $i++) {?>
                        <option <?php //if($i == $tahun){ echo 'selected'; } ?> value="<?php //echo $i; ?>"><?php //echo $i; ?></option>
                    <?php //} ?>
                </select> -->
            <!-- </form> -->
        </div>
        <div class="col-md-5" style="padding:0px; margin-top:30px; font-size:20px">
            <!-- <form method="post" accept-charset="utf-8" action="<?php //echo site_url("insentif_cont"); ?>"> -->
                <select name="Dist_id" id="Dist_id" onchange="this.form.submit()" class="form" style="margin-right:25px;">
                    <option value=null>Select Distributor</option>
                    <?php foreach ($distributor as $dist) {?>
                        <option <?php if($dist_id == $dist["distributor_id"]){ echo "selected"; } ?> value="<?php echo $dist["distributor_id"]; ?>"><?php echo $dist["distributor_id"]." - ".$dist["first_name"]." ".$dist["last_name"]; ?></option>
                    <?php } ?>
                </select>
            </form>
        </div>
        <div class="col-md-2" style="padding:0px; margin-top:30px; font-size:20px">
            <?php echo "Rp ".number_format(($total_insentif_acq+$total_insentif_trx+$total_insentif_topup),2,",","."); ?>
        </div>
    </div>

    <!-- ##### konten ##### -->
    <div class="konten">

        <div class="row akuisisi">
            <h3>NET ACQUISITION</h3>
            <table id="akuisisi" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Active KCP (Top up >= Rp 200,000)</th>
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
                        <td><?php// echo $jumlah_acq; ?></td>
                        <td><?php// echo $jumlah_acq; ?></td>
                        <td><?php// echo count($churn); ?></td>
                        <td><?php// echo $net_acq; ?></td>
                        <td><?php// echo "Rp ".number_format(45000,2,",","."); ?></td>
                        <td><?php// echo "Rp ".number_format(($total_insentif_acq),2,",","."); ?></td>
                        <td>
                            <button onclick="document.getElementById('modal-acq').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row transaksi">
            <h3>KCP MONTHLY TRANSACTION</h3>
            <table id="transaksi" class="table table-bordered table-hover">
                <tr>
                    <th> 
                        <button onclick="document.getElementById('modal-trans1').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </th>
                    <th>Pulsa</th>
                    <th>PPOB</th>
                    <th>Money Transfer</th>
                    <th>Digital Product</th>
                    <th>E-Commerce</th>
                    <th>Referal Product</th>
                </tr>
                <tr>
                    <th class="box-biru">Qty</th>
                    <td><?php echo count($pulsa);?></td>
                    <td><?php echo count($ppob);?></td>
                    <td><?php echo count($moneyTransfer);?></td>
                    <td><?php echo count($digitalProduct);?></td>
                    <td><?php echo count($eCommerce);?></td>
                    <td><?php echo count($referralProduct);?></td>
                </tr>
                <tr>
                    <th  class="box-biru">Incentive/Qty</th>
                    <td>Rp 25</td>
                    <td>Rp 200</td>
                    <td>Rp 200</td>
                    <td>Rp 200</td>
                    <td>Rp 5.000</td>
                    <td>Rp 10.000</td>
                </tr>
                <tr>
                    <th class="box-biru">Incentive</th>
                    <td class="abu"><?php echo  "Rp ".number_format(($insentif_pulsa),2,",",".");?></td>
                    <td class="abu"><?php echo  "Rp ".number_format(($insentif_ppob),2,",",".");?></td>
                    <td class="abu"><?php echo  "Rp ".number_format(($insentif_moneyTransfer),2,",",".");?></td>
                    <td class="abu"><?php echo  "Rp ".number_format(($insentif_digitalProduct),2,",",".");?></td>
                    <td class="abu"><?php echo  "Rp ".number_format(($insentif_eCommerce),2,",",".");?></td>
                    <td class="abu"><?php echo  "Rp ".number_format(($insentif_referralProduct),2,",",".");?></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td class="text-bold" colspan="6"><?php echo  "Rp ".number_format(($total_insentif_trx),2,",",".");?></td>
                </tr>
            </table>
        </div>

        <div class="row transaksi">
            <h3>KCP MONTHLY TOP UP</h3>
            <table class="table table-bordered">
                <tr>
                    <th colspan="2">
                        Main Top Up Incentive
                        <button onclick="document.getElementById('modal-tu2').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </th>
                    <th colspan="2">
                        Unique Top Up Incentive
                    </th>
                    <th colspan="3">
                        Total Top Up Incentive
                        <button onclick="document.getElementById('modal-tu1').style.display='block'" type="button" class="btn btn-default btn-xs navbar-btn btn-detail">Detail</button>
                    </th>
                </tr>
                <tr>
                    <td colspan="2"><?php echo  "Rp ".number_format($total_insentif_utama_topup,2,",",".");?></td>
                    <td colspan="2"><?php echo  "Rp ".number_format($total_insentif_unique_topup,2,",",".");?></td>
                    <td colspan="3" style="font-weight:bold;"><?php echo  "Rp ".number_format($total_insentif_topup,2,",",".");?></td>
                </tr>
                <tr>
                    <th colspan="7">Board Top Up</th>
                </tr>
                <tr>
                    <td class="calendar_box">
                        <div class="tanggal"> 1 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[1] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[1])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[1]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 2 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[2] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[2])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[2]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 3 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[3] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[3])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[3]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 4 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[4] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[4])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[4]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 5 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[5] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[5])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[5]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 6 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[6] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[6])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[6]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 7 </div>  
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[7] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[7])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[7]),2,",",".");?></div>
                    </td>
                </tr>
                <tr>
                    <td class="calendar_box">
                        <div class="tanggal"> 8 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[8] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[8])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[8]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 9 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[9] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[9])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[9]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 10 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[10] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[10])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[10]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 11 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[11] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[11])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[11]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 12 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[12] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[12])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[12]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 13 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[13] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[13])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[13]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 14 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[14] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[14])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[14]),2,",",".");?></div>
                    </td>
                </tr>
                <tr>
                    <td class="calendar_box">
                        <div class="tanggal"> 15 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[15] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[15])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[15]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 16 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[16] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[16])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[16]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 17 </div>  
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[17] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[17])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[17]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 18 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[18] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[18])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[18]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 19 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[19] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[19])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[19]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 20 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[20] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[20])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[20]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 21 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[21] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[21])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[21]),2,",",".");?></div>
                    </td>
                </tr>
                <tr>
                    <td class="calendar_box">
                        <div class="tanggal"> 22 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[22] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[22])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[22]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 23 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[23] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[23])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[23]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 24 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[24] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[24])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[24]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 25 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[25] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[25])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[25]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 26 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[26] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[26])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[26]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 27 </div>  
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[27] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[27])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[27]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 28 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[28] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[28])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[28]),2,",",".");?></div>
                    </td>
                </tr>
                <tr>
                    <td class="calendar_box">
                        <div class="tanggal"> 29 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[29] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[29])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[29]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 30 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[30] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[30])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[30]),2,",",".");?></div>
                    </td>
                    <td class="calendar_box">
                        <div class="tanggal"> 31 </div>
                        <span class="person_box"><?php echo $jumlah_orang_tanggal[31] ; ?></span>
                        <span class="person_satuan"><?php echo "Person(s)"; ?></span>
                        <div class="transaction_box"><?php echo count($tanggal[31])." Transaction(s)"; ?></div>
                        <div class="insentif_unique_topup"><?php echo  "Rp ".number_format(($insentif_unique_topup[31]),2,",",".");?></div>
                    </td>
                </tr>
            </table>
        </div>

        
    </div>
</div>

<!-- ##### modal ##### -->
<?php include 'kcc_external2018_modal.php'; ?>
