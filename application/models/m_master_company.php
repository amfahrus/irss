<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_master_company extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jb_company';
        $this->CI = get_instance();
    }
    
    function Listener($start, $rows, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by('a.company_name','asc');
		}	
        
        $this->db->select("a.*, 
        (select count(b.job_id) from jb_job b where a.company_id = b.company_id and 
        b.job_post_date <= '".date("Y-m-d h:i:s",strtotime("now"))."' and 
        b.job_due_date >= '".date("Y-m-d h:i:s",strtotime("now"))."') as sum_jobs_active,
        (select count(b.job_id) from jb_job b where a.company_id = b.company_id and 
        b.job_post_date <= '".date("Y-m-d h:i:s",strtotime("now"))."' and 
        b.job_due_date < '".date("Y-m-d h:i:s",strtotime("now"))."') as sum_jobs_expire");
        $this->db->from($this->_table.' a');
        $this->db->limit($start, $rows);
		return $this->db->get();
    }
    
    function RowsAll($search) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
        
        $this->db->select('a.company_id');
        $this->db->from($this->_table.' a');
		return $this->db->get();
    }
	
}
?>
