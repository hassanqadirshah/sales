<?php

class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_user_details($email)
    {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
//        $sql = "SELECT * FROM user WHERE email = '$email'";
//        $query = $this->db->query($sql)->result();
//        return $query;
    }
    
    function get_user_details_byid($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_employee_details($company)
    {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->where('position', 'Employee');
        $this->db->where('active', '1');
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_company_details($email)
    {
        $this->db->select('company');
        $this->db->where('email', $email);
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }
    
    function delete_employee_record($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user'); 
    }
    
    function update_employee_details($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_pendingrequest($company)
    {
        $this->db->select('*');
        $this->db->where('company', $company);
        $this->db->where('active', '0');
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }
}
