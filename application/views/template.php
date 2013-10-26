<?php

if(!isset($header_data))
{ 
	$header_data = array(
	'title' => 'Online Treasure Hunt'
	);
}

//load header, page and footer views
$this->load->view('includes/header',$header_data);
$this->load->view('pages/'.$page);
$this->load->view('includes/footer');