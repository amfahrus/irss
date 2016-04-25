<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_pending extends CI_Controller {
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_account_pending");
    }

    public function index() {
        $this->lists();
    }
	
    public function lists() {

		$data['home'] = base_url().'account_pending';
		$data['modul'] = 'Management Account Pending';
		$data['title'] = 'List Account Pending';
		$data['subtitle'] = 'Account Pending';
		$data['listener'] = 'account_pending/listener';
		
		$data["menu"] = $this->dokumen_lib->build_menu();
		$data['content'] = $this->load->view('backend/account_pending/list', $data, TRUE);
		$data["content"] = $this->load->view("backend/v_home", $data);
	       
    }
    
    public function listener() {
			// variable initialization
			$search = "";
			$start = 10;
			$rows = 0;
			$where = array();
			
			// get search value (if any)
			if ($this->input->post('sSearch') != "" ) 
			{
				//$search = $this->input->post('sSearch');
				$where["LOWER(a.company_account_name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
			}
			
			// limit
			$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
			$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

			// sort
			$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

			// run query to get user listing
			$cols = array(  "a.company_account_name", "a.company_account_username", "a.company_account_email", "sum_company", "a.company_account_is_enable", "a.company_account_id");
			$sumcols = 6;
			$sql = $this->m_account_pending->Listener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
			$iFilteredTotal = $sql->num_rows();

			$iTotal = $this->m_account_pending->RowsAll($where)->num_rows();

				/*
				 * Output
				 */
				 $output = array(
					 "sEcho" => intval($this->input->post('sEcho')),
					 "iTotalRecords" => $iFilteredTotal,
					 "iTotalDisplayRecords" => $iTotal,
					 "aaData" => array()
				 );

				// get result after running query and put it in array
				foreach ($sql->result_array() as $row) {
				$record = array();
				$record[] = $row['company_account_name'];
				$record[] = $row['company_account_username'];
				$record[] = $row['company_account_email'];
				$record[] = $row['sum_company'];
				$record[] = $row['company_account_is_enable'] > 0 ? 'Enable' : 'Disable' ;
				$record[] = $row['company_account_is_enable'] > 0 ?
							'<a class="btn btn-danger" href="javascript:void(0)" onclick="disable('.$row['company_account_id'].')">
								<i class="icon-remove icon-white"></i> 
									Disable
							</a>' :
							'<a class="action btn btn-success" href="javascript:void(0)" onclick="enable('.$row['company_account_id'].')">
								<i class="icon-ok icon-white"></i> 
									Enable
							</a>';

				$output['aaData'][] = $record;
			}
			// format it to JSON, this output will be displayed in datatable
			echo json_encode($output);
	}

    public function disable($ca_id){
		$data = array(
                "company_account_is_enable" => 0
            );
        $this->m_account_pending->update(array("company_account_id" => $ca_id),$data);
	}
	
	public function enable($ca_id){
		$data = array(
                "company_account_is_enable" => 1
            );
        $this->m_account_pending->update(array("company_account_id" => $ca_id),$data);
	}
}
