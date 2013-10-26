<?php
class levels_model extends CI_Model {

	function get_level() {
		//get level for the current user
		//current level is read from the database to prevent manipulation

		$fb_uid = $this->session->userdata('facebook_uid');

		if($fb_uid=='' || $fb_uid==NULL){
			return 0;
		}

		//set a default value, just in case.
		$current_level = 1;

		$sql = "SELECT level FROM users WHERE fb_uid = ?"; 
		$query = $this->db->query($sql, $fb_uid);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $current_level = $row->level;
		}

		//now we have the current level of the user

		$sql = 'SELECT level, title, difficulty, content, background, placeholder, cookie, javascript, html_comment, success_image, status FROM levels WHERE level = ?'; 
		$query = $this->db->query($sql, $current_level);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   //if status is 0, level is not yet activated
		   if($row->status==0){
		   	return 0;
		   }
		   //return all details to controller
		   return $row;
		}

		//User is in the highest level
		//Returning 0 displays the wait view.
		return 0;
	}

	function check_answer($answer){
		//Answer check function
		//Will increment level if answer is correct

		//only the first 30 characters of the answer are considered
		//security measure to reduce answer log size, and prevent some attacks
		$answer = (strlen($answer) > 30) ? substr($answer,0,30): $answer;

		$fb_uid = $this->session->userdata('facebook_uid');

		if($fb_uid=='' || $fb_uid==NULL){
			return false;
		}

		$current_level = 1;
		$fb_name = '';

		//read users level and name
		$sql = "SELECT fb_name, level FROM users WHERE fb_uid = ?"; 
		$query = $this->db->query($sql, $fb_uid);
		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $current_level = $row->level;
		   $fb_name = $row->fb_name;
		}

		//add answer log
		$log = array(
			'fb_uid' => $fb_uid,
			'fb_name' => $fb_name,
			'level' => $current_level,
			'answer' => mysql_real_escape_string($answer),
			'ip' =>  mysql_real_escape_string($_SERVER['REMOTE_ADDR'])
		);
		$this->db->insert('log_answers',$log);

		//read the hash of correct answer
		$sql = "SELECT answer FROM levels WHERE level = ?"; 
		$query = $this->db->query($sql, $current_level);
		
		if($query->num_rows > 0){
			$row = $query->row();

			//compare md5 hashes of answer and the correct answer
			//md5 is more than sufficient for security in our case
			if(md5($answer) === $row->answer){

				//if correct answer, increment the level
				$this->db->set('level', $current_level+1); 
				$this->db->where('fb_uid', $fb_uid);
				$this->db->set('passtime', 'NOW()', FALSE);
				$this->db->update('users'); 

				//post the details to facebook, just for promotion
				$this->load->model('user_model');
				$this->user_model->fb_post('level',$current_level);

				//return success to the controller
				return true;
			} else{
				//answer is wrong. return false.
				return false;
			}
		}
	}

	function get_success_img(){
		//get level up image.
		$fb_uid = $this->session->userdata('facebook_uid');

		if($fb_uid=='' || $fb_uid==NULL){
			return 0;
		}

		//Find out which level the user is in.
		$current_level = 1;

		$sql = "SELECT level FROM users WHERE fb_uid = ?"; 
		$query = $this->db->query($sql, $fb_uid);
		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $current_level = $row->level;
		}

		$sql = "SELECT success_image FROM levels WHERE level = ?"; 
		$query = $this->db->query($sql, $current_level-1);
		
		if($query->num_rows > 0){
			$row = $query->row();
			$image = $row->success_image;
		}

		//return the image. contains only the filename.
		return $image;
	}
}