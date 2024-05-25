<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gifts extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	//Count gift DONE
	public function count_gift() {
		return $this->db->count_all("gifts");
	}

	//gift List DONE 
	public function gift_list_count() {
		$this->db->select('*');
		$this->db->from('gifts');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->num_rows();	
		return false;
	}

	//gift List DONE
	public function gift_list($per_page=null, $page=null) {
		$this->db->select('*');
		$this->db->from('gifts');
		$this->db->limit($per_page, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	// DONE
	public function getGiftList($postData=null){
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
			$searchQuery = " (name like '%".$searchValue."%') ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('gifts');
		if($searchValue != '') $this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('gifts');
		if($searchValue != '')
			$this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('gifts');
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

			if($this->session->userdata('user_type') == 4)	{
				$customer_id 		=	0;
				$totalInvoiceAmount =	0;
				$ClaimedInvoiceAmount 	=	0;
				$this->db->select('customer_id');
				$this->db->from('customer_information');
				$this->db->where('user_ref_id', $this->session->userdata('user_id'));
				$query = $this->db->get();
				if($query->num_rows()>0) {
					$dts 			=	$query->result_array();	
					$customer_id	=	$dts[0]['customer_id'];
					if($customer_id>0) {
						$this->db->select('SUM(total_amount) as totalInvoiceAmount');
						$this->db->from('invoice');
						$this->db->where('type_of_invoice', 1);
						$this->db->where('customer_id', $customer_id);			
						$invAmountData = $this->db->get()->result();
						$totalInvoiceAmount = $invAmountData[0]->totalInvoiceAmount;

						$this->db->select('SUM(gift_amount) as ClaimedInvoiceAmount');
						$this->db->from('gift_request');
						$this->db->where('customer_id', $this->session->userdata('user_id'));			
						$ClaimedInvoiceData = $this->db->get()->result();
						$ClaimedInvoiceAmount = $ClaimedInvoiceData[0]->ClaimedInvoiceAmount;
					}
				}

				$this->db->select('id, status');
				$this->db->from('gift_request');
				$this->db->where('customer_id', $this->session->userdata('user_id'));
				$this->db->where('gift_id', $record->id);
				$query = $this->db->get();
				$gift_request_id	=	0;
				$gift_request_status = 0;
				if($query->num_rows()>0) {
					$dts 					=	$query->result_array();	
					$gift_request_id		=	$dts[0]['id'];
					$gift_request_status 	= 	$dts[0]['status'];
				}

				if($totalInvoiceAmount>0 && $gift_request_id==0) {					
					$TobeClaimInvoiceAmount =	$totalInvoiceAmount - $ClaimedInvoiceAmount;
					if($TobeClaimInvoiceAmount>0 && $TobeClaimInvoiceAmount>$record->mintarget)
						$button .='  <a href="javascript:void(0)" class="btn btn-primary btn-sm requestForGift_'.$record->id.'" data-toggle="tooltip" data-placement="left" onclick="requestForGift('.$record->id.', '.$record->mintarget.')" title="'.display('gift_request_claim').'">Claim</a>';
					else	
						$button .='  <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Not Applicable">Not Applicable</a>';
				}
				else{
					if($gift_request_status==1)
						$button .='  <a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Claimed">Claimed</a>';
					else if($gift_request_status==2)
						$button .='  <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Cancelled">Cancelled</a>';
					else if($gift_request_status==3)
						$button .='  <a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Approved">Approved</a>';
				}
			}
			else{
				$button	.=	'<div class="btn-group"><button type="button" class="btn btn-success " data-toggle="dropdown">Action <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu" role="menu">';
					if($this->permission1->method('manage_gift','update')->access()){
						$button .=' <li class="action"><a href="'.$base_url.'Cgift/gift_update_form/'.$record->id.'" class="btn btn-info"  data-placement="left" title="'. display('update').'">Edit</a></li>';
					}
					if($this->permission1->method('manage_gift','delete')->access()){
						$button .=' <li class="action"><a href="'.$base_url.'Cgift/gift_delete/'.$record->id.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i>DELETE</a></li>';
					}
				$button .='</ul></div>';
			}
            $data[] = array( 
                'sl'       	=>	$sl,
                'name'	    =>	$record->name,
                'amount'    =>	number_format($record->amount).' INR',
				'mintarget' =>	number_format($record->mintarget),				
                'button'   	=>	$button    
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

	public function getGiftRequestList($postData=null){
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
		

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('gift_request');
		if($searchValue != '') $this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('gift_request');
		if($searchValue != '')
			$this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('gift_request');
		if($searchValue != '')	$this->db->where($searchQuery);
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();
		$data = array();

		$sl =1;
        foreach($records as $record ){
			$gift_name = '';
			$this->db->select('name');
			$this->db->from('gifts');
			$this->db->where('id', $record->gift_id);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();	
				$gift_name = $dts[0]['name'];
			}

			$customer_name = '';
			$this->db->select('customer_name');
			$this->db->from('customer_information');
			$this->db->where('user_ref_id', $record->customer_id);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();	
				$customer_name = $dts[0]['customer_name'];
			}

          	$button 	= 	'';
          	$base_url 	= 	base_url();
          	$jsaction 	=	"return confirm('Are You Sure ?')";

			$status = '';

			if($record->status==1){
				$status = 'Claim Request';
				$button .='<a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="Click to Approve this Claimed Request" onclick="claimGiftRequestApprove('.$record->id.')">Approve</a>';
				$button .='<a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Click to Cancel this Claimed Request" onclick="claimGiftRequestCancel('.$record->id.')">Cancel</a>';
			}
			else if($record->status==2){
				$status = 'Cancelled';
				$button .='--';
			}
			else if($record->status==3){
				$status = 'Approved';
				$button .='--';
			}
            $data[] = array( 
                'sl'       		=>	$sl,
				'created_at'	=>	$record->created_at,	
                'gift_name'		=>	$gift_name,
				'customer_name'	=>	$customer_name,	
				'gift_amount'	=>	number_format($record->gift_amount).' INR',		
				'status'		=>	$status,
                'button'   		=>	$button    
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

	//all gift List DONE
	public function all_gift_list() {
		$this->db->select('*');
		$this->db->from('gifts');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}
	
	//gift Search List 
	public function gift_search_item($gift_id) {
		$this->db->select("*");
        $this->db->from('gifts');
		$this->db->where('gift_id', $gift_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Count gift DONE
	public function gift_entry($data) {
		$this->db->select('*');
		$this->db->from('gifts');
		$this->db->where('gift_name', $data['gift_name']);
		$query = $this->db->get();
		if($query->num_rows()>0)	return FALSE;
		else{
			$this->db->insert('gifts', $data);		
			$this->db->select('*');
			$this->db->from('gifts');
			$query = $this->db->get();
			foreach($query->result() as $row) {
				$json_gift[] = array(
					'label'	=>	$row->gift_name,
					'value'	=>	$row->gift_id
				);
			}
			$cache_file ='./my-assets/js/admin_js/json/gift.json';
			$giftList = json_encode($json_gift);
			file_put_contents($cache_file, $giftList);
			return TRUE;
		}
	}

	//Retrieve company Edit Data DONE
	public function retrieve_gift() {
		$this->db->select('*');
		$this->db->from('gifts');
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	public function retrieve_gift_request() {
		$this->db->select('*');
		$this->db->from('gift_request');
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Retrieve gift Edit Data DONE
	public function retrieve_gift_editdata($id) {
		$this->db->select('*');
		$this->db->from('gifts');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}

	//Retrieve gift Personal Data  DONE
	public function gift_personal_data($gift_id) {
		$this->db->select('*');
		$this->db->from('gifts');
		$this->db->where('id', $gift_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}
	
	//Update gift DONE 
	public function update_gift($data, $gift_id) {
		$this->db->where('id', $gift_id);
		$this->db->update('gifts', $data);	
		$this->db->select('*');
		$this->db->from('gifts');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json_gift[] = array(
				'label'	=>	$row->gift_name,
				'value'	=>	$row->gift_id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/gift.json';
		$giftList = json_encode($json_gift);
		file_put_contents($cache_file, $giftList);		
		return true;
	}
	
	// Delete gift Item DONE
	public function delete_gift($gift_id) {
		$this->db->where('id', $gift_id);
		$this->db->delete('gifts'); 
		$this->db->select('*');
		$this->db->from('gifts');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json_gift[] = array(
				'label'	=>	$row->value,
				'value'	=>	$row->id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/gift.json';
		$giftList = json_encode($json_gift);
		file_put_contents($cache_file, $giftList);		
		return true;
	}
	
    //autocomplete part DONE
    public function gift_search($gift_id){
 		$query = $this->db->select('*')->from('gifts')
        ->limit(20)
        ->get();
        if($query->num_rows()>0)	return $query->result_array();  
        return false;
    }
}