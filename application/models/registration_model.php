<?php

class Registration_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function add_record($data)
    {
        $this->db->insert('user',$data);
        return;
    }
    
    function get_user_details($email,$password)
    {
        $sql = "SELECT * FROM user WHERE email = '$email' AND (password = '$password') AND (active = 1)";
        $query = $this->db->query($sql)->result();
        return $query;
    }
    
    function add_emplyee_record($data)
    {
        $this->db->insert('user',$data);
        return;
    }
    
    function update_user_record($data , $id)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }
    
    function update_record($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }
}