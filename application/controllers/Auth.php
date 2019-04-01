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
        /**
         * Make to auth user and admin don't to url
         */

        if($this->session->userdata('email')){
            redirect('member');
        }

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
                    
                    if($admin['role_id'] == 1){
                        redirect('admin');
                    }else{
                        redirect('member');
                    }
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
        /**
         * Make to auth user and admin don't to url
         */

        if($this->session->userdata('email')){
            redirect('member');
        }

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

            $email= $this->input->post('email', true);
            $data = [
                'email'         => htmlspecialchars($email),
                'name'          => htmlspecialchars($this->input->post('name', true)),
                'password'      => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id'       => 2,
                'is_active'     => 0,
                'image'         => 'default.png',
                'date_created'  => time()
            ];

            // Shift Token variable random text
            $token          =   base64_encode(random_bytes(32));
            $user_token     =   [
                'email'         => $email,
                'token'         => $token,
                'date_created'  => time()
            ];

            $this->db->insert('admin', $data);
            $this->db->insert('user_token', $user_token);

            // method _sendEmail modefayer private
            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation , your account has been created. Please your activated account :)</div>');
            redirect('auth');
        }
    }

    /**
     * function _sendEmail method private insert to email 
     */
    private function _sendEmail($token, $type){
        // configuration smtp gmail
        $config =[
            'protocol'  =>  'smtp',
            'smtp_host' =>  'ssl://smtp.googlemail.com',
            'smtp_user' =>  'triatop9@gmail.com',
            'smtp_pass' =>  'triatopmaestrotopx12345',
            'smtp_port' =>  465,
            'mailtype'  =>  'html',
            'charset'   =>  'utf-8',
            'newline'   =>  "\r\n"
        ];

        // call library email on codeigniter with parameter $config
        $this->email->initialize($config);

        $this->email->from('triatop9@gmail.com', 'MuslimDesaigner.com');
        $this->email->to($this->input->post('email'));

        if($type  == 'verify'){

            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify you account : <a href="'. base_url() .'auth/verify?email='. $this->input->post('email') .'&token='. urlencode($token) .'">Activate</a>');

        }

        if( $this->email->send()){
            return true;
        }else{
            echo $this->email->print_debugger();
            die;
        }
    }

    /**
     * function verify for send email proccess
     */
    public function verify(){

        $email  =   $this->input->get('email');
        $token  =   $this->input->get('token');

        //check in database because manually url and jail users :)
        $admin  =   $this->db->get_where('admin', ['email' => $email])->row_array();

        if($admin){
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            
            if($user_token){
                // expired time activated user
                if(time() - $user_token['date_created'] < (60 * 60 * 24)){
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('admin');

                    $this->db->delete('user_token', ['email', $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    '. $email .' has been activated. Please your login :)</div>');
                    redirect('auth');
                }else{

                    $this->db->delete('admin',  ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Your activate is failed :) Token is expired .</div>');
                    redirect('auth');
                }

            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Your activate is failed :) Wrong is token .</div>');
                redirect('auth');
            }

        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Your activate is failed :) Wrong is email .</div>');
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

    public function blocked(){
        $this->load->view('auth/blocked');
    }
}
