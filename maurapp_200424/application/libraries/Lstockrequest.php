<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Lstockrequest
{
	public function stockrequest_add_form()
	{
		$CI = & get_instance();
		$CI->load->model('Stockrequests');
		$CI->load->model('Web_settings');
		$CI->load->library('session');
		$user_id = $CI->session->userdata('user_id');

		$data = array(
			'title' => display('add_new_stockrequest'),
			'user_id' => $user_id
		);

		$stockrequestForm = $CI->parser->parse('stockrequest/add_stockrequest_form', $data, true);
		return $stockrequestForm;
	}

	public function stockrequests_edit_data($stockrequest_id)
	{
		$CI = & get_instance();
		$CI->load->model('Stockrequests');
		$CI->load->model('Web_settings');
		$stockrequest_detail = $CI->Stockrequests->retrieve_stockrequest_editdata($stockrequest_id);

		$i = 0;
		if (!empty($stockrequest_detail)) {
			foreach ($stockrequest_detail as $k => $v) {
				$i++;
				$stockrequest_detail[$k]['sl'] = $i;
			}
		}

		$data = array(
			'title' => display('stockrequest_edit'),
			'stockrequests_id' => $stockrequest_detail[0]['stockrequests_id'],
			'date' => $stockrequest_detail[0]['date'],
			'stockrequests_details' => $stockrequest_detail[0]['stockrequests_details'],
			'total_amount' => $stockrequest_detail[0]['total_amount'],
			'unit' => $stockrequest_detail[0]['unit'],
			'stockrequest_all_data' => $stockrequest_detail
		);
		$dataList = $CI->parser->parse('stockrequest/edit_stockrequest_form', $data, true);
		return $dataList;
	}

	public function stockrequest_list()
	{
		$CI = & get_instance();
		$CI->load->model('Stockrequests');
		$CI->load->model('Web_settings');
		$data = array(
			'title' => display('manage_stockrequest'),
			'total_request' => $CI->Stockrequests->count_stockrequest()
		);
		$stockrequestList = $CI->parser->parse('stockrequest/stockrequest', $data, true);
		return $stockrequestList;
	}

	public function customer_stockrequest_list(){
		$CI = & get_instance();
		$CI->load->model('Stockrequests');
		$CI->load->model('Web_settings');
		$data = array(
			'title' => display('customer_stockrequest'),
			'total_request' => $CI->Stockrequests->count_stockrequest()
		);
		$stockrequestList = $CI->parser->parse('stockrequest/customer_stockrequest', $data, true);
		return $stockrequestList;	
	}

	public function inventory_list()
	{
		$CI = & get_instance();
		$CI->load->model('Stockrequests');
		$CI->load->model('Web_settings');
		$data = array(
			'title' => display('inventory'),
			'total_request' => $CI->Stockrequests->count_inventory()
		);
		$inventory_list = $CI->parser->parse('stockrequest/inventory', $data, true);
		return $inventory_list;
	}

	public function upcoming_list()
	{
		$CI = & get_instance();
		$CI->load->model('Stockrequests');
		$CI->load->model('Web_settings');
		$data = array(
			'title' => display('upcomingstock'),
			'total_request' => $CI->Stockrequests->count_upcoming()
		);
		$inventory_list = $CI->parser->parse('stockrequest/upcoming', $data, true);
		return $inventory_list;
	}

	public function stockrequest_html_data($stockrequest_id)
	{
		$CI = & get_instance();
		$CI->load->model('Stockrequests');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$CI->load->library('session');

		$user_id 	= 	$CI->session->userdata('user_id');
		$user_type 	= 	$CI->session->userdata('user_type');
		
		$user_logo 	= 	'';
		if($user_type == 3){
			$user_logo 	=	$CI->session->userdata('logo');	
		}
		elseif($user_type == 4){
			$this->db->select('user_id');
			$this->db->from('customer_information');
			$this->db->where('user_ref_id', $user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();	
				echo $mr_user_id = $dts[0]['user_id'];
				
				/*$this->db->select('logo');
				$this->db->from('users');
				$this->db->where('user_id', $mr_user_id);
				$query = $this->db->get();
				if($query->num_rows() > 0) {
					$dtss = $query->result_array();	
					$user_logo = $dtss[0]['logo'];
				}*/
			}
		}
		
		$stockrequest_detail = $CI->Stockrequests->retrieve_stockrequest_html_data($stockrequest_id);

		$subTotal_quantity = 0;
		$subTotal_cartoon = 0;
		$subTotal_discount = 0;
		$subTotal_ammount = 0;
		if (!empty($stockrequest_detail)) {
			foreach ($stockrequest_detail as $k => $v) {
				$stockrequest_detail[$k]['final_date'] = $CI->occational->dateConvert($stockrequest_detail[$k]['date']);
				$subTotal_quantity = $subTotal_quantity + $stockrequest_detail[$k]['quantity'];
				$subTotal_ammount = $subTotal_ammount + $stockrequest_detail[$k]['total_price'];
			}
			$i = 0;
			foreach ($stockrequest_detail as $k => $v) {
				$i++;
				$stockrequest_detail[$k]['sl'] = $i;
			}
		}
		$data = array(
			'title' 				=>	display('stockrequest_detail'),
			'request_by' 			=> 	$stockrequest_detail[0]['request_by'],
			'stockrequest_id' 		=> 	$stockrequest_detail[0]['stockrequests_id'],
			'status' 				=> 	$stockrequest_detail[0]['status'],
			'stockrequest_no' 		=> 	$stockrequest_detail[0]['stockrequests'],
			'final_date' 			=> 	$stockrequest_detail[0]['final_date'],
			'stockrequest_detail' 	=> 	$stockrequest_detail[0]['stockrequest_detail'],
			'total_amount' 			=> 	number_format($stockrequest_detail[0]['total_amount'], 2, '.', ','),
			'subTotal_quantity' 	=> 	$subTotal_quantity,
			'subTotal_ammount' 		=> 	number_format($subTotal_ammount, 2, '.', ','),
			'stockrequest_all_data' => 	$stockrequest_detail,
			'user_id' 				=> 	$user_id,
			'user_type' 			=> 	$user_type,
			'user_logo'				=>	$user_logo
		);

		$chapterList = $CI->parser->parse('stockrequest/stockrequest_html', $data, true);
		return $chapterList;
	}
}