<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ccoupon extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('lcoupon');
		$this->load->library('session');
		$this->load->model('Coupons');
		$this->auth->check_admin_auth();
    }

	//Default loading for coupon System. DONE
	public function index()
	{
		//Calling coupon add form which will be loaded by help of "lcoupon,located in library folder"
		$content = $this->lcoupon->coupon_add_form();
		//Here ,0 means array position 0 will be active class
		$this->template->full_admin_html_view($content);
	}

	//coupon_search_item DONE
	public function coupon_search_item()
	{
		$coupon_id = $this->input->post('coupon_id');	
		$content = $this->lcoupon->coupon_search_item($coupon_id);
		$this->template->full_admin_html_view($content);
	}	

	//DONE
	public function manage_coupon() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lcoupon');
        $CI->load->model('Coupons');
        $content =$this->lcoupon->coupon_list();
        $this->template->full_admin_html_view($content);
    }

	// GET data DONE
    public function CheckCouponList(){        
        $this->load->model('Coupons');
        $postData = $this->input->post();
        $data = $this->Coupons->getCouponList($postData);
        echo json_encode($data);
    } 
	
	//Insert Product and upload DONE 
	public function insert_coupon()
	{
	  	//coupon  basic information adding.
		$data=array(
			'value' 		=> 	$this->input->post('value'),
			'amount' 		=> 	$this->input->post('amount'),
			'types' 		=> 	$this->input->post('types'),
			'start_date' 		=> 	$this->input->post('start_date'),
			'start_time' 		=> 	$this->input->post('start_time'),
			'expiry_date' 		=> 	$this->input->post('expiry_date'),
			'expiry_time' 		=> 	$this->input->post('expiry_time'),
			'minimum_purchase' 		=> 	$this->input->post('minimum_purchase'),
			'no_of_uses' 		=> 	$this->input->post('no_of_uses'),
			'freq_of_use_per_customer' 		=> 	$this->input->post('freq_of_use_per_customer'),
			
			
		);
		$this->db->insert('coupons', $data);
		$coupon_id = $this->db->insert_id();
						
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-coupon'])){
			redirect(base_url('Ccoupon/manage_coupon'));
			exit;
		}
		elseif(isset($_POST['add-coupon-another'])){
			redirect(base_url('Ccoupon'));
			exit;
		}		
	}

	//coupon Update Form DONE
	public function coupon_update_form($coupon_id)
	{	
		$content = $this->lcoupon->coupon_edit_data($coupon_id);
		$this->template->full_admin_html_view($content);
	}
	
	// coupon Update DONE
	public function coupon_update()
	{
		$this->load->model('Coupons');
		$coupon_id = $this->input->post('coupon_id');
        $data = array(
			'value' 		=> 	$this->input->post('value'),
			'amount' 		=> 	$this->input->post('amount'),
			'types' 		=> 	$this->input->post('types'),
			'start_date' 		=> 	$this->input->post('start_date'),
			'start_time' 		=> 	$this->input->post('start_time'),
			'expiry_date' 		=> 	$this->input->post('expiry_date'),
			'expiry_time' 		=> 	$this->input->post('expiry_time'),
			'minimum_purchase' 		=> 	$this->input->post('minimum_purchase'),
			'no_of_uses' 		=> 	$this->input->post('no_of_uses'),
			'freq_of_use_per_customer' 		=> 	$this->input->post('freq_of_use_per_customer'),
			
		);
		$result = $this->Coupons->update_coupon($data, $coupon_id);
		if($result == TRUE) {
			$this->session->set_userdata(array('message' => display('successfully_updated')));
			redirect(base_url('Ccoupon/manage_coupon'));
			exit;
		}
		else{
			$this->session->set_userdata(array('error_message' => display('please_try_again')));
			redirect(base_url('Ccoupon'));  
		}
	}
	// product_delete DONE
	public function coupon_delete($coupon_id){	
		$this->load->model('Coupons');
		$couponinfo = $this->db->select('coupon_name')->from('coupon')->where('coupon_id', $coupon_id)->get()->row();
        $this->Coupons->delete_coupon($coupon_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect(base_url('Ccoupon/manage_coupon'));
	}				
}