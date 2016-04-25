<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart extends CI_Controller {
    var $_param;
    public function  __construct() {
        parent::__construct();
        //$_idmenu = 7;
        //$this->dokumen_lib->cek_wewenang_menu($_idmenu);
        $this->dokumen_lib->check_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_chart");
    }

    public function index() {
        $this->lists();
    }
	
    public function lists() {
			
		$data['thn'] = $this->m_chart->getYears();
		
		$data['home'] = base_url().'chart';
		$data['modul'] = 'Management Grafik Chart';
		$data['title'] = 'Chart Laporan';
		$data['subtitle'] = 'Chart';
		
		$data["menu"] = $this->dokumen_lib->build_menu();
		$data['content'] = $this->load->view('backend/chart/add', $data, TRUE);
		$data["content"] = $this->load->view("backend/v_beranda", $data);
	       
    }
    
    public function linejson($year){
		//$year = $_GET['tahun'];
		$sql = $this->m_chart->getDataLine($year);
		//die(var_dump($sql));
		echo json_encode($sql);
			
	}
	
	public function piejson($year){
		//$year = $_GET['tahun'];
		$sql = $this->m_chart->getDataPie($year);
		//die(var_dump($sql));
		echo json_encode($sql);
			
	}
	
	public function getYears(){
		$thn = $this->m_chart->getYears();
		if ($thn->num_rows() > 0) {
			foreach ($thn->result_array() as $row) {
				echo '<option value="'.$row['years'].'">'.$row['years'].'</option>';
			}
		} else {
			echo '<option value="0">Tidak tersedia</option>';
		}
	}
    
}
