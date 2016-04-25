<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        is_userlogged_in();
        $this->load->model('user_model');
    }

	public function index()
	{
		$data = array();
		$data['page'] = 'dashboard';
		$this->load->view('user/content', $data);
	}
	public function exams()
	{
		$data = array();
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$data['examlist'] = $this->user_model->exams($userid);
		}
		
		$data['page'] = 'examslist';
		$this->load->view('user/content', $data);
	}
	function takeexam($examid=0)
	{
		$data = array();
		$data['examdetails'] = $this->user_model->examdetails($examid);
		$data['page'] = 'startexam';
		$this->load->view('user/content', $data);
	}
	function exam($examid=0)
	{
		$data = array();
		$examdata = $this->user_model->examdata($examid);
		$data['page'] = 'exam';
		$data['duration'] = $examdata->duration * 60;
		$data['examid'] = $examid;
		$this->load->view('user/content', $data);
	}
	function save_answer()
	{
		$useranswer = $_POST['a'];
		$examid = $_POST['id'];
		$questionid = $_POST['q'];
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$this->user_model->save_answer($useranswer, $examid, $questionid, $userid);
			$response = 'success';
		}
		else
		{
			$response = 'relogin';
		}
		echo $response;	
	}
	function finish_user_exam()
	{
		$examid = $_POST['id'];
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$this->user_model->finish_user_exam($examid, $userid);
			$response = 'success';
		}
		else
		{
			$response = 'relogin';
		}
		echo $response;	
	}
	function get_user_exam_data()
	{
		$examid = $_POST['examId'];
		$examdata = $this->user_model->get_exam_data($examid);
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;

			$this->user_model->recordexam_start($examid, $loggeduser->userid);
		}
		echo json_encode($examdata);
	}

	function submit_exam($examid)
	{
		/*$data = array();
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$results = $this->user_model->exam_results($examid, $userid);
		}
		else
		{
			redirect(base_url().'users/exams');
		}

		$data['results'] = $results;
		$data['page'] = 'exam_results';
		$this->load->view('user/content', $data);*/
		
		redirect(base_url().'users/exams');
	}

	function results_summary($examid)
	{
		$data = array();
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$results = $this->user_model->exam_results($examid, $userid);
		}
		else
		{
			redirect(base_url());
		}

		$data['results'] = $results;
		$data['page'] = 'exam_results';
		$this->load->view('user/content', $data);
	}

	function profile()
	{
		$data = array();
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
		}
		else
		{
			redirect(base_url());
		}
		if(isset($_POST['updateprofilebttn']))
		{
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('newpassword', 'New password', 'trim|xss_clean|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('confirmnewpassword', 'Confirm new password', 'trim|xss_clean|matches[newpassword]');
			$this->form_validation->set_rules('currentpassword', 'Password', 'trim|xss_clean');
			$this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
		
			if($this->form_validation->run() == FALSE) 
			{
				$data['reset'] = FALSE;
			}
			else
			{
				$userdetails = array('firstname' => $this->input->post('firstname'),
									 'lastname'  => $this->input->post('lastname'),
									 'email'     => $this->input->post('email')
					);
				$newpassword = $this->input->post('newpassword');
				if(isset($newpassword) && $newpassword != '')
				{
					$userdetails['password'] = sha1($this->input->post('newpassword'));
				}
				$indexid = $this->input->post('userid');
				$curpassword = $this->input->post('currentpassword');
				if($this->user_model->updateprofile($userdetails, $indexid, $curpassword))
				{
					$data['success'] = 'Account details updated successfully !';
				}
				else
				{
					$data['error'] = 'An error occurred while updating your account, please make sure you have entered the correct password !';
				}

			}
		}


		$data['userdetails'] = $this->user_model->userprofile($userid);
		$data['page'] = 'profile';
		$this->load->view('user/content', $data);
	}

	function email_exists($email)
	{
		if($this->user_model->email_exists($email))
		{
		$this->form_validation->set_message('email_exists', 'Email already exists. Select another email');
        return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function view_results()
	{
		$data = array();
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$results = $this->user_model->get_exams_attempted($userid);
		}
		else
		{
			redirect(base_url());
		}
		$data['exams_attempted'] = $results;
		$data['page'] = 'view_results';
		$this->load->view('user/content', $data);
	}
	
	/* DISC */
	function takedisc()
	{
		$data = array();
		$data['details'] = $this->user_model->discdetails();
		$data['page'] = 'startdisc';
		$this->load->view('user/content', $data);
	}
	
	function disc()
	{
		$data = array();
		$data['page'] = 'disc';
		$this->load->view('user/content', $data);
	}
	
	function get_user_disc_data()
	{
		$examdata = $this->user_model->get_disc_data();
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;

			$this->user_model->recorddisc_start($loggeduser->userid);
		}
		echo json_encode($examdata);
	}
	
	function save_answer_disc()
	{
		$useranswer_m = $_POST['m'];
		$useranswer_j = $_POST['j'];
		$questionid = $_POST['q'];
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$this->user_model->save_answer_disc($useranswer_m, $useranswer_j, $questionid, $userid);
			$response = 'success';
		}
		else
		{
			$response = 'relogin';
		}
		echo $response;	
	}
	
	function finish_user_disc()
	{
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$this->user_model->finish_user_disc($userid);
			$response = 'success';
		}
		else
		{
			$response = 'relogin';
		}
		echo $response;	
	}
	
	function submit_disc()
	{
		redirect(base_url().'users/exams');
	}
	/* End DISC */
	
	/* MBTI */
	function takembti()
	{
		$data = array();
		$data['details'] = $this->user_model->mbtidetails();
		$data['page'] = 'startmbti';
		$this->load->view('user/content', $data);
	}
	
	function mbti()
	{
		$data = array();
		$data['page'] = 'mbti';
		$this->load->view('user/content', $data);
	}
	
	function get_user_mbti_data()
	{
		$examdata = $this->user_model->get_mbti_data();
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;

			$this->user_model->recordmbti_start($loggeduser->userid);
		}
		echo json_encode($examdata);
	}
	
	function save_answer_mbti()
	{
		$useranswer = $_POST['a'];
		$questionid = $_POST['q'];
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$this->user_model->save_answer_mbti($useranswer, $questionid, $userid);
			$response = 'success';
		}
		else
		{
			$response = 'relogin';
		}
		echo $response;	
	}
	
	function finish_user_mbti()
	{
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->userid;
			$this->user_model->finish_user_mbti($userid);
			$response = 'success';
		}
		else
		{
			$response = 'relogin';
		}
		echo $response;	
	}
	
	function submit_mbti()
	{
		redirect(base_url().'users/exams');
	}
	/* End MBTI */
	
}
