<?php

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('registration_model');
        $this->load->model('admin_model');
    }

    function index()
    {
        if (isset($_GET['user_id']))
        {
            $user_details = $this->admin_model->get_user_details_byid($_GET['user_id']);
            $data = array(
                    'name' => $user_details[0]->name,
                    'email' => $user_details[0]->email,
                    'password' => $user_details[0]->password,
                    'company' => $user_details[0]->company,
                    'gender' => $user_details[0]->gender,
                    'position' => $user_details[0]->position,
                    'active' => 1
                );
            $this->registration_model->update_record($user_details[0]->id, $data);
        }
        $this->load->view('user_login/login_view');
    }

    function login_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('user_login/login_view');
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $found = $this->registration_model->get_user_details($email, $password);
            if (count($found))
            {
                $data['user_record'] = $this->registration_model->get_user_details($email, $password);
                $newdata = array(
                    'user_email' => $this->input->post('email'),
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($newdata);
                redirect('sales');
            }
            else
            {
                redirect('login');
            }
        }
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        redirect('login');
    }

    function signup()
    {
        if (isset($_GET['user_id']))
        {
            $data['record'] = $this->admin_model->get_user_details_byid($_GET['user_id']);
            $this->load->view('user_login/signup_view', $data);
        }
        else
        {
            $data['record'] = null;
            $this->load->view('user_login/signup_view', $data);
        }
    }

    function signup_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            redirect('login/signup');
            //$this->load->view('user_login/signup_view');
        }
        else
        {
            if ($this->input->post('user_id') != 'new')
            {
                $id = $this->input->post('user_id');
                $data = array(
                    'email' => $this->input->post('email'),
                    'name' => $this->input->post('name'),
                    'password' => $this->input->post('password'),
                    'company' => $this->input->post('company'),
                    'gender' => $this->input->post('gender'),
                    'position' => 'Employee',
                    'active' => 1
                );
                $this->registration_model->update_record($id, $data);
            }
            else
            {
                $data = array(
                    'email' => $this->input->post('email'),
                    'name' => $this->input->post('name'),
                    'password' => $this->input->post('password'),
                    'company' => $this->input->post('company'),
                    'gender' => $this->input->post('gender'),
                    'position' => 'Administrator',
                    'active' => 0
                );
                $this->registration_model->add_record($data);

                //email functionality
                $id = $this->admin_model->get_user_details($this->input->post('email'));
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'umair.malik@purelogics.net',
                    'smtp_pass' => 'umaircs10'
                );
                $message = 'Your account has been created. Please click on the following URL to activate your account
                http://salerecord.iserver.purelogics.net/sales/index.php/login?user_id=' . $id[0]->id;
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('umair.malik@purelogics.net', 'Sales');
                $this->email->to($this->input->post('email'));
                $this->email->subject('Welcome to Shop Management');
                $this->email->message($message);

                if ($this->email->send())
                {
                    
                }
                else
                {
                    redirect('login/signup');
                }


                //end email
            }

            redirect('login');
        }
    }

}
