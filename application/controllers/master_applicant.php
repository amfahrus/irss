<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_applicant extends CI_Controller {
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_applicant");
    }

    public function index() {
        $this->lists();
    }
	
    public function lists() {

		$data['home'] = base_url().'master_applicant';
		$data['modul'] = 'Management Job Seeker';
		$data['title'] = 'List Job Seeker';
		$data['subtitle'] = 'Job Seeker';
		$data['listener'] = 'master_applicant/listener';
		
		$data["menu"] = $this->dokumen_lib->build_menu();
		$data['content'] = $this->load->view('backend/master_applicant/list', $data, TRUE);
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
				$where["LOWER(a.name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
			}
			
			// limit
			$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
			$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

			// sort
			$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

			// run query to get user listing
			$cols = array(  "a.name", "a.email", "a.phone", "a.gender");
			$sumcols = 5;
			$sql = $this->m_master_applicant->Listener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
			$iFilteredTotal = $sql->num_rows();

			$iTotal = $this->m_master_applicant->RowsAll($where)->num_rows();

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
				$record[] = $row['name'];
				$record[] = $row['email'];
				$record[] = $row['phone'];
				$record[] = $row['gender'];

				$output['aaData'][] = $record;
			}
			// format it to JSON, this output will be displayed in datatable
			echo json_encode($output);
	}

function activate(){
	$this->m_master_applicant->activate();
}

}
