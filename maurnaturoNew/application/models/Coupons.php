<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Coupons extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	//Count coupon DONE
	public function count_coupon() {
		return $this->db->count_all("coupons");
	}

	//coupon List DONE 
	public function coupon_list_count() {
		$this->db->select('*');
		$this->db->from('coupons');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->num_rows();	
		return false;
	}

	//coupon List DONE
	public function coupon_list($per_page=null, $page=null) {
		$this->db->select('*');
		$this->db->from('coupons');
		$this->db->limit($per_page, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	// DONE
	public function getCouponList($postData=null){
		$response = array();
		## Read value
		$draw 				= 	$postData['draw'];
		$start 				= 	$postData['start'];
		$rowperpage 		= 	$postData['length']; // Rows display per page
		$columnIndex 		= 	$postData['order'][0]['column']; // Column index
		$columnName 		= 	$postData['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder	=	$postData['order'][0]['dir']; // asc or desc
		$searchValue 		=	$postData['search']['value']; // Search value

		## Search 
		$searchQuery = "";
		if($searchValue != ''){
			$searchQuery = " (coupon_name like '%".$searchValue."%' or coupon_mobile like '%".$searchValue."%' or coupon_email like '%".$searchValue."%') ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('coupons');
		if($searchValue != '') $this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('coupons');
		if($searchValue != '')
			$this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('coupons');
		if($searchValue != '')	$this->db->where($searchQuery);
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();
		$data = array();
		$sl =1;
  
        foreach($records as $record ){
          	$button 	= 	'';
          	$base_url 	= 	base_url();
          	$jsaction 	=	"return confirm('Are You Sure ?')";

         	$button	.=	'<div class="btn-group"><button type="button" class="btn btn-success " data-toggle="dropdown">Action <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu" role="menu">';
				if($this->permission1->method('manage_coupon','update')->access()){
					$button .=' <li class="action"><a href="'.$base_url.'Ccoupon/coupon_update_form/'.$record->id.'" class="btn btn-info"  data-placement="left" title="'. display('update').'">Edit</a></li>';
				}
				if($this->permission1->method('manage_coupon','delete')->access()){
					$button .=' <li class="action"><a href="'.$base_url.'Ccoupon/coupon_delete/'.$record->id.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i>DELETE</a></li>';
				}
   			$button .='</ul></div>';
  
            $data[] = array( 
                'sl'       	      	=>	$sl,
                'value'	            =>	$record->value,
                'amount'        	=>	$record->amount,
                'types'         	=>	$record->types,
				'start_date'     	=>	$record->start_date,
				'start_time'     	=>	$record->start_time,
				'expiry_date'     	=>	$record->expiry_date,
				'expiry_time'     	=>	$record->expiry_time,
				'minimum_purchase'     	=>	$record->minimum_purchase,
				'no_of_uses'     	=>	$record->no_of_uses,
				'freq_of_use_per_customer'     	=>	$record->freq_of_use_per_customer,
				
                'button'    	=>	$button    
            ); 
			$sl++;
        }

		## Response
		$response = array(
			"draw" 					=> 	intval($draw),
			"iTotalRecords" 		=> 	$totalRecordwithFilter,
			"iTotalDisplayRecords" 	=> 	$totalRecords,
			"aaData" 				=> 	$data
		);
        return $response; 
    }

	//all coupon List DONE
	public function all_coupon_list() {
		$this->db->select('*');
		$this->db->from('coupons');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}
	
	//coupon Search List 
	public function coupon_search_item($coupon_id) {
		$this->db->select("*");
        $this->db->from('coupons');
		$this->db->where('coupon_id', $coupon_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Count coupon DONE
	public function coupon_entry($data) {
		$this->db->select('*');
		$this->db->from('coupons');
		$this->db->where('coupon_name', $data['coupon_name']);
		$query = $this->db->get();
		if($query->num_rows()>0)	return FALSE;
		else{
			$this->db->insert('coupons', $data);		
			$this->db->select('*');
			$this->db->from('coupons');
			$query = $this->db->get();
			foreach($query->result() as $row) {
				$json_coupon[] = array(
					'label'	=>	$row->coupon_name,
					'value'	=>	$row->coupon_id
				);
			}
			$cache_file ='./my-assets/js/admin_js/json/coupon.json';
			$couponList = json_encode($json_coupon);
			file_put_contents($cache_file, $couponList);
			return TRUE;
		}
	}

	//Retrieve company Edit Data DONE
	public function retrieve_coupon() {
		$this->db->select('*');
		$this->db->from('coupons');
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Retrieve customer Edit Data DONE
	public function retrieve_coupon_editdata($coupon_id) {
		$this->db->select('*');
		$this->db->from('coupons');
		$this->db->where('id', $coupon_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}

	//Retrieve coupon Personal Data  DONE
	public function coupon_personal_data($coupon_id) {
		$this->db->select('*');
		$this->db->from('coupons');
		$this->db->where('id', $coupon_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}
	
	//Update coupon DONE 
	public function update_coupon($data, $coupon_id) {
		$this->db->where('id', $coupon_id);
		$this->db->update('coupons', $data);	
		$this->db->select('*');
		$this->db->from('coupons');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json_coupon[] = array(
				'label'	=>	$row->coupon_name,
				'value'	=>	$row->coupon_id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/coupon.json';
		$couponList = json_encode($json_coupon);
		file_put_contents($cache_file, $couponList);		
		return true;
	}
	
	// Delete coupon Item DONE
	public function delete_coupon($coupon_id) {
		$this->db->where('id', $coupon_id);
		$this->db->delete('coupons'); 
		$this->db->select('*');
		$this->db->from('coupons');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json_coupon[] = array(
				'label'	=>	$row->value,
				'value'	=>	$row->id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/coupon.json';
		$couponList = json_encode($json_coupon);
		file_put_contents($cache_file, $couponList);		
		return true;
	}
	
    //autocomplete part DONE
    public function coupon_search($coupon_id){
 		$query = $this->db->select('*')->from('coupons')
        ->limit(20)
        ->get();
        if($query->num_rows()>0)	return $query->result_array();  
        return false;
    }
}