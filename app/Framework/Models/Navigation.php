<?php

namespace Framework\Models;

use Framework\Core\DB;

class Navigation {

	private $db;
	private $table = 'cms_navigation';

	public function __construct(DB $db){
		$this->db = $db;
	}

	public function create($fields = array()){
		if (!$this->db->insert($this->table, $fields)) {
			return false;
		}
		return true;
	}

	public function read($nav_id = null){
		if (null !== $nav_id) {
			return $this->db->get(['*'],$this->table,[['id','=',$nav_id]])->first();
		} else {
			return $this->db->get(['*'],$this->table)->results();
		}
	}

	public function update($nav_id, $fields = array()){
		if (!$this->db->update($this->table, $nav_id, $fields)) {
			return false;
		}
		return true;
	}

	public function delete($nav_id){}

}