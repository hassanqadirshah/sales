<?php

class Item_model extends CI_Model {

    function add_record($data) {
        $this->db->insert('items', $data);
        return;
    }

    function show_record($company, $limit, $start_from) {
        $sql = "SELECT * FROM items WHERE company = '$company' ORDER BY item_name LIMIT $start_from,10";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function show_recordDT($company) {
        $sql = "SELECT * FROM items WHERE company = '$company' ORDER BY item_name";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function show_record2($company) {
        $sql = "SELECT * FROM items WHERE company = '$company' ORDER BY item_name";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function show_sale_record($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("item_name");
        $this->db->from('items');
        $query = $this->db->get();
        return $query->result();

//        $sql = "SELECT * FROM items WHERE company = '$company'";
//        $query = $this->db->query($sql);
//        return $query->result();
    }

    function delete_item_record($item_id) {
        $this->db->where('id', $item_id);
        $this->db->delete('items');
    }

    function get_item_record($item_id) {
        $query = $this->db->get_where('items', array('id' => $item_id));
        return $query->result();
    }

    function update_record($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('items', $data);
    }

    function show_item_price($item_id) {
        $query = $this->db->get_where('items', array('id' => $item_id));
        $result = $query->result();
//        echo '<pre>';
//        print_r($result);
//        exit;
        return $query->result();
    }

    function num_record($company) {
        $sql = "SELECT * FROM items WHERE company = '$company'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_record_date($fromdate, $todate, $shop, $item, $id, $start_from) {
        if ($fromdate != NULL && $todate != NULL) {
            $sql = "SELECT itemsalerecord.*, itemsaledetail.*,items.* , shops.shop_name ,shops.discount , shops.id AS 
            shop_id FROM itemsalerecord INNER JOIN itemsaledetail ON  itemsalerecord.itemSaleDetailId = itemsaledetail.id 
            INNER JOIN items ON itemsalerecord.item_id = items.id INNER JOIN shops ON itemsaledetail.shop_id = 
            shops.id WHERE itemsaledetail.sale_date >= '{$fromdate}' AND (itemsaledetail.sale_date <= '{$todate}') 
            AND (itemsaledetail.user_id = '$id') LIMIT $start_from,10";
        } elseif ($fromdate != NULL && $todate == NULL) {
            $sql = "SELECT itemsalerecord.*, itemsaledetail.*,items.* , shops.shop_name ,shops.discount , shops.id AS 
            shop_id FROM itemsalerecord INNER JOIN itemsaledetail ON  itemsalerecord.itemSaleDetailId = itemsaledetail.id 
            INNER JOIN items ON itemsalerecord.item_id = items.id INNER JOIN shops ON itemsaledetail.shop_id = 
            shops.id WHERE itemsaledetail.sale_date >= '{$fromdate}' AND (itemsaledetail.user_id = '$id')";
        } elseif ($fromdate == NULL && $todate != NULL) {
            $sql = "SELECT itemsalerecord.*, itemsaledetail.*,items.* , shops.shop_name ,shops.discount , shops.id AS 
            shop_id FROM itemsalerecord INNER JOIN itemsaledetail ON  itemsalerecord.itemSaleDetailId = itemsaledetail.id 
            INNER JOIN items ON itemsalerecord.item_id = items.id INNER JOIN shops ON itemsaledetail.shop_id = 
            shops.id WHERE itemsaledetail.sale_date <= '{$todate}' AND (itemsaledetail.user_id = '$id')";
        } else {
            $sql = "SELECT itemsalerecord.*, itemsaledetail.*,items.* , shops.shop_name ,shops.discount , shops.id AS 
            shop_id FROM itemsalerecord INNER JOIN itemsaledetail ON  itemsalerecord.itemSaleDetailId = itemsaledetail.id 
            INNER JOIN items ON itemsalerecord.item_id = items.id INNER JOIN shops ON itemsaledetail.shop_id = 
            shops.id WHERE itemsaledetail.user_id = '$id'";
        }
        if ($shop != "") {
            $sql = $sql . "AND (shops.shop_name = '{$shop}')";
        }
        if ($item != "") {
            $sql = $sql . "AND (items.item_name = '{$item}')";
        }
        $sql = $sql . "ORDER BY shops.shop_name,itemsaledetail.sale_date LIMIT $start_from,10";
        $query = $this->db->query($sql)->result();
        return $query;
    }

}