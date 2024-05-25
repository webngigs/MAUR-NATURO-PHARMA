<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expenses extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function count_expenses() {
		return $this->db->count_all("expenses");
	}

	public function expenses_list_count() {
		$this->db->select('*');
		$this->db->from('expenses');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->num_rows();	
		return false;
	}

	public function expenses_list($per_page=null, $page=null) {
		$this->db->select('*');
		$this->db->from('expenses');
		$this->db->limit($per_page, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	public function retrieve_expenses() {
		$this->db->select('*');
		$this->db->from('expenses');
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	public function getExpensesList($postData=null){
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
		if($searchValue != '')	$searchQuery = " (title like '%".$searchValue."%') ";
		
		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('expenses');
		if($searchValue != '') $this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('expenses');
		if($searchValue != '')	$this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('expenses');
		if($searchValue != '')	$this->db->where($searchQuery);
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();
		$data = array();

		$sl =1;
        foreach($records as $record ){
          	$button 	= 	'';
          	$base_url 	= 	base_url();
          	$jsaction 	=	"return confirm('Are You Sure?')";

			$button	.=	'<div class="btn-group"><button type="button" class="btn btn-success " data-toggle="dropdown">Action <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu" role="menu">';
				$button .=' <li class="action"><a href="'.$base_url.'Cexpenses/expenses_view_form/'.$record->id.'" class="btn btn-sm btn-info" style="width: 60%;" data-placement="left" title="View"><i class="fa fa-eye"></i> View</a></li>';
				if($record->expenses_status == 'Pending'){
					$button .=' <li class="action"><a href="'.$base_url.'Cexpenses/expenses_approve/'.$record->id.'" class="btn btn-sm btn-success" style="width: 60%;" onclick="'.$jsaction.'"><i class="fa fa-check"></i> Approve</a></li>';
					$button .=' <li class="action"><a href="'.$base_url.'Cexpenses/expenses_rejected/'.$record->id.'" class="btn btn-sm btn-danger" style="width: 60%;" onclick="'.$jsaction.'"><i class="fa fa-times"></i> Reject</a></li>';
				}
		  	$button .='</ul></div>';

			$mr_name = '--';
			$this->db->select('mr_name');
			$this->db->from('mr_information');
			$this->db->where('mr_id', $record->mr_id);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();	
				$mr_name = $dts[0]['mr_name'];
			}

			if($record->expenses_status == 'Pending')		
				$expenses_status = '<strong class="text-primary">'.$record->expenses_status.'</strong>';
			elseif($record->expenses_status == 'Approved')
				$expenses_status = '<strong class="text-success">'.$record->expenses_status.'</strong>';
			elseif($record->expenses_status == 'Rejected')
				$expenses_status = '<strong class="text-danger">'.$record->expenses_status.'</strong>';

            $data[] = array( 
                'sl'       			=>	$sl,
				'mr_name'			=>	$mr_name,
                'name'	    		=>	$record->title,	
				'expenses_status'	=>	$expenses_status,
				'expenses_date'		=>	$record->expenses_date,	
				'amount'    		=>	number_format($record->amount).' INR',		
                'button'   			=>	$button    
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
}