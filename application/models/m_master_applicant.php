<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_master_applicant extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jb_person';
        $this->CI = get_instance();
    }
    
    function Listener($start, $rows, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by('a.name','asc');
		}	
        
        $this->db->select("a.*");
        $this->db->from($this->_table.' a');
$this->db->where("a.is_active",0);
        $this->db->limit($start, $rows);
		return $this->db->get();
    }
    
    function RowsAll($search) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        $this->db->select('a.user_id');
$this->db->where("a.is_active",0);
        $this->db->from($this->_table.' a');
		return $this->db->get();
    }

function activate(){
	$data = array('is_active' => 1);
	$this->db->update($this->_table,$data);
	}
}
