<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Demandrequests extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->load->library('session');
		$this->load->model('Web_settings');
		$this->auth->check_admin_auth();
	}

	public function count_demandrequest()
	{
		return $this->db->count_all("demandrequests");
	}

	public function count_customerdemandrequest(){
		return $this->db->count_all("demandrequests");
	}

	public function count_inventory()
	{
		$this->db->where('status', 4);
		return $this->db->count_all("demandrequests");
	}

	public function count_upcoming()
	{
		$this->db->where('status', 3);
		return $this->db->count_all("demandrequests");
	}

	public function demandrequest_entry()
	{
		$request_by = 'admin';
		$demandrequests_id = $this->generator(10);
		$demandrequests_id = strtoupper($demandrequests_id);
		$quantity = $this->input->post('product_quantity');
		$demandrequests_no = $this->number_generator();
		$createby = $this->session->userdata('user_id');
		$createdate = date('Y-m-d H:i:s');

        $mr_id = 0;
		if($this->session->userdata('user_type') == 4){
			$mr_id = 0;
			$this->db->select('user_id, customer_name, customer_email');
			$this->db->from('customer_information');
			$this->db->where('user_ref_id', $createby);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();	
				$mr_id = $dts[0]['user_id'];
				
				$this->db->select('user_id, mr_email, mr_name');
    			$this->db->from('mr_information');
    			$this->db->where('user_id', $mr_id);
    			$querys = $this->db->get();
    			if($querys->num_rows() > 0) {
    			    $dtss = $querys->result_array();
    			    
    				$this->load->library('email');
    			
    			    $message = 'Hi '.$dts[0]['customer_name'].',<br/>';
        			$message .= '<br/>You created new Demand Request ID#'.$demandrequests_no;
        		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
        		    $message .= '<br/>Demand Request No.: '.$demandrequests_no;
        		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cdemandrequest/demandrequests_inserted_data/'.$demandrequests_id.'">Click Here</a>';
        		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
        		    
                    $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                    $this->email->to($dts[0]['customer_email']);
                    $this->email->subject('You created new Demand Request ID#'.$demandrequests_no);
                    $this->email->message($message);
                    $this->email->set_mailtype('html');
                    $this->email->send();
    			
        			$message = 'Hi '.$dtss[0]['mr_name'].',<br/>';
        			$message .= '<br/>You have a new Demand Request ID#'.$demandrequests_no;
        		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
        		    $message .= '<br/>Demand Request No.: '.$demandrequests_no;
        		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cdemandrequest/demandrequests_inserted_data/'.$demandrequests_id.'">Click Here</a>';
        		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
        		    
                    $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                    $this->email->to($dtss[0]['mr_email']);
                    $this->email->subject('You created new Demand Request ID#'.$demandrequests_no);
                    $this->email->message($message);
                    $this->email->set_mailtype('html');
                    $this->email->send();
                
                    $message = 'Hi Admin,<br/>';
        		    $message .= '<br/>You have a new Demand Request ID#'.$demandrequests_no;
        		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
        		    $message .= '<br/>Demand Request No.: '.$demandrequests_no;
        		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cdemandrequest/demandrequests_inserted_data/'.$demandrequests_id.'">Click Here</a>';
        		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
        		    
                    $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                    $this->email->to('maurservicesjr@gmail.com');
                    $this->email->subject('You have a new Demand Request ID#'.$demandrequests_no);
                    $this->email->message($message);
                    $this->email->set_mailtype('html');
                    $this->email->send();
    			}
			}
			$request_by = 'customer';
		}
		if($createby == 1)								{
			$mrs_id = $this->input->post('mr_id');
			$this->db->select('user_id, mr_email, mr_name');
			$this->db->from('mr_information');
			$this->db->where('mr_id', $mrs_id);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();	
				$mr_id = $dts[0]['user_id'];
				
				$this->load->library('email');
				
				$message = 'Hi '.$dts[0]['mr_name'].',<br/>';
    		    $message .= '<br/>You have a new Demand Request ID#'.$demandrequests_no.' from Maurnaturo Team';
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Demand Request No.: '.$demandrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cdemandrequest/demandrequests_inserted_data/'.$demandrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to($dts[0]['mr_email']);
                $this->email->subject('You have a new Demand Request ID#'.$demandrequests_no);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
                
                $message = 'Hi Admin,<br/>';
    		    $message .= '<br/>You created new Demand Request ID#'.$demandrequests_no.' for '.$dts[0]['mr_name'];
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Demand Request No.: '.$demandrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cdemandrequest/demandrequests_inserted_data/'.$demandrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to('maurservicesjr@gmail.com');
                $this->email->subject('You created new Demand Request ID#'.$demandrequests_no.'  for '.$dts[0]['mr_name']);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
			}
			$request_by = 'admin';
		}
		if($this->session->userdata('user_type') == 3){
			$mr_id = $createby;
			$request_by = 'mr';
			
			$this->db->select('user_id, mr_email, mr_name');
			$this->db->from('mr_information');
			$this->db->where('user_id', $mr_id);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				$dts = $query->result_array();
				
				$this->load->library('email');
			
    			$message = 'Hi '.$dts[0]['mr_name'].',<br/>';
    			$message .= '<br/>You created new Demand Request ID#'.$demandrequests_no;
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Demand Request No.: '.$demandrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cdemandrequest/demandrequests_inserted_data/'.$demandrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to($dts[0]['mr_email']);
                $this->email->subject('You created new Demand Request ID#'.$demandrequests_no);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
                
                $message = 'Hi Admin,<br/>';
    		    $message .= '<br/>You have a new Demand Request ID#'.$demandrequests_no.' from '.$dts[0]['mr_name'];
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Demand Request No.: '.$demandrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cdemandrequest/demandrequests_inserted_data/'.$demandrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to('maurservicesjr@gmail.com');
                $this->email->subject('You have a new Demand Request ID#'.$demandrequests_no.' from '.$dts[0]['mr_name']);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
			}
		}

		$dataDemandRequests = array(
			'demandrequests_id' => $demandrequests_id,
			'date' => $createdate,
			'demandrequests' => $demandrequests_no,
			'demandrequests_details' => $this->input->post('demandrequests_details'),
			'createby' => $createby,
			'mr_id' => $mr_id,
			'status' => 1,
			'request_by' => $request_by
		);
		$this->db->insert('demandrequests', $dataDemandRequests);

		$demandrequests_d_id = $this->input->post('demandrequests_details_id');
		$quantity = $this->input->post('product_quantity');
		$rate = $this->input->post('product_rate');
		$p_id = $this->input->post('product_id');
		$total_amount = $this->input->post('total_price');
		$batch_id = $this->input->post('batch_id');

		$n = count($p_id);
		for ($i = 0; $i < $n; $i++) {
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $total_amount[$i];
			$manufacturer_rate = $this->manufacturer_rate($product_id);
			$batch = $batch_id[$i];

			$DemandRequestsDetailsData = array(
				'demandrequests_details_id' => $this->generator(15),
				'demandrequests_id' => $demandrequests_id,
				'product_id' => $product_id,
				'quantity' => $product_quantity,
				'status' => 1,
				'mr_id' => $mr_id
			);
			$this->db->insert('demandrequests_details', $DemandRequestsDetailsData);
		}
		return $demandrequests_id;
	}

	public function number_generator()
	{
		$demandrequests_no = 1;
		$this->db->select_max('demandrequests', 'demandrequests_no');
		$query = $this->db->get('demandrequests');
		$result = $query->result_array();
		if (isset($result[0]['demandrequests_no']))
			$demandrequests_no = $result[0]['demandrequests_no'] + 1;
		return $demandrequests_no;
	}

	public function manufacturer_rate($product_id)
	{
		$this->db->select('manufacturer_price');
		$this->db->from('product_information');
		$this->db->where(array('product_id' => $product_id));
		$query = $this->db->get();
		return $query->result_array();
	}

	public function generator($lenth)
	{
		$number = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
		for ($i = 0; $i < $lenth; $i++) {
			$rand_value = rand(0, 8);
			$rand_number = $number["$rand_value"];
			if (empty($con))
				$con = $rand_number;
			else
				$con = "$con" . "$rand_number";
		}
		return $con;
	}

	public function retrieve_demandrequest_html_data($demandrequest_id)
	{
		$this->db->select('a.*, c.demandrequests_details_id, c.quantity, d.product_id, d.product_name, d.strength, d.product_details, d.product_model');
		$this->db->from('demandrequests a');
		$this->db->join('demandrequests_details c', 'c.demandrequests_id = a.demandrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		$this->db->where('a.demandrequests_id', $demandrequest_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query->result_array();
		return false;
	}

	public function getDemandRequestsList($postData = null)
	{
		$createby = $this->session->userdata('user_id');

		$this->load->library('occational');
		$response = array();
		$fromdate = $this->input->post('fromdate');
		$todate   = $this->input->post('todate');
		if(!empty($fromdate)){
			$datbetween = "(a.date BETWEEN '$fromdate' AND '$todate')";
		}
		else{
			$datbetween = "";
		}

		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length'];
		$columnIndex = $postData['order'][0]['column'];
		$columnName = $postData['columns'][$columnIndex]['data'];
		$columnSortOrder = $postData['order'][0]['dir'];
		$searchValue = $postData['search']['value'];

		$searchQuery = "";
		if ($searchValue != '')
			$searchQuery = " (a.demandrequests like '%" . $searchValue . "%' or a.date like'%" . $searchValue . "%' or a.demandrequests_id like'%" . $searchValue . "%')";

		$this->db->select('count(*) as allcount');
		$this->db->from('demandrequests a');
		if(!empty($fromdate) && !empty($todate)){
			$this->db->where($datbetween);
		}

		if ($searchValue != '')
			$this->db->where($searchQuery);
		if ($createby != 1){
			if($this->session->userdata('user_type') == 4)		$this->db->where('a.createby', $createby);
			else if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where_in('a.request_by', ['mr','admin']);
			}
		}
		else{
			$this->db->where_in('a.request_by', ['mr','admin']);		
		}
			
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		$this->db->select('count(*) as allcount');
		$this->db->from('demandrequests a');
		if(!empty($fromdate) && !empty($todate)){
			$this->db->where($datbetween);
		}
		if ($searchValue != '')
			$this->db->where($searchQuery);
		if ($createby != 1){
			if($this->session->userdata('user_type') == 4)		$this->db->where('a.createby', $createby);
			else if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where_in('a.request_by', ['mr','admin']);
			}
		}
		else{
			$this->db->where_in('a.request_by', ['mr','admin']);		
		}
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		$this->db->select("a.*");
		$this->db->from('demandrequests a');
		if(!empty($fromdate) && !empty($todate)){
			$this->db->where($datbetween);
		}
		if ($searchValue != '')
			$this->db->where($searchQuery);
		if ($createby != 1){
			if($this->session->userdata('user_type') == 4)		$this->db->where('a.createby', $createby);
			else if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where_in('a.request_by', ['mr','admin']);
			}
		}
		else{
			$this->db->where_in('a.request_by', ['mr','admin']);		
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();
		$data = array();
		$sl = 1;

		if (isset($records) && count($records) > 0) {
			foreach ($records as $record) {
				if ($record->status == 1)
					$record->status = 'Pending';
				elseif ($record->status == 2)
					$record->status = 'Cancelled';
				elseif ($record->status == 3)
					$record->status = 'Approved';
				elseif ($record->status == 4)
					$record->status = 'Received';

				$total_quantity = 0;
				$this->db->select('SUM(quantity) as ttlQuantity');
				$this->db->from('demandrequests_details');
				$this->db->where('demandrequests_id', $record->demandrequests_id);
				$records_ttl = $this->db->get()->result();
				$total_quantity = $records_ttl[0]->ttlQuantity;

				$mr_name = '--';
				$customer_name = '--';
				if($record->request_by == 'customer'){					
					$this->db->select('customer_name, user_id');
					$this->db->from('customer_information');
					$this->db->where('user_ref_id', $record->createby);
					$query = $this->db->get();
					if($query->num_rows() > 0) {
						$dts = $query->result_array();	
						$customer_name = $dts[0]['customer_name'];
						$this->db->select('mr_name');
						$this->db->from('mr_information');
						$this->db->where('user_id', $dts[0]['user_id']);
						$query = $this->db->get();
						if($query->num_rows()>0) {
							$dts = $query->result_array();	
							$mr_name = $dts[0]['mr_name'];
						}
					}
				}
				else if($record->request_by == 'mr'){
					$this->db->select('mr_name');
					$this->db->from('mr_information');
					$this->db->where('user_id', $record->createby);
					$query = $this->db->get();
					if($query->num_rows() > 0) {
						$dts = $query->result_array();	
						$mr_name = $dts[0]['mr_name'];
					}
				}
			
				$button = '';
				$base_url = base_url();
				$jsaction = "return confirm('Are You Sure ?')";

				$button .= '  <a href="' . $base_url . 'Cdemandrequest/demandrequests_inserted_data/' . $record->demandrequests_id . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('demandrequests') . '"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
				
				if($this->session->userdata('user_type') == 1){
				    $button .=' <a href="'.$base_url.'Cdemandrequest/mr_demandrequest_delete/'.$record->demandrequests_id.'" class="btn btn-danger" onclick="'.$jsaction.'"><i class="fa fa-trash"></i></a>';
			    }
				
				$data[] = array(
					'sl'            	=>  $sl,
					'demandrequests' 	=>  $record->demandrequests,
					'final_date'    	=>  $record->date,
					'total_quantity'	=>	$total_quantity,
					'customer_name'		=>	$customer_name,
					'mr_name'			=>	$mr_name,
					'button'        	=>  $button
				);
				$sl++;
			}
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecordwithFilter,
			"iTotalDisplayRecords" => $totalRecords,
			"aaData" => $data
		);
		return $response;
	}

	public function getCustomerDemandRequestsList($postData = null)
	{
		$createby = $this->session->userdata('user_id');

		$this->load->library('occational');
		$response = array();
		$fromdate = $this->input->post('fromdate');
		$todate   = $this->input->post('todate');
		if(!empty($fromdate)){
			$datbetween = "(a.date BETWEEN '$fromdate' AND '$todate')";
		}
		else{
			$datbetween = "";
		}

		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length'];
		$columnIndex = $postData['order'][0]['column'];
		$columnName = $postData['columns'][$columnIndex]['data'];
		$columnSortOrder = $postData['order'][0]['dir'];
		$searchValue = $postData['search']['value'];

		$searchQuery = "";
		if ($searchValue != '')
			$searchQuery = " (a.demandrequests like '%" . $searchValue . "%' or a.date like'%" . $searchValue . "%' or a.demandrequests_id like'%" . $searchValue . "%')";

		$this->db->select('count(*) as allcount');
		$this->db->from('demandrequests a');
		if(!empty($fromdate) && !empty($todate)){
			$this->db->where($datbetween);
		}

		if ($searchValue != '')
			$this->db->where($searchQuery);
		if ($createby != 1){
			if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where('a.request_by', 'customer');
			}
		}
		else{
			$this->db->where_in('a.request_by', ['customer']);		
		}
			
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		$this->db->select('count(*) as allcount');
		$this->db->from('demandrequests a');
		if(!empty($fromdate) && !empty($todate)){
			$this->db->where($datbetween);
		}
		if ($searchValue != '')
			$this->db->where($searchQuery);
		if ($createby != 1){
			if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where('a.request_by', 'customer');
			}
		}
		else{
			$this->db->where_in('a.request_by', ['customer']);		
		}
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		$this->db->select("a.*");
		$this->db->from('demandrequests a');
		if (!empty($fromdate) && !empty($todate))
			$this->db->where($datbetween);
		if ($searchValue != '')
			$this->db->where($searchQuery);
		if ($createby != 1){
			if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where('a.request_by', 'customer');
			}
		}
		else{
			$this->db->where_in('a.request_by', ['customer']);		
		}
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();
		$data = array();
		$sl = 1;

		if (isset($records) && count($records) > 0) {
			foreach ($records as $record) {
				if ($record->status == 1)
					$record->status = 'Pending';
				elseif ($record->status == 2)
					$record->status = 'Cancelled';
				elseif ($record->status == 3)
					$record->status = 'Approved';
				elseif ($record->status == 4)
					$record->status = 'Received';

				$total_quantity = 0;
				$this->db->select('SUM(quantity) as ttlQuantity');
				$this->db->from('demandrequests_details');
				$this->db->where('demandrequests_id', $record->demandrequests_id);
				$records_ttl = $this->db->get()->result();
				$total_quantity = $records_ttl[0]->ttlQuantity;

				$mr_name = '--';
				$customer_name = '--';
				if($record->request_by == 'customer'){					
					$this->db->select('customer_name, user_id');
					$this->db->from('customer_information');
					$this->db->where('user_ref_id', $record->createby);
					$query = $this->db->get();
					if($query->num_rows() > 0) {
						$dts = $query->result_array();	
						$customer_name = $dts[0]['customer_name'];
						$this->db->select('mr_name');
						$this->db->from('mr_information');
						$this->db->where('user_id', $dts[0]['user_id']);
						$query = $this->db->get();
						if($query->num_rows()>0) {
							$dts = $query->result_array();	
							$mr_name = $dts[0]['mr_name'];
						}
					}
				}
				else if($record->request_by == 'mr'){
					$this->db->select('mr_name');
					$this->db->from('mr_information');
					$this->db->where('user_id', $record->createby);
					$query = $this->db->get();
					if($query->num_rows() > 0) {
						$dts = $query->result_array();	
						$mr_name = $dts[0]['mr_name'];
					}
				}
			
				$button = '';
				$base_url = base_url();
				$jsaction = "return confirm('Are You Sure ?')";

				$button .= '  <a href="' . $base_url . 'Cdemandrequest/demandrequests_inserted_data/' . $record->demandrequests_id . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('demandrequests') . '"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
				
				if($this->session->userdata('user_type') == 1){
				    $button .=' <a href="'.$base_url.'Cdemandrequest/customer_demandrequest_delete/'.$record->demandrequests_id.'" class="btn btn-danger" onclick="'.$jsaction.'"><i class="fa fa-trash"></i></a>';
			    }
				
				$data[] = array(
					'sl'            	=>  $sl,
					'demandrequests' 	=>  $record->demandrequests,
					'final_date'    	=>  $record->date,
					'total_quantity'	=>	$total_quantity,
					'customer_name'		=>	$customer_name,
					'mr_name'			=>	$mr_name,
					'button'        	=>  $button
				);
				$sl++;
			}
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecordwithFilter,
			"iTotalDisplayRecords" => $totalRecords,
			"aaData" => $data
		);
		return $response;
	}

	public function retrieve_demandrequest_editdata($demandrequest_id)
	{
		$this->db->select('a.*, c.*, c.product_id, d.product_name, d.product_model, d.unit');
		$this->db->from('demandrequests a');
		$this->db->join('demandrequests_details c', 'c.demandrequests_id = a.demandrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		$this->db->where('a.demandrequests_id', $demandrequest_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query->result_array();
		return false;
	}
	
	public function delete_demandrequest($demandrequest_id){
	    $this->db->where('demandrequests_id',$demandrequest_id);
		$this->db->delete('demandrequests');
		
		$this->db->where('demandrequests_id',$demandrequest_id);
		$this->db->delete('demandrequests_details');
	}
	
}