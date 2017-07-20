<?php

class Report extends CI_Controller {

    function __construct() {
        parent::__construct();
        $islogged_in = require_admin_login();
        if (!$islogged_in) {
            redirect('login');
        }
        $this->load->model('report_model');
        $this->load->model('admin_model');
        $this->load->model('shop_model');
        $this->load->model('itemsale_model');
    }

    function index() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

//        $config['base_url'] = 'http://localhost/sales/index.php/report/index';
//        $config['total_rows'] = $this->report_model->num_record($id[0]->company);
//        $config['per_page'] = 10;
//        $config['num_links'] = 20;
//        $this->pagination->initialize($config);
//        $so = $this->uri->segment(3);
//        if($so == '')
//        {
//            $so = 0;
//        }
//        $data['links'] = $this->pagination->create_links();

        $data['record'] = $this->report_model->show_record($id[0]->company);
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['record3'] = $this->report_model->show_item_record($id[0]->company);
        $data['record4'] = $this->report_model->show_price_record($id[0]->company);
        $data['main_content'] = 'report_view';
        $this->load->view('includes/templates', $data);
    }

    function filter() {
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $shop = $this->input->post('shop_name');
        $item = $this->input->post('item_name');
        if ($fromdate == '') {
            $fromdate = null;
        }
        if ($todate == '') {
            $todate = null;
        }
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record'] = $this->report_model->get_record_date($fromdate, $todate, $shop, $item, $id[0]->id);

        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['record3'] = $this->report_model->show_item_record($id[0]->company);
//        $data['record4'] = $this->report_model->show_price_record($id[0]->company);
        $data['record4'] = $this->report_model->get_record_date($fromdate, $todate, $shop, $item, $id[0]->id);
        $data['fromDate'] = $fromdate;
        $data['toDate'] = $todate;
        $data['shop_name'] = $shop;
        $data['item_name'] = $item;
        $data['main_content'] = 'report_view';
        $this->load->view('includes/templates', $data);
    }

    function detail_report() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record'] = $this->report_model->show_detail_record($id[0]->company);
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['record3'] = $this->report_model->show_item_record($id[0]->company);
        $data['company'] = $id[0]->company;
        $data['main_content'] = 'detail_report_view';
        $this->load->view('includes/templates', $data);
    }

    function detail_filter() {
        $shop = $this->input->post('shop_name');

        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        if ($shop != '') {
            $data['record'] = $this->report_model->get_detail_record_date($shop, $id[0]->company);
        } else {
            $data['record'] = $this->report_model->show_detail_record($id[0]->company);
        }

        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['record3'] = $this->report_model->show_item_record($id[0]->company);
        $data['record4'] = $this->report_model->show_price_record($id[0]->company);
        $data['company'] = $id[0]->company;
        $data['main_content'] = 'detail_report_view';
        $this->load->view('includes/templates', $data);
    }

    function shop_report() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);

        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $shop = $this->input->post('shop_name');
        if ($fromdate == '') {
            $fromdate = null;
        }
        if ($todate == '') {
            $todate = null;
        }
        if ($shop == '') {
            $shop = null;
        }
        if ($shop != NULL || $fromdate != null || $todate != null) {
            $data['record'] = $this->report_model->get_shop_report($shop, $id[0]->company, $fromdate, $todate);
            if ($shop != null) {
                $shop_id = $this->report_model->get_shopid($shop);
                $data['payment'] = $this->report_model->get_payment_report($shop_id[0]->id);
            }
        } else {
            $data['pageload_record'] = $this->report_model->get_shop_report_pageload($id[0]->company);
        }

        $data['fromDate'] = $fromdate;
        $data['toDate'] = $todate;
        $data['shop_name'] = $shop;
        $data['company'] = $id[0]->company;
        $data['main_content'] = 'shop_report_view';
        $this->load->view('includes/templates', $data);
    }

    function sales_report() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $specialDiscount = 0;

        if ($this->input->post('shop_name')) {
            $shop_id = $this->input->post('shop_name');
            $data['record'] = $this->report_model->show_overall_report_shop($id[0]->company, $shop_id);
            $specialDiscount = $this->report_model->getshopspecialDiscount($id[0]->company, $this->input->post('shop_name'));
            if ($specialDiscount) {
                $data['specialDiscount'] = $specialDiscount[0]->specialDiscount;
            } else {
                $data['specialDiscount'] = 0;
            }
            $data['record2'] = $this->report_model->show_shop_record($id[0]->company, $shop_id);
            $data['payment'] = $this->report_model->show_overall_payment_shop($id[0]->company, $shop_id);
            $data['shop_id'] = $shop_id;
        } else {
            $data['record'] = $this->report_model->show_overall_report($id[0]->company);
            $specialDiscount = $this->report_model->getspecialDiscount($id[0]->company);
            if ($specialDiscount) {
                $data['specialDiscount'] = $specialDiscount[0]->specialDiscount;
            } else {
                $data['specialDiscount'] = 0;
            }
            $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
            $data['payment'] = $this->report_model->show_overall_payment($id[0]->company);
        }
        $data['main_content'] = 'detail_sales_view';
        $this->load->view('includes/templates', $data);
    }

    function overdue_report() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $date = date("Y-m-d");
        $data['payment'] = $this->report_model->show_overdue_checks($id[0]->company, $date);

        $data['main_content'] = 'overdue_checks_view';
        $this->load->view('includes/templates', $data);
    }

    function shop_sale_report() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['main_content'] = 'shop_sale_report_view';
        $this->load->view('includes/templates', $data);
    }

    function shop_sale_filter() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $shop = $this->input->post('shop_name');
        if ($shop != '') {
            $shopName = $this->shop_model->get_shop_record($shop);
            $data['record'] = $this->report_model->get_shop_sale_record($shop, $id[0]->company);
            $data['amount'] = $this->itemsale_model->get_amount($shop);
            $data['discount_price'] = $this->itemsale_model->get_discount_price($shop);
            $data['payment_record'] = $this->itemsale_model->get_itemsale_record($id[0]->company, $shop);
            $data['shopName'] = $shopName[0]->shop_name;
        }
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['company'] = $id[0]->company;
        $data['main_content'] = 'shop_sale_report_view';
        $this->load->view('includes/templates', $data);
    }

    function payment_report() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);

        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $shop = $this->input->post('shop_name');
        if ($fromdate == '') {
            $fromdate = null;
        }
        if ($todate == '') {
            $todate = null;
        }
        if ($shop == '') {
            $shop = null;
        }
        if ($shop != NULL || $fromdate != null || $todate != null) {
            $data['record'] = $this->report_model->payment_report_filter($shop, $id[0]->company, $fromdate, $todate);
            $data['payment'] = $this->report_model->payment_shop_filter($id[0]->company, $shop, $fromdate, $todate);
        } else {
            $data['pageload_record'] = $this->report_model->get_payment_detail($id[0]->company);
            $data['payment'] = $this->report_model->show_overall_payment($id[0]->company);
        }

        $data['fromDate'] = $fromdate;
        $data['toDate'] = $todate;
        $data['shop_id'] = $shop;
        $data['company'] = $id[0]->company;
        $data['main_content'] = 'payment_report_view';
        $this->load->view('includes/templates', $data);
    }

}