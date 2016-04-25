<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_jobfunction extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_jobfunction");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_jobfunction->getAll();
        $data['home'] = base_url().'master_jobfunction';
        $data['modul'] = 'Management Job Fucntion';
        $data['title'] = 'List Job Function';
        $data['subtitle'] = 'Job Function';
        $data['link_add'] = 'master_jobfunction/add/';
        $data['link_edit'] = 'master_jobfunction/edit/';
        $data['link_delete'] = 'master_jobfunction/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_jobfunction/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_jobfunction';
		$data['modul'] = 'Management jobfunction';
        $data["title"] = "List Job Fucntion";
        $data["subtitle"] = "Add Job Function";
        $data['act'] = 'master_jobfunction/add_act';
        $data['sql'] = $this->m_master_jobfunction->getAll();
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_jobfunction/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_jobfunction->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_jobfunction';
        $data['modul'] = 'Management Job Function';
        $data["title"] = "List Job Function";
        $data["subtitle"] = "Edit Job Function";
		$data['act'] = 'master_jobfunction/edit_act/'.$id;
        $data["data"] = array(
            "jf_name" => $hasil['jf_name'],
            "jf_parent" => $hasil['jf_parent']
        );
        $data['sql'] = $this->m_master_jobfunction->getAll();
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_jobfunction/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_jobfunction->delete($id);

        redirect('master_jobfunction', 'refresh');
    }

    public function add_act() {
		$jf_name = $this->input->post('jf_name', TRUE);
        $jf_parent = $this->input->post('jf_parent', TRUE);
        
        $data = array(
            'jf_name' => trim($jf_name),
            'jf_parent' => trim($jf_parent)
        );
        
        $this->m_master_jobfunction->insert($data);

        redirect('master_jobfunction', 'refresh');
    }

    public function edit_act($id) {
        $jf_name = $this->input->post('jf_name', TRUE);
        $jf_parent = $this->input->post('jf_parent', TRUE);
        
        $data = array(
            'jf_name' => trim($jf_name),
            'jf_parent' => trim($jf_parent)
        );

        $result = $this->m_master_jobfunction->update(array("jf_id" => $id), $data);
        
        redirect('master_jobfunction', 'refresh');
    }
    
}
