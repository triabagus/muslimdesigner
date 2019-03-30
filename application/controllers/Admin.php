<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
    public function __construct(){ // make construct (run is firts) user not checkin without login
        parent::__construct();
        // helper check session and role
        is_logged_in();
    }

    public function index(){
        $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Dashboard';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role(){
        $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Role';
        
        $data['role']   = $this->db->get('role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAccess($role_id){
        $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Role Access';

        $data['role']   = $this->db->get_where('role', ['id_role' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu']   = $this->db->get('menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data   =[
            'menu_id' => $menu_id,
            'role_id' => $role_id
        ];

        $result = $this->db->get_where('access_menu', $data);

        if($result->num_rows() < 1){
            $this->db->insert('access_menu', $data);
        }else{
            $this->db->delete('access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Access Change :)</div>');
    }
}
