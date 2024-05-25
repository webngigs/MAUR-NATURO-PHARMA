<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Cinventory extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function inventory()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $CI->load->model('Stockrequests');
        $content = $this->lstockrequest->inventory_list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckInventoryList()
    {
        $this->load->model('Stockrequests');
        $postData = $this->input->post();
        $data = $this->Stockrequests->getInventoryList($postData);
        echo json_encode($data);
    }

    public function upcomingstock()
    {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lstockrequest');
        $CI->load->model('Stockrequests');
        $content = $this->lstockrequest->upcoming_list();
        $this->template->full_admin_html_view($content);
    }

    public function CheckUpcomingStockList()
    {
        $this->load->model('Stockrequests');
        $postData = $this->input->post();
        $data = $this->Stockrequests->getUpcomingStockList($postData);
        echo json_encode($data);
    }
}