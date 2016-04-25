<?php

class Api_mbti_model extends CI_Model 
{

/* MBTI */
	function recordmbti_start()
	{
		$this->db->set('starttime', 'NOW()', FALSE);
		$this->db->insert('mbti_guest');
		return $this->db->insert_id();
	}
	
	function mbtidetails($limit,$offset)
	{
	   $this->db->select('mbti_questionid'); 
	   $this->db->from('mbti_questions');
	   $this->db->limit($limit, $offset);
	   $details = $this->db->get();
	   return $details->result_array();
	}
	
	private function totalpage($limit){
	   $this->db->select('count(mbti_questionid) as total'); 
	   $this->db->from('mbti_questions');
	   $query = $this->db->get();
	   $row = $query->row_array();
	   return round((($row['total']/$limit)-1)*$limit);
	}
	
	function get_mbti_data($limit,$offset)
	{
					
		$exam = array();

		$this->db->select('*');
		$this->db->from('mbti_questions');
	    $this->db->limit($limit, $offset);
		$this->db->order_by('mbti_questionid', 'asc');
		$result_questions = $this->db->get();

		$exam['questions'] = array();
		foreach ($result_questions->result_array() as $x => $question) 
		{
			$exam['questions'][$x]['question_id'] = $question['mbti_questionid'];
			$exam['questions'][$x]['text'] = htmlentities($question['question']);
			$answers = array();
			$this->db->select('*');
			$this->db->from('mbti_option');
			$this->db->where('mbti_questionid',$question['mbti_questionid']);
			$result_option = $this->db->get();
			foreach ($result_option->result_array() as $option) 
			{
				$ansoption = array('id' => $option['option_label'], 'text' => $option['option_desc']);
				array_push($answers, $ansoption);
			}
	 
			$exam['questions'][$x]['answers'] = $answers;
	  
		}
		//die(print_r($exam));
		$exam['totalpage'] = $this->totalpage($limit);
		return $exam;
	}
	
	function save_answer_mbti($useranswer, $questionid, $userid)
	{
		$this->db->select('*');
		$this->db->from('mbti_guestquestions');
		$this->db->where('guestid', $userid);
		$this->db->where('mbti_questionid', $questionid);
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
		$question_status = array('answered' => 'answered', 'guest_answer' => $useranswer);
		$this->db->where('guestid', $userid);
		$this->db->where('mbti_questionid', $questionid);
		$this->db->update('mbti_guestquestions',  $question_status);
		}
		else
		{
		 $question_status = array('guestid' => $userid,
								  'mbti_questionid' => $questionid,
								  'answered' => 'answered', 
								  'guest_answer' => $useranswer);
		 $this->db->insert('mbti_guestquestions', $question_status);
		}
	}
	
	function finish_user_mbti($userid)
	{
		$exam_newstatus = array('endtime' => date('Y-m-d H:i:s'),
								'status' => 'completed'
								);
		 $this->db->where('guestid', $userid);
		 $this->db->set('status', 'completed');
		 $this->db->set('endtime', 'NOW()', FALSE);
		 $this->db->update('mbti_guest');
		 
	}
	
	function get_mbti_results($questid)
    {
        $results = array();
		$results['examname'] = 'MBTI';
		$this->db->select('*');
		$this->db->from('mbti_guest');
		$this->db->where('guestid',$questid);
		$mbti_records = $this->db->get();
		$users_results = array();
		foreach ($mbti_records->result_array() as $key => $mbti_result) 
		{			
			$userid = $mbti_result['guestid'];
			$this->db->select('a.guestid, a.mbti_questionid, a.guest_answer, b.option_marks, b.option_type');
			$this->db->from('mbti_guestquestions a');
			$this->db->join('mbti_option b', 'b.mbti_questionid = a.mbti_questionid and a.guest_answer = b.option_label');
			$this->db->where('a.guestid', $userid);
			$allquestions = $this->db->get()->result_array();
			$users_results[$key]['E'] = 0;
			$users_results[$key]['I'] = 0;
			$users_results[$key]['S'] = 0;
			$users_results[$key]['N'] = 0;
			$users_results[$key]['T'] = 0;
			$users_results[$key]['F'] = 0;
			$users_results[$key]['J'] = 0;
			$users_results[$key]['P'] = 0;
			foreach ($allquestions as  $questiondata) 
			{
				$users_results[$key]['E'] = $users_results[$key]['E'] + ($questiondata['option_type'] == 'E'? $questiondata['option_marks'] : 0);
				$users_results[$key]['I'] = $users_results[$key]['I'] + ($questiondata['option_type'] =='I'? $questiondata['option_marks'] : 0);
				$users_results[$key]['S'] = $users_results[$key]['S'] + ($questiondata['option_type'] == 'S'? $questiondata['option_marks'] : 0);
				$users_results[$key]['N'] = $users_results[$key]['N'] + ($questiondata['option_type'] == 'N'? $questiondata['option_marks'] : 0);
				$users_results[$key]['T'] = $users_results[$key]['T'] + ($questiondata['option_type'] == 'T'? $questiondata['option_marks'] : 0);
				$users_results[$key]['F'] = $users_results[$key]['F'] + ($questiondata['option_type'] == 'F'? $questiondata['option_marks'] : 0);
				$users_results[$key]['J'] = $users_results[$key]['J'] + ($questiondata['option_type'] == 'J'? $questiondata['option_marks'] : 0);
				$users_results[$key]['P'] = $users_results[$key]['P'] + ($questiondata['option_type'] == 'P'? $questiondata['option_marks'] : 0);
			}
			$energy = array('E'=>$users_results[$key]['E'],'I'=>$users_results[$key]['I']);
			$information = array('S'=>$users_results[$key]['S'],'N'=>$users_results[$key]['N']);
			$decisions = array('T'=>$users_results[$key]['T'],'F'=>$users_results[$key]['F']);
			$lifestyle = array('J'=>$users_results[$key]['J'],'P'=>$users_results[$key]['P']);
			$users_results[$key]['guest_mbti'] = array_search(max($energy), $energy).array_search(max($information), $information).array_search(max($decisions), $decisions).array_search(max($lifestyle), $lifestyle);
			$users_results[$key]['guest_mbti_type'] = $this->get_mbti_type($users_results[$key]['guest_mbti']);
		}
		$results['guest_results'] = $users_results;
		//die(print_r($results));
		return $results;
    }
	
	private function get_mbti_type($type)
    {
		$this->db->select('descs');
		$this->db->from('mbti_type');
		$this->db->where('types',$type);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   $row = $query->row_array();

		   return $row['descs'];
		} else {
		   return array();
		}
	}
	
	/* End MBTI */
}		
?>
