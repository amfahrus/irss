<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_groups extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->_table = 'be_group_user';
        $this->CI = get_instance();
    }
    
    public function getGroupsAll() {
        return $this->db->get($this->_table);
    }
	
	public function getGroupsById($id)
    {
        $this->db->where('group_id', $id);
        return $this->db->get($this->_table);
    }
	
    public function getGroupsByName($name)
    {
        $this->db->where('group_name', $name);
        return $this->db->get($this->_table);
    }

    public function insertGroups($data) {
        $this->db->insert($this->_table, $data);
    }

    public function deleteGroups($id)
    {
        $this->db->where('group_id', $id);
        $this->db->delete($this->_table);
    }

    public function updateGroups($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }
}
?>
