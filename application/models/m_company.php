<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_company extends CI_Model {
	
	function __construct(){
		parent::__construct();
        $this->CI = get_instance();
	}
	
	public function getCompanyLogin($username, $password){
		$this->db->select("company_account_id, company_account_name, company_account_username, company_account_email");
		$this->db->from("jb_company_account");
		$this->db->where("(company_account_username","'".$username."'", false);
		$this->db->or_where("company_account_email","'".$username."')", false);
		$this->db->where("company_account_password",$password);
		$this->db->where("company_account_is_active",1);
		$this->db->where("company_account_is_enable",1);
		return $this->db->get();
	}
	
	public function insertCompanyAccount($data){
		$this->db->insert("jb_company_account", $data);
        return $this->db->insert_id();
	}
	
	public function check_username($username = '') {
		$this->db->select("company_account_username");
        $this->db->from("jb_company_account");
        $this->db->where("company_account_username",$username);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function check_email($email = 0) {
		$this->db->select("company_account_email");
        $this->db->from("jb_company_account");
        $this->db->where("company_account_email",$email);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateCompanyAccount($where, $data) {
        $this->db->where($where);
        $this->db->update("jb_company_account", $data);
        return $this->db->affected_rows();
    }
    
    public function getCompanyAccountById($id){
		$this->db->select("*");
		$this->db->from("jb_company_account");
		$this->db->where("company_account_id",$id);
		return $this->db->get();
	}
    
    public function getMasterGradeAll(){
		$this->db->select("*");
		$this->db->from("jb_master_grade");
		$this->db->order_by("grade_order","desc");
		return $this->db->get();
	}
    
    public function getMasterMajorAll(){
		$this->db->select("*");
		$this->db->from("jb_master_major");
		$this->db->order_by("major_name","asc");
		return $this->db->get();
	}
	
	public function getMasterJobFunctionAll(){
		$this->db->select("*");
		$this->db->from("jb_master_job_function");
		$this->db->order_by("jf_id","asc");
		return $this->db->get();
	}
	
	public function getMasterCategoryAll(){
		$this->db->select("*");
		$this->db->from("jb_master_category");
		$this->db->order_by("category_id","asc");
		return $this->db->get();
	}
	
	public function getMasterTermAll(){
		$this->db->select("*");
		$this->db->from("jb_master_term");
		$this->db->order_by("term_name","asc");
		return $this->db->get();
	}
	
	public function getMasterStepAll(){
		$this->db->select("*");
		$this->db->from("jb_master_step");
		return $this->db->get();
	}
	
	public function getMasterIndustryAll(){
		$this->db->select("*");
		$this->db->from("jb_master_industry");
		$this->db->order_by("industry_name","asc");
		return $this->db->get();
	}
	
	public function getMasterLocationAll(){
		$this->db->select("*");
		$this->db->from("jb_master_city");
		$this->db->where("parent",1);
		$sql = $this->db->get();
		$tmp[] = array(
			'city_id' => 1,
			'city_name' => 'Seluruh Indonesia',
			'child'	=> array()
		);
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = array(
						'city_id' => $row['city_id'],
						'city_name' => $row['city_name'],
						'child'	=> $this->getCityFromParent($row['city_id'])
				);
			}
		}
		return $tmp;
	}
	
	private function getCityFromParent($id){
		$this->db->select("*");
		$this->db->from("jb_master_city");
		$this->db->where("parent",$id);
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[$row['city_id']] = $row['city_name'];
			}
		}
		return $tmp;
	}
	
	public function insertCompany($data){
		$this->db->insert("jb_company", $data);
        return $this->db->insert_id();
	}

	public function deleteCompany($cid){
		$this->db->where("company_id", $cid);
        $this->db->delete("jb_company");
	}

    public function updateCompany($where, $data) {
        $this->db->where($where);
        $this->db->update("jb_company", $data);
        return $this->db->affected_rows();
    }
	    
    public function getCompanyById($id){
		$this->db->select("a.*,b.industry_name");
		$this->db->from("jb_company a");
		$this->db->join("jb_master_industry b","a.industry_id = b.industry_id","LEFT");
		$this->db->where("a.company_id",$id);
		return $this->db->get();
	}
	
	public function getCompanyTotal($id){
		$this->db->select("count(company_id) as total");
		$this->db->from("jb_company");
		$this->db->where("company_account_id",$id);
		return $this->db->get();
	}
	
	public function getCompanyByAcount($id,$limit,$offset){
		$this->db->select("b.*,c.industry_name");
		$this->db->from("jb_company_account a");
		$this->db->join("jb_company b","a.company_account_id = b.company_account_id","LEFT");
		$this->db->join("jb_master_industry c","b.industry_id = c.industry_id","LEFT");
		$this->db->where("a.company_account_id",$id);
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}
	
	public function getCompanyAllByAcount($id){
		$this->db->select("b.*,c.industry_name");
		$this->db->from("jb_company_account a");
		$this->db->join("jb_company b","a.company_account_id = b.company_account_id","LEFT");
		$this->db->join("jb_master_industry c","b.industry_id = c.industry_id","LEFT");
		$this->db->where("a.company_account_id",$id);
		$this->db->order_by("b.company_id","asc");
		return $this->db->get();
	}
	
	public function insertNews($data){
		$this->db->insert("jb_job_news", $data);
        return $this->db->insert_id();
	}

	public function deleteNews($nid){
		$this->db->where("news_id", $nid);
        $this->db->delete("jb_job_news");
	}

    public function updateNews($where, $data) {
        $this->db->where($where);
        $this->db->update("jb_job_news", $data);
        return $this->db->affected_rows();
    }
	    
    public function getNewsById($id){
		$this->db->select("*");
		$this->db->from("jb_job_news");
		$this->db->where("news_id",$id);
		return $this->db->get();
	}
	
	function NewsListener($limit, $offset, $search, $sortcol, $sortdir) {
        if ($search != '') {
           //$this->db->like($search); 
           $this->db->where($search, NULL, false); 
        }
        
        if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by("a.news_id","asc");
		}	
        
        $this->db->select("a.*,b.*");
		$this->db->from("jb_job_news a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->where("b.company_account_id",$this->session->userdata('company_account_id'));
		$this->db->limit($limit, $offset);
		return $this->db->get();
    }
	
	function RowsNews($search) {
        if ($search != '') {
           //$this->db->like('a.nama', $search); 
           $this->db->where($search);
        }
        $this->db->select("a.news_id");
		$this->db->from("jb_job_news a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->where("b.company_account_id",$this->session->userdata('company_account_id'));
		return $this->db->get();
    }
	
	public function insertJob($data){
		$this->db->insert("jb_job", $data);
        return $this->db->insert_id();
	}
	
	public function updateJob($where, $data) {
        $this->db->where($where);
        $this->db->update("jb_job", $data);
        return $this->db->affected_rows();
    }
	
	public function deleteJobMajorByJobId($job_id){
		$this->db->where("job_id", $job_id);
        $this->db->delete("jb_job_major");
	}
    
    public function insertJobMajor($data){
		$this->db->insert_batch("jb_job_major", $data); 
	}
	
	public function deleteJobFunctionByJobId($job_id){
		$this->db->where("job_id", $job_id);
        $this->db->delete("jb_job_function");
	}
    
    public function insertJobFunction($data){
		$this->db->insert_batch("jb_job_function", $data); 
	}
	
	public function deleteJobStepByJobId($job_id){
		$this->db->where("job_id", $job_id);
        $this->db->delete("jb_job_step");
	}
    
    public function deleteJobStepByJsId($js_id){
		$this->db->where("js_id", $js_id);
        $this->db->delete("jb_job_step");
	}
    
    public function insertJobStep($data){
		$this->db->insert_batch("jb_job_step", $data); 
	}
	
	public function getJobById($id){
		$this->db->select("a.*,b.*,c.*,d.*,e.*,f.*,g.industry_name,
							(select count (x.user_id) from jb_job_person x 
							where x.job_id = a.job_id) as sumappl,
							(select count (w.job_id) from jb_job w 
							where w.company_id = b.company_id
							and w.job_post_date <= '".date("Y-m-d h:i:s",strtotime("now"))."'
							and w.job_due_date >= '".date("Y-m-d h:i:s",strtotime("now"))."') as sumjobs,
							(SELECT array_to_string(array(
							select y.major_name
							from jb_master_major y
							left join jb_job_major z on y.major_id = z.major_id
							where a.job_id = z.job_id
							group by y.major_name order by major_name asc), ', ')) as major,
							(SELECT array_to_string(array(
							select m.jf_name
							from jb_master_job_function m
							left join jb_job_function n on m.jf_id = n.jf_id
							where a.job_id = n.job_id
							group by m.jf_name order by m.jf_name asc), ', ')) as job_function",FALSE);
		$this->db->from("jb_job a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->join("jb_master_category c","a.category_id = c.category_id","LEFT");
		$this->db->join("jb_master_term d","a.term_id = d.term_id","LEFT");
		$this->db->join("jb_master_grade e","a.grade_id = e.grade_id","LEFT");
		$this->db->join("jb_master_city f","a.city_id = f.city_id","LEFT");
		$this->db->join("jb_master_industry g","g.industry_id = b.industry_id","LEFT");
		$this->db->where("a.job_id",$id);
		return $this->db->get();		
	}
	
	public function getJobStepByJobId($job_id){
		$this->db->select("b.step_name,a.*");
		$this->db->from("jb_job_step a");
		$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT");
		$this->db->where("a.job_id",$job_id);
		$this->db->order_by("a.js_order","asc");
		return $this->db->get();
	}
	
	public function getJobMajorByJobId($job_id){
		$this->db->select("a.*,b.major_name");
		$this->db->from("jb_job_major a");
		$this->db->join("jb_master_major b","a.major_id = b.major_id","LEFT");
		$this->db->where("a.job_id",$job_id);
		return $this->db->get();
	}
	
	public function getJobFunctionByJobId($job_id){
		$this->db->select("a.*,b.jf_name");
		$this->db->from("jb_job_function a");
		$this->db->join("jb_master_job_function b","a.jf_id = b.jf_id","LEFT");
		$this->db->where("a.job_id",$job_id);
		return $this->db->get();
	}
	
	function AotListener($limit, $offset, $search, $sortcol, $sortdir) {
        if ($search != '') {
           //$this->db->like($search); 
           $this->db->where($search, NULL, false); 
        }
        
        /*if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by("a.examname","asc");
		}*/	
        $this->db->order_by("a.examname","asc");
        
        $this->db->select("a.*,
							(select count (x.user_id) from jb_aot_person x 
							where x.exam_id = a.examid) as sumappl
							",FALSE);
		$this->db->from("exams a");
		$this->db->limit($limit, $offset);
		return $this->db->get();
    }
	
	function RowsAot($search) {
        if ($search != '') {
           //$this->db->like('a.nama', $search); 
           $this->db->where($search);
        }
        $this->db->select("a.examid");
		$this->db->from("exams a");
		return $this->db->get();
    }
	
	function JobListener($limit, $offset, $search, $sortcol, $sortdir) {
        if ($search != '') {
           //$this->db->like($search); 
           $this->db->where($search, NULL, false); 
        }
        
        if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by("a.job_id","asc");
		}	
        
        $this->db->select("a.*,b.*,d.industry_name,
							(select count (x.user_id) from jb_job_person x 
							where x.job_id = a.job_id) as sumappl,
							(case when 
							a.job_post_date <= '".date("Y-m-d h:i:s",strtotime("now"))."'
							and a.job_due_date >= '".date("Y-m-d h:i:s",strtotime("now"))."'
							then 'Active' else 'Expire' end) as job_status
							",FALSE);
		$this->db->from("jb_job a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->join("jb_company_account c","c.company_account_id = b.company_account_id","LEFT");
		$this->db->join("jb_master_industry d","d.industry_id = b.industry_id","LEFT");
		$this->db->where("c.company_account_id",$this->session->userdata('company_account_id'));
		$this->db->limit($limit, $offset);
		return $this->db->get();
    }
	
	function RowsJob($search) {
        if ($search != '') {
           //$this->db->like('a.nama', $search); 
           $this->db->where($search);
        }
        $this->db->select("a.job_id");
		$this->db->from("jb_job a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->join("jb_company_account c","c.company_account_id = b.company_account_id","LEFT");
		$this->db->where("c.company_account_id",$this->session->userdata('company_account_id'));
		return $this->db->get();
    }
	
	function StepListener($limit, $offset, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
           
        if ($sortcol != '') {
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by("a.js_order","asc");
		}	
        
        $this->db->select("c.job_is_external,a.job_id,a.step_id,b.step_name,
							(select count (x.user_id) from jb_step_person x 
							where x.job_id = a.job_id and x.step_id = a.step_id) as sumappl",FALSE);
		$this->db->from("jb_job_step a");
		$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT");
		$this->db->join("jb_job c","a.job_id = c.job_id","LEFT");
		$this->db->limit($limit, $offset);
		$this->db->order_by("a.js_order","asc");
		return $this->db->get();
    }
	
	function RowsStep($search) {
        if ($search != '') {
           //$this->db->like('a.nama', $search); 
           $this->db->where($search);
        }
        $this->db->select("b.step_name",FALSE);
		$this->db->from("jb_job_step a");
		$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT");
		return $this->db->get();
    }
    
    function ApplJobListener($limit, $offset, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
           
        if ($sortcol != '') {
			$this->db->order_by("a.name","asc");
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by("a.name","asc");
		}	
        
        $this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->limit($limit, $offset);
		return $this->db->get();
    }
	
	function RowsApplJob($search) {
        if ($search != '') {
           //$this->db->like('a.nama', $search); 
           $this->db->where($search);
        }
        $this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		return $this->db->get();
    }
	
	function ApplStepListener($limit, $offset, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->where($search, NULL, false); 
        }
           
        if ($sortcol != '') {
			$this->db->order_by("a.name","asc");
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by("a.name","asc");
		}	
        
        $this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_step_person b","a.user_id = b.user_id","LEFT");
		$this->db->limit($limit, $offset);
		return $this->db->get();
    }
	
	function RowsApplStep($search) {
        if ($search != '') {
           //$this->db->like('a.nama', $search); 
           $this->db->where($search);
        }
        $this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_step_person b","a.user_id = b.user_id","LEFT");
		return $this->db->get();
    }
    
    private function getCurrentStep($job_id,$user_id){
		$this->db->select("b.js_order",FALSE);
		$this->db->from("jb_step_person a");
		$this->db->join("jb_job_step b","a.job_id = b.job_id and a.step_id = b.step_id","LEFT");
		$this->db->where("a.job_id",$job_id);
		$this->db->where("a.user_id",$user_id);
		$this->db->order_by("a.sp_id","desc");
		$this->db->limit(1);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$step = $sql->row_array();
			return $step['js_order'];
		} else {
			return FALSE;
		}		
	}
    
    public function getNextStepAppl($job_id,$user_id){
		$js_order = $this->getCurrentStep($job_id,$user_id);
		if($js_order){
			$this->db->select("a.step_id, b.step_name, c.job_name",FALSE);
			$this->db->from("jb_job_step a");
			$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT");
			$this->db->join("jb_job c","a.job_id = c.job_id","LEFT");
			$this->db->where("a.js_order",$js_order+1);
			$this->db->where("a.job_id",$job_id);
			return $this->db->get();
		} else {
			$this->db->select("a.step_id, b.step_name, c.job_name",FALSE);
			$this->db->from("jb_job_step a");
			$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT");
			$this->db->join("jb_job c","a.job_id = c.job_id","LEFT");
			$this->db->where("a.js_order",1);
			$this->db->where("a.job_id",$job_id);
			return $this->db->get();
		}
	}
	
	public function getCurrentStepAppl($job_id,$user_id){
		$js_order = $this->getCurrentStep($job_id,$user_id);
		if($js_order){
			$this->db->select("a.step_id, b.step_name, c.job_name",FALSE);
			$this->db->from("jb_job_step a");
			$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT");
			$this->db->join("jb_job c","a.job_id = c.job_id","LEFT");
			$this->db->where("a.js_order",$js_order);
			$this->db->where("a.job_id",$job_id);
			return $this->db->get();
		} else {
			$this->db->select("a.step_id, b.step_name, c.job_name",FALSE);
			$this->db->from("jb_job_step a");
			$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT");
			$this->db->join("jb_job c","a.job_id = c.job_id","LEFT");
			$this->db->where("a.js_order",0);
			$this->db->where("a.job_id",$job_id);
			return $this->db->get();
		}
	}
    
    public function getStep($where){
		$this->db->select("a.step_name, a.step_id, b.js_order",FALSE);
		$this->db->from("jb_master_step a");
		$this->db->join("jb_job_step b","a.step_id = b.step_id","LEFT");
		$this->db->where($where);
		return $this->db->get();	
	}
    
    public function insertJobStepPerson($data){
		$this->db->insert("jb_step_person", $data);
        return $this->db->insert_id();
    }
	
	public function deleteJobStepPerson($where){
		$this->db->where($where);
        $this->db->delete("jb_step_person");
	}
	
	public function checkJobStepPerson($where){
		$this->db->select("sp_id");
        $this->db->from("jb_step_person");
		$this->db->where($where);
        return $this->db->get();
	}
    
    public function getEmailPersonByStep($where){
		$this->db->select("b.email");
        $this->db->from("jb_step_person a");
        $this->db->join("jb_person b","a.user_id = b.user_id","LEFT");
		$this->db->where($where);
        return $this->db->get();
	}
    
    public function updateJobStep($where, $data) {
        $this->db->where($where);
        $this->db->update("jb_job_step", $data);
        return $this->db->affected_rows();
    }
    
/*
     * BEGIN FILTER BY SYSTEM
     */ 
    
    private function getMinimumEduLevelOrder($job_id){
		$this->db->select("b.grade_order");
		$this->db->from("jb_job a");
		$this->db->join("jb_master_grade b","a.grade_id = b.grade_id","LEFT");
		$this->db->where("a.job_id",$job_id);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
			return $res['grade_order'];
		} else {
			return 0;
		}
	}
	
	private function getSelectedEduMajor($job_id){
		$this->db->select("major_id");
		$this->db->from("jb_job_major");
		$this->db->where("job_id",$job_id);
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = $row['major_id'];
			}
		} 
		return $tmp;
	}
	
	private function getMinimumYearsExperience($job_id){
		$this->db->select("job_years_exp");
		$this->db->from("jb_job");
		$this->db->where("job_id",$job_id);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
			return $res['job_years_exp'] * 12;
		} else {
			return 0;
		}
	}
	
	private function getMinimumAges($job_id){
		$this->db->select("job_age");
		$this->db->from("jb_job");
		$this->db->where("job_id",$job_id);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
			if(!empty($res['job_age'])){
				return $res['job_age'] * 12;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	
	private function getMinimumGPA($job_id){
		$this->db->select("job_score");
		$this->db->from("jb_job");
		$this->db->where("job_id",$job_id);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
			if(!empty($res['job_score'])){
				return $res['job_score'];
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	
	private function getMinimumScale($job_id){
		$this->db->select("job_scale");
		$this->db->from("jb_job");
		$this->db->where("job_id",$job_id);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
			if(!empty($res['job_scale'])){
				return $res['job_scale'];
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	
	private function getPriorityGender($job_id){
		$this->db->select("job_gender");
		$this->db->from("jb_job");
		$this->db->where("job_id",$job_id);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
			if(!empty($res['job_gender'])){
				return array($res['job_gender']);
			} else {
				return array("Male","Female");
			}
		} else {
			return array("Male","Female");
		}
	}
	
	private function QualifiedEduLevel($job_id){
		$EduOrder = $this->getMinimumEduLevelOrder($job_id);
		$this->db->select("DISTINCT ON (b.user_id) b.user_id,c.name,d.edu_years", false);
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->join("jb_person_education d","b.user_id = d.user_id","LEFT");
		$this->db->join("jb_master_grade e","e.grade_id = d.grade_id","LEFT");
		$this->db->where("(e.grade_order >=",$EduOrder,False);
		$this->db->where("e.grade_order IS NOT NULL)", null, false);
		$this->db->where("b.job_id",$job_id);
		$this->db->order_by("b.user_id", "desc"); 
		$this->db->order_by("d.edu_years", "desc"); 
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function UnqualifiedEduLevel($job_id){
		$EduOrder = $this->getMinimumEduLevelOrder($job_id);
		$this->db->select("DISTINCT ON (b.user_id) b.user_id,c.email,d.edu_years",false);
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->join("jb_person_education d","b.user_id = d.user_id","LEFT");
		$this->db->join("jb_master_grade e","e.grade_id = d.grade_id","LEFT");
		$this->db->where("(e.grade_order <",$EduOrder,false);
		$this->db->or_where("e.grade_order IS NULL)", null, false);
		$this->db->where("b.job_id",$job_id);
		$this->db->order_by("b.user_id", "desc"); 
		$this->db->order_by("d.edu_years", "desc"); 
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[$row['email']] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function QualifiedEduMajor($job_id){
		$EduMajor = $this->getSelectedEduMajor($job_id);
		if(count($EduMajor)>0){
			$this->db->where_in("(e.major_id",$EduMajor, false);
			$this->db->where("e.major_id IS NOT NULL)", null, false);
		}
		$this->db->select("DISTINCT ON (b.user_id) b.user_id,c.name,d.edu_years",false);
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->join("jb_person_education d","b.user_id = d.user_id","LEFT");
		$this->db->join("jb_master_major e","e.major_id = d.major_id","LEFT");
		$this->db->where("b.job_id",$job_id);
		$this->db->order_by("b.user_id", "desc"); 
		$this->db->order_by("d.edu_years", "desc"); 
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function UnqualifiedEduMajor($job_id){
		$EduMajor = $this->getSelectedEduMajor($job_id);
		$tmp = array();
		if(count($EduMajor)>0){
			$this->db->select("DISTINCT ON (b.user_id) b.user_id,c.email,d.edu_years",false);
			$this->db->from("jb_job a");
			$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
			$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
			$this->db->join("jb_person_education d","b.user_id = d.user_id","LEFT");
			$this->db->join("jb_master_major e","e.major_id = d.major_id","LEFT");
			$this->db->where_not_in("(e.major_id",$EduMajor, false);
			$this->db->or_where("e.major_id IS NULL)", null, false);
			$this->db->where("b.job_id",$job_id);
			$this->db->order_by("b.user_id", "desc"); 
			$this->db->order_by("d.edu_years", "desc"); 
			$sql = $this->db->get();
			if($sql->num_rows() > 0){
				foreach($sql->result_array() as $row){
					$tmp[$row['email']] = $row['user_id'];
				}
			}
		}
		return $tmp;
	}
	
	private function QualifiedYearsExp($job_id){
		$YearsExp = $this->getMinimumYearsExperience($job_id);
		$this->db->select("b.user_id,c.name");
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->where("((select sum(
		(case when p.exp_untilnow = 1 then (
		((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
		) else (
		((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
		)
		end
		)) as total
		from jb_person_experience p where p.user_id = c.user_id) >=",$YearsExp, FALSE);
		$this->db->where("(select sum(
		(case when p.exp_untilnow = 1 then (
		((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
		) else (
		((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
		)
		end
		)) as total
		from jb_person_experience p where p.user_id = c.user_id) IS NOT NULL)", null, false);
		$this->db->where("b.job_id",$job_id);
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function UnqualifiedYearsExp($job_id){
		$YearsExp = $this->getMinimumYearsExperience($job_id);
		$this->db->select("b.user_id,c.email");
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->where("((select sum(
		(case when p.exp_untilnow = 1 then (
		((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
		) else (
		((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
		)
		end
		)) as total
		from jb_person_experience p where p.user_id = c.user_id) <",$YearsExp, FALSE);
		$this->db->or_where("(select sum(
		(case when p.exp_untilnow = 1 then (
		((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
		) else (
		((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
		+ 
		extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
		)
		end
		)) as total
		from jb_person_experience p where p.user_id = c.user_id) IS NULL)", null, false);
		$this->db->where("b.job_id",$job_id);
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[$row['email']] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	
	private function QualifiedAges($job_id){
		$Ages = $this->getMinimumAges($job_id);
		$this->db->select("b.user_id,c.name");
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		if($Ages > 0){
			$this->db->where("((
			((extract( year FROM now() ) - extract( year FROM c.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM c.birth_date )) <=",$Ages, FALSE);
			$this->db->where("(
			((extract( year FROM now() ) - extract( year FROM c.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM c.birth_date )) IS NOT NULL)", null, false);
		}
		$this->db->where("b.job_id",$job_id);
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function UnqualifiedAges($job_id){
		$Ages = $this->getMinimumAges($job_id);
		$tmp = array();
		if($Ages > 0){
			$this->db->select("b.user_id,c.email");
			$this->db->from("jb_job a");
			$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
			$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
			$this->db->where("((
			((extract( year FROM now() ) - extract( year FROM c.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM c.birth_date )) >",$Ages, FALSE);
			$this->db->or_where("(
			((extract( year FROM now() ) - extract( year FROM c.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM c.birth_date )) IS NULL)", null, false);
			$this->db->where("b.job_id",$job_id);
			$sql = $this->db->get();
			if($sql->num_rows() > 0){
				foreach($sql->result_array() as $row){
					$tmp[$row['email']] = $row['user_id'];
				}
			}
		}
		return $tmp;
	}
	
	private function QualifiedGPA($job_id){
		$gpa = $this->getMinimumGPA($job_id);
		$scale = $this->getMinimumScale($job_id);
		$this->db->select("DISTINCT ON (b.user_id) b.user_id,c.name,d.edu_years",false);
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->join("jb_person_education d","b.user_id = d.user_id","LEFT");
		$this->db->join("jb_master_grade e","e.grade_id = d.grade_id","LEFT");
		$this->db->where("(d.edu_gpa >=",$gpa,False);
		if($scale>0){
			$this->db->where("d.edu_gpa_scale",$scale,False);
		}
		$this->db->where("d.edu_gpa IS NOT NULL", null, false);
		$this->db->where("d.edu_gpa_scale IS NOT NULL)", null, false);
		$this->db->where("b.job_id",$job_id);
		$this->db->order_by("b.user_id", "desc"); 
		$this->db->order_by("d.edu_years", "desc"); 
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function UnqualifiedGPA($job_id){
		$gpa = $this->getMinimumGPA($job_id);
		$scale = $this->getMinimumScale($job_id);
		$this->db->select("DISTINCT ON (b.user_id) b.user_id,c.email",false);
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->join("jb_person_education d","b.user_id = d.user_id","LEFT");
		$this->db->join("jb_master_grade e","e.grade_id = d.grade_id","LEFT");
		$this->db->where("(d.edu_gpa <",$gpa,false);
		if($scale>0){
			$this->db->or_where("d.edu_gpa_scale !=",$scale,false);
		}
		$this->db->or_where("d.edu_gpa IS NULL", null, false);
		$this->db->or_where("d.edu_gpa_scale IS NULL)", null, false);
		$this->db->where("b.job_id",$job_id);
		$this->db->order_by("b.user_id", "desc"); 
		$this->db->order_by("d.edu_years", "desc"); 
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[$row['email']] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function QualifiedGender($job_id){
		$gender = $this->getPriorityGender($job_id);
		if(count($gender)>0){
			$this->db->where_in("(c.gender",$gender, false);
			$this->db->where("c.gender IS NOT NULL)", null, false);
		}
		$this->db->select("b.user_id,c.name");
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
		$this->db->where("b.job_id",$job_id);
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = $row['user_id'];
			}
		}
		return $tmp;
	}
	
	private function UnqualifiedGender($job_id){
		$gender = $this->getPriorityGender($job_id);
		$tmp = array();
		if(count($gender)>0){
			$this->db->select("b.user_id,c.email");
			$this->db->from("jb_job a");
			$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
			$this->db->join("jb_person c","b.user_id = c.user_id","LEFT");
			$this->db->where_not_in("(c.gender",$gender, false);
			$this->db->or_where("c.gender IS NULL)", null, false);
			$this->db->where("b.job_id",$job_id);
			$sql = $this->db->get();
			if($sql->num_rows() > 0){
				foreach($sql->result_array() as $row){
					$tmp[$row['email']] = $row['user_id'];
				}
			}
		}
		return $tmp;
	}
	
	public function FilterListener($job_id){
		$q_edulevel = array();
		$q_edumajor = array();
		$q_yearsexp = array();
		$q_ages = array();
		$q_gpa = array();
		$q_gender = array();
		$u_edulevel = array();
		$u_edumajor = array();
		$u_yearsexp = array();
		$u_ages = array();
		$u_gpa = array();
		$u_gender = array();
		$qualified = array();
		$uq = array();
		$unqualified = array();
		if($job_id > 0){
			$q_edulevel = $this->QualifiedEduLevel($job_id);	
			$q_edumajor = $this->QualifiedEduMajor($job_id);	
			$q_yearsexp = $this->QualifiedYearsExp($job_id);
			$q_ages = $this->QualifiedAges($job_id);
			$q_gpa = $this->QualifiedGPA($job_id);
			$q_gender = $this->QualifiedGender($job_id);
			$qualified = array_intersect($q_edulevel, $q_edumajor, $q_yearsexp, $q_ages, $q_gpa, $q_gender);	
			//$qualified = array_intersect($q_edulevel, $q_yearsexp, $q_ages, $q_gpa, $q_gender);	
			$u_edulevel = $this->UnqualifiedEduLevel($job_id);	
			$u_edumajor = $this->UnqualifiedEduMajor($job_id);	
			$u_yearsexp = $this->UnqualifiedYearsExp($job_id);
			$u_ages = $this->UnqualifiedAges($job_id);
			$u_gpa = $this->UnqualifiedGPA($job_id);
			$u_gender = $this->UnqualifiedGender($job_id);
			$uq = array_merge($u_edulevel, $u_edumajor, $u_yearsexp, $u_ages, $u_gpa, $u_gender);
			$unqualified = array_diff($uq,$qualified);
			//$unqualified = array_merge($u_edulevel, $u_yearsexp, $u_ages, $u_gpa, $u_gender);
			//die(print_r($unqualified));
			$tmp = array(
						array(
								"fid" => "1",
								"job_id" => $job_id,
								"name" => "Qualified",
								"sumappl" => count($qualified)
						),
						array(
								"fid" => "0",
								"job_id" => $job_id,
								"name" => "Unqualified",
								"sumappl" => count($unqualified)
						)
			);
		} else {
			$tmp = array(
						array(
								"fid" => "1",
								"job_id" => $job_id,
								"name" => "Qualified",
								"sumappl" => 0
						),
						array(
								"fid" => "0",
								"job_id" => $job_id,
								"name" => "Unqualified",
								"sumappl" => 0
						)
			);
		} 
		return $tmp;
	}
    
    private function getArrayQualifiedUser($job_id){
		$q_edulevel = array();
		$q_edumajor = array();
		$q_yearsexp = array();
		$q_ages = array();
		$q_gpa = array();
		$q_gender = array();
		$qualified = array();
		if($job_id > 0){
			$q_edulevel = $this->QualifiedEduLevel($job_id);	
			$q_edumajor = $this->QualifiedEduMajor($job_id);	
			$q_yearsexp = $this->QualifiedYearsExp($job_id);
			$q_ages = $this->QualifiedAges($job_id);
			$q_gpa = $this->QualifiedGPA($job_id);
			$q_gender = $this->QualifiedGender($job_id);
			$qualified = array_intersect($q_edulevel, $q_edumajor, $q_yearsexp, $q_ages, $q_gpa, $q_gender);	
		}
		return $qualified;
	}
	
	 private function getArrayUnqualifiedUser($job_id){
		$u_edulevel = array();
		$u_edumajor = array();
		$u_yearsexp = array();
		$u_ages = array();
		$u_gpa = $this->UnqualifiedGPA($job_id);
		$u_gender = $this->UnqualifiedGender($job_id);
		$qualified = $this->getArrayQualifiedUser($job_id);
		$uq = array();
		$unqualified = array();
		if($job_id > 0){
			$u_edulevel = $this->UnqualifiedEduLevel($job_id);	
			$u_edumajor = $this->UnqualifiedEduMajor($job_id);	
			$u_yearsexp = $this->UnqualifiedYearsExp($job_id);
			$u_ages = $this->UnqualifiedAges($job_id);
			$uq = array_merge($u_edulevel, $u_edumajor, $u_yearsexp, $u_ages, $u_gpa, $u_gender);	
			$unqualified = array_diff($uq, $qualified);	
		}
		return $unqualified;
	}
    
    public function getQualifiedUser($limit, $search, $offset, $job_id){
        $array = count($this->getArrayQualifiedUser($job_id)) > 0 ? $this->getArrayQualifiedUser($job_id) : array( 0 => 0 );
		
		if ($search != '') { 
           $this->db->where($search, NULL, false); 
        }
		
		$this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->where_in("a.user_id",$array); 
		$this->db->where("b.job_id",$job_id); 
		$this->db->order_by("a.name","asc");
		$this->db->limit($limit, $offset);
		return $this->db->get();
		
	}
	
	public function getRowQualifiedUser($job_id, $search){
        $array = count($this->getArrayQualifiedUser($job_id)) > 0 ? $this->getArrayQualifiedUser($job_id) : array( 0 => 0 );
		
		if ($search != '') { 
           $this->db->where($search, NULL, false); 
        }
		
		$this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->where_in("a.user_id",$array); 
		$this->db->where("b.job_id",$job_id); 
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
	
	public function getUnqualifiedUser($limit, $search, $offset, $job_id){
        $array = count($this->getArrayUnqualifiedUser($job_id)) > 0 ? $this->getArrayUnqualifiedUser($job_id) : array( 0 => 0 );
		
		if ($search != '') { 
           $this->db->where($search, NULL, false); 
        }
		
		$this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
        $this->db->where_in("a.user_id",$array); 
		$this->db->where("b.job_id",$job_id); 
		$this->db->order_by("a.name","asc");
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}
	
	public function getRowUnqualifiedUser($job_id, $search){
        $array = count($this->getArrayUnqualifiedUser($job_id)) > 0 ? $this->getArrayUnqualifiedUser($job_id) : array( 0 => 0 );
		
		if ($search != '') { 
           $this->db->where($search, NULL, false); 
        }
		
		$this->db->select("a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
        $this->db->where_in("a.user_id",$array); 
		$this->db->where("b.job_id",$job_id); 
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
    
    /*
     * END FILTER BY SYSTEM
     */
    
    /*
     * BEGIN EXPORT
     */
   
    public function getApplAotExport($examid){
		$this->db->select("a.user_id,a.name,a.gender, a.birth_place,a.birth_date,(
			((extract( year FROM now() ) - extract( year FROM a.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM a.birth_date )) as ages, 
			(select sum(
				(case when p.exp_untilnow = 1 then (
				((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
				) else (
				((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
				)
				end
				)) as total
			from jb_person_experience p 
			where p.user_id = a.user_id) as exp,
			a.religion, a.email, a.phone,
			d.edu_name, d.edu_place, d.edu_years, d.edu_gpa, d.edu_gpa_scale, e.grade_name, f.major_name",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_aot_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("exams c","b.exam_id = c.examid","LEFT");
		$this->db->join("jb_person_education d","a.user_id = d.user_id and d.edu_years = (select max(x.edu_years) from jb_person_education x where x.user_id = a.user_id and x.edu_status = 1)","LEFT");
		$this->db->join("jb_master_grade e","d.grade_id = e.grade_id","LEFT");
		$this->db->join("jb_master_major f","d.major_id = f.major_id","LEFT");
		$this->db->where("c.examid",$examid);
		//$this->db->limit(2);
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
	
	public function getApplAotExportSimple($examid){
		$this->db->select("a.user_id,a.name");
		$this->db->from("jb_person a");
		$this->db->join("jb_aot_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("exams c","b.exam_id = c.examid","LEFT");
		$this->db->where("c.examid",$examid);
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
    
    public function getApplJobExport($job_id){
		$this->db->select("a.user_id,a.name,a.gender, a.birth_place,a.birth_date,(
			((extract( year FROM now() ) - extract( year FROM a.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM a.birth_date )) as ages, 
			(select sum(
				(case when p.exp_untilnow = 1 then (
				((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
				) else (
				((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
				)
				end
				)) as total
			from jb_person_experience p 
			where p.user_id = a.user_id) as exp,
			a.religion, a.email, a.phone,
			d.edu_name, d.edu_place, d.edu_years, d.edu_gpa, d.edu_gpa_scale, e.grade_name, f.major_name, c.job_name, g.company_name",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		$this->db->join("jb_person_education d","a.user_id = d.user_id and d.edu_years = (select max(x.edu_years) from jb_person_education x where x.user_id = a.user_id and x.edu_status = 1)","LEFT");
		$this->db->join("jb_master_grade e","d.grade_id = e.grade_id","LEFT");
		$this->db->join("jb_master_major f","d.major_id = f.major_id","LEFT");
		$this->db->join("jb_company g","c.company_id = g.company_id","LEFT");
		$this->db->where("c.job_id",$job_id);
		//$this->db->limit(2);
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
	
	public function getApplJobExportSimple($job_id){
		$this->db->select("a.user_id,a.name");
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		$this->db->where("c.job_id",$job_id);
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
	
	public function getApplStepExport($job_id,$step_id){
		$this->db->select("a.user_id,a.name,a.gender, a.birth_place,a.birth_date,(
			((extract( year FROM now() ) - extract( year FROM a.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM a.birth_date )) as ages, 
			(select sum(
				(case when p.exp_untilnow = 1 then (
				((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
				) else (
				((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
				)
				end
				)) as total
			from jb_person_experience p 
			where p.user_id = a.user_id) as exp,
			a.religion, a.email, a.phone,
			d.edu_name, d.edu_place, d.edu_years, d.edu_gpa, d.edu_gpa_scale, e.grade_name, f.major_name, c.job_name, i.company_name, h.step_name",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		$this->db->join("jb_person_education d","a.user_id = d.user_id and d.edu_years = (select max(x.edu_years) from jb_person_education x where x.user_id = a.user_id and x.edu_status = 1)","LEFT");
		$this->db->join("jb_master_grade e","d.grade_id = e.grade_id","LEFT");
		$this->db->join("jb_master_major f","d.major_id = f.major_id","LEFT");
		$this->db->join("jb_step_person g","a.user_id = g.user_id and c.job_id = g.job_id","LEFT");
		$this->db->join("jb_master_step h","h.step_id = g.step_id","LEFT");
		$this->db->join("jb_company i","c.company_id = i.company_id","LEFT");
		$this->db->where("c.job_id",$job_id);
		$this->db->where("g.step_id",$step_id);
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
    
    public function getApplQualifiedExport($job_id){
		$array = count($this->getArrayQualifiedUser($job_id)) > 0 ? $this->getArrayQualifiedUser($job_id) : array( 0 => 0 );
		$this->db->select("a.user_id,a.name,a.gender, a.birth_place,a.birth_date,(
			((extract( year FROM now() ) - extract( year FROM a.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM a.birth_date )) as ages, 
			(select sum(
				(case when p.exp_untilnow = 1 then (
				((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
				) else (
				((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
				)
				end
				)) as total
			from jb_person_experience p 
			where p.user_id = a.user_id) as exp,
			a.religion, a.email, a.phone,
			d.edu_name, d.edu_place, d.edu_years, d.edu_gpa, d.edu_gpa_scale, e.grade_name, f.major_name, c.job_name, g.company_name",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		$this->db->join("jb_person_education d","a.user_id = d.user_id and d.edu_years = (select max(x.edu_years) from jb_person_education x where x.user_id = a.user_id and x.edu_status = 1)","LEFT");
		$this->db->join("jb_master_grade e","d.grade_id = e.grade_id","LEFT");
		$this->db->join("jb_master_major f","d.major_id = f.major_id","LEFT");
		$this->db->join("jb_company g","c.company_id = g.company_id","LEFT");
		$this->db->where("c.job_id",$job_id);
		$this->db->where_in("a.user_id",$array);
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
	
	public function getApplUnqualifiedExport($job_id){
		$array = count($this->getArrayUnqualifiedUser($job_id)) > 0 ? $this->getArrayUnqualifiedUser($job_id) : array( 0 => 0 );
		$this->db->select("a.user_id,a.name,a.gender, a.birth_place,a.birth_date,(
			((extract( year FROM now() ) - extract( year FROM a.birth_date )) *12) 
			+ 
			extract(MONTH FROM now() ) - extract(MONTH FROM a.birth_date )) as ages, 
			(select sum(
				(case when p.exp_untilnow = 1 then (
				((extract( year FROM now() ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM now() ) - extract(MONTH FROM p.exp_joindate )
				) else (
				((extract( year FROM p.exp_outdate ) - extract( year FROM p.exp_joindate )) *12) 
				+ 
				extract(MONTH FROM p.exp_outdate ) - extract(MONTH FROM p.exp_joindate )
				)
				end
				)) as total
			from jb_person_experience p 
			where p.user_id = a.user_id) as exp,
			a.religion, a.email, a.phone,
			d.edu_name, d.edu_place, d.edu_years, d.edu_gpa, d.edu_gpa_scale, e.grade_name, f.major_name, c.job_name, g.company_name",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		$this->db->join("jb_person_education d","a.user_id = d.user_id and d.edu_years = (select max(x.edu_years) from jb_person_education x where x.user_id = a.user_id and x.edu_status = 1)","LEFT");
		$this->db->join("jb_master_grade e","d.grade_id = e.grade_id","LEFT");
		$this->db->join("jb_master_major f","d.major_id = f.major_id","LEFT");
		$this->db->join("jb_company g","c.company_id = g.company_id","LEFT");
		$this->db->where("c.job_id",$job_id);
		$this->db->where_in("a.user_id",$array);
		$this->db->order_by("a.name","asc");
		return $this->db->get();
	}
    
    /*
     * END EXPORT
     */
    
    /*
     * for resume preview
     */ 
     public function getPersonById($id){
		$this->db->select("*");
		$this->db->from("jb_person");
		$this->db->where("user_id",$id);
		return $this->db->get();
	}
	
	public function getPersonCardById($id){
		$this->db->select("*");
		$this->db->from("jb_person_card");
		$this->db->where("user_id",$id);
		return $this->db->get();
	}
	
	public function getPersonTrainingById($id){
		$this->db->select("*");
		$this->db->from("jb_person_training");
		$this->db->where("user_id",$id);
		return $this->db->get();
	}
	
	public function getPersonLangById($id){
		$this->db->select("*");
		$this->db->from("jb_person_language");
		$this->db->where("user_id",$id);
		return $this->db->get();
	}
	
	public function getPersonEducationById($id){
		$this->db->select("a.*,b.major_name,c.grade_name");
		$this->db->from("jb_person_education a");
		$this->db->join("jb_master_major b","a.major_id = b.major_id","LEFT");
		$this->db->join("jb_master_grade c","a.grade_id = c.grade_id","LEFT");
		$this->db->where("user_id",$id);
		$this->db->order_by("a.grade_id","desc");
		return $this->db->get();
	}
	
	public function getPersonExperienceById($id){
		$this->db->select("*");
		$this->db->from("jb_person_experience");
		$this->db->where("user_id",$id);
		$this->db->order_by("exp_joindate","desc");
		return $this->db->get();
	}
	
	public function getPersonExpectationById($id){
		$this->db->select("a.*,b.*");
		$this->db->from("jb_person_expectation a");
		$this->db->join("jb_master_city b","a.city_id = b.city_id","LEFT");
		$this->db->where("a.user_id",$id);
		return $this->db->get();
	}
	
	public function getAvailableAOT(){
		$this->db->select("*");
		$this->db->from("exams");
		$this->db->where("now() <=","availableto", false);
		return $this->db->get();
	}
	
	public function insertAOTPerson($data){
		$this->db->insert("jb_aot_person", $data);
        return $this->db->insert_id();
    }
    
    public function deleteAOTPerson($where){
		$this->db->where($where);
        $this->db->delete("jb_aot_person");
	}
	
    public function deleteUserExamPerson($where){
		$this->db->where($where);
        $this->db->delete("userexam");
	}
	
    public function deleteUserQuestionsPerson($where){
		$this->db->where($where);
        $this->db->delete("userquestions");
	}
	
    public function checkAOIPerson($where){
		$this->db->select("aoi_id");
        $this->db->from("jb_aoi_person");
		$this->db->where($where);
        return $this->db->get();
	}
	
	public function insertAOIPerson($data){
		$this->db->insert("jb_aoi_person", $data);
        return $this->db->insert_id();
    }
    
    public function deleteAOIPerson($where){
		$this->db->where($where);
        $this->db->delete("jb_aoi_person");
	}
	
    public function checkAOTPerson($where){
		$this->db->select("aot_id");
        $this->db->from("jb_aot_person");
		$this->db->where($where);
        return $this->db->get();
	}
	
	public function checkDISCPerson($where){
		$this->db->select("disc_id");
        $this->db->from("jb_disc_person");
		$this->db->where($where);
        return $this->db->get();
	}
	
	public function insertDISCPerson($data){
		$this->db->insert("jb_disc_person", $data);
        return $this->db->insert_id();
    }
    
    public function deleteDISCPerson($where){
		$this->db->where($where);
        $this->db->delete("jb_disc_person");
	}
	
    public function checkMBTIPerson($where){
		$this->db->select("mbti_id");
        $this->db->from("jb_mbti_person");
		$this->db->where($where);
        return $this->db->get();
	}
	
	public function insertMBTIPerson($data){
		$this->db->insert("jb_mbti_person", $data);
        return $this->db->insert_id();
    }
    
    public function deleteMBTIPerson($where){
		$this->db->where($where);
        $this->db->delete("jb_mbti_person");
	}
	
	public function getIdPersonByStep($where){
		$this->db->select("b.user_id,b.email");
        $this->db->from("jb_step_person a");
        $this->db->join("jb_person b","a.user_id = b.user_id","LEFT");
		$this->db->where($where);
        return $this->db->get();
	}
	
	public function getAllAoi(){
		$this->db->select("a.*, b.job_name, c.name, (case when now() between a.startdate and a.enddate then 1 else 0 end) as open", false);
		$this->db->from("jb_aoi_person a");
		$this->db->join("jb_job b","b.job_id = a.job_id","LEFT");
		$this->db->join("jb_person c","c.user_id = a.user_id","LEFT");
		$this->db->order_by("a.aoi_create_time","desc");
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$status = $row['open'] > 0 ? '<a href="'.base_url().'home/interview/" target="_blank">Click Here</a>':'Disable';
				$tmp[] = array(
						'name' => $row['name'],
						'job_name' => $row['job_name'],
						'start_date' => $row['startdate'],
						'end_date' => $row['enddate'],
						'description' => $row['description'],
						'status' => $status
				);
			}
		}
		return $tmp;
	}
	
	public function getSumAoi(){
		$this->db->select("aoi_id");
		$this->db->from("jb_aoi_person");
		$this->db->where("now() <= ","enddate",false);
		$this->db->order_by("aoi_create_time","desc");
		$sql = $this->db->get();
		return $sql->num_rows();
	}
	
	// begin search applicants
	function ApplListener($limit, $offset, $search, $sortcol, $sortdir) {
        if ($search != '') {
           $this->db->or_where($search, NULL, false); 
        }
           
        if ($sortcol != '') {
			$this->db->order_by("a.name","asc");
            $this->db->order_by($sortcol,$sortdir);
        } else {
			$this->db->order_by("a.name","asc");
		}	
        
        $this->db->select("c.job_id,c.job_name,a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		$this->db->limit($limit, $offset);
		return $this->db->get();
    }
	
	function RowsAppl($search) {
        if ($search != '') {
           //$this->db->like('a.nama', $search); 
           $this->db->where($search);
        }
        $this->db->select("c.job_id,c.job_name,a.user_id,a.name,a.email",FALSE);
		$this->db->from("jb_person a");
		$this->db->join("jb_job_person b","a.user_id = b.user_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		return $this->db->get();
    }
	// end search applicants
}
