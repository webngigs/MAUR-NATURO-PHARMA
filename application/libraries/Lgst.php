<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lgst {
	//Retrieve  gift List	DONE
	public function list() {
        $CI =& get_instance();
        $CI->load->model('Web_settings');
		$CI->load->model('Gst');
		$data['title']  	=	'GST Report';
        $giftList = $CI->parser->parse('gst/list', $data, true);
        return $giftList;
    }
}
?>