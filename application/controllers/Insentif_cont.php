<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insentif_cont extends CI_Controller {

    public function __construct(){
        
        parent::__construct();
        if ($_SESSION['user_logged'] == FALSE){
            $this->session->set_flashdata("error", "Please login first to view this page!! ");
            redirect("Auth_cont/login");
        }
    }
    
    public function index(){
        //NSM
        if($_SESSION['authority']== 1){
            $_SESSION['mode'] = "asm";
            redirect("insentif_cont/asm");
        }

        // Internal self login
        else if($_SESSION['authority']== 3){
            $_SESSION['mode'] = "internalss";
            redirect("insentif_cont/kcc_internalss");
        }

        // External self login
        else if($_SESSION['authority']== 4){
            $_SESSION['mode'] = "externalss";
            redirect("insentif_cont/kcc_externalss");
        }

         // super kcc self login
         else if($_SESSION['authority']== 5){
            $_SESSION['mode'] = "superkccss";
            redirect("insentif_cont/kcc_superss");
        }
        
        else{
            echo "ERROR";
            // redirect("insentif_cont/kcc_externalss");
        }
    }

    public function kcc_internal(){

        $_SESSION['mode'] = "internal";
        //Get the value from the form.
        $kcc_internal_selected = $this->input->post('kcc_internal');

        //di dalam DB 'full access', table 'insentif_login'
        //ambil list of kcc internal
        $data['kcc_internal_returned']= $this->Insentif_model_kcc_internal->get_kcc_internal(); 

        if($kcc_internal_selected == null){
            $data['kcc_internal_selected']= $data['kcc_internal_returned'][0]['username'];
            $kcc_internal_selected = $data['kcc_internal_selected'];
        }
        else{
            $data['kcc_internal_selected'] = $kcc_internal_selected;
        }
        include 'kcc_internal_script.php';
        $this->load->view('header');
        $this->load->view('Navbar',$data);
        $this->load->view('kcc_internal',$data);
		$this->load->view('footer');
    }

    public function kcc_internalss(){
        
        $_SESSION['mode'] = "internalss";
        //Get the value from the form.
        $kcc_internal_selected = $_SESSION['identity'];
        $data['name_returned']= $this->Insentif_model_kcc_internal->get_kcc_internal_name($kcc_internal_selected); 

        include 'kcc_internal_script.php';
        $this->load->view('header');
        $this->load->view('Navbar',$data);
        $this->load->view('kcc_internalss',$data);
        $this->load->view('footer');
    }

    public function asm(){
        $_SESSION['mode'] = "asm";
        include 'asm_script.php';
        $this->load->view('header');
        $this->load->view('Navbar',$data);
        $this->load->view('asm',$data);
		$this->load->view('footer');
    }

	public function kcc_external(){
        $_SESSION['mode'] = "external";
        //Get the value from the form.
        $bulan = $this->input->post('Bulan');
        $tahun = $this->input->post('Tahun');
        $Dist_id = $this->input->post('Dist_id');

        //jika nilai bulan null
        if($bulan == null){
            $data['bulan']= date('m');
            $bulan=date('m');
        }
        else{
            $data['bulan'] = $bulan;
        }

        //jika nilai tahun null
        if($tahun == null){
            $data['tahun']= date('y');
            $tahun=date('y');
        }
        else{
            $data['tahun'] = $tahun;
        }

        $data['distributor']= $this->Insentif_model_kcc_external->get_distributor();

        //jika distributor ID null
        if($Dist_id == null){
            $data['dist_id'] = $data['distributor'][0]['distributor_id'];
            $Dist_id = $data['distributor'][0]['distributor_id'];
        }
        else{
            //Put the value in an array to pass to the view. 
            $data['dist_id'] = $Dist_id;
        }
        
        if($tahun == 2018){
            include 'kcc_external_script2018.php';
            $this->load->view('header');
            $this->load->view('Navbar',$data);
            $this->load->view('kcc_external2018', $data);
            $this->load->view('footer');
        }
        else{
            include 'kcc_external_script.php';
            $this->load->view('header');
            $this->load->view('Navbar',$data);
            $this->load->view('kcc_external', $data);
            $this->load->view('footer');
        }
    }

    public function kcc_externalss(){
        $_SESSION['mode'] = "externalss";
        //Get the value from the form.
        $bulan = $this->input->post('Bulan');
        $tahun = $this->input->post('Tahun');
        $Dist_id = $_SESSION['identity'];

        if($bulan == null){
            $data['bulan']= date('m');
            $bulan=date('m');
            // echo "bulan = ". date('m');
        }
        else{
            $data['bulan'] = $bulan;
            // echo "bulan = ".$bulan;
        }

        //jika nilai tahun null
        if($tahun == null){
            $data['tahun']= date('y');
            $tahun=date('y');
        }
        else{
            $data['tahun'] = $tahun;
        }
        $data['distributor']= $this->Insentif_model_kcc_external->get_distributor_name($Dist_id);
        
        if($tahun == 2018){
            include 'kcc_external_script2018.php';
            $this->load->view('header');
            $this->load->view('Navbar',$data);
            $this->load->view('kcc_externalss2018', $data);
            $this->load->view('footer');
        }
        else{
            include 'kcc_external_script.php';
            $this->load->view('header');
            $this->load->view('Navbar',$data);
            $this->load->view('kcc_externalss', $data);
            $this->load->view('footer');
        }
    }

    public function kcc_super(){
        $_SESSION['mode'] = "superkcc";
        //Get the value from the form.
        $bulan = $this->input->post('Bulan');
        $tahun = $this->input->post('Tahun');
        $super_kcc_id = $this->input->post('skcc_id');

        //jika nilai bulan null
        if($bulan == null){
            $data['bulan']= date('m');
            $bulan=date('m');
        }
        else{
            $data['bulan'] = $bulan;
        }

        //jika nilai tahun null
        if($tahun == null){
            $data['tahun']= date('y');
            $tahun=date('y');
        }
        else{
            $data['tahun'] = $tahun;
        }

        $data['super_kcc_list']= $this->Insentif_model_super_kcc->get_super_kcc_list();

        //jika nilai super_kcc_id null
        if($super_kcc_id == null){
            $data['super_kcc_id']= $data['super_kcc_list'][0]['username'];
            $super_kcc_id = $data['super_kcc_id'];
        }
        else{
            $data['super_kcc_id'] = $super_kcc_id;
        }
        $Dist_id = 'D2B';
        
        $data['bawahan_super_kcc']= $this->Insentif_model_super_kcc->get_kcc_under_super_kcc($super_kcc_id);
            // foreach($data['bawahan_super_kcc'] as $bwh){
            //     $bwh['distributor_id'] =
            // }
            $Dist_id = $data['bawahan_super_kcc'][0][0]["distributor_id"];
               foreach($data['bawahan_super_kcc'][0] as $d){
                   
                   $Dist_id = $Dist_id."','".$d["distributor_id"];
               } 
            print_r($Dist_id);
            include 'kcc_external_script2018.php';

        
        $this->load->view('header');
        $this->load->view('Navbar',$data);
        $this->load->view('kcc_super', $data);
        $this->load->view('footer');

    }

    public function kcc_superss(){
        $_SESSION['mode'] = "superkccss";
        //Get the value from the form.
        $bulan = $this->input->post('Bulan');
        $tahun = $this->input->post('Tahun');
        $super_kcc_id = $_SESSION['identity'];

        //jika nilai bulan null
        if($bulan == null){
            $data['bulan']= date('m');
            $bulan=date('m');
        }
        else{
            $data['bulan'] = $bulan;
        }

        //jika nilai tahun null
        if($tahun == null){
            $data['tahun']= date('y');
            $tahun=date('y');
        }
        else{
            $data['tahun'] = $tahun;
        }
        $data['super_kcc']= $this->Insentif_model_super_kcc->get_super_kcc_name($super_kcc_id);
        
        $data['bawahan_super_kcc']= $this->Insentif_model_super_kcc->get_kcc_under_super_kcc($super_kcc_id);
            include 'kcc_external_script2018.php';
        
        
        $this->load->view('header');
        $this->load->view('Navbar',$data);
        $this->load->view('kcc_superss', $data);
        $this->load->view('footer');

    }
}
