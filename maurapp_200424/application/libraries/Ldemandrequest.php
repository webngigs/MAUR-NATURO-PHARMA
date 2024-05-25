<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Ldemandrequest
{
	public function demandrequest_add_form()
	{
		$CI = & get_instance();
		$CI->load->model('Demandrequests');
		$CI->load->model('Web_settings');
		$CI->load->library('session');
		$user_id = $CI->session->userdata('user_id');

		$data = array(
			'title' => display('add_new_demadrequest'),
			'user_id' => $user_id
		);

		$demandrequestForm = $CI->parser->parse('demandrequest/add_demandrequest_form', $data, true);
		return $demandrequestForm;
	}

	public function stockrequests_edit_data($demandrequest_id)
	{
		$CI = & get_instance();
		$CI->load->model('Demandrequests');
		$CI->load->model('Web_settings');
		$demandrequest_detail = $CI->Demandrequests->retrieve_demandrequest_editdata($demandrequest_id);

		$i = 0;
		if (!empty($demandrequest_detail)) {
			foreach ($demandrequest_detail as $k => $v) {
				$i++;
				$demandrequest_detail[$k]['sl'] = $i;
			}
		}

		$data = array(
			'title' => display('demandrequest_edit'),
			'demandrequests_id' => $demandrequest_detail[0]['demandrequests_id'],
			'date' => $demandrequest_detail[0]['date'],
			'demandrequests_details' => $demandrequest_detail[0]['demandrequests_details'],
			'demandrequest_all_data' => $demandrequest_detail
		);
		$dataList = $CI->parser->parse('demandrequest/edit_demandrequest_form', $data, true);
		return $dataList;
	}

	public function demandrequest_list()
	{
		$CI = & get_instance();
		$CI->load->model('Demandrequests');
		$CI->load->model('Web_settings');
		$data = array(
			'title' => display('manage_demandrequest'),
			'total_request' => $CI->Demandrequests->count_demandrequest()
		);
		$demandrequestList = $CI->parser->parse('demandrequest/demandrequest', $data, true);
		return $demandrequestList;
	}

	public function customer_demandrequest_list(){
		$CI = & get_instance();
		$CI->load->model('Demandrequests');
		$CI->load->model('Web_settings');
		$data = array(
			'title' => display('customer_demandrequest'),
			'total_request' => $CI->Demandrequests->count_customerdemandrequest()
		);
		$demandrequestList = $CI->parser->parse('demandrequest/customer_demandrequest', $data, true);
		return $demandrequestList;	
	}

	public function demandrequest_html_data($demandrequest_id)
	{
		$CI = & get_instance();
		$CI->load->model('Demandrequests');
		$CI->load->model('Web_settings');
		$CI->load->library('occational');
		$CI->load->library('session');

		$user_id = $CI->session->userdata('user_id');
		$user_type = $CI->session->userdata('user_type');
		
		$demandrequest_detail = $CI->Demandrequests->retrieve_demandrequest_html_data($demandrequest_id);

		if (!empty($demandrequest_detail)) {
			foreach ($demandrequest_detail as $k => $v) {
				$demandrequest_detail[$k]['final_date'] = $CI->occational->dateConvert($demandrequest_detail[$k]['date']);
			}
			$i = 0;
			foreach ($demandrequest_detail as $k => $v) {
				$i++;
				$demandrequest_detail[$k]['sl'] = $i;
			}
		}
		$data = array(
			'title' => display('demandrequest_detail'),
			'request_by' => $demandrequest_detail[0]['request_by'],
			'demandrequest_id' => $demandrequest_detail[0]['demandrequests_id'],
			'status' => $demandrequest_detail[0]['status'],
			'demandrequest_no' => $demandrequest_detail[0]['demandrequests'],
			'final_date' => $demandrequest_detail[0]['final_date'],
			'demandrequest_detail' => $demandrequest_detail[0]['demandrequest_detail'],
			'demandrequest_all_data' => $demandrequest_detail,
			'user_id' => $user_id,
			'user_type' => $user_type
		);

		$chapterList = $CI->parser->parse('demandrequest/demandrequest_html', $data, true);
		return $chapterList;
	}
}