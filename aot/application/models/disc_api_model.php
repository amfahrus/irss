<?php

class Disc_api_model extends CI_Model 
{

/* DISC */
	function recorddisc_start($email, $name)
	{
		$this->db->set('guestemail', $email);
		$this->db->set('guestname', $name);
		$this->db->set('starttime', 'NOW()', FALSE);
		$this->db->insert('disc_guest');
		return $this->db->insert_id();
	}
	
	function discdetails($limit,$offset)
	{
	   $this->db->select('*'); 
	   $this->db->from('disc_option');
	   $this->db->limit($limit, $offset);
	   $details = $this->db->get();
	   return $details->result_array();
	}
	
	private function totalpage($limit){
	   $this->db->select('count(disc_optionid) as total'); 
	   $this->db->from('disc_option');
	   $query = $this->db->get();
	   $row = $query->row_array();
	   return round((($row['total']/$limit)-1)*$limit);
	}
	
	private function total(){
	   $this->db->select('count(disc_optionid) as total'); 
	   $this->db->from('disc_option');
	   $query = $this->db->get();
	   $row = $query->row_array();
	   return round($row['total']);
	}
	
	function get_disc_data($limit,$offset)
	{

		$exam = array();

		$this->db->select('*');
		$this->db->from('disc_option');
	    $this->db->limit($limit, $offset);
		$this->db->order_by('disc_optionid', 'asc');
		$result_questions = $this->db->get();

		$exam['questions'] = array();
		foreach ($result_questions->result_array() as $x => $question) 
		{
			$exam['questions'][$x]['question_id'] = $question['disc_optionid'];
			$exam['questions'][$x]['text'] = $question['option_desc'];
	  
		}
		//die(print_r($exam));
		$exam['totalpage'] = $this->totalpage($limit);
		$exam['total'] = $this->total();
		return $exam;
	}
	
	function save_answer_disc($option, $marks, $userid)
	{
		$this->db->select('*');
		$this->db->from('disc_guestquestions');
		$this->db->where('guestid', $userid);
		$this->db->where('disc_optionid', $option);
		$result = $this->db->get();
		if($result->num_rows() > 0)
		{
		$question_status = array('answered' => $marks);
		$this->db->where('guestid', $userid);
		$this->db->where('disc_optionid', $option);
		$this->db->update('disc_guestquestions',  $question_status);
		}
		else
		{
		 $question_status = array('guestid' => $userid,
								  'disc_optionid' => $option,
								  'answered' => $marks);
		 $this->db->insert('disc_guestquestions', $question_status);
		}
	}
	
	function finish_user_disc($userid)
	{
		$exam_newstatus = array('endtime' => date('Y-m-d H:i:s'),
								'status' => 'completed'
								);
		 $this->db->where('guestid', $userid);
		 $this->db->set('status', 'completed');
		 $this->db->set('endtime', 'NOW()', FALSE);
		 $this->db->update('disc_guest');
		 
	}
	
