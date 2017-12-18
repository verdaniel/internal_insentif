<?php
//Get the value from the form
$bulan = $this->input->post('Bulan');
$tahun = $this->input->post('Tahun');


// Set target disini
$data['target_usr'] = 120;
$data['target_dnl'] = 60;
$data['target_tu'] = 480000000;
$data['target_trx'] = 360000000;
$data['target_uspr'] = 12;

$max_achievement_usr= 100;
$max_achievement_dnl= 120;
$max_achievement_tu= 120;
$max_achievement_trx= 120;
$max_achievement_uspr= 120;

$bobot_usr= 25;
$bobot_dnl= 15;
$bobot_tu= 25;
$bobot_trx= 25;
$bobot_uspr= 10;



if($bulan == null){
    $data['bulan']= date('m');
    $bulan=date('m');
}
else{
    $data['bulan'] = $bulan;
}
if($tahun == null){
    $data['tahun']= date('Y');
    $tahun=date('Y');
}
else{
    $data['tahun'] = $tahun;
}

$data['cvs_returned']= $this->Insentif_model_kcc_internal->get_cvs($kcc_internal_selected); 

// ############# bagian USR ###################
$data['cvs_usr_achieve_returned']= $this->Insentif_model_kcc_internal->get_cvs_usr_achieve($bulan, $tahun, $kcc_internal_selected); 
$data['cvs_usr_minus_returned']= $this->Insentif_model_kcc_internal->get_cvs_usr_minus($bulan, $tahun, $kcc_internal_selected); 

// mekanisme untuk buat array USR Actual
$data['cvs_usr_actual_returned']=[];
$total_actual_usr=0;
for ($i=0; $i < count($data['cvs_usr_achieve_returned']); $i++) { 
    for ($o=0; $o < count($data['cvs_usr_minus_returned']); $o++) { 
        if ($data['cvs_usr_achieve_returned'][$i]['beatguy_id'] == $data['cvs_usr_minus_returned'][$o]['beatguy_id'] ) {
            $actual=$data['cvs_usr_achieve_returned'][$i]['usr']-$data['cvs_usr_minus_returned'][$o]['usr_minus'];
            $total_actual_usr+=$actual;
            $data['cvs_usr_actual_returned'][]=['beatguy_id'=>$data['cvs_usr_achieve_returned'][$i]['beatguy_id'], 'usr_actual'=>$actual];
        }
    }
}
############# bagian DNL ###################
$data['cvs_dnl_actual_returned']= $this->Insentif_model_kcc_internal->get_cvs_dnl($bulan, $tahun, $kcc_internal_selected);

############# bagian Transaksi ###################
//buat nilai default 0
for ($i=0; $i < count($data['cvs_returned']); $i++) { 
    $data['cvs_trx_all'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'trx_all'=>0]; 
    $data['cvs_trx_mt'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'trx_money_transfer'=>0]; 
    $data['cvs_trx_actual_returned'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'trx_actual'=>0]; 
}

$cvs_trx_all= $this->Insentif_model_kcc_internal->get_cvs_trx_all($bulan, $tahun, $kcc_internal_selected); 
$cvs_trx_mt= $this->Insentif_model_kcc_internal->get_cvs_trx_mt($bulan, $tahun, $kcc_internal_selected); 

