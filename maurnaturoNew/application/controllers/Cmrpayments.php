<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cmrpayments extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lmrpayments');
		$this->load->library('session');
		$this->load->model('Mrpaymment');
		$this->auth->check_admin_auth();
    }

    public function index()
	{
		$content = $this->lmrpayments->payment_add_form();
		$this->template->full_admin_html_view($content);
	}

    public function manage_mr_payment(){
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lmrpayments');
        $CI->load->model('Mrpaymment');
        $content =$this->lmrpayments->payment_list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckPaymentList(){        
        $this->load->model('Mrpaymment');
        $postData = $this->input->post();
        $data = $this->Mrpaymment->getPaymentList($postData);
        echo json_encode($data);
    }
    
    public function insert_payment()
	{
        $postData = $this->input->post();

		$mr_id = $this->session->userdata('user_id');
		if(isset($postData['mr_id']) && $postData['mr_id']>0)	$mr_id = $postData['mr_id'];

        $data=array(
            'mr_id'         =>  $mr_id,
			'title' 		=> 	$postData['title'],
			'description' 	=> 	$postData['description'],
			'amount' 	    => 	$postData['amount'],
			'payment_type'	=> 	$postData['payment_type'],
            'payment_date'  =>  $postData['payment_date']			
		);
		$this->db->insert('mrpaymments', $data);
		
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($postData['add_payment'])){
			redirect(base_url('Cmrpayments/manage_mr_payment'));
			exit;
		}
		elseif(isset($postData['add_payment_another'])){
			redirect(base_url('Cmrpayments'));
			exit;
		}		
	}
    
}