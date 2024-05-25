<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ctarget extends CI_Controller {
	public $menu;
	function __construct() {
      	parent::__construct();
		$this->load->library('auth');
		$this->load->library('ltarget');
		$this->load->library('session');
		$this->load->model('Targets');
		$this->auth->check_admin_auth();
    }

	//Default loading for Customer System. DONE
	public function index()
	{
		//Calling Customer add form which will be loaded by help of "ltarget, located in library folder"
		$content = $this->ltarget->add_form();
		//Here ,0 means array position 0 will be active class

		$this->template->full_admin_html_view($content);
	}

	//customer_search_item DONE
	public function search_item()
	{
		$id = $this->input->post('id');	
		$content = $this->ltarget->search_item($id);
		$this->template->full_admin_html_view($content);
	}	

	//DONE
	public function manage_target() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('ltarget');
        $CI->load->model('Targets');
        $content =$this->ltarget->list();
        $this->template->full_admin_html_view($content);
    }

	// GET data DONE
    public function CheckList(){        
        $this->load->model('Targets');
        $postData = $this->input->post();
        $data = $this->Targets->getList($postData);
        echo json_encode($data);
    } 
	
	//Insert Product and upload DONE 
	public function insert_target() {
	  	//Customer  basic information adding.
		$data=array(
			'mr_id'			=>	$this->input->post('mr_id'),
			'minpurchase'	=>	$this->input->post('minpurchase'),
			'maxpurchase'	=> 	$this->input->post('maxpurchase'),
			'commission' 	=>	$this->input->post('commission'),
			'commission_type' 	=>	$this->input->post('commission_type'),
			'note' 	=>	$this->input->post('note')
		);
		$this->db->insert('targets', $data);
		$id = $this->db->insert_id();
						
		$this->session->set_userdata(array('message'=>display('successfully_added')));
		if(isset($_POST['add-target'])){
			redirect(base_url('Ctarget/manage_target'));
			exit;
		}
		elseif(isset($_POST['add-new-another'])){
			redirect(base_url('Ctarget'));
			exit;
		}		
	}

	//customer Update Form DONE
	public function update_form($id)
	{	
		$content = $this->ltarget->edit_data($id);
		$this->template->full_admin_html_view($content);
	}
	
	// customer Update DONE
	public function update()
	{
		$this->load->model('Targets');
		$id = $this->input->post('id');
        $data = array(
			'mr_id'			=>	$this->input->post('mr_id'),
			'minpurchase'	=>	$this->input->post('minpurchase'),
			'maxpurchase'	=> 	$this->input->post('maxpurchase'),
			'commission' 	=>	$this->input->post('commission'),
			'commission_type' 	=>	$this->input->post('commission_type'),
			'note' 	=>	$this->input->post('note')
		);
		$result = $this->Targets->update($data, $id);
		if($result == TRUE) {
			$this->session->set_userdata(array('message' => display('successfully_updated')));
			redirect(base_url('Ctarget/manage_target'));
			exit;
		}
		else{
			$this->session->set_userdata(array('error_message' => display('please_try_again')));
			redirect(base_url('Ctarget'));  
		}
	}

	// product_delete DONE
	public function delete($id){	
		$this->load->model('Targets');
		$clientinfo = $this->db->select('id')->from('targets')->where('id', $id)->get()->row();
        $this->Targets->delete($id);
		$this->session->set_userdata(array('message'=>display('successfully_delete')));
		redirect(base_url('Ctarget/manage_target'));
	}				
}