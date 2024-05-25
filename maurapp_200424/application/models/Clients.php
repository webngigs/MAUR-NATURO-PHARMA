<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clients extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	//Count MR DONE
	public function count_client() {
		$this->db->where('user_id', $this->session->userdata('user_id'));
		return $this->db->count_all("client_information");
	}

	//MR List DONE 
	public function client_list_count() {
		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->num_rows();	
		return false;
	}

	//MR List DONE
	public function client_list($per_page=null, $page=null) {
		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->limit($per_page, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	// DONE
	public function getClientList($postData=null){
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
			$searchQuery = " (client_name like '%".$searchValue."%' or client_mobile like '%".$searchValue."%' or client_email like '%".$searchValue."%') ";
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		if($searchValue != '') $this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		if($searchValue != '')	$this->db->where($searchQuery);
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
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
				if($this->permission1->method('manage_client','update')->access()){
					$button .=' <li class="action"><a href="'.$base_url.'Cclient/client_update_form/'.$record->client_id.'" class="btn btn-info"  data-placement="left" title="'. display('update').'">Edit</a></li>';
				}
				if($this->permission1->method('manage_client','delete')->access()){
					$button .=' <li class="action"><a href="'.$base_url.'Cclient/client_delete/'.$record->client_id.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i>DELETE</a></li>';
				}
   			$button .='</ul></div>';  
            $data[] = array( 
                'sl'       	 	=>	$sl,
                'client_name'	=>	$record->client_name,
                'address'   	=>	$record->client_address,
                'mobile'    	=>	$record->client_mobile,
				'email'     	=>	$record->client_email,
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

	//all MR List DONE
	public function all_client_list() {
		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}
	
	//MR Search List 
	public function client_search_item($client_id) {
		$this->db->select("*");
        $this->db->from('client_information');
		$this->db->where('client_id', $client_id);
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Count MR DONE
	public function client_entry($data) {
		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('client_name', $data['client_name']);
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($query->num_rows()>0)	return FALSE;
		else{
			$this->db->insert('mr_information', $data);		
			$this->db->select('*');
			$this->db->from('mr_information');
			$this->db->where('user_id', $this->session->userdata('user_id'));
			$query = $this->db->get();
			foreach($query->result() as $row) {
				$json_mr[] = array(
					'label'	=>	$row->client_name,
					'value'	=>	$row->client_id
				);
			}
			$cache_file ='./my-assets/js/admin_js/json/client.json';
			$clientList = json_encode($json_mr);
			file_put_contents($cache_file, $clientList);
			return TRUE;
		}
	}

	//Retrieve company Edit Data DONE
	public function retrieve_client() {
		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Retrieve customer Edit Data DONE
	public function retrieve_client_editdata($client_id) {
		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('client_id', $client_id);
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}

	//Retrieve MR Personal Data  DONE
	public function client_personal_data($client_id) {
		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('client_id', $client_id);
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}
	
	//Update MR DONE 
	public function update_client($data, $client_id) {
		$this->db->where('client_id', $client_id);
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->update('client_information', $data);	

		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();

		foreach($query->result() as $row) {
			$json_client[] = array(
				'label'	=>	$row->client_name,
				'value'	=>	$row->client_id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/client.json';
		$clientList = json_encode($json_client);
		file_put_contents($cache_file, $clientList);		
		return true;
	}
	
	// Delete MR Item DONE
	public function delete_client($client_id) {
		$this->db->where('client_id', $client_id);
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->delete('client_information'); 

		$this->db->select('*');
		$this->db->from('client_information');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json_client[] = array(
				'label'	=>	$row->client_name,
				'value'	=>	$row->client_id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/client.json';
		$clientList = json_encode($json_client);
		file_put_contents($cache_file, $clientList);		
		return true;
	}
	
    //autocomplete part DONE
    public function client_search($client_id){
 		$query = $this->db->select('*')->from('client_information')
		->where('user_id', $this->session->userdata('user_id'))
        ->group_start()
			->like('client_name', $client_id)
			->or_like('client_mobile', $client_id)
        ->group_end()
        ->limit(20)
        ->get();
        if($query->num_rows()>0)	return $query->result_array();  
        return false;
    }
}