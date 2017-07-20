<?php

class Material extends CI_Controller {

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
        $this->load->model('material_model');
    }

    function index()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['user_record'] = $this->admin_model->get_user_details($email);

//        $config['base_url'] = base_url().'index.php/material/index';
//        $config['total_rows'] = $this->material_model->num_record($id[0]->company);
//        $config['per_page'] = 10;
//        $config['num_links'] = 20;
//        $this->pagination->initialize($config);
//        $so = $this->uri->segment(3);
//        if ($so == '')
//        {
//            $so = 0;
//        }
//        $data['links'] = $this->pagination->create_links();

        $data['record'] = $this->material_model->show_recordDT($id[0]->company);
        $data['main_content'] = 'material/material_view';
        $this->load->view('includes/templates', $data);
    }

    function add_material()
    {
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $data['main_content'] = 'material/add_material_view';
        $this->load->view('includes/templates', $data);
    }

    function insert_material()
    {
        if ($this->input->post('record_update') == 'update')
        {
            $id = $this->input->post('mat_id');
            $data = array(
                'mat_name' => $this->input->post('mat_name')
            );

            $this->material_model->update_record($data, $id);
            $this->session->set_flashdata('msg', 'Material Updated');
        }
        else
        {
            $data = array(
                'user_id' => $this->input->post('id'),
                'mat_name' => $this->input->post('mat_name'),
                'company' => $this->input->post('company')
            );

            $this->material_model->add_record($data);
            $this->session->set_flashdata('msg', 'Material added');
        }
        redirect('/material/index/', 'refresh');
    }

    function delete_mat()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $mat_id = $this->input->post('mat_id');
        $this->material_model->delete_mat_record($mat_id, $column);
        $this->index();
    }

    function update_mat()
    {
        $mat_id = $_GET['mat_id'];
        $data = $this->material_model->get_item_record($mat_id);
        echo json_encode($data);
    }

    function material_purchase()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['mat_record'] = $this->material_model->show_material_record($id[0]->company);
        $high_invoice = $this->material_model->get_invoice($id[0]->company, 'materials_purchase');
        $data['high_invoice'] = ($high_invoice[0]->invoice + 1);
        $data['main_content'] = 'material/purchase_material_view';
        $this->load->view('includes/templates', $data);
    }

    function add_purchase()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $mat_array = $this->input->post('item');
        $BuyNam_array = $this->input->post('BuyNam');
        $qty_array = $this->input->post('qty');
        $scale_array = $this->input->post('scale');
        $price_array = $this->input->post('price');
        for ($i = 0; $i < count($mat_array); $i++)
        {
            $amount = $price_array[$i] / $qty_array[$i];

            $data = array(
                'user_id' => $id[0]->id,
                'mat_id' => $mat_array[$i],
                'buyer' => $BuyNam_array[$i],
                'mat_qty' => $qty_array[$i],
                'scale' => $scale_array[$i],
                'mat_price' => $price_array[$i],
                'single_price' => $amount,
                'purchase_date' => $this->input->post('date'),
                'company' => $id[0]->company,
                'invoice' => $this->input->post('invoice')
            );
            $this->material_model->add_purchase_record($data, $qty_array[$i], $mat_array[$i]);
        }
        $this->material_purchase();
    }

    function material_release()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['mat_record'] = $this->material_model->show_material_record($id[0]->company);
        $high_invoice = $this->material_model->get_invoice($id[0]->company, 'materials_release');
        $data['high_invoice'] = ($high_invoice[0]->invoice + 1);
        $data['main_content'] = 'material/release_material_view';
        $this->load->view('includes/templates', $data);
    }

    function fetch_mat_quantity()
    {
        $mat_id = $_GET['mat_id'];
        $mat_qty = $this->material_model->fetch_mat_qty($mat_id);
        echo $mat_qty[0]->total_qty;
    }

    function release_purchase()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $mat_array = $this->input->post('item');
        $qty_array = $this->input->post('qty');
        $text_array = $this->input->post('text');

        for ($i = 0; $i < count($mat_array); $i++)
        {
            $data = array(
                'user_id' => $id[0]->id,
                'mat_id' => $mat_array[$i],
                'mat_qty' => $qty_array[$i],
                'text' => $text_array[$i],
                'release_date' => $this->input->post('date'),
                'company' => $id[0]->company,
                'invoice' => $this->input->post('invoice')
            );
            $this->material_model->release_mat_record($data, $qty_array[$i], $mat_array[$i]);
        }
        $this->material_release();
    }

    function purchase_report()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['record'] = $this->material_model->show_purchase_record($id[0]->company);
        $data['record2'] = $this->material_model->show_mat_record($id[0]->company);
        $data['main_content'] = 'material/report_mat_purchase_view';
        $this->load->view('includes/templates', $data);
    }

    function filter()
    {
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $name = $this->input->post('name');
        echo $name;
        
        $mat = $this->input->post('mat_name');
        if ($fromdate == '')
        {
            $fromdate = null;
        }
        if ($todate == '')
        {
            $todate = null;
        }
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record'] = $this->material_model->get_record_date($fromdate, $todate, $name, $mat, $id[0]->company);
        $data['record2'] = $this->material_model->show_mat_record($id[0]->company);
        $data['main_content'] = 'material/report_mat_purchase_view';
        $this->load->view('includes/templates', $data);
    }

    function delete_mat_purchase()
    {
        $mat_id = $this->input->post('mat_id');
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $this->material_model->delete_mat_report($mat_id);
        $this->material_model->update_mat_record($id, $qty);
        $this->purchase_report();
    }

    function release_report()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['record'] = $this->material_model->show_release_record($id[0]->company);
        $data['record2'] = $this->material_model->show_mat_record($id[0]->company);
        $data['main_content'] = 'material/report_mat_release_view';
        $this->load->view('includes/templates', $data);
    }

    function filter_release()
    {
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $mat = $this->input->post('mat_name');
        if ($fromdate == '')
        {
            $fromdate = null;
        }
        if ($todate == '')
        {
            $todate = null;
        }
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record'] = $this->material_model->get_release_record_date($fromdate, $todate, $mat, $id[0]->company);
        $data['record2'] = $this->material_model->show_mat_record($id[0]->company);
        $data['main_content'] = 'material/report_mat_release_view';
        $this->load->view('includes/templates', $data);
    }

    function delete_mat_release()
    {
        $mat_id = $this->input->post('mat_id');
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $this->material_model->delete_mat_release_report($mat_id, $id, $qty);
        $this->release_report();
    }

    function material_purchase_edit($invoice = '')
    {
        $invoice = $this->input->post('invoice');
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        if ($invoice != null)
        {
            $data['record'] = $this->material_model->get_purchase_record_invoice($id[0]->company, $invoice);
        }
        $data['mat_record'] = $this->material_model->show_record2($id[0]->company);
        $data['invoice'] = $invoice;
        $data['main_content'] = 'material/editpurchase_view';
        $this->load->view('includes/templates', $data);
    }

    function mat_delete()
    {
        $mat_id = $_GET['id'];
        $material_id = $_GET['material_id'];
        $qty = $_GET['quantity'];
        $this->material_model->delete_mat_report($mat_id, 'materials_purchase');
        $this->material_model->update_mat_record($material_id, $qty);
    }

    function update_mat_purchase()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $mat_array = $this->input->post('item');
        $qty_array = $this->input->post('qty');
        $price_array = $this->input->post('price');
        $invoice = $this->input->post('invoice');

        $material_id = $this->input->post('material_id');
        $material_qty = $this->input->post('material_qty');
        for ($i = 0; $i < count($material_id); $i++)
        {
            $this->material_model->update_mat_record($material_id[$i], $material_qty[$i]);
        }
        $this->material_model->delete_purchase_record($invoice, $id[0]->company, 'materials_purchase');
        for ($i = 0; $i < count($mat_array); $i++)
        {
            $amount = $price_array[$i] / $qty_array[$i];

            $data = array(
                'user_id' => $id[0]->id,
                'mat_id' => $mat_array[$i],
                'mat_qty' => $qty_array[$i],
                'mat_price' => $price_array[$i],
                'single_price' => $amount,
                'purchase_date' => $this->input->post('date'),
                'company' => $id[0]->company,
                'invoice' => $invoice
            );
            $this->material_model->add_purchase_record($data, $qty_array[$i], $mat_array[$i]);
        }
        $this->material_purchase_edit($invoice);
    }

    function material_release_edit($invoice = '')
    {
        $invoice = $this->input->post('invoice');
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        if ($invoice != null)
        {
            $data['record'] = $this->material_model->get_release_record_invoice($id[0]->company, $invoice);
        }
        $data['mat_record'] = $this->material_model->show_record2($id[0]->company);
        $data['invoice'] = $invoice;
        $data['main_content'] = 'material/editreleases_view';
        $this->load->view('includes/templates', $data);
    }

    function update_mat_release()
    {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $error_flag = 0;
        $count = 0;

        $mat_array = $this->input->post('item');
        $qty_array = $this->input->post('qty');
        $text_array = $this->input->post('text');
        $invoice = $this->input->post('invoice');

        $total_qty = $this->input->post('original_qty');
        $material_id = $this->input->post('material_id');
//        $text = $this->input->post('text');
        $size_of_real_array = count($material_id);
        for ($i = 0; $i < count($total_qty); $i++)
        {
            $this->material_model->update_mat_release_record($material_id[$i], $total_qty[$i]);
        }

        for ($i = 0; $i < count($mat_array); $i++)
        {
            $count++;
            $total_qty_in_db = $this->material_model->check_mat_release_record($mat_array[$i], $qty_array[$i]);
//            echo $total_qty_in_db[0]->total_qty - $qty_array[$i].'<br>';
            if (($total_qty_in_db[0]->total_qty - $qty_array[$i]) < 0)
            {
                $error_flag = 1;
                if ($count < $size_of_real_array)
                {
                    $this->material_model->update_mat_qty($total_qty[$i], $mat_array[$i]);
                }
            }
            else
            {
                $this->material_model->update_mat_qty($qty_array[$i], $mat_array[$i]);
            }
        }
        if ($error_flag == 0)
        {
            $this->material_model->delete_purchase_record($invoice, $id[0]->company, 'materials_release');
            for ($i = 0; $i < count($mat_array); $i++)
            {
                $data = array(
                    'user_id' => $id[0]->id,
                    'mat_id' => $mat_array[$i],
                    'mat_qty' => $qty_array[$i],
                    'text' => $text_array[$i],
                    'release_date' => $this->input->post('date'),
                    'company' => $id[0]->company,
                    'invoice' => $invoice
                );
                $this->material_model->edit_mat_record($data, $qty_array[$i], $mat_array[$i]);
            }
            $this->material_release_edit($invoice);
        }
        else
        {
//            for ($i = 0; $i < count($total_qty); $i++)
//            {
//                $this->material_model->reverse_mat_release_record($material_id[$i], $total_qty[$i]);
//            }
            $this->session->set_flashdata('error_message', 'Quantity you entered exceed total quantity available in stock');
            redirect("material/material_release_edit");
        }
    }

    function mat_delete_release()
    {
        $mat_id = $_GET['id'];
        $material_id = $_GET['material_id'];
        $qty = $_GET['quantity'];
        $this->material_model->delete_mat_report($mat_id, 'materials_release');
        $this->material_model->update_mat_release_record($material_id, $qty);
    }

}