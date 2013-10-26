<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class nimda extends CI_Controller {

	function __construct() {
		parent::__construct();

		//admin controller
		//available only if role is >1

		$this->auth->confirm_user();
		$this->load->model('user_model');
		
		$role = $this->user_model->get_role();

		if($role<2){
			redirect('/','location');
		}
	}

	public function index()
	{
		//show basic statistics
		$this->load->model('admin_model');
		$stats = $this->admin_model->get_stats();

		$data['details'] = $stats;
		$data['page'] = 'nimda/home';
		$data['header_data'] = array('title' => 'Clueless Admin Panel');
		$this->load->view('template', $data);	
	}

	public function levels(){
		//read uri segments, and call appropriate functions
		$page_type = $this->uri->segment(3, 0);

		if($page_type==="add_level"){

			if($this->input->post('add_level')!='true'){	
				$data['page'] = 'nimda/add_level';
				$data['header_data'] = array('title' => 'Add Level - Clueless');
				$this->load->view('template', $data);
				return;	
			}

			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('answer', 'Answer', 'required');
			$this->form_validation->set_rules('level', 'Level', 'required|numeric');

			if ($this->form_validation->run() == FALSE)
			{
				$data['page'] = 'nimda/add_level';
				$data['header_data'] = array('title' => 'Add Level - Clueless');
				$this->load->view('template', $data);
				return;
			}

			//now, everything is okay. upload images, if selected, and add to database.

			$level = $this->input->post('level');
			$this->load->library('upload');

			$img_level = 0;
			$img_finish = 0;

			if (!empty($_FILES['content_image']['name'])) {
				$level_config = array(
					'upload_path' => './assets/levels/',
					'allowed_types' => 'jpg',
					'max_size' => '1024',
					'max_width' => '1000',
					'max_height' => '1000',
					'file_name' => 'level_'.$level.'.jpg',
					'overwrite' => TRUE
					);

				$this->upload->initialize($level_config);

				if (!$this->upload->do_upload('content_image') ){
					$error = $this->upload->display_errors();

					$data['page'] = 'nimda/add_level';
					$data['header_data'] = array('title' => 'Add Level - Clueless');
					$data['upload_error']= '<strong>Level Image:</strong>'.$error;
					$this->load->view('template', $data);
					return;

				}else{
					$data = array('upload_data' => $this->upload->data());
					$img_data = $this->upload->data();
					$img_level = $img_data['orig_name'];
				}
			}//end upload code for content_image


			//check if there's finish image selected
			if (!empty($_FILES['finish_image']['name'])) {
				$level_config = array(
					'upload_path' => './assets/levels/',
					'allowed_types' => 'jpg',
					'max_size' => '1024',
					'max_width' => '1000',
					'max_height' => '1000',
					'file_name' => 'finish_'.$level.'.jpg',
					'overwrite' => TRUE
					);

				$this->upload->initialize($level_config);

				if (!$this->upload->do_upload('finish_image') ){
					$error = $this->upload->display_errors();

					$data['page'] = 'nimda/add_level';
					$data['header_data'] = array('title' => 'Add Level - Clueless');
					$data['upload_error']= '<strong>Level Finish Image:</strong>'.$error;
					$this->load->view('template', $data);

					return;
				}else{
					$img_data = $this->upload->data();
					$img_finish = $img_data['orig_name'];
				}
			}//end upload code for content_image

			//add to database

			//Set content appropriately.
			if($img_level){
				if($this->input->post('content_text')!=''){
					$content = $this->input->post('content_text').'<br><br><img src="/levels/'.$img_level.'"/>';
				}else{
					$content = '<img src="/levels/'.$img_level.'"/>';
				}
			}else{
				$content = '<br><br><br>'.$this->input->post('content_text');
			}

			if($img_finish){
				$finish = $img_finish;
			}else{
				$finish = NULL;
			}

			$full_details = array(
				'level' => $this->input->post('level'),
				'title' => $this->input->post('title'),
				'difficulty' => $this->input->post('difficulty'),
				'content' => $content, //add text and image
				'answer' => md5($this->input->post('answer')),
				'placeholder' => $this->input->post('placeholder'),
				'html_comment' => $this->input->post('html_comment'),
				'success_image' => $finish,
				'background' => NULL,
				'cookie' => NULL,
				'javascript' => NULL,
				'status' => 0
			);

			$this->load->model('admin_model');

			if($this->admin_model->add_level($full_details)){
				//successfully added
				redirect('/nimda/levels','location');
			}else{
				$data['page'] = 'error';
				$data['header_data'] = array('title' => 'Error when adding levels');
				$this->load->view('template', $data);
			}
		
		//end add_level function
		}else if($page_type==="status"){
			//change level status (active/deactive)

			$level = $this->input->get('level');
			$status = $this->input->get('now');
			
			if($status==1){
				$status=0;
			}else{
				$status=1;
			}


			$this->load->model('admin_model');
			$this->admin_model->set_status($level,$status);

			redirect('/nimda/levels','location');
		}else if($page_type==="set_user"){
			//set current admins level for debugging
			$this->load->model('admin_model');
			$this->admin_model->set_admin_level($this->input->post('level'));
			redirect('/nimda/levels','location');
		}else{
			//Manage Levels page.
			$this->load->model('admin_model');
			$levels = $this->admin_model->get_all_levels();

			$data['page'] = 'nimda/levels';
			$data['levels'] = $levels;
			$data['current_level'] = $this->admin_model->get_admin_level();
			$data['header_data'] = array('title' => 'Manage Levels - Clueless');
			$this->load->view('template', $data);
		}
	}

	public function users(){

		$this->load->model('admin_model');
		$post_username = $this->input->get_post('fb_username');

		//post_username has user's fb_uid when
		//answer log is requested
		if($post_username=='')
		{
			$users = $this->admin_model->get_users();

			$data['users'] = $users;

			$data['page'] = 'nimda/users';
			$data['header_data'] = array('title' => 'All Users - Clueless');
			$this->load->view('template', $data);	
		}else{
			//show default users page with details of all users
			$user_log = $this->admin_model->get_log($post_username);
			$data['user_log'] = $user_log;

			$data['page'] = 'nimda/user_log';
			$data['header_data'] = array('title' => 'Log for '.$post_username);
			$this->load->view('template', $data);	
		}
	}

}