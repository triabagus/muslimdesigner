<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
  <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-pen-nib"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Admin MD</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- QUERY MENU -->
  <?php
    $role_id    = $this->session->userdata('role_id');
    $query_menu = "SELECT `menu`.`id` , `name_menu` 
                    FROM `menu` JOIN `access_menu` 
                    ON `menu`.`id` = `access_menu`.`menu_id`
                    WHERE `access_menu`.`role_id` = $role_id
                    ORDER BY `access_menu`.`menu_id` ASC
                  ";
    $menu = $this->db->query($query_menu)->result_array();
  ?>
<!-- Looping Menu -->
<?php foreach($menu as $m):?>
  <div class="sidebar-heading">
    <?= $m['name_menu']; ?>
  </div>
  <!-- Query Sub Menu -->
  <?php
      $menuId = $m['id'];
      $querySubMenu ="SELECT *
                      FROM `sub_menu` 
                      WHERE `menu_id` = $menuId
                      AND `is_active` = 1
                    ";
      $subMenu = $this->db->query($querySubMenu)->result_array();
    ?>
    <?php foreach($subMenu as $sm):?>
    <?php if($title == $sm['title']):?>
      <li class="nav-item active">
    <?php else :?>
      <li class="nav-item">
    <?php endif;?>
        <a class="nav-link" href="<?= base_url($sm['url'])?>">
          <i class="<?= $sm['icon'];?>"></i>
          <span><?= $sm['title'];?></span></a>
      </li>
    <?php endforeach;?>
    <hr class="sidebar-divider">
<?php endforeach;?>

<li class="nav-item">
  <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
    <i class="fas fa-fw fa-sign-out-alt"></i>
    <span>Logout</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->