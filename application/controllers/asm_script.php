<?php 
// Set target disini
$data['target_usr'] = 120;
$data['target_dnl'] = 60;
$data['target_tu'] = 480000000;
$data['target_trx'] = 360000000;
$data['target_uspr'] = 12;

//Get the value from the form.
$bulan = $this->input->post('Bulan');
$tahun = $this->input->post('Tahun');
$region = $this->input->post('region');

if($bulan == null){
    $data['bulan']= date('m');
    $bulan=date('m');
}
else{
    $data['bulan'] = $bulan;
}
if($tahun== null){
    $data['tahun']= date('Y');
    $tahun=date('Y');
}
else{
    $data['tahun'] = $tahun;
}
$data['region_returned']= $this->Insentif_model_asm->get_region(); //di DB namanya 'state'

//jika belum ada region
if($region == null){
    $data['region_selected'] = $data['region_returned'][0]['state'];
    $region = $data['region_returned'][0]['state'];
}

//jika sudah ada region
else{ 
    $data['region_selected'] = $region;
}

//ambil semua data nama CVS region tsb
$data['cvs_returned']= $this->Insentif_model_asm->get_cvs($region); 

$list_disttributor=[];
for ($i=0; $i < count($data['cvs_returned']); $i++) { 
    $list_disttributor[]= $data['cvs_returned'][$i]['distributor_id'];
}

//hitung jumlah beatguy dengan KCC yang sama untuk colspan tabel
$data['kcc_counts']= array_count_values($list_disttributor);

//dapatkan total topup cvs dalam "sebulan terpilih"
$data['cvs_tu']= $this->Insentif_model_asm->get_cvs_tu($bulan, $tahun); 