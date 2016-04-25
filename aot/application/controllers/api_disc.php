<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_disc extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //is_userlogged_in();
        $this->load->model('api_disc_model');
    }

	/* DISC */
	function token($key)
	{
		if(isset($key))
		{
			$user = $this->api_disc_model->logintoken(base64_decode(rawurldecode(($key))));	
			if($user)
			{
				$email = $user['email'];
				$name = $user['name'];
				$user_id = $user['user_id'];
				$this->session->set_userdata('user_id', $user['user_id']);
				$this->session->set_userdata('email', $user['email']);
				$this->session->set_userdata('name', $user['name']);
				redirect(substr_replace(base_url(), '/karakter', -5, -1));
			} else {
				redirect(substr_replace(base_url(), '', -5, -1));
			}
		} else {
			redirect(substr_replace(base_url(), '', -5, -1));
		}
	}
	
	function getSession()
	{
		$user['user_id'] = $this->session->userdata('user_id');
		$user['email'] = $this->session->userdata('email');
		$user['name'] = $this->session->userdata('name');
		echo json_encode($user);
	}
	
	function takedisc()
	{
		$param = json_decode(file_get_contents("php://input"), true);
		$user_id = $param['user_id'];
		$email = $param['email'];
		$name = $param['name'];
		$guestid = $this->api_disc_model->recorddisc_start($user_id, $email,$name);
		$userdata['userdetails'] = array('guestid' =>$guestid);
		$this->session->set_userdata($userdata);
		$examdata = $this->api_disc_model->get_disc_data(4,0);
		echo json_encode($examdata);
	}
	
	function disc($offset = 0)
	{
		$details = $this->api_disc_model->discdetails(4,$offset);
		echo json_encode($details);
	}
	
	function get_user_disc_data($offset = 0)
	{
		$examdata = $this->api_disc_model->get_disc_data(4,$offset);
		echo json_encode($examdata);
	}
	
	function save_answer_disc()
	{
		$param = json_decode(file_get_contents("php://input"), true);
		$option = $param['option'];
		$marks = $param['marks'];
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->guestid;
			$this->api_disc_model->save_answer_disc($option, $marks, $userid);
			$response['msgs'] = 'success';
		}
		else
		{
			$response['msgs'] = 'relogin';
		}
		echo json_encode($response);	
	}
	
	function finish_user_disc()
	{
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->guestid;
			$this->api_disc_model->finish_user_disc($userid);
			$response = $this->api_disc_model->get_disc_results($userid);
		}
		else
		{
			$response['msgs'] = 'relogin';
		}
		echo json_encode($response);
	}
	
	function show_grafik()
	{
		$response = $this->api_disc_model->get_disc_results(79);
		echo json_encode($response);
	}
	
	public function send_email(){
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->guestid;
			$dataemail = $this->api_disc_model->email_result($userid);
			
			$param = json_decode(file_get_contents("php://input"), true);
			$email1 = $param['email1'];
			$email2 = $param['email2'];
			$email3 = $param['email3'];
			$email4 = $param['email4'];
			$msgs = $param['msgs'];	
			
			$this->load->library('email');
			$config['protocol'] = 'mail';
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from('noreply@brantas-abipraya.co.id', 'Tes Minat Bakat');
			$this->email->to($dataemail['email']);
			$this->email->subject('Hasil Tes Minat Bakat Anda : '.$dataemail['type']);
			$this->email->message($dataemail['long_desc']);
			$this->email->send();
			$this->email->clear();
			$this->email->from('noreply@brantas-abipraya.co.id', 'Tes Minat Bakat');
			$this->email->to($email1,$email2,$email3,$email4);
			$this->email->subject('Tes Minat Bakat');
			$this->email->message('<p>Halo</p>,
			<p>Sobat Anda "'.$dataemail['name'].'" dengan alamat email '.$dataemail['email'].' telah menyelesaikan Tes Minat Bakat dengan hasil yang bombastis, dia mengajak anda beserta 3 rekan lainnya untuk ikut serta dalam tes berikut ini:<p>
			<p><a href="http://tesminatbakat.dmpgroup.co.id" target="_blank">tesminatbakat.dmpgroup.co.id</a></p>
			<br> 
			<br> 
			<p>Silahkan mencoba dan buktikan hasilnya</p>
			<p>Salam Hangat,</p>
			<br>
			<p>Tim Minat Bakat</p>
			');
			$this->email->send();
			
			echo 'Email Terkirim';
		} else {
			echo 'Email Gagal';
		}
	}
	/* End DISC */
	
}
