<!-- ########## Area Modal ########## -->
    <!-- ======= modal acq ======= -->
    <div class="w3-container modal_acq">
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
                                                <?php echo "Rp ".number_format($a['amount'],2,",","."); ?>
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
    </div>

    <!-- ======= modal topup1 ======= -->
    <div class="w3-container modal_tu1">
        <div id="modal-tu1" class="w3-modal w3-animate-opacity">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-orange modal-campaign modal1">
                    <span onclick="document.getElementById('modal-tu1').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                    <h2>KCP Monthly Top Up 1st Slabs</h2>
                </header>
                <!-- konten modal -->
                <div class="w3-container">
                    <div class="row">
                        <!-- tabel -->
                        <div class="col-md-12">
                            <table id="topup1" class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th class="kolom_no">No</th>
                                        <th>KCP</th>
                                        <th>Frequency</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor=0; ?>
                                    <?php foreach ($topup1 as $tu) { ?>
                                        <?php $nomor++; ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $tu['retailer_id']." - ".$tu['first_name']." ".$tu['last_name']; ?></td>
                                            <td><?php echo $tu['freq']; ?></td>
                                            <td>
                                                <?php echo "Rp ".number_format($tu['total'],2,",","."); ?>
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
    </div>
    <!-- ======= modal topup2 ======= -->
    <div class="w3-container modal_tu2">
        <div id="modal-tu2" class="w3-modal w3-animate-opacity">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-orange modal-campaign modal1">
                    <span onclick="document.getElementById('modal-tu2').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                    <h2>KCP Monthly Top Up 2nd Slabs</h2>
                </header>
                <!-- konten modal -->
                <div class="w3-container">
                    <div class="row">
                        <!-- tabel -->
                        <div class="col-md-12">
                            <table id="topup2" class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th class="kolom_no">No</th>
                                        <th>KCP</th>
                                        <th>Frequency</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor=0; ?>
                                    <?php foreach ($topup2 as $tu) { ?>
                                        <?php $nomor++; ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $tu['retailer_id']." - ".$tu['first_name']." ".$tu['last_name']; ?></td>
                                            <td><?php echo $tu['freq']; ?></td>
                                            <td>
                                                <?php echo "Rp ".number_format($tu['total'],2,",","."); ?>
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
    </div>
    <!-- ======= modal topup3 ======= -->
    <div class="w3-container modal_tu3">
        <div id="modal-tu3" class="w3-modal w3-animate-opacity">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-orange modal-campaign modal1">
                    <span onclick="document.getElementById('modal-tu3').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                    <h2>KCP Monthly Top Up 3rd Slabs</h2>
                </header>
                <!-- konten modal -->
                <div class="w3-container">
                    <div class="row">
                        <!-- tabel -->
                        <div class="col-md-12">
                            <table id="topup3" class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th class="kolom_no">No</th>
                                        <th>KCP</th>
                                        <th>Frequency</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor=0; ?>
                                    <?php foreach ($topup3 as $tu) { ?>
                                        <?php $nomor++; ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $tu['retailer_id']." - ".$tu['first_name']." ".$tu['last_name']; ?></td>
                                            <td><?php echo $tu['freq']; ?></td>
                                            <td>
                                                <?php echo "Rp ".number_format($tu['total'],2,",","."); ?>
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
    </div>

    <!-- ======= modal trans1 ======= -->
    <div class="w3-container modal_trans1">
        <div id="modal-trans1" class="w3-modal w3-animate-opacity">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-orange modal-campaign modal1">
                    <span onclick="document.getElementById('modal-trans1').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                    <h2>KCP Monthly Transaction 1st Slabs</h2>
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
                                        <th>Frequency</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor=0; ?>
                                    <?php foreach ($transaction1 as $trans) { ?>
                                        <?php $nomor++; ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $trans['retailer_id']." - ".$trans['first_name']." ".$trans['last_name']; ?></td>
                                            <td><?php echo $trans['freq']; ?></td>
                                            <td>
                                                <?php echo "Rp ".number_format($trans['total'],2,",","."); ?>
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
    </div>
    <!-- ======= modal trans2 ======= -->
    <div class="w3-container modal_trans2">
        <div id="modal-trans2" class="w3-modal w3-animate-opacity">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-orange modal-campaign modal1">
                    <span onclick="document.getElementById('modal-trans2').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                    <h2>KCP Monthly Transaction 2nd Slabs</h2>
                </header>
                <!-- konten modal -->
                <div class="w3-container">
                    <div class="row">
                        <!-- tabel -->
                        <div class="col-md-12">
                            <table id="trans2" class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th class="kolom_no">No</th>
                                        <th>KCP</th>
                                        <th>Frequency</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor=0; ?>
                                    <?php foreach ($transaction2 as $trans) { ?>
                                        <?php $nomor++; ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $trans['retailer_id']." - ".$trans['first_name']." ".$trans['last_name']; ?></td>
                                            <td><?php echo $trans['freq']; ?></td>
                                            <td>
                                                <?php echo "Rp ".number_format($trans['total'],2,",","."); ?>
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
    </div>
    <!-- ======= modal trans3 ======= -->
    <div class="w3-container modal_trans3">
        <div id="modal-trans3" class="w3-modal w3-animate-opacity">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container w3-orange modal-campaign modal1">
                    <span onclick="document.getElementById('modal-trans3').style.display='none'" class="w3-button w3-large w3-display-topright w3-xbtn">&times;</span>
                    <h2>KCP Monthly Transaction 3rd Slabs</h2>
                </header>
                <!-- konten modal -->
                <div class="w3-container">
                    <div class="row">
                        <!-- tabel -->
                        <div class="col-md-12">
                            <table id="trans3" class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th class="kolom_no">No</th>
                                        <th>KCP</th>
                                        <th>Frequency</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor=0; ?>
                                    <?php foreach ($transaction3 as $trans) { ?>
                                        <?php $nomor++; ?>
                                        <tr>
                                            <td><?php echo $nomor; ?></td>
                                            <td><?php echo $trans['retailer_id']." - ".$trans['first_name']." ".$trans['last_name']; ?></td>
                                            <td><?php echo $trans['freq']; ?></td>
                                            <td>
                                                <?php echo "Rp ".number_format($trans['total'],2,",","."); ?>
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
    </div>