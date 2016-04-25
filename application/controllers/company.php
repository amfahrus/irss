<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends CI_Controller {

	public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->getLanguage();
		$this->load->model("m_company");
    }
    
	public function index(){
		redirect('home');
	}
	
    public function login(){
		$data['act'] = base_url().'company/ceklogin';      
		$this->load->view('frontend/company/login', $data);
	}
	
	public function ceklogin(){
		$this->form_validation->set_rules('company_account_email', 'Email', 'required|xss_clean');
		$this->form_validation->set_rules('company_account_password', 'Password', 'required|xss_clean');
		$data['act'] = base_url().'company/ceklogin'; 
			
        if ($this->form_validation->run() == false) {     
			$this->load->view('frontend/company/form/login_failed', $data);           
        } else {
			$username = $this->input->post('company_account_email');
			$password = $this->input->post('company_account_password');
			if($this->input->post('remember_me')){
				setcookie("cookname", base64_encode($username), time()+60*60*24*100, "/");
				setcookie("cookpass", base64_encode($password), time()+60*60*24*100, "/");
			}
			
			$res = $this->m_company->getCompanyLogin($username,$this->dokumen_lib->get_password($password));
        
			if ($res->num_rows() > 0) {
				$row = $res->row_array();
				$this->session->set_userdata('company_account_id', $row['company_account_id']);
				$this->session->set_userdata('company_account_key', $this->dokumen_lib->get_password($row['company_account_id']));
				$this->session->set_userdata('company_account_name', $row['company_account_name']);
				$this->session->set_userdata('company_account_username', $row['company_account_username']);
				$this->session->set_userdata('company_account_email', $row['company_account_email']);
				$this->session->set_userdata('company_account_aoi', $this->m_company->getSumAoi());
				redirect('home','refresh');
			} else {
				$this->session->set_flashdata('info', lang('account_does_not_exist._maybe_your_input_is_incorrect_or_your_account_is_not_active'));
				redirect('company/login_failed'); 
            }
			
        }
		
	}
	
	public function login_failed(){
		$data['act'] = base_url().'company/ceklogin'; 
		$this->load->view('frontend/company/form/login_failed', $data); 
	}
	
	public function register(){
		$data['act'] = base_url().'company/cekregister'; 
		$this->load->view('frontend/company/register',$data);
	}
	
	public function register_success(){
		$this->load->view('frontend/apl/form/register_success');
	}
	
	public function cekregister(){
		$this->form_validation->set_rules('company_account_name', lang('account_name'), 'required|xss_clean');
		$this->form_validation->set_rules('company_account_username', lang('account_username'), 'required|xss_clean|alpha_numeric|callback_check_username_reg');
		$this->form_validation->set_rules('company_account_email', 'Email', 'valid_email|required|xss_clean|callback_check_email_reg');
		$this->form_validation->set_rules('company_account_password', 'Password', 'required|xss_clean|alpha_numeric');
		$this->form_validation->set_rules('security_code', 'security_code', 'alpha_numeric|required|xss_clean|callback_valid_confirmation_code');
		
        if ($this->form_validation->run() == true) {

            $fields["company_account_username"] = $this->input->post("company_account_username");
            $fields["company_account_name"] = $this->input->post("company_account_name");
            $fields["company_account_email"] = $this->input->post("company_account_email");
            $fields["company_account_password"] = $this->dokumen_lib->get_password($this->input->post("company_account_password"));
            
            $exec = $this->m_company->insertCompanyAccount($fields);
            $this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
			$this->email->to($fields["company_account_email"]);

			$this->email->subject('e-Recruitment Company Registration');
			$this->email->message('<html>
									<head>
									<meta content="text/html; charset=ISO-8859-1"
									http-equiv="content-type">
									<title></title>
									</head>
									<body>
									<big style="font-style: italic;"><big><span
									style="color: red; font-weight: bold;">e</span><span
									style="font-weight: bold;">-Recruitment</span></big></big><br>
									<hr style="width: 100%; height: 2px;"><big><big><span
									style="font-weight: bold;">Email Confirmation</span></big></big><br>
									Congratulations your company has been registered in e-Recruitment. For the next process
									Please click the link below to activating your account. Thank you.<br>
									<br>
									<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
									cellspacing="2">
									<tbody>
									<tr>
									<td style="vertical-align: top; width: 253px;"><a href="'.base_url().'company/email_confirmation/'.base64_encode($exec).'"><big><span
									style="font-weight: bold;">Click here to activating your account</span></big></a><br>
									</td>
									</tr>
									<tr>
									<td style="vertical-align: top;">Or copy paste this link to your web browser : '.base_url().'company/email_confirmation/'.base64_encode($exec).'<br>
									</td>
									</tr>
									</tbody>
									</table>
									<br>
									<hr style="width: 100%; height: 2px;"><small><span
									style="font-weight: bold;">DO NOT REPLY THIS EMAIL !</span></small><br>
									<br>
									<big style="font-style: italic;"><big><span
									style="color: red; font-weight: bold;">e</span><span
									style="font-weight: bold;">-Recruitment<br>
									</span></big></big> <br>
									</body>
									</html>

									');
			$this->email->send();
//            if($exec) {
            $this->session->set_flashdata('success', lang('registration_successful._please_check_your_email_for_activation!'));
            redirect('company/register_success');
//            }
//            else {
//                $this->session->set_flashdata('error','Registration failed');
//            }
        } else {
			$data['act'] = base_url().'company/cekregister'; 
            $this->load->view('frontend/company/form/register_failed', $data);
        }
	}
	
	public function check_username_reg($username) {

        if ($this->m_company->check_username($username)) {
			$this->form_validation->set_message('check_username_reg', "Username " . $username . " ".lang('already_registered,_choose_another_username'));
            return false;
        } else {
			return true;
        }
    }
	
	public function check_email_reg($email) {

        if ($this->m_company->check_email($email)) {
			$this->form_validation->set_message('check_email_reg', "Email " . $email . " ".lang('already_registered,_choose_another_email'));
            return false;
        } else {
			return true;
        }
    }
	
	public function forgot(){
		$data['act'] = base_url().'company/cekforgot'; 
		$this->load->view('frontend/company/form/forgot_failed',$data);
	}
	
	public function cekforgot(){
		$this->form_validation->set_rules('company_account_email', 'Email', 'valid_email|required|xss_clean|callback_check_email_forgot');
		
		if ($this->form_validation->run() == true) {
			$email = $this->input->post("company_account_email");
			$pwd = $this->dokumen_lib->generate_random_password(6);
            $data = array(
                "company_account_password" => $this->dokumen_lib->get_password($pwd)
            );
            $this->m_company->updateCompanyAccount(array("company_account_email" => $email), $data);
            $this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
			$this->email->to($email);

			$this->email->subject('New Password');
			$this->email->message('<html>
									<head>
									<meta content="text/html; charset=ISO-8859-1"
									http-equiv="content-type">
									<title></title>
									</head>
									<body>
									<big style="font-style: italic;"><big><span
									style="color: red; font-weight: bold;">e</span><span
									style="font-weight: bold;">-Recruitment</span></big></big><br>
									<hr style="width: 100%; height: 2px;"><big><big><span
									style="font-weight: bold;">Recovery Password</span></big></big><br>
									<br>
									<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
									cellspacing="2">
									<tbody>
									<tr>
									<td style="vertical-align: top; width: 178px;"><big><span
									style="font-weight: bold;">Your New</span><span
									style="font-weight: bold;"> Password</span></big> <br>
									</td>
									<td style="vertical-align: top; width: 0px;">:<br>
									</td>
									<td style="vertical-align: top; width: 766px;">'.$pwd.'<br>
									</td>
									</tr>
									</tbody>
									</table>
									<br>
									<hr style="width: 100%; height: 2px;"><small><span
									style="font-weight: bold;">DO NOT REPLY THIS EMAIL !</span></small><br>
									You can change password after login.<br>
									Please login to :<br>
									<br>
									<big style="font-style: italic;"><big><span
									style="color: red; font-weight: bold;">e</span><span
									style="font-weight: bold;">-Recruitment<br>
									<a href="'.base_url().'">'.base_url().'</a><br>
									</span></big></big>
									</body>
									</html>');
			$this->email->send();
            $this->session->set_flashdata('success', lang('your_new_password_has_been_sent_to_your_email!'));
            redirect('company/register_success');
        } else {

            $data['act'] = base_url().'company/cekforgot'; 
            $this->load->view('frontend/company/form/forgot_failed', $data);
        }
    }
    
	public function check_email_forgot($email) {

        if ($this->m_company->check_email($email)) {
            return true;
        } else {
			$this->form_validation->set_message('check_email_forgot', "Email " . $email . " ".lang('does_not_exist'));
            return false;
        }
	}
	
	public function email_confirmation($key) {
		$id = base64_decode($key);
        $data = array(
            "company_account_is_active" => 1
        );
        $this->m_company->updateCompanyAccount(array("company_account_id" => $id), $data);
        $res = $this->m_company->getCompanyAccountById($id);
        if ($res->num_rows() > 0) {
				$row = $res->row_array();
				$this->session->unset_userdata('company_account_id');
				$this->session->unset_userdata('company_account_key');
				$this->session->unset_userdata('company_account_username');
				$this->session->unset_userdata('company_account_name');
				$this->session->unset_userdata('company_account_email');
        
				$this->session->set_userdata('company_account_id', $row['company_account_id']);
				$this->session->set_userdata('company_account_key', $this->dokumen_lib->get_password($row['company_account_id']));
				$this->session->set_userdata('company_account_name', $row['company_account_name']);
				$this->session->set_userdata('company_account_username', $row['company_account_username']);
				$this->session->set_userdata('company_account_email', $row['company_account_email']);
				$this->session->set_flashdata('success', 'Your account has been activated!');
				$this->load->view('frontend/company/form/register_success', $data);
		}
    }
	
	public function logout() {
        $this->session->unset_userdata('company_account_id');
        $this->session->unset_userdata('company_account_key');
        $this->session->unset_userdata('company_account_username');
        $this->session->unset_userdata('company_account_name');
        $this->session->unset_userdata('company_account_email');
        redirect("home","refresh");
    }
    
    public function profile($offset = 0){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$total = $this->m_company->getCompanyTotal($this->session->userdata('company_account_id'))->row_array();
		$config['base_url'] = base_url().'company/profile/'; //set the base url for pagination
		$config['total_rows'] = $total['total']; //total rows
		$config['per_page'] = '5'; //the number of per page for pagination
		$config['uri_segment'] = 3; //see from base_url. 3 for this case
		$config['full_tag_open'] = "<ul class=\"pagination pagination-lg\">";
		$config['full_tag_close'] = "</ul>";
		$config['cur_tag_open'] = "<li class=\"active\"><a href=\"#\">";
		$config['cur_tag_close'] = "<span class=\"sr-only\">(current)</span></a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		$this->pagination->initialize($config); //initialize pagination
		
		$data['sql'] = $this->m_company->getCompanyByAcount($this->session->userdata('company_account_id'),$config['per_page'],$offset);
		$data['company_account'] = $this->getCompanyAccount($this->session->userdata('company_account_id'));
		$data['contents'] = $this->load->view('frontend/company/form/profile', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function edit_password(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['company_account'] = $this->getCompanyAccount($this->session->userdata('company_account_id'));
		$this->form_validation->set_rules('company_account_password', 'Password', 'required|xss_clean|alpha_numeric');
		
		if ($this->form_validation->run() == true) {
			$pwd = $this->input->post("company_account_password");
            $data = array(
                "company_account_password" => $this->dokumen_lib->get_password($pwd)
            );
            $this->m_company->updateCompanyAccount(array("company_account_id" => $this->session->userdata('company_account_id')), $data);
			redirect('company/profile/', 'refresh');
        } else {
            $data['act'] = base_url().'company/edit_password/'; 
			$data['contents'] = $this->load->view('frontend/company/form/change_password', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function edit_account(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['company_account'] = $this->getCompanyAccount($this->session->userdata('company_account_id'));
		$this->form_validation->set_rules('company_account_username', 'Company Username', 'required|xss_clean|callback_check_username_edit');
		$this->form_validation->set_rules('company_account_name', 'Company Name', 'required|xss_clean');
		$this->form_validation->set_rules('company_account_email', 'Company Email', 'required|xss_clean|callback_check_email_edit');
		if ($this->form_validation->run() == true) {
			
            $data = array(
                "company_account_name" => $this->input->post("company_account_name"),
                "company_account_email" => $this->input->post("company_account_email"),
                "company_account_username" => $this->input->post("company_account_username")
            );
            $this->m_company->updateCompanyAccount(array("company_account_id" => $this->session->userdata('company_account_id')), $data);
				
			$this->session->unset_userdata('company_account_username');
			$this->session->unset_userdata('company_account_name');
			$this->session->unset_userdata('company_account_email');
			
			$this->session->set_userdata('company_account_name', $this->input->post("company_account_name"));
			$this->session->set_userdata('company_account_email', $this->input->post("company_account_email"));
			$this->session->set_userdata('company_account_username', $this->input->post("company_account_username"));
			
			redirect('company/profile/', 'refresh');
        } else {
            $data['act'] = base_url().'company/edit_account/'; 
			$data['contents'] = $this->load->view('frontend/company/form/account_edit', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function add_profile(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['company'] = $this->getCompany(0);
		$data['industry'] = $this->m_company->getMasterIndustryAll();
		$this->form_validation->set_rules('company_name', lang('company_name'), 'required|xss_clean');
		$this->form_validation->set_rules('company_phone', lang('company_phone'), 'required|xss_clean');
		$this->form_validation->set_rules('company_address', lang('company_address'), 'required|xss_clean');
		$this->form_validation->set_rules('company_desc', lang('company_long_description'), 'required|xss_clean');
		$this->form_validation->set_rules('company_shortdesc', lang('company_short_description'), 'required|xss_clean');
		$this->form_validation->set_rules('company_location', lang('company_location'), 'required|xss_clean');
		$this->form_validation->set_rules('company_industry', lang('company_industry'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			//$config['file_name'] = strtotime("now");
			$config['upload_path'] = './assets/photo/';
			$config['allowed_types'] = 'jpg|png|gif';
			$config['max_size'] = '100000';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('company_logo')) {
				$logo = '';
				$url_logo = '';
			} else {
				$files = array('upload_data' => $this->upload->data());
				$logo = $files['upload_data']['full_path'];
				$url_logo = base_url().'assets/photo/'.$files['upload_data']['file_name'];
			}
			
			if (!$this->upload->do_upload('company_banner')) {
				$banner = '';
				$url_banner = '';
			} else {
				$filesb = array('upload_data' => $this->upload->data());
				$banner = $filesb['upload_data']['full_path'];
				$url_banner = base_url().'assets/photo/'.$filesb['upload_data']['file_name'];
			}
			
			$longitude = ($this->input->post("company_longitude")) ? $this->input->post("company_longitude") : NULL;
			$latitude = ($this->input->post("company_latitude")) ? $this->input->post("company_latitude") : NULL;
			
            $data = array(
                "company_name" => $this->input->post("company_name"),
                "company_email" => $this->input->post("company_email"),
                "company_phone" => $this->input->post("company_phone"),
                "company_address" => $this->input->post("company_address"),
                "company_desc" => $this->input->post("company_desc"),
                "company_shortdesc" => $this->input->post("company_shortdesc"),
                "company_location" => $this->input->post("company_location"),
                "industry_id" => $this->input->post("company_industry"),
                "company_website" => $this->input->post("company_website"),
                "company_longitude" => $longitude,
                "company_latitude" => $latitude,
                "company_logo" => $url_logo,
                "company_banner" => $url_banner,
                "company_website" => $this->input->post("company_website"),
                "company_account_id" => $this->session->userdata('company_account_id')
            );
            $this->m_company->insertCompany($data);
			
			redirect('company/profile/', 'refresh');
        } else {
            $data['act'] = base_url().'company/add_profile/'; 
			$data['contents'] = $this->load->view('frontend/company/form/profile_edit', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function edit_profile($cid){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_profile($this->session->userdata('company_account_id'),$cid);
		$data['company'] = $this->getCompany($cid);
		$data['industry'] = $this->m_company->getMasterIndustryAll();
		$this->form_validation->set_rules('company_name', lang('company_name'), 'required|xss_clean');
		$this->form_validation->set_rules('company_phone', lang('company_phone'), 'required|xss_clean');
		$this->form_validation->set_rules('company_address', lang('company_address'), 'required|xss_clean');
		$this->form_validation->set_rules('company_desc', lang('company_long_description'), 'required|xss_clean');
		$this->form_validation->set_rules('company_shortdesc', lang('company_short_description'), 'required|xss_clean');
		$this->form_validation->set_rules('company_location', lang('company_location'), 'required|xss_clean');
		$this->form_validation->set_rules('company_industry', lang('company_industry'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			//$config['file_name'] = strtotime("now");
			$config['upload_path'] = './assets/photo/';
			$config['allowed_types'] = 'jpg|png|gif';
			$config['max_size'] = '100000';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('company_logo')) {
				$logo = $this->m_company->getCompanyById($cid)->row_array();
				$url_logo = $logo['company_logo'];
			} else {
				$files = array('upload_data' => $this->upload->data());
				$logo = $files['upload_data']['full_path'];
				$url_logo = base_url().'assets/photo/'.$files['upload_data']['file_name'];
			}
			
			if (!$this->upload->do_upload('company_banner')) {
				$banner = $this->m_company->getCompanyById($cid)->row_array();
				$url_banner = $banner['company_banner'];
			} else {
				$filesb = array('upload_data' => $this->upload->data());
				$banner = $filesb['upload_data']['full_path'];
				$url_banner = base_url().'assets/photo/'.$filesb['upload_data']['file_name'];
			}
			
			$longitude = ($this->input->post("company_longitude")) ? $this->input->post("company_longitude") : NULL;
			$latitude = ($this->input->post("company_latitude")) ? $this->input->post("company_latitude") : NULL;
			
            $data = array(
                "company_name" => $this->input->post("company_name"),
                "company_email" => $this->input->post("company_email"),
                "company_phone" => $this->input->post("company_phone"),
                "company_address" => $this->input->post("company_address"),
                "company_desc" => $this->input->post("company_desc"),
                "company_shortdesc" => $this->input->post("company_shortdesc"),
                "company_location" => $this->input->post("company_location"),
                "industry_id" => $this->input->post("company_industry"),
                "company_website" => $this->input->post("company_website"),
                "company_longitude" => $longitude,
                "company_latitude" => $latitude,
                "company_logo" => $url_logo,
                "company_banner" => $url_banner,
                "company_website" => $this->input->post("company_website"),
                "company_account_id" => $this->session->userdata('company_account_id')
            );
            $this->m_company->updateCompany(array("company_id" => $cid), $data);
			
			redirect('company/profile/', 'refresh');
        } else {
            $data['act'] = base_url().'company/edit_profile/'.$cid; 
			$data['contents'] = $this->load->view('frontend/company/form/profile_edit', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function delete_profile($cid){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_profile($this->session->userdata('company_account_id'),$cid);
		$this->m_company->deleteCompany($cid);
		redirect('company/profile/', 'refresh');
	}
	
	public function post(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['job_detail'] = false;
		$data['job_step'] = false;
		$data['job_major'] = false;
		$data['job_function'] = false;
		
		$data['company'] = $this->m_company->getCompanyAllByAcount($this->session->userdata('company_account_id'));
		$data['location'] = $this->m_company->getMasterLocationAll();
		$data['term'] = $this->m_company->getMasterTermAll();
		$data['category'] = $this->m_company->getMasterCategoryAll();
		$data['grade'] = $this->m_company->getMasterGradeAll();
		$data['major'] = $this->m_company->getMasterMajorAll();
		$data['jobfunction'] = $this->m_company->getMasterJobFunctionAll();
		$data['step'] = $this->m_company->getMasterStepAll();
		
		$this->form_validation->set_rules('company_id', lang('company'), 'required|xss_clean');
		$this->form_validation->set_rules('job_name', lang('job_name'), 'required|xss_clean');
		$this->form_validation->set_rules('job_desc', lang('job_description'), 'required|xss_clean');
		$this->form_validation->set_rules('jf_id', lang('job_function'), 'required|xss_clean');
		$this->form_validation->set_rules('job_post_date', lang('post_date'), 'required|xss_clean');
		$this->form_validation->set_rules('job_due_date', lang('expire_date'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$age = $this->input->post("job_age");
			$gender = $this->input->post("job_gender");
			$score = $this->input->post("job_score");
			$scale = $this->input->post("job_scale");
			$ages = !empty($age) ? $age : NULL;
			$genders = !empty($gender) ? $gender : NULL;
			$scores = !empty($score) ? $score : NULL;
			$scales = !empty($scale) ? $scale : NULL;
			$data = array(
                "company_id" => $this->input->post("company_id"),
                "job_name" => $this->input->post("job_name"),
                "job_desc" => $this->input->post("job_desc"),
                "category_id" => $this->input->post("category_id"),
                "city_id" => $this->input->post("city_id"),
                "term_id" => $this->input->post("term_id"),
                "job_post_date" => $this->input->post("job_post_date"),
                "job_due_date" => $this->input->post("job_due_date"),
                "grade_id" => $this->input->post("grade_id"),
                "job_years_exp" => $this->input->post("job_years_exp"),
                "job_is_external" => $this->input->post("job_is_external"),
                "job_external_url" => $this->input->post("job_external_url"),
                "job_age" => $ages,
                "job_gender" => $genders,
                "job_score" => $scores,
                "job_scale" => $scales
            );
            $job_id = $this->m_company->insertJob($data);
            
            $major = $this->input->post("major_id");
            if(!empty($major)){
				$i = 0;
				foreach($major as $row){
					$batch[$i]['job_id']=$job_id;
					$batch[$i]['major_id']=$major[$i];
					$i++;
				}
				$this->m_company->deleteJobMajorByJobId($job_id);
				$this->m_company->insertJobMajor($batch);
			}
            $jobfunc = $this->input->post("jf_id");
            if(!empty($jobfunc)){
				$k = 0;
				foreach($jobfunc as $jrow){
					$jfunc[$k]['job_id']=$job_id;
					$jfunc[$k]['jf_id']=$jobfunc[$k];
					$k++;
				}
				$this->m_company->deleteJobFunctionByJobId($job_id);
				$this->m_company->insertJobFunction($jfunc);
			}
            if($this->input->post("job_is_external") == 0){
				$step_id = $this->input->post("step_id");
				$step_desc = $this->input->post("js_desc");
				$j = 0;
				foreach($step_id as $rows){
					$steps[$j]['job_id']=$job_id;
					$steps[$j]['step_id']=$step_id[$j];
					$steps[$j]['js_order']=$j+1;
					$steps[$j]['js_desc']=$step_desc[$j];
					$j++;
				}
				$this->m_company->deleteJobStepByJobId($job_id);
				$this->m_company->insertJobStep($steps);
			}
			
            redirect('company/post_preview/'.$job_id, 'refresh');
		} else {
			$data['act'] = base_url().'company/post/'; 
			$data['contents'] = $this->load->view('frontend/company/form/post', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}        
	}
	
	public function post_preview($job_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_job($this->session->userdata('company_account_id'),$job_id);
		$data['job_detail'] = $this->m_company->getJobById($job_id);
		$data['job_step'] = $this->m_company->getJobStepByJobId($job_id);
		$data['contents'] = $this->load->view('frontend/company/form/post_preview', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function edit_post($job_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_job($this->session->userdata('company_account_id'),$job_id);
		$data['job_detail'] = $this->m_company->getJobById($job_id)->row_array();
		$data['job_step'] = $this->m_company->getJobStepByJobId($job_id);
		$job_major = array();
		$sql = $this->m_company->getJobMajorByJobId($job_id);
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$job_major[] = $row['major_id'];
			}
		}
		$data['job_major'] = $job_major;
		$job_function = array();
		$query = $this->m_company->getJobFunctionByJobId($job_id);
		if($query->num_rows() > 0){
			foreach($query->result_array() as $rows){
				$job_function[] = $rows['jf_id'];
			}
		}
		$data['job_function'] = $job_function;
		
		$data['company'] = $this->m_company->getCompanyAllByAcount($this->session->userdata('company_account_id'));
		$data['location'] = $this->m_company->getMasterLocationAll();
		$data['term'] = $this->m_company->getMasterTermAll();
		$data['category'] = $this->m_company->getMasterCategoryAll();
		$data['grade'] = $this->m_company->getMasterGradeAll();
		$data['major'] = $this->m_company->getMasterMajorAll();
		$data['jobfunction'] = $this->m_company->getMasterJobFunctionAll();
		$data['step'] = $this->m_company->getMasterStepAll();
		
		$this->form_validation->set_rules('company_id', lang('company'), 'required|xss_clean');
		$this->form_validation->set_rules('job_name', lang('job_name'), 'required|xss_clean');
		$this->form_validation->set_rules('job_desc', lang('job_description'), 'required|xss_clean');
		$this->form_validation->set_rules('job_post_date', lang('post_date'), 'required|xss_clean');
		$this->form_validation->set_rules('job_due_date', lang('expire_date'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$age = $this->input->post("job_age");
			$gender = $this->input->post("job_gender");
			$score = $this->input->post("job_score");
			$scale = $this->input->post("job_scale");
			$ages = !empty($age) ? $age : NULL;
			$genders = !empty($gender) ? $gender : NULL;
			$scores = !empty($score) ? $score : NULL;
			$scales = !empty($scale) ? $scale : NULL;
			$data = array(
                "company_id" => $this->input->post("company_id"),
                "job_name" => $this->input->post("job_name"),
                "job_desc" => $this->input->post("job_desc"),
                "category_id" => $this->input->post("category_id"),
                "city_id" => $this->input->post("city_id"),
                "term_id" => $this->input->post("term_id"),
                "job_post_date" => $this->input->post("job_post_date"),
                "job_due_date" => $this->input->post("job_due_date"),
                "grade_id" => $this->input->post("grade_id"),
                "job_years_exp" => $this->input->post("job_years_exp"),
                "job_is_external" => $this->input->post("job_is_external"),
                "job_external_url" => $this->input->post("job_external_url"),
                "job_age" => $ages,
                "job_gender" => $genders,
                "job_score" => $scores,
                "job_scale" => $scales
            );
            $this->m_company->updateJob(array("job_id" => $job_id),$data);
            
            $major = $this->input->post("major_id");
            if(!empty($major)){
				$i = 0;
				foreach($major as $row){
					$batch[$i]['job_id']=$job_id;
					$batch[$i]['major_id']=$major[$i];
					$i++;
				}
				$this->m_company->deleteJobMajorByJobId($job_id);
				$this->m_company->insertJobMajor($batch);
			}
            $jobfunc = $this->input->post("jf_id");
            if(!empty($jobfunc)){
				$k = 0;
				foreach($jobfunc as $jrow){
					$jfunc[$k]['job_id']=$job_id;
					$jfunc[$k]['jf_id']=$jobfunc[$k];
					$k++;
				}
				$this->m_company->deleteJobFunctionByJobId($job_id);
				$this->m_company->insertJobFunction($jfunc);
			}
			if($this->input->post("job_is_external") == 0){
				$step_id = $this->input->post("step_id");
				$step_desc = $this->input->post("js_desc");
				$j = 0;
				foreach($step_id as $rows){
					$steps[$j]['job_id']=$job_id;
					$steps[$j]['step_id']=$step_id[$j];
					$steps[$j]['js_order']=$j+1;
					$steps[$j]['js_desc']=$step_desc[$j];
					$j++;
				}
				$this->m_company->deleteJobStepByJobId($job_id);
				$this->m_company->insertJobStep($steps);
			}
            redirect('company/post_preview/'.$job_id, 'refresh');
		} else {
			$data['act'] = base_url().'company/edit_post/'.$job_id; 
			$data['contents'] = $this->load->view('frontend/company/form/post', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function delete_step($job_id,$js_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_job($this->session->userdata('company_account_id'),$job_id);
		$this->m_company->deleteJobStepByJsId($js_id);
		redirect('company/edit_post/'.$job_id, 'refresh');
	}
	
	public function modal_add_company(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		
		$data['industry'] = $this->m_company->getMasterIndustryAll();
		$data['act'] = base_url().'company/add_profile/'; 
		$this->load->view('frontend/company/form/profile_modal', $data);
	}
	
	public function jobs(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['listener'] = base_url().'company/jobs_listener';
		$data['contents'] = $this->load->view('frontend/company/form/jobs', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	function jobs_listener() {
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.job_name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.job_name", "job_status", "b.company_name", "a.job_post_date", "a.job_due_date", "a.job_read_count", "sumappl", "a.job_id");
		$sumcols = 8;
		$jobs = $this->m_company->JobListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $jobs->num_rows();

		$iTotal = $this->m_company->RowsJob($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($jobs->result() as $row) {
			$record = array();

			$record[] = '<a href="'.base_url().'company/post_preview/'.$row->job_id.'" >
							'.$row->job_name.'
						</a>';
			$record[] = $row->job_status;
			$record[] = $row->company_name;
			$record[] = $this->dokumen_lib->simple($row->job_post_date);
			$record[] = $this->dokumen_lib->simple($row->job_due_date);
			$record[] = $row->job_read_count;
			$record[] = $row->sumappl > 0 ? '<a href="#" onclick="showAppl(\''.base64_encode($row->job_id).'\')">'.$row->sumappl.'</a>' : $row->sumappl;
			$record[] = '
						<a class="btn btn-info" href="'.base_url().'company/edit_post/'.$row->job_id.'" >
							<span class="glyphicon glyphicon-edit"></span> 
								Edit
						</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function applicants($job_id = ''){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		if(!empty($job_id)){
			$data['job_id'] = base64_decode($job_id);
			$data['listener_job'] = base_url().'company/jobsapp_listener/'.base64_decode($job_id);
			$data['listener_step'] = base_url().'company/steps_listener/'.base64_decode($job_id);
			$data['listener_appl'] = base_url().'company/jobappl_listener/'.base64_decode($job_id);
			$data['listener_filter'] = base_url().'company/filter_listener/'.base64_decode($job_id);
		} else {
			$data['listener_job'] = base_url().'company/jobsapp_listener/0';
			$data['listener_step'] = base_url().'company/steps_listener/0';
			$data['listener_appl'] = base_url().'company/jobappl_listener/0';
			$data['listener_filter'] = base_url().'company/filter_listener/0';
		}
		$data['aot'] = $this->m_company->getAvailableAOT();
		$data['contents'] = $this->load->view('frontend/company/form/applicants', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function add_news(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['company'] = $this->m_company->getCompanyAllByAcount($this->session->userdata('company_account_id'));
		$data['news'] = false;
		$this->form_validation->set_rules('news_name', 'News Name', 'required|xss_clean');
		$this->form_validation->set_rules('news_desc', 'Description', 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			//$config['file_name'] = strtotime("now");
			$config['upload_path'] = './assets/files/';
			$config['allowed_types'] = 'zip';
			$config['max_size'] = '100000';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('news_file')) {
				$url_file = '';
			} else {
				$files = array('upload_data' => $this->upload->data());
				$url_file = base_url().'assets/files/'.$files['upload_data']['file_name'];
			}
			
            $data = array(
                "news_name" => $this->input->post("news_name"),
                "news_desc" => $this->input->post("news_desc"),
                "company_id" => $this->input->post("company_id"),
                "news_file" => $url_file
            );
            $nid = $this->m_company->insertNews($data);
			
			redirect('company/news_preview/'.$nid, 'refresh');
        } else {
            $data['act'] = base_url().'company/add_news/'; 
			$data['contents'] = $this->load->view('frontend/company/form/postnews', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function edit_news($nid){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_news($this->session->userdata('company_account_id'),$nid);
		$data['company'] = $this->m_company->getCompanyAllByAcount($this->session->userdata('company_account_id'));
		$data['news'] = $this->m_company->getNewsById($nid)->row_array();
		$this->form_validation->set_rules('news_name', 'News Name', 'required|xss_clean');
		$this->form_validation->set_rules('news_desc', 'Description', 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$config['upload_path'] = './assets/files/';
			$config['allowed_types'] = '*';
			$config['max_size'] = '100000';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('news_file')) {
				$news = $this->m_company->getNewsById($nid)->row_array();
				$url_file = $news['news_file'];
			} else {
				$files = array('upload_data' => $this->upload->data());
				$url_file = base_url().'assets/files/'.$files['upload_data']['file_name'];
			}
			
            $data = array(
                "news_name" => $this->input->post("news_name"),
                "news_desc" => $this->input->post("news_desc"),
                "company_id" => $this->input->post("company_id"),
                "news_file" => $url_file
            );
            $this->m_company->updateNews(array("news_id" => $nid), $data);
			
			redirect('company/news_preview/'.$nid, 'refresh');
        } else {
            $data['act'] = base_url().'company/edit_news/'.$nid; 
			$data['contents'] = $this->load->view('frontend/company/form/postnews', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function delete_news($nid){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_news($this->session->userdata('company_account_id'),$nid);
		$this->m_company->deleteNews($nid);
		redirect('company/news/', 'refresh');
	}
	
	public function news_preview($nid){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->dokumen_lib->check_company_news($this->session->userdata('company_account_id'),$nid);
		$data['news'] = $this->m_company->getNewsById($nid);
		$data['contents'] = $this->load->view('frontend/company/form/news_preview', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function news(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['listener'] = base_url().'company/news_listener';
		$data['contents'] = $this->load->view('frontend/company/form/news', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	function news_listener() {
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.news_name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.news_name", "b.company_name", "a.news_post_date" );
		$sumcols = 8;
		$news = $this->m_company->NewsListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $news->num_rows();

		$iTotal = $this->m_company->RowsNews($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($news->result() as $row) {
			$record = array();

			$record[] = '<a href="'.base_url().'company/news_preview/'.$row->news_id.'" >
							'.$row->news_name.'
						</a>';
			$record[] = $row->company_name;
			$record[] = $this->dokumen_lib->simple($row->news_post_date);
			$record[] = '
						<a class="btn btn-info" href="'.base_url().'company/edit_news/'.$row->news_id.'" >
							<span class="glyphicon glyphicon-edit"></span> 
								Edit
						</a>
						
						<a class="btn btn-danger" href="'.base_url().'company/delete_news/'.$row->news_id.'" >
							<span class="glyphicon glyphicon-remove"></span> 
								Del
						</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function add_jobstepperson(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		
		$data = array(
                "job_id" => $this->input->post("job_id"),
                "step_id" => $this->input->post("step_id"),
                "user_id" => $this->input->post("user_id")
            );
        $sql = $this->m_company->checkJobStepPerson($data);
        if($sql->num_rows()==0){
			$this->m_company->insertJobStepPerson($data);
		}
	}
	
	public function delete_jobstepperson($sp_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data = array(
                "job_id" => $this->input->post("job_id"),
                "step_id" => $this->input->post("step_id"),
                "user_id" => $this->input->post("user_id")
            );
        $this->m_company->deleteJobStepPerson($data);
	}
	
	public function send_personal_email($user_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$person = $this->getPerson($user_id);
		if($person){
			$cc_email = $this->input->post('cc', TRUE);
			$subject = $this->input->post('subject', TRUE);
			$message = $this->input->post('message', TRUE);
			//die(var_dump($message));
			$config['upload_path'] = './assets/files/';
			$config['allowed_types'] = 'zip';
			$config['max_size'] = '5000';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
	 
			if (!$this->upload->do_upload('attach'))
			{
				$attach_email = '';
			}
			else
			{
				$files = array('upload_data' => $this->upload->data());
				$attach_email = $files['upload_data']['full_path'];
			}
			
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
			$this->email->to($person["email"]);
			$this->email->cc($cc_email);
			if(!empty($attach_email)){
				$this->email->attach($attach_email);
			}
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			echo lang("success_send_email");
		} else {
			echo lang("failed_send_email");
		}
	}
	
	public function send_email($job_id, $step_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getEmailPersonByStep(array("a.job_id" => $job_id, "a.step_id" => $step_id));
		if($sql->num_rows()>0){
			
			$cc_email = $this->input->post('cc', TRUE);
			$subject = $this->input->post('subject', TRUE);
			$message = $this->input->post('message', TRUE);
			
			$config['upload_path'] = './assets/files/';
			$config['allowed_types'] = 'zip';
			$config['max_size'] = '5000';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
	 
			if (!$this->upload->do_upload('attach'))
			{
				$attach_email = '';
				$url_attach = '';
			}
			else
			{
				$files = array('upload_data' => $this->upload->data());
				$attach_email = $files['upload_data']['full_path'];
				$url_attach = base_url().'assets/files/'.$files['upload_data']['file_name'];
			}
			
			$batch = array(
				'js_attach' => trim($url_attach),
				'js_cc_email' => trim($cc_email),
				'js_subject_email' => trim($subject),
				'js_message_email' => trim($message),
				'js_attach_email' => trim($attach_email)
			);
			
			$this->m_company->updateJobStep(array("job_id" => $job_id, "step_id" => $step_id),$batch);
			
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			if(!empty($attach_email)){
				$this->email->attach($attach_email);
			}
			
			foreach ($sql->result_array() as $person) {
				$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
				$this->email->to($person["email"]);
				$this->email->cc($cc_email);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
			}
			
			echo lang("success_send_email");
		} else {
			echo lang("failed_send_email");
		}
	}
	
	public function email(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$this->form_validation->set_rules('to', 'Email Address', 'required');
		$this->form_validation->set_rules('subject', 'Email Subject', 'required');
		$this->form_validation->set_rules('message', 'Email Message', 'required');

        if ($this->form_validation->run() == true) {	
			$cc_email = $this->input->post('cc', TRUE);
			$to_email = $this->input->post('to', TRUE);
			$subject = $this->input->post('subject', TRUE);
			$message = $this->input->post('message', TRUE);
			
			$config['upload_path'] = './assets/files/';
			$config['allowed_types'] = 'zip';
			$config['max_size'] = '5000';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
	 
			if (!$this->upload->do_upload('attach'))
			{
				$attach_email = '';
				$url_attach = '';
			}
			else
			{
				$files = array('upload_data' => $this->upload->data());
				$attach_email = $files['upload_data']['full_path'];
				$url_attach = base_url().'assets/files/'.$files['upload_data']['file_name'];
			}
			
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			if(!empty($attach_email)){
				$this->email->attach($attach_email);
			}
			
			$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
			$this->email->to($to_email);
			$this->email->cc($cc_email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			
			$this->session->set_flashdata('success', lang("success_send_email"));
            redirect('company/email');
        } else {
			$data['act'] = base_url().'company/email'; 
            $data['contents'] = $this->load->view('frontend/company/form/email', $data, TRUE);
            $this->load->view('frontend/template', $data);
        }
	}
	
	public function send_personal_aot($job_id,$user_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$person = $this->getPerson($user_id);
		if($person){
			$message = $this->input->post("description");
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
			$this->email->to($person["email"]);
			$this->email->subject('Abipraya Online Test');
			$this->email->message($message);
			$this->email->send();
			
			$where = array(
                "exam_id" => $this->input->post("examid"),
                //"job_id" => $job_id,
                "user_id" => $user_id
            );
			$exams = array(
				"examid" => $this->input->post("examid"),
				"userid" => $row["user_id"]
			);
			$data = array(
                "exam_id" => $this->input->post("examid"),
                "job_id" => $job_id,
                "user_id" => $user_id,
                "description" => $this->input->post("description"),
                "startdate" => $this->input->post("startdate"),
                "enddate" => $this->input->post("enddate")
            );
        if($this->input->post("examid") == "disc"){
			$wheredisc = array(
                "job_id" => $job_id,
                "user_id" => $user_id
            );
			$datadisc = array(
                "job_id" => $job_id,
                "user_id" => $user_id,
                "description" => $this->input->post("description"),
                "startdate" => $this->input->post("startdate"),
                "enddate" => $this->input->post("enddate")
            );
			$this->m_company->deleteMBTIPerson($wheredisc);
			$this->m_company->insertMBTIPerson($datadisc);
		} elseif($this->input->post("examid") == "mbti"){
			$wherembti = array(
                "job_id" => $job_id,
                "user_id" => $user_id
            );
			$datambti = array(
                "job_id" => $job_id,
                "user_id" => $user_id,
                "description" => $this->input->post("description"),
                "startdate" => $this->input->post("startdate"),
                "enddate" => $this->input->post("enddate")
            );
			$this->m_company->deleteMBTIPerson($wherembti);
			$this->m_company->insertMBTIPerson($datambti);
		} else {
			$sql = $this->m_company->checkAOTPerson($where);
			if($sql->num_rows()==0){
				$this->m_company->insertAOTPerson($data);
			} else {
				$this->m_company->deleteUserExamPerson($exams);
				$this->m_company->deleteUserQuestionsPerson($exams);
				$this->m_company->deleteAOTPerson($where);
				$this->m_company->insertAOTPerson($data);
            }
		}
			echo "Success";
		} else {
			echo "failed";
		}
	}
	
	public function send_aot($job_id, $step_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getIdPersonByStep(array("a.job_id" => $job_id, "a.step_id" => $step_id));
		if($sql->num_rows()>0){
			$message = $this->input->post("description");
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			foreach($sql->result_array() as $row){
				
				$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
				$this->email->to($row["email"]);
				$this->email->subject('Abipraya Online Test');
				$this->email->message($message);
				$this->email->send();
				
				$where = array(
					"exam_id" => $this->input->post("examid"),
					"job_id" => $job_id,
					"user_id" => $row["user_id"]
				);
				$exams = array(
					"exam_id" => $this->input->post("examid"),
					"user_id" => $row["user_id"]
				);
				$data = array(
					"exam_id" => $this->input->post("examid"),
					"job_id" => $job_id,
					"user_id" => $row["user_id"],
					"description" => $this->input->post("description"),
					"startdate" => $this->input->post("startdate"),
					"enddate" => $this->input->post("enddate")
				);
		if($this->input->post("examid") == "disc"){
			$wheredisc = array(
                "job_id" => $job_id,
                "user_id" => $user_id
            );
			$datadisc = array(
                "job_id" => $job_id,
                "user_id" => $user_id,
                "description" => $this->input->post("description"),
                "startdate" => $this->input->post("startdate"),
                "enddate" => $this->input->post("enddate")
            );
			$this->m_company->deleteDISCPerson($wheredisc);
			$this->m_company->insertDISCPerson($datadisc);
		} elseif($this->input->post("examid") == "mbti"){ 
			$wherembti = array(
                "job_id" => $job_id,
                "user_id" => $user_id
            );
			$datambti = array(
                "job_id" => $job_id,
                "user_id" => $user_id,
                "description" => $this->input->post("description"),
                "startdate" => $this->input->post("startdate"),
                "enddate" => $this->input->post("enddate")
            );
			$this->m_company->deleteMBTIPerson($wherembti);
			$this->m_company->insertMBTIPerson($datambti);
		} else {
			$sql = $this->m_company->checkAOTPerson($where);
			if($sql->num_rows()==0){
				$this->m_company->insertAOTPerson($data);
			} else {
				$this->m_company->deleteUserExamPerson($exams);
				$this->m_company->deleteUserQuestionsPerson($exams);
				$this->m_company->deleteAOTPerson($where);
				$this->m_company->insertAOTPerson($data);
            }
		}
		}
			echo "Success";
		} else {
			echo "failed";
		}
	}
	
	public function send_personal_aoi($job_id,$user_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$person = $this->getPerson($user_id);
		if($person){
			$message = $this->input->post("description");
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
			$this->email->to($person["email"]);
			$this->email->subject('Abipraya Online Interview');
			$this->email->message($message);
			$this->email->send();
			
			$where = array(
                "job_id" => $job_id,
                "user_id" => $user_id
            );
			$data = array(
                "job_id" => $job_id,
                "user_id" => $user_id,
                "description" => $this->input->post("description"),
                "startdate" => $this->input->post("startdate"),
                "enddate" => $this->input->post("enddate")
            );
        $sql = $this->m_company->checkAOIPerson($where);
        if($sql->num_rows()==0){
			$this->m_company->insertAOIPerson($data);
		} else {
			$this->m_company->deleteAOIPerson($where);
			$this->m_company->insertAOIPerson($data);
        }
			echo "Success";
		} else {
			echo "failed";
		}
	}
	
	public function send_aoi($job_id, $step_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getIdPersonByStep(array("a.job_id" => $job_id, "a.step_id" => $step_id));
		if($sql->num_rows()>0){
			$message = $this->input->post("description");
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			foreach($sql->result_array() as $row){
				
				$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
				$this->email->to($row["email"]);
				$this->email->subject('Abipraya Online Interview');
				$this->email->message($message);
				$this->email->send();
				
				$where = array(
					"job_id" => $job_id,
					"user_id" => $row["user_id"]
				);
				$data = array(
					"job_id" => $job_id,
					"user_id" => $row["user_id"],
					"description" => $this->input->post("description"),
					"startdate" => $this->input->post("startdate"),
					"enddate" => $this->input->post("enddate")
				);
			$sql = $this->m_company->checkAOIPerson($where);
			if($sql->num_rows()==0){
				$this->m_company->insertAOIPerson($data);
			} else {
				$this->m_company->deleteAOIPerson($where);
				$this->m_company->insertAOIPerson($data);
			}
		}
			echo "Success";
		} else {
			echo "failed";
		}
	}
	
	public function jobsapp_listener($job_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.job_name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		if($job_id > 0) {
			$where["a.job_id"] = $job_id;
		}
		//$where["a.job_is_external"] = 0;
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.job_id", "a.job_name", "sumappl");
		$sumcols = 3;
		$jobs = $this->m_company->JobListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $jobs->num_rows();

		$iTotal = $this->m_company->RowsJob($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($jobs->result() as $row) {
			$record = array();

			$record[] = $row->job_id;
			$record[] = $row->company_name;
			$record[] = $row->job_name;
			$record[] = $row->sumappl;
			$record[] = '<a href="javascript:void(0)" class="btn btn-success export-excel" onclick="apptoexcel('.$row->job_id.')"><span class="glyphicon glyphicon-file"></span> Excel</a>';
			$record[] = '<a href="javascript:void(0)" class="btn btn-danger export-pdf" onclick="apptopdf('.$row->job_id.')"><span class="glyphicon glyphicon-list-alt"></span> PDF</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function filter_listener($job_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		
		$filter = $this->m_company->FilterListener($job_id);

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => 2,
				 "iTotalDisplayRecords" => 2,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($filter as $row) {
			$record = array();

			$record[] = $row['fid'];
			$record[] = $row['job_id'];
			$record[] = $row['name'];
			$record[] = $row['sumappl'];
			$record[] = '<a href="javascript:void(0)" class="btn btn-success export-excel" onclick="filtertoexcel('.$row['job_id'].','.$row['fid'].')"><span class="glyphicon glyphicon-file"></span> Excel</a>';
			$record[] = '<a href="javascript:void(0)" class="btn btn-danger export-pdf" onclick="filtertopdf('.$row['job_id'].','.$row['fid'].')"><span class="glyphicon glyphicon-list-alt"></span> PDF</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function steps_listener($job_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.job_name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		$where["a.job_id"] = $job_id;
		
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.job_id", "a.step_id", "a.step_name", "sumappl");
		$sumcols = 4;
		$steps = $this->m_company->StepListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $steps->num_rows();

		$iTotal = $this->m_company->RowsStep($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($steps->result_array() as $row) {
			$record = array();
			if($row['job_is_external'] > 0){
				$record[] = NULL;
				$record[] = NULL;
				$record[] = NULL;
				$record[] = NULL;
				$record[] = NULL;
				$record[] = NULL;
				$record[] = NULL;
			} else {
				$record[] = $row['job_id'];
				$record[] = $row['step_id'];
				$record[] = $row['step_name'];
				$record[] = $row['sumappl'];
				$record[] = '
							<a href="javascript:void(0)" class="btn btn-primary send-aot" onclick="sendStepAOT('.$row['job_id'].','.$row['step_id'].')"><span class="glyphicon glyphicon-list-alt"></span> AOT</a>
							<a href="javascript:void(0)" class="btn btn-warning send-aoi" onclick="sendStepAOI('.$row['job_id'].','.$row['step_id'].')"><span class="glyphicon glyphicon-facetime-video"></span> AOI</a>
							<a href="javascript:void(0)" class="btn btn-info send-email" onclick="sendStepEmail('.$row['job_id'].','.$row['step_id'].')"><span class="glyphicon glyphicon-envelope"></span> '.lang('send_email').'</a>';
				$record[] = '<a href="javascript:void(0)" class="btn btn-success export-excel" onclick="steptoexcel('.$row['job_id'].','.$row['step_id'].',\''.$row['step_name'].'\')"><span class="glyphicon glyphicon-file"></span> Excel</a>';
				$record[] = '<a href="javascript:void(0)" class="btn btn-danger export-pdf" onclick="steptopdf('.$row['job_id'].','.$row['step_id'].',\''.$row['step_name'].'\')"><span class="glyphicon glyphicon-list-alt"></span> PDF</a>';
			}
			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function jobappl_listener($job_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		$where["b.job_id"] = $job_id;
		
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.user_id", "a.name", "a.email");
		$sumcols = 3;
		$query = $this->m_company->ApplJobListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $query->num_rows();

		$iTotal = $this->m_company->RowsApplJob($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($query->result_array() as $row) {
			$next_step = $this->m_company->getNextStepAppl($job_id,$row['user_id'])->row_array();
			$current_step = $this->m_company->getCurrentStepAppl($job_id,$row['user_id'])->row_array();
			//die(print_r($step_user));	
			$record = array();

			$record[] = $row['user_id'];
			$record[] = $row['name'];
			$record[] = $row['email'];
			$record[] = !empty($current_step['step_id']) ? $current_step['step_id'] : 0;
			$record[] = !empty($current_step['step_name']) ? $current_step['step_name'].' <a href="javascript:void(0)" class="delete-step" onclick="deleteStep('.$job_id.','.$current_step['step_id'].','.$row['user_id'].')" ><span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> '.lang('del').'</span></a>' : lang('start');
			$record[] = !empty($next_step['step_id']) ? $next_step['step_id'] : 0;
			$record[] = !empty($next_step['step_name']) ? $next_step['step_name'].' <a href="javascript:void(0)" class="add-step" onclick="addStep('.$job_id.','.$next_step['step_id'].','.$row['user_id'].')"><span class="label label-success"><span class="glyphicon glyphicon-ok"></span> '.lang('add').'</span></a>' : lang('finish');
			$record[] = '
						<a href="javascript:void(0)" class="btn btn-primary send-aot" onclick="sendPersonalAOT('.$job_id.','.$row['user_id'].')"><span class="glyphicon glyphicon-list-alt"></span> AOT</a>
						<a href="javascript:void(0)" class="btn btn-warning send-aoi" onclick="sendPersonalAOI('.$job_id.','.$row['user_id'].')"><span class="glyphicon glyphicon-facetime-video"></span> AOI</a>
						<a href="javascript:void(0)" class="btn btn-info send-email" onclick="sendPersonalEmail('.$row['user_id'].')"><span class="glyphicon glyphicon-envelope"></span> '.lang('send_email').'</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function filterappl_listener($fid,$job_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.user_id", "a.name", "a.email");
		$sumcols = 3;
		if($fid == 1){
			$query = $this->m_company->getQualifiedUser($start, $where, $rows, $job_id);
			$iFilteredTotal = $query->num_rows();
			$iTotal = $this->m_company->getRowQualifiedUser($job_id, $where)->num_rows();
		} else {
			$query = $this->m_company->getUnqualifiedUser($start, $where, $rows, $job_id);
			$iFilteredTotal = $query->num_rows();
			$iTotal = $this->m_company->getRowUnqualifiedUser($job_id, $where)->num_rows();
		}
			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($query->result_array() as $row) {
			$next_step = $this->m_company->getNextStepAppl($job_id,$row['user_id'])->row_array();
			$current_step = $this->m_company->getCurrentStepAppl($job_id,$row['user_id'])->row_array();
			//die(print_r($step_user));	
			$record = array();

			$record[] = $row['user_id'];
			$record[] = $row['name'];
			$record[] = $row['email'];
			$record[] = !empty($current_step['step_id']) ? $current_step['step_id'] : 0;
			$record[] = !empty($current_step['step_name']) ? $current_step['step_name'].' <a href="javascript:void(0)" class="delete-step" onclick="deleteStep('.$job_id.','.$current_step['step_id'].','.$row['user_id'].')" ><span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> '.lang('del').'</span></a>' : lang('start');
			$record[] = !empty($next_step['step_id']) ? $next_step['step_id'] : 0;
			$record[] = !empty($next_step['step_name']) ? $next_step['step_name'].' <a href="javascript:void(0)" class="add-step" onclick="addStep('.$job_id.','.$next_step['step_id'].','.$row['user_id'].')"><span class="label label-success"><span class="glyphicon glyphicon-ok"></span> '.lang('add').'</span></a>' : lang('finish');
			$record[] = '
						<a href="javascript:void(0)" class="btn btn-primary send-aot" onclick="sendPersonalAOT('.$job_id.','.$row['user_id'].')"><span class="glyphicon glyphicon-list-alt"></span> AOT</a>
						<a href="javascript:void(0)" class="btn btn-warning send-aoi" onclick="sendPersonalAOI('.$job_id.','.$row['user_id'].')"><span class="glyphicon glyphicon-facetime-video"></span> AOI</a>
						<a href="javascript:void(0)" class="btn btn-info send-email" onclick="sendPersonalEmail('.$row['user_id'].')"><span class="glyphicon glyphicon-envelope"></span> '.lang('send_email').'</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function stepappl_listener($job_id,$step_id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		$where["b.job_id"] = $job_id;
		$where["b.step_id"] = $step_id;
		
		$current = $this->m_company->getStep(array("b.job_id" =>$job_id, "b.step_id" => $step_id))->row_array();
		$next_order = ($current['js_order']+1);
		$next = $this->m_company->getStep(array("b.job_id" =>$job_id, "b.js_order" => $next_order))->row_array();
		
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.user_id", "a.name", "a.email");
		$sumcols = 3;
		$query = $this->m_company->ApplStepListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $query->num_rows();

		$iTotal = $this->m_company->RowsApplStep($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($query->result_array() as $row) {
			$next_step = $this->m_company->getNextStepAppl($job_id,$row['user_id'])->row_array();
			$current_step = $this->m_company->getCurrentStepAppl($job_id,$row['user_id'])->row_array();
			//die(print_r($step_user));	
			$record = array();

			$record[] = $row['user_id'];
			$record[] = $row['name'];
			$record[] = $row['email'];
			$record[] = !empty($current_step['step_id']) && $current_step['step_id'] == $current['step_id'] ? $current_step['step_id'] : $current['step_id'];
			$record[] = !empty($current_step['step_name']) && $current_step['step_id'] == $current['step_id'] ? $current_step['step_name'].' <a href="javascript:void(0)" class="delete-step" onclick="deleteStep('.$job_id.','.$current_step['step_id'].','.$row['user_id'].')" ><span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> '.lang('del').'</span></a>' : $current['step_name'];
			$record[] = !empty($next_step['step_id']) && $next_step['step_id'] == $next['step_id'] ? $next_step['step_id'] : (!empty($next['step_id']) ? $next['step_id'] : 0);
			$record[] = !empty($next_step['step_name']) && $next_step['step_id'] == $next['step_id'] ? $next_step['step_name'].' <a href="javascript:void(0)" class="add-step" onclick="addStep('.$job_id.','.$next_step['step_id'].','.$row['user_id'].')"><span class="label label-success"><span class="glyphicon glyphicon-ok"></span> '.lang('add').'</span></a>' : (!empty($next['step_name']) ? $next['step_name'] : lang('finish'));
			$record[] = '
						<a href="javascript:void(0)" class="btn btn-primary send-aot" onclick="sendPersonalAOT('.$job_id.','.$row['user_id'].')"><span class="glyphicon glyphicon-list-alt"></span> AOT</a>
						<a href="javascript:void(0)" class="btn btn-warning send-aoi" onclick="sendPersonalAOI('.$job_id.','.$row['user_id'].')"><span class="glyphicon glyphicon-facetime-video"></span> AOI</a>
						<a href="javascript:void(0)" class="btn btn-info send-email" onclick="sendPersonalEmail('.$row['user_id'].')"><span class="glyphicon glyphicon-envelope"></span> '.lang('send_email').'</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function aotapp_listener($examid){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.examname) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		if($examid > 0) {
			$where["a.examid"] = $examid;
		}
		//$where["a.job_is_external"] = 0;
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.examid", "a.examname", "sumappl");
		$sumcols = 3;
		$jobs = $this->m_company->AotListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $jobs->num_rows();

		$iTotal = $this->m_company->RowsAot($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($jobs->result() as $row) {
			$record = array();

			$record[] = $row->examid;
			$record[] = $row->examname;
			$record[] = $row->sumappl;
			$record[] = '<a href="javascript:void(0)" class="btn btn-success export-excel" onclick="aottoexcel('.$row->examid.')"><span class="glyphicon glyphicon-file"></span> Excel</a>';
			$record[] = '<a href="javascript:void(0)" class="btn btn-danger export-pdf" onclick="aottopdf('.$row->examid.')"><span class="glyphicon glyphicon-list-alt"></span> PDF</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	public function check_email_edit($email) {

        if ($this->m_company->check_email($email) && $this->session->userdata('company_account_email') != $email) {
            return false;
			$this->form_validation->set_message('check_email_edit', "Email " . $email . " exist. Choose another email!");
        } else {
            return true;
        }
	}
	
	public function check_username_edit($username) {

        if ($this->m_company->check_username($username) && $this->session->userdata('company_account_username') != $username) {
			$this->form_validation->set_message('check_username_edit', "Username " . $username . " exist, choose another Company Username.");
            return false;
        } else {
			return true;
        }
    }
	
	public function getCompanyAccount($id){
		$this->dokumen_lib->check_company_login($id);
		$sql = $this->m_company->getCompanyAccountById($id);
		$res = false;
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
		}
		return $res;
	}
	
	public function getCompany($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getCompanyById($id);
		$res = false;
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
		}
		return $res;
	}
	
	/*
	 * for resume preview
	 */
	 public function cv($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['person'] = $this->getPerson($id);
		$data['card'] = $this->getPersonCard($id);
		$data['training'] = $this->getPersonTraining($id);
		$data['language'] = $this->getPersonLang($id);
		$data['education'] = $this->getPersonEducation($id);
		$data['experience'] = $this->getPersonExperience($id);
		$data['expectation'] = $this->getPersonExpectation($id);
		echo $this->load->view('frontend/company/form/cv_preview', $data, TRUE);
	}
	
	public function pdfcv($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['person'] = $this->getPerson($id);
		$data['card'] = $this->getPersonCard($id);
		$data['training'] = $this->getPersonTraining($id);
		$data['language'] = $this->getPersonLang($id);
		$data['education'] = $this->getPersonEducation($id);
		$data['experience'] = $this->getPersonExperience($id);
		$data['expectation'] = $this->getPersonExpectation($id);
		$this->load->helper(array('dompdf', 'file'));
		// page info here, db calls, etc.     
		$html = $this->load->view('frontend/company/form/cv_pdf', $data, TRUE);
		$filename = $data['person'] ? url_title($data['person']['name'],'underscore') : 'CV';
		pdf_create($html, $filename);
		//$file_to_save = './assets/zip/'.$filename;
		//save the pdf file on the server
		//file_put_contents($file_to_save, pdf_create($html, $filename, false)); 
	}
	
	public function export(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['listener_job'] = base_url().'company/jobsapp_listener/0';
		$data['listener_step'] = base_url().'company/steps_listener/0';
		$data['listener_appl'] = base_url().'company/jobappl_listener/0';
		$data['listener_filter'] = base_url().'company/filter_listener/0';
		$data['listener_aot'] = base_url().'company/aotapp_listener/0';
		
		$data['contents'] = $this->load->view('frontend/company/form/export', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function aottoexcel(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$examid = $this->input->post('examid');
		$database = $this->m_company->getApplAotExport($examid);
		$this->load->library('excel');
        $header = array('No', lang('full_name'), lang('gender'), lang('age'), lang('experience'), lang('birth_place'), lang('birth_date'), lang('religion'), lang('score'), lang('scale'), lang('education'), lang('field_of_study'), lang('university'), lang('city'), 'Email', lang('phone'));
		$result = array();
		$i=1;
		$vowels = array("@", ".");
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
		$cacheSettings = array( 'dir'  => '/var/www/tmp');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		$inputFileType = 'Excel2007';
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		//$objReader->setReadDataOnly(true);
		if ($database->num_rows() > 0) {
			$j = ceil($database->num_rows());
			foreach ($database->result_array() as $row) {
				 $result[] = array(
					'no' => $i,
					'name' => $row['name'],
					'gender' => lang(strtolower($row['gender'])),
					'age' => floor($row['ages'] / 12),
					'exp' => floor($row['exp'] / 12),
					'birth_place' => $row['birth_place'],
					'birth_date' => $this->dokumen_lib->simple2($row['birth_date']),
					'religion' => $row['religion'],
					'grade' => $row['edu_gpa'],
					'scale' => $row['edu_gpa_scale'],
					'education' => $row['grade_name'],
					'major' => $row['major_name'],
					'university' => $row['edu_name'],
					'edu_place' => $row['edu_place'],
					'email' => $row['email'],
					'phone' => $row['phone']
					);
                $i++;
                //sleep(15);
		   }
		}
        $this->excel->getProperties()->setTitle("e-Recruitment");
        $this->excel->getProperties()->setSubject("e-Recruitment");
        $this->excel->getProperties()->setDescription("e-Recruitment");
        $this->excel->getProperties()->setKeywords("e-Recruitment");
        $this->excel->getProperties()->setCategory("e-Recruitment");

        $this->excel->getActiveSheet()->fromArray($header, null, 'A1');
        $this->excel->getActiveSheet()->fromArray($result, null, 'A2');
        $this->excel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="report.xls"');
        $objWriter->save("php://output");
	}
	
	public function aottopdf(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$examid = $this->input->post('examid');
		$database = $this->m_company->getApplAotExportSimple($examid);
		if($database->num_rows() > 0){
			ini_set('memory_limit','576M');
			set_time_limit(-1);
			$this->load->library('StreamZip');
			$zip = new ZipStream("resume.zip");
			$this->load->helper(array('dompdf', 'file'));
			$i = 1;
			//$fp = fopen('./pdfdebug.txt', 'w');
			foreach($database->result_array() as $row){
				//if($row['user_id'] != 4644 && $row['user_id'] != 4692){
				$data['person'] = $this->getPerson($row['user_id']);
				$data['card'] = $this->getPersonCard($row['user_id']);
				$data['training'] = $this->getPersonTraining($row['user_id']);
				$data['language'] = $this->getPersonLang($row['user_id']);
				$data['education'] = $this->getPersonEducation($row['user_id']);
				$data['experience'] = $this->getPersonExperience($row['user_id']);
				$data['expectation'] = $this->getPersonExpectation($row['user_id']);
				
//fwrite($fp, $row['user_id'].' || ');
				$html = $this->load->view('frontend/company/form/cv_pdf', $data, TRUE);
				$filename = $data['person'] ? preg_replace('/[^\p{L}\p{N}\s]/u', '_', url_title($data['person']['name'],'underscore')) : 'CV';
				$stream = pdf_create($html, $filename, false);
				$attach = $data['expectation']->row_array();
				$zip->addDirectory($filename);
				////$zip->addFile($stream, $filename."/CV_".$filename.".pdf");
				$zip->openStream($filename."/CV_".$filename.".pdf");
				$zip->addStreamData($stream);
				$zip->closeStream();
				//mkdir("./assets/zip/$filename", 0777, true);
				//$file_to_save = './assets/zip/'.$filename.'/'.$filename;
				//save the pdf file on the server
				//file_put_contents($file_to_save, pdf_create($html, $filename, false));
				//$zip->addLargeFile("./assets/zip/".$filename, $filename."/CV_".$filename.".pdf", FALSE);
				if(!empty($attach['expected_url_cv'])){
					$fileuser = strstr($attach['expected_url_cv'], 'assets/');
					$attext = pathinfo($fileuser);
					$zip->addLargeFile("./".$fileuser, $filename."/Lampiran_".$filename.".".$attext['extension'], FALSE);
					//file_put_contents($file_to_save, "./".$fileuser);
				}
				//$zip->openStream("CV_".$filename.".pdf");
				//$zip->addStreamData($stream);
				//$zip->closeStream();
				$i++;
				//}
			}
			$zip->finalize();
			
			//array_map('unlink', glob("./assets/zip/*"));
//fclose($fp);
		}
	}
	
	public function apptoexcel(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$job_id = $this->input->post('job_id');
		$database = $this->m_company->getApplJobExport($job_id);
		$this->load->library('excel');
        $header = array('No', lang('full_name'), lang('gender'), lang('age'), lang('experience'), lang('birth_place'), lang('birth_date'), lang('religion'), lang('score'), lang('scale'), lang('education'), lang('field_of_study'), lang('university'), lang('city'), 'Email', lang('phone'), lang('job_name'), lang('company_name'));
		$result = array();
		$i=1;
		$vowels = array("@", ".");
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
		$cacheSettings = array( 'dir'  => '/var/www/tmp');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		$inputFileType = 'Excel2007';
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		//$objReader->setReadDataOnly(true);
		if ($database->num_rows() > 0) {
			$j = ceil($database->num_rows());
			foreach ($database->result_array() as $row) {
				 $result[] = array(
					'no' => $i,
					'name' => $row['name'],
					'gender' => lang(strtolower($row['gender'])),
					'age' => floor($row['ages'] / 12),
					'exp' => floor($row['exp'] / 12),
					'birth_place' => $row['birth_place'],
					'birth_date' => $this->dokumen_lib->simple2($row['birth_date']),
					'religion' => $row['religion'],
					'grade' => $row['edu_gpa'],
					'scale' => $row['edu_gpa_scale'],
					'education' => $row['grade_name'],
					'major' => $row['major_name'],
					'university' => $row['edu_name'],
					'edu_place' => $row['edu_place'],
					'email' => $row['email'],
					'phone' => $row['phone'],
					'job_name' => $row['job_name'],
					'company_name' => $row['company_name']
					);
                $i++;
                //sleep(15);
		   }
		}
        $this->excel->getProperties()->setTitle("e-Recruitment");
        $this->excel->getProperties()->setSubject("e-Recruitment");
        $this->excel->getProperties()->setDescription("e-Recruitment");
        $this->excel->getProperties()->setKeywords("e-Recruitment");
        $this->excel->getProperties()->setCategory("e-Recruitment");

        $this->excel->getActiveSheet()->fromArray($header, null, 'A1');
        $this->excel->getActiveSheet()->fromArray($result, null, 'A2');
        $this->excel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="report.xls"');
        $objWriter->save("php://output");
	}
	
	public function apptopdf(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$job_id = $this->input->post('job_id');
		$database = $this->m_company->getApplJobExportSimple($job_id);
		if($database->num_rows() > 0){
			ini_set('memory_limit','576M');
			set_time_limit(-1);
			$this->load->library('StreamZip');
			$zip = new ZipStream("resume.zip");
			$this->load->helper(array('dompdf', 'file'));
			$i = 1;
			//$fp = fopen('./pdfdebug.txt', 'w');
			foreach($database->result_array() as $row){
				//if($row['user_id'] != 4644 && $row['user_id'] != 4692){
				$data['person'] = $this->getPerson($row['user_id']);
				$data['card'] = $this->getPersonCard($row['user_id']);
				$data['training'] = $this->getPersonTraining($row['user_id']);
				$data['language'] = $this->getPersonLang($row['user_id']);
				$data['education'] = $this->getPersonEducation($row['user_id']);
				$data['experience'] = $this->getPersonExperience($row['user_id']);
				$data['expectation'] = $this->getPersonExpectation($row['user_id']);
				
//fwrite($fp, $row['user_id'].' || ');
				$html = $this->load->view('frontend/company/form/cv_pdf', $data, TRUE);
				$filename = $data['person'] ? preg_replace('/[^\p{L}\p{N}\s]/u', '_', url_title($data['person']['name'],'underscore')) : 'CV';
				$stream = pdf_create($html, $filename, false);
				$attach = $data['expectation']->row_array();
				$zip->addDirectory($filename);
				////$zip->addFile($stream, $filename."/CV_".$filename.".pdf");
				$zip->openStream($filename."/CV_".$filename.".pdf");
				$zip->addStreamData($stream);
				$zip->closeStream();
				//mkdir("./assets/zip/$filename", 0777, true);
				//$file_to_save = './assets/zip/'.$filename.'/'.$filename;
				//save the pdf file on the server
				//file_put_contents($file_to_save, pdf_create($html, $filename, false));
				//$zip->addLargeFile("./assets/zip/".$filename, $filename."/CV_".$filename.".pdf", FALSE);
				if(!empty($attach['expected_url_cv'])){
					$fileuser = strstr($attach['expected_url_cv'], 'assets/');
					$attext = pathinfo($fileuser);
					$zip->addLargeFile("./".$fileuser, $filename."/Lampiran_".$filename.".".$attext['extension'], FALSE);
					//file_put_contents($file_to_save, "./".$fileuser);
				}
				//$zip->openStream("CV_".$filename.".pdf");
				//$zip->addStreamData($stream);
				//$zip->closeStream();
				$i++;
				//}
			}
			$zip->finalize();
			
			//array_map('unlink', glob("./assets/zip/*"));
//fclose($fp);
		}
	}
	
	public function filtertoexcel(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$job_id = $this->input->post('job_id');
		$fid = $this->input->post('fid');
		if($fid>0){
			$name = "Qualified";
			$database = $this->m_company->getApplQualifiedExport($job_id);
		} else {
			$name = "Unqualified";
			$database = $this->m_company->getApplUnqualifiedExport($job_id);
		}
		$this->load->library('excel');
        $header = array('No', lang('full_name'), lang('gender'), lang('age'), lang('experience'), lang('birth_place'), lang('birth_date'), lang('religion'), lang('score'), lang('scale'), lang('education'), lang('field_of_study'), lang('university'), lang('city'), 'Email', lang('phone'), lang('job_name'), lang('company_name'));
		$result = array();
		$i=1;
		$vowels = array("@", ".");
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
		$cacheSettings = array( 'dir'  => '/var/www/tmp');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		$inputFileType = 'Excel2007';
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		//$objReader->setReadDataOnly(true);
		if ($database->num_rows() > 0) {
			$j = ceil($database->num_rows());
			foreach ($database->result_array() as $row) {
				 $result[] = array(
					'no' => $i,
					'name' => $row['name'],
					'gender' => lang(strtolower($row['gender'])),
					'age' => floor($row['ages'] / 12),
					'exp' => floor($row['exp'] / 12),
					'birth_place' => $row['birth_place'],
					'birth_date' => $this->dokumen_lib->simple2($row['birth_date']),
					'religion' => $row['religion'],
					'grade' => $row['edu_gpa'],
					'scale' => $row['edu_gpa_scale'],
					'education' => $row['grade_name'],
					'major' => $row['major_name'],
					'university' => $row['edu_name'],
					'edu_place' => $row['edu_place'],
					'email' => $row['email'],
					'phone' => $row['phone'],
					'job_name' => $row['job_name'],
					'company_name' => $row['company_name']
					);
                $i++;
                //sleep(15);
		   }
		}
        $this->excel->getProperties()->setTitle("e-Recruitment");
        $this->excel->getProperties()->setSubject("e-Recruitment");
        $this->excel->getProperties()->setDescription("e-Recruitment");
        $this->excel->getProperties()->setKeywords("e-Recruitment");
        $this->excel->getProperties()->setCategory("e-Recruitment");

        $this->excel->getActiveSheet()->fromArray($header, null, 'A1');
        $this->excel->getActiveSheet()->fromArray($result, null, 'A2');
        $this->excel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$name.'_report.xls"');
        $objWriter->save("php://output");
	}
	
	public function filtertopdf(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$job_id = $this->input->post('job_id');
		$fid = $this->input->post('fid');
		if($fid>0){
			$name = "Qualified";
			$database = $this->m_company->getApplQualifiedExport($job_id);
		} else {
			$name = "Unqualified";
			$database = $this->m_company->getApplUnqualifiedExport($job_id);
		}
		if($database->num_rows() > 0){
			set_time_limit(-1);
			$this->load->library('StreamZip');
			$zip = new ZipStream("resume.zip");
			foreach($database->result_array() as $row){
				$data['person'] = $this->getPerson($row['user_id']);
				$data['card'] = $this->getPersonCard($row['user_id']);
				$data['training'] = $this->getPersonTraining($row['user_id']);
				$data['language'] = $this->getPersonLang($row['user_id']);
				$data['education'] = $this->getPersonEducation($row['user_id']);
				$data['experience'] = $this->getPersonExperience($row['user_id']);
				$data['expectation'] = $this->getPersonExpectation($row['user_id']);
				
				$this->load->helper(array('dompdf', 'file'));
				$html = $this->load->view('frontend/company/form/cv_pdf', $data, TRUE);
				$filename = $data['person'] ? url_title($data['person']['name'],'underscore') : 'CV';
				$stream = pdf_create($html, $filename, false);
				$attach = $data['expectation']->row_array();
				$zip->addDirectory($filename);
				//$zip->addFile($stream, $filename."/CV_".$filename.".pdf");
				$zip->openStream($filename."/CV_".$filename.".pdf");
				$zip->addStreamData($stream);
				$zip->closeStream();
				if(!empty($attach['expected_url_cv'])){
					$fileuser = strstr($attach['expected_url_cv'], 'assets/');
					$attext = pathinfo($fileuser);
					$zip->addLargeFile("./".$fileuser, $filename."/Lampiran_".$filename.".".$attext['extension'], FALSE);
				}
				//$zip->openStream($filename.".pdf");
				//$zip->addStreamData($stream);
				//$zip->closeStream();
			}
			$zip->finalize();
		}
	}
	
	public function steptoexcel(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$job_id = $this->input->post('job_id');
		$step_id = $this->input->post('step_id');
		$step_name = $this->input->post('step_name');
		$database = $this->m_company->getApplStepExport($job_id,$step_id);
		$this->load->library('excel');
        $header = array('No', lang('full_name'), lang('gender'), lang('age'), lang('experience'), lang('birth_place'), lang('birth_date'), lang('religion'), lang('score'), lang('scale'), lang('education'), lang('field_of_study'), lang('university'), lang('city'), 'Email', lang('phone'), lang('job_name'), lang('steps'), lang('company_name'));
		$result = array();
		$i=1;
		$vowels = array("@", ".");
		$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
		$cacheSettings = array( 'dir'  => '/var/www/tmp');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		$inputFileType = 'Excel2007';
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		//$objReader->setReadDataOnly(true);
		if ($database->num_rows() > 0) {
			$j = ceil($database->num_rows());
			foreach ($database->result_array() as $row) {
				 $result[] = array(
					'no' => $i,
					'name' => $row['name'],
					'gender' => lang(strtolower($row['gender'])),
					'age' => floor($row['ages'] / 12),
					'exp' => floor($row['exp'] / 12),
					'birth_place' => $row['birth_place'],
					'birth_date' => $this->dokumen_lib->simple2($row['birth_date']),
					'religion' => $row['religion'],
					'grade' => $row['edu_gpa'],
					'scale' => $row['edu_gpa_scale'],
					'education' => $row['grade_name'],
					'major' => $row['major_name'],
					'university' => $row['edu_name'],
					'edu_place' => $row['edu_place'],
					'email' => $row['email'],
					'phone' => $row['phone'],
					'job_name' => $row['job_name'],
					'step_name' => $step_name,
					'company_name' => $row['company_name']
					);
                $i++;
                //sleep(15);
		   }
		}
        $this->excel->getProperties()->setTitle("e-Recruitment");
        $this->excel->getProperties()->setSubject("e-Recruitment");
        $this->excel->getProperties()->setDescription("e-Recruitment");
        $this->excel->getProperties()->setKeywords("e-Recruitment");
        $this->excel->getProperties()->setCategory("e-Recruitment");

        $this->excel->getActiveSheet()->fromArray($header, null, 'A1');
        $this->excel->getActiveSheet()->fromArray($result, null, 'A2');
        $this->excel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$step_name.'_report.xls"');
        $objWriter->save("php://output");
	}
	
	public function steptopdf(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$job_id = $this->input->post('job_id');
		$step_id = $this->input->post('step_id');
		$step_name = $this->input->post('step_name');
		$database = $this->m_company->getApplStepExport($job_id,$step_id);
		if($database->num_rows() > 0){
			set_time_limit(-1);
			$this->load->library('StreamZip');
			$zip = new ZipStream("resume.zip");
			foreach($database->result_array() as $row){
				$data['person'] = $this->getPerson($row['user_id']);
				$data['card'] = $this->getPersonCard($row['user_id']);
				$data['training'] = $this->getPersonTraining($row['user_id']);
				$data['language'] = $this->getPersonLang($row['user_id']);
				$data['education'] = $this->getPersonEducation($row['user_id']);
				$data['experience'] = $this->getPersonExperience($row['user_id']);
				$data['expectation'] = $this->getPersonExpectation($row['user_id']);
				
				$this->load->helper(array('dompdf', 'file'));
				$html = $this->load->view('frontend/company/form/cv_pdf', $data, TRUE);
				$filename = $data['person'] ? url_title($data['person']['name'],'underscore') : 'CV';
				$stream = pdf_create($html, $filename, false);
				$attach = $data['expectation']->row_array();
				$zip->addDirectory($filename);
				//$zip->addFile($stream, $filename."/CV_".$filename.".pdf");
				$zip->openStream($filename."/CV_".$filename.".pdf");
				$zip->addStreamData($stream);
				$zip->closeStream();
				if(!empty($attach['expected_url_cv'])){
					$fileuser = strstr($attach['expected_url_cv'], 'assets/');
					$attext = pathinfo($fileuser);
					$zip->addLargeFile("./".$fileuser, $filename."/Lampiran_".$filename.".".$attext['extension'], FALSE);
				}
				//$zip->openStream($filename."/CV_".$filename.".pdf");
				//$zip->addStreamData($stream);
				//$zip->closeStream();
			}
			$zip->finalize();
		}
	}
	
	public function aot(){
		redirect(base_url().'aot/admin/token/'.rawurlencode(base64_encode($this->session->userdata('company_account_id'))));
	}
	
	public function aoi(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['aoi'] = $this->m_company->getAllAoi();
		//die(print_r($data['aoi']));
		$data['contents'] = $this->load->view('frontend/company/form/aoi', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function getPerson($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getPersonById($id);
		$res = false;
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
		}
		return $res;
	}
	
	public function getPersonCard($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getPersonCardById($id);
		return $sql;
	}
	
	public function getPersonTraining($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getPersonTrainingById($id);
		return $sql;
	}
	
	public function getPersonLang($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getPersonLangById($id);
		return $sql;
	}
	
	public function getPersonEducation($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getPersonEducationById($id);
		return $sql;
	}
	
	public function getPersonExperience($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getPersonExperienceById($id);
		return $sql;
	}
	
	public function getPersonExpectation($id){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$sql = $this->m_company->getPersonExpectationById($id);
		return $sql;
	}
	
	// begin add search applicants
	public function search(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		$data['listener'] = base_url().'company/appl_listener/';
		$data['aot'] = $this->m_company->getAvailableAOT();
		$data['contents'] = $this->load->view('frontend/company/form/search', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function appl_listener(){
		$this->dokumen_lib->check_company_login($this->session->userdata('company_account_id'));
		// variable initialization
		$search = "";
		$start = 10;
		$rows = 0;
		$where = array();
		
		// get search value (if any)
		if ($this->input->post('sSearch') != "" ) 
		{
			//$search = $this->input->post('sSearch');
			$where["LOWER(a.name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
			$where["LOWER(a.email) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
		}
		
		// limit
		$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
		$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

		// sort
		$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

		// run query to get user listing
		$cols = array(  "a.user_id", "c.job_id", "c.job_name", "a.name", "a.email");
		$sumcols = 3;
		$jobs = $this->m_company->ApplListener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
		$iFilteredTotal = $jobs->num_rows();

		$iTotal = $this->m_company->RowsAppl($where)->num_rows();

			/*
			 * Output
			 */
			 $output = array(
				 "sEcho" => intval($this->input->post('sEcho')),
				 "iTotalRecords" => $iFilteredTotal,
				 "iTotalDisplayRecords" => $iTotal,
				 "aaData" => array()
			 );

			// get result after running query and put it in array
			foreach ($jobs->result() as $row) {
			$record = array();
			$job_id = !empty($row->job_id) ? $row->job_id : 0;
			$record[] = $row->user_id;
			$record[] = $row->job_id;
			$record[] = $row->job_name;
			$record[] = $row->name;
			$record[] = $row->email;
			$record[] = '
						<a href="javascript:void(0)" class="btn btn-primary send-aot" onclick="sendPersonalAOT('.$job_id.','.$row->user_id.')"><span class="glyphicon glyphicon-list-alt"></span> AOT</a>
						<a href="javascript:void(0)" class="btn btn-warning send-aoi" onclick="sendPersonalAOI('.$job_id.','.$row->user_id.')"><span class="glyphicon glyphicon-facetime-video"></span> AOI</a>
						<a href="javascript:void(0)" class="btn btn-info send-email" onclick="sendPersonalEmail('.$row->user_id.')"><span class="glyphicon glyphicon-envelope"></span> '.lang('send_email').'</a>';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable
		echo json_encode($output);
	}
	
	// End search applicants
	public function valid_confirmation_code($security_code) {
		
		$this->load->library('securimage_library');
        if ($this->securimage_library->check($security_code) == true) {
            return TRUE;
        } else {
            $this->form_validation->set_message('valid_confirmation_code', 'Invalid Security Code');
            return FALSE;
        }
    }
}
