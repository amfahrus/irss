<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_city extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_city");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_city->getAll();
        $data['home'] = base_url().'master_city';
        $data['modul'] = 'Management City';
        $data['title'] = 'List City';
        $data['subtitle'] = 'City';
        $data['link_add'] = 'master_city/add/';
        $data['link_edit'] = 'master_city/edit/';
        $data['link_delete'] = 'master_city/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_city/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_city';
		$data['modul'] = 'Management city';
        $data["title"] = "List city";
        $data["subtitle"] = "Add city";
        $data['act'] = 'master_city/add_act';
        $data['sql'] = $this->m_master_city->getAll();
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_city/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_city->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_city';
        $data['modul'] = 'Management City';
        $data["title"] = "List City";
        $data["subtitle"] = "Edit City";
		$data['act'] = 'master_city/edit_act/'.$id;
        $data["data"] = array(
            "city_name" => $hasil['city_name'],
            "parent" => $hasil['parent']
        );
        $data['sql'] = $this->m_master_city->getAll();
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_city/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_city->delete($id);

        redirect('master_city', 'refresh');
    }

    public function add_act() {
		$city_name = $this->input->post('city_name', TRUE);
        $parent = $this->input->post('parent', TRUE);
        
        $data = array(
            'city_name' => trim($city_name),
            'parent' => trim($parent)
        );
        
        $this->m_master_city->insert($data);

        redirect('master_city', 'refresh');
    }

    public function edit_act($id) {
        $city_name = $this->input->post('city_name', TRUE);
        $parent = $this->input->post('parent', TRUE);
        
        $data = array(
            'city_name' => trim($city_name),
            'parent' => trim($parent)
        );

        $result = $this->m_master_city->update(array("city_id" => $id), $data);
        
        redirect('master_city', 'refresh');
    }
    
}
