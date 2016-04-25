<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_master_step extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jb_master_step';
        $this->CI = get_instance();
    }
    
    public function getAll() {
        return $this->db->get($this->_table);
    }
	
	public function getById($id)
    {
        $this->db->select("*");						
		$this->db->from($this->_table);
		$this->db->where('step_id', $id);
		return $this->db->get();
    }

    public function insert($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    public function delete($id)
    {
        $this->db->where('step_id', $id);
        $this->db->delete($this->_table);
    }

    public function update($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }
}
?>
