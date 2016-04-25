<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Captcha extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('securimage_library');
    }

    public function normal() {
        $this->securimage_library->initialize();
        $this->securimage_library->show();
    }
}
