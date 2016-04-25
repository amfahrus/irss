<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }
    function index()
    {
		$data = array();
		$this->load->view('admin/login', $data);
    }

    function login()
    {
        $data = array();
        if(isset($_POST['loginbttn']))
        {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = FALSE;
            }
            else
            {
                $username = $this->input->post('username');
                $password = $this->get_password($this->input->post('password'));
                if($this->admin_model->login($username, $password))
                {
                    redirect(base_url().'administrator');
                }
                else
                {
                    $data['error'] = 'Wrong Username/password combination, please try again !';
                }
            }
        }
        $this->load->view('admin/login', $data);
    }
    
    function token($key)
	{
		$data = array();
		if(isset($key))
		{
				if($this->admin_model->logintoken(base64_decode(rawurldecode(($key)))))
				{
					redirect(base_url().'administrator');
				}
				else
				{
					$data['error'] = 'Wrong Username/password combination, please try again !';
				}
		}
		$this->load->view('admin/login', $data);
	}
	
    function logout()
    {
        $this->session->unset_userdata('admindetails');
        //$this->index();
        redirect(substr_replace(base_url(), '', -5, -1));
    }
    
    function get_password($password) {
        $pass = sha1($password.$this->config->item('encryption_key'));
        $res = $this->db->query("SELECT ('$pass') AS pass");
        $res = $res->row();
        return $res->pass;
    }
}
