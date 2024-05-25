<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Targets extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->library('auth');
		$this->load->library('session');
		
	}

	//Count MR DONE
	public function count() {
		return $this->db->count_all("targets");
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

	//MR List DONE 
	public function list_count() {
		$this->db->select('*');
		$this->db->from('targets');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->num_rows();	
		return false;
	}

	//MR List DONE
	public function list($per_page=null, $page=null) {
		$this->db->select('*');
		$this->db->from('targets');
		$this->db->limit($per_page, $page);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	// DONE
	public function getList($postData=null){
		$createby = $this->session->userdata('user_id');
		$this->load->model('Invoices');
		$total_sales_amount =   $this->Invoices->total_sales_amount();

		$response = array();
		## Read value
		$draw 				= 	$postData['draw'];
		$start 				= 	$postData['start'];
		$rowperpage 		= 	$postData['length']; // Rows display per page
		$columnIndex 		= 	$postData['order'][0]['column']; // Column index
		$columnName 		= 	$postData['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder	=	$postData['order'][0]['dir']; // asc or desc
		$searchValue 		=	$postData['search']['value']; // Search value

		$mr_id = '';
		if($this->session->userdata('user_type') == 3)	{
			$mr_id = '';
			$this->db->select('mr_id');
			$this->db->from('mr_information');
			$this->db->where('user_id', $createby);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();	
				$mr_id = $dts[0]['mr_id'];
			}
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('targets');
		if($this->session->userdata('user_type') == 3)	{
			$this->db->where('mr_id', $mr_id);
		}		
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->from('targets');
		if($this->session->userdata('user_type') == 3)	{
			$this->db->where('mr_id', $mr_id);
		}
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select("*");
		$this->db->from('targets');
		if($this->session->userdata('user_type') == 3)	{
			$this->db->where('mr_id', $mr_id);
		}		
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();
		$data = array();

		$sl =1;
        foreach($records as $record ){
          	$button 	= 	'';
          	$base_url 	= 	base_url();
          	$jsaction 	=	"return confirm('Are You Sure ?')";
			if($this->session->userdata('user_type') == 3)	{
			    if($total_sales_amount>=$record->minpurchase && $total_sales_amount <= $record->maxpurchase){
			        $button = '<h5 class="text-success">Eligible</h5>';              
			    }
			    else{
			        $button = '<h5 class="text-danger">Not Eligible</h5>';
			    }
			}
			else{
				$button	.=	'<div class="btn-group"><button type="button" class="btn btn-success " data-toggle="dropdown">Action <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu" role="menu">';
					if($this->permission1->method('manage_target', 'update')->access()){
						$button .=' <li class="action"><a href="'.$base_url.'Ctarget/update_form/'.$record->id.'" class="btn btn-info"  data-placement="left" title="'. display('update').'">Edit</a></li>';
					}
					if($this->permission1->method('manage_target','delete')->access()){
						$button .=' <li class="action"><a href="'.$base_url.'Ctarget/delete/'.$record->id.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i>DELETE</a></li>';
					}
				$button .='</ul></div>';
			}

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
                'sl'       	 	=>	$sl,
                'mr_name'		=>	$mr_name,
				'minpurchase'	=>	number_format($record->minpurchase).' ₹',
                'maxpurchase'   =>	number_format($record->maxpurchase).' ₹',
                'commission'    =>	number_format($record->commission).' ₹',
                'commission_type'    =>	$record->commission_type,
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
	public function all_list() {
		$this->db->select('*');
		$this->db->from('targets');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}
	
	//MR Search List 
	public function search_item($id) {
		$this->db->select("*");
        $this->db->from('targets');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	public function entry($data) {
		$this->db->select('*');
		$this->db->from('targets');
		$query = $this->db->get();
		if($query->num_rows()>0)	return FALSE;
		else{
			$this->db->insert('targets', $data);		
			$this->db->select('*');
			$this->db->from('targets');
			$query = $this->db->get();
			foreach($query->result() as $row) {
				$json[] = array(
					'label'	=>	$row->minpurchase,
					'value'	=>	$row->id
				);
			}
			$cache_file ='./my-assets/js/admin_js/json/target.json';
			$List = json_encode($json);
			file_put_contents($cache_file, $List);
			return TRUE;
		}
	}

	//Retrieve company Edit Data DONE
	public function retrieve() {
		$this->db->select('*');
		$this->db->from('targets');
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();	
		return false;
	}

	//Retrieve customer Edit Data DONE
	public function retrieve_editdata($id) {
		$this->db->select('*');
		$this->db->from('targets');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}

	//Retrieve MR Personal Data  DONE
	public function personal_data($id) {
		$this->db->select('*');
		$this->db->from('targets');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows()>0)	return $query->result_array();
		return false;
	}
	
	//Update MR DONE 
	public function update($data, $id) {
		$this->db->where('id', $id);
		$this->db->update('targets', $data);	
		$this->db->select('*');
		$this->db->from('targets');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json[] = array(
				'label'	=>	$row->minpurchase,
				'value'	=>	$row->id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/target.json';
		$List = json_encode($json);
		file_put_contents($cache_file, $List);		
		return true;
	}
	
	// Delete MR Item DONE
	public function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('targets'); 
		$this->db->select('*');
		$this->db->from('targets');
		$query = $this->db->get();
		foreach($query->result() as $row) {
			$json[] = array(
				'label'	=>	$row->minpurchase,
				'value'	=>	$row->id
			);
		}
		$cache_file = './my-assets/js/admin_js/json/target.json';
		$List = json_encode($json);
		file_put_contents($cache_file, $List);		
		return true;
	}
	
    //autocomplete part DONE
    public function search($id){
 		$query = $this->db->select('*')->from('targets')
        ->limit(20)
        ->get();
        if($query->num_rows()>0)	return $query->result_array();  
        return false;
    }
}