<?php

class Material_model extends CI_Model {

    function show_record($company, $limit, $start_from) {
        $sql = "SELECT * FROM materials_name WHERE company = '$company' ORDER BY mat_name LIMIT $start_from,10";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function show_recordDT($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("mat_name");
        $this->db->from('materials_name');
        $query = $this->db->get();
        return $query->result();
    }

    function num_record($company) {
        $sql = "SELECT * FROM materials_name WHERE company = '$company'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function add_record($data) {
        $this->db->insert('materials_name', $data);
        return;
    }

    function delete_mat_record($mat_id) {
        $this->db->where('id', $mat_id);
        $this->db->delete('materials_name');
    }

    function get_item_record($mat_id) {
        $query = $this->db->get_where('materials_name', array('id' => $mat_id));
        return $query->result();
    }

    function update_record($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('materials_name', $data);
    }

    function show_material_record($company) {
        $query = $this->db->get_where('materials_name', array('company' => $company));
        return $query->result();
    }

    function add_purchase_record($data, $qty, $id) {
        $this->db->insert('materials_purchase', $data);

        $sql = "UPDATE materials_name SET total_qty = total_qty + $qty WHERE id = $id";
        $query = $this->db->query($sql);
        return;
    }

    function fetch_mat_qty($mat_id) {
        $sql = "SELECT total_qty AS total_qty FROM materials_name WHERE id = '$mat_id'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function release_mat_record($data, $qty, $id) {
        $this->db->insert('materials_release', $data);

        $sql = "UPDATE materials_name SET total_qty = total_qty - $qty WHERE id = $id";
        $query = $this->db->query($sql);
        return;
    }

    function edit_mat_record($data, $qty, $id) {
        $this->db->insert('materials_release', $data);
        return;
    }

    function update_mat_qty($qty, $id) {
        $sql = "UPDATE materials_name SET total_qty = total_qty - $qty WHERE id = $id";
        $query = $this->db->query($sql);
        return;
    }

    function get_invoice($company, $col_name) {
        $sql = "SELECT MAX(invoice + 0) as invoice FROM $col_name WHERE company = '$company'";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_mat_record($company) {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->order_by("mat_name");
        $this->db->from('materials_name');
        $query = $this->db->get();
        return $query->result();
    }

    function show_purchase_record($company) {
        $sql = "SELECT materials_name.id,materials_purchase.buyer, materials_name.mat_name, materials_purchase.id AS purchase_id, 
            materials_purchase.mat_id, materials_purchase.mat_qty, materials_purchase.mat_price, 
            materials_purchase.single_price, materials_purchase.purchase_date, materials_purchase.invoice  
            from materials_purchase INNER JOIN materials_name ON materials_purchase.mat_id = materials_name.id 
            WHERE materials_purchase.company = '$company' ORDER BY materials_purchase.purchase_date";
//**********BELOW QUERY WILL DISPLAY RECORD GROUP BY MAT_NAME AND SUM OF QUANTITY***********//
//**********IT WILL HIDE REPEATING ROWS OF SAME INVOICE AND DATE***************//
//        $sql = "SELECT materials_name.id, materials_name.mat_name, materials_purchase.id AS purchase_id, 
//            materials_purchase.mat_id, SUM(materials_purchase.mat_qty) as mat_qty, materials_purchase.mat_price, 
//            materials_purchase.single_price, materials_purchase.purchase_date, materials_purchase.invoice  
//            from materials_purchase INNER JOIN materials_name ON materials_purchase.mat_id = materials_name.id 
//            WHERE materials_purchase.company = '$company' GROUP BY materials_name.mat_name ORDER BY materials_purchase.purchase_date";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function delete_mat_report($mat_id, $column) {
        $this->db->where('id', $mat_id);
        $this->db->delete($column);
    }

    function update_mat_record($id, $qty) {
        $sql = "UPDATE materials_name SET total_qty = total_qty - $qty WHERE id = $id";
        $query = $this->db->query($sql);
        return;
    }

    function show_release_record($company) {
        $sql = "SELECT materials_name.id, materials_name.mat_name, materials_release.id AS release_id, 
            materials_release.mat_id, materials_release.mat_qty, materials_release.text, materials_release.release_date, materials_release.invoice  
            from materials_release INNER JOIN materials_name ON materials_release.mat_id = materials_name.id 
            WHERE materials_release.company = '$company' ORDER BY materials_release.release_date";

        $query = $this->db->query($sql)->result();
        return $query;
    }

    function delete_mat_release_report($mat_id, $id, $qty) {
        $this->db->where('id', $mat_id);
        $this->db->delete('materials_release');

        $sql = "UPDATE materials_name SET total_qty = total_qty + $qty WHERE id = $id";
        $query = $this->db->query($sql);
    }

    function get_record_date($fromdate, $todate, $name, $mat, $company) {
        if ($fromdate != NULL && $todate != NULL) {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_purchase.id AS purchase_id, 
            materials_purchase.mat_id, materials_purchase.mat_qty, materials_purchase.mat_price, 
            materials_purchase.single_price, materials_purchase.purchase_date, materials_purchase.invoice  
            from materials_purchase INNER JOIN materials_name ON materials_purchase.mat_id = materials_name.id 
            WHERE materials_purchase.purchase_date >= '{$fromdate}' AND (materials_purchase.purchase_date <= '{$todate}') 
            AND (materials_purchase.company = '$company')";
        } elseif ($fromdate != NULL && $todate == NULL) {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_purchase.id AS purchase_id, 
            materials_purchase.mat_id, materials_purchase.mat_qty, materials_purchase.mat_price, 
            materials_purchase.single_price, materials_purchase.purchase_date, materials_purchase.invoice  
            from materials_purchase INNER JOIN materials_name ON materials_purchase.mat_id = materials_name.id 
            WHERE materials_purchase.purchase_date >= '{$fromdate}' AND (materials_purchase.company = '$company')";
        } elseif ($fromdate == NULL && $todate != NULL) {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_purchase.id AS purchase_id, 
            materials_purchase.mat_id, materials_purchase.mat_qty, materials_purchase.mat_price, 
            materials_purchase.single_price, materials_purchase.purchase_date, materials_purchase.invoice  
            from materials_purchase INNER JOIN materials_name ON materials_purchase.mat_id = materials_name.id 
            WHERE materials_purchase.purchase_date <= '{$todate}' AND (materials_purchase.company = '$company')";
        } else {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_purchase.id AS purchase_id, 
            materials_purchase.mat_id, materials_purchase.mat_qty, materials_purchase.mat_price, 
            materials_purchase.single_price, materials_purchase.purchase_date, materials_purchase.invoice  
            from materials_purchase INNER JOIN materials_name ON materials_purchase.mat_id = materials_name.id 
            WHERE (materials_purchase.company = '$company')";
        }
        if ($mat != "") {
            $sql = $sql . "AND (materials_purchase.mat_id = '{$mat}')";
        }
        if ($name != "") {
            echo $sql = $sql . "AND (materials_purchase.buyer = '{$name}')";
            
        }
        $sql = $sql . " ORDER BY materials_purchase.purchase_date";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function get_release_record_date($fromdate, $todate, $mat, $company) {
        if ($fromdate != NULL && $todate != NULL) {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_release.id AS release_id, 
            materials_release.mat_id, materials_release.mat_qty, materials_release.release_date, materials_release.invoice  
            from materials_release INNER JOIN materials_name ON materials_release.mat_id = materials_name.id 
            WHERE materials_release.release_date >= '{$fromdate}' AND (materials_release.release_date <= '{$todate}') 
            AND (materials_release.company = '$company')";
        } elseif ($fromdate != NULL && $todate == NULL) {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_release.id AS release_id, 
            materials_release.mat_id, materials_release.mat_qty, materials_release.release_date, materials_release.invoice  
            from materials_release INNER JOIN materials_name ON materials_release.mat_id = materials_name.id 
            WHERE materials_release.release_date >= '{$fromdate}' AND (materials_release.company = '$company')";
        } elseif ($fromdate == NULL && $todate != NULL) {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_release.id AS release_id, 
            materials_release.mat_id, materials_release.mat_qty, materials_release.release_date, materials_release.invoice  
            from materials_release INNER JOIN materials_name ON materials_release.mat_id = materials_name.id 
            WHERE (materials_release.release_date <= '{$todate}') AND (materials_release.company = '$company')";
        } else {
            $sql = "SELECT materials_name.id, materials_name.mat_name, materials_release.id AS release_id, 
            materials_release.mat_id, materials_release.mat_qty, materials_release.release_date, materials_release.invoice  
            from materials_release INNER JOIN materials_name ON materials_release.mat_id = materials_name.id 
            WHERE (materials_release.company = '$company')";
        }
        if ($mat != "") {
            $sql = $sql . "AND (materials_release.mat_id = '{$mat}')";
        }
        $sql = $sql . " ORDER BY materials_release.release_date";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function show_record2($company) {
        $sql = "SELECT * FROM materials_name WHERE company = '$company' ORDER BY mat_name";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_purchase_record_invoice($company, $invoice) {
        $sql = "SELECT * FROM materials_purchase WHERE company = '$company' AND (invoice = '$invoice')";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function delete_purchase_record($invoice, $company, $column) {
        $this->db->where('invoice', $invoice);
        $this->db->where('company', $company);
        $this->db->delete($column);
    }

    function get_release_record_invoice($company, $invoice) {
        $sql = "SELECT * FROM materials_release WHERE company = '$company' AND (invoice = '$invoice')";
        $query = $this->db->query($sql)->result();
        return $query;
    }

    function update_mat_release_record($id, $qty) {
        $sql = "UPDATE materials_name SET total_qty = total_qty + $qty WHERE id = $id";
        $query = $this->db->query($sql);
        return;
    }

    function reverse_mat_release_record($id, $qty) {
        $sql = "UPDATE materials_name SET total_qty = total_qty - $qty WHERE id = $id";
        $query = $this->db->query($sql);
        return;
    }

    function check_mat_release_record($mat_array, $qty_array) {
        $sql = "SELECT total_qty FROM materials_name WHERE id = '$mat_array'";
        $query = $this->db->query($sql)->result();
//        echo "<pre>";
//        print_r($query);
//        exit;
        return $query;
    }

}
