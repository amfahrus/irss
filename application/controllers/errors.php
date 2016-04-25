<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {
    
    public function index()
    {   
      
            $d["content"] = $this->load->view('v_404','',true);
            $this->load->view('v_template', $d);
    
    }

}