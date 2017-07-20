<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function require_admin_login()
{
    $CI = &get_instance();
    if ($CI->session->userdata('logged_in'))
    {

        return $CI->session->userdata('logged_in');
    }
    else
    {
//         $CI->load->view('admin/staff/login');
       redirect(base_url().'index.php/login');
    }
}
function getFeatures($option_name)
{
   $CI =& get_instance();
   $CI->load->model('admin/listing/listing_model','list_mod');
   $feature_arr =array();
   $feature_arr = $CI->list_mod->getFeatureOptions($option_name);
   return $feature_arr;

}
