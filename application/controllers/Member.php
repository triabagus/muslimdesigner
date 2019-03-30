<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller 
{
    public function __construct(){ // make construct (run is firts) user not checkin without login
        parent::__construct();
        // helper check session and role
        is_logged_in();
    }

    public function index(){
        $data['admin']  =$this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        // Same in filed title database for title because active menu 
        $data['title']  = 'My Profile';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('member/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Make to controle edit profile
     */
    public function edit(){
        $data['admin']  =$this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        // Same in filed title database for title because active menu 
        $data['title']  = 'Edit Member';

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('member/edit', $data);
            $this->load->view('templates/footer');
        }else{
            $name   = $this->input->post('name');
            $email  = $this->input->post('email');

            // check image name
            $upload_image   = $_FILES['image']['name'];

            // var_dump($upload_image); check upload image
            // die;
            if($upload_image){
                $config['allowed_types'] = 'gif|jpg|png'; // type image
                $config['max_size']     = '2048'; // 100 = kilobyte
                $config['upload_path'] = './assets/img/profile/'; // path general .

                $this->load->library('upload', $config);

                if($this->upload->do_upload('image')){

                    // check old image
                    $old_image   = $data['admin']['image'];
                    if($old_image != 'default.png'){
                        unlink(FCPATH . 'assets/img/profile/' . $old_image); // delete old image
                    }

                    $new_image      = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                }else{
                    echo $this->upload->display_errors();
                }

            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('admin');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your profile has been updated :)</div>');
            redirect('member');
        }
    }

}