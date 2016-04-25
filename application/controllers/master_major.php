<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_major extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_major");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_major->getAll();
        $data['home'] = base_url().'master_major';
        $data['modul'] = 'Management Major';
        $data['title'] = 'List Major';
        $data['subtitle'] = 'Major';
        $data['link_add'] = 'master_major/add/';
        $data['link_edit'] = 'master_major/edit/';
        $data['link_delete'] = 'master_major/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_major/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_major';
		$data['modul'] = 'Management Major';
        $data["title"] = "List Major";
        $data["subtitle"] = "Add Major";
        $data['act'] = 'master_major/add_act';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_major/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_major->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_major';
        $data['modul'] = 'Management Major';
        $data["title"] = "List Major";
        $data["subtitle"] = "Edit Major";
		$data['act'] = 'master_major/edit_act/'.$id;
        $data["data"] = array(
            "major_name" => $hasil['major_name']
        );
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_major/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_major->delete($id);

        redirect('master_major', 'refresh');
    }

    public function add_act() {
		$major_name = $this->input->post('major_name', TRUE);
        
        $data = array(
            'major_name' => trim($major_name)
        );
        
        $this->m_master_major->insert($data);

        redirect('master_major', 'refresh');
    }

    public function edit_act($id) {
        $major_name = $this->input->post('major_name', TRUE);
        
        $data = array(
            'major_name' => trim($major_name)
        );

        $result = $this->m_master_major->update(array("major_id" => $id), $data);
        
        redirect('master_major', 'refresh');
    }
    
}
