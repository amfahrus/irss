<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disc_api extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //is_userlogged_in();
        $this->load->model('disc_api_model');
    }

	/* DISC */
	function takedisc()
	{
		$param = json_decode(file_get_contents("php://input"), true);
		$email = $param['email'];
		$name = $param['name'];
		$guestid = $this->disc_api_model->recorddisc_start($email,$name);
		$userdata['userdetails'] = array('guestid' =>$guestid);
		$this->session->set_userdata($userdata);
		$examdata = $this->disc_api_model->get_disc_data(4,0);
		echo json_encode($examdata);
	}
	
	function disc($offset = 0)
	{
		$details = $this->disc_api_model->discdetails(4,$offset);
		echo json_encode($details);
	}
	
	function get_user_disc_data($offset = 0)
	{
		$examdata = $this->disc_api_model->get_disc_data(4,$offset);
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
			$this->disc_api_model->save_answer_disc($option, $marks, $userid);
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
			$this->disc_api_model->finish_user_disc($userid);
			$response = $this->disc_api_model->get_disc_results($userid);
		}
		else
		{
			$response['msgs'] = 'relogin';
		}
		echo json_encode($response);
	}
	
	function show_grafik()
	{
		$response = $this->disc_api_model->get_disc_results(79);
		echo json_encode($response);
	}
	
	public function send_email(){
		$session = get_session_details();
		if(isset($session->userdetails) && !empty($session->userdetails))
		{
			$loggeduser = (object)$session->userdetails;
			$userid = $loggeduser->guestid;
			
			$param = json_decode(file_get_contents("php://input"), true);
			$email1 = $param['email1'];
			$email2 = $param['email2'];
			$email3 = $param['email3'];
			$email4 = $param['email4'];
			$msgs = $param['msgs'];	

			$dataemail = $this->disc_api_model->email_result($userid, $msgs);

			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail -t -i';
			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			
			$this->email->from('info@irss.dmpgroup.co.id', 'Tes Karakter');
			$this->email->to($dataemail['email']);
			$this->email->subject('Hasil Tes Karakter Anda : '.$dataemail['type']);
			$this->email->message($dataemail['long_desc']);
			$this->email->send();
			$this->email->clear();
			$this->email->from('info@irss.dmpgroup.co.id', 'Tes Karakter');
			$this->email->to($email1,$email2,$email3,$email4);
			$this->email->subject('Tes Karakteristik Individu');
			$this->email->message('<p>Halo,</p>
			<p>Sobat Anda "'.$dataemail['name'].'" dengan alamat email '.$dataemail['email'].' telah menyelesaikan Tes Karakter dengan hasil yang bombastis, dia mengajak anda beserta 3 rekan lainnya untuk ikut serta dalam tes berikut ini:<p>
			<p><a href="http://teskarakter.dmpgroup.co.id" target="_blank">teskarakter.dmpgroup.co.id</a></p>
			<br> 
			<p>Silahkan mencoba dan buktikan hasilnya</p>
			<p>Salam Hangat,</p>
			<br>
			<p>Tim Karakteristik</p>
			');
			$this->email->send();
			
			echo 'success';
		} else {
			echo 'error';
		}
	}
	
	public function feedback(){
		$param = json_decode(file_get_contents("php://input"), true);
		$name = $param['name'];
		$email = $param['email'];
		$msgs = $param['msgs'];	

		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail -t -i';
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		
		$this->email->from('info@irss.dmpgroup.co.id', 'Tes Karakter');
		$this->email->to('cs@dmpgroup.co.id');
		$this->email->cc('amfahrus@yahoo.co.id','syafriyadimml@yahoo.com');
		$this->email->subject('Feedback : '.$nama);
		$this->email->message('<p>Nama : '.$nama.'</p>'.'<p>Email : '.$email.'</p><p>'.$msgs.'</p>');
		$this->email->send();
		$this->email->clear();
		echo 'success';
		
	}
	/* End DISC */
	
}
