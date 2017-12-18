<?php
// ############# Akuisisi #############
$returned_new_acq = $this->Insentif_model_kcc_external->get_new_acquisition_tu($Dist_id, $bulan, $tahun);
$data['acq']= $returned_new_acq[0];

if($returned_new_acq != null){
    //new acq initial deposit >= 200rb
    $data['jumlah_acq']= $returned_new_acq[1];
}
else { //jika tidak ada yang diakuisisi >=200rb bulan ini
    $data['jumlah_acq']= 0;
}
// ===== bagian awal penghitung churn

$all_acq = $this->Insentif_model_kcc_external->get_acquisition_list($Dist_id, $bulan, $tahun);
$last_month_id = $this->Insentif_model_kcc_external->topup_list($Dist_id, $bulan, $tahun);


// menyatukan nama depan & nama belakang
$all_acq_name=[];
for ($i=0; $i < count($all_acq); $i++) { 
    array_push($all_acq_name, $all_acq[$i]['retailer_id']." - ".$all_acq[$i]['first_name']." ".$all_acq[$i]['last_name']);
}

// cek apakah yang terakuisisi belanja pada bulan lalu
$all_acq_belanja=[];
for ($o=0; $o <count($all_acq) ; $o++) { 
    for ($i=0; $i < count($last_month_id); $i++) { 
        if ($last_month_id[$i]['retailerid'] == $all_acq[$o]['retailer_id']) {
            array_push($all_acq_belanja, $all_acq[$o]['retailer_id']." - ".$all_acq[$o]['first_name']." ".$all_acq[$o]['last_name']);
        }
    }
}

//cari selisih $all_acq_name yang tidak ada dalam $all_acq_belanja
$churn=array_diff($all_acq_name, $all_acq_belanja);

$data['churn'] = $churn;
$data['net_acq'] = $data['jumlah_acq'] - count($churn);

// jika net_acq minus
if($data['net_acq'] <0) {
    $data['net_acq_calc']= 0;
}
else{
    $data['net_acq_calc']= $data['net_acq'];
}
// ===== bagian akhir penghitung churn

############# Top up ###########
// topup slab1
$returned_tu_1= $this->Insentif_model_kcc_external->get_topup_slab1($Dist_id, $bulan, $tahun);
$data['topup1']= $returned_tu_1[0];
$data['topupPerson1']= $returned_tu_1[1];
$data['topupQty1']= $returned_tu_1[2];
$data['topupSum1']= $returned_tu_1[3];
// topup slab2
$returned_tu_2= $this->Insentif_model_kcc_external->get_topup_slab2($Dist_id, $bulan, $tahun);
$data['topup2']= $returned_tu_2[0];
$data['topupPerson2']= $returned_tu_2[1];
$data['topupQty2']= $returned_tu_2[2];
$data['topupSum2']= $returned_tu_2[3];

// topup slab3
$returned_tu_3= $this->Insentif_model_kcc_external->get_topup_slab3($Dist_id, $bulan, $tahun);
$data['topup3']= $returned_tu_3[0];
$data['topupPerson3']= $returned_tu_3[1];
$data['topupQty3']= $returned_tu_3[2];
$data['topupSum3']= $returned_tu_3[3];

// ############# Transaksi ###########
$returned_trx= $this->Insentif_model_kcc_external->get_transaction($Dist_id, $bulan);

// trans slab1
$returned_tr_1= $returned_trx[0];
$data['transaction1']= $returned_tr_1[0];
$data['transPerson1']= $returned_tr_1[1];
$data['transQty1']= $returned_tr_1[2];
$data['transSum1']= $returned_tr_1[3];

// trans slab2
$returned_tr_2= $returned_trx[1];
$data['transaction2']= $returned_tr_2[0];
$data['transPerson2']= $returned_tr_2[1];
$data['transQty2']= $returned_tr_2[2];
$data['transSum2']= $returned_tr_2[3];

// trans slab3
$returned_tr_3= $returned_trx[2];
$data['transaction3']= $returned_tr_3[0];
$data['transPerson3']= $returned_tr_3[1];
$data['transQty3']= $returned_tr_3[2];
$data['transSum3']= $returned_tr_3[3];