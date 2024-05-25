<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cmr extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		
		$this->load->library('lmr');
		$this->load->library('session');
		$this->load->model('Mrs');
		$this->load->model('Permission_model');
		$this->auth->check_admin_auth();
    }

	//Default loading for Customer System. DONE
	public function index()
	{
		//Calling Customer add form which will be loaded by help of "lmr,located in library folder"
		$content = $this->lmr->mr_add_form();
		$this->template->full_admin_html_view($content);
	}

	//customer_search_item DONE
	public function mr_search_item()
	{
		$mr_id = $this->input->post('mr_id');	
		$content = $this->lmr->mr_search_item($mr_id);
		$this->template->full_admin_html_view($content);
	}	

	//DONE
	public function manage_mr() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lmr');
        
        
        
        $CI->load->model('Mrs');
        $content =$this->lmr->mr_list();
        $this->template->full_admin_html_view($content);
    }

	// GET data DONE
    public function CheckMrList(){        
        $this->load->model('Mrs');
        
        
        
        $postData = $this->input->post();
        $data = $this->Mrs->getMrList($postData);
        echo json_encode($data);
    } 
	
	//Insert Product and upload DONE 
	public function insert_mr()
	{
		$dataUser = array(
			'user_id'			=>	null,
			'first_name'		=>	$this->input->post('mr_name'),
			'status'			=>	1
		);
		$this->db->insert('users', $dataUser);
        $insert_id = $this->db->insert_id();
		
		$mr_password = $this->input->post('mr_password');
		$mr_password = md5("gef".$mr_password);
		
		$dataUserLogin = array(
			'user_id'			=>	$insert_id,
			'username'			=>	$this->input->post('mr_email'),
			'password'			=>	$mr_password,
			'user_type'			=>	3,
			'security_code'		=>  '',
			'status'			=>	1,
		);
		$this->db->insert('user_login', $dataUserLogin);

		$sec_userrole = array(
			'user_id' 		=>	$insert_id,
			'roleid'		=>	1,
			'createby'		=>	$this->session->userdata('user_id'),
			'createdate'	=>	date('Y-m-d H:i:s')
		);
		$this->db->insert('sec_userrole', $sec_userrole);
		$id = $this->db->insert_id();

		$accesslog = array(
			'action_page' 	=>	'User Role',
			'action_done' 	=> 	'create',
			'remarks' 		=> 	'Role id :' . $id,
			'user_name' 	=> 	$this->session->userdata('user_id'),
			'entry_date' 	=> 	date('Y-m-d H:i:s')
		);
		$this->db->insert('accesslog', $accesslog);

	  	//Customer  basic information adding.
		$data = array(
			'user_id'	        	    =>	$insert_id,
			'mr_name' 		            => 	$this->input->post('mr_name'),
			'mr_address'                => 	$this->input->post('mr_address'),
			'mr_mobile' 	            => 	$this->input->post('mr_mobile'),
			'mr_email' 		            => 	$this->input->post('mr_email'),
			'mr_password' 	            => 	$this->input->post('mr_password'),
			'status' 		            =>	1,
            'reference_by_joining'      =>  $this->input->post('reference_by_joining'),
			'joining_date' 	            => 	$this->input->post('joining_date'),
			'area_cover' 	            => 	$this->input->post('area_cover'),
			'police_verfication_date' 	=> 	$this->input->post('police_verfication_date'),
			'police_verfication_no' 	=> 	$this->input->post('police_verfication_no'),
			'whatsapp_no' 	            => 	$this->input->post('whatsapp_no'),
			'other_contact_no' 	        => 	$this->input->post('other_contact_no'),
			
			
			'pancard' 	            => 	$this->input->post('pancard'),
			'aadharcard' 	        => 	$this->input->post('aadharcard'),
			'account_holder_name' 	=> 	$this->input->post('account_holder_name'),
			'account_number' 	    => 	$this->input->post('account_number'),
			'bank_name' 	        => 	$this->input->post('bank_name'),
			'ifsc_code' 	        => 	$this->input->post('ifsc_code'),
			'idno' 	                => 	$this->input->post('idno'),
		);

		$this->load->library('upload');

	    if (($_FILES['id_proff']['name'])) {
            $files = $_FILES;
            $config=array();
            $config['upload_path'] ='assets/dist/img/id_proff/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = '1000000';
            $config['max_width']     = '1024000';
            $config['max_height']    = '768000';
            $config['overwrite']     = FALSE;
            $config['encrypt_name']  = true; 

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('id_proff')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('Cmr');
            } else {
                $view =$this->upload->data();
                $id_proff	=	base_url($config['upload_path'].$view['file_name']);
				$data['id_proff'] = $id_proff;
            }
        }
        
        if (($_FILES['mr_photo']['name'])) {
            $files = $_FILES;
            $config=array();
            $config['upload_path'] ='assets/dist/img/mr_photo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = '1000000';
            $config['max_width']     = '1024000';
            $config['max_height']    = '768000';
            $config['overwrite']     = FALSE;
            $config['encrypt_name']  = true; 

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('mr_photo')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('Cmr');
            } else {
                $view =$this->upload->data();
                $mr_photo	=	base_url($config['upload_path'].$view['file_name']);
				$data['mr_photo'] = $mr_photo;
            }
        }

		$this->db->insert('mr_information', $data);
		$mr_id = $this->db->insert_id();
						
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-mr'])){
		    
		    $message = 'Hi '.$this->input->post('mr_name').',<br/>';
		    $message .= '<br/>Please find your login details:';
		    $message .= '<br/>================================<br/><br/>Login URl: <a href="https://app.maurnaturo.com/">https://app.maurnaturo.com/</a>';
		    $message .= '<br/>Login ID: '.$this->input->post('mr_email');
		    $message .= '<br/>Password: '.$this->input->post('mr_password');
		    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
		    
		    $this->load->library('email');
            $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
            $this->email->to($this->input->post('mr_email'));
            $this->email->subject('Your Login Details for app.maurnaturo.com');
            $this->email->message($message);
            $this->email->set_mailtype('html');
            $this->email->send();
		    
		    redirect(base_url('Cmr/manage_mr'));
			exit;
		}
		elseif(isset($_POST['add-mr-another'])){
			redirect(base_url('Cmr'));
			exit;
		}		
	}
	
	public function mr_change_password($mr_id)
	{	
		$content = $this->lmr->mr_change_password($mr_id);
		$this->template->full_admin_html_view($content);
	}

	//customer Update Form DONE
	public function mr_update_form($mr_id)
	{	
		$content = $this->lmr->mr_edit_data($mr_id);
		$this->template->full_admin_html_view($content);
	}
	
	public function mr_update_password(){
	    $this->load->model('Mrs');
		$mr_id    =   $this->input->post('mr_id');
		$user_id  =   $this->input->post('user_id');
		
		$password 	    =   $this->input->post('password');  
		$password = md5("gef".$password);
		
		$data = array('mr_password' => $this->input->post('password'));
		$this->Mrs->update_mr($data, $mr_id);
		
		$this->db->query("UPDATE `user_login` SET `password` = '$password' WHERE `user_id`='$user_id'");

		$this->session->set_userdata(array('message' => display('successfully_updated')));
		redirect(base_url('Cmr/manage_mr'));
		exit;
	}
	
	// customer Update DONE
	public function mr_update()
	{
		$this->load->model('Mrs');
		$mr_id = $this->input->post('mr_id');
		$user_id = $this->input->post('user_id');

		$mr_password = $this->input->post('mr_password');
		$mr_password = md5("gef".$mr_password);

        $data = array(
			'mr_name' 	            	=> 	$this->input->post('mr_name'),
			'mr_address'             	=> 	$this->input->post('mr_address'),
			'mr_mobile' 	            =>	$this->input->post('mr_mobile'),
			'mr_email' 		            => 	$this->input->post('mr_email'),
			'reference_by_joining'      =>  $this->input->post('reference_by_joining'),
			'joining_date' 	            => 	$this->input->post('joining_date'),
			'area_cover' 	            => 	$this->input->post('area_cover'),
			'police_verfication_date' 	=> 	$this->input->post('police_verfication_date'),
			'police_verfication_no' 	=> 	$this->input->post('police_verfication_no'),
			'id_proff'                	=> 	$this->input->post('id_proff'),
			'whatsapp_no' 	            => 	$this->input->post('whatsapp_no'),
			'other_contact_no' 	        => 	$this->input->post('other_contact_no'),
			'pancard' 	        => 	$this->input->post('pancard'),
			'aadharcard' 	        => 	$this->input->post('aadharcard'),
			'account_holder_name' 	        => 	$this->input->post('account_holder_name'),
			'account_number' 	        => 	$this->input->post('account_number'),
			'bank_name' 	        => 	$this->input->post('bank_name'),
			'ifsc_code' 	        => 	$this->input->post('ifsc_code'),
			'idno' 	        => 	$this->input->post('idno'),
		);

		$this->load->library('upload');
		if (($_FILES['id_proff']['name'])) {
            $files = $_FILES;
            $config=array();
            $config['upload_path'] ='assets/dist/img/id_proff/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = '1000000';
            $config['max_width']     = '1024000';
            $config['max_height']    = '768000';
            $config['overwrite']     = FALSE;
            $config['encrypt_name']  = true; 

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('id_proff')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('Cmr');
            } else {
                $view =$this->upload->data();
                $id_proff	=	base_url($config['upload_path'].$view['file_name']);
				$data['id_proff'] = $id_proff;
            }
        }
        
        if (($_FILES['mr_photo']['name'])) {
            $files = $_FILES;
            $config=array();
            $config['upload_path'] ='assets/dist/img/mr_photo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = '1000000';
            $config['max_width']     = '1024000';
            $config['max_height']    = '768000';
            $config['overwrite']     = FALSE;
            $config['encrypt_name']  = true; 

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('mr_photo')) {
                $sdata['error_message'] = $this->upload->display_errors();
                $this->session->set_userdata($sdata);
                redirect('Cmr');
            } else {
                $view =$this->upload->data();
                $mr_photo	=	base_url($config['upload_path'].$view['file_name']);
				$data['mr_photo'] = $mr_photo;
            }
        }

		$result = $this->Mrs->update_mr($data, $mr_id);
		if($result == TRUE) {

			$first_name = 	$this->input->post('mr_name');
			$user_name	=	$this->input->post('mr_email');

			$this->db->query("UPDATE `users` AS `a`,`user_login` AS `b` SET `a`.`first_name` = '$first_name', `b`.`username` = '$user_name', `b`.`password` = '$password' WHERE `a`.`user_id` = '$user_id' AND `a`.`user_id` = `b`.`user_id`");

			$this->session->set_userdata(array('message' => display('successfully_updated')));
			redirect(base_url('Cmr/manage_mr'));
			exit;
		}
		else{
			$this->session->set_userdata(array('error_message' => display('please_try_again')));
			redirect(base_url('Cmr'));  
		}
	}
	// product_delete DONE
	public function mr_delete($mr_id){	
		$this->load->model('Mrs');
		$mrinfo = $this->db->select('mr_name')->from('mr_information')->where('mr_id', $mr_id)->get()->row();
        $this->Mrs->delete_mr($mr_id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect(base_url('Cmr/manage_mr'));
	}	
	
	public function stock_request(){
		$CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $CI->load->model('Stockrequests');
        $content = $this->lstockrequest->stockrequest_list();
        $this->template->full_admin_html_view($content);
	}
}