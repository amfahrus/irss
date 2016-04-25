<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_industry extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_industry");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_industry->getAll();
        $data['home'] = base_url().'master_industry';
        $data['modul'] = 'Management Industry';
        $data['title'] = 'List Industry';
        $data['subtitle'] = 'Industry';
        $data['link_add'] = 'master_industry/add/';
        $data['link_edit'] = 'master_industry/edit/';
        $data['link_delete'] = 'master_industry/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_industry/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_industry';
		$data['modul'] = 'Management Industry';
        $data["title"] = "List Industry";
        $data["subtitle"] = "Add Industry";
        $data['act'] = 'master_industry/add_act';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_industry/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_industry->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_industry';
        $data['modul'] = 'Management Industry';
        $data["title"] = "List Industry";
        $data["subtitle"] = "Edit Industry";
		$data['act'] = 'master_industry/edit_act/'.$id;
        $data["data"] = array(
            "industry_name" => $hasil['industry_name']
        );
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_industry/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_industry->delete($id);

        redirect('master_industry', 'refresh');
    }

    public function add_act() {
		$industry_name = $this->input->post('industry_name', TRUE);
        
        $data = array(
            'industry_name' => trim($industry_name)
        );
        
        $this->m_master_industry->insert($data);

        redirect('master_industry', 'refresh');
    }

    public function edit_act($id) {
        $industry_name = $this->input->post('industry_name', TRUE);
        
        $data = array(
            'industry_name' => trim($industry_name)
        );

        $result = $this->m_master_industry->update(array("industry_id" => $id), $data);
        
        redirect('master_industry', 'refresh');
    }
    
}
