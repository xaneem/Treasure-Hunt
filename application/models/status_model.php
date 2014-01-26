<?php
class status_model extends CI_Model {

	function get_leaderboard(){
		//prepare a leaderboard
		$data = array();

		$details = array(
			'rank' => NULL,
			'fb_name' => NULL,
			'level' => NULL,
			'college' => NULL
		);

		$rank = 1;
		
		$sql = "SELECT fb_name, level, college, role FROM users ORDER BY level DESC, passtime ASC"; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				//Only regular users are shown in the leaderboard
				//banned users and admins have a rank 0, and are excluded.
				if($row->role == 1){

					$details['rank'] = $rank;
					$details['fb_name'] = $row->fb_name;
					$details['level'] = $row->level;
					$details['college'] = $row->college;
					array_push($data, $details);

					$rank++;
				}
			}
			return $data;
		}else{
			//couldn't find any rows!?
			return false;
		}
		
	}

	function get_rank($fb_uid=''){
		//calculate rank of the current user, or given fb_uid

		if($fb_uid == ''){
			$fb_uid = $this->session->userdata('facebook_uid');
		}

		if($fb_uid=='' || $fb_uid==NULL){
			return 0;
		}

		//make sure the uid corresponds to a regular user
		$sql = "SELECT fb_uid, role FROM users WHERE fb_uid = $fb_uid"; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$role = $row->role;
		}else{
			return 0;
		}

		if($role!=1){
			//Rank is 0 for anyone other than a regular user.
			return 0;
		}

		//count from 0 to the current user's position
		$rank = 0;

		$sql = "SELECT fb_uid FROM users WHERE role=1 ORDER BY level DESC, passtime ASC"; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$rank++;
				if($row->fb_uid == $fb_uid){
					return $rank;
				}
			}
		}

		return 0;

	}

	function get_winners(){
		//For future use, if winner's details are 
		//added to database

		//return an empty array for now.
		$data = array();
		return $data;
	}
}