// overwrite
for ($i=0; $i <count($data['cvs_returned']) ; $i++) { 
    for ($o=0; $o < count($cvs_trx_all) ; $o++) { 
        if ($data['cvs_trx_all'][$i]['beatguy_id']==$cvs_trx_all[$o]['beatguy_id']) {
            $data['cvs_trx_all'][$i]=['beatguy_id'=>$data['cvs_trx_all'][$i]['beatguy_id'], 'trx_all'=>$cvs_trx_all[$o]['trx_all']]; 
        }
    }

    for ($p=0; $p < count($cvs_trx_mt) ; $p++) { 
        if ($data['cvs_trx_mt'][$i]['beatguy_id']==$cvs_trx_mt[$p]['beatguy_id']) {
            $data['cvs_trx_mt'][$i]=['beatguy_id'=>$data['cvs_trx_mt'][$i]['beatguy_id'], 'trx_money_transfer'=>$cvs_trx_mt[$p]['trx_money_transfer']]; 
        }
    }

    // mekanisme untuk buat array TRX 
    // note: jika TRX-MT > 30% TRX-achieve: nilai TRX-actual = TRX-all dikurang TRX-MT
    if ($data['cvs_trx_mt'][$i]['trx_money_transfer']!=0) {
        $persentase_mt= $data['cvs_trx_mt'][$i]['trx_money_transfer']/$data['cvs_trx_all'][$i]['trx_all'];
        if($persentase_mt>0.3){
            $actual=$data['cvs_trx_all'][$i]['trx_all']-$data['cvs_trx_mt'][$i]['trx_money_transfer'];
            $data['cvs_trx_actual_returned'][$i]=['beatguy_id'=>$data['cvs_trx_all'][$i]['beatguy_id'], 'trx_actual'=>$actual];
        }
        else{
            $actual=$data['cvs_trx_all'][$i]['trx_all'];
            $data['cvs_trx_actual_returned'][$i]=['beatguy_id'=>$data['cvs_trx_all'][$i]['beatguy_id'], 'trx_actual'=>$actual];
        }
    }
    else{
        $actual=$data['cvs_trx_all'][$i]['trx_all'];
        $data['cvs_trx_actual_returned'][$i]=['beatguy_id'=>$data['cvs_trx_all'][$i]['beatguy_id'], 'trx_actual'=>$actual];
    }
}

// ############# bagian Top Up ###################
//buat nilai default 0
for ($i=0; $i < count($data['cvs_returned']); $i++) { 
    $data['cvs_tu_raw_returned'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'topup'=>0]; 
    $data['cvs_tu_negative_balance_returned'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'tu_negative_balance'=>0];  
}
$cvs_tu_raw_returned= $this->Insentif_model_kcc_internal->get_cvs_tu_raw($bulan, $tahun, $kcc_internal_selected); 
$cvs_tu_negative_balance_returned= $this->Insentif_model_kcc_internal->get_cvs_tu_negative_balance($bulan, $tahun, $kcc_internal_selected); 

