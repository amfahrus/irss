<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        //$_idmenu = 3;
        //$this->dokumen_lib->cek_wewenang_menu($_idmenu);
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_groups");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_groups->getGroupsAll();
        $data['home'] = base_url().'groups';
        $data['modul'] = 'Management Group User';
        $data['title'] = 'List Group User';
        $data['subtitle'] = 'Group User';
        $data['link_add'] = 'groups/add/';
        $data['link_edit'] = 'groups/edit/';
        $data['link_delete'] = 'groups/delete/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/groups/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
		$data['home'] = base_url().'groups';
		$data['modul'] = 'Management Groups User';
        $data["title"] = "List Group User";
        $data["subtitle"] = "Add Group User";
        $data['act'] = 'groups/add_act';
        
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/groups/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_groups->getGroupsById($id);
        $hasil = $hasil->result();
		$data['home'] = base_url().'groups';
        $data['modul'] = 'Management Group User';
        $data["title"] = "List Group User";
        $data["subtitle"] = "Edit Group User";
		$data['act'] = 'groups/edit_act/'.$id;
        $data["data"] = array(
            "group_name" => $hasil[0]->group_name
        );

        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/groups/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_groups->deleteGroups($id);

        redirect('groups', 'refresh');
    }

    public function add_act() {
        $group_name = $this->input->post('group_name', TRUE);

        $result = $this->m_groups->getGroupsByName($group_name);

        if ($result->num_rows() > 0) {
            echo "<script>alert('Group user sudah ada')</script>";
            exit();
        }

        $data = array(
            'group_name' => trim($group_name)
        );
        
        $this->m_groups->insertGroups($data);

        redirect('groups', 'refresh');
    }

    public function edit_act($id) {
        $group_name = $this->input->post('group_name', TRUE);
		   $data = array(
				'group_name' => trim($group_name)
			);

        $result = $this->m_groups->updateGroups(array("group_id" => $id), $data);
        redirect('groups', 'refresh');
    }
    
}
