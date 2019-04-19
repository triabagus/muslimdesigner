<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Role Management</h1>
    

    <div class="row">
        <div class="col-lg-6">
        <?= form_error('role','<div class="alert alert-danger" role="alert">','</div>');?>
        <?= $this->session->flashdata('message');?>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Add New Role</a>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Role</th>
                <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i=1;
                foreach ($role as $r) : 
            ?>
                <tr>
                <th scope="row"><?= $i++;?></th>
                <td><?= $r['name_role'];?></td>
                <td>
                    <a href="<?= base_url('admin/roleaccess/'). $r['id_role'];?>" class="badge badge-warning">Access</a>
                    <a href="<?= base_url('admin/editrole/'). $r['id_role'];?>" class="badge badge-success">Edit</a>
                    <a href="#" data-toggle="modal" data-target="#deleteRoleModal<?= $r['id_role'];?>" class="badge badge-danger">Delete</a>
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

<!-- Modal Add Menu -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?= base_url('admin/role');?>" method="post">
      <div class="modal-body">
        <div class="form-group">
            <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
      </form>

    </div>
  </div>
</div>

<!-- Modal delete Menu -->
<?php 
  foreach ($role as $r) : 
?>
<div class="modal fade" id="deleteRoleModal<?= $r['id_role'];?>" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteRoleModalLabel">Warning </h5>
      </div>
      <div class="modal-body">
      <p>Are you sure you want to delete data <b><?= $r['name_role'];?></b></p>
      </div>
      <div class="modal-footer">
        <form action="<?= base_url('admin/deleterole');?>" method="POST">
          <input type="hidden" name="idRole" value="<?= $r['id_role'];?>">
          <button type="submit" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach;?>