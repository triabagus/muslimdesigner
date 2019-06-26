<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">My Profile Member</h1>

<div class="row">
    <div class="col-lg-6">
        <?= $this->session->flashdata('message');?>
    </div>
</div>

<div class="card shadow mb-3" style="max-width: 540px;">
<!-- Card Header - Dropdown -->
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary"></h6>
    <div class="dropdown no-arrow">
      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-156px, 19px, 0px);">
        <div class="dropdown-header">Option</div>
        <a class="dropdown-item" href="member/edit">Edit Profile</a>
        <a class="dropdown-item" href="member/changepassword">Change Password</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">Something else here</a>
      </div>
    </div>
  </div>

  <div class="row no-gutters">
    <div class="col-md-4 p-3" >
      <img src="<?= base_url('assets/img/profile/' . $admin['image'])?>" class="card-img-top">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title"><?= $admin['name'];?></h5>
        <p class="card-text"><?= $admin['email'];?></p>
        <p class="card-text"><small class="text-muted">Member Since <?= date('d F Y', $admin['date_created']);?></small></p>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->