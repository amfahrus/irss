<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class dokumen_lib
{
    function dokumen_lib()
    {
        $this->CI=& get_instance();
		$nama_hari = array();
		$nama_bulan = array();
		$prefix_bulan = array();
		$tanggal;
		$hari;
		$bulan;
		$tahun;
		$this->nama_hari = array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
		$this->nama_bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');							
		$this->prefix_bulan = array('01','02','03','04','05','06','07','08','09','10','11','12');							

        $this->CI->load->library('session');
        $this->CI->load->helper('form');
        $this->CI->load->helper('url');
        $this->CI->load->helper('language');
    }
	
	function serial()
	{
		if(strpos(base_url(),'www.') !== false){
			$param = str_replace('www.','',base_url());
		} else {
			$param = base_url();
		}	 
		$key = intval($param);
		$arr = str_split($param);
		$k = strlen($param);
		$sernum = '';
		for ($i=0; $i<$k; $i++)
		{
			$sernum .= strtoupper(chr(intval(ord($arr[$i]))+intval(intval(ord($arr[$i]))+$i))+intval(date("Y")));
		}
		$split = str_split(md5($sernum),4);
		$result = implode("-",$split);
		return strtoupper($result);
	}
	
	function getLanguage(){
		$global_language = $this->CI->session->userdata('global_language');
		if(empty($global_language)){
			$this->CI->session->set_userdata('global_language','indonesia');
			$global_language = $this->CI->session->userdata('global_language');
		}	
		$this->CI->lang->load('home', $global_language);
		$this->CI->lang->load('company', $global_language);
		$this->CI->lang->load('person', $global_language);
		$this->CI->lang->load('form_validation', $global_language);
	}
	
	function get_serial()
	{
		$query = $this->CI->db->query("SELECT * FROM config WHERE label = 'serial'");
		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   return $row->contents;
		} else {
		   return '';
		} 
	}
	
	function check_person_login($id) {
		$serial = $this->serial();
		//$sernum = $this->get_serial();
		
        //if ($this->CI->session->userdata('user_id') && $sernum == $serial) {
        if ($this->get_password($id) == $this->CI->session->userdata('user_key') && $this->CI->session->userdata('user_id') == $id) {
			return true;
        } else {
            redirect('person/ceklogin','refresh');
            return false;
        }
    }
	
	function check_company_login($id) {
		$serial = $this->serial();
		//$sernum = $this->get_serial();
		
        //if ($this->CI->session->userdata('user_id') && $sernum == $serial) {
        if ($this->get_password($id) == $this->CI->session->userdata('company_account_key') && $this->CI->session->userdata('company_account_id') == $id) {
			return true;
        } else {
            redirect('company/ceklogin','refresh');
            return false;
        }
    }
    
    function check_company_news($cid,$nid) {
		$this->CI->db->select("a.news_id");
		$this->CI->db->from("jb_job_news a");
		$this->CI->db->join("jb_company b","a.company_id = b.company_id","LEFT");
		$this->CI->db->where("a.news_id",$nid);
		$this->CI->db->where("b.company_account_id",$cid);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0) {
			return true;
        } else {
            redirect('company/ceklogin','refresh');
            return false;
        }
    }
    
    function check_company_profile($id,$cid) {
		$this->CI->db->select("company_id");
		$this->CI->db->from("jb_company");
		$this->CI->db->where("company_id",$cid);
		$this->CI->db->where("company_account_id",$id);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0) {
			return true;
        } else {
            redirect('company/ceklogin','refresh');
            return false;
        }
    }
    
    function check_company_job($id,$job_id) {
		$this->CI->db->select("a.company_id");
		$this->CI->db->from("jb_company a");
		$this->CI->db->join("jb_job b","a.company_id = b.company_id","LEFT");
		$this->CI->db->where("b.job_id",$job_id);
		$this->CI->db->where("a.company_account_id",$id);
        $query = $this->CI->db->get();
        if ($query->num_rows() > 0) {
			return true;
        } else {
            redirect('company/ceklogin','refresh');
            return false;
        }
    }
	
    function check_admin_login() {
		$serial = $this->serial();
		//$sernum = $this->get_serial();
		
        //if ($this->CI->session->userdata('admin_id') && $sernum == $serial) {
        if ($this->CI->session->userdata('admin_id')) {
			return true;
        } else {
            redirect('admin','refresh');
            return false;
        }
    }

    function cek_wewenang_menu() {
        $group = $this->CI->session->userdata("group_id");
        
        $query = $this->CI->db->query("SELECT menu_id FROM be_menu where link = '".$this->CI->uri->segment(1)."'");
		$row = $query->row();
		$menu_id = $row->menu_id;
		$query->free_result();
		
		$sql = "SELECT * FROM be_menu_user WHERE group_id = $group AND menu_id = $menu_id";
		//die($sql);
        $res = $this->CI->db->query($sql);
        $res = $res->row();
        if ($res->enable == "0" || $this->CI->db->query($sql)->num_rows() == 0) {
            redirect("admin","refresh");
            return false;
        } else {
            return true;
        }
    }


    /*function get_grup_user() {
        return $this->CI->session->userdata('grupuser');
    }*/
	
	function generate_random_password($len=5){
	  $random_text = "";
          $length = $len;
          $a = "";
          $b = "";
           $template = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
           settype($length, "integer");
           settype($random_text, "string");
           settype($a, "integer");
           settype($b, "integer");

           for ($a = 0; $a <= $length; $a++) {
                   $b = rand(0, strlen($template) - 1);
                   $random_text .= $template[$b];
           }

           return $random_text;
    }
	
    function get_password($password) {
        $pass = sha1($password.$this->CI->config->item('encryption_key'));
        $res = $this->CI->db->query("SELECT ('$pass') AS pass");
        $res = $res->row();
        return $res->pass;
    }

    //  define createCache
    function createCache ( $content ,  $cacheFile ) {
        $cacheFile = 'cache/' . $cacheFile;
        $fp = fopen($cacheFile , 'w' );
        $content = "<!-- this is cache -->\n" . $content;
        fwrite( $fp , $content );
        fclose( $fp);
    }

    // define getCache
    function getCache ( $cacheFile ,  $expireTime ) {
        $cacheFile = 'cache/' . $cacheFile;
        //if ( file_exists ( $cacheFile ) && filemtime ( $cacheFile ) > ( time() - $expireTime ) ) {
        //    return file_get_contents( $cacheFile );
        //}
        if (file_exists($cacheFile) && (time() - $expireTime < filemtime($cacheFile))) {
            return file_get_contents($cacheFile);
        } else {
            return "";
        }
    }
    
    public function child_menu($id) {
        $sql = "SELECT menu_id, label, link, urutan, visible, image
                FROM be_menu a 
                WHERE parent <> 0
                AND parent = $id
                ORDER BY urutan ASC";

        $res = $this->CI->db->query($sql);
	$tmp = "";
        foreach ($res->result_array() as $mn) {
            $tmp .= "<li><a class=\"ajax-link\" href='" .base_url().$mn['link'] . "' id='" . $mn['label'] . "'><i class=\"" . $mn['image'] . "\"></i><span class=\"hidden-tablet\">" . $mn['label'] . "</span></a></li>";
            }
        return $tmp;
    }
    
    public function build_menu() {
        $group = $this->CI->session->userdata("group_id");
        //$grupuser = $this->CI->session->userdata("grupuser");
        $sql = "SELECT menu_id, label, link, urutan, visible, image, (SELECT COUNT(*) FROM be_menu WHERE parent = a.menu_id) as has_child
                FROM be_menu a 
                WHERE menu_id IN (SELECT menu_id FROM be_menu_user WHERE group_id = $group AND enable = '1') and parent = '0'
                ORDER BY urutan ASC";
        
        $res = $this->CI->db->query($sql);
        
	$tmp = "";
        foreach ($res->result_array() as $mn) {
            if ($mn["has_child"] > 0) {
                $tmp .= "<li class=\"nav-header hidden-tablet\">" . $mn['label'];
                $tmp .= $this->child_menu($mn['menu_id']);
                $tmp .= "</li>";
            } else {
                $tmp .= "<li><a class=\"ajax-link\" href='" .base_url().$mn['link'] . "' id='" . $mn['label'] . "'><i class=\"" . $mn['image'] . "\"></i><span class=\"hidden-tablet\">" . $mn['label'] . "</span></a></li>";
            
            }
            }
        return $tmp;
        //$this->CI->session->set_userdata("menu", $menu);
    }
    
    public function child_cekmenu($id,$group) {
        $sql = "SELECT menu_id, label, link, urutan, visible,
				(SELECT COUNT(*) FROM be_menu_user WHERE menu_id = a.menu_id AND group_id = $group) as cek
                FROM be_menu a 
                WHERE parent <> 0
                AND parent = $id
                ORDER BY urutan ASC";

        $res = $this->CI->db->query($sql);
	$tmp = "<ul>";
        foreach ($res->result_array() as $mn) {
            if($mn["cek"] > 0){
					$tmp .= "<li><input type=\"checkbox\" checked name=\"menu[".$mn['menu_id']."]\" value=\"".$mn['menu_id']."\"> ".$mn['label'];
				} else {
					$tmp .= "<li><input type=\"checkbox\" name=\"menu[".$mn['menu_id']."]\" value=\"".$mn['menu_id']."\"> ".$mn['label'];
				}
            }
        $tmp .= "</ul>";
        return $tmp;
    }
    
    public function build_cekmenu($group) {
        $sql = "SELECT menu_id, label, link, urutan, visible, image, 
        (SELECT COUNT(*) FROM be_menu WHERE parent = a.menu_id) as has_child,
		(SELECT COUNT(*) FROM be_menu_user WHERE menu_id = a.menu_id AND group_id = $group) as cek
                FROM be_menu a
                WHERE a.parent = 0
                ORDER BY urutan ASC";
        
        $res = $this->CI->db->query($sql);
        
	$tmp = "";
        foreach ($res->result_array() as $mn) {
            if ($mn["has_child"] > 0) {
				if($mn["cek"] > 0){
					$tmp .= "<li><input type=\"checkbox\" checked name=\"menu[".$mn['menu_id']."]\" value=\"".$mn['menu_id']."\"> ".$mn['label'];
				} else {
					$tmp .= "<li><input type=\"checkbox\" name=\"menu[".$mn['menu_id']."]\" value=\"".$mn['menu_id']."\"> ".$mn['label'];
				}
                $tmp .= $this->child_cekmenu($mn['menu_id'],$group);
            } else {
                if($mn["cek"] > 0){
					$tmp .= "<li><input type=\"checkbox\" checked name=\"menu[".$mn['menu_id']."]\" value=\"".$mn['menu_id']."\"> ".$mn['label'];
				} else {
					$tmp .= "<li><input type=\"checkbox\" name=\"menu[".$mn['menu_id']."]\" value=\"".$mn['menu_id']."\"> ".$mn['label'];
				}
            
            }
        }
        return $tmp;
        //$this->CI->session->set_userdata("menu", $menu);
    }
    
     public function multiple_jur($jobs) {
		if ($jobs==0){
			$addsql = "";
		} else {
			$addsql = "AND lowongan_id = $jobs";
		}
        $sql = "SELECT a.*, 
				(SELECT COUNT(*) FROM kualifikasi WHERE jurusan_id = a.jurusan_id $addsql) as cek
                FROM jurusan a
                WHERE a.enable = 1
                ORDER BY jurusan ASC";
        
        $res = $this->CI->db->query($sql);
        
	$tmp = "";
        foreach ($res->result_array() as $mn) {
                if($mn["cek"] > 0){
					$tmp .= "<option selected value=\"".$mn['jurusan_id']."\">".$mn['jurusan']."</option>";
				} else {
					$tmp .= "<option value=\"".$mn['jurusan_id']."\">".$mn['jurusan']."</option>";
				}
        }
        return $tmp;
        //$this->CI->session->set_userdata("menu", $menu);
    }
    
    public function bulan($param){
        switch ($param) {
            case 1:
                $m = "I";
                break;
            case 2:
                $m = "II";
                break;
            case 3:
                $m = "III";
                break;
            case 4:
                $m = "IV";
                break;
            case 5:
                $m = "V";
                break;
            case 6:
                $m = "VI";
                break;
            case 7:
                $m = "VII";
                break;
            case 8:
                $m = "VIII";
                break;
            case 9:
                $m = "IX";
                break;
            case 10:
                $m = "X";
                break;
            case 11:
                $m = "XI";
                break;
            case 12:
                $m = "XII";
                break;
            default:
                $m = "Not Found";
        }
        return $m;
    }
	
	function getDay($newDay) 
		{
			if($newDay<7)
			return $this->nama_hari[$newDay];		
		}
		
		function getMonth($newMonth)
		{
			if(($newMonth-1)<12)
			return $this->nama_bulan[$newMonth-1];			
		}
		
		function convert($new_date)
		{
			$new_date = mysql_to_unix($new_date);
			
			$new_day = mdate('%w', $new_date);			
			$new_month = mdate('%n', $new_date);	
			$new_tanggal = mdate('%j',$new_date);
			$new_tahun = mdate('%Y',$new_date);
			$new_hour = mdate('%H',$new_date);
			$new_minutes = mdate('%i',$new_date);
			 			
			return $this->nama_hari[$new_day].', '.$new_tanggal.'/'.$new_month.'/'.$new_tahun.'&nbsp;&nbsp;'.$new_hour.':'.$new_minutes.' WIB';			
		}
		
		function convert2($new_date)
		{
			$new_date = mysql_to_unix($new_date);
			
			$new_day = mdate('%w', $new_date);			
			$new_month = mdate('%n', $new_date);	
			$new_tanggal = mdate('%j',$new_date);
			$new_tahun = mdate('%Y',$new_date);
			$new_hour = mdate('%H',$new_date);
			$new_minutes = mdate('%i',$new_date);
			 			
			return $this->nama_hari[$new_day].', '.$new_tanggal.' '.$this->nama_bulan[$new_month-1].' '.$new_tahun.'&nbsp;&nbsp;';			
		}
		
		function simple($new_date)
		{
			$new_date = mysql_to_unix($new_date);
			
			$new_day = mdate('%w', $new_date);			
			$new_month = mdate('%n', $new_date);	
			$new_tanggal = mdate('%j',$new_date);
			$new_tahun = mdate('%Y',$new_date);
			$new_hour = mdate('%H',$new_date);
			$new_minutes = mdate('%i',$new_date);
			 			
			return $new_tanggal.' '.$this->nama_bulan[$new_month-1].' '.$new_tahun;			
		}
		
		function simple2($new_date)
		{
			$new_date = mysql_to_unix($new_date);
			
			$new_day = mdate('%w', $new_date);			
			$new_month = mdate('%n', $new_date);	
			$new_tanggal = mdate('%j',$new_date);
			$new_tahun = mdate('%Y',$new_date);
			$new_hour = mdate('%H',$new_date);
			$new_minutes = mdate('%i',$new_date);
			 			
			return $new_tanggal.'/'.$new_month.'/'.$new_tahun;			
		}
		
		function now()
		{
			$new_day = date('w');
			$new_month = date('n');
			$new_tanggal = date('j');
			$new_tahun = date('Y');
			return $this->nama_hari[$new_day].', '.$new_tanggal.' '.$this->nama_bulan[$new_month-1].' '.$new_tahun;		
		}
		
		function to_excel($query, $filename='exceloutput')
		{		
			 $headers = ''; // just creating the var for field headers to append to below
			 $data = ''; // just creating the var for field data to append to below
			 
			 $obj =& get_instance();
			 
			 $fields = $query->field_data();
			 if ($query->num_rows() == 0) {
				  echo '<p>The table appears to have no data.</p>';
			 } else {
				  foreach ($fields as $field) {
					 $headers .= $field->name . "\t";
				  }
			 
				  foreach ($query->result() as $row) {
					   $line = '';
					   foreach($row as $value) {                                            
							if ((!isset($value)) OR ($value == "")) {
								 $value = "\t";
							} else {
								 $value = str_replace('"', '""', $value);
								 $value = '"' . $value . '"' . "\t";
							}
							$line .= $value;
					   }
					   $data .= trim($line)."\n";
				  }
				  
				  $data = str_replace("\r","",$data);
								 
				  header("Content-type: application/octet-stream");
				  header("Content-Disposition: attachment; filename=$filename.xls");
				  header("Pragma: no-cache");
				  header("Expires: 0");
				  echo "$headers\n$data";  
			 }
		}

		function get_start($iDisplayStart) {
			$start = 0;
			if (isset($iDisplayStart)) {
				$start = intval($iDisplayStart);

				if ($start < 0)
					$start = 0;
			}

			return $start;
		}

		function get_rows($iDisplayLength) {
			$rows = 10;
			if (isset($iDisplayLength)) {
				$rows = intval($iDisplayLength);
				if ($rows < 5 || $rows > 500) {
					$rows = 10;
				}
			}

			return $rows;
		}

		function get_sort_dir($sSortDir_0) {
			$sort_dir = "ASC";
			$sdir = strip_tags($sSortDir_0);
			if (isset($sdir)) {
				if ($sdir != "asc" ) {
					$sort_dir = "DESC";
				}
			}

			return $sort_dir;
		}

		function get_sort($iSortCol_0,$cols,$sumcols) {
			$sCol = $iSortCol_0;
			$col = 0;
			if (isset($sCol)) {
				$col = intval($sCol);
				if ($col < 0 || $col > $sumcols)
					$col = 0;
			}
			$colName = $cols[$col];

			return $colName;
		}

 
}