// overwrite
for ($i=0; $i <count($data['cvs_returned']) ; $i++) { 
    for ($o=0; $o < count($cvs_tu_raw_returned) ; $o++) { 
        if ($data['cvs_tu_raw_returned'][$i]['beatguy_id']==$cvs_tu_raw_returned[$o]['beatguy_id']) {
            $data['cvs_tu_raw_returned'][$i]=['beatguy_id'=>$data['cvs_tu_raw_returned'][$i]['beatguy_id'], 'topup'=>$cvs_tu_raw_returned[$o]['topup']]; 
        }
    }
    for ($p=0; $p < count($cvs_tu_negative_balance_returned) ; $p++) { 
        if ($data['cvs_tu_negative_balance_returned'][$i]['beatguy_id']==$cvs_tu_negative_balance_returned[$p]['beatguy_id']) {
            $data['cvs_tu_negative_balance_returned'][$i]=['beatguy_id'=>$data['cvs_tu_negative_balance_returned'][$i]['beatguy_id'], 'tu_negative_balance'=>$cvs_tu_negative_balance_returned[$p]['tu_negative_balance']]; 
        }
    }
    // mekanisme untuk buat array TU 
    // note: jika TRX-MT > 30% TU-raw: nilai TU-actual = TU-raw dikurang TRX-MT
    if ($data['cvs_trx_mt'][$i]['trx_money_transfer']!=0) {
        $persentase_mt= $data['cvs_trx_mt'][$i]['trx_money_transfer']/$data['cvs_tu_raw_returned'][$i]['topup'];
        if($persentase_mt>0.3){
            $actual=$data['cvs_tu_raw_returned'][$i]['topup']-$data['cvs_trx_mt'][$i]['trx_money_transfer']-$data['cvs_tu_negative_balance_returned'][$i]['tu_negative_balance'];
            $data['cvs_tu_actual_returned'][$i]=['beatguy_id'=>$data['cvs_tu_raw_returned'][$i]['beatguy_id'], 'tu_actual'=>$actual];
            $achieve=$data['cvs_tu_raw_returned'][$i]['topup']-$data['cvs_trx_mt'][$i]['trx_money_transfer'];
            $data['cvs_tu_achieve_returned'][$i]=['beatguy_id'=>$data['cvs_tu_raw_returned'][$i]['beatguy_id'], 'topup'=>$achieve];
        }
        else{
            $actual=$data['cvs_tu_raw_returned'][$i]['topup']-$data['cvs_tu_negative_balance_returned'][$i]['tu_negative_balance'];
            $data['cvs_tu_actual_returned'][$i]=['beatguy_id'=>$data['cvs_tu_raw_returned'][$i]['beatguy_id'], 'tu_actual'=>$actual];
            $achieve=$data['cvs_tu_raw_returned'][$i]['topup'];
            $data['cvs_tu_achieve_returned'][$i]=['beatguy_id'=>$data['cvs_tu_raw_returned'][$i]['beatguy_id'], 'topup'=>$achieve];
        }
    }
    else{
        $actual=$data['cvs_tu_raw_returned'][$i]['topup']-$data['cvs_tu_negative_balance_returned'][$i]['tu_negative_balance'];
        $data['cvs_tu_actual_returned'][$i]=['beatguy_id'=>$data['cvs_tu_raw_returned'][$i]['beatguy_id'], 'tu_actual'=>$actual];
        $achieve=$data['cvs_tu_raw_returned'][$i]['topup'];
        $data['cvs_tu_achieve_returned'][$i]=['beatguy_id'=>$data['cvs_tu_raw_returned'][$i]['beatguy_id'], 'topup'=>$achieve];
    }
}


// echo "TU raw = ";
// print_r($data['cvs_tu_raw_returned']);
// echo "<br><br>TU negative = ";
// print_r($data['cvs_tu_negative_balance_returned']);
// echo "<br><br>TU actual = ";
// print_r($data['cvs_tu_actual_returned']);
// echo "<br><br>TRX MT = ";
// print_r($data['cvs_trx_mt']);




// ############# bagian USPR ###################
$data['cvs_uspr_actual_returned']= $this->Insentif_model_kcc_internal->get_cvs_uspr($bulan, $tahun, $kcc_internal_selected);

// ############# bagian ACHIEVEMENT % ###################
// mekanisme untuk buat % array achievement
$data['achievement_usr']=[];
$data['achievement_dnl']=[];
$data['achievement_tu']=[];
$data['achievement_trx']=[];
$data['achievement_uspr']=[];

//buat nilai default 0
for ($i=0; $i < count($data['cvs_returned']); $i++) { 
    $data['achievement_usr'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'achieve'=>0, 'achievementXbobot'=>0]; 
    $data['achievement_dnl'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'achieve'=>0, 'achievementXbobot'=>0]; 
    $data['achievement_tu'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'achieve'=>0, 'achievementXbobot'=>0]; 
    $data['achievement_trx'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'achieve'=>0, 'achievementXbobot'=>0]; 
    $data['achievement_uspr'][]=['beatguy_id'=>$data['cvs_returned'][$i]['beatguy_id'], 'achieve'=>0, 'achievementXbobot'=>0]; 
}

