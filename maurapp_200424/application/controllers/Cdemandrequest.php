<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Cdemandrequest extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('ldemandrequest');
        $content = $CI->ldemandrequest->demandrequest_add_form();
        $this->template->full_admin_html_view($content);
    }

    public function insert_demandrequest()
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Demandrequests');
        $demandrequests_id = $CI->Demandrequests->demandrequest_entry();
        $this->session->set_userdata(array('message' => display('successfully_added')));
        redirect("Cdemandrequest");
    }

    public function demandrequest_update_form($demandrequests_id)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('ldemandrequest');
        $content = $CI->ldemandrequest->demandrequests_edit_data($demandrequests_id);
        $this->template->full_admin_html_view($content);
    }

    public function demandrequest_update()
    {

    }

    public function manage_demandrequest()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('ldemandrequest');
        $CI->load->model('Demandrequests');
        $content = $this->ldemandrequest->demandrequest_list();
        $this->template->full_admin_html_view($content);
    }

    public function customer_demandrequest()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('ldemandrequest');
        $CI->load->model('Demandrequests');
        $content = $this->ldemandrequest->customer_demandrequest_list();
        $this->template->full_admin_html_view($content);
    }

    public function mr_demandrequest_delete($demandrequest_id)
    {
        $this->load->model('Demandrequests');
		$this->Demandrequests->delete_demandrequest($demandrequest_id);
		redirect(base_url('Cdemandrequest/manage_demandrequest'));
    }
    
    public function customer_demandrequest_delete($demandrequest_id)
    {
        $this->load->model('Demandrequests');
		$this->Demandrequests->delete_demandrequest($demandrequest_id);
		redirect(base_url('Cdemandrequest/customer_demandrequest'));
    }

    public function product_stock_check($product_id)
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Demandrequests');
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

    public function demandrequests_inserted_data($demandrequest_id)
    {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('ldemandrequest');
        $content = $CI->ldemandrequest->demandrequest_html_data($demandrequest_id);
        $this->template->full_admin_html_view($content);
    }

    public function CheckDemandrequestList()
    {
        $this->load->model('Demandrequests');
        $postData = $this->input->post();
        $data = $this->Demandrequests->getDemandRequestsList($postData);
        echo json_encode($data);
    }

    public function CheckCustomerDemandrequestList()
    {
        $this->load->model('Demandrequests');
        $postData = $this->input->post();
        $data = $this->Demandrequests->getCustomerDemandRequestsList($postData);
        echo json_encode($data);
    }

    public function Approvedemandrequest()
    {
        $updateData = array('status' => 3);
        $this->db->where('demandrequests_id', $this->input->post('demandrequest_id'));
        $this->db->update('Demandrequests', $updateData);
        $data = [
            'status' => true,
            'message' => 'Demand Request Successfully Approved',
        ];
        echo json_encode($data);
    }

    public function Cancelleddemandrequest()
    {
        $updateData = array('status' => 2);
        $this->db->where('demandrequests_id', $this->input->post('demandrequest_id'));
        $this->db->update('Demandrequests', $updateData);
        $data = [
            'status' => true,
            'message' => 'Demand Request Successfully Cancelled',
        ];
        echo json_encode($data);
    }

    public function Receiveddemandrequest()
    {
        $updateData = array('status' => 4);
        $this->db->where('demandrequests_id', $this->input->post('demandrequest_id'));
        $this->db->update('Demandrequests', $updateData);
        $data = [
            'status' => true,
            'message' => 'Demand Request Successfully Received',
        ];
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
    
    public function mr_autocomplete_on_add_customer()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Mrs');
        $mr_id = $this->input->post('mr_id');
        $mr_info = $CI->Mrs->mr_search($mr_id);

        $list[''] = '';
        foreach ($mr_info as $value) {
            $json_mr[] = array('label' => $value['mr_name'], 'value' => $value['user_id']);
        }
        echo json_encode($json_mr);
    }
}