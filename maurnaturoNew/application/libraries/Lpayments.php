<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lpayments {
    public function payment_add_form(){
		$CI =& get_instance();
		$CI->load->model('Paymment');

		$CI->load->model('Targets');
		$all_mr = $CI->Targets->select_all_mr();

		$data = array(
			'title' => display('add_payment'),
			'all_mr'	=>	$all_mr
		);
		$addForm = $CI->parser->parse('payments/add_payment_form', $data,true);
		return $addForm;
	}

    public function payment_edit_data($id)
	{		
		$CI =& get_instance();
		$CI->load->model('Paymment');
		
		$payment_detail = $CI->Paymment->retrieve_payment_editdata($id);
		$data	=	array(
			'title' 	        => 	display('payment_edit'),
			'id' 	            => 	$payment_detail[0]['id'],
			'name'     	        => 	$payment_detail[0]['name'],
			'amount' 	        => 	$payment_detail[0]['amount'],
			'payment_type'      => 	$payment_detail[0]['payment_type'],
			'payment_status'    =>	$payment_detail[0]['payment_status'],
			'payment_date'	    =>	$payment_detail[0]['payment_date'],
		);
		$paymentList = $CI->parser->parse('payments/edit_payment_form', $data, true);
		return $paymentList;
	}

    public function payment_list() {
        $CI =& get_instance();
        $CI->load->model('Paymment');
        $CI->load->model('Web_settings');
        $payment_info 			=	$CI->Paymment->retrieve_payment();
        $data['total_customer']	= 	$CI->Paymment->count_payment();
        $data['title']          = 	display('manage_payment');
        $data['company_info']   = 	$payment_info;
        $paymentList = $CI->parser->parse('payments/payment', $data, true);
        return $paymentList;
    }
}