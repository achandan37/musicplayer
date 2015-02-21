<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->output->enable_profiler();
	}

	public function index()
	{
		$this->load->model('songs');
		$allsongs=$this->songs->GetSongs();
		$this->load->view('backup',array('allsongs'=>$allsongs));
		$this->load->view('playlist',array('allsongs'=>$allsongs));

	}

	public function getsongs()
	{
		$this->load->model('songs');
		$allsongs=$this->songs->GetSongs();
		// shuffle($allsongs);
		echo json_encode($allsongs);
		// $this->session->set_userdata('allsongs', $allsongs);
		
	}
}

//end of main controller