<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller 
{
    public function __construct(){ // make construct (run is firts) user not checkin without login
        parent::__construct();
        // helper check session and role
        is_logged_in();
    }

    public function index(){
        $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Menu Management';
        $data['menu']  = $this->db->get('menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        }else{
            $this->db->insert('menu', ['name_menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">New menu added :)
            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>

            </div>');
            
            redirect('menu');
        }
    }

    public function submenu(){
        $data['admin']   = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']   = 'Submenu Management';
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu']    = $this->db->get('menu')->result_array();


        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        }else{
            $data   =[
                'title'     => $this->input->post('title') ,
                'menu_id'   => $this->input->post('menu_id') ,
                'url'       => $this->input->post('url') ,
                'icon'      => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">New submenu added :)
            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button> 

            </div>');
            
            redirect('menu/submenu');
        }
    }

    public function editMenu($id){
        $data['admin']   = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']   = 'Edit Menu';

        $data['menu']   = $this->db->get_where('menu', ['id' => $id])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/edit-menu', $data);
        $this->load->view('templates/footer');
    }

    public function editSubMenu($id){
        $data['admin']   = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']   = 'Edit Sub Menu';

        $data['submenu']    = $this->db->get_where('sub_menu', ['id' => $id])->row_array();
        
        $this->load->model('Menu_model', 'menu');
        $data['editsubmenu'] = $this->menu->getSubMenuEdit($id);

        $data['menu']  = $this->db->get('menu')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/edit-submenu', $data);
        $this->load->view('templates/footer');
    }

    public function updateSubMenu(){
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        $id_submenu     = $this->input->post('id');
        $title   = $this->input->post('title');
        $menu_id        = $this->input->post('menu_id');
        $url            = $this->input->post('url');
        $icon           = $this->input->post('icon');
        $is_active      = $this->input->post('is_active');

        if($this->form_validation->run() == false){

            $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $data['title']  = 'Edit Sub Menu';
            $data['submenu']   = $this->db->get_where('sub_menu', ['id' => $id_submenu])->row_array();

            $this->load->model('Menu_model', 'menu');
            $data['editsubmenu'] = $this->menu->getSubMenuEdit($menu_id);
    
            $data['menu']  = $this->db->get('menu')->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/edit-submenu', $data);
            $this->load->view('templates/footer');
        }else{
            
            $set    =   array(
                'menu_id'   => $menu_id ,
                'title'     => $title ,
                'url'       => $url ,
                'icon'      => $icon,
                'is_active' => $is_active
            );
            $this->db->where('id', $id_submenu);
            $this->db->update('sub_menu', $set);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> The submenu is updated :)
            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            
            </div>');
            redirect('menu/submenu');
        }
    }

    public function updateMenu(){
        $this->form_validation->set_rules('menu', 'Nama Menu', 'required|trim');
        $id_menu    = $this->input->post('id');
        $name_menu  = $this->input->post('menu');

        if($this->form_validation->run() == false){

            $data['admin']  = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $data['title']  = 'Edit Menu';
            $data['menu']   = $this->db->get_where('menu', ['id' => $id_menu])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/edit-menu', $data);
            $this->load->view('templates/footer');
        }else{
            
            $this->db->set('name_menu', $name_menu);
            $this->db->where('id', $id_menu);
            $this->db->update('menu');

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> The menu is updated :)

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>

            </div>');
            redirect('menu');
        }
    }

    public function deleteMenu(){
        $id_menu    = $this->input->post('id');
        
        $this->db->where('id', $id_menu);
        $this->db->delete('menu');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> The menu is <span class="text-danger">deleted</span> :)
        
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>

        </div>');
        redirect('menu');
    }

    public function deleteSubMenu(){
        $id_menu    = $this->input->post('id');
        
        $this->db->where('id', $id_menu);
        $this->db->delete('sub_menu');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"> The submenu is <span class="text-danger">deleted</span> :)
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>

        </div>');
        redirect('menu/submenu');
    }

} 