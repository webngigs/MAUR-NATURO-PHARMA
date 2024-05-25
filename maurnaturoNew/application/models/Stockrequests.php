<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Stockrequests extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->load->library('session');
		$this->load->model('Web_settings');
		$this->auth->check_admin_auth();
	}

	public function count_stockrequest()
	{
		return $this->db->count_all("stockrequests");
	}

	public function count_inventory()
	{
		$this->db->where('status', 4);
		return $this->db->count_all("stockrequests");
	}

	public function count_upcoming()
	{
		$this->db->where('status', 3);
		return $this->db->count_all("stockrequests");
	}

	public function stockrequest_entry()
	{
		$request_by = 'admin';
		$stockrequests_id = $this->generator(10);
		$stockrequests_id = strtoupper($stockrequests_id);

		$quantity = $this->input->post('product_quantity');
		$available_quantity = $this->input->post('available_quantity');
		
		$stockrequests_no = $this->number_generator();

		$createby = $this->session->userdata('user_id');
		$createdate = date('Y-m-d H:i:s');

        $status = 1;

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
        			$message .= '<br/>You created new Stock Transfer Request ID#'.$stockrequests_no;
        		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
        		    $message .= '<br/>Stock Transfer Request No.: '.$stockrequests_no;
        		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cstockrequest/stockrequests_inserted_data/'.$stockrequests_id.'">Click Here</a>';
        		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
        		    
                    $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                    $this->email->to($dts[0]['customer_email']);
                    $this->email->subject('You created new Stock Transfer Request ID#'.$stockrequests_no);
                    $this->email->message($message);
                    $this->email->set_mailtype('html');
                    $this->email->send();
    			
        			$message = 'Hi '.$dtss[0]['mr_name'].',<br/>';
        			$message .= '<br/>You have a new Stock Transfer Request ID#'.$stockrequests_no;
        		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
        		    $message .= '<br/>Stock Transfer Request No.: '.$stockrequests_no;
        		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cstockrequest/stockrequests_inserted_data/'.$stockrequests_id.'">Click Here</a>';
        		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
        		    
                    $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                    $this->email->to($dtss[0]['mr_email']);
                    $this->email->subject('You created new Stock Transfer Request ID#'.$stockrequests_no);
                    $this->email->message($message);
                    $this->email->set_mailtype('html');
                    $this->email->send();
                
                    $message = 'Hi Admin,<br/>';
        		    $message .= '<br/>You have a new Stock Transfer Request ID#'.$stockrequests_no;
        		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
        		    $message .= '<br/>Stock Transfer Request No.: '.$stockrequests_no;
        		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cstockrequest/stockrequests_inserted_data/'.$stockrequests_id.'">Click Here</a>';
        		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
        		    
                    $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                    $this->email->to('maurservicesjr@gmail.com');
                    $this->email->subject('You have a new Stock Transfer Request ID#'.$stockrequests_no);
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
    		    $message .= '<br/>You have a new Stock Transfer Request ID#'.$stockrequests_no.' from Maurnaturo Team';
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Stock Transfer Request No.: '.$stockrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cstockrequest/stockrequests_inserted_data/'.$stockrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to($dts[0]['mr_email']);
                $this->email->subject('You have a new Stock Transfer Request ID#'.$stockrequests_no);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
                
                $message = 'Hi Admin,<br/>';
    		    $message .= '<br/>You created new Stock Transfer Request ID#'.$stockrequests_no.' for '.$dts[0]['mr_name'];
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Stock Transfer Request No.: '.$stockrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cstockrequest/stockrequests_inserted_data/'.$stockrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to('maurservicesjr@gmail.com');
                $this->email->subject('You created new Stock Transfer Request ID#'.$stockrequests_no.'  for '.$dts[0]['mr_name']);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
			}
			$request_by = 'admin';
			$status = 3;
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
    			$message .= '<br/>You created new Stock Transfer Request ID#'.$stockrequests_no;
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Stock Transfer Request No.: '.$stockrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cstockrequest/demandrequests_inserted_data/'.$stockrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to($dts[0]['mr_email']);
                $this->email->subject('You created new Stock Transfer Request ID#'.$stockrequests_no);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
                
                $message = 'Hi Admin,<br/>';
    		    $message .= '<br/>You have a new Stock Transfer Request ID#'.$stockrequests_no.' from '.$dts[0]['mr_name'];
    		    $message .= '<br/>Please Check below details:<br/>============================<br/><br/>';
    		    $message .= '<br/>Stock Transfer Request No.: '.$stockrequests_no;
    		    $message .= '<br/>Please <a href="https://app.maurnaturo.com/Cstockrequest/demandrequests_inserted_data/'.$stockrequests_id.'">Click Here</a>';
    		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    		    
                $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
                $this->email->to('maurservicesjr@gmail.com');
                $this->email->subject('You have a new Stock Transfer Request ID#'.$stockrequests_no.' from '.$dts[0]['mr_name']);
                $this->email->message($message);
                $this->email->set_mailtype('html');
                $this->email->send();
			}
		}

		$dataStockRequests = array(
			'stockrequests_id'      =>  $stockrequests_id,
			'date'                  =>  $createdate,
			'total_amount'          =>  $this->input->post('grand_total_price'),
			'stockrequests'         =>  $stockrequests_no,
			'stockrequests_details' =>  $this->input->post('stockrequests_details'),
			'createby'              =>  $createby,
			'mr_id'                 =>  $mr_id,
			'status'                =>  $status,
			'request_by'            =>  $request_by
		);
		$this->db->insert('stockrequests', $dataStockRequests);

		$stockrequests_d_id = $this->input->post('stockrequests_details_id');
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

			$StockRequestsDetailsData = array(
				'stockrequests_details_id' => $this->generator(15),
				'stockrequests_id' => $stockrequests_id,
				'product_id' => $product_id,
				'batch_id' => $batch,
				'quantity' => $product_quantity,
				'rate' => $product_rate,
				'manufacturer_rate' => $manufacturer_rate[0]['manufacturer_price'],
				'total_price' => $total_price,
				'status' => 1,
				'mr_id' => $mr_id
			);
			$this->db->insert('stockrequests_details', $StockRequestsDetailsData);
		}
		
		
		
		return $stockrequests_id;
	}

	public function number_generator()
	{
		$stockrequests_no = 1;
		$this->db->select_max('stockrequests', 'stockrequests_no');
		$query = $this->db->get('stockrequests');
		$result = $query->result_array();
		if (isset($result[0]['stockrequests_no']))
			$stockrequests_no = $result[0]['stockrequests_no'] + 1;
		return $stockrequests_no;
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

	public function retrieve_stockrequest_html_data($stockrequest_id)
	{
		$this->db->select('a.*, c.stockrequests_details_id, c.batch_id, c.quantity, c.rate, c.manufacturer_rate, c.total_price,
		d.product_id, d.product_name, d.strength, d.product_details, d.product_model');
		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		$this->db->where('a.stockrequests_id', $stockrequest_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query->result_array();
		return false;
	}

	public function getStockRequestsList($postData = null)
	{
		$createby = $this->session->userdata('user_id');

		$this->load->library('occational');
		$response = array();
		$fromdate = $this->input->post('fromdate');
		$todate   = $this->input->post('todate');
		$status   = $this->input->post('status');
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
			$searchQuery = " (a.stockrequests like '%" . $searchValue . "%' or a.date like'%" . $searchValue . "%' or a.stockrequests_id like'%" . $searchValue . "%')";

		$this->db->select('count(*) as allcount');
		$this->db->from('stockrequests a');
		if(!empty($fromdate) && !empty($todate)){
			$this->db->where($datbetween);
		}
		
		if (!empty($status))    $this->db->where('a.status', $status);

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
		$this->db->from('stockrequests a');
		if(!empty($fromdate) && !empty($todate)){
			$this->db->where($datbetween);
		}
		
		if (!empty($status))    $this->db->where('a.status', $status);
		
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
		$this->db->from('stockrequests a');
		if (!empty($fromdate) && !empty($todate))
			$this->db->where($datbetween);
		
		if (!empty($status))    $this->db->where('a.status', $status);
		
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
				else if($record->request_by == 'admin'){
				    $this->db->select('mr_name');
					$this->db->from('mr_information');
					$this->db->where('user_id', $record->mr_id);
					$query = $this->db->get();
					if($query->num_rows() > 0) {
						$dts = $query->result_array();	
						$mr_name = $dts[0]['mr_name'];
					}
				}

				$button = '';
				$base_url = base_url();
				$jsaction = "return confirm('Are You Sure ?')";

				$button .= '  <a href="' . $base_url . 'Cstockrequest/stockrequests_inserted_data/' . $record->stockrequests_id . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('stockrequests') . '"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
				
				if($this->session->userdata('user_type') == 1){
					if ($this->permission1->method('manage_stockrequest', 'update')->access()) {
						if ($record->status == 'Pending')
							$button .= ' <a href="' . $base_url . 'Cstockrequest/stockrequest_update_form/' . $record->stockrequests_id . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('update') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
					}
					if ($this->permission1->method('manage_stockrequest', 'delete')->access()) {
						if ($record->status == 'Pending')
							$button .= '<a href="' . $base_url . 'Cstockrequest/stockrequest_delete/' . $record->stockrequests_id . '" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('delete') . '"  onclick="' . $jsaction . '"><i class="fa fa-trash"></i></a>';
					}
				}
				$data[] = array(
					'sl'            =>  $sl,
					'mr_name'       =>  $mr_name,
					'customer_name' =>  $customer_name,
					'stockrequests' =>  $record->stockrequests,
					'final_date'    =>  $record->date,
					'total_amount'  =>  $record->total_amount,
					'status'        =>  $record->status,
					'button'        =>  $button
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

	public function getCustomerStockRequestsList($postData = null)
	{
		$createby = $this->session->userdata('user_id');

		$this->load->library('occational');
		$response = array();
		$fromdate = $this->input->post('fromdate');
		$todate   = $this->input->post('todate');
		$status   = $this->input->post('status');
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
			$searchQuery = " (a.stockrequests like '%" . $searchValue . "%' or a.date like'%" . $searchValue . "%' or a.stockrequests_id like'%" . $searchValue . "%')";

		$this->db->select('count(*) as allcount');
		$this->db->from('stockrequests a');
		if (!empty($fromdate) && !empty($todate))
			$this->db->where($datbetween);
			
		if (!empty($status))    $this->db->where('a.status', $status);

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
		$this->db->from('stockrequests a');
		if (!empty($fromdate) && !empty($todate))
			$this->db->where($datbetween);
		if (!empty($status))    $this->db->where('a.status', $status);
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
		$this->db->from('stockrequests a');
		if (!empty($fromdate) && !empty($todate))
			$this->db->where($datbetween);
		if ($searchValue != '')
	    if (!empty($status))    $this->db->where('a.status', $status);
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

				$button .= '  <a href="' . $base_url . 'Cstockrequest/stockrequests_inserted_data/' . $record->stockrequests_id . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('stockrequests') . '"><i class="fa fa-window-restore" aria-hidden="true"></i></a>';
				if ($this->permission1->method('manage_stockrequest', 'update')->access()) {
					$button .= ' <a href="' . $base_url . 'Cstockrequest/stockrequest_update_form/' . $record->stockrequests_id . '" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('update') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				}
				if ($this->permission1->method('manage_stockrequest', 'delete')->access()) {
					$button .= '<a href="' . $base_url . 'Cstockrequest/stockrequest_delete/' . $record->stockrequests_id . '" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="' . display('delete') . '"  onclick="' . $jsaction . '"><i class="fa fa-trash"></i></a>';
				}
				$data[] = array(
					'sl'            =>  $sl,
					'mr_name'       =>  $mr_name,
					'customer_name' =>  $customer_name,
					'stockrequests' =>  $record->stockrequests,
					'final_date'    =>  $record->date,
					'total_amount'  =>  $record->total_amount,
					'status'        =>  $record->status,
					'button'        =>  $button
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

	public function getInventoryList($postData = null)
	{
		$this->load->library('occational');
		$response = array();
		/*$fromdate = $this->input->post('fromdate');
		$todate   = $this->input->post('todate');
		if(!empty($fromdate))	$datbetween = "(a.date BETWEEN '$fromdate' AND '$todate')";
		else $datbetween = "";*/

		$createby = $this->session->userdata('user_id');

		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length'];
		$columnIndex = $postData['order'][0]['column'];
		$columnName = $postData['columns'][$columnIndex]['data'];
		$columnSortOrder = $postData['order'][0]['dir'];
		$searchValue = $postData['search']['value'];

		$this->db->select('count(*) as allcount');
		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		//$this->db->where('a.status', 4);
	    if($createby != 1){
			if($this->session->userdata('user_type') == 4)		$this->db->where('a.createby', $createby);
			else if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where_in('a.request_by', ['mr','admin']);
			}
		}
		else{
			$this->db->where_in('a.request_by', ['mr','admin']);		
		}
		$this->db->group_by('d.product_id, c.batch_id');
		$records = $this->db->get()->result();
		$totalRecords = count($records);

		$this->db->select('count(*) as allcount');
		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		//$this->db->where('a.status', 4);
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
		$this->db->group_by('d.product_id, c.batch_id');
		$records = $this->db->get()->result();
		$totalRecordwithFilter = count($records);
        
		$this->db->select(
			'a.*, 
			c.stockrequests_details_id, c.batch_id, SUM(c.quantity) AS quantity, c.rate, c.manufacturer_rate, c.total_price,
			d.product_id, d.product_name, d.strength, d.product_details, d.product_model, d.price, (SELECT SUM(id.quantity) FROM invoice_details AS id WHERE  a.mr_id=id.created_by_mr AND id.type_of_invoice=2 AND id.batch_id=c.batch_id) AS sold_quantity'
		);

		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		//$this->db->where('a.status', 4);
		if($createby != 1){
			if($this->session->userdata('user_type') == 4)		$this->db->where('a.createby', $createby);
			else if($this->session->userdata('user_type') == 3)	{
				$this->db->where('a.mr_id', $createby);
				$this->db->where_in('a.request_by', ['mr','admin']);
			}
		}
		else{
			$this->db->where_in('a.request_by', ['mr','admin']);		
		}
		
		$this->db->group_by('d.product_id, c.batch_id');
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();

		$data = array();
		$sl = 1;
		if (isset($records) && count($records) > 0) {
			foreach ($records as $record) {
				$base_url = base_url();
				$data[] = array(
					'sl' => $sl,
					'date' => $record->date,
					'product_name' => $record->product_name,
					'product_model' => $record->product_model,
					'batch_id' => $record->batch_id,
					'quantity' => $record->quantity-$record->sold_quantity,
					'price' => $record->price,
					'query' => 'SELECT a.*, c.stockrequests_details_id, c.batch_id, SUM(c.quantity) AS quantity, c.rate, c.manufacturer_rate, c.total_price, d.product_id, d.product_name, d.strength, d.product_details, d.product_model, d.price, (SELECT SUM(id.quantity) FROM invoice_details AS id WHERE  a.mr_id=id.created_by_mr AND id.type_of_invoice=2 AND id.batch_id=c.batch_id) AS sold_quantity FROM stockrequests a JOIN stockrequests_details c ON c.stockrequests_id = a.stockrequests_id JOIN product_information d ON d.product_id = c.product_id WHERE a.mr_id='.$createby.' AND a.request_by IN (\'mr\', \'admin\') '.
					' AND batch_id=\''.$record->batch_id.'\' GROUP BYd.product_id, c.batch_id'
				);
				$sl++;
			}
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecordwithFilter,
			"iTotalDisplayRecords" => $totalRecords,
			"aaData" => $data,
		);
		return $response;
	}

	public function getUpcomingStockList($postData = null)
	{
		$this->load->library('occational');
		$response = array();
		/*$fromdate = $this->input->post('fromdate');
		$todate   = $this->input->post('todate');
		if(!empty($fromdate))	$datbetween = "(a.date BETWEEN '$fromdate' AND '$todate')";
		else $datbetween = "";*/

		$createby = $this->session->userdata('user_id');

		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length'];
		$columnIndex = $postData['order'][0]['column'];
		$columnName = $postData['columns'][$columnIndex]['data'];
		$columnSortOrder = $postData['order'][0]['dir'];
		$searchValue = $postData['search']['value'];

		$this->db->select('count(*) as allcount');
		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
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
		$this->db->where('a.status', 3);
		$this->db->group_by('d.product_id');
		$records = $this->db->get()->result();
		$totalRecords = $records[0]->allcount;

		$this->db->select('count(*) as allcount');
		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		$this->db->where('a.status', 3);
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
		$this->db->group_by('d.product_id');
		$records = $this->db->get()->result();
		$totalRecordwithFilter = $records[0]->allcount;

		$this->db->select(
			'a.*, 
			c.stockrequests_details_id, c.batch_id, SUM(c.quantity) AS quantity, c.rate, c.manufacturer_rate, c.total_price,
			d.product_id, d.product_name, d.strength, d.product_details, d.product_model, d.price'
		);

		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		$this->db->where('a.status', 3);
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
		$this->db->group_by('d.product_id');
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get()->result();

		$data = array();
		$sl = 1;
		if (isset($records) && count($records) > 0) {
			foreach ($records as $record) {
				$base_url = base_url();
				
				$data[] = array(
					'sl' => $sl,
					'date' => $record->date,
					'product_name' => $record->product_name,
					'product_model' => $record->product_model,
					'batch_id' => $record->batch_id,
					'quantity' => $record->quantity,
					'price' => $record->price
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

	public function retrieve_stockrequest_editdata($stockrequest_id)
	{
		$this->db->select('a.*, c.*, c.batch_id, c.product_id, d.product_name, d.product_model, d.unit');
		$this->db->from('stockrequests a');
		$this->db->join('stockrequests_details c', 'c.stockrequests_id = a.stockrequests_id');
		$this->db->join('product_information d', 'd.product_id = c.product_id');
		$this->db->where('a.stockrequests_id', $stockrequest_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
			return $query->result_array();
		return false;
	}
	
	public function get_total_product_quantity($product_id){
		$this->db->select('*');
		$this->db->from('product_information');
		$this->db->where(array(
			'product_id'	=>	$product_id,
			'status'		=>	1
		));
		$product_information = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_stocks');
		$this->db->from('stockrequests_details b');
		$this->db->where('b.product_id', $product_id);
		$this->db->where('b.mr_id', $this->session->userdata('user_id'));
		$total_stocks	=	$this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.type_of_invoice', 1);
		$this->db->where('created_by_mr', $this->session->userdata('user_id'));
		$this->db->where('b.product_id', $product_id);
		$total_sale = $this->db->get()->row();

		$available_quantity = ($total_stocks->total_stocks - $total_sale->total_sale);

		$CI =& get_instance();
		$CI->load->model('Web_settings');
		$CI->load->model('Products');
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $content = $CI->Products->batch_search_item($product_id);

		$html = "";
        if(empty($content))	$html .="No Product Found !";
		else{
			$html .="<select name=\"batch_id[]\"   class=\"batch_id_1 form-control\" id=\"batch_id_1\" required=\"required\">";
	        	$html .= "<option>".display('select_one')."</option>";
	        	foreach ($content as $product) {
	    			$html .="<option value=".$product['batch_id'].">".$product['batch_id']."</option>";
	        	}	
	        $html .="</select>";
		}

		$tablecolumn	=	$this->db->list_fields('tax_collection');
        $num_column 	=	count($tablecolumn)-4;
		$taxfield		=	'';
		$taxvar 		=	[];
		for($i=0; $i<$num_column; $i++){
			$taxfield 			= 	'tax'.$i;
			$data2[$taxfield] 	= 	$product_information->$taxfield;
			$taxvar[$i]       	= 	$product_information->$taxfield;
			$data2['taxdta']  	=	$taxvar;
		}

		$data2['total_product']      = $available_quantity; 
		$data2['manufacturer_price'] = $product_information->manufacturer_price; 
		$data2['price'] 	         = $product_information->price; 
		$data2['manufacturer_id'] 	 = $product_information->manufacturer_id;
		$data2['unit'] 	 		     = $product_information->unit;
		$data2['tax'] 	 		     = $product_information->tax;
		$data2['tax0'] 	 		     = $product_information->tax0;
		$data2['batch'] 	 	     = $html;
		$data2['discount_type']      = $currency_details[0]['discount_type'];
		$data2['txnmber']            = $num_column;
		$data['user_id']        =   $this->session->userdata('user_id');

		return $data2;
	}

	public function get_total_product_batch($batch_id){
		$CI =& get_instance();
		$CI->load->model('Web_settings');
		
		$this->db->select('a.expeire_date, a.product_id, a.tax0');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.batch_id', $batch_id);
		$this->db->order_by('a.id','desc');
		$total_purchase = $this->db->get()->row();

		$this->db->select('user_id');
		$this->db->from('customer_information');
		$this->db->where('user_ref_id', $createby);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$dts = $query->result_array();	
			$mr_id = $dts[0]['user_id'];
		}

		$this->db->select('SUM(quantity) as total_sale');
		$this->db->from('invoice_details');
		$this->db->where('type_of_invoice', 2);
		$this->db->where('created_by_mr', $this->session->userdata('user_id'));
		$this->db->where('product_id', $total_purchase->product_id);
		$this->db->where('batch_id', $batch_id);
		$total_sale = $this->db->get()->row();

		$this->db->select('SUM(quantity) as total_stocks, d.item_rate');
		$this->db->from('stockrequests_details AS s');
		$this->db->join('product_information d', 'd.product_id = s.product_id');
		$this->db->where('s.product_id', $total_purchase->product_id);
		$this->db->where('s.batch_id', $batch_id);
		$this->db->where('s.mr_id', $this->session->userdata('user_id'));
		$total_stocks	=	$this->db->get()->row();

        $item_rate = $total_stocks->item_rate;

		$available_quantity = ($total_stocks->total_stocks - $total_sale->total_sale);


		$currency_details 		= 	$CI->Web_settings->retrieve_setting_editdata();		
		$data['total_product'] 	= 	$available_quantity;
		$data['expire_date']   	= 	$total_purchase->expeire_date;
		$data['totalRecords']   = 	0;
		$data['total_sale']		= 	$total_sale;
		$data['total_purchase'] = 	$total_purchase;
		$data['tax0']           = 	$total_purchase->tax0;
		$data['user_id']        =   $this->session->userdata('user_id');
        $data['item_rate']      = 	$item_rate;
        
        $data['query'] = 'SELECT * FROM stockrequests_details AS s JOIN product_information d ON d.product_id = s.product_id WHERE s.product_id='.$total_purchase->product_id.' AND s.batch_id=\''.$batch_id.'\' AND s.mr_id='.$this->session->userdata('user_id');
		$data['query_s'] = 'SELECT * FROM invoice_details WHERE type_of_invoice=\'2\' AND created_by_mr='.$this->session->userdata('user_id').' AND product_id='.$total_purchase->product_id.' AND batch_id=\''.$batch_id.'\'';
		
		return $data;
	}
	
	public function get_total_product_batch_onss($batch_id, $mr_id){
		$CI =& get_instance();
		$CI->load->model('Web_settings');
		
		$item_rate = 0;
		
		$this->db->select('a.expeire_date, a.product_id, a.tax0');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.batch_id', $batch_id);
		$this->db->order_by('a.id', 'desc');
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(quantity) as total_sale');
		$this->db->from('invoice_details');
		$this->db->where('type_of_invoice', 2);
		$this->db->where('created_by_mr', $mr_id);
		$this->db->where('product_id', $total_purchase->product_id);
		$this->db->where('batch_id', $batch_id);
		$total_sale = $this->db->get()->row();

		$this->db->select('SUM(quantity) as total_stocks, d.item_rate');
		$this->db->from('stockrequests_details AS s');
		$this->db->join('product_information d', 'd.product_id = s.product_id');
		$this->db->where('s.product_id', $total_purchase->product_id);
		$this->db->where('s.batch_id', $batch_id);
		$this->db->where('s.mr_id', $mr_id);
		$total_stocks	    =	$this->db->get()->row();
		
		$item_rate = $total_stocks->item_rate;
		
		$available_quantity =   ($total_stocks->total_stocks - $total_sale->total_sale);

		$currency_details 		= 	$CI->Web_settings->retrieve_setting_editdata();		
		$data['total_product'] 	= 	$available_quantity;
		$data['expire_date']   	= 	$total_purchase->expeire_date;
		$data['totalRecords']   = 	0;
		$data['total_sale']		= 	$total_sale;
		$data['total_purchase'] = 	$total_purchase;
		$data['tax0']           = 	$total_purchase->tax0;
		$data['user_id']        =   $this->session->userdata('user_id');
		$data['item_rate']      = 	$item_rate;

		return $data;
	}
}