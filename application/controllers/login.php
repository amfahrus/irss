<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function index() {
        redirect("admin","refresh");
    }

    public function cek_login()
    {
		$this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', '|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'alpha_numeric|xss_clean');
        $user = $this->input->post('username',TRUE);
        $password = $this->input->post('password',TRUE);
		
		if ($this->form_validation->run() == true) {
        #convert password ke MD5
        if ($password != "") {
            $password = $this->dokumen_lib->get_password($password);
        }

        $this->load->model('m_users');

        //$array = array('user_id' => $user, 'password' => $password);
        $res = $this->m_users->getUserLogin($user,$password);
        
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row)
            {
            $this->session->set_userdata('admin_id', $row->user_id);
			$this->session->set_userdata('admin_username', $row->username);
            $this->session->set_userdata('admin_name', $row->nama);
            $this->session->set_userdata('admin_desc', $row->keterangan);
            $this->session->set_userdata('group_id', $row->group_id);
            $this->session->set_userdata('group_name', $row->group_name);
            }
        }
        else
        {
            redirect("admin","refresh");
        }
		} 
        redirect("admin","refresh");
		
    }

    public function logout() {
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('admin_username');
        $this->session->unset_userdata("admin_name");
        $this->session->unset_userdata('admin_desc');
        $this->session->unset_userdata('group_id');
        $this->session->unset_userdata('group_name');
        redirect("admin","refresh");
    }
}
