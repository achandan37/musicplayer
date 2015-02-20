<?php 

class Songs extends CI_Model {

	public function GetSongs(){
		$query="SELECT * FROM song";
		return $this->db->query($query)->result_array();
	}

}