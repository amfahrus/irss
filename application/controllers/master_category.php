<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_category extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_category");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_master_category->getAll();
        $data['home'] = base_url().'master_category';
        $data['modul'] = 'Management Category';
        $data['title'] = 'List Category';
        $data['subtitle'] = 'Category';
        $data['link_add'] = 'master_category/add/';
        $data['link_edit'] = 'master_category/edit/';
        $data['link_delete'] = 'master_category/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_category/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'master_category';
		$data['modul'] = 'Management Category';
        $data["title"] = "List Category";
        $data["subtitle"] = "Add Category";
        $data['act'] = 'master_category/add_act';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/master_category/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_master_category->getById($id);
        $hasil = $hasil->row_array();
		$data['home'] = base_url().'master_category';
        $data['modul'] = 'Management Category';
        $data["title"] = "List Category";
        $data["subtitle"] = "Edit Category";
		$data['act'] = 'master_category/edit_act/'.$id;
        $data["data"] = array(
            "category_name" => $hasil['category_name'],
            "category_month_experience" => $hasil['category_month_experience']
        );
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/master_category/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_master_category->delete($id);

        redirect('master_category', 'refresh');
    }

    public function add_act() {
		$category_name = $this->input->post('category_name', TRUE);
        $category_month_experience = $this->input->post('category_month_experience', TRUE);
        
        $data = array(
            'category_name' => trim($category_name),
            'category_month_experience' => trim($category_month_experience)
        );
        
        $this->m_master_category->insert($data);

        redirect('master_category', 'refresh');
    }

    public function edit_act($id) {
        $category_name = $this->input->post('category_name', TRUE);
        $category_month_experience = $this->input->post('category_month_experience', TRUE);
        
        $data = array(
            'category_name' => trim($category_name),
            'category_month_experience' => trim($category_month_experience)
        );

        $result = $this->m_master_category->update(array("category_id" => $id), $data);
        
        redirect('master_category', 'refresh');
    }
    
}
