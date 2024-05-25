<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cexpenses extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lexpenses');
		$this->load->library('session');
		$this->load->model('Expenses');
		$this->auth->check_admin_auth();
    }

    public function index()
	{
		$content = $this->lexpenses->expenses_add_form();
		$this->template->full_admin_html_view($content);
	}

    public function manage_expenses(){
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lexpenses');
        $CI->load->model('Expenses');
        $content =$this->lexpenses->expenses_list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckExpensesList(){        
        $this->load->model('Expenses');
        $postData = $this->input->post();
        $data = $this->Expenses->getExpensesList($postData);
        echo json_encode($data);
    }
    
    public function insert_expenses()
	{
        $postData = $this->input->post();
		$mr_id = $this->session->userdata('user_id');
		if(isset($postData['mr_id']) && $postData['mr_id']>0)	$mr_id = $postData['mr_id'];

        $data = array(
            'mr_id'         =>  $mr_id,
			'title' 		=> 	$postData['title'],
			'description' 	=> 	$postData['description'],
			'amount' 	    => 	$postData['amount'],
            'expenses_date'	=>  $postData['expenses_date']			
		);
		$this->db->insert('expenses', $data);
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($postData['add_expenses'])){
			redirect(base_url('Cexpenses/manage_expenses'));
			exit;
		}
		elseif(isset($postData['add_expenses_another'])){
			redirect(base_url('Cexpenses'));
			exit;
		}		
	}  
	
	public function expenses_approve($id){
		$data = array(
            'expenses_status' => 'Approved'			
		);
		$this->db->where('id', $id);
		$this->db->update('expenses', $data);

		$this->session->set_userdata(array('message'=>'Expenses Successfully Approved'));
		redirect(base_url('Cexpenses/manage_expenses'));
		exit;
	}

	public function expenses_rejected($id){
		$data = array(
            'expenses_status' => 'Rejected'			
		);
		$this->db->where('id', $id);
		$this->db->update('expenses', $data);

		$this->session->set_userdata(array('message'=>'Expenses Successfully Approved'));
		redirect(base_url('Cexpenses/manage_expenses'));
		exit;
	}
}