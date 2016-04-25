<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_term extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_term");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_term->getAll();
        $data['home'] = base_url().'master_term';
        $data['modul'] = 'Management Term';
        $data['title'] = 'List Term';
        $data['subtitle'] = 'Term';
        $data['link_add'] = 'master_term/add/';
        $data['link_edit'] = 'master_term/edit/';
        $data['link_delete'] = 'master_term/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_term/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_term';
		$data['modul'] = 'Management Term';
        $data["title"] = "List term";
        $data["subtitle"] = "Add Term";
        $data['act'] = 'master_term/add_act';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_term/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_term->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_term';
        $data['modul'] = 'Management Term';
        $data["title"] = "List Term";
        $data["subtitle"] = "Edit Term";
		$data['act'] = 'master_term/edit_act/'.$id;
        $data["data"] = array(
            "term_name" => $hasil['term_name']
        );
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_term/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_term->delete($id);

        redirect('master_term', 'refresh');
    }

    public function add_act() {
		$term_name = $this->input->post('term_name', TRUE);
        
        $data = array(
            'term_name' => trim($term_name)
        );
        
        $this->m_master_term->insert($data);

        redirect('master_term', 'refresh');
    }

    public function edit_act($id) {
        $term_name = $this->input->post('term_name', TRUE);
        
        $data = array(
            'term_name' => trim($term_name)
        );

        $result = $this->m_master_term->update(array("term_id" => $id), $data);
        
        redirect('master_term', 'refresh');
    }
    
}
