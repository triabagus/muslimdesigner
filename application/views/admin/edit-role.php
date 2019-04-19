<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
    

    <div class="row">
        <div class="col-lg-6">

        <?= $this->session->flashdata('message');?>
        
            <?php echo form_open_multipart('admin/updaterole');?>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="role" name="id" value="<?= $role['id_role']?>">
                    <input type="text" class="form-control" id="role" name="role" placeholder="Role name" value="<?= $role['name_role']?>">
                    <?= form_error('role', '<small class="text-danger pl-3">','</small>');?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="<?= base_url('admin/role')?>" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
