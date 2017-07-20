<?php

class Shop_model extends CI_Model {

    function add_record($data) {
        $this->db->insert('shops', $data);
        return;
    }

    function show_record($company, $limit, $start_from) {
        $sql = "SELECT * FROM shops WHERE company = '$company' ORDER BY shop_name LIMIT $start_from,10";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_recordDT($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("shop_name");
        $this->db->from('shops');
        $query = $this->db->get();
        return $query->result();
    }

    function show_record2($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("shop_name");
        $this->db->from('shops');
        $query = $this->db->get();
        return $query->result();
    }

    function show_sale_record($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("shop_name");
        $this->db->from('shops');
        $query = $this->db->get();
        return $query->result();
    }

    function get_shop_details($shop_id) {
        $sql = "SELECT invoices_details.*, invoices.*, items.*, shops.shop_name, 
            shops.discount, shops.id AS shop_id  FROM invoices_details INNER JOIN invoices ON invoices_details.itemSaleDetailId
            = invoices.id INNER JOIN items ON invoices_details.item_id = items.id INNER JOIN shops ON 
            invoices.shop_id = shops.id WHERE shops.id = '$shop_id'";

        $query = $this->db->query($sql)->result();

        return $query;
    }

    function delete_shop_record($shop_id) {
        $this->db->where('id', $shop_id);
        $this->db->delete('shops');
    }

    function get_shop_record($shop_id) {
        $query = $this->db->get_where('shops', array('id' => $shop_id));
        return $query->result();
    }

    function update_record($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('shops', $data);
    }

    function show_shop_discount($shop_id) {
        $query = $this->db->get_where('shops', array('id' => $shop_id));
        return $query->result();
    }

    function num_record($company) {
        $query = $this->db->get_where('shops', array('company' => $company));
        return $query->num_rows();
    }

}