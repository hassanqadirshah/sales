<?php

class invoices_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add_sale_record($data) {
        $this->db->insert('invoices', $data);
        return $this->db->insert_id();
    }

    function get_invoice($company) {
        $sql = "SELECT MAX(invoice + 0) as invoice FROM invoices WHERE company = '$company'";
        $query = $this->db->query($sql)->result();
        return $query;
    }
    
    function get_id_DeltetRecord($invoice, $company)
    {
        $sql = "SELECT id FROM invoices WHERE company = '$company' AND (invoice = '$invoice')";
        $query = $this->db->query($sql)->result();
        return $query;
    }

}