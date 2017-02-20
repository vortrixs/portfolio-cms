<?php

namespace Framework\Models;

use Framework\Core\DB;

class Category {

	private $db;
	private $table = 'cms_categories';

	public function __construct(DB $db){
		$this->db = $db;
	}

	public function create($fields){
		if (!$this->db->insert($this->table, $fields)) {
			return false;
		}
		return true;
	}

	public function read($category_id = null){
		if (null !== $category_id) {
			return $this->db->get(['*'],$this->table,[['id','=',$category_id]])->first();
		} else {
			return $this->db->get(['*'],$this->table)->results();
		}
	}

	public function update($category_id, $fields){
		if (!$this->db->update($this->table, $category_id, $fields)) {
			return false;
		}
		return true;
	}

	public function delete($category_id){}

}