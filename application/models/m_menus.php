<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_menus extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->_table = 'be_menu';
        $this->CI = get_instance();
    }
    
    public function getMenusAll() {
		$this->db->select("a.*,(select label from ".$this->_table." b where b.menu_id = a.parent) as nama_parent");
		$this->db->from($this->_table.' a');
        return $this->db->get();
    }
	
	public function getMenusById($id)
    {
        $this->db->where('menu_id', $id);
        return $this->db->get($this->_table);
    }
	
    public function getMenusByName($name)
    {
        $this->db->where('label', $name);
        return $this->db->get($this->_table);
    }

    public function insertMenus($data) {
        $this->db->insert($this->_table, $data);
    }

    public function deleteMenus($id)
    {
        $this->db->where('menu_id', $id);
        $this->db->delete($this->_table);
    }

    public function updateMenus($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }
	
}
?>
