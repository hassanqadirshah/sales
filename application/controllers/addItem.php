<?php

class AddItem extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $islogged_in = require_admin_login();
        if (!$islogged_in)
        {
            redirect('login');
        }
        $this->load->model('item_model');
        $this->load->model('admin_model');
    }

    function add_item()
    {
        if ($this->input->post('record_update') == 'update')
        {
            $id = $this->input->post('item_id');
            $data = array(
                'item_name' => $this->input->post('item_name'),
                'item_price' => $this->input->post('item_price')
            );

            $this->item_model->update_record($data, $id);
            $this->session->set_flashdata('msg', 'Item Updated');
        }
        else
        {
            $data = array(
                'user_id' => $this->input->post('id'),
                'item_name' => $this->input->post('item_name'),
                'item_price' => $this->input->post('item_price'),
                'company' => $this->input->post('company')
            );

            $this->item_model->add_record($data);
            $this->session->set_flashdata('msg', 'Item added');
        }
        redirect('/addItem/show_item/', 'refresh');
    }

    function show_item()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['user_record'] = $this->admin_model->get_user_details($email);

//        $config['base_url'] = base_url() . 'index.php/addItem/show_item';
//        $config['total_rows'] = $this->item_model->num_record($id[0]->company);
//        $config['per_page'] = 10;
//        $config['num_links'] = 20;
//        $this->pagination->initialize($config);
//        $data['links'] = $this->pagination->create_links();

        $data['record'] = $this->item_model->show_recordDT($id[0]->company);
        $data['main_content'] = 'showItems_view';
        $this->load->view('includes/templates', $data);
    }

    function delete_item()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['user_record'] = $this->admin_model->get_user_details($email);

        $item_id = $this->input->post('item_id');
        $this->item_model->delete_item_record($item_id);
        //redirect('add_Item/show_item');
        $data['record'] = $this->item_model->show_record2($id[0]->company);
        $data['main_content'] = 'showItems_view';
        $this->load->view('includes/templates', $data);
    }

    function update_item()
    {
        $item_id = $_GET['item_id'];
        $data = $this->item_model->get_item_record($item_id);

        echo json_encode($data);
    }

}