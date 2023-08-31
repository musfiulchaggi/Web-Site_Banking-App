<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <?= form_open_multipart('pelayanan/daftarNasabah') ?>
            <div class="form-group row" hidden>
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10 ">
                    <input type="text" class="form-control text-center" id="id_user" name="id_user" value="<?= $user['id_user'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10 ">
                    <input type="text" class="form-control text-center" id="email" name="email" value="<?= $user['email'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" readonly>
                    <!-- menampilkan pesan eror -->
                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            <!-- <div class="form-group row">
                <div class="col-sm-2">Picture</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<= base_url('assets/img/profile/') . $user['image'] ?>" class="img-thumbnail">

                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Pendapatan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="income" name="income" value="<?= $nasabah['income'] ?>">
                    <?= form_error('income', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                    <select class="form-control" name="status" id="status" required>
                        <option value="0"<?php if ($nasabah['status'] == '0') echo ' selected="selected"'; ?>>Belum Menikah</option>
                        <option value="1"<?php if ($nasabah['status'] == '1') echo ' selected="selected"'; ?>>Menikah</option>
                        <option value="2"<?php if ($nasabah['status'] == '2') echo ' selected="selected"'; ?>>Lainnya</option>
                    </select>
                <?= form_error('status', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Pendidikan</label>
                <div class="col-sm-10">
                    <select class="form-control" name="pendidikan" id="pendidikan" required>
                        <option value="0"<?php if ($nasabah['pendidikan'] == '0') echo ' selected="selected"'; ?>>SD</option>
                        <option value="1"<?php if ($nasabah['pendidikan'] == '1') echo ' selected="selected"'; ?>>SMP</option>
                        <option value="2"<?php if ($nasabah['pendidikan'] == '2') echo ' selected="selected"'; ?>>SMA</option>
                        <option value="3"<?php if ($nasabah['pendidikan'] == '3') echo ' selected="selected"'; ?>>D1</option>
                        <option value="4"<?php if ($nasabah['pendidikan'] == '4') echo ' selected="selected"'; ?>>D2</option>
                        <option value="5"<?php if ($nasabah['pendidikan'] == '5') echo ' selected="selected"'; ?>>D3</option>
                        <option value="6"<?php if ($nasabah['pendidikan'] == '6') echo ' selected="selected"'; ?>>S1/D4</option>
                        <option value="7"<?php if ($nasabah['pendidikan'] == '7') echo ' selected="selected"'; ?>>S2</option>
                        <option value="8"<?php if ($nasabah['pendidikan'] == '8') echo ' selected="selected"'; ?>>S3</option>
                        <option value="9"<?php if ($nasabah['pendidikan'] == '9') echo ' selected="selected"'; ?>>Lainnya</option>
                    </select>
                    <?= form_error('pendidikan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Pengeluaran</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="pengeluaran" name="pengeluaran" value="<?= $nasabah['pengeluaran'] ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('pengeluaran', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <!-- mangakali bootstrap row rata kanan justify-content-end-->
            <div class="form-group row justify-content-end">
                <div class="col-sm-10 ">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
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