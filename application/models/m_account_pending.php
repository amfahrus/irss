<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_account_pending extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jb_company_account';
        $this->CI = get_instance();
    }
    
    function Listener($start, $rows, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by('a.company_account_name','asc');
		}	
        
        $this->db->select('a.*, (select count(b.company_id) from jb_company b where a.company_account_id = b.company_account_id) as sum_company');
        $this->db->from($this->_table.' a');
        $this->db->limit($start, $rows);
        $this->db->where('a.company_account_is_enable', 0); 
		return $this->db->get();
    }
    
    function RowsAll($search) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        $this->db->select('a.company_account_id');
        $this->db->from($this->_table.' a');
		return $this->db->get();
    }
    
    public function update($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }
	
	public function getCountPending(){
		$this->db->select("count(company_account_id) as sum");
		$this->db->from($this->_table);
        $this->db->where("company_account_is_enable", 0);
        $sql = $this->db->get();
        $res = $sql->row_array();
        if($res['sum'] > 0){
			return $res['sum'];	
		} else {
			return false;
		}
	}
}
?>
