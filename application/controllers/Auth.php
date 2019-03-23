<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false){
            $data['title']  = 'Login | MuslimDesaigner.com';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }else{
            // validation success
            $this->_login();
        }
    }
    
    private function _login()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');

        $admin      = $this->db->get_where('admin', ['email' => $email])->row_array();

        // if admin is one
        if($admin){
            // if admin active
            if($admin['is_active'] == 1){
                // check is password
                if(password_verify($password, $admin['password'])){
                    $data   =[
                        'email'     => $admin['email'],
                        'role_id'   => $admin['role_id']
                    ];
                    $this->session->set_userdata($data);
                    redirect('user');
                }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password :)</div>');
                    redirect('auth');
                }
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                This email has been not actived :)</div>');
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email not is registered :)</div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[admin.email]', [
            'is_unique'     => 'This email has already registered :)'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]',[
            'matches'       => 'Password dont match :)',
            'min_length'    => 'Password too short :)'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run()   == false){
            $data['title']  = 'Registration | MuslimDesaigner.com';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                'email'         => htmlspecialchars($this->input->post('email', true)),
                'name'          => htmlspecialchars($this->input->post('name', true)),
                'password'      => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id'       => 2,
                'is_active'     => 1,
                'image'         => 'default.png',
                'date_created'  => time()
            ];

            $this->db->insert('admin', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation , your account has been created. Please your login :)</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        You have been logged out :)</div>');
        redirect('auth');
    }
}
