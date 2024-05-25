<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ccustomer extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lcustomer');
		$this->load->library('session');
		$this->load->model('Customers');
		
		$this->load->library('lpermission');
		$this->load->model('Permission_model');
		$this->auth->check_admin_auth();
    }

	//Default loading for Customer System.
	public function index()
	{
		//Calling Customer add form which will be loaded by help of "lcustomer,located in library folder"
		$content = $this->lcustomer->customer_add_form();
		//Here ,0 means array position 0 will be active class
		$this->template->full_admin_html_view($content);
	}

	//customer_search_item
	public function customer_search_item()
	{
		$customer_id = $this->input->post('customer_id');	
		$content = $this->lcustomer->customer_search_item($customer_id);
		$this->template->full_admin_html_view($content);
	}	

	//credit customer_search_item
	public function credit_customer_search_item()
	{
		$customer_id = $this->input->post('customer_id');	
		$content = $this->lcustomer->credit_customer_search_item($customer_id);
		$this->template->full_admin_html_view($content);
	}	

	//paid customer_search_item
	public function paid_customer_search_item()
	{
		$customer_id = $this->input->post('customer_id');	
		$content = $this->lcustomer->paid_customer_search_item($customer_id);
		$this->template->full_admin_html_view($content);
	}

	public function manage_customer() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lcustomer');
        $CI->load->model('Customers');
        $content =$this->lcustomer->customer_list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckCustomerList(){
        // GET data
        $this->load->model('Customers');
        $postData = $this->input->post();
        $data = $this->Customers->getCustomerList($postData);
        echo json_encode($data);
    } 

    //Product Add Form
    public function credit_customer() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lcustomer');
        $CI->load->model('Customers');
        $content = $this->lcustomer->credit_customer_list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckCreditCustomerList(){
        // GET data
        $this->load->model('Customers');
        $postData = $this->input->post();
        $data = $this->Customers->getCreditCustomerList($postData);
        echo json_encode($data);
    } 

    //Paid Customer list. The customer who will pay 100%.
    public function paid_customer() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lcustomer');
        $CI->load->model('Customers');
        $content = $this->lcustomer->paid_customer_list();
        $this->template->full_admin_html_view($content);        
    }
    
    public function ActiveOrInactiveCustomer(){
        $data=array(
			'status' => $this->input->post('status')
		);
        $this->db->where('user_id', $this->input->post('user_ref_id'));
		$this->db->update('user_login', $data);
		
		$data=array(
			'status' => $this->input->post('status')
		);
        $this->db->where('user_id', $this->input->post('user_ref_id'));
		$this->db->update('users', $data);
		
		$data=array(
			'status' => $this->input->post('status')
		);
        $this->db->where('user_ref_id', $this->input->post('user_ref_id'));
		$this->db->update('customer_information', $data);
    }
    
    public function CheckPaidCustomerList(){
        // GET data
        $this->load->model('Customers');
        $postData = $this->input->post();
        $data = $this->Customers->getPaidCustomerList($postData);
        echo json_encode($data);
    } 

	//Insert Product and upload
	public function insert_customer()
	{		
	    $roleid         =   2;
	    $create_by      =   $this->session->userdata('user_id');
	    
        $create_date    =   date('Y-m-d h:i:s');
        
        $vouchar_no = $this->auth->generator(10);
        
        $status = 1;
        $who_added = 1;
        if($this->session->userdata('user_type') == 3)  {
            $status = 2;
            $who_added = 2;
            $mr_id          =   $this->session->userdata('user_id');
        }
        
        if($this->session->userdata('user_type') == 1)  {
            $mr_id          =   $this->input->post('mr_id');    
        }
		
		$dataUser = array(
			'user_id'			=>	null,
			'first_name'		=>	$this->input->post('customer_name'),
			'status'			=>	$status,
		);
		$this->db->insert('users', $dataUser);
        $insert_id = $this->db->insert_id();
		
		$password = $this->input->post('password');
		$password = md5("gef".$password);
		
		$dataUserLogin = array(
			'user_id'			=>	$insert_id,
			'username'			=>	$this->input->post('customer_email'),
			'password'		    =>	$password,
			'user_type'			=>	4,
			'security_code'		=>  '',
			'status'			=>	$status,
		);
		$this->db->insert('user_login', $dataUserLogin);
		
		$data['role_data'] = (Object)$postData = array(
            'id'            =>  '',
            'user_id'       =>  $insert_id,
            'roleid'        =>  $roleid,
            'createby'      =>  $create_by,
            'createdate'    =>  $create_date
        );
        
        if ($this->Permission_model->role_create($postData)) {
            $id = $this->db->insert_id();
            $accesslog = array(
                'action_page'   =>  'User Role',
                'action_done'   =>  'create',
                'remarks'       =>  'Role id :' . $id,
                'user_name'     =>  $this->session->userdata('id'),
                'entry_date'    =>  date('Y-m-d H:i:s')
            );
            $this->db->insert('accesslog', $accesslog);
        }
		
	  	//Customer  basic information adding.
		$data = array(
			'user_ref_id' 		            => 	$insert_id,
			'user_id' 			            => 	$mr_id,
			'customer_types' 	            => 	$this->input->post('customer_types'),
			'customer_name' 	            => 	$this->input->post('customer_name'),
			'customer_address'	            => 	$this->input->post('customer_address'),
			'customer_mobile' 	            => 	$this->input->post('customer_mobile'),
			'customer_email' 	            => 	$this->input->post('customer_email'),
			'password'       	            => 	$this->input->post('password'),
			'status' 			            => 	1,
            'previous_balance'          	=> 	$this->input->post('previous_balance'),
			'area' 	                        => 	$this->input->post('area'),
			'district'                  	=> 	$this->input->post('district'),
			'state' 	                    => 	$this->input->post('state'),
			'state_code' 	                => 	$this->input->post('state_code'),
			'gst_no'                     	=> 	$this->input->post('gst_no'),
			'birthday_date' 	            => 	$this->input->post('birthday_date'),
			'marriage_anniversary_date' 	=> 	$this->input->post('marriage_anniversary_date'),
			'total_sale' 	                => 	$this->input->post('total_sale'),
			'discount' 	                    => 	$this->input->post('discount'),
			'pancard'                       => 	$this->input->post('pancard'),
			'rvc_no'                        => 	$this->input->post('rvc_no'),
			'text'                          => 	$this->input->post('text'),
			'who_added'                     =>  $who_added
		);
		
		$this->db->insert('customer_information',$data);
	
		$customer_id = $this->db->insert_id();
		$coa = $this->Customers->headcode();
        if($coa->HeadCode!=NULL){
            $headcode=$coa->HeadCode+1;
        }
		else{
            $headcode="10203000001";
        }
		$c_acc    = $this->input->post('customer_name').'-'.$customer_id;
		$createby  = $this->session->userdata('user_id');
		$createdate = date('Y-m-d H:i:s');
		$customer_coa = [
			'HeadCode'         => $headcode,
			'HeadName'         => $c_acc,
			'PHeadName'        => 'Customer Receivable',
			'HeadLevel'        => '4',
			'IsActive'         => '1',
			'IsTransaction'    => '1',
			'IsGL'             => '0',
			'HeadType'         => 'A',
			'IsBudget'         => '0',
			'IsDepreciation'   => '0',
			'DepreciationRate' => '0',
			'CreateBy'         => $createby,
			'CreateDate'       => $createdate,
        ];
		//Previous balance adding -> Sending to customer model to adjust the data.
		$this->db->insert('acc_coa',$customer_coa);
		$this->Customers->previous_balance_add($this->input->post('previous_balance'),$customer_id);
							
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-customer'])){
		    
		    $message = 'Hi '.$this->input->post('customer_name').',<br/>';
		    $message .= '<br/>Please find your login details:';
		    $message .= '<br/>================================<br/><br/>Login URl: <a href="https://app.maurnaturo.com/">https://app.maurnaturo.com/</a>';
		    $message .= '<br/>Login ID: '.$this->input->post('customer_email');
		    $message .= '<br/>Password: '.$this->input->post('password');
		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
		    
		    $this->load->library('email');
            $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
            $this->email->to($this->input->post('customer_email'));
            $this->email->subject('Your Login Details for app.maurnaturo.com');
            $this->email->message($message);
            $this->email->set_mailtype('html');
            $this->email->send();
		    
			redirect(base_url('Ccustomer/manage_customer'));
			exit;
		}elseif(isset($_POST['add-customer-another'])){
			redirect(base_url('Ccustomer'));
			exit;
		}		
	}
	//CSV Customer Add From here
	function uploadCsv_Customer()
    {
		$filename = $_FILES['upload_csv_file']['name'];  
		$ext = end(explode('.', $filename));
		$ext = substr(strrchr($filename, '.'), 1);
		if($ext == 'csv'){
			$count=0;
			$fp = fopen($_FILES['upload_csv_file']['tmp_name'],'r') or die("can't open file");

			if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE)
			{  
	     		while($csv_line = fgetcsv($fp,1024)){
					//keep this if condition if you want to remove the first row
					for($i = 0, $j = count($csv_line); $i < $j; $i++)
					{	               
						$insert_csv = array();
						$insert_csv['customer_name'] = (!empty($csv_line[0])?$csv_line[0]:null);
						$insert_csv['customer_email'] = (!empty($csv_line[1])?$csv_line[1]:'');
						$insert_csv['customer_mobile'] = (!empty($csv_line[2])?$csv_line[2]:'');
						$insert_csv['customer_address'] = (!empty($csv_line[3])?$csv_line[3]:'');
						$insert_csv['previousbalance'] = (!empty($csv_line[4])?$csv_line[4]:0);
					}
               
					$customerdata = array(
						'customer_name'    => $insert_csv['customer_name'],
						'customer_email'   => $insert_csv['customer_email'],
						'customer_mobile'  => $insert_csv['customer_mobile'],
						'customer_address' => $insert_csv['customer_address'],
						'status' 		   => 1,
					);

	            	if ($count > 0) {
						$this->db->insert('customer_information',$customerdata);
						$customer_id = $this->db->insert_id();
						$coa = $this->Customers->headcode();
                       	if($coa->HeadCode!=NULL){
                            $headcode=$coa->HeadCode+1;
                       	}else{
                            $headcode="102030001";
                        }
						$c_acc=$insert_csv['customer_name'].'-'.$customer_id;
						$createby=$this->session->userdata('user_id');
						$createdate=date('Y-m-d H:i:s');
						$transaction_id=$this->auth->generator(10);

						$ledger = array(
							'transaction_id' => $transaction_id,
							'customer_id' 	=> $customer_id,
							'invoice_no'    => "NA",
							'receipt_no' 	=> NULL,
							'amount' 		=> $insert_csv['previousbalance'],
							'description' 	=> "Previous adjustment with software",
							'payment_type' 	=> "NA",
							'cheque_no'     => "NA",
							'date' 		    => date("Y-m-d"),
							'status' 		=> 1,
							'd_c' 		    => "d"				
						);

						$customer_coa = [
							'HeadCode'         => $headcode,
							'HeadName'         => $c_acc,
							'PHeadName'        => 'Customer Receivable',
							'HeadLevel'        => '4',
							'IsActive'         => '1',
							'IsTransaction'    => '1',
							'IsGL'             => '0',
							'HeadType'         => 'A',
							'IsBudget'         => '0',
							'IsDepreciation'   => '0',
							'DepreciationRate' => '0',
							'CreateBy'         => $createby,
							'CreateDate'       => $createdate,
						];
               
						$cosdr = array(
							'VNo'            =>  $transaction_id,
							'Vtype'          =>  'PR Balance',
							'VDate'          =>  date("Y-m-d"),
							'COAID'          =>  $headcode,
							'Narration'      =>  'Customer debit For Transaction No'.$transaction_id,
							'Debit'          =>  $insert_csv['previousbalance'],
							'Credit'         =>  0,
							'IsPosted'       => 1,
							'CreateBy'       => $this->session->userdata('user_id'),
							'CreateDate'     => date('Y-m-d H:i:s'),
							'IsAppove'       => 1
						);
						$this->db->insert('customer_ledger', $ledger);
						$this->db->insert('acc_coa',$customer_coa);
						$this->db->insert('acc_coa',$cosdr);
	                }  
	            	$count++; 
	        	}	        
        	}
			$this->db->select('*');
			$this->db->from('customer_information');
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_customer[] = array('label'=>$row->customer_name,'value'=>$row->customer_id);
			}
			$cache_file ='./my-assets/js/admin_js/json/customer.json';
			$customerList = json_encode($json_customer);
			file_put_contents($cache_file,$customerList);
        	fclose($fp) or die("can't close file");
    		$this->session->set_userdata(array('message'=>display('successfully_added')));
			redirect(base_url('Ccustomer/manage_customer'));
		}
		else{
        	$this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
        	redirect(base_url('Ccustomer/manage_customer'));
    	}
    }

	//customer Update Form
	public function customer_update_form($customer_id)
	{	
		$content = $this->lcustomer->customer_edit_data($customer_id);
		$this->template->full_admin_html_view($content);
	}
	
	public function customer_change_password($customer_id)
	{	
		$content = $this->lcustomer->customer_change_password($customer_id);
		$this->template->full_admin_html_view($content);
	}
	
	public function customer_view($customer_id){
	    $content = $this->lcustomer->customer_view_data($customer_id);
		$this->template->full_admin_html_view($content);
	}
			
	//Customer Ledger
	public function customer_ledger($customer_id)
	{
		$content = $this->lcustomer->customer_ledger_data($customer_id);
		$this->template->full_admin_html_view($content);
	}
	
	//Customer Final Ledger
	public function customerledger($customer_id)
	{	
		$content = $this->lcustomer->customerledger_data($customer_id);
		$this->template->full_admin_html_view($content);
	}	
	//Customer Previous Balance
	public function previous_balance_form()
	{	
		$content = $this->lcustomer->previous_balance_form();
		$this->template->full_admin_html_view($content);
	}
	
	//customer_update_password
	public function customer_update_password(){
	    $this->load->model('Customers');
		$customer_id    =   $this->input->post('customer_id');
		$user_ref_id    =   $this->input->post('user_ref_id');
		
		$password 	    =   $this->input->post('password');  
		$password = md5("gef".$password);
		
		$data = array('password' => $this->input->post('password'));
		
		$this->Customers->update_customer($data, $customer_id);
		$this->db->query("UPDATE `user_login` SET `password` = '$password' WHERE `user_id`='$user_ref_id'");

		$this->session->set_userdata(array('message' => display('successfully_updated')));
		redirect(base_url('Ccustomer/manage_customer'));
		exit;
	}
	// customer Update
	public function customer_update()
	{
		$this->load->model('Customers');
		$customer_id = $this->input->post('customer_id');
		$user_ref_id 	= $this->input->post('user_ref_id');

        $old_headnam = $this->input->post('oldname').'-'.$customer_id;
        $c_acc       = $this->input->post('customer_name').'-'.$customer_id;
		
		$data = array(
			'customer_types' 	            => 	$this->input->post('customer_types'),
			'customer_name' 	            => 	$this->input->post('customer_name'),
			'customer_address'	            => 	$this->input->post('customer_address'),
			'customer_mobile' 	            => 	$this->input->post('customer_mobile'),
			'customer_email' 	            => 	$this->input->post('customer_email'),
            'previous_balance'          	=> 	$this->input->post('previous_balance'),
			'area' 	                        => 	$this->input->post('area'),
			'district'                  	=> 	$this->input->post('district'),
			'state' 	                    => 	$this->input->post('state'),
			'state_code' 	                => 	$this->input->post('state_code'),
			'gst_no'                     	=> 	$this->input->post('gst_no'),
			'birthday_date' 	            => 	$this->input->post('birthday_date'),
			'marriage_anniversary_date' 	=> 	$this->input->post('marriage_anniversary_date'),
			'total_sale' 	                => 	$this->input->post('total_sale'),
			'discount' 	                    => 	$this->input->post('discount'),
			'pancard'                       => 	$this->input->post('pancard'),
			'rvc_no'                        => 	$this->input->post('rvc_no'),
			'text'                          => 	$this->input->post('text')
		);
		
        // Customer Acc Coa update
        $customer_coa = [
            'HeadName'         => $c_acc
        ];
		$result = $this->Customers->update_customer($data, $customer_id);
		if ($result == TRUE) {
			$this->db->where('HeadName', $old_headnam);
			$this->db->update('acc_coa', $customer_coa);
			
			$first_name = 	$this->input->post('customer_name');
			$user_name	=	$this->input->post('customer_email');
			$this->db->query("UPDATE `users` AS `a`,`user_login` AS `b` SET `a`.`first_name` = '$first_name', `b`.`username` = '$user_name' WHERE `a`.`user_id` = '$user_ref_id' AND `a`.`user_id` = `b`.`user_id`");

			$this->session->set_userdata(array('message' => display('successfully_updated')));
			redirect(base_url('Ccustomer/manage_customer'));
			exit;
    	}
		else{
       		$this->session->set_userdata(array('error_message' => display('please_try_again')));
            redirect(base_url('Ccustomer'));  
    	}
	}
	// product_delete
	public function customer_delete($customer_id)
	{	
		$this->load->model('Customers');
		$customerinfo = $this->db->select('customer_name')->from('customer_information')->where('customer_id',$customer_id)->get()->row();
        $customer_head = $customerinfo->customer_name.'-'.$customer_id;
		$this->Customers->delete_customer($customer_id);
		$this->Customers->delete_customer_ledger($customer_id, $customer_head);
		$this->Customers->delete_invoic($customer_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect(base_url('Ccustomer/manage_customer'));
	}			
}