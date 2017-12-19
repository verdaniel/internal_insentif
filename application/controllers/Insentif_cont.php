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
            $data['mode'] = "asm";
            redirect("insentif_cont/asm");
        }

        // Internal self login
        else if($_SESSION['authority']== 3){
            $data['mode'] = "externalss";
            redirect("insentif_cont/kcc_internalss");
        }

        // External self login
        else if($_SESSION['authority']== 4){
            $data['mode'] = "externalss";
            redirect("insentif_cont/kcc_externalss");
        }

         // super kcc self login
         else if($_SESSION['authority']== 5){
            $data['mode'] = "superkccss";
            redirect("insentif_cont/kcc_superss");
        }
        
        else{
            echo "ERROR";
            // redirect("insentif_cont/kcc_externalss");
        }
    }

    public function kcc_internal(){

        $data['mode'] = "internal";
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
        
        $data['mode'] = "internalss";
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
        $data['mode'] = "asm";
        include 'asm_script.php';
        $this->load->view('header');
        $this->load->view('Navbar',$data);
        $this->load->view('asm',$data);
		$this->load->view('footer');
    }

	public function kcc_external(){
        $data['mode'] = "external";
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
        $data['mode'] = "externalss";
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
        $data['mode'] = "superkcc";
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

        $data['distributor']= $this->Insentif_model_super_kcc->get_distributor();

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

    public function kcc_superss(){
        $data['mode'] = "externalss";
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
}
