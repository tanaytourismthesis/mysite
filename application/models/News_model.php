<?php
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class News_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('query');
	}
	
	public function load_news_list($title = '', $start = 0, $limit = 5)
	{
		
		return $this->query->select(
				array(
					'table' => 'news',
					'fields' => 'id,title,dateposted',
					'conditions' => array (
						'like' => array(
							'title' => $title
						)
					),
					'start' => $start,
					'limit' => $limit
				)
			);
			
	}
	
  public function get_total_records($title = '')
  {
    return $this->query->select(
				array(
					'table' => 'news',
					'fields' => 'id,title,dateposted',
					'conditions' => array (
						'like' => array(
							'title' => $title
						)
					)
				),
        false,
        true
          
			);
  }
}

