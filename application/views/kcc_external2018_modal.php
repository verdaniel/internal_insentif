<!-- ########## Area Modal ########## -->
    <!-- ======= modal acq (akuisisi) ======= -->
    <div id="modal-acq" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4" style=" width:90%!important;">
            <header class="w3-container w3-orange modal-campaign modal1">
                <span onclick="document.getElementById('modal-acq').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                <h2>Net Aquisition</h2>
            </header>
            <!-- konten modal -->
            <div class="w3-container">
                <div class="row">
                    <!-- tabel -->
                    <div class="col-md-7">
                        <table id="akuisisi" class="table table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th class="kolom_no">No</th>
                                    <th>KCP</th>
                                    <th>Initial Top Up</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=0; ?>
                                <?php foreach ($acq as $a) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $a['retailerid']." - ".$a['first_name']." ".$a['last_name']; ?></td>
                                        <td>
                                            <?php echo "Rp ".number_format($a['amount'],0,",","."); ?>
                                        </td>   
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- tabel -->
                    <div class="col-md-5">
                        <table id="akuisisi" class="table table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th class="kolom_no">No</th>
                                    <th>Churn</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=0; ?>
                                <?php foreach ($churn as $nama) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $nama; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- ======= modal topup 1 (list seluruh top up sebulan) ======= -->
    <div id="modal-tu1" class="w3-modal w3-animate-opacity"> <!-- class="w3-modal w3-animate-opacity" -->
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-orange modal-campaign modal1">
                <span onclick="document.getElementById('modal-tu1').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                <h2>KCP Monthly Top Up</h2>
            </header>
            <!-- konten modal -->
            <div class="w3-container">
                <div class="row">
                    <!-- tabel -->
                    <div class="col-md-12">
                        <table id="topup" class="table table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th class="kolom_no">No</th>
                                    <th>KCP</th>
                                    <th>Time</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=0; ?>
                                <?php foreach ($raw_tu as $tu) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $tu['retailerid']." - ".$tu['first_name']." ".$tu['last_name']; ?></td>
                                        <td><?php echo $tu['dateofpayment']; ?></td>
                                        <td>
                                            <?php echo "Rp ".number_format($tu['amount'],0,",","."); ?>
                                        </td>   
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ======= modal topup 2 (list frekuensi top up tiap KCP dalam sebulan)======= -->
    <div id="modal-tu2" class="w3-modal w3-animate-opacity"> <!-- class="w3-modal w3-animate-opacity" -->
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-orange modal-campaign modal1">
                <span onclick="document.getElementById('modal-tu2').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                <h2>KCP Monthly Top Up</h2>
            </header>
            <!-- konten modal -->
            <div class="w3-container">
                <div class="row">
                    <!-- tabel -->
                    <div class="col-md-12">
                        <table id="topup" class="table table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>KCP</th>
                                    <th>Freq</th>
                                    <th>Incentive</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=1; $i<=count($id_tanggal); $i++) { ?>
                                    <?php foreach ($id_tanggal[$i] as $nama => $freq) { ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $nama ; ?></td>
                                            <td><?php echo $freq; ?></td>
                                            <td>
                                                <?php 
                                                    switch ($freq) {
                                                        case '1':
                                                            $insentif_utama_topup= 5000;
                                                            break;
                                                        
                                                        default:
                                                            # code...
                                                            $insentif_utama_topup= 10000;
                                                            break;
                                                    }
                                                    echo $insentif_utama_topup;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- ======= modal transaksi ======= -->
    <div id="modal-trans1" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-orange modal-campaign modal1">
                <span onclick="document.getElementById('modal-trans1').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                <h2>KCP Monthly Transaction</h2>
            </header>
            <!-- konten modal -->
            <div class="w3-container">
                <div class="row">
                    <!-- tabel -->
                    <div class="col-md-12">
                        <table id="trans1" class="table table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th class="kolom_no">No</th>
                                    <th>KCP</th>
                                    <th>Time</th>
                                    <th>Transaction Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=0; ?>
                                <?php foreach ($referralProduct as $data) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $data['retailer_id']." - ".$data['first_name']." ".$data['last_name']; ?></td>
                                        <td><?php echo $data['transaction_date']; ?></td>
                                        <td>
                                            <?php echo "Referral Product"; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                               
                                <?php foreach ($digitalProduct as $data) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $data['retailer_id']." - ".$data['first_name']." ".$data['last_name']; ?></td>
                                        <td><?php echo $data['transaction_date']; ?></td>
                                        <td>
                                            <?php echo "Digital Product"; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php foreach ($moneyTransfer as $data) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $data['retailer_id']." - ".$data['first_name']." ".$data['last_name']; ?></td>
                                        <td><?php echo $data['transaction_date']; ?></td>
                                        <td>
                                            <?php echo "Money Transfer"; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php foreach ($ppob as $data) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $data['retailer_id']." - ".$data['first_name']." ".$data['last_name']; ?></td>
                                        <td><?php echo $data['transaction_date']; ?></td>
                                        <td>
                                            <?php echo "PPOB"; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php foreach ($pulsa as $data) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $data['retailer_id']." - ".$data['first_name']." ".$data['last_name']; ?></td>
                                        <td><?php echo $data['transaction_date']; ?></td>
                                        <td>
                                            <?php echo "Pulsa"; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- ======= modal aktif topup (yang akumulasi topup sebulan >=200rb) ======= -->
    <div id="modal-active-tu" class="w3-modal w3-animate-opacity"> <!-- class="w3-modal w3-animate-opacity" -->
        <div class="w3-modal-content w3-card-4">
            <header class="w3-container w3-orange modal-campaign modal1">
                <span onclick="document.getElementById('modal-active-tu').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                <h2>KCP Active</h2>
            </header>
            <!-- konten modal -->
            <div class="w3-container">
                <div class="row">
                    <!-- tabel -->
                    <div class="col-md-12">
                        <table id="topup" class="table table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th class="kolom_no">No</th>
                                    <th>KCP</th>
                                    <th>Qty</th>
                                    <th>Top Up Accumulation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=0; ?>
                                <?php foreach ($active_kcp as $kcp) { ?>
                                    <?php $nomor++; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $kcp['retailerid']." - ".$kcp['first_name']." ".$kcp['last_name']; ?></td>
                                        <td><?php echo $kcp['freq']; ?></td>
                                        <td>
                                            <?php echo "Rp ".number_format($kcp['total'],0,",","."); ?>
                                        </td>   
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    