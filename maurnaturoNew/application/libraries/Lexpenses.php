<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lexpenses {
    public function expenses_add_form(){
		$CI =& get_instance();
		$CI->load->model('Expenses');
		$CI->load->model('Targets');

		$all_mr = $CI->Targets->select_all_mr();

		$data = array(
			'title' 	=> 	display('add_expenses'),
			'all_mr'	=>	$all_mr
		);
		$addForm = $CI->parser->parse('expenses/add_expenses_form', $data,true);
		return $addForm;
	}

    public function expenses_edit_data($id)
	{		
		$CI =& get_instance();
		$CI->load->model('Expenses');
		
		$expenses_detail = $CI->Expenses->retrieve_expenses_editdata($id);
		$data	=	array(
			'title' 	        => 	display('expenses_edit'),
			'id' 	            => 	$expenses_detail[0]['id'],
			'name'     	        => 	$expenses_detail[0]['name'],
			'amount' 	        => 	$expenses_detail[0]['amount'],
			'expenses_date'	    =>	$expenses_detail[0]['expenses_date'],
		);
		$expensesList = $CI->parser->parse('expenses/edit_expenses_form', $data, true);
		return $expensesList;
	}

    public function expenses_list() {
        $CI =& get_instance();
        $CI->load->model('Expenses');
        $CI->load->model('Web_settings');
        $expenses_info 			=	$CI->Expenses->retrieve_expenses();
        $data['total_customer']	= 	$CI->Expenses->count_expenses();
        $data['title']          = 	display('manage_expenses');
        $data['company_info']   = 	$expenses_info;
        $expensesList = $CI->parser->parse('expenses/expenses', $data, true);
        return $expensesList;
    }
}