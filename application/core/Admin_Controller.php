<?php defined('BASEPATH') OR exit('No direct script access allowed');

// class Admin_Controller extends MX_Controller
// {
	
//     function __construct()
//     {
//         parent::__construct();
// 		$this->load->helper('language');
// 		if($this->session->userdata('lang')!="")
// 		{
// 			$this->lang->load('admin',$this->session->userdata('lang'));
// 		}else{
// 			$this->lang->load('admin', 'english');
// 		}
// 		$this->setting	=	get_setting();
// 		$this->auth->check_session();
// 	    //if SSL is enabled in config force it here.
//         if (config_item('ssl_support') && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off'))
// 		{
// 			$CI =& get_instance();
// 			$CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
// 			redirect($CI->uri->uri_string());
// 		}

//     }
	

// 	public function render_admin($page=false,$data=false)
// 	{
		
// 		$this->load->view('template/header',$data);
// 		$this->load->view('template/sidebar',$data);
// 		$this->load->view($page,$data);
// 		$this->load->view('template/footer',$data);
// 	}
    
// }


class User_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    	 
		$this->front_user	=	get_front_user();
			//echo print_r($this->front_user);die;
		if(empty($this->front_user['contact'])){
			$CI->session->set_flashdata('error','You Need To Sign In To Access');
			redirect('front/home');
		}    
    }
    
}


class Manager_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        
    }
}


class Admin_Controller extends CI_Controller
{

	public $CI;
	public $setting;

    function __construct()
    {
        parent::__construct();
        
        // if SSL is enabled in config force it here.
        if (config_item('ssl_support') && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off'))
		{
			$this->CI =& get_instance();
			$this->CI->config->config['base_url'] = str_replace('http://', 'https://', $this->CI->config->config['base_url']);
			redirect($this->CI->uri->uri_string());
		}
		  $this->CI =& get_instance();
		  $this->CI->load->model(['setting_model','currency_model']);
		  $getCurrency = $this->CI->currency_model->get_currency_symbol();
		  $this->setting	=	$this->CI->setting_model->get();
		  //$this->setting->currency_symbol = $getCurrency->currency_symbol;
       
		if(!empty($this->setting->timezone)){
			date_default_timezone_set($this->setting->timezone);
		}
		//  check if user is logged in
        $this->check_login_status();
    }

    //  redirect user to login page if not logged in
    protected function check_login_status() 
    {
     	   
        $this->load->library('auth');
		if(!$this->auth->check_access('Admin')){
			//redirect(base_url(''));
		}

		$this->CI =& get_instance();
		 $admin = $this->CI->session->userdata('admin');
        if(!$admin)
        {
            //redirect(base_url(''));
        }
		
	}   
	
	public function render_admin($page=false,$data=false)
	{
			
		$this->load->view('template/header',$data);
		$this->load->view('template/sidebar',$data);
		$this->load->view($page,$data);
		$this->load->view('template/footer',$data);
	}
}	



?>