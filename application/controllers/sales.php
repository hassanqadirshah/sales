<?php

class Sales extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('sale_model');
        $this->load->model('admin_model');
        $islogged_in = require_admin_login();
        if(!$islogged_in)
        {
            redirect('login');
        }
    }

    function index()
    {
//        $email = $this->session->userdata('user_email');
//        $id = $this->admin_model->get_user_details($email);
//        $data['records'] = $this->sale_model->get_record($id[0]->company);
        $data['main_content'] = 'sales_view';
        $this->load->view('includes/templates', $data);
    }

    function item_detail()
    {
        $item_id = $this->input->post('item_id');
        $data['item_records'] = $this->sale_model->get_item_record($item_id);
        $data['main_content'] = 'sales_view';
        $this->load->view('includes/templates', $data);
    }

    function shop_detail()
    {
        $shop_id = $this->input->post('shop_id');
        $data['shop_records'] = $this->sale_model->get_shop_record($shop_id);
        $data['main_content'] = 'sales_view';
        $this->load->view('includes/templates', $data);
    }

    function filter_date()
    {
        $date = $this->input->post('date');
        $data['records'] = $this->sale_model->get_record_date($date);
        $data['main_content'] = 'sales_view';
        $this->load->view('includes/templates', $data);
    }
    
//    function db_temp()
//    {
//        $record = $this->sale_model->getAllRecord();
//        foreach($record as $row)
//        {
//            $data = array(
//               'itemSaleDetailId' => $row->invoiceID
//            );
//            $this->sale_model->updateAllRecord($data, $row->invoice);
//        }
//        echo 'function end';
//    }

}
