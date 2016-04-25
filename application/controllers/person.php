<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Person extends CI_Controller {

	public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->getLanguage();
		$this->load->model("m_person");
    }
	
	public function index(){
		redirect('home');
	}
	
    public function login(){
		$data['act'] = base_url().'person/ceklogin';      
		$this->load->view('frontend/apl/login', $data);
	}
	
	public function ceklogin(){
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$data['act'] = base_url().'person/ceklogin'; 
			
        if ($this->form_validation->run() == false) {     
			$this->load->view('frontend/apl/form/login_failed', $data);           
        } else {
			$username = $this->input->post('email');
			$password = $this->input->post('password');
			if($this->input->post('remember_me')){
				setcookie("cookname", base64_encode($username), time()+60*60*24*100, "/");
				setcookie("cookpass", base64_encode($password), time()+60*60*24*100, "/");
			}
			
			$res = $this->m_person->getUserLogin($username,$this->dokumen_lib->get_password($password));
        
			if ($res->num_rows() > 0) {
				$row = $res->row_array();
				$this->session->set_userdata('user_id', $row['user_id']);
				$this->session->set_userdata('user_key', $this->dokumen_lib->get_password($row['user_id']));
				$this->session->set_userdata('name', $row['name']);
				$this->session->set_userdata('username', $row['username']);
				$this->session->set_userdata('useraot', $this->m_person->getSumAotPerson($row['user_id']));
				$this->session->set_userdata('useraoi', $this->m_person->getSumAoiPerson($row['user_id']));
				redirect('home');
			} else {
				$this->session->set_flashdata('info', lang('account_does_not_exist._maybe_your_input_is_incorrect_or_your_account_is_not_active'));
				redirect('person/login_failed'); 
            }
			
        }
		
	}
	
	public function login_failed(){
		$data['act'] = base_url().'person/ceklogin';
		$this->load->view('frontend/apl/form/login_failed', $data); 
	}
	
	public function register(){
		$data['act'] = base_url().'person/cekregister'; 
		$this->load->view('frontend/apl/register',$data);
	}
	
	public function register_success(){
		$this->load->view('frontend/apl/form/register_success');
	}
	
	public function cekregister(){
		$this->form_validation->set_rules('name', lang('full_name'), 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean|callback_check_email_reg');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean|alpha_numeric');
		$this->form_validation->set_rules('security_code', 'security_code', 'alpha_numeric|required|xss_clean|callback_valid_confirmation_code');
		
        if ($this->form_validation->run() == true) {

            $fields["username"] = $this->input->post("email");
            $fields["name"] = $this->input->post("name");
            $fields["email"] = $this->input->post("email");
            //$fields["is_active"] = 1;
            $fields["password"] = $this->dokumen_lib->get_password($this->input->post("password"));
            
            $exec = $this->m_person->insertPerson($fields);
            $this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
			$this->email->to($fields["email"]);

			$this->email->subject('e-Recruitment Registration');
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
									Congratulations you have registered in e-Recruitment. For the next process
									Please click the link below to confirmation your account. Thank you.<br>
									<br>
									<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
									cellspacing="2">
									<tbody>
									<tr>
									<td style="vertical-align: top; width: 253px;"><a href="'.base_url().'person/email_confirmation/'.base64_encode($exec).'"><big><span
									style="font-weight: bold;">Click here to confirmation your account</span></big></a><br>
									</td>
									</tr>
									<tr>
									<td style="vertical-align: top;">Or copy paste this link to your web browser : '.base_url().'person/email_confirmation/'.base64_encode($exec).'<br>
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
            //$this->session->set_flashdata('success', lang('registration_successful.'));
            redirect('person/register_success');
//            }
//            else {
//                $this->session->set_flashdata('error','Registration failed');
//            }
        } else {
			$data['act'] = base_url().'person/cekregister'; 
            $this->load->view('frontend/apl/form/register_failed', $data);
        }
	}
	
	public function check_email_reg($email) {

        if ($this->m_person->check_email($email)) {
			$this->form_validation->set_message('check_email_reg', "Email " . $email . " ".lang('already_registered,_choose_another_email'));
            return false;
        } else {
			return true;
        }
    }
	
	public function forgot(){
		$data['act'] = base_url().'person/cekforgot'; 
		$this->load->view('frontend/apl/form/forgot_failed',$data);
	}
	
	public function cekforgot(){
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required|xss_clean|callback_check_email_forgot');
		
		if ($this->form_validation->run() == true) {
			$email = $this->input->post("email");
			$pwd = $this->dokumen_lib->generate_random_password(6);
            $data = array(
                "password" => $this->dokumen_lib->get_password($pwd)
            );
            $this->m_person->updatePerson(array("email" => $email), $data);
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
            redirect('person/register_success');
        } else {

            $data['act'] = base_url().'person/cekforgot'; 
            $this->load->view('frontend/apl/form/forgot_failed', $data);
        }
    }
    
	public function check_email_forgot($email) {

        if ($this->m_person->check_email($email)) {
            return true;
        } else {
			$this->form_validation->set_message('check_email_forgot', "Email " . $email . " ".lang('does_not_exist'));
            return false;
        }
	}
	
	public function email_confirmation($key) {
		$id = base64_decode($key);
        $data = array(
            "is_active" => 1,
            "is_confirmation" => 1
        );
        $this->m_person->updatePerson(array("user_id" => $id), $data);
        $res = $this->m_person->getPersonById($id);
        if ($res->num_rows() > 0) {
				$row = $res->row_array();
				$this->session->unset_userdata('user_id');
				$this->session->unset_userdata('user_key');
				$this->session->unset_userdata('username');
				$this->session->unset_userdata('name');
        
				$this->session->set_userdata('user_id', $row['user_id']);
				$this->session->set_userdata('user_key', $this->dokumen_lib->get_password($row['user_id']));
				$this->session->set_userdata('name', $row['name']);
				$this->session->set_userdata('username', $row['username']);
				$this->session->set_flashdata('success', lang('your_account_has_been_activated!'));
				redirect('person/register_success');
		}
    }
	
	public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_key');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('useraot');
        $this->session->unset_userdata('useraoi');
        redirect("home");
    }
    
    public function account(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['person'] = $this->getPerson($id);
		$data['contents'] = $this->load->view('frontend/apl/form/account_detail', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function edit_password(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['person'] = $this->getPerson($id);
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean|alpha_numeric');
		
		if ($this->form_validation->run() == true) {
			$pwd = $this->input->post("password");
            $data = array(
                "password" => $this->dokumen_lib->get_password($pwd)
            );
            $this->m_person->updatePerson(array("user_id" => $id), $data);
			redirect('person/account/');
        } else {
            $data['act'] = base_url().'person/edit_password/'; 
			$data['contents'] = $this->load->view('frontend/apl/form/change_password', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function edit_account(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['person'] = $this->getPerson($id);
		$this->form_validation->set_rules('name', lang('full_name'), 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|callback_check_email_edit');
		$this->form_validation->set_rules('phone', lang('phone'), 'required|xss_clean');
		$this->form_validation->set_rules('address', lang('address'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
            $data = array(
                "username" => $this->input->post("email"),
                "name" => $this->input->post("name"),
                "email" => $this->input->post("email"),
                "phone" => $this->input->post("phone"),
                "address" => $this->input->post("address")
            );
            $this->m_person->updatePerson(array("user_id" => $id), $data);
				
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('name');
			
			$this->session->set_userdata('name', $this->input->post("name"));
			$this->session->set_userdata('username', $this->input->post("email"));
			
			redirect('person/account/');
        } else {
            $data['act'] = base_url().'person/edit_account/'; 
			$data['contents'] = $this->load->view('frontend/apl/form/account_edit', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function jobalert(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['person'] = $this->getPerson($id);
		
		$job_function = array();
		$query = $this->m_person->getJobAlertByUserId($id);
		if($query->num_rows() > 0){
			foreach($query->result_array() as $rows){
				$job_function[] = $rows['jf_id'];
			}
		}
		$data['job_alert'] = $job_function;
		$data['job_function'] = $this->m_person->getMasterJobFunctionAll();
		
		$this->form_validation->set_rules('is_job_alert', lang('subscribe'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
            $is_job_alert = $this->input->post("is_job_alert");
            $job_alert_time = $this->input->post("job_alert_time");
            $data = array(
                "is_job_alert" => $is_job_alert,
                "job_alert_time" => $job_alert_time
            );
            $this->m_person->updatePerson(array("user_id" => $id), $data);
			if($is_job_alert > 0 ){
				$jobfunc = $this->input->post("jf_id");
				$k = 0;
				foreach($jobfunc as $jrow){
					$jfunc[$k]['user_id']=$id;
					$jfunc[$k]['jf_id']=$jobfunc[$k];
					$k++;
				}
				$this->m_person->deleteJobAlertByUserId($id);
				$this->m_person->insertJobAlert($jfunc);
			}
			
			redirect('person/account/');
        } else {
            $data['act'] = base_url().'person/jobalert/'; 
			$data['contents'] = $this->load->view('frontend/apl/form/job_alert', $data, TRUE);
			$this->load->view('frontend/template', $data);
        }
	}
	
	public function cv(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['person'] = $this->getPerson($id);
		$data['card'] = $this->getPersonCard($id);
		$data['training'] = $this->getPersonTraining($id);
		$data['language'] = $this->getPersonLang($id);
		$data['education'] = $this->getPersonEducation($id);
		$data['experience'] = $this->getPersonExperience($id);
		$data['expectation'] = $this->getPersonExpectation($id);
		$data['contents'] = $this->load->view('frontend/apl/form/cv_detail', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function edit_cv_info(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['person'] = $this->getPerson($id);
		
		$this->form_validation->set_rules('name', lang('full_name'), 'required|xss_clean');
		$this->form_validation->set_rules('gender', lang('gender'), 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|callback_check_email_edit');
		$this->form_validation->set_rules('phone', lang('phone'), 'required|xss_clean');
		$this->form_validation->set_rules('address', lang('address'), 'required|xss_clean');
		$this->form_validation->set_rules('city', lang('city'), 'required|xss_clean');
		$this->form_validation->set_rules('birth_place', lang('birth_place'), 'required|xss_clean');
		$this->form_validation->set_rules('birth_date', lang('birth_date'), 'required|xss_clean');
		$this->form_validation->set_rules('religion', lang('religion'), 'required|xss_clean');
		$this->form_validation->set_rules('height', lang('height'), 'required|xss_clean');
		$this->form_validation->set_rules('weight', lang('weight'), 'required|xss_clean');
		$this->form_validation->set_rules('marital_status', lang('marital_status'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			
			$config['file_name'] = strtotime("now");
			$config['upload_path'] = './assets/photo/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '4000';
			$config['overwrite'] = FALSE;
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('photo')) {
				$files = $this->m_person->getPersonById($id)->row_array();
				$file = $files['photo'];
			} else {
				$files = array('upload_data' => $this->upload->data());
				$file = $files['upload_data']['file_name'];
			}
			
            $data = array(
                "name" => $this->input->post("name"),
                "gender" => $this->input->post("gender"),
                "marital_status" => $this->input->post("marital_status"),
                "email" => $this->input->post("email"),
                "phone" => $this->input->post("phone"),
                "address" => $this->input->post("address"),
                "city" => $this->input->post("city"),
                "birth_place" => $this->input->post("birth_place"),
                "birth_date" => $this->input->post("birth_date"),
                "religion" => $this->input->post("religion"),
                "height" => $this->input->post("height"),
                "weight" => $this->input->post("weight"),
                "photo" => base_url().'assets/photo/'.$file
            );
            $this->m_person->updatePerson(array("user_id" => $id), $data);
				
			$this->session->unset_userdata('username');
			$this->session->unset_userdata('name');
			
			$this->session->set_userdata('name', $this->input->post("name"));
			$this->session->set_userdata('username', $this->input->post("email"));
			
			redirect('person/cv/');
        } else {
			$data['act'] = base_url().'person/edit_cv_info/';
			$data['contents'] = $this->load->view('frontend/apl/form/edit_cv_info', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function edit_cv_card(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['card'] = $this->getPersonCard($id);
		
		$this->form_validation->set_rules('card_name[]', lang('card_name'), 'required|xss_clean');
		$this->form_validation->set_rules('card_number[]', lang('card_number'), 'required|xss_clean');
		$this->form_validation->set_rules('card_place[]', lang('card_place'), 'required|xss_clean');
		$this->form_validation->set_rules('card_expire[]', lang('card_expire'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$card_name = $this->input->post("card_name");
			$card_number = $this->input->post("card_number");
			$card_place = $this->input->post("card_place");
			$card_expire = $this->input->post("card_expire");
			$i = 0;
			foreach($card_name as $row){
				$batch[$i]['user_id']=$id;
				$batch[$i]['card_name']=$card_name[$i];
				$batch[$i]['card_number'] = $card_number[$i];
				$batch[$i]['card_place'] = $card_place[$i];
				$batch[$i]['card_expire'] = $card_expire[$i];
				$i++;
			}
			//die(print_r($batch));
            $this->m_person->deletePersonCardById($id);
            $this->m_person->insertPersonCard($batch);
				
			redirect('person/cv/');
        } else {
			$data['act'] = base_url().'person/edit_cv_card/';
			$data['contents'] = $this->load->view('frontend/apl/form/edit_cv_card', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function deleteCard($card_id){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$this->m_person->deleteCardById($card_id);
		redirect('person/edit_cv_card/'.$this->session->userdata('user_id'), 'refresh');
	}
	
	public function edit_cv_education(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['education'] = $this->getPersonEducation($id);
		$data['grade'] = $this->m_person->getMasterGradeAll();
		$data['major'] = $this->m_person->getMasterMajorAll();
		
		$this->form_validation->set_rules('edu_name[]', lang('university'), 'required|xss_clean');
		$this->form_validation->set_rules('edu_place[]', lang('city'), 'required|xss_clean');
		$this->form_validation->set_rules('grade_id[]', lang('grade_name'), 'required|xss_clean');
		$this->form_validation->set_rules('major_id[]', lang('field_of_study'), 'required|xss_clean');
		//$this->form_validation->set_rules('edu_years[]', lang('graduation_year'), 'xss_clean|numeric');
		//$this->form_validation->set_rules('edu_gpa[]', lang('grade'), 'xss_clean|numeric');
		//$this->form_validation->set_rules('edu_gpa_scale[]', lang('grade'), 'xss_clean|numeric');
		
		if ($this->form_validation->run() == true) {
			$edu_name = $this->input->post("edu_name");
			$edu_years = $this->input->post("edu_years");
			$edu_place = $this->input->post("edu_place");
			$edu_gpa = $this->input->post("edu_gpa");
			$edu_gpa_scale = $this->input->post("edu_gpa_scale");
			$grade_id = $this->input->post("grade_id");
			$major_id = $this->input->post("major_id");
			$edu_status = $this->input->post("edu_status");
			$i = 0;
			foreach($edu_name as $row){
				$years = !empty($edu_years[$i]) ? $edu_years[$i] : NULL;
				$gpa = !empty($edu_gpa[$i]) ? $edu_gpa[$i] : 0;
				$scale = !empty($edu_gpa_scale[$i]) ? $edu_gpa_scale[$i] : 0;
				$batch[$i]['user_id']=$id;
				$batch[$i]['grade_id']=$grade_id[$i];
				$batch[$i]['major_id']=$major_id[$i];
				$batch[$i]['edu_name']=$edu_name[$i];
				$batch[$i]['edu_years'] = $years;
				$batch[$i]['edu_place'] = $edu_place[$i];
				$batch[$i]['edu_gpa'] = $gpa;
				$batch[$i]['edu_gpa_scale'] = $scale;
				$batch[$i]['edu_status'] = $edu_status[$i];
				$i++;
			}
			//die(print_r($batch));
            $this->m_person->deletePersonEduById($id);
            $this->m_person->insertPersonEdu($batch);
				
			redirect('person/cv/');
        } else {
			$data['act'] = base_url().'person/edit_cv_education/';
			$data['contents'] = $this->load->view('frontend/apl/form/edit_cv_education', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function deleteEducation($edu_id){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$this->m_person->deleteEduById($edu_id);
		redirect('person/edit_cv_education/'.$this->session->userdata('user_id'), 'refresh');
	}
	
	public function edit_cv_language(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['language'] = $this->getPersonLang($id);
		
		$this->form_validation->set_rules('lang_name[]', lang('language'), 'required|xss_clean');
		$this->form_validation->set_rules('lang_talking[]', lang('spoken'), 'required|xss_clean|numeric');
		$this->form_validation->set_rules('lang_writing[]', lang('writen'), 'required|xss_clean|numeric');
		$this->form_validation->set_rules('lang_score[]', lang('score'), 'xss_clean');
		$this->form_validation->set_rules('lang_description[]', lang('description'), 'xss_clean');
		
		if ($this->form_validation->run() == true) {
			$lang_name = $this->input->post("lang_name");
			$lang_talking = $this->input->post("lang_talking");
			$lang_writing = $this->input->post("lang_writing");
			$lang_description = $this->input->post("lang_description");
			$lang_score = $this->input->post("lang_score");
			$i = 0;
			foreach($lang_name as $row){
				$batch[$i]['user_id']=$id;
				$batch[$i]['lang_name']=$lang_name[$i];
				$batch[$i]['lang_talking'] = $lang_talking[$i];
				$batch[$i]['lang_writing'] = $lang_writing[$i];
				$batch[$i]['lang_description'] = $lang_description[$i];
				$batch[$i]['lang_score'] = !empty($lang_score[$i]) ? $lang_score[$i] : 0;
				$i++;
			}
			//die(print_r($batch));
            $this->m_person->deletePersonLangById($id);
            $this->m_person->insertPersonLang($batch);
				
			redirect('person/cv/');
        } else {
			$data['act'] = base_url().'person/edit_cv_language/';
			$data['contents'] = $this->load->view('frontend/apl/form/edit_cv_language', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function deleteLanguage($lang_id){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$this->m_person->deleteLangById($lang_id);
		redirect('person/edit_cv_language/'.$this->session->userdata('user_id'), 'refresh');
	}
	
	public function edit_cv_training(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['training'] = $this->getPersonTraining($id);
		
		$this->form_validation->set_rules('training_name[]', lang('training_name'), 'required|xss_clean');
		$this->form_validation->set_rules('training_trainer[]', lang('training_institution'), 'required|xss_clean');
		$this->form_validation->set_rules('training_city[]', lang('training_location'), 'required|xss_clean');
		$this->form_validation->set_rules('training_years[]', lang('training_year'), 'required|xss_clean|numeric');
		
		if ($this->form_validation->run() == true) {
			$training_name = $this->input->post("training_name");
			$training_trainer = $this->input->post("training_trainer");
			$training_city = $this->input->post("training_city");
			$training_years = $this->input->post("training_years");
			$i = 0;
			foreach($training_name as $row){
				$batch[$i]['user_id']=$id;
				$batch[$i]['training_name']=$training_name[$i];
				$batch[$i]['training_trainer']=$training_trainer[$i];
				$batch[$i]['training_city']=$training_city[$i];
				$batch[$i]['training_years']=$training_years[$i];
				$i++;
			}
			//die(print_r($batch));
            $this->m_person->deletePersonTrainingById($id);
            $this->m_person->insertPersonTraining($batch);
				
			redirect('person/cv/');
        } else {
			$data['act'] = base_url().'person/edit_cv_training/';
			$data['contents'] = $this->load->view('frontend/apl/form/edit_cv_training', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function deleteTraining($training_id){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$this->m_person->deleteTrainingById($training_id);
		redirect('person/edit_cv_training/'.$this->session->userdata('user_id'), 'refresh');
	}

	public function edit_cv_experience(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['experience'] = $this->getPersonExperience($id);
		
		$this->form_validation->set_rules('exp_company[]', lang('company_name'), 'required|xss_clean');
		$this->form_validation->set_rules('exp_major[]', lang('company_major'), 'required|xss_clean');
		$this->form_validation->set_rules('exp_address[]', lang('company_address'), 'required|xss_clean');
		$this->form_validation->set_rules('exp_position[]', lang('last_position'), 'required|xss_clean');
		$this->form_validation->set_rules('exp_sallary[]', lang('last_sallary'), 'required|xss_clean|integer');
		$this->form_validation->set_rules('exp_jobdesc[]', lang('job_description'), 'required|xss_clean');
		$this->form_validation->set_rules('exp_joindate[]', lang('join_date'), 'required|xss_clean');
		
		if ($this->form_validation->run() == true) {
			$exp_company = $this->input->post("exp_company");
			$exp_major = $this->input->post("exp_major");
			$exp_address = $this->input->post("exp_address");
			$exp_position = $this->input->post("exp_position");
			$exp_sallary = $this->input->post("exp_sallary");
			$exp_jobdesc = $this->input->post("exp_jobdesc");
			$exp_joindate = $this->input->post("exp_joindate");
			$outdate = $this->input->post("exp_outdate");
			$exp_untilnow = $this->input->post("exp_untilnow");
			$i = 0;
			foreach($exp_company as $row){				
				$exp_outdate = !empty($outdate[$i]) ? $outdate[$i] : NULL;
				$batch[$i]['user_id']=$id;
				$batch[$i]['exp_company']=$exp_company[$i];
				$batch[$i]['exp_major']=$exp_major[$i];
				$batch[$i]['exp_address']=$exp_address[$i];
				$batch[$i]['exp_position']=$exp_position[$i];
				$batch[$i]['exp_sallary']=$exp_sallary[$i];
				$batch[$i]['exp_jobdesc']=$exp_jobdesc[$i];
				$batch[$i]['exp_joindate']=$exp_joindate[$i];
				$batch[$i]['exp_outdate']=$exp_outdate;
				$batch[$i]['exp_untilnow']=$exp_untilnow[$i];
				$i++;
			}
			//die(print_r($batch));
            $this->m_person->deletePersonExpById($id);
            $this->m_person->insertPersonExp($batch);
				
			redirect('person/cv/');
        } else {
			$data['act'] = base_url().'person/edit_cv_experience/';
			$data['contents'] = $this->load->view('frontend/apl/form/edit_cv_experience', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function deleteExperience($exp_id){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$this->m_person->deleteExpById($exp_id);
		redirect('person/edit_cv_experience/'.$this->session->userdata('user_id'), 'refresh');
	}
	
	public function edit_cv_expected(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['expectation'] = $this->getPersonExpectation($id);
		$data['location'] = $this->m_person->getMasterLocationAll();
		
		$this->form_validation->set_rules('expected_sallary', lang('expected_sallary'), 'required|xss_clean|integer');
		
		if ($this->form_validation->run() == true) {
			
			$config['file_name'] = $this->session->userdata('user_key');
			$config['upload_path'] = './assets/files/';
			$config['allowed_types'] = 'pdf|doc|docx';
			$config['max_size'] = '350';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			
			if (!$this->upload->do_upload('expected_url_cv')) {
				$files = $this->m_person->getPersonExpectationById($id)->row_array();
				$file = $files['expected_url_cv'];
			} else {
				$files = array('upload_data' => $this->upload->data());
				$file = base_url().'assets/files/'.$files['upload_data']['file_name'];
			}
			
			$expected_sallary = $this->input->post("expected_sallary");
			$city_id = $this->input->post("city_id");
			$expected_description = $this->input->post("expected_description");
			
			$batch = array(
                "user_id" => $id,
                "expected_sallary" => $expected_sallary,
                "city_id" => $city_id,
                "expected_description" => $expected_description,
                "expected_url_cv" => $file
            );
			//die(print_r($batch));
            $this->m_person->deletePersonExpectedById($id);
            $this->m_person->insertPersonExpected($batch);
				
			redirect('person/cv/');
        } else {
			$data['act'] = base_url().'person/edit_cv_expected/';
			$data['contents'] = $this->load->view('frontend/apl/form/edit_cv_expectation', $data, TRUE);
			$this->load->view('frontend/template', $data);
		}
	}
	
	public function application(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['job_status'] = $this->m_person->getAllJobStatusPerson($id);
		//die(print_r($data['job_status']));
		$data['contents'] = $this->load->view('frontend/apl/form/application_status', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function aot(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['aot'] = $this->m_person->getAllAotPerson($id);
		//die(print_r($data['aot']));
		$data['contents'] = $this->load->view('frontend/apl/form/aot_status', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function aoi(){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['aoi'] = $this->m_person->getAllAoiPerson($id);
		//die(print_r($data['aoi']));
		$data['contents'] = $this->load->view('frontend/apl/form/aoi_status', $data, TRUE);
		$this->load->view('frontend/template', $data);
	}
	
	public function view_jobstep($js_id){
		$id = $this->session->userdata('user_id');
		$this->dokumen_lib->check_person_login($id);
		$data['step'] = $this->m_person->getJobStepById($js_id);
		$data['contents'] = $this->load->view('frontend/apl/form/view_jobstep', $data);
	}
	
	public function check_email_edit($email) {
		
        if ($this->m_person->check_email($email) && $this->session->userdata('username') != $email) {
            return false;
			$this->form_validation->set_message('check_email_edit', "Email " . $email . " ".lang('exist._choose_another_email!'));
        } else {
            return true;
        }
	}
	
	public function submitjob($job_id){
		$this->session->set_userdata('joblink',base_url().'home/detail/');
		$id = $this->session->userdata('user_id');
		$job = $this->m_person->checkJob(array("job_id" => $job_id));
		if(!is_numeric($job_id) OR $job->num_rows() == 0){
			redirect('home');
		};
		$this->dokumen_lib->check_person_login($id);
		$external = $this->m_person->isExternalJob($job_id);
		if($external){
			$where = array(
						"job_id" => $job_id,
						"user_id" => $id
					);
			$sql = $this->m_person->checkPersonJob($where);
			if($sql->num_rows()>0){
				header("Location: $external");
			} else {
				$data = array(
							"job_id" => $job_id,
							"user_id" => $id
				);
				$this->m_person->insertPersonJob($data);
				header("Location: $external");
			}
		} else {
			$ClearToSubmit = $this->m_person->getYearsPersonJob(array("user_id" => $id));
			if($ClearToSubmit){
				$where = array(
							"job_id" => $job_id,
							"user_id" => $id
						);
				$sql = $this->m_person->checkPersonJob($where);
				if($sql->num_rows()>0){
					$this->session->set_flashdata('info', lang('you_already_submit_this_job'));
					redirect('person/application');
				} else {
					$data = array(
								"job_id" => $job_id,
								"user_id" => $id
					);
					$this->m_person->insertPersonJob($data);
					$this->session->set_flashdata('info', lang('you_have_successfully_submit_the_job'));
					redirect('person/application');
				}
			} else {
				$this->session->set_flashdata('info', lang('you_can_only_submit_1_job_per_years'));
				redirect('person/application');
			}
		}
	}
	
	public function getPerson($id){
		$this->dokumen_lib->check_person_login($id);
		$sql = $this->m_person->getPersonById($id);
		$res = false;
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
		}
		return $res;
	}
	
	public function getPersonCard($id){
		$this->dokumen_lib->check_person_login($id);
		$sql = $this->m_person->getPersonCardById($id);
		return $sql;
	}
	
	public function getPersonTraining($id){
		$this->dokumen_lib->check_person_login($id);
		$sql = $this->m_person->getPersonTrainingById($id);
		return $sql;
	}
	
	public function getPersonLang($id){
		$this->dokumen_lib->check_person_login($id);
		$sql = $this->m_person->getPersonLangById($id);
		return $sql;
	}
	
	public function getPersonEducation($id){
		$this->dokumen_lib->check_person_login($id);
		$sql = $this->m_person->getPersonEducationById($id);
		return $sql;
	}
	
	public function getPersonExperience($id){
		$this->dokumen_lib->check_person_login($id);
		$sql = $this->m_person->getPersonExperienceById($id);
		return $sql;
	}
	
	public function getPersonExpectation($id){
		$this->dokumen_lib->check_person_login($id);
		$sql = $this->m_person->getPersonExpectationById($id);
		return $sql;
	}
	
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
