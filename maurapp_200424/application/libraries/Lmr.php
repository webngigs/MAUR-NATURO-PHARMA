<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lmr {
	//Retrieve  Customer List	DONE
	public function mr_list() {
        $CI =& get_instance();
        $CI->load->model('Mrs');
        $CI->load->model('Web_settings');
        $mr_info = $CI->Mrs->retrieve_mr();
        $data['total_customer']    = $CI->Mrs->count_mr();
        $data['title']             = display('manage_mr');
        $data['company_info']      = $mr_info;
        $mrList = $CI->parser->parse('mr/mr', $data,true);
        return $mrList;
    }
	
	//Retrieve  Customer Search List DONE	
	public function mr_search_item($mr_id)
	{
		$CI =& get_instance();
		$CI->load->model('Mrs');
		$CI->load->model('Web_settings');
		$mr_list 		= 	$CI->Mrs->mr_search_item($mr_id);
		$all_mr_list 	= 	$CI->mrs->all_mr_list();  
		$i=0;
		$total=0;
		if($mr_list) {
			foreach($mr_list as $k=>$v) {
				$i++;
				$mr_list[$k]['sl']=$i;
				$mr_info = $CI->db->select('*')->from('mr_information')->where('mr_id', $mr_list[$k]['mr_id'])->get()->row();
				$mr_list[$k]['mr_name']		=	$mr_info->mr_name;
				$mr_list[$k]['mr_address']	=	$mr_info->mr_address;
				$mr_list[$k]['mr_mobile']	=	$mr_info->mr_mobile;
			}
			$data = array(
				'title' 	       => 	display('manage_mr'),
				'subtotal'	       =>	number_format($total, 2, '.', ','),
				'all_customer_list'=>	$all_mr_list,
				'links'		       =>	"",
				'mr_list'   		=> 	$mr_list
			);
			$mrList = $CI->parser->parse('mr/mr', $data, true);
			return $mrList;
		}
		else{
			redirect('Cmr/manage_mr');
		}
	}	

	//Sub Category Add DONE
	public function mr_add_form(){
		$CI =& get_instance();
		$CI->load->model('Mrs');
		$data = array(
			'title' => display('add_mr')
		);
		$customerForm = $CI->parser->parse('mr/add_mr_form', $data,true);
		return $customerForm;
	}
	//	INSERT MR DONE
	public function insert_mr($data)
	{
		$CI = & get_instance();
		$CI->load->model('Mrs');
        $CI->Mrs->mr_entry($data);
		return true;
	}
	
	
	public function mr_change_password($mr_id)
	{
		$CI =& get_instance();
		$CI->load->model('Mrs');
		$mr_detail = $CI->Mrs->retrieve_mr_editdata($mr_id);
		$data=array(
			'title'     =>  'Change MR Password',
			'mr_id' 	=>  $mr_detail[0]['mr_id'],
			'user_id'   =>  $mr_detail[0]['user_id'],
			'password'  =>  $mr_detail[0]['mr_password'],
			'mr_name'      =>  $mr_detail[0]['mr_name'],
			'mr_email'      =>  $mr_detail[0]['mr_email'],
		);
		$chapterList = $CI->parser->parse('mr/mr_change_password_form', $data, true);
		return $chapterList;
	}
	
	//customer Edit Data DONE 
	public function mr_edit_data($mr_id)
	{
		$CI =& get_instance();
		$CI->load->model('Mrs');
		$mr_detail = $CI->Mrs->retrieve_mr_editdata($mr_id);

		$data	=	array(
			'title' 		                => 	display('mr_edit'),
			'mr_id'                         => 	$mr_detail[0]['mr_id'],
			'mr_name'                      	=> 	$mr_detail[0]['mr_name'],
			'mr_address' 	                => 	$mr_detail[0]['mr_address'],
			'mr_mobile'                  	=> 	$mr_detail[0]['mr_mobile'],
			'mr_email' 		                => 	$mr_detail[0]['mr_email'],
			'mr_password'	                =>	'',
			'status' 		                => 	$mr_detail[0]['status'],
			'reference_by_joining' 		    => 	$mr_detail[0]['reference_by_joining'],
			'joining_date' 		            => 	$mr_detail[0]['joining_date'],
			'area_cover' 	              	=> 	$mr_detail[0]['area_cover'],
			'police_verfication_date' 		=> 	$mr_detail[0]['police_verfication_date'],
			'police_verfication_no' 		=> 	$mr_detail[0]['police_verfication_no'],
			'id_proff' 		                => 	$mr_detail[0]['id_proff'],
			'whatsapp_no' 	              	=> 	$mr_detail[0]['whatsapp_no'],
			'other_contact_no' 	          	=> 	$mr_detail[0]['other_contact_no'],
			
			'mr_photo' 	          	    => 	$mr_detail[0]['mr_photo'],
			'pancard' 	          	    => 	$mr_detail[0]['pancard'],
			'aadharcard' 	          	=> 	$mr_detail[0]['aadharcard'],
			'idno' 	          	        => 	$mr_detail[0]['idno'],
			'account_holder_name' 	    => 	$mr_detail[0]['account_holder_name'],
			'account_number' 	        => 	$mr_detail[0]['account_number'],
			'bank_name' 	          	=> 	$mr_detail[0]['bank_name'],
			'ifsc_code' 	          	=> 	$mr_detail[0]['ifsc_code'],
		);
		$mrList = $CI->parser->parse('mr/edit_mr_form', $data, true);
		return $mrList;
	}

	public function stockrequest_list(){
        $CI = & get_instance();
        $CI->load->model('Stockrequests');
        $CI->load->model('Web_settings');
        $data = array(
            'title'         =>  display('manage_stockrequest'),
            'total_request' =>  $CI->Stockrequests->count_stockrequest()
        );
        $stockrequestList = $CI->parser->parse('mr/stockrequest', $data, true);
        return $stockrequestList;
    }
}
?>