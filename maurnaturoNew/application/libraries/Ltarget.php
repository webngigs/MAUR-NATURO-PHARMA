<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ltarget {
	//Retrieve  Customer List	DONE
	public function list() {
        $CI =& get_instance();
        $CI->load->model('Targets');
        $CI->load->model('Invoices');
        $CI->load->model('Web_settings');
        $info = $CI->Targets->retrieve();
        $data['total_customer']	= 	$CI->Targets->count();
        $data['title']          = 	display('manage_target');
        $data['info']      		=	$info;
        
        $total_sales_amount         =   $CI->Invoices->total_sales_amount();
        $data['total_sales_amount'] =	$total_sales_amount;
        
        $clientList = $CI->parser->parse('target/target', $data,true);
        return $clientList;
    }
	
	//Retrieve  Customer Search List DONE	
	public function search_item($id)
	{
		$CI =& get_instance();
		$CI->load->model('Targets');
		$CI->load->model('Web_settings');
		$list 		= 	$CI->Targets->search_item($id);
		$all_list 	= 	$CI->Targets->all_list();  
		$i=0;
		$total=0;
		if($list) {
			foreach($list as $k=>$v) {
				$i++;
				$list[$k]['sl']=$i;
				$info = $CI->db->select('*')->from('targets')->where('id', $list[$k]['id'])->get()->row();
				$list[$k]['minpurchase']	=	$info->minpurchase;
				$list[$k]['maxpurchase']	=	$info->maxpurchase;
				$list[$k]['commission']		=	$info->commission;
				$list[$k]['commission_type']		=	$info->commission_type;
				$list[$k]['note']		=	$info->note;
			}
			$data = array(
				'title' 	       	=> 	display('manage_target'),
				'subtotal'	       	=>	number_format($total, 2, '.', ','),
				'all_customer_list'	=>	$all_list,
				'links'		       	=>	"",
				'list'   			=> 	$list
			);
			$List = $CI->parser->parse('target/target', $data, true);
			return $List;
		}
		else{
			redirect('Ctarget/manage_target');
		}
	}	

	//Sub Category Add DONE
	public function add_form(){
		$CI =& get_instance();
		
		$CI->load->model('Targets');
		$all_mr = $CI->Targets->select_all_mr();

		$data = array(
			'title'		=>	display('add_target'),
			'all_mr'	=>	$all_mr
		);
		$Form = $CI->parser->parse('target/add_form', $data, true);
		return $Form;
	}
	//	INSERT MR DONE
	public function insert_target($data)
	{
		$CI = & get_instance();
		$CI->load->model('Targets');
        $CI->Targets->entry($data);
		return true;
	}
	
	//customer Edit Data DONE 
	public function edit_data($id)
	{
		$CI =& get_instance();
		$CI->load->model('Targets');

		$all_mr = 	$CI->Targets->select_all_mr();
		$detail	=	$CI->Targets->retrieve_editdata($id);

		$data = array(
			'title' 		=> 	display('target_edit'),
			'id' 	    	=> 	$detail[0]['id'],
			'mr_id' 	    => 	$detail[0]['mr_id'],
			'minpurchase'	=> 	$detail[0]['minpurchase'],
			'maxpurchase' 	=> 	$detail[0]['maxpurchase'],
			'commission' 	=> 	$detail[0]['commission'],
			'commission_type' 	=> 	$detail[0]['commission_type'],
			'note' 	=> 	$detail[0]['note'],
			'all_mr'		=>	$all_mr
		);

		$List = $CI->parser->parse('target/edit_form', $data, true);
		return $List;
	}
}
?>