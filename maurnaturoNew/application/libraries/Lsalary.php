<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lsalary {
    public function add_form(){
		$CI =& get_instance();
		$CI->load->model('Salaries');

		$all_mr = $CI->Salaries->select_all_mr();

		$data = array(
			'title' => display('add_salary'),
			'all_mr'	=>	$all_mr
		);
		$addForm = $CI->parser->parse('salary/add_salary_form', $data,true);
		return $addForm;
	}

    public function edit_data($id)
	{		
		$CI =& get_instance();
		$CI->load->model('Salaries');
		
		$salary_detail = $CI->Salaries->retrieve_salary_editdata($id);
		$data	=	array(
			'title' 	        => 	display('salary_edit'),
			'id' 	            => 	$salary_detail[0]['id'],
			'name'     	        => 	$salary_detail[0]['name'],
			'amount' 	        => 	$salary_detail[0]['amount'],
			'salary_date'	    =>	$salary_detail[0]['salary_date'],
		);
		$salaryList = $CI->parser->parse('salary/edit_salary_form', $data, true);
		return $salaryList;
	}

    public function list() {
        $CI =& get_instance();
        $CI->load->model('Salaries');
        $CI->load->model('Web_settings');
        $salary_info 			=	$CI->Salaries->retrieve_salary();
        $data['total_customer']	= 	$CI->Salaries->count_salary();
        $data['title']          = 	display('manage_salary');
        $data['company_info']   = 	$salary_info;
        $salaryList = $CI->parser->parse('salary/salary', $data, true);
        return $salaryList;
    }
}