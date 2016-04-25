<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Serverstatus extends CI_Controller {
    var $_param;
    public function  __construct() {
        parent::__construct();
        //$_idmenu = 7;
        //$this->dokumen_lib->cek_wewenang_menu($_idmenu);
        $this->dokumen_lib->check_login();
        $this->dokumen_lib->cek_wewenang_menu();
    }

    public function index() {
        $this->lists();
    }
	
    public function lists() {
		
		$data['home'] = base_url().'serverstatus';
		$data['modul'] = 'Management Server Status';
		$data['title'] = 'Server Status';
		$data['subtitle'] = 'Live';
		
		$data["menu"] = $this->dokumen_lib->build_menu();
		$data['content'] = $this->load->view('backend/serverstatus/add', $data, TRUE);
		$data["content"] = $this->load->view("backend/v_beranda", $data);
	       
    }
    
    public function json(){
		$html = file_get_contents("http://brantas-abipraya.co.id/server-status");
		preg_match_all("#<dt.*?>([^<]+)</dt>#", $html, $item);
		$stat = explode(",",$item[1][6]);
		$ctime = explode(",",$item[1][2]);
		$times = explode(" ",$ctime[1]);
		//$time = date("H:i:s",strtotime($times[2]));
		//$times = time() * 1000;
		$time = strtotime($times[1].' '.$times[2]) * 1000;
		//die($time);
		$request = preg_replace("/[^0-9]/","",$stat[0]);
		$idle = preg_replace("/[^0-9]/","",$stat[1]);
		$ret[] = array($time, intval($request));
		$ret[] = array($time, intval($idle));
		echo json_encode($ret);
			
	}
    
}
