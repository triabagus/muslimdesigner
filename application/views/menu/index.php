<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Menu Management</h1>
    

    <div class="row">
        <div class="col-lg-6">

        <?= form_error('menu','<div class="alert alert-danger" role="alert">','</div>');?>
        <?= $this->session->flashdata('message');?>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Menu</th>
                <th scope="col">Option</th>
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
                    <a href="<?= base_url('menu/editMenu/'). $m['id'];?>" class="badge badge-success">Edit</a>
                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#deleteMenuModal<?= $m['id'];?>">Delete</a>
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
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?= base_url('menu');?>" method="post">
      <div class="modal-body">
        <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="menu name">
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
  foreach ($menu as $m) : 
?>
<div class="modal fade" id="deleteMenuModal<?= $m['id'];?>" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteMenuModalLabel">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p>Are you sure you want to delete data <b><?= $m['name_menu'];?></b></p>
      </div>
      <div class="modal-footer">
        <form action="<?= base_url('menu/deleteMenu');?>" method="post">
          <input type="hidden" class="form-control" id="menu" name="id" value="<?= $m['id']; ?>">
          <button type="submit" class="btn btn-danger">Delete</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </form>
      </div>

    </div>
  </div>
</div>
<?php endforeach;?>