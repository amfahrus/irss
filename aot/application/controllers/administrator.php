<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        is_adminlogged_in();
        $this->load->model('admin_model');
        $this->load->model('user_model');
    }
    function index()
    {
		$data = array();
        $data['page'] = 'dashboard';
		$this->load->view('admin/main', $data);
    }

    function editcategory($catid)
    {
        $data = array();
        if(isset($_POST['editcategorybttn']))
        {
            $this->form_validation->set_rules('catname', 'Category Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('catdesc', 'Category Description', 'trim|xss_clean');
            $this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $categorydetails = array('catname'=>$this->input->post('catname'), 
                                         'catdesc'=>$this->input->post('catdesc')
                                         );
                $indexid = $this->input->post('catid');
                if($this->admin_model->editcategory($categorydetails, $indexid))
                {
                    $data['success'] = 'Category edited successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while editing the category, please try again !';
                }
            }
        }
        $data['categorydetails'] = $this->admin_model->getcategory($catid);
        $data['page'] = 'editcategory';
        $this->load->view('admin/main', $data);
    }

    function categories()
    {
        $data = array();
        $data['categoriesdata'] = $this->admin_model->dbselect('exam_category');
        $data['page'] = 'managecategories';
        $this->load->view('admin/main', $data);
    }
    function createcategory()
    {
        $data = array();
        if(isset($_POST['savecatbttn']))
        {
            $this->form_validation->set_rules('catname', 'Category Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('catdesc', 'Category Description', 'trim|xss_clean');
            $this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $categorydetails = array('catname'=>$this->input->post('catname'), 
                                         'catdesc'=>$this->input->post('catdesc')
                                         );
                if($this->admin_model->createcategory($categorydetails))
                {
                    $data['success'] = 'Category added successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while adding the category, please try again !';
                }
            }
        }
        $data['page'] = 'createcategory';
        $this->load->view('admin/main', $data);
    }

    function exams()
    {
        $data = array();
        $data['exams'] = $this->admin_model->getexams();
        $data['page'] = 'manageexams';
        $this->load->view('admin/main', $data);
    }
    function editexam($examid)
    {
        $data = array();
        if(isset($_POST['saveexambttn']))
        {
            $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
            $this->form_validation->set_rules('examname', 'Exam Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('examdesc', 'Exam Description', 'trim|required|xss_clean');
            $this->form_validation->set_rules('noofques', 'Number of questions', 'trim|required|xss_clean');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required|xss_clean');
            $this->form_validation->set_rules('availablefrom', 'Available From', 'trim|required|xss_clean');
            $this->form_validation->set_rules('availableto', 'Available To', 'trim|required|xss_clean');
            $this->form_validation->set_rules('passmark', 'Pass Mark', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $examdetails = array('examname'=>$this->input->post('examname'), 
                                         'description'=>$this->input->post('examdesc'),
                                         'catid'=>$this->input->post('category'),
                                         'availablefrom'=>date('Y-m-d', strtotime($this->input->post('availablefrom'))),
                                         'availableto'=>date('Y-m-d', strtotime($this->input->post('availableto'))),
                                         'duration'=>$this->input->post('duration'),
                                         'questions'=>$this->input->post('noofques'),
                                         'passmark'=>$this->input->post('passmark')
                                         );
                $indexid = $this->input->post('examid');
                if($this->admin_model->editexam($examdetails, $indexid))
                {
                    $data['success'] = 'Exam updated successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while editing the exam, please try again !';
                }
            }
        }
        $examdetails = $this->admin_model->getexam($examid);
        $data['examdetails'] = $examdetails;
        $data['categories'] = $this->admin_model->get_select_option('exam_category', 'catid', 'catname', $examdetails->catid);
        $data['page'] = 'editexam';
        $this->load->view('admin/main', $data);
    }
    function createexam()
    {
        $data = array();
        if(isset($_POST['saveexambttn']))
        {
            $this->form_validation->set_rules('category', 'Category', 'trim|required|xss_clean');
            $this->form_validation->set_rules('examname', 'Exam Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('examdesc', 'Exam Description', 'trim|required|xss_clean');
            $this->form_validation->set_rules('noofques', 'Number of questions', 'trim|required|xss_clean');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required|xss_clean');
            $this->form_validation->set_rules('availablefrom', 'Available From', 'trim|required|xss_clean');
            $this->form_validation->set_rules('availableto', 'Available To', 'trim|required|xss_clean');
            $this->form_validation->set_rules('passmark', 'Pass Mark', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $examdetails = array('examname'=>$this->input->post('examname'), 
                                         'description'=>$this->input->post('examdesc'),
                                         'catid'=>$this->input->post('category'),
                                         'availablefrom'=>date('Y-m-d', strtotime($this->input->post('availablefrom'))),
                                         'availableto'=>date('Y-m-d', strtotime($this->input->post('availableto'))),
                                         'duration'=>$this->input->post('duration'),
                                         'questions'=>$this->input->post('noofques'),
                                         'passmark'=>$this->input->post('passmark')
                                         );
                if($this->admin_model->createexam($examdetails))
                {
                    $data['success'] = 'Exam added successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while adding the exam, please try again !';
                }
            }
        }
        $data['categories'] = $this->admin_model->get_select_option('exam_category', 'catid', 'catname');
        $data['page'] = 'createexam';
        $this->load->view('admin/main', $data);
    }

    function deleteexam()
    {
        $examid = $_POST['examId'];
        $this->admin_model->deleterecord('exams', 'examid', $examid);
    }
     function deletequestion()
    {
        $questionId = $_POST['questionId'];
        $this->admin_model->deleterecord('questions', 'questionid', $questionId);
    }

    function deletecategory()
    {
        $catid = $_POST['catId'];
        $this->admin_model->deleterecord('exam_category', 'catid', $catid);
    }
    function mngquestions($examid)
    {
        $data = array();
        $data['questions'] = $this->admin_model->get_exam_questions($examid);
        $data['examdata'] = $this->admin_model->get_exam_name($examid);
        $data['page'] = 'managequestions';
        $this->load->view('admin/main', $data);
    }
    function createquestion($examid)
    {
        $data = array();
        if(isset($_POST['savequestionbttn']))
        {
            $this->form_validation->set_rules('question', 'Question', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optiona', 'Option A', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optionb', 'Option B', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optionc', 'Option C', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optiond', 'Option D', 'trim|required|xss_clean');
            $this->form_validation->set_rules('correctanswer', 'Correct Answer', 'trim|required|xss_clean');
            $this->form_validation->set_rules('marks', 'Marks', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $questiondetails = array('examid'=>$this->input->post('examid'), 
                                         'question'=>$this->input->post('question'),
                                         'optiona'=>$this->input->post('optiona'),
                                         'optionb'=>$this->input->post('optionb'),
                                         'optionc'=>$this->input->post('optionc'),
                                         'optiond'=>$this->input->post('optiond'),
                                         'correctanswer'=>$this->input->post('correctanswer'),
                                         'marks'=>$this->input->post('marks')
                                         );
                if($this->admin_model->createquestion($questiondetails))
                {
                    $data['success'] = 'Question added successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while adding the Question, please try again !';
                }
            }

        }
        $data['examid'] = $examid;
        $data['page'] = 'createquestions';
        $this->load->view('admin/main', $data);
    }

    function editquestion($questionid = 0)
    {
        $data = array();
        if(isset($_POST['editquestionbttn']))
        {
            $this->form_validation->set_rules('question', 'Question', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optiona', 'Option A', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optionb', 'Option B', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optionc', 'Option C', 'trim|required|xss_clean');
            $this->form_validation->set_rules('optiond', 'Option D', 'trim|required|xss_clean');
            $this->form_validation->set_rules('correctanswer', 'Correct Answer', 'trim|required|xss_clean');
            $this->form_validation->set_rules('marks', 'Marks', 'trim|required|xss_clean');
            $this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $questionid = $this->input->post('questionid');
                $questiondetails = array('question'=>$this->input->post('question'),
                                         'optiona'=>$this->input->post('optiona'),
                                         'optionb'=>$this->input->post('optionb'),
                                         'optionc'=>$this->input->post('optionc'),
                                         'optiond'=>$this->input->post('optiond'),
                                         'correctanswer'=>$this->input->post('correctanswer'),
                                         'marks'=>$this->input->post('marks')
                                         );
                if($this->admin_model->editquestion($questiondetails, $questionid))
                {
                    $data['success'] = 'Question edited successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while editing the Question, please try again !';
                }
            }
        }

        $data['question'] = $this->admin_model->getquestion($questionid);
        $data['page'] = 'editquestion';
        $this->load->view('admin/main', $data);
    }

    function administrators()
    {
        $data = array();
        $data['administratorsdata'] = $this->admin_model->dbselect('administrators');
        $data['page'] = 'manageadministrators';
        $this->load->view('admin/main', $data);
    }

    function results()
    {
        $data = array();
        $data['page'] = 'viewresults';
        $data['exams'] = $this->admin_model->get_attempted_exams();
        $this->load->view('admin/main', $data);
    }
    function view_results($examid)
    {
        $data = array();
        $search = array();
        if(isset($_POST['searchbttn']))
        {
			$search['name'] = $this->input->post("name");
			$search['start'] = $this->input->post("start");
			$search['end'] = $this->input->post("end");
		}
        $data['page'] = 'exam_results';
        $data['exam_id'] = $examid;
        $data['exam_results'] = $this->admin_model->get_exam_results($examid,$search);
        $this->load->view('admin/main', $data);
    }
    
    function publish_results($examid)
    {
        $details = array('showstatus'=>1);
		if($this->admin_model->publishresult($details, $examid)){
			echo "<script>alert('Success');</script>";
		}
		redirect('administrator/view_results/'.$examid);
    }
    
    function get_password($password) {
        $pass = sha1($password.$this->config->item('encryption_key'));
        $res = $this->db->query("SELECT ('$pass') AS pass");
        $res = $res->row();
        return $res->pass;
    }
	
	function results_summary()
	{
		$examid = $_GET['examid'];
		$userid = $_GET['userid'];
		$data = array();
		$results = $this->admin_model->exam_results($examid, $userid);
		

		$data['results'] = $results;
		$this->load->view('admin/userexam_results', $data);
	}
	
	function pdfresult($examid){
		$data = array();
        $search = array();
        $search['name'] = $this->input->post("name");
		$search['start'] = $this->input->post("start");
		$search['end'] = $this->input->post("end");
		$database = $this->admin_model->rowExamUsers($examid,$search);
		if($database->num_rows() > 0){
			ini_set('memory_limit', '1024M');
			//ini_set('memory_limit','576M');
			$this->load->library('StreamZip');
			$zip = new ZipStream("aot.zip");
			$this->load->helper(array('dompdf', 'file'));
			foreach($database->result_array() as $row){
				$results = $this->admin_model->exam_results($examid, $row['userid']);
				$data['results'] = $results;
				$html = $this->load->view('admin/userexam_results_pdf', $data, true);
				$filename = $row['name'] ? preg_replace('/[^\p{L}\p{N}\s]/u', '_', url_title($row['name'],'underscore')) : 'aot';
				$stream = pdf_create($html, $filename, false);
				$zip->addDirectory($filename);
				$zip->openStream($filename."/".$filename.".pdf");
				$zip->addStreamData($stream);
				$zip->closeStream();
			}
			$zip->finalize();
		}
		
	}
	
    /* Begin DISC */
	function disc()
    {
        $data = array();
        $data['questions'] = $this->admin_model->get_disc_questions();
        $data['page'] = 'discquestions';
        $this->load->view('admin/main', $data);
    }
	
	function adddiscquestion()
    {
        $data = array();
        $batch = array();
        if(isset($_POST['adddiscquestionbttn']))
        {
            $this->form_validation->set_rules('question', 'Question', 'required|xss_clean');
            $this->form_validation->set_rules('option_label[]', 'Option Label', 'required|xss_clean');
            //$this->form_validation->set_rules('option_desc[]', 'Option Description', 'required|xss_clean');
            //$this->form_validation->set_rules('option_marks[]', 'Option Marks', 'required|xss_clean');
            //$this->form_validation->set_rules('option_type[]', 'Option Type', 'required|xss_clean');
            //$this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $question = array('question' => $this->input->post('question'));
				$questionid = $this->admin_model->adddiscquestion($question);
				$option_label = $this->input->post("option_label");
				$option_desc = $this->input->post("option_desc");
				$option_marks = $this->input->post("option_marks");
				$option_mtype = $this->input->post("option_mtype");
				$option_jtype = $this->input->post("option_jtype");
				if(!empty($option_label)){
					$i = 0;
					foreach($option_label as $row){
						$batch[$i]['disc_questionid']=$questionid;
						$batch[$i]['option_label']=$option_label[$i];
						$batch[$i]['option_desc']=$option_desc[$i];
						$batch[$i]['option_marks']=$option_marks[$i];
						$batch[$i]['option_mtype']=$option_mtype[$i];
						$batch[$i]['option_jtype']=$option_jtype[$i];
						$i++;
					}
				}
				$this->admin_model->deleterecord('disc_option','disc_questionid',$questionid);
                if($this->admin_model->adddiscoptions($batch))
                {
                    $data['success'] = 'Question added successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while editing the Question, please try again !';
                }
            }
        }

        $data['page'] = 'creatediscquestions';
        $this->load->view('admin/main', $data);
    }
	
	function editdiscquestion($disc_questionid = 0)
    {
        $data = array();
        $batch = array();
        if(isset($_POST['editdiscquestionbttn']))
        {
            $this->form_validation->set_rules('question', 'Question', 'trim|required|xss_clean');
            $this->form_validation->set_rules('option_label[]', 'Option Label', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('option_desc[]', 'Option Description', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('option_marks[]', 'Option Marks', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('option_type[]', 'Option Type', 'trim|required|xss_clean');
            //$this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $question = array('question' => $this->input->post('question'));
				$optionid = $this->input->post("disc_optionid");
				$option_label = $this->input->post("option_label");
				$option_desc = $this->input->post("option_desc");
				$option_marks = $this->input->post("option_marks");
				$option_mtype = $this->input->post("option_mtype");
				$option_jtype = $this->input->post("option_jtype");
				if(!empty($option_label)){
					$i = 0;
					foreach($option_label as $row){
						$batch[$i]['disc_questionid']=$disc_questionid;
						$batch[$i]['option_label']=$option_label[$i];
						$batch[$i]['option_desc']=$option_desc[$i];
						$batch[$i]['option_marks']=$option_marks[$i];
						$batch[$i]['option_mtype']=$option_mtype[$i];
						$batch[$i]['option_jtype']=$option_jtype[$i];
						$i++;
					}
				}
				$this->admin_model->deleterecord('disc_option','disc_questionid',$disc_questionid);
                if($this->admin_model->editdiscquestion($disc_questionid, $question, $batch))
                {
                    $data['success'] = 'Question edited successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while editing the Question, please try again !';
                }
            }
        }

        $data['question'] = $this->admin_model->getdiscquestionid($disc_questionid);
        $data['options'] = $this->admin_model->getdiscoptions($disc_questionid);
        $data['page'] = 'editdiscquestions';
        $this->load->view('admin/main', $data);
    }
	
	function deletediscquestion()
    {
        $questionId = $_POST['disc_questionId'];
        $this->admin_model->deleterecord('disc_questions', 'disc_questionid', $questionId);
        $this->admin_model->deleterecord('disc_option', 'disc_questionid', $questionId);
    }
    
    function view_discresults()
    {
        $data = array();
        $search = array();
        if(isset($_POST['searchbttn']))
        {
			$search['name'] = $this->input->post("name");
			$search['start'] = $this->input->post("start");
			$search['end'] = $this->input->post("end");
		}
		//die(print_r($search));
        $data['page'] = 'disc_results';
        $data['exam_results'] = $this->admin_model->get_disc_results($search);
        $this->load->view('admin/main', $data);
    }
	/* End DISC */
	
	/* Begin MBTI */
	function mbti()
    {
        $data = array();
        $data['questions'] = $this->admin_model->get_mbti_questions();
        $data['page'] = 'mbtiquestions';
        $this->load->view('admin/main', $data);
    }
	
	function addmbtiquestion()
    {
        $data = array();
        $batch = array();
        if(isset($_POST['addmbtiquestionbttn']))
        {
            $this->form_validation->set_rules('question', 'Question', 'required|xss_clean');
            $this->form_validation->set_rules('option_label[]', 'Option Label', 'required|xss_clean');
            //$this->form_validation->set_rules('option_desc[]', 'Option Description', 'required|xss_clean');
            //$this->form_validation->set_rules('option_marks[]', 'Option Marks', 'required|xss_clean');
            //$this->form_validation->set_rules('option_type[]', 'Option Type', 'required|xss_clean');
            //$this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $question = array('question' => $this->input->post('question'));
				$questionid = $this->admin_model->addmbtiquestion($question);
				$option_label = $this->input->post("option_label");
				$option_desc = $this->input->post("option_desc");
				$option_marks = $this->input->post("option_marks");
				$option_type = $this->input->post("option_type");
				if(!empty($option_label)){
					$i = 0;
					foreach($option_label as $row){
						$batch[$i]['mbti_questionid']=$questionid;
						$batch[$i]['option_label']=$option_label[$i];
						$batch[$i]['option_desc']=$option_desc[$i];
						$batch[$i]['option_marks']=$option_marks[$i];
						$batch[$i]['option_type']=$option_type[$i];
						$i++;
					}
				}
				$this->admin_model->deleterecord('mbti_option','mbti_questionid',$questionid);
                if($this->admin_model->addmbtioptions($batch))
                {
                    $data['success'] = 'Question added successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while editing the Question, please try again !';
                }
            }
        }

        $data['page'] = 'creatembtiquestions';
        $this->load->view('admin/main', $data);
    }
	
	function editmbtiquestion($mbti_questionid = 0)
    {
        $data = array();
        $batch = array();
        if(isset($_POST['editmbtiquestionbttn']))
        {
            $this->form_validation->set_rules('question', 'Question', 'trim|required|xss_clean');
            $this->form_validation->set_rules('option_label[]', 'Option Label', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('option_desc[]', 'Option Description', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('option_marks[]', 'Option Marks', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('option_type[]', 'Option Type', 'trim|required|xss_clean');
            //$this->form_validation->set_error_delimiters('<span class="fielderror">', '</span>');
            if($this->form_validation->run() == FALSE) 
            {
                $data['reset'] = false;
            }
            else
            {
                $question = array('question' => $this->input->post('question'));
				$optionid = $this->input->post("mbti_optionid");
				$option_label = $this->input->post("option_label");
				$option_desc = $this->input->post("option_desc");
				$option_marks = $this->input->post("option_marks");
				$option_type = $this->input->post("option_type");
				if(!empty($option_label)){
					$i = 0;
					foreach($option_label as $row){
						$batch[$i]['mbti_questionid']=$mbti_questionid;
						$batch[$i]['option_label']=$option_label[$i];
						$batch[$i]['option_desc']=$option_desc[$i];
						$batch[$i]['option_marks']=$option_marks[$i];
						$batch[$i]['option_type']=$option_type[$i];
						$i++;
					}
				}
				$this->admin_model->deleterecord('mbti_option','mbti_questionid',$mbti_questionid);
                if($this->admin_model->editmbtiquestion($mbti_questionid, $question, $batch))
                {
                    $data['success'] = 'Question edited successfully !';
                }
                else
                {
                    $data['error']   = 'An error occurred while editing the Question, please try again !';
                }
            }
        }

        $data['question'] = $this->admin_model->getmbtiquestionid($mbti_questionid);
        $data['options'] = $this->admin_model->getmbtioptions($mbti_questionid);
        $data['page'] = 'editmbtiquestions';
        $this->load->view('admin/main', $data);
    }
	
	function deletembtiquestion()
    {
        $questionId = $_POST['mbti_questionId'];
        $this->admin_model->deleterecord('mbti_questions', 'mbti_questionid', $questionId);
        $this->admin_model->deleterecord('mbti_option', 'mbti_questionid', $questionId);
    }
    
    function view_mbtiresults()
    {
        $data = array();
        $search = array();
        if(isset($_POST['searchbttn']))
        {
			$search['name'] = $this->input->post("name");
			$search['start'] = $this->input->post("start");
			$search['end'] = $this->input->post("end");
		}
		//die(print_r($search));
        $data['page'] = 'mbti_results';
        $data['exam_results'] = $this->admin_model->get_mbti_results($search);
        $this->load->view('admin/main', $data);
    }
    /* End MBTI */
    
    function compare_summary()
    {
        $data = array();
        $search = array();
        $data['exams'] = $this->admin_model->get_exams_all();
        $data['examname1'] = '';
        $data['examname2'] = '';
		if(isset($_POST['searchbttn']))
        {
			$search['exam1'] = $this->input->post("exam1");
			$search['exam2'] = $this->input->post("exam2");
			$data['examname1'] = $this->admin_model->get_exams_name($search['exam1']);
			$data['examname2'] = $this->admin_model->get_exams_name($search['exam2']);
			$data['results'] = $this->admin_model->get_compare_summary_results($search['exam1'],$search['exam2']);
		}
        $data['page'] = 'comparesummary';
        $this->load->view('admin/main', $data);
    }
}
