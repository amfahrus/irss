<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_grade extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_grade");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_grade->getAll();
        $data['home'] = base_url().'master_grade';
        $data['modul'] = 'Management Grade';
        $data['title'] = 'List Grade';
        $data['subtitle'] = 'Grade';
        $data['link_add'] = 'master_grade/add/';
        $data['link_edit'] = 'master_grade/edit/';
        $data['link_delete'] = 'master_grade/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_grade/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_grade';
		$data['modul'] = 'Management Grade';
        $data["title"] = "List Grade";
        $data["subtitle"] = "Add Grade";
        $data['act'] = 'master_grade/add_act';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_grade/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_grade->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_grade';
        $data['modul'] = 'Management Grade';
        $data["title"] = "List Grade";
        $data["subtitle"] = "Edit Grade";
		$data['act'] = 'master_grade/edit_act/'.$id;
        $data["data"] = array(
            "grade_name" => $hasil['grade_name'],
            "grade_order" => $hasil['grade_order']
        );
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_grade/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_grade->delete($id);

        redirect('master_grade', 'refresh');
    }

    public function add_act() {
		$grade_name = $this->input->post('grade_name', TRUE);
        $grade_order = $this->input->post('grade_order', TRUE);
        
        $data = array(
            'grade_name' => trim($grade_name),
            'grade_order' => trim($grade_order)
        );
        
        $this->m_master_grade->insert($data);

        redirect('master_grade', 'refresh');
    }

    public function edit_act($id) {
        $grade_name = $this->input->post('grade_name', TRUE);
        $grade_order = $this->input->post('grade_order', TRUE);
        
        $data = array(
            'grade_name' => trim($grade_name),
            'grade_order' => trim($grade_order)
        );

        $result = $this->m_master_grade->update(array("grade_id" => $id), $data);
        
        redirect('master_grade', 'refresh');
    }
    
}
