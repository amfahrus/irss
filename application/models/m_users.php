<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_users extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->_table = 'be_user';
        $this->CI = get_instance();
    }
    
    function getUserAll() {
        return $this->db->query('select
                                a.*,
                                b.*
                                from be_user a
                                left join be_group_user b on a.group_id = b.group_id
                                order by a.nama asc');
    }
    
    
    function getUser($id) {
        return $this->db->query("select
                                a.*,
                                b.*
                                from be_user a
                                left join be_group_user b on a.group_id = b.group_id
                                where a.user_id = $id
                                order by a.nama asc");
    }

    function getUserLogin($user,$pass) {
        return $this->db->query('select
                                a.*,
                                b.*
                                from be_user a
                                left join be_group_user b on a.group_id = b.group_id
                                where
                                a.username = \''.$user.'\' and
                                a.password = \''.$pass.'\'');
    }
	
	function getEula()
    {
        $this->db->where('label', 'eula');
        return $this->db->get('config');
    }
	
	function getUsersById($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->get($this->_table);
    }
	
    function getUsersByUname($user)
    {
        $this->db->where('username', $user);
        return $this->db->get($this->_table);
    }

    public function insertUsers($data) {
        $this->db->insert($this->_table, $data);
    }

    public function deleteUsers($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete($this->_table);
    }

    public function updateUsers($where, $data) {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }
    
    public function getGroup(){
        return $this->db->query("SELECT * FROM be_group_user");
    }
    
}
?>
