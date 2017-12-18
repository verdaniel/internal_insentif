<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// authority
// 1 => NSM
// 2 => ASM
// 3 => internal
// 4 => eksternal




class Auth_cont extends CI_Controller {

	public function logout(){
		unset($_SESSION);
		session_destroy();
		redirect('auth_cont/login','refresh');
	}
	
	public function login(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]'); //password should has more than 5 character

		//check for validation
		if ($this->form_validation->run() == TRUE){

			$username = $_POST['username'];
			$password = base64_encode($_POST['password']);

			$CI = &get_instance();

			// cek tabel "login" dari "database buatan sendiri" 
			$this->db2 = $CI->load->database('login',TRUE);
			$this->db2->select('username, password, authority');
			$this->db2->from('insentif_login');
			$this->db2->where(['username'=>$username]);
			$query = $this->db2->get();
			$user_data = $query->row();

			if ($user_data != null){
				
				// cek apakah password di tabel sesuai dengan yang di input di kolom password (di view)
				if ($password == $user_data->password){
					$_SESSION['user_logged'] = TRUE;
					$_SESSION['authority'] = $user_data->authority;
					if ($_SESSION['authority']==1) {
						$_SESSION['identity'] = "NSM";
					}
					else if ($_SESSION['authority']==2) {
						$_SESSION['identity'] = "ASM";
					}
					else {
						$_SESSION['identity'] = $user_data->username;
					}
					
					//redirect to profile page if success
					redirect("insentif_cont", "refresh");
				}

				else{
					$this->session->set_flashdata("error", "Username or password is incorrect");
					redirect('Auth_cont/login','refresh');
				}

			}
			
			//cek jika username yang terinput merupakan distributer ID 
			elseif (preg_match("/^[D][0-9][A-Z0-9]$/",$username)) {
				// check distributor_id dan password in ipay_distributor
				$this->db->select('password');
				$this->db->from('ipay_distributor');
				$this->db->where(['distributor_id'=>$username]);
				$query = $this->db->get();
				$user_data = $query->row();
				
				if ($user_data != null){
					// cek password
					if ($user_data->password == $password){
						$_SESSION['user_logged'] = TRUE;
						$_SESSION['identity'] = $username;
						$_SESSION['authority'] = 4;

						//redirect to profile page if success
						redirect("insentif_cont", "refresh");
					}

					else{
						$this->session->set_flashdata("error", "Username or password is incorrect");
						redirect('Auth_cont/login','refresh');
					}
				}
			}
			else{
				$this->session->set_flashdata("error", "Username or password is incorrect");
				redirect('Auth_cont/login','refresh');
			}
		}
		
		$_SESSION['user_logged'] = FALSE;
		$this->load->view('login');
		
	}
	
}
