<?php

class AddShop extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $islogged_in = require_admin_login();
        if (!$islogged_in)
        {
            redirect('login');
        }
        $this->load->model('shop_model');
        $this->load->model('report_model');
        $this->load->model('admin_model');
    }

    function add_shop()
    {
        if ($this->input->post('record_update') == 'update')
        {
            $id = $this->input->post('shop_id');
            $data = array(
                'shop_name' => $this->input->post('shop_name'),
                'discount' => $this->input->post('discount')
            );

            $this->shop_model->update_record($data, $id);
            $this->session->set_flashdata('msg', 'Shop Updated');
        }
        else
        {
            $data = array(
                'user_id' => $this->input->post('id'),
                'shop_name' => $this->input->post('shop_name'),
                'discount' => $this->input->post('discount'),
                'company' => $this->input->post('company')
            );
            $this->shop_model->add_record($data);
            $this->session->set_flashdata('msg', 'Shop added');
        }
        redirect(site_url().'/addShop/show_shop/', 'refresh');
    }

    function show_shop()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['user_record'] = $this->admin_model->get_user_details($email);

//        $config['base_url'] = base_url().'index.php/addShop/show_shop';
//        $config['total_rows'] = $this->shop_model->num_record($id[0]->company);
//        $config['per_page'] = 10;
//        $config['num_links'] = 20;
//        $this->pagination->initialize($config);
//        $so = $this->uri->segment(3);
//        if ($so == '')
//        {
//            $so = 0;
//        }
//        $data['links'] = $this->pagination->create_links();

        $data['record'] = $this->shop_model->show_recordDT($id[0]->company);
        $data['main_content'] = 'showShops_view';
        $this->load->view('includes/templates', $data);
    }

    function shop_detail()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $shop_id = $this->input->post('shop_id');
        $data['shopDetail_records'] = $this->shop_model->get_shop_details($shop_id);
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['record3'] = $this->report_model->show_item_record($id[0]->company);
        $data['main_content'] = 'shopDetail_view';
        $this->load->view('includes/templates', $data);
    }

    function filter()
    {
        $date = $this->input->post('date');
        if ($date == '')
        {
            $date = date('Y-m-d');
        }
        $shop = $this->input->post('shop_name');
        $item = $this->input->post('item_name');
        $data['shopDetail_records'] = $this->report_model->get_record_date($date, $shop, $item);
        $data['record2'] = $this->report_model->show_shop_record();
        $data['record3'] = $this->report_model->show_item_record();
        $data['main_content'] = 'shopDetail_view';
        $this->load->view('includes/templates', $data);
    }

    function delete_shop()
    {
        $shop_id = $this->input->post('shop_id');
        $this->shop_model->delete_shop_record($shop_id);
        redirect('addShop/show_shop');
    }

    function update_shop()
    {
        $shop_id = $_GET['shop_id'];
        $data = $this->shop_model->get_shop_record($shop_id);
        echo json_encode($data);
    }

}