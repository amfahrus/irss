<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akses extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        //$_idmenu = 5;
        //$this->dokumen_lib->cek_wewenang_menu($_idmenu);
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_akses");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
		$data['home'] = base_url().'akses';
		$data['modul'] = 'Management Akses Menu';
        $data["title"] = "List Akses Menu";
        $data["subtitle"] = "Akses Menu";
        $data['act'] = 'akses/add_act';
		$data['groups'] = $this->m_akses->getGroupsAll();
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/akses/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function add_act() {
        $group = $this->input->post('group', TRUE);
        $menu = $this->input->post('menu', TRUE);
        $enable = $this->input->post('enable', TRUE);
		$i = 0;
		foreach ($menu as $row)
			{
				$data[$i]['group_id']=$group;
				$data[$i]['menu_id']=$row;
				$data[$i]['enable']='1';
				$i++;
			}
			
		$this->m_akses->deleteAkses($group);
        $this->m_akses->insertAkses($data);

        redirect('akses', 'refresh');
    }
    
     public function menu($id=0) {
	   $data['group'] = $id;
       $this->load->view('backend/akses/menu',$data);
    }
}
