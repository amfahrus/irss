<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        //$_idmenu = 4;
        //$this->dokumen_lib->cek_wewenang_menu($_idmenu);
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_menus");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_menus->getMenusAll();
        $data['home'] = base_url().'menus';
        $data['modul'] = 'Management Menu';
        $data['title'] = 'List Menu';
        $data['subtitle'] = 'Menu';
        $data['link_add'] = 'menus/add/';
        $data['link_edit'] = 'menus/edit/';
        $data['link_delete'] = 'menus/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/menus/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'menus';
		$data['modul'] = 'Management Menu';
        $data["title"] = "List Menu";
        $data["subtitle"] = "Add Menu";
        $data['act'] = 'menus/add_act';
        $data['menus'] = $this->m_menus->getMenusAll();
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/menus/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_menus->getMenusById($id);
        $hasil = $hasil->result();
		$data['home'] = base_url().'menus';
        $data['modul'] = 'Management Menu';
        $data["title"] = "List Menu";
        $data["subtitle"] = "Edit Menu";
		$data['act'] = 'menus/edit_act/'.$id;
        $data["data"] = array(
            "label" => $hasil[0]->label,
            "link" => $hasil[0]->link,
            "image" => $hasil[0]->image,
            "urutan" => $hasil[0]->urutan,
            "visible" => $hasil[0]->visible,
            "parent" => $hasil[0]->parent
        );
		$data['menus'] = $this->m_menus->getMenusAll();
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/menus/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_menus->deleteMenus($id);

        redirect('menus', 'refresh');
    }

    public function add_act() {
        $label = $this->input->post('label', TRUE);
        $link = $this->input->post('link', TRUE);
        $urutan = $this->input->post('urutan', TRUE);
        $visible = $this->input->post('visible', TRUE);
        $image = $this->input->post('image', TRUE);
        $parent = $this->input->post('parent', TRUE);

        $result = $this->m_menus->getMenusByName($label);

        if ($result->num_rows() > 0) {
            echo "<script>alert('Menu sudah ada')</script>";
            exit();
        }

        $data = array(
            'label' => $label,
            'link' => $link,
            'urutan' => $urutan,
            'visible' => $visible,
            'image' => $image,
            'parent' => $parent
        );
        
        $this->m_menus->insertMenus($data);

        redirect('menus', 'refresh');
    }

    public function edit_act($id) {
       $label = $this->input->post('label', TRUE);
        $link = $this->input->post('link', TRUE);
        $urutan = $this->input->post('urutan', TRUE);
        $visible = $this->input->post('visible', TRUE);
        $image = $this->input->post('image', TRUE);
        $parent = $this->input->post('parent', TRUE);
		   $data = array(
            'label' => $label,
            'link' => $link,
            'urutan' => $urutan,
            'visible' => $visible,
            'image' => $image,
            'parent' => $parent
        );

        $result = $this->m_menus->updateMenus(array("menu_id" => $id), $data);
        redirect('menus', 'refresh');
    }
    
}
