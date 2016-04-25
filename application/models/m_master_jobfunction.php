<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_master_jobfunction extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jb_master_job_function';
        $this->CI = get_instance();
    }
    
    public function getAll() {
        $this->db->select("a.*,(select b.jf_name from jb_master_job_function b where b.jf_id = a.jf_parent) as parent_name");						
		$this->db->from($this->_table." a");
		return $this->db->get();
    }
	
	public function getById($id)
    {
        $this->db->select("*");						
		$this->db->from($this->_table);
		$this->db->where('jf_id', $id);
		return $this->db->get();
    }

    public function insert($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
    
    public function delete($id)
    {
        $this->db->where('jf_id', $id);
        $this->db->delete($this->_table);
    }

    public function update($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }
}
?>
