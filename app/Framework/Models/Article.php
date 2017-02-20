<?php

namespace Framework\Models;

use Framework\Core\DB;

class Article {

	private $db;
	private $table = 'cms_articles';

	public function __construct(DB $db){
		$this->db = $db;
		return $this;
	}

	public function create($fields = array()){
		if (!$this->db->insert($this->table, $fields)) {
			return false;
		}
		return true;
	}

	public function read($article_id = null){
		if (null !== $article_id) {
			return $this->db->get(['*'],$this->table,[['id','=',$article_id]])->first();
		} else {
			return $this->db->get(['*'],$this->table)->results();
		}
	}

	public function update($article_id, $fields = array()){
		if (!$this->db->update($this->table, $article_id, $fields)) {
			return false;
		}
		return true;
	}

	public function delete($article_id){

	}

}