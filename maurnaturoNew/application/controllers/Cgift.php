<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cgift extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lgift');
		$this->load->library('session');
		$this->load->model('Gifts');
		$this->auth->check_admin_auth();
    }

	//Default loading for gift System. DONE
	public function index()
	{
		//Calling gift add form which will be loaded by help of "lgift,located in library folder"
		$content = $this->lgift->gift_add_form();
		//Here ,0 means array position 0 will be active class
		$this->template->full_admin_html_view($content);
	}

	//gift_search_item DONE
	public function gift_search_item()
	{
		$gift_id = $this->input->post('gift_id');	
		$content = $this->lgift->gift_search_item($gift_id);
		$this->template->full_admin_html_view($content);
	}	

	//DONE
	public function manage_gift() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lgift');
        $CI->load->model('Gifts');
        $content =$this->lgift->gift_list();
        $this->template->full_admin_html_view($content);
    }

	public function gift_request(){
		$CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lgift');
        $CI->load->model('Gifts');
        $content =$this->lgift->gift_request_list();
        $this->template->full_admin_html_view($content);	
	}

	// GET data DONE
    public function CheckGiftList(){        
        $this->load->model('Gifts');
        $postData = $this->input->post();
        $data = $this->Gifts->getGiftList($postData);
        echo json_encode($data);
    } 

	public function CheckGiftRequestList(){
		$this->load->model('Gifts');
        $postData = $this->input->post();
        $data = $this->Gifts->getGiftRequestList($postData);
        echo json_encode($data);
	}
	
	//Insert Product and upload DONE 
	public function insert_gift()
	{
	  	//gift  basic information adding.
		$data=array(
			'name' 		=> 	$this->input->post('gift_name'),
			'photo' 	=> 	$this->input->post('gift_photo'),
			'amount' 	=> 	$this->input->post('gift_amount'),
			'mintarget'	=> 	$this->input->post('minimum_target')			
		);
		$this->db->insert('gifts', $data);
		$gift_id = $this->db->insert_id();
						
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-gift'])){
			redirect(base_url('Cgift/manage_gift'));
			exit;
		}
		elseif(isset($_POST['add-gift-another'])){
			redirect(base_url('Cgift'));
			exit;
		}		
	}

	//gift Update Form DONE
	public function gift_update_form($id)
	{	
		$content = $this->lgift->gift_edit_data($id);
		$this->template->full_admin_html_view($content);
	}
	
	// gift Update DONE
	public function gift_update()
	{
		$this->load->model('Gifts');
		$gift_id = $this->input->post('gift_id');
        $data = array(
			'name' 		=> 	$this->input->post('gift_name'),
			'photo' 	=> 	$this->input->post('gift_photo'),
			'amount' 	=> 	$this->input->post('gift_amount'),
			'mintarget' => 	$this->input->post('minimum_target')			
		);
		$result = $this->Gifts->update_gift($data, $gift_id);
		if($result == TRUE) {
			$this->session->set_userdata(array('message' => display('successfully_updated')));
			redirect(base_url('Cgift/manage_gift'));
			exit;
		}
		else{
			$this->session->set_userdata(array('error_message' => display('please_try_again')));
			redirect(base_url('Cgift'));  
		}
	}
	// gift_delete DONE
	public function gift_delete($gift_id){	
		$this->load->model('Gifts');
		$giftinfo = $this->db->select('name')->from('gifts')->where('id', $gift_id)->get()->row();
        $this->Gifts->delete_gift($gift_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect(base_url('Cgift/manage_gift'));
	}	
	
	public function request_for_gift(){
		$data=array(
			'gift_id' 		=> 	$this->input->post('gift_id'),
			'customer_id' 	=> 	$this->session->userdata('user_id'),
			'gift_amount'	=>	$this->input->post('gift_amount')
		);
		$this->db->insert('gift_request', $data);
		$gift_request_id = $this->db->insert_id();
		$data = array();
		$data['status'] = true;
		$data['gift_request_id'] = $gift_request_id;
		echo json_encode($data);
	}

	public function claimGiftRequestApprove(){
		$this->db->where('id', $this->input->post('gift_request_id'));
		$this->db->update('gift_request', array('status' => 3));
		$data = array();
		$data['status'] = true;
		echo json_encode($data);
	}

	public function claimGiftRequestCancel(){
		$this->db->where('id', $this->input->post('gift_request_id'));
		$this->db->update('gift_request', array('status' => 2));
		$data = array();
		$data['status'] = true;
		echo json_encode($data);
	}
}