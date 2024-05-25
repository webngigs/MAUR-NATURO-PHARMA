<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cclient extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lclient');
		$this->load->library('session');
		$this->load->model('Clients');
		$this->auth->check_admin_auth();
    }

	//Default loading for Customer System. DONE
	public function index()
	{
		//Calling Customer add form which will be loaded by help of "lclient,located in library folder"
		$content = $this->lclient->client_add_form();
		//Here ,0 means array position 0 will be active class
		$this->template->full_admin_html_view($content);
	}

	//customer_search_item DONE
	public function client_search_item()
	{
		$client_id = $this->input->post('client_id');	
		$content = $this->lclient->client_search_item($client_id);
		$this->template->full_admin_html_view($content);
	}	

	//DONE
	public function manage_client() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lclient');
        $CI->load->model('Clients');
        $content =$this->lclient->client_list();
        $this->template->full_admin_html_view($content);
    }

	// GET data DONE
    public function CheckClientList(){        
        $this->load->model('Clients');
        $postData = $this->input->post();
        $data = $this->Clients->getClientList($postData);
        echo json_encode($data);
    } 
	
	//Insert Product and upload DONE 
	public function insert_client()
	{

		$dataUser = array(
			'user_id'			=>	null,
			'first_name'		=>	$this->input->post('client_name'),
			'status'			=>	1
		);
		$this->db->insert('users', $dataUser);
        $insert_id = $this->db->insert_id();
		
		$password = $this->input->post('password');
		$password = md5("gef".$password);
		
		$dataUserLogin = array(
			'user_id'			=>	$insert_id,
			'username'			=>	$this->input->post('email'),
			'password'		    =>	$password,
			'user_type'			=>	4,
			'security_code'		=>  '',
			'status'			=>	1
		);
		$this->db->insert('user_login', $dataUserLogin);

	  	//Customer  basic information adding.
		$data=array(
			'user_ref_id' 		=> 	$insert_id,
			'user_id' 			=> 	$this->session->userdata('user_id'),
			'client_name' 		=> 	$this->input->post('client_name'),
			'client_address'	=> 	$this->input->post('address'),
			'client_mobile' 	=> 	$this->input->post('mobile'),
			'client_email' 		=> 	$this->input->post('email'),
			'client_password' 	=> 	$password,
			'status' 			=>	1
		);
		$this->db->insert('client_information', $data);
		$client_id = $this->db->insert_id();
						
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-client'])){
			redirect(base_url('Cclient/manage_client'));
			exit;
		}
		elseif(isset($_POST['add-client-another'])){
			redirect(base_url('Cclient'));
			exit;
		}		
	}

	//customer Update Form DONE
	public function client_update_form($client_id)
	{	
		$content = $this->lclient->client_edit_data($client_id);
		$this->template->full_admin_html_view($content);
	}
	
	// customer Update DONE
	public function client_update()
	{
		$this->load->model('Clients');
		$client_id 	= $this->input->post('client_id');
		$user_ref_id 	= $this->input->post('user_ref_id');

		$password = $this->input->post('password');
		$password = md5("gef".$password);

        $data = array(
			'client_name' 		=> 	$this->input->post('client_name'),
			'client_address'	=> 	$this->input->post('address'),
			'client_mobile' 	=>	$this->input->post('mobile'),
			'client_email' 		=> 	$this->input->post('email'),
			'client_password' 	=> 	$password
		);
		$result = $this->Clients->update_client($data, $client_id);
		if($result == TRUE) {
			$first_name = 	$this->input->post('client_name');
			$user_name	=	$this->input->post('email');

			$this->db->query("UPDATE `users` AS `a`,`user_login` AS `b` SET `a`.`first_name` = '$first_name', `b`.`username` = '$user_name', WHERE `a`.`user_id` = '$user_ref_id' AND `a`.`user_id` = `b`.`user_id`");

			$this->session->set_userdata(array('message' => display('successfully_updated')));
			redirect(base_url('Cclient/manage_client'));
			exit;
		}
		else{
			$this->session->set_userdata(array('error_message' => display('please_try_again')));
			redirect(base_url('Cclient'));  
		}
	}
	// product_delete DONE
	public function client_delete($client_id){	
		$this->load->model('Clients');
		$clientinfo = $this->db->select('client_name')->from('client_information')->where('client_id', $client_id)->get()->row();
        $this->Clients->delete_client($client_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect(base_url('Cclient/manage_client'));
	}				
}