<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

Project Details
===============
Project Creator: Saneem Perinkadakkat
Twitter: @xaneem
Facebook: http://www.facebook.com/xaneem
GitHub: https://github.com/xaneem/Treasure-Hunt/

This project was originally created for Clueless 2013, an online treasure
hunt conducted as a part of Tathva 2013, the annual techno-management festival of
NIT Calicut.

You're free to use this code for any project, but you should follow the license given below.

If you need any help with the code, or details about how to install it, feel free
to ping me on Facebook or Twitter. Cheers!

LICENSE:
This project is licensed under GNU GENERAL PUBLIC LICENSE Version 2.
You're free to use this project for any purpose, but you
SHOULD provide the source code of any derivation freely available,
along with the proper attribution to the original project creator.

*/

class Home extends CI_Controller {

	public function index()
	{

		//Check if user is logged in
		if($this->auth->is_logged_in()){
			//If logged in, arena page is shown.

			$this->load->model('user_model');

			//Role is used to manage privileges
			//For details, see user_model
			$role = $this->user_model->get_role();		
			if($role == -1){
				//user is banned from the game
				//he/she will not be able to answer levels
				//and the rank will be 0 (will not show up in the leaderboard)
				$data['page'] = 'banned';
				$data['header_data'] = array('title' => 'You\'re Banned!');
				$this->load->view('template', $data);
			}else{

				//Load the level
				$this->load->model('levels_model');
				$level_details = $this->levels_model->get_level();

				if($level_details){
					//have a look in the views folder for details
					//arena is a view, header_data is used to change page title etc.
					$data['page'] = 'arena';
					$data['level'] = $level_details;
					$data['header_data'] = array('title' => $level_details->title);
					$this->load->view('template', $data);
				}else{
					//User is in the highest level. Load wait view.
					$data['page'] = 'wait';
					$data['header_data'] = array('title' => 'Levels to be uploaded!');
					$this->load->view('template',$data);
				}
			}
		}else{
			//Load general home page, with details and log-in button
			$data['page'] = 'home';
			$data['header_data'] = array('title' => 'Online Treasure Hunt');
			$this->load->view('template',$data);
		}
	}

	public function login() {
		//handles login
		$this->load->model('user_model');
		$result = $this->user_model->get_user();

		if ($result['is_true']) {
			//user has logged in to Facebook

			//Check if it's a returning user or just signed up
			$login_type = $this->user_model->signed_in();		
			if($login_type == "signup"){
				//first timer. let the user fill out details
				$this->signup();
			}else if($login_type == "signin"){

				//sign in the user, and set session values
				$details = $this->user_model->get_user_details();
				$role = $this->user_model->get_role($details['facebook_uid']);

				$this->session->set_userdata(array(
					'facebook_uid' => $details['facebook_uid'], 
					'fb_name' => $details['username'],
					'is_logged_in' => TRUE,
					'role' => $role
				));

				redirect(base_url(), 'location');
			}else{
				//0 was returned. could be some error with Facebook API
				//return to home page, and let the user try logging in again, after logging out
				$this->auth->logout();
			}
		}else{
			//redirect to Facebook to authenticate
			redirect($this->facebook->getLoginURL($this->config->item('facebook_login_parameters'), 'location'));
		}
	}
	
	public function signup() {
		//check if signup form was submitted
		if($this->input->post('signup') == "true"){
			
			$this->load->model('user_model');
			//NOTE: form validation to come up here

			//Enter details into database
			$signup = $this->user_model->signup(array(
				'college' => $this->input->post('college'),
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email')
			));

			if($signup){
				//data successfully added to database
				$details = $this->user_model->get_user_details();
				
				$role = $this->user_model->get_role($details['facebook_uid']);

				$this->session->set_userdata(array(
					'facebook_uid' => $details['facebook_uid'], 
					'fb_name' => $details['username'],
					'is_logged_in' => TRUE,
					'role' => $role
				));
			}else{
				//there was a problem logging in.
				//send flash_message
				redirect(base_url(), 'location');
			}

			redirect(base_url(), 'location');
		}else{
			//display signup form
			$data['page'] = 'signup';
			$this->load->view('template', $data);
		}
	}

