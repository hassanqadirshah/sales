<?php

class Item_sales extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('itemsale_model');
        $this->load->model('invoices_model');
        $this->load->model('itemsalerecord_model');
        $this->load->model('sale_model');
        $this->load->model('admin_model');
        $this->load->model('item_model');
        $this->load->model('shop_model');
        $this->load->model('report_model');
        $islogged_in = require_admin_login();
        if (!$islogged_in) {
            redirect('login');
        }
    }

    function index() {
        $this->cart->destroy();
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['item_record'] = $this->item_model->show_sale_record($id[0]->company);
        $data['shop_record'] = $this->shop_model->show_sale_record($id[0]->company);
        $high_invoice = $this->invoices_model->get_invoice($id[0]->company);
        $data['high_invoice'] = ($high_invoice[0]->invoice + 1);
        $data['main_content'] = 'itemSale_view';
        $this->load->view('includes/templates', $data);
    }

    function main() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['item_record'] = $this->item_model->show_record($id[0]->company);
        $data['shop_record'] = $this->shop_model->show_record($id[0]->company);
        $data['main_content'] = 'itemSale_view';
        $this->load->view('includes/templates', $data);
    }

    function addrecord() {
        $item_price = 0;
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $id = $this->admin_model->get_user_details($email);
        $shop_discount = $this->shop_model->show_shop_discount($this->input->post('shop'));
        $item_array = $this->input->post('item');
        $qty_array = $this->input->post('qty');
        $special_dis = $this->input->post('special_discount');
        $data = array(
            'shop_id' => $this->input->post('shop'),
            'sale_date' => $this->input->post('date'),
            'company' => $id[0]->company,
            'invoice' => $this->input->post('invoice'),
            'specialDiscount' => $special_dis,
            'user_id' => $id[0]->id
        );
        $lastRow = $this->invoices_model->add_sale_record($data);

        for ($i = 0; $i < count($item_array); $i++) {
            $item_price = $this->item_model->show_item_price($item_array[$i]);
            $amount = $item_price[0]->item_price * $qty_array[$i];
            if ($shop_discount[0]->discount != 0) {
                $discount_amount = $amount - ($shop_discount[0]->discount * $qty_array[$i]);
            } else {
                $discount_amount = $amount;
            }

            $data = array(
                'item_id' => $item_array[$i],
                'qty' => $qty_array[$i],
                'discounted_price' => $discount_amount,
                'itemSaleDetailId' => $lastRow,
            );
            $this->itemsalerecord_model->add_sale_record($data);
        }
        redirect('item_sales');
    }

    function fetch_item_record() {
        $item_id = $_GET['item_id'];
        $item_price = $this->item_model->show_item_price($item_id);
        echo $item_price[0]->item_price;
    }

    function sales_details() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $config['base_url'] = base_url() . 'index.php/item_sales/sales_details';
        $config['total_rows'] = $this->itemsale_model->num_record($id[0]->company);
        $config['per_page'] = 10;
        $config['num_links'] = 20;
        $this->pagination->initialize($config);
        $so = $this->uri->segment(3);
        if ($so == '') {
            $so = 0;
        }
        $data['links'] = $this->pagination->create_links();
        $data['record'] = $this->itemsale_model->show_record($id[0]->company, $so);
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['record3'] = $this->report_model->show_item_record($id[0]->company);
        $data['main_content'] = 'editsale_view';
        $this->load->view('includes/templates', $data);
    }

    function sales_edit() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $data['item_record'] = $this->item_model->show_record2($id[0]->company);
        $data['shop_record'] = $this->shop_model->show_record2($id[0]->company);
        $data['record'] = $this->itemsale_model->get_record($this->input->post('sale_id'));

        $data['main_content'] = 'updatesale_view';
        $this->load->view('includes/templates', $data);
    }

    function sale_delete() {
        if ($_GET['id']) {
            //get itemSaleDetailId of this id
            $record = $this->itemsalerecord_model->getID($_GET['id']);
            //count total rows of itemSaleDetailId
            $totalRows = $this->itemsalerecord_model->countRows($record[0]->itemSaleDetailId);
            if ($totalRows[0]->rows > 1) {
                $this->itemsalerecord_model->delete_record($_GET['id']);
            } else {
                $this->itemsalerecord_model->delete_invoice_record($_GET['id'], $record[0]->itemSaleDetailId);
            }
            redirect('item_sales/sales_invoice_edit');
        } else {
            $email = $this->session->userdata('user_email');
            $id = $this->admin_model->get_user_details($email);
            $this->itemsale_model->delete_record($this->input->post('sale_id'));
            redirect('item_sales/sales_details');
        }
    }

    function sales_update() {
        $item_prices = 0;
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $id = $this->admin_model->get_user_details($email);

        $shop_discount = $this->shop_model->show_shop_discount($this->input->post('shop'));

        $item = $this->input->post('item');
        $qty = $this->input->post('qty');
        $sale_id = $this->input->post('sale_id');

        $item_prices = $this->item_model->show_item_price($item);
        $amount = $item_prices[0]->item_price * $qty;
        if ($shop_discount[0]->discount != 0) {
            $discount_amount = $amount - ($shop_discount[0]->discount * $qty);
        } else {
            $discount_amount = $amount;
        }

        $data = array(
            'user_id' => $id[0]->id,
            'item_id' => $item,
            'shop_id' => $this->input->post('shop'),
            'sale_date' => $this->input->post('date'),
            'qty' => $qty,
            'discounted_price' => $discount_amount,
            'company' => $id[0]->company
        );

        $this->itemsale_model->update_sale_record($sale_id, $data);
        redirect('item_sales/sales_details');
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

        $config['base_url'] = base_url() . 'index.php/item_sales/filter';
        $config['total_rows'] = $this->itemsale_model->num_record($id[0]->company);
        $config['per_page'] = 10;
        $config['num_links'] = 20;
        $this->pagination->initialize($config);
        $so = $this->uri->segment(3);
        if ($so == '') {
            $so = 0;
        }
        $data['links'] = $this->pagination->create_links();

        $data['record'] = $this->item_model->get_record_date($fromdate, $todate, $shop, $item, $id[0]->id, $so);
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['record3'] = $this->report_model->show_item_record($id[0]->company);
        $data['main_content'] = 'editsale_view';
        $this->load->view('includes/templates', $data);
    }

    function sales_invoice_edit() {
        $invoice = '';
        if(isset($_GET['invoice']))
        {
            $invoice = $_GET['invoice'];
        }
        else if($this->input->post('invoice'))
        {
            $invoice = $this->input->post('invoice');
        }
        $data['searchInvoice'] = $invoice;
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        if ($invoice != null) {
            $data['record'] = $this->itemsale_model->get_itemsale_record_invoice($id[0]->company, $invoice);
        }
        $data['item_record'] = $this->item_model->show_record2($id[0]->company);
        $data['shop_record'] = $this->shop_model->show_record2($id[0]->company);
        $data['invoice'] = $invoice;
        $data['main_content'] = 'editinvoice_view';
        $this->load->view('includes/templates', $data);
    }

    function update_record() {
        $item_price = 0;
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $id = $this->admin_model->get_user_details($email);
        $shop_discount = $this->shop_model->show_shop_discount($this->input->post('shop'));
        $item_array = $this->input->post('item');
        $qty_array = $this->input->post('qty');
        $id_array = $this->input->post('item_sale_id');

        for ($i = 0; $i < count($item_array); $i++) {
            $item_price = $this->item_model->show_item_price($item_array[$i]);
            $amount = $item_price[0]->item_price * $qty_array[$i];
            if ($shop_discount[0]->discount != 0) {
                $discount_amount = $amount - ($shop_discount[0]->discount * $qty_array[$i]);
            } else {
                $discount_amount = $amount;
            }


            $data = array(
                'item_id' => $item_array[$i],
                'shop_id' => $this->input->post('shop'),
                'qty' => $qty_array[$i],
                'discounted_price' => $discount_amount,
            );

            $this->itemsale_model->update_record($id_array[$i], $data);
        }
        redirect('sales_invoice_edit');
    }

    function update_new_record() {
        $item_price = 0;
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $id = $this->admin_model->get_user_details($email);

        $shop_discount = $this->shop_model->show_shop_discount($this->input->post('shop'));
        $item_array = $this->input->post('item');
        $qty_array = $this->input->post('qty');
        $invoice = $this->input->post('invoice');
        if ($invoice == '') {
            redirect('item_sales/sales_invoice_edit');
        } else {
            $id[0]->company;
            //get id of sale detail deleted
            $rowId = $this->invoices_model->get_id_DeltetRecord($invoice, $id[0]->company);
            //delete previouis record
            $this->itemsale_model->delete_sale_record($invoice, $id[0]->company, $rowId[0]->id);

            $data = array(
                'shop_id' => $this->input->post('shop'),
                'sale_date' => $this->input->post('date'),
                'company' => $id[0]->company,
                'invoice' => $this->input->post('invoice'),
                'specialDiscount' => $this->input->post('special_discount'),
                'user_id' => $id[0]->id
            );
            $lastRow = $this->invoices_model->add_sale_record($data);

            for ($i = 0; $i < count($item_array); $i++) {
                $item_price = $this->item_model->show_item_price($item_array[$i]);
                $amount = $item_price[0]->item_price * $qty_array[$i];
                if ($shop_discount[0]->discount != 0) {
                    $discount_amount = $amount - ($shop_discount[0]->discount * $qty_array[$i]);
                } else {
                    $discount_amount = $amount;
                }

                $data = array(
                    'item_id' => $item_array[$i],
                    'qty' => $qty_array[$i],
                    'discounted_price' => $discount_amount,
                    'itemSaleDetailId' => $lastRow
                );
                $this->itemsalerecord_model->add_sale_record($data);
            }
            redirect('item_sales/sales_invoice_edit');
        }
    }

    function fetch_shop_discount() {
        $shop_id = $_GET['shop_id'];
        $shop_discount = $this->shop_model->show_shop_discount($shop_id);
        echo $shop_discount[0]->discount;
    }

    function add_payment_invoice($shop_id = '') {
        if (isset($_POST['shop_name'])) {
            $shop_id = $this->input->post('shop_name');
        }
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        if ($shop_id != null) {
            $data['amount'] = $this->itemsale_model->get_amount($shop_id);
            $data['discount_price'] = $this->itemsale_model->get_discount_price($shop_id);
            $shop_name = $this->shop_model->get_shop_record($shop_id);
            $data['record'] = $this->itemsale_model->get_itemsale_record($id[0]->company, $shop_id);
            $data['shop_name'] = $shop_name[0]->shop_name;
        }
        $data['shop_id'] = $shop_id;
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['main_content'] = 'payment_invoice_view';
        $this->load->view('includes/templates', $data);
    }

    function insert_payment() {
        $email = $this->session->userdata('user_email');
        $shop_id = $this->input->post('shop_id');
        $id = $this->admin_model->get_user_details($email);
        if ($this->input->post('payment_mode') != 'check') {
            $overdue_date = 0;
        } else {
            $overdue_date = $this->input->post('overdue_date');
        }
        $data = array(
            'payment_mode' => $this->input->post('payment_mode'),
            'amount' => $this->input->post('amount'),
            'shop_id' => $this->input->post('shop_id'),
            'date' => $this->input->post('date'),
            'comment' => $this->input->post('comment'),
            'is_received' => $this->input->post('payment_received'),
            'company' => $id[0]->company,
            'overdue_date' => $overdue_date
        );
        if ($shop_id != '') {
            $this->itemsale_model->add_payment($data);
        }
        redirect('item_sales/add_payment_invoice/' . $shop_id);
    }

    function payment_invoice_edit($shopid = '') {
        $shop_id = isset($_POST['shop_name']) ? $_POST['shop_name'] : $shopid;
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        if ($shop_id != null) {
            $data['payment_record'] = $this->itemsale_model->get_payment($shop_id);
            $data['amount'] = $this->itemsale_model->get_amount($shop_id);
            $data['discount_price'] = $this->itemsale_model->get_discount_price($shop_id);
            $shop_name = $this->shop_model->get_shop_record($shop_id);
            $data['shop_name'] = $shop_name[0]->shop_name;
//            $data['record'] = $this->itemsale_model->get_itemsale_record($id[0]->company, $invoice);
        }
        $data['shop_id'] = $shop_id;
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['main_content'] = 'payment_edit_view';
        $this->load->view('includes/templates', $data);
    }

    function delete_payment() {
        $payment_id = $this->input->post('payment_id');
        $shop_id = $this->input->post('shop_id');
        $this->itemsale_model->delete_payment($payment_id);
        redirect('item_sales/payment_invoice_edit/' . $shop_id);
    }

    function update_payment() {
        $payment_id = $this->input->post('payment_id');
        $payment_mode = $this->input->post('payment_mode');
        $amount = $this->input->post('amount');
        $shop_id = $this->input->post('shop_id');
        $date = $this->input->post('date');
        $comment = $this->input->post('comment');
        $payment_received = $this->input->post('payment_received');
        
        if ($this->input->post('payment_mode') != 'check') {
            $overdue_date = 0;
        }
        else
        {
            $overdue_date = $this->input->post('overdue_date');
        }
        $data = array(
            'payment_mode' => $payment_mode,
            'amount' => $amount,
            'shop_id' => $shop_id,
            'date' => $date,
            'comment' => $comment,
            'is_received' => $payment_received,
            'overdue_date' => $overdue_date
        );

        $this->itemsale_model->update_payment($payment_id, $data);
        redirect('item_sales/payment_invoice_edit/' . $shop_id);
    }

    function unpaid_payments() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record'] = $this->itemsale_model->payment_records();
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['main_content'] = 'unpaid_payments_view';
        $this->load->view('includes/templates', $data);
    }

    function unpaid_filter() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);
        $shop_id = $this->input->post('shop_name');

        $data['record'] = $this->itemsale_model->payment_records($shop_id);
        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $data['main_content'] = 'unpaid_payments_view';
        $this->load->view('includes/templates', $data);
    }

    function edit_unpaid_payments() {
        $email = $this->session->userdata('user_email');
        $id = $this->admin_model->get_user_details($email);

        $data['record2'] = $this->report_model->show_shop_record($id[0]->company);
        $payment_id = $this->input->post('payment_id');
        $data['payment_record'] = $this->itemsale_model->get_payment_id($payment_id);
        //$data['record'] = $this->itemsale_model->payment_records($payment_id);
        $shop_id = $this->itemsale_model->getshop_id($payment_id);
        //$shop_idd = $this->itemsale_model->payment_records($payment_id);
        $shop_name = $this->shop_model->get_shop_record($shop_id[0]->shop_id);
        $data['shop_id'] = $shop_id[0]->shop_id;
        $data['shop_name'] = $shop_name[0]->shop_name;
        $data['discount_price'] = $this->itemsale_model->get_discount_price($shop_id[0]->shop_id);
        $data['amount'] = $this->itemsale_model->get_amount($shop_id[0]->shop_id);
        $data['main_content'] = 'unpaid_edit_view';
        $this->load->view('includes/templates', $data);
    }

}