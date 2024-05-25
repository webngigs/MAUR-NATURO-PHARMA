<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Cstockrequest extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $content = $CI->lstockrequest->stockrequest_add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert_stockrequest()
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Stockrequests');
        $stockrequests_id = $CI->Stockrequests->stockrequest_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect("Cstockrequest/stockrequests_inserted_data/" . $stockrequests_id);
    }

    public function stockrequest_update_form($stockrequests_id)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $content = $CI->lstockrequest->stockrequests_edit_data($stockrequests_id);
        $this->template->full_admin_html_view($content);
    }

    public function stockrequest_update()
    {

    }

    public function manage_stockrequest()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $CI->load->model('Stockrequests');
        $content = $this->lstockrequest->stockrequest_list();
        $this->template->full_admin_html_view($content);
    }

    public function customer_stockrequest()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $CI->load->model('Stockrequests');
        $content = $this->lstockrequest->customer_stockrequest_list();
        $this->template->full_admin_html_view($content);
    }

    public function stockrequest_delete($stockrequest_id)
    {

    }

    public function product_stock_check($product_id)
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Stockrequests');
        $CI->load->model('Invoices');

        $purchase_stocks = $CI->Invoices->get_total_purchase_item($product_id);
        $total_purchase = 0;
        if (!empty($purchase_stocks)) {
            foreach ($purchase_stocks as $k => $v) {
                $total_purchase = ($total_purchase + $purchase_stocks[$k]['quantity']);
            }
        }

        $sales_stocks = $CI->Invoices->get_total_sales_item($product_id);
        $total_sales = 0;
        if (!empty($sales_stocks)) {
            foreach ($sales_stocks as $k => $v) {
                $total_sales = ($total_sales + $sales_stocks[$k]['quantity']);
            }
        }

        $final_total = ($total_purchase - $total_sales);
        return $final_total;
    }

    public function stockrequests_inserted_data($stockrequest_id)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $content = $CI->lstockrequest->stockrequest_html_data($stockrequest_id);
        $this->template->full_admin_html_view($content);
    }

    public function CheckStockRequestList()
    {
        $this->load->model('Stockrequests');
        $postData = $this->input->post();
        $data = $this->Stockrequests->getStockRequestsList($postData);
        echo json_encode($data);
    }

    public function CheckCustomerStockRequestList()
    {
        $this->load->model('Stockrequests');
        $postData = $this->input->post();
        $data = $this->Stockrequests->getCustomerStockRequestsList($postData);
        echo json_encode($data);
    }

    public function ApproveStockRequest()
    {
        $updateData = array('status' => 3);
        $this->db->where('stockrequests_id', $this->input->post('stockrequest_id'));
        $this->db->update('stockrequests', $updateData);
        $data = [
            'status' => true,
            'message' => 'Challan Successfully Approved',
        ];
        echo json_encode($data);
    }

    public function CancelledStockRequest()
    {
        $updateData = array('status' => 2);
        $this->db->where('stockrequests_id', $this->input->post('stockrequest_id'));
        $this->db->update('stockrequests', $updateData);
        $data = [
            'status' => true,
            'message' => 'Challan Successfully Cancelled',
        ];
        echo json_encode($data);
    }

    public function ReceivedStockRequest()
    {
        $updateData = array('status' => 4);
        $this->db->where('stockrequests_id', $this->input->post('stockrequest_id'));
        $this->db->update('stockrequests', $updateData);
        $data = [
            'status' => true,
            'message' => 'Challan Successfully Received',
        ];
        
        $this->db->select('stockrequests, mr_id');
		$this->db->from('stockrequests');
		$this->db->where(array('stockrequests_id' => $this->input->post('stockrequest_id')));
		$query = $this->db->get();
		$dts = $query->result_array();
		$mr_id = $dts[0]['mr_id'];
		
		$this->db->select('user_id, mr_email, mr_name');
		$this->db->from('mr_information');
		$this->db->where('mr_id', $mr_id);
		$querys = $this->db->get();
		if($querys->num_rows() > 0) {
			$dtss = $querys->result_array();
        
            $this->load->library('email');
    				
    		$message = 'Hi '.$dtss[0]['mr_name'].',<br/>';
    	    $message .= '<br/>Received Stock Transfer Request ID#'.$stockrequests_no.' from Maurnaturo Team';
    	    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    	    
            $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
            $this->email->to($dtss[0]['mr_email']);
            $this->email->subject('Received Stock Transfer Request ID#'.$stockrequests_no);
            $this->email->message($message);
            $this->email->set_mailtype('html');
            $this->email->send();
            
            $message = 'Hi Admin,<br/>';
    	    $message .= '<br/>Received Stock Transfer Request ID#'.$stockrequests_no.' by '.$dtss[0]['mr_name'];
    	    $message .= '<br/><br/>--<br/>Thanks and Regards,<br/>Maurnaturo Team';
    	    
            $this->email->from('maurservicesjr@gmail.com', 'Maurnaturo Team');
            $this->email->to('maurservicesjr@gmail.com');
            $this->email->subject('Received Stock Transfer Request ID#'.$stockrequests_no.' by '.$dtss[0]['mr_name']);
            $this->email->message($message);
            $this->email->set_mailtype('html');
            $this->email->send();
		}
        echo json_encode($data);
    }

    public function mr_autocomplete()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Mrs');
        $mr_id = $this->input->post('mr_id');
        $mr_info = $CI->Mrs->mr_search($mr_id);

        $list[''] = '';
        foreach ($mr_info as $value) {
            $json_mr[] = array('label' => $value['mr_name'], 'value' => $value['mr_id']);
        }
        echo json_encode($json_mr);
    }
}