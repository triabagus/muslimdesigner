 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Role Management</h1>
    

    <div class="row">
        <div class="col-lg-6">

        <?= $this->session->flashdata('message');?>
        
        <h5>Role : <?= $role['name_role'];?></h5>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Menu</th>
                <th scope="col">Access</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i=1;
                foreach ($menu as $m) : 
            ?>
                <tr>
                <th scope="row"><?= $i++;?></th>
                <td><?= $m['name_menu'];?></td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" <?= check_access($role['id_role'], $m['id']);?> data-role="<?= $role['id_role'];?>" data-menu="<?= $m['id'];?>">
                    </div>
                </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->