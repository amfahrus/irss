<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "/third_party/simplexlsx.class.php";

class simplexls extends SimpleXLSX {

    public function __construct() {
        parent::__construct();
    }

}
