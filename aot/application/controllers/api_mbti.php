<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_mbti extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //is_userlogged_in();
        $this->load->model('api_mbti_model');
    }

	/* MBTI */
	function takembti()
	{
		$guestid = $this->api_mbti_model->recordmbti_start();
		$userdata['userdetails'] = array('guestid' =>$guestid);
		$this->session->set_userdata($userdata);
		$examdata = $this->api_mbti_model->get_mbti_data(5,0);
		echo json_encode($examdata);
	}
	
	function mbti($offset = 0)
	{
		$details = $this->api_mbti_model->mbtidetails(5,$offset);
		echo json_encode($details);
	}
	
	function get_user_mbti_data($offset = 0)
	{
		$examdata = $this->api_mbti_model->get_mbti_data(5,$offset);
		echo json_encode($examdata);
	}
	
	function save_answer_mbti()
	{
		$param = json_decode(file_get_contents("php://input"), true);
		$useranswer = $param['answer'];
		$questionid = $param['question'];
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->guestid;
			$this->api_mbti_model->save_answer_mbti($useranswer, $questionid, $userid);
			$response['msgs'] = 'success';
		}
		else
		{
			$response['msgs'] = 'relogin';
		}
		echo json_encode($response);	
	}
	
	function finish_user_mbti()
	{
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->guestid;
			$this->api_mbti_model->finish_user_mbti($userid);
			$response = $this->api_mbti_model->get_mbti_results($userid);
		}
		else
		{
			$response['msgs'] = 'relogin';
		}
		echo json_encode($response);
	}
	
	function submit_mbti()
	{
		$response['msgs'] = 'done';
		echo json_encode($response);
	}
	/* End MBTI */
	
}
