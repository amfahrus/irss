<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_master_jobs extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jb_job';
        $this->CI = get_instance();
    }
    
    function Listener($start, $rows, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by('a.job_name','asc');
		}	
        
        $this->db->select("a.*,b.company_name,(case when 
							a.job_post_date <= '".date("Y-m-d h:i:s",strtotime("now"))."'
							and a.job_due_date >= '".date("Y-m-d h:i:s",strtotime("now"))."'
							then 'Active' else 'Expire' end) as status");
        $this->db->from($this->_table.' a');
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
        $this->db->limit($start, $rows);
		return $this->db->get();
    }
    
    function RowsAll($search) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        $this->db->select('a.job_id');
        $this->db->from($this->_table.' a');
		return $this->db->get();
    }
	
}
?>
