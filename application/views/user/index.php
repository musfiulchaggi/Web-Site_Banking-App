<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>


</div>
<!-- /.container-fluid -->
<div class="container">

    <div class="col-lg-8">

        <?php echo $this->session->flashdata('message'); ?>

    </div>


    <div class="card mb-3 col-lg-8">
        <div class="row no-gutters">
            <div class="col-md-4 mt-2">
                <img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['name'] ?></h5>
                    <p class="card-text"><?= $user['email'] ?></p>
                    <p class="card-text"><?= ucfirst($user['gender']) .', '.date('d-m-Y',$user['date_birth']) ?></p>

                    <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']) ?></small></p>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- End of Main Content -->