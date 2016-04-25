<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_step extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_step");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_step->getAll();
        $data['home'] = base_url().'master_step';
        $data['modul'] = 'Management Step';
        $data['title'] = 'List Step';
        $data['subtitle'] = 'Step';
        $data['link_add'] = 'master_step/add/';
        $data['link_edit'] = 'master_step/edit/';
        $data['link_delete'] = 'master_step/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_step/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_step';
		$data['modul'] = 'Management Step';
        $data["title"] = "List Step";
        $data["subtitle"] = "Add Step";
        $data['act'] = 'master_step/add_act';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_step/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_step->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_step';
        $data['modul'] = 'Management step';
        $data["title"] = "List step";
        $data["subtitle"] = "Edit step";
		$data['act'] = 'master_step/edit_act/'.$id;
        $data["data"] = array(
            "step_name" => $hasil['step_name'],
            "step_desc" => $hasil['step_desc']
        );
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_step/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_step->delete($id);

        redirect('master_step', 'refresh');
    }

    public function add_act() {
		$step_name = $this->input->post('step_name', TRUE);
        $step_desc = $this->input->post('step_desc', TRUE);
        
        $data = array(
            'step_name' => trim($step_name),
            'step_desc' => trim($step_desc)
        );
        
        $this->m_master_step->insert($data);

        redirect('master_step', 'refresh');
    }

    public function edit_act($id) {
        $step_name = $this->input->post('step_name', TRUE);
        $step_desc = $this->input->post('step_desc', TRUE);
        
        $data = array(
            'step_name' => trim($step_name),
            'step_desc' => trim($step_desc)
        );

        $result = $this->m_master_step->update(array("step_id" => $id), $data);
        
        redirect('master_step', 'refresh');
    }
    
}
