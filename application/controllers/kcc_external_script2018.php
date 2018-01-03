<?php

// ############# Set Nilai Insentif Disini ! ############

//kalau kcc eksternal porsi insentifnya 75%
if($_SESSION['mode']== "superkcc" || $_SESSION['mode']== "superkccss"){  
    $pengali_insentif = 1;
}

//kalau skcc porsi insentifnya 25%
elseif($_SESSION['mode']== "external" || $_SESSION['mode']== "externalss"){
    $pengali_insentif = 1;
}


$data['insentifPer_acq']               = $pengali_insentif * 40000;
$data['insentifPer_pulsa']             = $pengali_insentif * 18;
$data['insentifPer_ppob']              = $pengali_insentif * 150;
$data['insentifPer_moneyTransfer']     = $pengali_insentif * 150;
$data['insentifPer_digitalProduct']    = $pengali_insentif * 150;
// $data['insentifPer_eCommerce']         = $pengali_insentif * 5000;
$data['insentifPer_referralProduct']    = $pengali_insentif * 75000;

// ############# Akuisisi #############
$returned_new_acq = $this->Insentif_model_kcc_external2018->get_new_acquisition_tu($Dist_id, $bulan, $tahun);
$data['acq']= $returned_new_acq[0];

// kasih nilai default jika hasil query "get_new_acquisition_tu" null
if($returned_new_acq != null){
    //new acq initial deposit >= 200rb
    $data['jumlah_acq']= $returned_new_acq[1];
}
else { //jika tidak ada yang diakuisisi >=200rb bulan ini
    $data['jumlah_acq']= 0;
}

// ===== bagian awal penghitung churn
$all_acq = $this->Insentif_model_kcc_external2018->get_acquisition_list($Dist_id, $bulan, $tahun);
$last_month_id = $this->Insentif_model_kcc_external2018->topup_list($Dist_id, $bulan, $tahun);

// untuk menghilangkan index 'identity' agar bisa pakai array_intersect
$all_acq_compare=[];
$last_month_id_compare=[];
for ($i=0; $i < count($all_acq); $i++) { 
    array_push($all_acq_compare, $all_acq[$i]['identity']);
}
for ($p=0; $p < count($last_month_id); $p++) {
        array_push($last_month_id_compare, $last_month_id[$p]['identity']);
}

// cek apakah yang terakuisisi bulan lalu, belanja pada bulan ini, data yang sama akan menjadi array $all_acq_belanja
//array yang menambung list orang-orang yang terakuisisi bulan lalu & belanja di bulan ini
$all_acq_belanja= array_intersect($all_acq_compare, $last_month_id_compare);

//cari selisih $all_acq_name yang tidak ada dalam $all_acq_belanja
$churn=array_diff($all_acq_compare, $all_acq_belanja);

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

$data['total_insentif_acq']= $data['net_acq_calc']*$data['insentifPer_acq'];

// ############# Transaksi #############
$returned_tr= $this->Insentif_model_kcc_external2018->get_transaction($Dist_id, $bulan, $tahun);
$data['pulsa']= $returned_tr[0];
$data['ppob']= $returned_tr[1];
$data['moneyTransfer']= $returned_tr[2];
$data['digitalProduct']= $returned_tr[3];
// $data['eCommerce']= $returned_tr[4];
$data['referralProduct']= $returned_tr[4];

// hitung insentif per jenis transaksi
$data['insentif_pulsa']             = count($data['pulsa'])          * $data['insentifPer_pulsa'] ;
$data['insentif_ppob']              = count($data['ppob'])           * $data['insentifPer_ppob'] ;
$data['insentif_moneyTransfer']     = count($data['moneyTransfer'])  * $data['insentifPer_moneyTransfer'] ;
$data['insentif_digitalProduct']    = count($data['digitalProduct']) * $data['insentifPer_digitalProduct'] ;
// $data['insentif_eCommerce']         = count($data['eCommerce'])      * $data['insentifPer_eCommerce'] ;
$data['insentif_referralProduct']   = count($data['referralProduct'])* $data['insentifPer_referralProduct'] ;

$data['insentif_eCommerce'] = 0;
$data['total_insentif_trx']=$data['insentif_pulsa']+$data['insentif_ppob']+$data['insentif_moneyTransfer']+$data['insentif_digitalProduct']+$data['insentif_eCommerce']+$data['insentif_referralProduct'];
// ############# Top Up #############
$returned_tu= $this->Insentif_model_kcc_external2018->get_topup($Dist_id, $bulan, $tahun);

for ($i=1; $i <32 ; $i++) { 
    // penampung Data kcp
    $tanggal[$i]= $returned_tu[0][$i-1];

    // penampung ID kcp & jumlah top up
    $id_tanggal[$i]= $returned_tu[1][$i-1];

    // hitung jumlah orang top up per hari
    $jumlah_orang_tanggal[$i]=count($returned_tu[1][$i-1]);

    //insentif unique 
    if($jumlah_orang_tanggal[$i]>=30){
        $insentif_unique_topup[$i]= $jumlah_orang_tanggal[$i]*2500;
    }
    else{
        $insentif_unique_topup[$i]=0;
    }
}

for ($i=1; $i<=count($id_tanggal); $i++) { 
    //jika di tanggal itu ada transaksi
    if (count($id_tanggal[$i])!=0) {
        foreach ($id_tanggal[$i] as $nama => $freq) { 
            switch ($freq) {
                case '1':
                    $insentif_utama_topup= 5000;
                    break;
                
                default:
                    # code...
                    $insentif_utama_topup= 10000;
                    break;
            }
            $array_insentif_utama_topup[]= $insentif_utama_topup;
        } 
    }
    //jika di tanggal itu tidak ada transaksi
    else{
        $array_insentif_utama_topup[]= 0;
    }
} 

$data['raw_tu']= $returned_tu[2];
$data['tanggal']= $tanggal;
$data['id_tanggal']= $id_tanggal;
$data['jumlah_orang_tanggal']= $jumlah_orang_tanggal;
$data['insentif_unique_topup']=$insentif_unique_topup;
$data['total_insentif_utama_topup']=array_sum($array_insentif_utama_topup);
$data['total_insentif_unique_topup']=array_sum($insentif_unique_topup);
$data['total_insentif_topup']= $data['total_insentif_unique_topup']+$data['total_insentif_utama_topup'];

// ############# POSM #############
$data['insentif_posm']= 10000;

$returned_active_kcp = $this->Insentif_model_kcc_external2018->get_active_kcp($Dist_id, $bulan, $tahun);
$data['active_kcp']= $returned_active_kcp[0];
$data['jumlah_active_kcp']= $returned_active_kcp[1];

$data['total_insentif_posm']= $data['insentif_posm']*$data['jumlah_active_kcp'];