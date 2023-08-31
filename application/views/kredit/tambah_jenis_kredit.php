<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>
    <div class="row justify-content-end">
        <div class="col">
            <button  class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#mdlTambahNsb">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <span class="text">Tambahkan Jenis Kredit</span>
            </button>

        </div>
    </div>

    <div class="card boder-primary mt-4">

        <div class="card-body ">
            <table id="tblNasabah" class="table thead-dark table-striped table-bordered text-center" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Total Angsuran Bulanan</th>
                        <th>Jumlah Bunga (Persen)</th>
                        <th>Nama Kredit</th> 
                        <th>Denda</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($jenisKredit as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['total_angsuran_bulan'] ?> Bulan</td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['jumlah_bunga_persen'] ?>%</td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['nama_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['denda_kredit'] ?>%</td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                <div class="col">
                                    <button class="editJnsKredit btn btn-warning btn-sm " data-toggle="modal" data-target="#mdlEditJenisKredit" 
                                    data-id-jenis-kredit="<?= $br['id_jenis_kredit'] ?>" 
                                    data-denda_persen="<?= $br['denda_kredit'] ?>" 
                                    data-total-angsuran-bulan="<?= $br['total_angsuran_bulan'] ?>" data-jumlah-bunga-persen="<?= $br['jumlah_bunga_persen'] ?>" 
                                    data-nama-kredit="<?= $br['nama_kredit'] ?>">Edit</button>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

    <div class="row justify-content-center">


    </div>
</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->

<!-- modal Tambah Mesin -->
<div class="modal fade" id="mdlTambahNsb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-success text-light">
                <h3>Tambahkan Jenis Kredit</h3>
            </div>
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <?= form_open_multipart('kredit/tambahJenisKredit') ?>
            <div class="modal-body bg-gradient-info">
                <div class="form-group row">
                    <label for="total_angsuran_bulan" class="col-sm-4 col-form-label text-light ">Total Angsuran</label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="total_angsuran_bulan" name="total_angsuran_bulan" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                        <!-- menampilkan pesan eror -->
                        <?= form_error('total_angsuran_bulan', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah_bunga_persen" class="col-sm-4 col-form-label text-light ">Bunga (Persen)</label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="jumlah_bunga_persen" name="jumlah_bunga_persen" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                        <!-- menampilkan pesan eror -->
                        <?= form_error('jumlah_bunga_persen', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah_bunga_persen" class="col-sm-4 col-form-label text-light ">Denda (Persen)</label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="denda_persen" name="denda_persen" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                        <!-- menampilkan pesan eror -->
                        <?= form_error('jumlah_bunga_persen', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_kredit" class="col-sm-4 col-form-label text-light">Nama Kredit</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_kredit" name="nama_kredit">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('nama_kredit', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                    </div>
                </div>
                <!-- mangakali bootstrap row rata kanan justify-content-end-->
                <div class="form-group row justify-content-end">
                    <div class="col-sm-8 ">
                        <button type="submit" class="btn btn-success text-light"><b>Tambahkan</b></button>
                    </div>

                </div>

            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Edit Mesin-->
<div class="modal fade" id="mdlEditJenisKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-warning">
                <h5 class="modal-title text-light" id="">Edit Jenis Kredit</h5>
            </div>
            <?= form_open_multipart('kredit/editJenisKredit', ['id' => 'formeditjeniskredit']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_jenis_kredit" name="id_jenis_kredit" value="" hidden>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">

                        <label for="total_angsuran_bulan" style="color: black;"> <b>Total Angsuran</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="total_angsuran_bulan" name="total_angsuran_bulan" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">

                        <label for="jumlah_bunga_persen" style="color: black;"> <b>Bunga (Persen)</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="jumlah_bunga_persen" name="jumlah_bunga_persen" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="jumlah_bunga_persen" class="col-sm-4 col-form-label " style="color: black;"> <b>Denda (Persen)</b> </label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="denda_persen" name="denda_persen" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                        <!-- menampilkan pesan eror -->
                        <?= form_error('jumlah_bunga_persen', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="nama_kredit" style="color: black;"> <b>Nama Kredit</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="nama_kredit" name="nama_kredit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditjeniskredit')[0].reset();">Close</button>
                    <button type="submit" id="btntambah" class="btn btn-warning" onclick="">Edit</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>