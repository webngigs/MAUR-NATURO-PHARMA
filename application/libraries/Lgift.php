<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lgift {
	//Retrieve  gift List	DONE
	public function gift_list() {
        $CI =& get_instance();
        $CI->load->model('Gifts');
		$CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $gift_info 				=	$CI->Gifts->retrieve_gift();
        $data['total_customer']	= 	$CI->Gifts->count_gift();
        $data['title']          = 	display('manage_gift');
        $data['company_info']   = 	$gift_info;

		$InvoiceDetails = $CI->Invoices->__getTotalAmountOfInvoices();
		$data['totalInvoiceAmount'] 	= 	$InvoiceDetails['totalInvoiceAmount'];
		$data['ClaimedInvoiceAmount'] 	= 	$InvoiceDetails['ClaimedInvoiceAmount'];
		$data['TobeClaimInvoiceAmount'] =	$InvoiceDetails['TobeClaimInvoiceAmount'];

        $giftList = $CI->parser->parse('gift/gift', $data, true);
        return $giftList;
    }

	public function gift_request_list(){
		$CI =& get_instance();
        $CI->load->model('Gifts');
		$CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $gift_info = $CI->Gifts->retrieve_gift_request();
        $data['total_customer']    =	$CI->Gifts->count_gift();
        $data['title']             = 	display('gift_request');
        $data['company_info']      = 	$gift_info;

		$InvoiceDetails = $CI->Invoices->__getTotalAmountOfInvoices();
		$data['totalInvoiceAmount'] 	= 	number_format($InvoiceDetails['totalInvoiceAmount']);
		$data['ClaimedInvoiceAmount'] 	= 	number_format($InvoiceDetails['ClaimedInvoiceAmount']);
		$data['TobeClaimInvoiceAmount'] =	number_format($InvoiceDetails['TobeClaimInvoiceAmount']);

        $giftList = $CI->parser->parse('gift/gift_request', $data,true);
        return $giftList;	
	}
	
	//Retrieve  gift Search List DONE	
	public function gift_search_item($gift_id)
	{
		$CI =& get_instance();
		$CI->load->model('Gifts');
		$CI->load->model('Web_settings');
		$gift_list 		= 	$CI->Gifts->gift_search_item($gift_id);
		$all_gift_list 	= 	$CI->Gifts->all_gift_list();  
		$i=0;
		$total=0;
		if($gift_list) {
			foreach($gift_list as $k=>$v) {
				$i++;
				$gift_list[$k]['sl']=$i;
				$gift_info = $CI->db->select('*')->from('gifts')->where('gift_id', $gift_list[$k]['gift_id'])->get()->row();
				$gift_list[$k]['gift_name']		=	$gift_info->gift_name;
			
			}
			$data = array(
				'title' 	       => 	display('manage_gift'),
				'subtotal'	       =>	number_format($total, 2, '.', ','),
				'all_customer_list'=>	$all_gift_list,
				'links'		       =>	"",
				'gift_list'   		=> 	$gift_list
			);
			$giftList = $CI->parser->parse('gift/gift', $data, true);
			return $giftList;
		}
		else{
			redirect('Cgift/manage_gift');
		}
	}	

	//Sub gift Add DONE
	public function gift_add_form(){
		$CI =& get_instance();
		$CI->load->model('Gifts');
		$data = array(
			'title' => display('add_gift')
		);
		$customerForm = $CI->parser->parse('gift/add_gift_form', $data,true);
		return $customerForm;
	}
	//	INSERT gift DONE
	public function insert_gift($data)
	{
		$CI = & get_instance();
		$CI->load->model('Gifts');
        $CI->Gifts->gift_entry($data);
		return true;
	}
	
	//gift Edit Data DONE 
	public function gift_edit_data($id)
	{
		
		$CI =& get_instance();
		$CI->load->model('Gifts');
		
		
		$gift_detail = $CI->Gifts->retrieve_gift_editdata($id);
		$data	=	array(
			'title' 		=> 	display('gift_edit'),
			'id' 	    => 	$gift_detail[0]['id'],
			'name'     	=> 	$gift_detail[0]['name'],
			'amount' 	=> 	$gift_detail[0]['amount'],
			'mintarget' 		=> 	$gift_detail[0]['mintarget'],
			'maxtarget'	=>	$gift_detail[0]['maxtarget'],
			'photo'	=>	$gift_detail[0]['photo'],
		);
		$giftList = $CI->parser->parse('gift/edit_gift_form', $data, true);
		return $giftList;
	}
}
?>