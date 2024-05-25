<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cgst extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lgst');
		$this->load->library('session');
		$this->auth->check_admin_auth();
    }

	//Default loading for gift System. DONE
	public function index()
	{
		$content = $this->lgst->list();
		$this->template->full_admin_html_view($content);
	}

	public function downloadgst(){
		$this->load->model('Gst');
		$this->Gst->getList();
	}
}