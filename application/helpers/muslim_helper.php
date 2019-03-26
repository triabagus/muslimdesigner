<?php

function is_logged_in()
{
    $ci = get_instance();
    // get library codeigniter
    if(!$ci->session->userdata('email')){ 
        // if session email not found
        redirect('auth');
        // redirect page login
    } else {
        $role_id    = $ci->session->userdata('role_id'); // get session role id
        $menu       = $ci->uri->segment(1); // see url menu segment 1

        $queryMenu  = $ci->db->get_where('menu' , ['name_menu' => $menu])->row_array(); 
        // query menu get menu about url menu rows
        $menuId     = $queryMenu['id'];
        // get menuid with variable $menuId

        $accessMenu = $ci->db->get_where('access_menu',[
            'role_id'   => $role_id ,
            'menu_id'   => $menuId
        ]);
        // check access menu role id and menu id with access menu table #endregion
        
        if($accessMenu->num_rows() < 1){ 
            redirect('auth/blocked');
        }
        // access menu nothing so to page blocked in auth
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    // get ci library

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('access_menu');

    /*
        or query :
        $ci->db->get_where('access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);
    */
    
    if($result->num_rows() > 0){
        return "checked='checked'";
    }
    
}
