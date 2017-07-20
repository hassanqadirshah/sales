<?php

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $islogged_in = require_admin_login();
        if(!$islogged_in)
        {
            redirect('login');
        }
        $this->load->model('admin_model');
        $this->load->model('registration_model');
    }
    
    function index()
    {
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $this->load->view('admin/adminpanel_view',$data);
    }
    
    function add_employee()
    {
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $this->load->view('admin/addEmployee_view', $data);
    }
    
    function add_employee_validation()
    {
        $this->load->library('form_validation');
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        //$this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
        //$this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE)
	{
            $this->load->view('admin/addEmployee_view', $data);
	}
        else
        {
            $data = array(
                'email' => $this->input->post('email'),
                //'name' => $this->input->post('name'),
                //'password' => $this->input->post('password'),
                'company' => $this->input->post('company'),
                //'gender' => $this->input->post('gender'),
                'position' => 'Employee',
                'active' => 0
            );
        
            $this->registration_model->add_emplyee_record($data);
            
            $id = $this->admin_model->get_user_details($this->input->post('email'));
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'umair.malik@purelogics.net',
                'smtp_pass' => 'umaircs10'
            );
            $message = 'Your account has been created. Please click on the following URL to activate your account
                http://salerecord.iserver.purelogics.net/sales/index.php/login/signup?user_id='.$id[0]->id;
            $this->load->library('email',$config);
            $this->email->set_newline("\r\n");
            $this->email->from('umair.malik@purelogics.net','Sales');
            $this->email->to($this->input->post('email'));
            $this->email->subject('Welcome to Shop Management');
            $this->email->message($message);
            
            if($this->email->send())
            {
                
            }
            else
            {
                redirect('admin/add_employee');
            }
            redirect('admin');
        }
    }
    
    function edit_profile()
    {
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $this->load->view('admin/editProfile_view', $data);
    }
    
    function update_employee_validation()
    {
        $this->load->library('form_validation');
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('position', 'Position', 'required');
        if ($this->form_validation->run() == FALSE)
	{
            $this->load->view('admin/editProfile_view', $data);
	}
        else
        {
            $data = array(
                'email' => $this->input->post('email'),
                'name' => $this->input->post('name'),
                'company' => $this->input->post('company'),
                'gender' => $this->input->post('gender'),
                'position' => $this->input->post('position')
            );
            $id = $this->input->post('id');
            $this->registration_model->update_user_record($data , $id);
            redirect('admin');
        }
    }
    
    function emplyee_profile()
    {
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $email = $this->session->userdata('user_email');
        $company = $this->admin_model->get_company_details($email);
        $company[0]->company;
        $data['employee_record'] = $this->admin_model->get_employee_details($company[0]->company);
        $this->load->view('admin/employeeProfile_view', $data);
    }
    
    function delete_employee()
    {
        $id = $this->input->post('id');
        $this->admin_model->delete_employee_record($id);
        $this->index();
    }
    
    function edit_employee()
    {
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $id = $this->input->post('id');
        $data['employee_record'] = $this->admin_model->update_employee_details($id);
        $this->load->view('admin/editEmployee_view', $data);
    }
    
    function pending_request()
    {
        $email = $this->session->userdata('user_email');
        $data['user_record'] = $this->admin_model->get_user_details($email);
        $email = $this->session->userdata('user_email');
        $company = $this->admin_model->get_company_details($email);
        $company[0]->company;
        $data['employee_record'] = $this->admin_model->get_pendingrequest($company[0]->company);
        $this->load->view('admin/employeeProfile_view', $data);
    }
}