	function get_disc_results($questid)
    {
        $results = array();
		$results['examname'] = 'DISC';
		$this->db->select('*');
		$this->db->from('disc_guest');
		$this->db->where('guestid',$questid);
		$mbti_records = $this->db->get();
		$users_results = array();
		foreach ($mbti_records->result_array() as $key => $disc_result) 
		{			
			$userid = $disc_result['guestid'];
			$this->db->select('a.guestid, a.disc_optionid, a.answered, b.option_mtype');
			$this->db->from('disc_guestquestions a');
			$this->db->join('disc_option b', 'b.disc_optionid = a.disc_optionid');
			$this->db->where('a.guestid', $userid);
			$allquestions = $this->db->get()->result_array();
			$users_results[$key]['D'] = 0;
			$users_results[$key]['I'] = 0;
			$users_results[$key]['S'] = 0;
			$users_results[$key]['C'] = 0;
			foreach ($allquestions as  $questiondata) 
			{
				$users_results[$key]['D'] = $users_results[$key]['D'] + ($questiondata['option_mtype'] == 'D'? $questiondata['answered'] : 0);
				$users_results[$key]['I'] = $users_results[$key]['I'] + ($questiondata['option_mtype'] =='I'? $questiondata['answered'] : 0);
				$users_results[$key]['S'] = $users_results[$key]['S'] + ($questiondata['option_mtype'] == 'S'? $questiondata['answered'] : 0);
				$users_results[$key]['C'] = $users_results[$key]['C'] + ($questiondata['option_mtype'] == 'C'? $questiondata['answered'] : 0);
			}
			$users_results[$key]['tot_D'] = round(($this->get_disc_total('D')*3), 2);
			$users_results[$key]['tot_I'] = round(($this->get_disc_total('I')*3), 2);
			$users_results[$key]['tot_S'] = round(($this->get_disc_total('S')*3), 2);
			$users_results[$key]['tot_C'] = round(($this->get_disc_total('C')*3), 2);
			
			$users_results[$key]['avg_D'] = round(($users_results[$key]['D'] * 100) / ($users_results[$key]['D']+$users_results[$key]['I']+$users_results[$key]['S']+$users_results[$key]['C']), 2);
			$users_results[$key]['avg_I'] = round(($users_results[$key]['I'] * 100) / ($users_results[$key]['D']+$users_results[$key]['I']+$users_results[$key]['S']+$users_results[$key]['C']), 2);
			$users_results[$key]['avg_S'] = round(($users_results[$key]['S'] * 100) / ($users_results[$key]['D']+$users_results[$key]['I']+$users_results[$key]['S']+$users_results[$key]['C']), 2);
			$users_results[$key]['avg_C'] = round(($users_results[$key]['C'] * 100) / ($users_results[$key]['D']+$users_results[$key]['I']+$users_results[$key]['S']+$users_results[$key]['C']), 2);
			$DISC = array('D'=>$users_results[$key]['D'],'I'=>$users_results[$key]['I'],'S'=>$users_results[$key]['S'],'C'=>$users_results[$key]['C']);
			$users_results[$key]['guest_disc'] = array_search(max($DISC), $DISC);
			$disc_type = $this->get_disc_type($users_results[$key]['guest_disc']);
			$types = $disc_type->row_array();
			$users_results[$key]['guest_disc_img'] = $types['img'];
			$users_results[$key]['guest_disc_type_name'] = $types['type_name'];
			$users_results[$key]['guest_disc_type_desc'] = $types['type_desc'];
			$users_results[$key]['guest_disc_short_desc'] = $types['short_desc'];
			$users_results[$key]['guest_disc_long_desc'] = $types['long_desc'];
		}
		$results['guest_results'] = $users_results;
		//die(print_r($results));
		return $results;
    }
	
	private function get_disc_total($type)
    {
		$this->db->select('count(disc_optionid) as total');
		$this->db->from('disc_option');
		$this->db->where('option_mtype',$type);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   $row = $query->row_array();

		   return $row['total'];
		} else {
		   return array();
		}
	}
	
	private function get_disc_type($type)
    {
		$this->db->select('*');
		$this->db->from('disc_type');
		$this->db->where('type_name',$type);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
		   return $query;
		} else {
		   return array();
		}
	}

	function insert_result($guestid,$comment,$type,$name,$email)
	{
		$this->db->set('guestresultemail', $email);
		$this->db->set('guestresultname', $name);
		$this->db->set('guestresulttype', $type);
		$this->db->set('guestresultcomment', $comment);
		$this->db->insert('disc_guest_result');
		return $this->db->insert_id();
	}

	function email_result($guestid,$comment)
	{
		$dataguest = array();
		$disc = $this->get_disc_results($guestid);
		$this->db->select('*');
		$this->db->from('disc_guest');
		$this->db->where('guestid',$guestid);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{	
		   $row = $query->row_array();
		   $dataguest['type'] = $disc['guest_results'][0]['guest_disc_type_desc'];
		   $dataguest['long_desc'] = $disc['guest_results'][0]['guest_disc_long_desc'];
		   $dataguest['name'] = $row['guestname'];
		   $dataguest['email'] = $row['guestemail'];
$this->insert_result($guestid,$comment,$disc['guest_results'][0]['guest_disc_type_desc'],$row['guestname'],$row['guestemail']);
		}
		return $dataguest;
	}
	/* End DISC */
}		
?>
