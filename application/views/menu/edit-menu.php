<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
    
    <div class="row">
        <div class="col-lg-6">

        <?= $this->session->flashdata('message');?>
        
            <?php echo form_open_multipart('menu/updatemenu');?>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="menu" name="id" value="<?= $menu['id']?>">
                    <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name" value="<?= $menu['name_menu']?>">
                    <?= form_error('menu', '<small class="text-danger pl-3">','</small>');?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="<?= base_url('menu')?>" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
