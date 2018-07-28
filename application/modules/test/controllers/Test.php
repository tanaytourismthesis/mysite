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
		
		$data['response'] = FALSE;
		
		if ($title === NULL) {
			throw new Exception("Invalid parameter");
		}
		
		try {
			$result = $this->news_model->load_news_list($title);
			
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
}
