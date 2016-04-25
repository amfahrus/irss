<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

	public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->getLanguage();
        $this->load->model("m_home");
    }

    public function index($offset = 0) {
		$data['search'] = base_url().'home/search/default';
		$where = array();
		
		$total = $this->m_home->getJobEnableAll($where)->row_array();
		$config['base_url'] = base_url().'home/index/'; //set the base url for pagination
		$config['total_rows'] = $total['total']; //total rows
		$config['per_page'] = '5'; //the number of per page for pagination
		$config['uri_segment'] = 3; //see from base_url. 3 for this case
		$config['full_tag_open'] = "<ul class=\"pagination pagination-lg\">";
		$config['full_tag_close'] = "</ul>";
		$config['cur_tag_open'] = "<li class=\"active\"><a href=\"#\">";
		$config['cur_tag_close'] = "<span class=\"sr-only\">(current)</span></a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		$this->pagination->initialize($config); //initialize pagination
		
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		
		$data['count'] = $this->m_home->getTotalByCompany();
		$data['total'] = $total['total'];
		$data['sql'] = $this->m_home->getPageJobEnableAll($where,$config['per_page'],$offset);
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
		$data['contents'] = $this->load->view('frontend/home/home', $data, TRUE);
		$this->load->view('frontend/template', $data);

    }
    
    public function search($search = 'default',$offset = 0) {
		$data['search'] = base_url().'home/search/'.$search;
		$where = array();
		
		if (isset($_POST['keyword'])) {
			$data['keyword'] = $this->input->post('keyword');
			$this->session->set_userdata('search_keyword',$data['keyword']);
			$this->session->unset_userdata('search_category');
		}
		if (isset($_POST['company'])) {
			$data['company'] = $this->input->post('company');
			$this->session->set_userdata('search_company',$data['company']);
			$this->session->unset_userdata('search_category');
		}
		switch ($search) {
			case 'Fresh-Graduate':
				$data['category'] = '1';
				$data['catdesc'] = 'fresh_graduate';
				$this->session->set_userdata('search_category',$data['category']);
				$this->session->unset_userdata('search_keyword');
				$this->session->unset_userdata('search_company');
				break;
			case 'Junior':
				$data['category'] = '2';
				$data['catdesc'] = 'junior';
				$this->session->set_userdata('search_category',$data['category']);
				$this->session->unset_userdata('search_keyword');
				$this->session->unset_userdata('search_company');
				break;
			case 'Middle':
				$data['category'] = '3';
				$data['catdesc'] = 'middle';
				$this->session->set_userdata('search_category',$data['category']);
				$this->session->unset_userdata('search_keyword');
				$this->session->unset_userdata('search_company');
				break;
			case 'Senior':
				$data['category'] = '4';
				$data['catdesc'] = 'senior';
				$this->session->set_userdata('search_category',$data['category']);
				$this->session->unset_userdata('search_keyword');
				$this->session->unset_userdata('search_company');
				break;
			case 'Evergreen':
				$data['category'] = '5';
				$data['catdesc'] = 'evergreen';
				$this->session->set_userdata('search_category',$data['category']);
				$this->session->unset_userdata('search_keyword');
				$this->session->unset_userdata('search_company');
				break;
			default:
				$this->session->unset_userdata('search_category');
		}
		
		if($this->session->userdata('search_category')){
			$where['a.category_id'] = $this->session->userdata('search_category');
			$data['category'] = $this->session->userdata('search_category');
		}
		if($this->session->userdata('search_keyword')){
			$where['lower(a.job_name) like'] = strtolower('%'.$this->session->userdata('search_keyword').'%');
			$data['keyword'] = $this->session->userdata('search_keyword');
		}
		if($this->session->userdata('search_company')){
			$where['lower(b.company_name) like'] = strtolower('%'.$this->session->userdata('search_company').'%');
			$data['company'] = $this->session->userdata('search_company');
		}
		$total = $this->m_home->getJobEnableAll($where)->row_array();
		$config['base_url'] = base_url().'home/search/'.$search; //set the base url for pagination
		$config['total_rows'] = $total['total']; //total rows
		$config['per_page'] = '5'; //the number of per page for pagination
		$config['uri_segment'] = 4; //see from base_url. 3 for this case
		$config['full_tag_open'] = "<ul class=\"pagination pagination-lg\">";
		$config['full_tag_close'] = "</ul>";
		$config['cur_tag_open'] = "<li class=\"active\"><a href=\"#\">";
		$config['cur_tag_close'] = "<span class=\"sr-only\">(current)</span></a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		$this->pagination->initialize($config); //initialize pagination
		
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		
		$data['count'] = $this->m_home->getTotalByCompany();
		$data['total'] = $total['total'];
		$data['sql'] = $this->m_home->getPageJobEnableAll($where,$config['per_page'],$offset);
		$data['meta'] = array(
							'name' => url_title($search, ' ')
						);
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
		$data['contents'] = $this->load->view('frontend/home/home', $data, TRUE);
		$this->load->view('frontend/template', $data);
    }
    
    public function detail($id = 0) {
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		$data['search'] = base_url().'home/search/default';
		if(!is_numeric($id)){
			redirect('home','refresh');
		};
        $data['job_detail'] = $this->m_home->getJobById($id);
		$data['job_step'] = $this->m_home->getJobStepByJobId($id);
		$data['meta'] = $data['job_detail']->num_rows() > 0 ? $data['job_detail']->row_array() : array();
        if($data['job_detail']->num_rows() > 0){
			$company = $data['job_detail']->row_array();
			$data['related'] = $this->m_home->getJobByCompany(array('a.company_id' => $company['company_id'], 'a.job_id !=' => $id));
			$this->m_home->readJob($id);
		} else {
			$data['related'] = $this->m_home->getJobByCompany(array('a.company_id' => 0, 'a.job_id !=' => $id));
		}
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
		$data['contents'] = $this->load->view('frontend/home/detail', $data, TRUE);
		$this->load->view('frontend/template', $data);
    }
    
    public function company($cid=0,$name='',$offset=0) {
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		$data['search'] = base_url().'home/search/default';
		
		if(!is_numeric($cid)){
			redirect('home','refresh');
		};
		$where = array('a.company_id' => $cid);
		
		$total = $this->m_home->getJobEnableAll($where)->row_array();
		$config['base_url'] = base_url().'home/company/'.$cid.'/'.$name.'/'; //set the base url for pagination
		$config['total_rows'] = $total['total']; //total rows
		$config['per_page'] = '5'; //the number of per page for pagination
		$config['uri_segment'] = 5; //see from base_url. 3 for this case
		$config['full_tag_open'] = "<ul class=\"pagination pagination-lg\">";
		$config['full_tag_close'] = "</ul>";
		$config['cur_tag_open'] = "<li class=\"active\"><a href=\"#\">";
		$config['cur_tag_close'] = "<span class=\"sr-only\">(current)</span></a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		$this->pagination->initialize($config); //initialize pagination
		
		$data['count'] = $this->m_home->getTotalByCompanyException($cid);
		$data['total'] = $total['total'];
		$data['sql'] = $this->m_home->getPageJobEnableAll($where,$config['per_page'],$offset);
		
        $sql = $this->m_home->getCompanyById($cid);
        $data['company'] = $sql->row_array();
        $data['meta'] = $sql->num_rows() > 0 ? $sql->row_array() : array();
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
        $data['contents'] = $this->load->view('frontend/home/company', $data, TRUE);
		$this->load->view('frontend/template', $data);
    }
	
	public function cekPerson(){
		$this->load->model("m_person");
		$user_id = $this->session->userdata('user_id');
		$sql = false;
		if(isset($user_id) && !empty($user_id)){
			$this->session->set_userdata('useraot', $this->m_person->getSumAotPerson($user_id));
			$sql = $this->m_person->getPersonById($user_id)->row_array();
		}
		return $sql;
	}
	
	public function cekCompany(){
		$this->load->model("m_company");
		$company_account_id = $this->session->userdata('company_account_id');
		$sql = false;
		if(isset($company_account_id) && !empty($company_account_id)){
			$sql = $this->m_company->getCompanyAccountById($company_account_id)->row_array();
		}
		return $sql;
	}
	
	public function setlang($lang){
		if($lang == 'english'){
			$this->session->set_userdata('global_language','english');
		} else {
			$this->session->set_userdata('global_language','indonesia');
		}
		redirect('home');
	}
	
	public function JobAlertDaily(){
		$this->load->library('email');
		$config['protocol'] = 'mail';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		
		$sql = $this->m_home->getJobAlert('Daily');
		if(count($sql) > 0){
			foreach ($sql as $row) {
			
				$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
				$this->email->to($row['email']);
				$this->email->subject($this->config->item("web_title").' Job Alert');
				$this->email->message('<html>
										<head>
										<meta content="text/html; charset=ISO-8859-1"
										http-equiv="content-type">
										<title></title>
										</head>
										<body>
										'.$row['body'].'
										</body>
										</html>');
				$this->email->send();

			}
		}
	}
	
	public function JobAlertWeekly(){
		$this->load->library('email');
		$config['protocol'] = 'mail';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		
		$sql = $this->m_home->getJobAlert('Weekly');
		if(count($sql) > 0){
			foreach ($sql as $row) {
			
				$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
				$this->email->to($row['email']);
				$this->email->subject($this->config->item("web_title").' Job Alert');
				$this->email->message('<html>
										<head>
										<meta content="text/html; charset=ISO-8859-1"
										http-equiv="content-type">
										<title></title>
										</head>
										<body>
										'.$row['body'].'
										</body>
										</html>');
				$this->email->send();

			}
		}
	}
	
	public function JobAlertMonthly(){
		$this->load->library('email');
		$config['protocol'] = 'mail';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		
		$sql = $this->m_home->getJobAlert('Monthly');
		if(count($sql) > 0){
			foreach ($sql as $row) {
			
				$this->email->from($this->config->item("email_sender"), $this->config->item("email_sender_name"));
				$this->email->to($row['email']);
				$this->email->subject($this->config->item("web_title").' Job Alert');
				$this->email->message('<html>
										<head>
										<meta content="text/html; charset=ISO-8859-1"
										http-equiv="content-type">
										<title></title>
										</head>
										<body>
										'.$row['body'].'
										</body>
										</html>');
				$this->email->send();

			}
		}
	}
	
	public function rss(){
		$limit = 20;
		$data['title'] = $this->config->item("web_title").' - '.lang('rss_title');
		$data['link'] = base_url(); 
		$data['description'] = $this->config->item("web_title").' - '.lang('rss_desc');
		$data['item'] = $this->m_home->getJobRss($limit);
		$this->load->view('frontend/home/rss', $data);
	}
	
	public function news($offset = 0) {
		$data['search'] = base_url().'home/search/default';
		$where = array();
		
		$total = $this->m_home->getNewsAll($where)->row_array();
		$config['base_url'] = base_url().'home/news/'; //set the base url for pagination
		$config['total_rows'] = $total['total']; //total rows
		$config['per_page'] = '5'; //the number of per page for pagination
		$config['uri_segment'] = 3; //see from base_url. 3 for this case
		$config['full_tag_open'] = "<ul class=\"pagination pagination-lg\">";
		$config['full_tag_close'] = "</ul>";
		$config['cur_tag_open'] = "<li class=\"active\"><a href=\"#\">";
		$config['cur_tag_close'] = "<span class=\"sr-only\">(current)</span></a></li>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = "</li>";
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		$this->pagination->initialize($config); //initialize pagination
		
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		
		$data['count'] = $this->m_home->getTotalByCompany();
		$data['total'] = $total['total'];
		$data['sql'] = $this->m_home->getPageNewsAll($where,$config['per_page'],$offset);
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
		$data['contents'] = $this->load->view('frontend/home/news', $data, TRUE);
		$this->load->view('frontend/template', $data);

    }
    
    public function news_detail($nid = 0) {
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		$data['search'] = base_url().'home/search/default';
		if(!is_numeric($nid)){
			redirect('home/news','refresh');
		};
        $data['news_detail'] = $this->m_home->getNewsById($nid);
		$data['meta'] = $data['news_detail']->num_rows() > 0 ? $data['news_detail']->row_array() : array();
        $data['count'] = $this->m_home->getTotalByCompany();
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
		$data['contents'] = $this->load->view('frontend/home/news_detail', $data, TRUE);
		$this->load->view('frontend/template', $data);
    }
    
    public function userguide() {
		$data['search'] = base_url().'home/search/default';
		$where = array();
		$total = $this->m_home->getJobEnableAll($where)->row_array();
		
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		
		$data['count'] = $this->m_home->getTotalByCompany();
		$data['total'] = $total['total'];
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
		$data['contents'] = $this->load->view('frontend/home/flowchart', $data, TRUE);
		$this->load->view('frontend/template', $data);

    }
    
    public function contact() {
		$data['search'] = base_url().'home/search/default';
		$where = array();
		$total = $this->m_home->getJobEnableAll($where)->row_array();
		
		$data['person'] = $this->cekPerson();
		$data['companies'] = $this->cekCompany();
		
		$data['count'] = $this->m_home->getTotalByCompany();
		$data['total'] = $total['total'];
		$data['panel'] = $this->load->view('frontend/panel', $data, TRUE);
		$data['contents'] = $this->load->view('frontend/home/contact', $data, TRUE);
		$this->load->view('frontend/template', $data);

    }
    
    public function interview() {
		$data['contents'] = $this->load->view('frontend/home/interview');
		$this->load->view('frontend/template', $data);
    }
}