	public function logout() {
		//log out user
		//function is inside the library folder
		$this->auth->logout();
	}

	public function answer(){
		//Function to verify answer
		//This works using both ajax, or direct post.
		$answer = $this->input->get_post('answer');
		$type = $this->input->get_post('type');
		$image = '';

		$this->load->model('levels_model');
		$result = $this->levels_model->check_answer($answer);
		//Result is true or false, from model.

		//return json if ajax
		//ajax answer checking has not been implemented yet.
		// if($type=='ajax'){
		// 	echo json_encode(array('result' => $result));
		// 	exit;
		// }

		if($result){
			$image = $this->levels_model->get_success_img();
		}

		// If not ajax, display user friendly page.
		$data['image'] = $image;
		$data['result'] = $result;
		$data['page'] = 'answer';
		$this->load->view('template', $data);
	}

	public function leaderboard(){
		$this->load->model('status_model');
		$leaderboard = $this->status_model->get_leaderboard();

		$data['page'] = 'leaderboard';
		$data['leaderboard'] = $leaderboard;
		$data['header_data'] = array('title' => 'Leaderboard');
		$this->load->view('template',$data);
	}

	public function winners(){
		// Winners is a static page at the moment
		// $this->load->model('status_model');
		// $winners = $this->status_model->get_winners();
		// $data['winners'] = $winners;

		$data['page'] = 'winners';
		$data['header_data'] = array('title' => 'Winners');
		$this->load->view('template',$data);

	}

	public function rules(){
		$data['page'] = 'rules';
		$data['header_data'] = array('title' => 'Rules');
		$this->load->view('template',$data);
	}

	public function profile(){

		//check if there's anything after /profile/
		$chapter=$this->uri->segment(2, 0);

		//used to jump user to next chapter (Level 21, in this case)
		//this was used to encourage late registrations
		//you can comment out this code to disable the feature
		if($chapter==='nextchapter'){
			$this->load->model('user_model');
			$this->user_model->chapter2();
			redirect(base_url(), 'location');
		}

		$this->load->model('user_model');
		$user = $this->user_model->read_user();

		$data['page'] = 'profile';
		$data['header_data'] = array('title' => 'Your Profile');
		$data['user'] = $user;

		$this->load->view('template',$data);
	}

	public function levels(){
		//controller to display level images safely.
		$file=$this->uri->segment(2, 0);

		//Send a Not Modified header if broswer requests it
		//This prevents reloading of images on each refresh
		//as pictures are served using php.
		if (file_exists('./assets/levels/'.$file) && isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		{
		    header('HTTP/1.0 304 Not Modified');
		    header("Cache-Control: max-age=12096000, public");
		    header("Expires: Sat, 26 Jul 2015 05:00:00 GMT");
		    header("Pragma: cache");
		    exit;
		}

		//only images starting with level_ and finish_ are used
		preg_match('/(?P<type>finish_|level_)(?P<level>[0-9]*)_?(.*)\.jpg/', $file, $read);
		
		if(!array_key_exists('level', $read)){
			header('HTTP/1.0 404 Not Found');
			include("assets/php/404.php");
			return;
		}

		if(!array_key_exists('type', $read)){
			header('HTTP/1.0 404 Not Found');
			include("assets/php/404.php");
			return;
		}

		$level = $read['level'];
		$type = $read['type'];

		$this->load->model('user_model');
		$current_level = $this->user_model->get_level();

		if($type=='finish_'){
			//finish image for the previous level is required
			//because user will have moved to the next level when answer is correct
			$current_level--;
		}

		if($current_level==$level){
			//show images only if current level is same as requested
			if(!file_exists('./assets/levels/'.$file))
			{
				header('HTTP/1.0 404 Not Found');
				include("assets/php/404.php");
				return;
			}else{
				//serve image with appropriate headers
				header("Content-type: image/jpeg");
				header("Cache-Control: max-age=12096000, public");
				header("Expires: Sat, 26 Jul 2015 05:00:00 GMT");
				header("Pragma: cache");
				echo file_get_contents('assets/levels/'.$file);
			}
		}else{
			//visitor is trying to view levels other than current level
			//show forbidden page
			header('HTTP/1.0 403 Forbidden');
			include("assets/php/403.php");
			return;
		}

	}

}