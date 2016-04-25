<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_akses extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->_table = 'be_menu_user';
        $this->CI = get_instance();
    }
    
	public function getGroupsAll() {
        return $this->db->get("be_group_user");
    }

    public function insertAkses($data) {
        //$this->db->insert($this->_table, $data);
        $this->db->insert_batch($this->_table, $data);
    }

    public function deleteAkses($group)
    {
        $this->db->where('group_id', $group);
        $this->db->delete($this->_table);
    }
	
}
?>
