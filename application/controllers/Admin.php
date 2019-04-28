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

        $this->form_validation->set_rules('role', 'Nama Role', 'required|trim');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        }else{
            $this->db->insert('role', ['name_role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> The role is inserted :)
            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>

            </div>');

            redirect('admin/role');
        }

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

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Access Change :)
        
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>

        </div>');

    }

    public function editRole($role_id){
        $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Edit Role';
        $data['role']   = $this->db->get_where('role', ['id_role' => $role_id])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-role', $data);
            $this->load->view('templates/footer');
    }

    public function updateRole(){
        $this->form_validation->set_rules('role', 'Nama Role', 'required|trim');
        $id_role    = $this->input->post('id');
        $name_role  = $this->input->post('role');

        if($this->form_validation->run() == false){

            $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $data['title']  = 'Edit Role';
            $data['role']   = $this->db->get_where('role', ['id_role' => $id_role])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-role', $data);
            $this->load->view('templates/footer');
        }else{
            
            $this->db->set('name_role', $name_role);
            $this->db->where('id_role', $id_role);
            $this->db->update('role');

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> The role is updated :)
            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>

            </div>');

            redirect('admin/role');
        }
    }

    public function deleteRole(){
        $id_role    = $this->input->post('idRole');
        
        $this->db->where('id_role', $id_role);
        $this->db->delete('role');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> The role is deleted :)
        
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>

        </div>');
        
        redirect('admin/role');
    }
}
