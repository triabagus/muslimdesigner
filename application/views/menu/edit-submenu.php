<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title;?></h1>
    
    <div class="row">
        <div class="col-lg-6">

        <?= $this->session->flashdata('message');?>
        
            <?php echo form_open_multipart('menu/updatesubmenu');?>
                <div class="form-group">
                    <label for="formTitle">Title</label>
                    <input type="hidden" class="form-control" id="menu" name="id" value="<?= $submenu['id']?>">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title" value="<?= $submenu['title']?>">
                    <?= form_error('title', '<small class="text-danger pl-3">','</small>');?>
                </div>

                <div class="form-group">
                <label for="formHakMenu">Pilih Hak Akses Menu</label>
                    <select name="menu_id" id="menu_id" class="form-control">   
                        <?php foreach ($editsubmenu as $esm):?>
                        
                            <?php foreach($menu as $m):?>
                                
                            <option value="<?= $m['id']?>" <?php if($esm['menu_id'] == $m['id']): echo"selected"; endif;?> ><?= $m['name_menu']?></option>
                            
                            <?php endforeach;?>

                        <?php endforeach;?>

                    </select>
                </div>  

                <div class="form-group">
                <label for="formUrl">URL</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url" value="<?= $submenu['url']; ?>">
                    <?= form_error('url', '<small class="text-danger pl-3">','</small>');?>
                </div>

                <div class="form-group">
                <label for="formIcon">Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon" value="<?= $submenu['icon'];?>">
                    <?= form_error('icon', '<small class="text-danger pl-3">','</small>');?>
                    <small class="text-primary pl-3">* Tambahkan fa-fw untuk meratakan menu :)</small>
                </div>

                <div class="form-group">
                    <div class="form-check">
                    
                    <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" <?php if($submenu['is_active'] == 1): echo"checked"; endif;?>>

                    <label class="form-check-label" for="defaultCheck1">
                        Active ?
                    </label>
                    </div>
                </div> 

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <a href="<?= base_url('menu/submenu')?>" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
