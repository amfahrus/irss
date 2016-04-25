<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_person extends CI_Model {
	
	function __construct(){
		parent::__construct();
        $this->CI = get_instance();
	}
	
	public function getUserLogin($username, $password){
		$this->db->select("user_id, name, username");
		$this->db->from("jb_person");
		$this->db->where("username",$username);
		$this->db->where("password",$password);
		$this->db->where("is_active",1);
		return $this->db->get();
	}
	
	public function insertPerson($data){
		$this->db->insert("jb_person", $data);
        return $this->db->insert_id();
	}
	
	public function check_email($email = 0) {
		$this->db->select("email");
        $this->db->from("jb_person");
        $this->db->where("email",$email);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updatePerson($where, $data) {
        $this->db->where($where);
        $this->db->update("jb_person", $data);
        return $this->db->affected_rows();
    }
    
    public function deleteCardById($card_id){
		$this->db->where("card_id", $card_id);
        $this->db->delete("jb_person_card");
	}
	
    public function deletePersonCardById($user_id){
		$this->db->where("user_id", $user_id);
        $this->db->delete("jb_person_card");
	}
    
    public function insertPersonCard($data){
		$this->db->insert_batch("jb_person_card", $data); 
	}
    
    public function deleteEduById($edu_id){
		$this->db->where("edu_id", $edu_id);
        $this->db->delete("jb_person_education");
	}
	
    public function deletePersonEduById($user_id){
		$this->db->where("user_id", $user_id);
        $this->db->delete("jb_person_education");
	}
    
    public function insertPersonEdu($data){
		$this->db->insert_batch("jb_person_education", $data); 
	}
    
    public function deleteLangById($lang_id){
		$this->db->where("lang_id", $lang_id);
        $this->db->delete("jb_person_language");
	}
	
    public function deletePersonLangById($user_id){
		$this->db->where("user_id", $user_id);
        $this->db->delete("jb_person_language");
	}
    
    public function insertPersonLang($data){
		$this->db->insert_batch("jb_person_language", $data); 
	}
	
	public function deleteTrainingById($training_id){
		$this->db->where("training_id", $training_id);
        $this->db->delete("jb_person_training");
	}
	
    public function deletePersonTrainingById($user_id){
		$this->db->where("user_id", $user_id);
        $this->db->delete("jb_person_training");
	}
    
    public function insertPersonTraining($data){
		$this->db->insert_batch("jb_person_training", $data); 
	}
    
    public function deleteExpById($exp_id){
		$this->db->where("exp_id", $exp_id);
        $this->db->delete("jb_person_experience");
	}
	
    public function deletePersonExpById($user_id){
		$this->db->where("user_id", $user_id);
        $this->db->delete("jb_person_experience");
	}
    
    public function insertPersonExp($data){
		$this->db->insert_batch("jb_person_experience", $data); 
	}
    
    public function deletePersonExpectedById($user_id){
		$this->db->where("user_id", $user_id);
        $this->db->delete("jb_person_expectation");
	}
    
    public function insertPersonExpected($data){
		$this->db->insert("jb_person_expectation", $data); 
	}
    
    public function getMasterGradeAll(){
		$this->db->select("*");
		$this->db->from("jb_master_grade");
		return $this->db->get();
	}
    
    public function getMasterMajorAll(){
		$this->db->select("*");
		$this->db->from("jb_master_major");
		return $this->db->get();
	}
    
    public function getPersonById($id){
		$this->db->select("*");
		$this->db->from("jb_person");
		$this->db->where("user_id",$id);
		return $this->db->get();
	}
	
	public function checkPersonJob($where){
		$this->db->select("*");
		$this->db->from("jb_job_person");
		$this->db->where($where);
		return $this->db->get();
	}
	
	public function getYearsPersonJob($where){
		$this->db->select("extract(year from jp_create_time) as years");
		$this->db->from("jb_job_person");
		$this->db->where($where);
		$this->db->limit(1);
		$this->db->order_by("jp_create_time","desc");
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$years = date("Y");
			$res = $sql->row_array();
			if($res['years'] == $years){
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
	
	public function checkJob($where){
		$this->db->select("*");
		$this->db->from("jb_job");
		$this->db->where($where);
		return $this->db->get();
	}
	
	public function insertPersonJob($data){
		$this->db->insert("jb_job_person", $data);
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
	
	public function getAllJobStatusPerson($user_id){
		$this->db->select("a.job_id,a.job_name, b.jp_create_time,(case when 
							a.job_post_date <= '".date("Y-m-d h:i:s",strtotime("now"))."'
							and a.job_due_date >= '".date("Y-m-d h:i:s",strtotime("now"))."'
							then 1 else 0 end) as is_active", false);
		$this->db->from("jb_job a");
		$this->db->join("jb_job_person b","a.job_id = b.job_id","LEFT");
		$this->db->where("b.user_id",$user_id);
		$this->db->order_by("b.jp_create_time","desc");
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$tmp[] = array(
						'job_id' => $row['job_id'],
						'job_name' => $row['job_name'],
						'job_active' => $row['is_active'],
						'job_status' => $this->getPersonJobStep($user_id,$row['job_id'])
				);
			}
		}
		return $tmp;
	}
	
	public function getAllAotPerson($user_id){
		$this->db->select("a.*, b.*, c.job_name, (case when now() between b.startdate and b.enddate then 1 else 0 end) as open", false);
		$this->db->from("exams a");
		$this->db->join("jb_aot_person b","a.examid = b.exam_id","LEFT");
		$this->db->join("jb_job c","b.job_id = c.job_id","LEFT");
		$this->db->where("b.user_id",$user_id);
		$this->db->order_by("b.aot_create_time","desc");
		$sql = $this->db->get();
		$tmp = array();
		if(count($this->getAllDISCPerson($user_id)) > 0){
			$tmp = $this->getAllDISCPerson($user_id);
		}
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$result = $row['showstatus'] > 0 ? '<a class="btn btn-info" href="'.base_url().'aot/main/tokenresult/'.rawurlencode(base64_encode($row['examid'])).'/'.rawurlencode(base64_encode($user_id)).'" target="_blank">Result</a>':'No Result';
				$detail = $row['open'] > 0 ? '<a href="'.base_url().'aot/main/token/'.rawurlencode(base64_encode($user_id)).'" target="_blank">'.$row['examname'].'</a>':$row['examname'];
				$status = $row['open'] > 0 ? '<a class="btn btn-info" href="'.base_url().'aot/main/token/'.rawurlencode(base64_encode($user_id)).'" target="_blank">Click Here</a>':'Disable';
				$tmp[] = array(
						'exam_id' => $row['examid'],
						'exam_name' => $row['examname'],
						'job_name' => $row['job_name'],
						'start_date' => $row['startdate'],
						'end_date' => $row['enddate'],
						'description' => $row['description'],
						'detail' => $detail,
						'status' => $status,
						'result' => $result
				);
			}
		}
		//die(print_r($tmp));
		return $tmp;
	}
	
	public function getAllDISCPerson($user_id){
		$this->db->select("a.*, b.job_name, (case when now() between a.startdate and a.enddate then 1 else 0 end) as open", false);
		$this->db->from("jb_disc_person a");
		$this->db->join("jb_job b","a.job_id =b.job_id","LEFT");
		$this->db->where("a.user_id",$user_id);
		$this->db->order_by("a.disc_create_time","desc");
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$result = 'No Result';
				$detail = $row['open'] > 0 ? '<a href="'.base_url().'aot/api_disc/token/'.rawurlencode(base64_encode($user_id)).'" target="_blank">Tes Karakter</a>':'Tes Karakter';
				$status = $row['open'] > 0 ? '<a class="btn btn-info" href="'.base_url().'aot/api_disc/token/'.rawurlencode(base64_encode($user_id)).'" target="_blank">Click Here</a>':'Disable';
				$tmp[] = array(
						'exam_id' => 'disc',
						'exam_name' => 'Tes Karakter',
						'job_name' => $row['job_name'],
						'start_date' => $row['startdate'],
						'end_date' => $row['enddate'],
						'description' => $row['description'],
						'detail' => $detail,
						'status' => $status,
						'result' => $result
				);
			}
		}
		return $tmp;
	}
	
	public function getSumAotPerson($user_id){
		$this->db->select("b.exam_id");
		$this->db->from("exams a");
		$this->db->join("jb_aot_person b","a.examid = b.exam_id","LEFT");
		$this->db->where("b.user_id",$user_id);
		$this->db->where("b.showstatus",0);
		$this->db->where("now() <= ","b.enddate",false);
		$this->db->order_by("b.aot_create_time","desc");
		$sql = $this->db->get();
		return $sql->num_rows();
	}
	
	public function getAllAoiPerson($user_id){
		$this->db->select("a.*, b.job_name, (case when now() between a.startdate and a.enddate then 1 else 0 end) as open", false);
		$this->db->from("jb_aoi_person a");
		$this->db->join("jb_job b","b.job_id = a.job_id","LEFT");
		$this->db->where("a.user_id",$user_id);
		$this->db->order_by("a.aoi_create_time","desc");
		$sql = $this->db->get();
		$tmp = array();
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				$status = $row['open'] > 0 ? '<a href="'.base_url().'home/interview/" target="_blank">Click Here</a>':'Disable';
				$tmp[] = array(
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
	
	public function getSumAoiPerson($user_id){
		$this->db->select("aoi_id");
		$this->db->from("jb_aoi_person");
		$this->db->where("user_id",$user_id);
		$this->db->where("now() <= ","enddate",false);
		$this->db->order_by("aoi_create_time","desc");
		$sql = $this->db->get();
		return $sql->num_rows();
	}
	
	private function getPersonJobStep($user_id,$job_id){
		$this->db->select("b.step_id,b.step_name,a.js_order,a.js_id");
		$this->db->from("jb_job_step a");
		$this->db->join("jb_master_step b","a.step_id = b.step_id","LEFT OUTER");
		$this->db->join("jb_step_person c","b.step_id = c.step_id and c.user_id = $user_id","LEFT OUTER");
		$this->db->where("a.job_id",$job_id);
		$this->db->order_by("a.js_order","asc");
		$sql = $this->db->get();
		$tmp = array();
		$fail = false;
		if($sql->num_rows() > 0){
			foreach($sql->result_array() as $row){
				if($this->isExistInCurrentStep($user_id,$job_id,$row['step_id'])){
					$status = 'pass';
				} else{
					if($fail){
						$status = 'unknown';
					} else {
						if($this->isAnyoneExistInCurrentStep($job_id, $row['js_order'])){
							$fail = true;
							$status = 'fail';
						} else {
							$fail = false;
							$status = 'unknown';
						}
					}
				}
				/*$status = $this->isExistInCurrentStep($user_id,$job_id,$row['step_id']) ? 'pass' : 
						  ($this->isAnyoneExistInCurrentStep($job_id, $row['js_order']) ? 'fail' : 'unknown');*/
				$tmp[$row['step_name']] = array(
							'status' => $status,
							'step_id' => $row['step_id'],
							'js_id' => $row['js_id']
				);
			}
		}
		return $tmp;
	}

	private function isExistInCurrentStep($user_id,$job_id,$step_id){
		$this->db->select("a.user_id");
		$this->db->from("jb_step_person a");
		$this->db->where("a.user_id",$user_id);
		$this->db->where("a.job_id",$job_id);
		$this->db->where("a.step_id",$step_id);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	private function isAnyoneExistInCurrentStep($job_id,$order){
		$this->db->select("a.user_id");
		$this->db->from("jb_step_person a");
		$this->db->join("jb_job_step b","a.job_id = b.job_id and a.step_id = b.step_id","LEFT");
		$this->db->where("a.job_id",$job_id);
		$this->db->where("b.js_order",$order);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getJobStepById($js_id){
		$this->db->select("js_desc,js_attach");
		$this->db->from("jb_job_step");
		$this->db->where("js_id",$js_id);
		$sql = $this->db->get();
		return $sql;
	}
	
	public function getMasterLocationAll(){
		$this->db->select("*");
		$this->db->from("jb_master_city");
		$this->db->where("parent",1);
		$sql = $this->db->get();
		$tmp[] = array(
			'city_id' => 1,
			'city_name' => 'Seluruh Indonesia',
			'child'	=> ''
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
	
	public function isExternalJob($job_id){
		$this->db->select("job_external_url");
		$this->db->from("jb_job");
		$this->db->where("job_id",$job_id);
		$this->db->where("job_is_external",1);
		$sql = $this->db->get();
		if($sql->num_rows() > 0){
			$res = $sql->row_array();
			return $res['job_external_url'];
		} else {
			return false;
		}
	}
	
	public function deleteJobAlertByUserId($user_id){
		$this->db->where("user_id", $user_id);
        $this->db->delete("jb_job_alert");
	}
    
    public function insertJobAlert($data){
		$this->db->insert_batch("jb_job_alert", $data); 
	}
	
	public function getJobAlertByUserId($user_id){
		$this->db->select("a.*,b.jf_name");
		$this->db->from("jb_job_alert a");
		$this->db->join("jb_master_job_function b","a.jf_id = b.jf_id","LEFT");
		$this->db->where("a.user_id",$user_id);
		return $this->db->get();
	}
	
	public function getMasterJobFunctionAll(){
		$this->db->select("*");
		$this->db->from("jb_master_job_function");
		return $this->db->get();
	}
}
