<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
    public function index(){
        $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Dashboard Admin | Muslimdesaigner.com';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
}