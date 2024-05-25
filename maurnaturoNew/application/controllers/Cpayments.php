<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cpayments extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lpayments');
		$this->load->library('session');
		$this->load->model('Paymment');
		$this->auth->check_admin_auth();
    }

    public function index()
	{
		$content = $this->lpayments->payment_add_form();
		$this->template->full_admin_html_view($content);
	}

    public function manage_payment(){
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lpayments');
        $CI->load->model('Paymment');
        $content =$this->lpayments->payment_list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckPaymentList(){        
        $this->load->model('Paymment');
        $postData = $this->input->post();
        $data = $this->Paymment->getPaymentList($postData);
        echo json_encode($data);
    }

	public function ___getMrIdByLoggedUserId(){
		$this->db->select("mr_id");
        $this->db->from('mr_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		else return 0;
	}
    
    public function insert_payment()
	{
        $postData = $this->input->post();
		
		$dataSet = [];
		if(empty($postData['customer_id'])){
			$this->session->set_userdata(array('error_message'=>'Please Select Customer'));
			redirect(base_url('Cpayments'));
		}
		else{
			$mr_id = 0;
			$this->db->select('user_id');
			$this->db->from('customer_information');
			$this->db->where('customer_id', $postData['customer_id']);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();
				$result_array = $this->___getMrIdByLoggedUserId($dts[0]['user_id']);
				if(isset($result_array[0]['mr_id']))	$mr_id = $result_array[0]['mr_id'];

				$dataSet['customer_id']	=	$postData['customer_id'];
				$dataSet['mr_user_id'] 	=	$dts[0]['user_id'];
				$dataSet['mr_id'] 		=	$mr_id;				
			}
		}

        $data=array(
			'customer_id'	=>	$postData['customer_id'],
			'customer_name'	=>	$postData['customer_name'],
            'mr_id'         =>  $mr_id,
			'title' 		=> 	$postData['title'],
			'description' 	=> 	$postData['description'],
			'amount' 	    => 	$postData['amount'],
			'payment_type'	=> 	$postData['payment_type'],
            'payment_date'  =>  $postData['payment_date']			
		);

		$this->db->insert('paymments', $data);
		$payment_id = $this->db->insert_id();
		$dataSet['payment_id'] 		=	$payment_id;
		$this->__adjustPaymentInInvoice($dataSet);
		
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add_payment'])){
			redirect(base_url('Cpayments/manage_payment'));
			exit;
		}
		elseif(isset($_POST['add_payment_another'])){
			redirect(base_url('Cpayments'));
			exit;
		}		
	}
    
	public function __adjustPaymentInInvoice($dataSet){
		if($dataSet['payment_id']>0){
			$this->db->select("*");
			$this->db->from('paymments');
			$this->db->where('id', $dataSet['payment_id']);
			$query = $this->db->get();
			if($query->num_rows()>0){
				$paymentData = $query->result_array();
				$paymentReceivedAmount = $paymentData[0]['amount'];
				$this->___getNotFullyAdjustInvoice($dataSet, $paymentReceivedAmount);
			}		
		}
	}

	public function ___getNotFullyAdjustInvoice($dataSet, $paymentReceivedAmount){
		$this->db->select("*");
		$this->db->from('invoice');
		$this->db->where('customer_id', $dataSet['customer_id']);
		$this->db->where('mr_id', $dataSet['mr_user_id']);
		$this->db->where('is_fully_adjust', 0);
		$this->db->where('type_of_invoice', 1);
		$this->db->where('total_amount >',  0);
		
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$invoices = $query->result_array();	
			if(isset($invoices) && count($invoices)>0){
				$adjustmentAmount = $paymentReceivedAmount;
				foreach($invoices as $invoice){
					if(isset($invoice['total_amount']) && $invoice['total_amount']>0){
						$dueAmountToAdjust = $invoice['total_amount'] - $invoice['adjust_amount'];
						if($dueAmountToAdjust<=$adjustmentAmount){
							$is_fully_adjust 	= 	1;
							$invoice_amount 	= 	$dueAmountToAdjust;
							$adjustmentAmount 	= 	$adjustmentAmount - $invoice_amount;
						}
						else if($dueAmountToAdjust>$adjustmentAmount){
							$is_fully_adjust 	= 	0;
							$invoice_amount 	= 	$adjustmentAmount;
							$adjustmentAmount 	= 	$adjustmentAmount - $dueAmountToAdjust;
						}
						
						$invoice_id 	=	$invoice['id'];
						$adjustAmount	= 	$invoice['adjust_amount'] + $invoice_amount;

						$this->db->query("UPDATE `invoice` SET `adjust_amount` = '$adjustAmount', `is_fully_adjust` = '$is_fully_adjust' WHERE `id`='$invoice_id'");
						if($adjustmentAmount<=0)	break;
					}	
				}
			}
		}
	}
}