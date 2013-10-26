<?php
class admin_model extends CI_Model {
	function get_stats(){
		//retrieve basic stats

		$sql = "SELECT COUNT(*) AS count FROM levels WHERE status = 1"; 
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $levels_active = $row->count;
		}

		$sql = "SELECT MAX(level) AS highest FROM users WHERE role = 1"; 
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $levels_highest = $row->highest;
		}

		$sql = "SELECT COUNT(*) AS count FROM users WHERE role = 1"; 
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $users_count = $row->count;
		}

		$stats = array(
			'levels_active' => $levels_active,
			'levels_highest' => $levels_highest,
			'users_count' => $users_count
		);

		return $stats;
	}

	function get_users(){
		//retrieve user details
		$this->load->model('user_model');

		$users = array();

		$sql = "SELECT fb_uid FROM users ORDER BY fb_name ASC"; 
		/*
		When there are so many users (500+), this function takes up too much time
		and resources to execute. You might want to add a pagination feature, or just
		limit the number of users displayed to a small number like this:
		$sql = "SELECT fb_uid FROM users ORDER BY fb_name ASC LIMIT 200";

		Reason and another alternative is given in the comments below 

		The answer log function works fine independent of this limit.
		*/
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$uid = $row->fb_uid;
				//This read_user function is called for each user
				//from the table. This is the main cause of high execution time.
				//Best practice would be to request the data from the aboe SQL query itself
				array_push($users, $this->user_model->read_user($uid));
			}
		}

		return $users;
	}

	function get_log($fb_uid){
		//Get user log, return if no fb_uid given

		if($fb_uid=='' || $fb_uid==NULL){
			return false;
		}

		$user_log = array();

		$sql = "SELECT fb_name, level, answer, timestamp, ip FROM log_answers WHERE fb_uid = ? ORDER BY level DESC, timestamp DESC"; 
		$query = $this->db->query($sql, $fb_uid);
		
		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {

		   	$log=array(
		   		'fb_name' => $row->fb_name,
		   		'level' => $row->level,
		   		'answer' => $row->answer,
		   		'timestamp' => $row->timestamp,
		   		'ip' => $row->ip
		   		);
		   	array_push($user_log, $log);
		   }

		   return $user_log;
		}else{
			return false;
		}
	}


	function add_level($details){
		//Add level feature

		$sql = "SELECT level, status FROM levels WHERE level = ?"; 
		$query = $this->db->query($sql, $details['level']);

		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			if($row->status==1){
				return 0;
			}

		   $sql = "DELETE FROM levels WHERE level = ?"; 
		   $query = $this->db->query($sql, $details['level']);
		}

		return $this->db->insert('levels',$details);
	}

	function set_status($level,$status){
		//set status of a level

		$data = array(
			'status' => $status
			);

		$this->db->where('level', $level);
		return $this->db->update('levels', $data); 

	}

	function set_admin_level($level){
		//set admin's level

		$fb_uid = $this->session->userdata('facebook_uid');

		if($fb_uid=='' || $fb_uid==NULL){
			return 0;
		}

		$data = array(
			'level' => $level
			);

		$this->db->where('fb_uid', $fb_uid);
		return $this->db->update('users', $data); 

	}

	function get_admin_level(){
		//get admin's current level to show in levels tab.

		$fb_uid = $this->session->userdata('facebook_uid');

		if($fb_uid=='' || $fb_uid==NULL){
			return 0;
		}
		$current_level = 1;

		$sql = "SELECT level FROM users WHERE fb_uid = ?"; 
		$query = $this->db->query($sql, $fb_uid);
		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $current_level = $row->level;
		}
		return $current_level;
	}

	function get_all_levels(){
		//gets details of all levels, for display in Levels tab

		$levels = array();

		$sql = "SELECT level, status FROM levels ORDER BY level ASC"; 
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {

		   	$level=array(
		   		'level' => $row->level,
		   		'status' => $row->status,
		   		);
		   	array_push($levels, $level);
		   }

		   return $levels;
		}else{
			return false;
		}
	}
}
