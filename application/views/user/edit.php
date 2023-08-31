<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <?= form_open_multipart('user/edit') ?>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10 ">
                    <input type="text" class="form-control text-center" id="email" name="email" value="<?= $user['email'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input type="radio" class="form-check-input-lg" id="gender" name="gender" value="male" <?php if($user){ if( ($user['gender']) == 'male'){echo ('checked');};} ?>>
                        <label class="form-check-label" for="gender">Male</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input-lg" id="gender2" name="gender" value="female" <?php if($user){ if( ($user['gender']) == 'female'){echo ('checked');};} ?>>
                        <label class="form-check-label" for="gender2">Female</label>
                    </div>
                    <!-- menampilkan pesan eror -->
                    <?= form_error('gender', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Date Birth</label>
                <div class="col-sm-10">
                    <input class="form-control" data-date="09/07/2023" value="<?php if($user){echo (date('Y-m-d',$user['date_birth'])); }?>" type="date" name="date_birth" id="date_birth" placeholder="-">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('date_birth', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">Picture</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" class="img-thumbnail">

                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- mangakali bootstrap row rata kanan justify-content-end-->
            <div class="form-group row justify-content-end">
                <div class="col-sm-10 ">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>

            </div>


        </div>
    </div>

</div>
<!-- /.container-fluid -->
<div class="container">

</div>

</div>
<!-- End of Main Content -->