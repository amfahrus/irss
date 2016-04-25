<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index() {
        $data = false;
        //redirect("beranda","refresh");
        if ($this->session->userdata("admin_id")) {
            $data["title"] = "Welcome";
			$this->load->model('m_account_pending');
			$data["isPending"] = $this->m_account_pending->getCountPending();
            $data["content"] = $this->load->view("backend/home/v_home", $data, TRUE);
            $data["menu"] = $this->dokumen_lib->build_menu();
            $this->load->view("backend/v_home", $data);
            
        } else {
            $data["title"] = "Login";
            $data["content"] = $this->load->view('backend/v_login', '', true);
            $this->load->view('backend/v_template', $data);
        }
    }

    public function passwd($id) {
        $this->dokumen_lib->check_admin_login();
        $this->load->model("m_users");
        $data["title"] = "Change Password Admin";
        $data['modul'] = 'Management User Admin';
        $data['act'] = 'admin/passwd/' . $id;
        if ($this->input->post('password')) {
            $password = $this->input->post('password');
            $data = array(
                "password" => $this->dokumen_lib->get_password($password)
            );
            $this->m_users->updateUsers(array("user_id" => $id), $data);
            //echo "<script>alert('Password berhasil diganti!')</script>";
            redirect("admin");
        }
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/users/passwd', $data, TRUE);
        $this->load->view('backend/v_beranda', $data);
    }

    public function detailuser($id = 0) {
        $this->dokumen_lib->check_admin_login();
        $this->load->model("m_users");
        $data['sql'] = $this->m_users->getUser($id);
        $data['modul'] = 'Management User Admin';
        $data['title'] = 'Profile User Admin';
        $data["menu"] = $this->dokumen_lib->build_menu();
        $data['content'] = $this->load->view('backend/users/detail', $data, TRUE);
        $data["content"] = $this->load->view("backend/v_beranda", $data);
    }

    public function eula($id) {
        $this->dokumen_lib->check_login();
        $this->load->model("m_users");

        if ($this->input->post('submit')) {
            $nama = $this->input->post('nama');
            $password = $this->input->post('password');
            $data = array(
                "eula" => 1
            );
            $this->m_users->updateUsers(array("user_id" => $id), $data);
            $this->session->set_userdata('eula', '1');
            redirect("beranda", "refresh");
        }
        $sql = $this->m_users->getEula();
        $data['uid'] = $id;
        $data['eula'] = FALSE;
        if ($sql->num_rows() > 0) {
            foreach ($sql->result() as $row) {
                $data['eula'] = $row->contents;
            }
        }
        $data["content"] = $this->load->view("v_eula", $data);
    }
    
	
	public function input_serial() {
		$ser1 = $this->dokumen_lib->serial();
		$ser2 = $this->dokumen_lib->get_serial();
		if ($ser1 != $ser2) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('serial', 'serial', 'required|callback_check_serial');
			
			if ($this->form_validation->run() == true) {

				$fields["contents"] = $this->input->post("serial");
				$this->db->where('label','serial');
				$this->db->update('config', $fields);
	//            if($exec) {
				$this->session->set_flashdata('pesan_sukses', 'Data Berhasil');
				redirect('beranda', 'refresh');
	//            }
	//            else {
	//                $this->session->set_flashdata('pesan_error','Data Gagal');
	//                redirect('beranda/register_user', 'refresh');
	//            }
			} else {

				$data["title"] = "Input Serial Number";
				$data["menu"] = $this->dokumen_lib->build_menu();
				$data["content"] = $this->load->view('backend/v_serial', $data, true);
				$this->load->view('backend/v_beranda', $data);
			}
		} else {
			redirect('beranda', 'refresh');
		}
    }
    
	public function check_serial($serial) {
	
		$sernum = $this->dokumen_lib->serial();

        if ($sernum != $serial) {
            $this->form_validation->set_message('check_serial', "Nomor Serial Tidak Valid!!!");
            return false;
        } else {
            return true;
        }
    }
	
	public function license() {
		$s1 = $this->dokumen_lib->serial();
		$s2 = $this->dokumen_lib->get_serial();
		if ($s1 != $s2) {
			echo '0';
		} else {
			echo '1';
		}
    }

}
