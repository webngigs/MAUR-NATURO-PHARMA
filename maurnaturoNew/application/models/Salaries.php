<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Salaries extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function select_all_mr()
	{
		$query = $this->db->select('*')
			->from('mr_information')
			->where('status','1')
			->get();

		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	public function count_salary() {
		return $this->db->count_all("salaries");
	}

	public function salary_list_count() {
		$this->db->select('*');
		$this->db->from('salaries');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->num_rows();	
		return false;
	}

	public function salary_list($per_page=null, $page=null) {
		$this->db->select('*');
		$this->db->from('salaries');
		$this->db->limit($per_page, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	public function retrieve_salary() {
		$this->db->select('*');
		$this->db->from('salaries');
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	public function getList($postData=null){
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
		$this->db->from('salaries');
		if($searchValue != '') $this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('salaries');
		if($searchValue != '')	$this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('salaries');
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
				if($this->permission1->method('manage_salary','update')->access()){
					$button .=' <li class="action"><a href="'.$base_url.'Csalary/salary_update_form/'.$record->id.'" class="btn btn-info"  data-placement="left" title="'. display('update').'">Edit</a></li>';
				}
				if($this->permission1->method('manage_salary','delete')->access()){
					$button .=' <li class="action"><a href="'.$base_url.'Csalary/salary_delete/'.$record->id.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i>DELETE</a></li>';
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

            $data[] = array( 
                'sl'       			=>	$sl,
                'mr_name'	    	=>	$mr_name,
				'name'	    		=>	$record->title,	
				'salary_date'		=>	$record->salary_date,	
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