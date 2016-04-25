<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_chart extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->_table = 'pelamar';
        $this->CI = get_instance();
    }
    
    public function getDataLine($year){
		$this->db->select("count(pid) as sum, date_part('month', create_time) as times, lowongan_id",FALSE);
		$this->db->from($this->_table);
		$this->db->where("date_part('year', create_time) = ",$year);
		$this->db->group_by(array("times", "lowongan_id"));
		$this->db->order_by("lowongan_id asc, times asc");
		$sql = $this->db->get();
		$res = array();
		if ($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				/*$res[$row['lowongan_id']]['name'] = $this->getlowongan($row['lowongan_id']);
				$res[$row['lowongan_id']]['data'][(int)$row['times']] = (int)$row['sum'];*/
				for($i=0;$i<12;$i++){
					if(intval($row['times']) == intval($i)){
						$res[$this->getlowongan($row['lowongan_id'])][$row['times']] = round($row['sum'],2);
					} 
					if(!isset($res[$this->getlowongan($row['lowongan_id'])][$i])){
						$res[$this->getlowongan($row['lowongan_id'])][$i] = round(0,2);
					}
				}
			}
		}
		//die(print_r($res));
		return $res;
	}
	
	public function getDataPie($year){
		$this->db->select("count(pid) as sum, date_part('year', create_time) as times, lowongan_id",FALSE);
		$this->db->from($this->_table);
		$this->db->where("date_part('year', create_time) = ",$year);
		$this->db->group_by(array("times", "lowongan_id"));
		$this->db->order_by("lowongan_id asc, times asc");
		$sql = $this->db->get();
		$res = array();
		if ($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$res[$this->getlowongan($row['lowongan_id'])] = round($row['sum'],2);
			}
		}
		//die(print_r($res));
		return $res;
	}
	
	public function getYears(){
		$this->db->select("date_part('year', create_time) as years",FALSE);
		$this->db->from($this->_table);
		$this->db->group_by("years");
		$sql = $this->db->get();
		return $sql;
	}
	
	public function getLowongan($id){
		$this->db->select("nama_lowongan");
		$this->db->from("lowongan");
		$this->db->where("lowongan_id",$id);
		$sql = $this->db->get();
		if ($sql->num_rows() > 0){
			$row = $sql->row_array(); 
			return $row['nama_lowongan'];
		} else {
			return false;
		} 
	}
    
}
?>