// overwrite value default dengan value lain (jika beatguy_id sama)
// semua di tebengin ke loop achievement_usr agar lebih efisien
for ($i=0; $i <count($data['achievement_usr']) ; $i++) { 
    // achievement USR
    for ($o=0; $o <count($data['cvs_usr_actual_returned']) ; $o++) { 
        if ($data['achievement_usr'][$i]['beatguy_id'] == $data['cvs_usr_actual_returned'][$o]['beatguy_id']) {
            $achievement_usr=round(($data['cvs_usr_actual_returned'][$o]['usr_actual']/$data['target_usr'])*100);
            if ($achievement_usr>=$max_achievement_usr) {
                $data['achievement_usr'][$i]=['beatguy_id'=>$data['achievement_usr'][$i]['beatguy_id'], 'achieve'=>100, 'achievementXbobot'=>$bobot_usr]; 
            }
            else {
                $achievementXbobot=round($achievement_usr * ($bobot_usr/100));
                $data['achievement_usr'][$i]=['beatguy_id'=>$data['achievement_usr'][$i]['beatguy_id'], 'achieve'=>$achievement_usr, 'achievementXbobot'=>$achievementXbobot];  
            }
        }
    }

    // achievement DNL
    for ($o=0; $o <count($data['cvs_dnl_actual_returned']) ; $o++) { 
        if ($data['achievement_dnl'][$i]['beatguy_id'] == $data['cvs_dnl_actual_returned'][$o]['beatguy_id']) {
            $achievement_dnl=round(($data['cvs_dnl_actual_returned'][$o]['dnl']/$data['target_dnl'])*100);
            if ($achievement_dnl>=$max_achievement_dnl) {
                $data['achievement_dnl'][$i]=['beatguy_id'=>$data['achievement_dnl'][$i]['beatguy_id'], 'achieve'=>100, 'achievementXbobot'=>$bobot_dnl]; 
            }
            else {
                $achievementXbobot=round($achievement_dnl * ($bobot_dnl/100));
                $data['achievement_dnl'][$i]=['beatguy_id'=>$data['achievement_dnl'][$i]['beatguy_id'], 'achieve'=>$achievement_dnl, 'achievementXbobot'=>$achievementXbobot];  
            }
        }
    }
    
    // achievement TU
    for ($o=0; $o <count($data['cvs_tu_actual_returned']) ; $o++) { 
        if ($data['achievement_tu'][$i]['beatguy_id'] == $data['cvs_tu_actual_returned'][$o]['beatguy_id']) {
            $achievement_tu=round(($data['cvs_tu_actual_returned'][$o]['tu_actual']/$data['target_tu'])*100);
            if ($achievement_tu>=$max_achievement_tu) {
                $data['achievement_tu'][$i]=['beatguy_id'=>$data['achievement_tu'][$i]['beatguy_id'], 'achieve'=>100, 'achievementXbobot'=>$bobot_tu]; 
            }
            else {
                $achievementXbobot=round($achievement_tu * ($bobot_tu/100));
                $data['achievement_tu'][$i]=['beatguy_id'=>$data['achievement_tu'][$i]['beatguy_id'], 'achieve'=>$achievement_tu, 'achievementXbobot'=>$achievementXbobot];  
            }
        }
    }

    // achievement TRX
    for ($o=0; $o <count($data['cvs_trx_actual_returned']) ; $o++) { 
        if ($data['achievement_trx'][$i]['beatguy_id'] == $data['cvs_trx_actual_returned'][$o]['beatguy_id']) {
            $achievement_trx=round(($data['cvs_trx_actual_returned'][$o]['trx_actual']/$data['target_trx'])*100);
            if ($achievement_trx>=$max_achievement_trx) {
                $data['achievement_trx'][$i]=['beatguy_id'=>$data['achievement_trx'][$i]['beatguy_id'], 'achieve'=>100, 'achievementXbobot'=>$bobot_trx]; 
            }
            else {
                $achievementXbobot=round($achievement_trx * ($bobot_trx/100));
                $data['achievement_trx'][$i]=['beatguy_id'=>$data['achievement_trx'][$i]['beatguy_id'], 'achieve'=>$achievement_trx, 'achievementXbobot'=>$achievementXbobot];  
            }
        }
    }

    // achievement USPR
    for ($o=0; $o <count($data['cvs_uspr_actual_returned']) ; $o++) { 
        if ($data['achievement_uspr'][$i]['beatguy_id'] == $data['cvs_uspr_actual_returned'][$o]['beatguy_id']) {
            $achievement_uspr=round(($data['cvs_uspr_actual_returned'][$o]['uspr_actual']/$data['target_uspr'])*100);
            if ($achievement_uspr>=$max_achievement_uspr) {
                $data['achievement_uspr'][$i]=['beatguy_id'=>$data['achievement_uspr'][$i]['beatguy_id'], 'achieve'=>100, 'achievementXbobot'=>$bobot_uspr]; 
            }
            else {
                $achievementXbobot=round($achievement_uspr * ($bobot_uspr/100));
                $data['achievement_uspr'][$i]=['beatguy_id'=>$data['achievement_uspr'][$i]['beatguy_id'], 'achieve'=>$achievement_uspr, 'achievementXbobot'=>$achievementXbobot];  
            }
        }
    }
    // total semua achievement * bobot
    $total_kpi_cvs = $data['achievement_usr'][$i]['achievementXbobot']
                    +$data['achievement_dnl'][$i]['achievementXbobot']
                    +$data['achievement_tu'][$i]['achievementXbobot']
                    +$data['achievement_trx'][$i]['achievementXbobot']
                    +$data['achievement_uspr'][$i]['achievementXbobot'];
    // Insentif CVS
    if ($total_kpi_cvs<70) {
        $insentif_cvs=0;
    }
    else if ($total_kpi_cvs<85) {
        $insentif_cvs=$data['cvs_tu_actual_returned'][$i]['tu_actual']*(10/100);
    }
    else if ($total_kpi_cvs<100) {
        $insentif_cvs=$data['cvs_tu_actual_returned'][$i]['tu_actual']*(15/100);
    }
    else if ($total_kpi_cvs<115) {
        $insentif_cvs=$data['cvs_tu_actual_returned'][$i]['tu_actual']*(20/100);
    }
    else {
        $insentif_cvs=$data['cvs_tu_actual_returned'][$i]['tu_actual']*(25/100);
    }
    
    $data['total_kpi_cvs'][$i]=['beatguy_id'=>$data['achievement_uspr'][$i]['beatguy_id'], 'total_kpi_cvs'=>$total_kpi_cvs, 'insentif_cvs'=>$insentif_cvs];
}

