<?php

namespace Framework\Models;

use Framework\Core\DB;

class Image {

	private $db;
	private $table = 'cms_images';
	private $path = 'assets/img/uploads/';

	public function __construct(DB $db){
		$this->db = $db;
	}

	public function create($temp_filename, $category){
		$filename = md5($temp_filename);
		move_uploaded_file($temp_filename, $this->path . $filename);
		if (!$this->db->insert($this->table, ['image' => $filename, 'category' => $category])) {
			throw new Exception('<p>An error occured. Try again or <a href="contact">contact us<a> if you keep getting this message.</p>');
		}
	}

	public function read($category = null){
		# return image id and filename
	}

	public function delete($filename, $image_id){
		# delete image from db via id
		# delete image from server with unlink($path . $filename)
	}

}