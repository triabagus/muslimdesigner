<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model 
{
    public function getSubMenu(){
        $query  ="SELECT `sub_menu`.*,  `menu`.`name_menu`
                    FROM `sub_menu` JOIN `menu`
                    ON `sub_menu`.`menu_id` = `menu`.`id`
                ";
        return $this->db->query($query)->result_array();
    }
}