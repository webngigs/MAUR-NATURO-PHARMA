<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csalary extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lsalary');
		$this->load->library('session');
		$this->load->model('Salaries');
		$this->auth->check_admin_auth();
    }

    public function index()
	{
		$content = $this->lsalary->add_form();
		$this->template->full_admin_html_view($content);
	}

    public function manage_salary(){
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lsalary');
        $CI->load->model('Salaries');
        $content =$this->lsalary->list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckSalaryList(){        
        $this->load->model('Salaries');
        $postData = $this->input->post();
        $data = $this->Salaries->getList($postData);
        echo json_encode($data);
    }
    
    public function insert_salary()
	{
        $postData = $this->input->post();
        
		$data=array(
            'mr_id'         =>  $postData['mr_id'],
			'title' 		=> 	$postData['title'],
			'description' 	=> 	$postData['description'],
			'amount' 	    => 	$postData['amount'],
            'salary_date'  =>  $postData['salary_date']			
		);
		$this->db->insert('salaries', $data);
		
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($postData['add_salary'])){
			redirect(base_url('Csalary/manage_salary'));
			exit;
		}
		elseif(isset($postData['add_salary_another'])){
			redirect(base_url('Csalary'));
			exit;
		}		
	}    
}