// ############# bagian SPV (baris total) ###################

$data['cvs_active_returned']= $this->Insentif_model_kcc_internal->get_cvs_active($kcc_internal_selected); 

$data['total_target_usr']=$data['target_usr']*$data['cvs_active_returned'][0]['jumlah_aktif'];
$data['total_target_dnl']=$data['target_dnl']*$data['cvs_active_returned'][0]['jumlah_aktif'];
$data['total_target_tu']=$data['target_tu']*$data['cvs_active_returned'][0]['jumlah_aktif'];
$data['total_target_trx']=$data['target_trx']*$data['cvs_active_returned'][0]['jumlah_aktif'];
$data['total_target_uspr']=$data['target_uspr']*$data['cvs_active_returned'][0]['jumlah_aktif'];


$data['total_usr_achieve']=0;
$data['total_usr_minus']=0;
$data['total_usr_actual']=0;
$data['total_dnl_actual']=0;
$data['total_tu_achieve']=0;
$data['total_tu_negative_balance']=0;
$data['total_tu_actual']=0;
$data['total_trx_actual']=0;
$data['total_uspr_actual']=0;

for ($i=0; $i < count($data['cvs_returned']); $i++) { 
    // total USR
    $data['total_usr_achieve'] += $data['cvs_usr_achieve_returned'][$i]['usr'];
    $data['total_usr_minus'] += $data['cvs_usr_minus_returned'][$i]['usr_minus'];
    $data['total_usr_actual'] += $data['cvs_usr_actual_returned'][$i]['usr_actual'];

    // total DNL
    $data['total_dnl_actual'] += $data['cvs_dnl_actual_returned'][$i]['dnl'];

    // total Top Up
    $data['total_tu_achieve'] += $data['cvs_tu_achieve_returned'][$i]['topup'];
    $data['total_tu_negative_balance'] += $data['cvs_tu_negative_balance_returned'][$i]['tu_negative_balance'];
    $data['total_tu_actual'] += $data['cvs_tu_actual_returned'][$i]['tu_actual'];

    // total TRX
    $data['total_trx_actual'] += $data['cvs_trx_actual_returned'][$i]['trx_actual'];

    // total USPR
    $data['total_uspr_actual'] += $data['cvs_uspr_actual_returned'][$i]['uspr_actual'];

    // total achievement
    $total_usr_achievement=round(($data['total_usr_actual']/$data['total_target_usr'])*100);
    $total_dnl_achievement=round(($data['total_dnl_actual']/$data['total_target_dnl'])*100);
    $total_tu_achievement=round(($data['total_tu_actual']/$data['total_target_tu'])*100);
    $total_trx_achievement=round(($data['total_trx_actual']/$data['total_target_trx'])*100);
    $total_uspr_achievement=round(($data['total_uspr_actual']/$data['total_target_uspr'])*100);

    if($total_usr_achievement>=$max_achievement_usr){
        $data['total_usr_achievement'] = 100;
    }
    else{
        $data['total_usr_achievement'] = $total_usr_achievement;
    }
    if($total_dnl_achievement>=$max_achievement_dnl){
        $data['total_dnl_achievement'] = 100;
    }
    else{
        $data['total_dnl_achievement'] = $total_dnl_achievement;
    }
    if($total_tu_achievement>=$max_achievement_tu){
        $data['total_tu_achievement'] = 100;
    }
    else{
        $data['total_tu_achievement'] = $total_tu_achievement;
    }
    if($total_trx_achievement>=$max_achievement_trx){
        $data['total_trx_achievement'] = 100;
    }
    else{
        $data['total_trx_achievement'] = $total_trx_achievement;
    }
    if($total_uspr_achievement>=$max_achievement_uspr){
        $data['total_uspr_achievement'] = 100;
    }
    else{
        $data['total_uspr_achievement'] = $total_uspr_achievement;
    }

    // total achivement x bobot
    $data['total_usr_achievementXbobot'] = round($data['total_usr_achievement']*$bobot_usr/100);
    $data['total_dnl_achievementXbobot'] = round($data['total_dnl_achievement']*$bobot_dnl/100);
    $data['total_tu_achievementXbobot'] = round($data['total_tu_achievement']*$bobot_tu/100);
    $data['total_trx_achievementXbobot'] = round($data['total_trx_achievement']*$bobot_trx/100);
    $data['total_uspr_achievementXbobot'] = round($data['total_uspr_achievement']*$bobot_uspr/100);

    // KPI SPV
    $data['total_kpi_spv'] = $data['total_usr_achievementXbobot']+$data['total_dnl_achievementXbobot']+$data['total_tu_achievementXbobot']+$data['total_trx_achievementXbobot']+$data['total_uspr_achievementXbobot'];

    // Insentif SPV
    if ($data['total_kpi_spv']<70) {
        $data['insentif_spv']=0;
    }
    else if ($data['total_kpi_spv']<85) {
        $data['insentif_spv']=$data['total_tu_actual']*(10/100);
    }
    else if ($data['total_kpi_spv']<100) {
        $data['insentif_spv']=$data['total_tu_actual']*(15/100);
    }
    else if ($data['total_kpi_spv']<115) {
        $data['insentif_spv']=$data['total_tu_actual']*(20/100);
    }
    else {
        $data['insentif_spv']=$data['total_tu_actual']*(25/100);
    }
}



// echo "dnl = ";
// print_r($data['cvs_dnl_actual_returned']);
// echo "<br> <br> tu_actual = ";
// print_r($data['cvs_tu_actual_returned']);
// echo "<br> <br> trx actual = ";
// print_r($data['cvs_trx_actual_returned']);
// echo "<br> <br> cvs returned = ";
// print_r($data['cvs_returned']);
