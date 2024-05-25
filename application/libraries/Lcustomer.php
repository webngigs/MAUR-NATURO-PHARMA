<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcustomer {

	//Retrieve  Customer List	
	 public function customer_list() {
        $CI =& get_instance();
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $company_info = $CI->Customers->retrieve_company();
        $data['total_customer']    = $CI->Customers->count_customer();
        $data['title']             = display('manage_customer');
        $data['company_info']      = $company_info;
        $customerList = $CI->parser->parse('customer/customer',$data,true);
        return $customerList;
    }

    //Retrieve  Credit Customer List	
    public function credit_customer_list() {
        $CI = & get_instance();
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $company_info = $CI->Customers->retrieve_company();
        $data['company_info']   = $company_info;
        $data['total_customer'] = $CI->Customers->count_credit_customer();
        $customerList = $CI->parser->parse('customer/credit_customer', $data, true);
        return $customerList;
    }

    //##################  Paid  Customer List  ##########################	
    public function paid_customer_list() {
        $CI = & get_instance();
        $CI->load->model('Customers');
        $CI->load->model('Web_settings');
        $company_info = $CI->Customers->retrieve_company();
        $data['total_customer'] = $CI->Customers->count_paid_customer();
        $data['company_info']   = $company_info;
        $customerList = $CI->parser->parse('customer/paid_customer', $data, true);
        return $customerList;
    }

	
	//Retrieve  Customer Search List	
	public function customer_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$CI->load->model('Web_settings');
		$customers_list = $CI->Customers->customer_search_item($customer_id);
		$all_customer_list = $CI->Customers->all_customer_list();  
		$i=0;
		$total=0;
		if ($customers_list) {
			foreach($customers_list as $k=>$v)
			{
				$i++;
           		$customers_list[$k]['sl']=$i;
		    	 $customer_info = $CI->db->select('*')->from('customer_information')->where('customer_id',$customers_list[$k]['customer_id'])->get()->row();
			   $total+=$customers_list[$k]['customer_balance'];
			   $customers_list[$k]['customer_name']=$customer_info->customer_name;
			   $customers_list[$k]['customer_address']=$customer_info->customer_address;
			   $customers_list[$k]['customer_mobile']=$customer_info->customer_mobile;
			}
			$currency_details = $CI->Web_settings->retrieve_setting_editdata();
			$data = array(
				'title' 	       => display('manage_customer'),
				'subtotal'	       =>	number_format($total, 2, '.', ','),
				'all_customer_list'=>$all_customer_list,
				'links'		       =>	"",
				'customers_list'   => $customers_list,
				'currency' 	       => $currency_details[0]['currency'],
				'position' 	       => $currency_details[0]['currency_position'],
				);
			$customerList = $CI->parser->parse('customer/customer',$data,true);
			return $customerList;
		}else{
			redirect('Ccustomer/manage_customer');
		}
		
	}	

	//Retrieve  Credit Customer Search List	
	public function credit_customer_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$CI->load->model('Web_settings');
		$customers_list = $CI->Customers->credit_customer_search_item($customer_id);
		$all_credit_customer_list = $CI->Customers->all_credit_customer_list();

		$i=0;
		$total=0;
		if ($customers_list) {
			foreach($customers_list as $k=>$v)
			{
				$i++;
           		$customers_list[$k]['sl']=$i;
		    	 $customer_info = $CI->db->select('*')->from('customer_information')->where('customer_id',$customers_list[$k]['customer_id'])->get()->row();
			   $total+=$customers_list[$k]['customer_balance'];
			   $customers_list[$k]['customer_name']=$customer_info->customer_name;
			   $customers_list[$k]['customer_address']=$customer_info->customer_address;
			   $customers_list[$k]['customer_mobile']=$customer_info->customer_mobile;
			}
			$currency_details = $CI->Web_settings->retrieve_setting_editdata();
			$data = array(
					'title' 	=> display('manage_customer'),
					'subtotal'	=>	number_format($total, 2, '.', ','),
					'all_credit_customer_list'=>$all_credit_customer_list,
					'links'		=>	"",
					'customers_list' => $customers_list,
					'currency' => $currency_details[0]['currency'],
					'position' => $currency_details[0]['currency_position'],
				);
			$customerList = $CI->parser->parse('customer/credit_customer',$data,true);
			return $customerList;
		}else{
			redirect('Ccustomer/manage_customer');
		}
		
	}	

	//Retrieve  Paid Customer Search List	
	public function paid_customer_search_item($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$CI->load->model('Web_settings');
		$customers_list = $CI->Customers->paid_customer_search_item($customer_id);
		$all_paid_customer_list = $CI->Customers->all_paid_customer_list();
		$i=0;
		$total=0;
		if ($customers_list) {
			foreach($customers_list as $k=>$v)
			{
				$i++;
           		$customers_list[$k]['sl']=$i;
		    	$customer_info = $CI->db->select('*')->from('customer_information')->where('customer_id',$customers_list[$k]['customer_id'])->get()->row();
			   $total+=$customers_list[$k]['customer_balance'];
			   $customers_list[$k]['customer_name']=$customer_info->customer_name;
			   $customers_list[$k]['customer_address']=$customer_info->customer_address;
			   $customers_list[$k]['customer_mobile']=$customer_info->customer_mobile;
			}
			$currency_details = $CI->Web_settings->retrieve_setting_editdata();
			$data = array(
		'title' 	            => display('manage_customer'),
		'subtotal'          	=>	number_format($total, 2, '.', ','),
		'all_paid_customer_list'=>$all_paid_customer_list,
		'links'		            =>	"",
		'customers_list'        => $customers_list,
		'currency'           	=> $currency_details[0]['currency'],
		'position'          	=> $currency_details[0]['currency_position'],
				);
			$customerList = $CI->parser->parse('customer/paid_customer',$data,true);
			return $customerList;
		}else{
			redirect('Ccustomer/manage_customer');
		}
	}
	//Sub Category Add
	public function customer_add_form(){
		$CI =& get_instance();
		$CI->load->model('Customers');
		$data = array(
				'title' => display('add_customer')
			);
		$customerForm = $CI->parser->parse('customer/add_customer_form',$data,true);
		return $customerForm;
	}
	public function insert_customer($data)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
        $CI->Customers->customer_entry($data);
		return true;
	}
	
	//customer Edit Data
	public function customer_edit_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$customer_detail = $CI->Customers->retrieve_customer_editdata($customer_id);
		$data=array(
			'title' 		                => display('customer_edit'),
			'customer_id' 	                => $customer_detail[0]['customer_id'],
			'user_ref_id'                   => $customer_detail[0]['user_ref_id'],
			'customer_types'                => $customer_detail[0]['customer_types'],
			'customer_name'                 => $customer_detail[0]['customer_name'],
			'customer_address'          	=> $customer_detail[0]['customer_address'],
			'customer_mobile'           	=> $customer_detail[0]['customer_mobile'],
			'customer_email'             	=> $customer_detail[0]['customer_email'],
			'password'                      => '',
			'status' 			            => $customer_detail[0]['status'],
			'previous_balance'          	=> $customer_detail[0]['previous_balance'],
			'area'                         	=> $customer_detail[0]['area'],
			'district'                    	=> $customer_detail[0]['district'],
			'state' 	                    => $customer_detail[0]['state'],
			'state_code' 	                => $customer_detail[0]['state_code'],
			'gst_no' 	                    => $customer_detail[0]['gst_no'],
			'birthday_date' 	            => $customer_detail[0]['birthday_date'],
			'marriage_anniversary_date' 	=> $customer_detail[0]['marriage_anniversary_date'],
			'total_sale' 	                => $customer_detail[0]['total_sale'],
			'discount'           	        => $customer_detail[0]['discount'],
			'pancard'                       => $customer_detail[0]['pancard'],
			'rvc_no'                        => $customer_detail[0]['rvc_no'],
			'text'                         	=> $customer_detail[0]['text']
		);
		$chapterList = $CI->parser->parse('customer/edit_customer_form', $data, true);
		return $chapterList;
	}
	
	public function customer_change_password($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$customer_detail = $CI->Customers->retrieve_customer_editdata($customer_id);
		$data=array(
			'title' 		=>  'Change Customer Password',
			'customer_id' 	=>  $customer_detail[0]['customer_id'],
			'user_ref_id'   =>  $customer_detail[0]['user_ref_id'],
			'password'      =>  $customer_detail[0]['password'],
			'customer_name'      =>  $customer_detail[0]['customer_name'],
			'customer_email'      =>  $customer_detail[0]['customer_email'],
		);
		$chapterList = $CI->parser->parse('customer/customer_change_password_form', $data, true);
		return $chapterList;
	}
	
	public function customer_view_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$customer_detail = $CI->Customers->retrieve_customer_editdata($customer_id);
		$data=array(
			'title' 		                => 'Customer Details',
			'customer_id' 	                => $customer_detail[0]['customer_id'],
			'customer_types'                => $customer_detail[0]['customer_types'],
			'customer_name'                 => $customer_detail[0]['customer_name'],
			'customer_address'          	=> $customer_detail[0]['customer_address'],
			'customer_mobile'           	=> $customer_detail[0]['customer_mobile'],
			'customer_email'             	=> $customer_detail[0]['customer_email'],
			'password'                      => '',
			'status' 			            => $customer_detail[0]['status'],
			'previous_balance'          	=> $customer_detail[0]['previous_balance'],
			'area'                         	=> $customer_detail[0]['area'],
			'district'                    	=> $customer_detail[0]['district'],
			'state' 	                    => $customer_detail[0]['state'],
			'state_code' 	                => $customer_detail[0]['state_code'],
			'gst_no' 	                    => $customer_detail[0]['gst_no'],
			'birthday_date' 	            => $customer_detail[0]['birthday_date'],
			'marriage_anniversary_date' 	=> $customer_detail[0]['marriage_anniversary_date'],
			'total_sale' 	                => $customer_detail[0]['total_sale'],
			'discount'           	        => $customer_detail[0]['discount'],
			'pancard'                         	=> $customer_detail[0]['pancard'],
			'rvc_no'                         	=> $customer_detail[0]['rvc_no'],
			'text'                         	=> $customer_detail[0]['text']
		);
		$chapterList = $CI->parser->parse('customer/view_customer', $data, true);
		return $chapterList;
	}

	//Customer ledger Data
	public function customer_ledger_data($customer_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$customer_detail = $CI->Customers->customer_personal_data($customer_id);
		$invoice_info 	= $CI->Customers->customer_invoice_data($customer_id);
		$invoice_amount = 0;
		if(!empty($invoice_info)){
			foreach($invoice_info as $k=>$v){
				$invoice_info[$k]['final_date'] = $CI->occational->dateConvert($invoice_info[$k]['date']);
				$invoice_amount = $invoice_amount+$invoice_info[$k]['amount'];
			}
		}
		$receipt_info 	= $CI->Customers->customer_receipt_data($customer_id);
		$receipt_amount = 0;
		if(!empty($receipt_info)){
			foreach($receipt_info as $k=>$v){
				$receipt_info[$k]['final_date'] = $CI->occational->dateConvert($receipt_info[$k]['date']);
				$receipt_amount = $receipt_amount+$receipt_info[$k]['amount'];
			}
		}
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$data=array(
			'title' 			=> display('customer_ledger'),
			'customer_id' 		=> $customer_detail[0]['customer_id'],
			'customer_name' 	=> $customer_detail[0]['customer_name'],
			'customer_address' 	=> $customer_detail[0]['customer_address'],
			'customer_mobile' 	=> $customer_detail[0]['customer_mobile'],
			'customer_email' 	=> $customer_detail[0]['customer_email'],
			'receipt_amount' 	=> number_format($receipt_amount, 2, '.', ','),
			'invoice_amount' 	=> $invoice_amount,
			'invoice_info' 		=> $invoice_info,
			'receipt_info' 		=> $receipt_info,
			'currency' 			=> $currency_details[0]['currency'],
			'position' 			=> $currency_details[0]['currency_position'],
			
			);
		$chapterList = $CI->parser->parse('customer/customer_details',$data,true);
		return $chapterList;
	}
	//Customer ledger Data
	public function customerledger_data($customer_id)
	{
		//print_r($customer_id);exit;
		$CI =& get_instance();
		$CI->load->model('Customers');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$customer_detail = $CI->Customers->customer_personal_data($customer_id);
		$ledger 	= $CI->Customers->customerledger_tradational($customer_id);
		$summary 	= $CI->Customers->customer_transection_summary($customer_id);

	 // print_r($data['ledger']);exit;

		// $balance = 0;
		// if(!empty($ledger)){
		// 	foreach($ledger as $index=>$value){
		// 		$ledger[$index]['final_date'] = $CI->occational->dateConvert($ledger[$index]['date']);
				
		// 		if(!empty($ledger[$index]['invoice_no'])or  $ledger[$index]['invoice_no']=="NA")
		// 		{
		// 			$ledger[$index]['credit']=$ledger[$index]['amount'];
		// 			$ledger[$index]['balance']=$balance+$ledger[$index]['amount'];
		// 			$ledger[$index]['debit']="";
		// 			$balance=$ledger[$index]['balance'];
		// 		}
		// 		else
		// 		{
		// 			$ledger[$index]['debit']=$ledger[$index]['amount'];
		// 			$ledger[$index]['balance']=$balance-$ledger[$index]['amount'];
		// 			$ledger[$index]['credit']="";
		// 			$balance=$ledger[$index]['balance'];
		// 		}
		// 	}
		// }

		$company_info 	= $CI->Customers->retrieve_company();
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		$data=array(
			'title' 			=> display('customer_ledger'),
			'customer_id' 		=> $customer_detail[0]['customer_id'],
			'customer_name' 	=> $customer_detail[0]['customer_name'],
			'customer_address' 	=> $customer_detail[0]['customer_address'],
			'customer_mobile' 	=> $customer_detail[0]['customer_mobile'],
			'customer_email' 	=> $customer_detail[0]['customer_email'],
			'ledger' 			=> $ledger,
			'total_credit'		=> number_format($summary[0][0]['total_credit'], 2, '.', ','),
			'total_debit'		=> number_format($summary[1][0]['total_debit'], 2, '.', ','),
			'total_balance'		=> number_format($summary[1][0]['total_debit']-$summary[0][0]['total_credit'], 2, '.', ','),
			'company_info'		=> $company_info,
			'currency' => $currency_details[0]['currency'],
			'position' => $currency_details[0]['currency_position'],
			);

		$singlecustomerdetails = $CI->parser->parse('customer/customer_ledger',$data,true);
		return $singlecustomerdetails;
	}
	
	//Search customer
	public function customer_search_list($cat_id,$company_id)
	{
		$CI =& get_instance();
		$CI->load->model('Customers');
		$category_list = $CI->Customers->retrieve_category_list();
		$customers_list = $CI->Customers->customer_search_list($cat_id,$company_id);
		$data = array(
				'title' 		=> display('manage_customer'),
				'customers_list'=> $customers_list,
				'category_list' => $category_list
			);
		$customerList = $CI->parser->parse('customer/customer',$data,true);
		return $customerList;
	}
}
?>