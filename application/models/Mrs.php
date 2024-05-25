<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mrs extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	//Count MR DONE
	public function count_mr() {
		return $this->db->count_all("mr_information");
	}

	//MR List DONE 
	public function mr_list_count() {
		$this->db->select('*');
		$this->db->from('mr_information');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->num_rows();	
		return false;
	}

	//MR List DONE
	public function mr_list($per_page=null, $page=null) {
		$this->db->select('*');
		$this->db->from('mr_information');
		$this->db->limit($per_page, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	// DONE
	public function getMrList($postData=null){
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
			$searchQuery = " (mr_name like '%".$searchValue."%' or mr_mobile like '%".$searchValue."%' or mr_email like '%".$searchValue."%') ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('mr_information');
		if($searchValue != '') $this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('mr_information');
		if($searchValue != '')
			$this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('mr_information');
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
         	
			if($this->permission1->method('manage_mr','update')->access()){
				$button .=' <a href="'.$base_url.'Cmr/mr_change_password/'.$record->mr_id.'" class="btn btn-warning" data-placement="left" title="Change Password"><i class="fa fa-key"></i></a>';
				$button .=' <a href="'.$base_url.'Cmr/mr_update_form/'.$record->mr_id.'" class="btn btn-info" data-placement="left" title="'.display('update').'"><i class="fa fa-edit"></i></a>';
				
			}
			if($this->permission1->method('manage_mr','delete')->access()){
				$button .=' <a href="'.$base_url.'Cmr/mr_delete/'.$record->mr_id.'" class="btn btn-danger" onclick="'.$jsaction.'"><i class="fa fa-trash"></i></a>';
			}
  
            $data[] = array( 
                'sl'            =>	$sl,
                'mr_name'	    =>	$record->mr_name,
                'mr_address'    =>	$record->mr_address,
                'mr_mobile'     =>	$record->mr_mobile,
				'mr_email'      =>	$record->mr_email,
				'mr_password'   =>	$record->mr_password,
                'button'        =>	$button,    
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

	//all MR List DONE
	public function all_mr_list() {
		$this->db->select('*');
		$this->db->from('mr_information');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}
	
	//MR Search List 
	public function mr_search_item($mr_id) {
		$this->db->select("*");
        $this->db->from('mr_information');
		$this->db->where('mr_id', $mr_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Count MR DONE
	public function mr_entry($data) {
		$this->db->select('*');
		$this->db->from('mr_information');
		$this->db->where('mr_name', $data['mr_name']);
		$query = $this->db->get();
		if($query->num_rows()>0)	return FALSE;
		else{
			$this->db->insert('mr_information', $data);		
			$this->db->select('*');
			$this->db->from('mr_information');
			$query = $this->db->get();
			foreach($query->result() as $row) {
				$json_mr[] = array(
					'label'	=>	$row->mr_name,
					'value'	=>	$row->mr_id
				);
			}
			$cache_file ='./my-assets/js/admin_js/json/mr.json';
			$mrList = json_encode($json_mr);
			file_put_contents($cache_file, $mrList);
			return TRUE;
		}
	}

	//Retrieve company Edit Data DONE
	public function retrieve_mr() {
		$this->db->select('*');
		$this->db->from('mr_information');
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Retrieve customer Edit Data DONE
	public function retrieve_mr_editdata($mr_id) {
		$this->db->select('*');
		$this->db->from('mr_information');
		$this->db->where('mr_id', $mr_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}

	//Retrieve MR Personal Data  DONE
	public function mr_personal_data($mr_id) {
		$this->db->select('*');
		$this->db->from('mr_information');
		$this->db->where('mr_id', $mr_id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}
	
	//Update MR DONE 
	public function update_mr($data, $mr_id) {
		$this->db->where('mr_id', $mr_id);
		$this->db->update('mr_information', $data);	
		$this->db->select('*');
		$this->db->from('mr_information');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json_mr[] = array(
				'label'	=>	$row->mr_name,
				'value'	=>	$row->mr_id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/mr.json';
		$mrList = json_encode($json_mr);
		file_put_contents($cache_file, $mrList);		
		return true;
	}
	
	// Delete MR Item DONE
	public function delete_mr($mr_id) {
		$this->db->where('mr_id', $mr_id);
		$this->db->delete('mr_information'); 
		$this->db->select('*');
		$this->db->from('mr_information');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json_mr[] = array(
				'label'	=>	$row->mr_name,
				'value'	=>	$row->mr_id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/mr.json';
		$mrList = json_encode($json_mr);
		file_put_contents($cache_file, $mrList);		
		return true;
	}
	
    //autocomplete part DONE
    public function mr_search($mr_id){
 		$query = $this->db->select('*')->from('mr_information')
        ->group_start()
			->like('mr_name', $mr_id)
			->or_like('mr_mobile', $mr_id)
        ->group_end()
        ->limit(20)
        ->get();
        if($query->num_rows()>0)	return $query->result_array();  
        return false;
    }
}