<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
    
    public function  __construct() {
        parent::__construct();
        //$_idmenu = 2;
        //$this->dokumen_lib->cek_wewenang_menu($_idmenu);
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_users");
    }

    public function index() {
        $this->lists();
    }

    public function lists() {
        $data['sql'] = $this->m_users->getUserAll();
        $data['modul'] = 'Management User';
        $data['title'] = 'List User';
        $data['link_add'] = 'users/add/';
        $data['link_edit'] = 'users/edit/';
        $data['link_delete'] = 'users/delete/';
        $data['link_detail'] = 'users/detail/';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/users/list', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function detail($id=0) {
        $data['sql'] = $this->m_users->getUser($id);
        $data['modul'] = 'Management User';
        $data['title'] = 'Profile User';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/users/detail', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }
    
    public function add() {
        $data["title"] = "Add User";
        $data['modul'] = 'Management User';
        $data['act'] = 'users/add_act';
        $data["group"] = $this->m_users->getGroup();
        
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data["content"] = $this->load->view("backend/users/add", $data, true);
        $data["content"] = $this->load->view("backend/v_home", $data);
    }

    public function edit($id) {
        $hasil = $this->m_users->getUsersById($id);
        $hasil = $hasil->result();

        $data["title"] = "Edit User";
        $data['modul'] = 'Management User';
		$data['act'] = 'users/edit_act/'.$id;
        $data["data"] = array(
            "user_id" => $id,
            "username" => $hasil[0]->username,
            "nama" => $hasil[0]->nama,
            "password" => "",
            "keterangan" => $hasil[0]->keterangan,
            "group_id" => $hasil[0]->group_id
        );

        $data["group"] = $this->m_users->getGroup();

        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/users/add', $data, TRUE);
        $this->load->view('backend/v_home', $data);
    }

    public function delete($id)
    {
        $this->m_users->deleteUsers($id);

        redirect('users', 'refresh');
    }

    public function add_act() {
        $user = $this->input->post('username', TRUE);
        $nama = $this->input->post('nama', TRUE);
        $password = $this->input->post('password', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $group = $this->input->post('group', TRUE);

        $result = $this->m_users->getUsersByUname($user);

        if ($result->num_rows() > 0) {
            echo "<script>alert('User sudah ada')</script>";
            exit();
        }

        $data = array(
            'username' => trim($user),
            'nama' => trim($nama),
            'keterangan' => trim($keterangan),
            'password' => $this->dokumen_lib->get_password(trim($password)),
            'group_id' => $group
        );
        
        $this->m_users->insertUsers($data);

        redirect('users', 'refresh');
    }

    public function edit_act($id) {
        $user = $id;
        $nama = $this->input->post('nama', TRUE);
        $password = $this->input->post('password', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);
        $group = $this->input->post('group', TRUE);

       $data = array(
            'user_id' => trim($user),
            'nama' => trim($nama),
            'keterangan' => trim($keterangan),
            'group_id' => $group
        );

        $result = $this->m_users->updateUsers(array("user_id" => $user), $data);
        redirect('users', 'refresh');
    }
    
    public function reset_passwd($id) {
        $password = '1234567';    
        $data = array(
            "password" => $this->dokumen_lib->get_password($password)
        );
        $this->m_users->updateUsers(array("user_id" => $id), $data);
    }
}
