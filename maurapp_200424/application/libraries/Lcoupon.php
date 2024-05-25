<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lcoupon {
	//Retrieve  coupon List	DONE
	public function coupon_list() {
        $CI =& get_instance();
        $CI->load->model('Coupons');
        $CI->load->model('Web_settings');
        $coupon_info = $CI->Coupons->retrieve_coupon();
        $data['total_coupon']    = $CI->Coupons->count_coupon();
        $data['title']             = display('manage_coupon');
        $data['company_info']      = $coupon_info;
        $couponList = $CI->parser->parse('coupon/coupon', $data,true);
        return $couponList;
    }
	
	//Retrieve  coupon Search List DONE	
	public function coupon_search_item($coupon_id)
	{
		$CI =& get_instance();
		$CI->load->model('Coupons');
		$CI->load->model('Web_settings');
		$coupon_list 		= 	$CI->Coupons->coupon_search_item($coupon_id);
		$all_coupon_list 	= 	$CI->Coupons->all_coupon_list();  
		$i=0;
		$total=0;
		if($coupon_list) {
			foreach($coupon_list as $k=>$v) {
				$i++;
				$coupon_list[$k]['sl']=$i;
				$coupon_info = $CI->db->select('*')->from('coupon')->where('coupon_id', $coupon_list[$k]['coupon_id'])->get()->row();
				$coupon_list[$k]['coupon_name']		=	$coupon_info->coupon_name;
				
			}
			$data = array(
				'title' 	       => 	display('manage_coupon'),
				'subtotal'	       =>	number_format($total, 2, '.', ','),
				'all_customer_list'=>	$all_coupon_list,
				'links'		       =>	"",
				'coupon_list'   		=> 	$coupon_list
			);
			$couponList = $CI->parser->parse('coupon/coupon', $data, true);
			return $couponList;
		}
		else{
			redirect('Ccoupon/manage_coupon');
		}
	}	

	//Sub Category Add DONE
	public function coupon_add_form(){
		$CI =& get_instance();
		$CI->load->model('Coupons');
		$data = array(
			'title' => display('add_coupon')
		);
		$customerForm = $CI->parser->parse('coupon/add_coupon_form', $data,true);
		return $customerForm;
	}
	//	INSERT MR DONE
	public function insert_coupon($data)
	{
		$CI = & get_instance();
		$CI->load->model('Coupons');
        $CI->Coupons->coupon_entry($data);
		return true;
	}
	
	//coupon Edit Data DONE 
	public function coupon_edit_data($coupon_id)
	{
		$CI =& get_instance();
		$CI->load->model('Coupons');
		$coupon_detail = $CI->Coupons->retrieve_coupon_editdata($coupon_id);
		$data	=	array(
			'title' 		=> 	display('coupon_edit'),
			'id' 	    => 	$coupon_detail[0]['id'],
			'value'     	=> 	$coupon_detail[0]['value'],
			'amount' 	=> 	$coupon_detail[0]['amount'],
			'types' 	=> 	$coupon_detail[0]['types'],
			'start_date' 		=> 	$coupon_detail[0]['start_date'],
			'start_time'	=>	$coupon_detail[0]['start_time'],
            'expiry_date'	=>	$coupon_detail[0]['expiry_date'],
            'expiry_time'	=>	$coupon_detail[0]['expiry_time'],
            'minimum_purchase'	=>	$coupon_detail[0]['minimum_purchase'],
            'no_of_uses'	=>	$coupon_detail[0]['no_of_uses'],
            'freq_of_use_per_customer'	=>	$coupon_detail[0]['freq_of_use_per_customer'],
		);
		$couponList = $CI->parser->parse('coupon/edit_coupon_form', $data, true);
		return $couponList;
	}
}
?>