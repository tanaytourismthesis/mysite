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
					'order' => 'dateposted DESC',
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
	
	public function add_new_news($newstitle)
	{
		$slug = "Wow";
		$content = "Isa kang alamat dall";
		$count = 4;
		$time = 5;
		$hits = 6;
		$authorid = 1;
		return $this->query->insert('news',
			array(
				'title' => $newstitle,
				'slug' =>  $slug,
				'text_content' => $content,
				'word_count' => $count,
				'reading_time' => $time,
				'dateposted' => date('Y-m-d H:i:s'),
				'num_hits' => $hits,
				'authorID' => $authorid		
			)
		);
	}
}

