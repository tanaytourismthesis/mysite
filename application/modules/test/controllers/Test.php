<?php
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Test extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
	}

	public function index(){
		$data = [];
		
		$this->template->build_template(
			'Test Lang', //Page Title
			array( // Views
				array(
					'view' => 'test',
					'data' => $data
				)
			),
			array( // JavaScript Files
				"assets/jquery-3.2.1.min.js",
				"assets/script.js"
			),
			array( // CSS Files
				
			),
			array( // Meta Tags
				
			),
			'mysite' // template page
		);
	}
	
	public function load_news() {
		$title = $this->input->post('title') ?? NULL;
		$limit = $this->input->post('limit') ?? NULL;
		$start = $this->input->post('start') ?? NULL;
		
		$data['response'] = FALSE;
		
		if ($title === NULL) {
			throw new Exception("Invalid parameter");
		}
		
		try {
			$result = $this->news_model->load_news_list($title,$start,$limit);
			
			if (!empty($result)) {
				$data['data'] = $result;
				$data['response'] = TRUE;
			}
			
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}
		
		header( 'Content-Type: application/x-json' );
		echo json_encode( $data );
	}
  
  public function get_total_pages()
  {
    $title = $this->input->post('title') ?? NULL;
    $data['response'] = FALSE; 
    
    if ($title === NULL) {
			throw new Exception("Invalid parameter");
		}
    
    try {
      $result = $this->news_model->get_total_records($title);
			$data['response'] = TRUE;
			$data['data'] = $result;
    }
		catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}
		header( 'Content-Type: application/x-json' );
		echo json_encode( $data );
  }
	
	public function add_news()
	{
		$data['response'] = FALSE;
		$data['message'] = 'Please check required fields or check your network connection.';
		
		$newstitle = $this->input->post('newstitle');
		if($newstitle === NULL){
			throw new Exception("Invalid parameter");
		}
		
		try {
			$res = $this->news_model->add_new_news($newstitle);
				
			if ($res === TRUE)
			{
				$data['response'] = TRUE;
				$data['message'] = 'Successfully added new article.';
			}
		}
		catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}
		
		header( 'Content-Type: application/x-json' );
		echo json_encode( $data );
	}
	
	public function get_news($id = NULL)
	{
		$data['response'] = FALSE;
		$data['message'] = 'Something Went Wrong!.';
		
		if ($id === NULL) {
			throw new Exception("Invalid parameter");
		}
		
		try {
			$result = $this->news_model->get_news($id);
			
			if (!empty($result)) {
				$data['data'] = $result;
				$data['response'] = TRUE;
				$data['message'] = 'Success!';
			}
			
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}
		
		header( 'Content-Type: application/x-json' );
		echo json_encode( $data );
	}
	
	public function update_news()
	{
		$newstitlenews = $this->input->post('newstitlenews');
		$id = $this->input->post('id');
			
		$data['response'] = FALSE;
		$data['message'] = 'Something Went Wrong!.';
			
		if(empty($id) || empty($newstitlenews)){
			throw new Exception("Invalid parameter");
		}
		try {		
			$result = $this->news_model->update_news($id,$newstitlenews);
			
			if (!empty($result)) {
				$data['data'] = $result;
				$data['response'] = TRUE;
				$data['message'] = 'Success!';
			}
			
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}
		
		header( 'Content-Type: application/x-json' );
		echo json_encode( $data );
	}
}
