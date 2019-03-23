<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
    public function index(){
        $data['admin']  =$this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        echo "welcome to ". $data['admin']['name'];
    }
}