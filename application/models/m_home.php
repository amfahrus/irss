<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_home extends CI_Model {
	
	function __construct(){
		parent::__construct();
        $this->CI = get_instance();
	}
	
	public function getJobEnableAll($where) {
		if(is_array($where)){
			$this->db->where($where);
		}
		$this->db->select("count(a.job_id) as total");
		$this->db->from("jb_job a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->where("a.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where("a.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
		return $this->db->get();
    }
    
    public function getPageJobEnableAll($where,$limit,$offset){
		if(is_array($where)){
			$this->db->where($where);
		}
		$this->db->select("a.*,b.*,c.*,d.*,e.*,f.*,g.industry_name,
							(select count (x.user_id) from jb_job_person x 
							where x.job_id = a.job_id) as sumappl,
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
		$this->db->join("jb_master_industry g","b.industry_id = g.industry_id","LEFT");
		$this->db->where("a.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where("a.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->order_by("a.category_id","asc");
		$this->db->order_by("a.job_name","asc");
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}
	
	public function getNewsAll($where) {
		if(is_array($where)){
			$this->db->where($where);
		}
		$this->db->select("count(news_id) as total");
		$this->db->from("jb_job_news");
		return $this->db->get();
    }
    
    public function getPageNewsAll($where,$limit,$offset){
		if(is_array($where)){
			$this->db->where($where);
		}
		$this->db->select("a.*, b.*");
		$this->db->from("jb_job_news a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->order_by("a.news_post_date","desc");
		$this->db->limit($limit, $offset);
		return $this->db->get();
	}
	
	public function getNewsById($nid){
		$this->db->select("a.*, b.*");
		$this->db->from("jb_job_news a");
		$this->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->db->where("a.news_id",$nid);
		$this->db->order_by("a.news_post_date","desc");
		return $this->db->get();
	}
	
	public function getTotalByCompany(){
		$this->db->select("a.company_id, a.company_name, a.company_logo, count(b.job_id) as total");
		$this->db->from("jb_company a");
		$this->db->join("jb_job b","a.company_id = b.company_id","LEFT");
		$this->db->where("b.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where("b.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->group_by("a.company_id, a.company_name, a.company_logo");
		$this->db->order_by("total","desc");
		return $this->db->get();
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
		$this->db->join("jb_master_industry g","b.industry_id = g.industry_id","LEFT");
		//$this->db->where("a.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		//$this->db->where("a.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
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
	
	public function getJobByCompany($where){
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
		$this->db->join("jb_master_industry g","b.industry_id = g.industry_id","LEFT");
		$this->db->where("a.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where("a.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where($where);
		$this->db->order_by("a.job_create_time","desc");
		$this->db->limit(3, 0);
		return $this->db->get();
	}
	
	public function getTotalByCompanyException($cid){
		$this->db->select("a.company_id, a.company_name, a.company_logo, count(b.job_id) as total");
		$this->db->from("jb_company a");
		$this->db->join("jb_job b","a.company_id = b.company_id","LEFT");
		$this->db->where("a.company_id !=",$cid);
		$this->db->where("b.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where("b.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->group_by("a.company_id, a.company_name, a.company_logo");
		$this->db->order_by("total","desc");
		return $this->db->get();
	}
	
	public function getCompanyById($cid){
		$this->db->select("a.company_id, a.company_name, a.company_address, a.company_logo, a.company_desc, a.company_shortdesc, a.company_phone, a.company_website, a.company_email, a.company_location, a.company_longitude, a.company_latitude, count(b.job_id) as total");
		$this->db->from("jb_company a");
		$this->db->join("jb_job b","a.company_id = b.company_id","LEFT");
		$this->db->where("a.company_id",$cid);
		$this->db->group_by("a.company_id, a.company_name, a.company_address, a.company_logo, a.company_desc, a.company_shortdesc, a.company_phone, a.company_website, a.company_email, a.company_location, a.company_longitude, a.company_latitude");
		$this->db->order_by("total","desc");
		return $this->db->get();
	}
	
	public function readJob($job_id){
		$sql = $this->getJobById($job_id)->row_array();
		$count = $sql['job_read_count'] + 1;
		$data = array("job_read_count" => $count);
        $this->db->where("job_id", $job_id);
        $this->db->update("jb_job", $data);
	}
	
	/*
     * BEGIN SEND JOB ALERT
     */
    
    private function getEmail($job_id,$frequency){
		$this->db->select("a.email");
		$this->db->from("jb_person a");
		$this->db->where("a.is_job_alert",1);
		$this->db->where("a.job_alert_time",$frequency);
		$this->db->where("ARRAY(select b.jf_id from jb_job_alert b where a.user_id = b.user_id) &&"," ARRAY(select c.jf_id from jb_job_function c where c.job_id = ".$job_id.")",false);
		return $this->db->get();
	}
	
	public function getJobAlert($frequency){
		$tmp = array();
		$this->db->select("a.*,b.*,c.*,d.*,e.*,f.*,g.industry_name,
							(select count (x.user_id) from jb_job_person x 
							where x.job_id = a.job_id) as sumappl,
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
		$this->db->join("jb_master_industry g","b.industry_id = g.industry_id","LEFT");
		$this->db->where("a.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where("a.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->order_by("","random");
		$this->db->limit(10, 0);
		$sql = $this->db->get();
		if($sql->num_rows()>0){
			$body = false;
			foreach($sql->result_array() as $res){
				$body .= '<div style="text-align: left; font-weight: bold;"><a href="'.base_url().'home/detail/'.$res['job_id'].'/'.url_title($res['job_name']).'"><big>'.$res['job_name'].'</big></a></div>
						<hr style="width: 100%; height: 2px;">'
						.$res['company_name'].'<br>'
						.lang('career_level').' : '.$res['category_name'].'<br>'
						.lang('industry').' : '.$res['industry_name'].'<br>'
						.lang('location').' : '.$res['city_name'].'<br>'
						.lang('expire_date').' : '.$this->dokumen_lib->simple($res['job_due_date']).'
						<hr style="width: 100%; height: 2px;">';
			}
			$person = $this->getEmail($res['job_id'],$frequency);
			if($person->num_rows()>0){
				foreach($person->result_array() as $row){
					$tmp[] = array(
							"email" => $row['email'],
							"body"	=> $body
					);
				}
			}
		}
		return $tmp;
	}
    
    /*
     * END JOB ALERT
     */ 
     
     public function getJobRss($limit){
		$this->db->select("a.*,b.*,c.*,d.*,e.*,f.*,g.industry_name,
							(select count (x.user_id) from jb_job_person x 
							where x.job_id = a.job_id) as sumappl,
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
		$this->db->join("jb_master_industry g","b.industry_id = g.industry_id","LEFT");
		$this->db->where("a.job_post_date <=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->where("a.job_due_date >=",date("Y-m-d h:i:s",strtotime("now")));
		$this->db->order_by("a.job_due_date","desc");
		$this->db->limit($limit);
		return $this->db->get();
	}
}

?>
