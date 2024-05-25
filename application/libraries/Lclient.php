<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lclient {
	//Retrieve  Customer List	DONE
	public function client_list() {
        $CI =& get_instance();
        $CI->load->model('Clients');
        $CI->load->model('Web_settings');
        $client_info = $CI->Clients->retrieve_client();
        $data['total_customer']    = $CI->Clients->count_client();
        $data['title']             = display('manage_client');
        $data['company_info']      = $client_info;
        $clientList = $CI->parser->parse('client/client', $data,true);
        return $clientList;
    }
	
	//Retrieve  Customer Search List DONE	
	public function client_search_item($client_id)
	{
		$CI =& get_instance();
		$CI->load->model('Clients');
		$CI->load->model('Web_settings');
		$client_list 		= 	$CI->Clients->client_search_item($client_id);
		$all_client_list 	= 	$CI->Clients->all_client_list();  
		$i=0;
		$total=0;
		if($client_list) {
			foreach($client_list as $k=>$v) {
				$i++;
				$client_list[$k]['sl']=$i;
				$client_info = $CI->db->select('*')->from('client_information')->where('client_id', $client_list[$k]['client_id'])->get()->row();
				$client_list[$k]['client_name']		=	$client_info->client_name;
				$client_list[$k]['client_address']	=	$client_info->client_address;
				$client_list[$k]['client_mobile']	=	$client_info->client_mobile;
			}
			$data = array(
				'title' 	       => 	display('manage_client'),
				'subtotal'	       =>	number_format($total, 2, '.', ','),
				'all_customer_list'=>	$all_client_list,
				'links'		       =>	"",
				'client_list'   		=> 	$client_list
			);
			$clientList = $CI->parser->parse('client/client', $data, true);
			return $clientList;
		}
		else{
			redirect('Cclient/manage_client');
		}
	}	

	//Sub Category Add DONE
	public function client_add_form(){
		$CI =& get_instance();
		$CI->load->model('Clients');
		$data = array(
			'title' => display('add_client')
		);
		$customerForm = $CI->parser->parse('client/add_client_form', $data,true);
		return $customerForm;
	}
	//	INSERT MR DONE
	public function insert_client($data)
	{
		$CI = & get_instance();
		$CI->load->model('Clients');
        $CI->Clients->client_entry($data);
		return true;
	}
	
	//customer Edit Data DONE 
	public function client_edit_data($client_id)
	{
		$CI =& get_instance();
		$CI->load->model('Clients');
		$client_detail = $CI->Clients->retrieve_client_editdata($client_id);
		$data	=	array(
			'title' 		=> 	display('client_edit'),
			'client_id' 	    => 	$client_detail[0]['client_id'],
			'client_name'     	=> 	$client_detail[0]['client_name'],
			'client_address' 	=> 	$client_detail[0]['client_address'],
			'client_mobile' 	=> 	$client_detail[0]['client_mobile'],
			'client_email' 		=> 	$client_detail[0]['client_email'],
			'client_password'	=>	'',
			'status' 			=> 	$client_detail[0]['status']
		);
		$clientList = $CI->parser->parse('client/edit_client_form', $data, true);
		return $clientList;
	}
}
?>