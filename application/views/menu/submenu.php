<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Submenu Management</h1>
    
    <div class="row">
    
        <div class="col-lg-8">
        <?php if(validation_errors()):?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif;?>
        
        <?= $this->session->flashdata('message');?>
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add New Submenu</a>

        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Menu</th>
                <th scope="col">Url</th>
                <th scope="col">Icon</th>
                <th scope="col">Active</th>
                <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i=1;
                foreach ($subMenu as $sm) : 
            ?>
                <tr>
                <th scope="row"><?= $i++;?></th>
                <td><?= $sm['title'];?></td>
                <td><?= $sm['name_menu'];?></td>
                <td><?= $sm['url'];?></td>
                <td><?= $sm['icon'];?></td>
                <td><?= $sm['is_active'];?></td>
                <td>
                    <a href="<?= base_url('menu/editSubMenu/'). $sm['id'];?>" class="badge badge-success">Edit</a>
                    <a href="#" class="badge badge-danger" data-toggle="modal" data-target="#deleteSubMenuModal<?= $sm['id'];?>">Delete</a>
                </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

        </div>
        
        <!-- Information Menu Management -->
        <div class="col-lg-4 ">
        
        <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Information</h6>
        </div>
        <div class="card-body">
            <div class="text-center">
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url('assets/');?>img/info/undraw_personal_settings_kihd.svg" alt="info menu management">
            </div>
            <p>
                I help you guys, informations menu management in here just simple but secure for every want. So i hope you interest ux experience.
            </p>
            
            <!-- Card Header - Accordion -->
            <div class="card shadow mb-2">
                <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Add url , where?</h6>
                </a>

                <div class="collapse" id="collapseCardExample" style="">
                    <div class="card-body">
                        Admin developer add menu url okay.
                    </div>
                </div>
            </div>

            <!-- Card Header - Accordion -->
            <div class="card shadow mb-2">
                <a href="#collapseCardExample2" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample2">
                    <h6 class="m-0 font-weight-bold text-primary">Icon add fa-fw </h6>
                </a>
                <div class="collapse" id="collapseCardExample2" style="">
                    <div class="card-body">
                    If you add icon , search in here <a href="https://fontawesome.com/icons?d=gallery" target="_blank" rel="font"> Fa fa-icon </a>. And you add fa-fw ,because <strong>Menu cool in sidebar admin</strong> so see deverent!
                    </div>
                </div>
            </div>
            
            <a target="_blank" rel="helpme" href="#">Help Me →</a>
        </div>
        </div>

        </div>
        <!-- Information Menu Management -->

    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Modal Add Menu -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
            <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body">

            <form action="<?= base_url('menu/submenu');?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
            </div>
            
            <div class="form-group">
                <select name="menu_id" id="menu_id" class="form-control">
                    <option value="">Select menu</option>            
                    <?php foreach($menu as $m):?>
                    <option value="<?= $m['id']?>"><?= $m['name_menu']?></option>
                    <?php endforeach;?>
                </select>
            </div>
        
            <div class="form-group">
                <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
            </div>
        
            <div class="form-group">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                <label class="form-check-label" for="defaultCheck1">
                    Active ?
                </label>
                </div>
            </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Modal delete Menu -->
<?php 
    foreach ($subMenu as $sm) : 
?>
<div class="modal fade" id="deleteSubMenuModal<?= $sm['id'];?>" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete data <b><?= $sm['title'];?></b></p>
            </div>

            <div class="modal-footer">
                <form action="<?= base_url('menu/deleteSubMenu');?>" method="post">
                <input type="hidden" class="form-control" id="menu" name="id" value="<?= $sm['id']; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
