<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>
    <div class="row justify-content-end">
        <div class="col">
            <button  class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#mdltambahao">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <span class="text">Tambahkan AO</span>
            </button>

        </div>
    </div>
    <div class="card boder-primary mt-4">

        <div class="card-body ">
            <table id="tblNasabah" class="table thead-dark table-striped table-bordered " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id AO</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Photo</th>
                        <th>Gender</th> 
                        <th>Tanggal Lahir</th>
                        <th>Jabatan</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($ao as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_user'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['name'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['email'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['ao_phone'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <img src="<?= base_url('assets/img/profile/') . $br['image'] ?>" class="img-thumbnail"></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['gender'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('d-m-Y',$br['date_birth']) ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= "Account Officer (AO)" ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                <div class="col">
                                    <button class="edtao btn btn-warning btn-sm btn-block" data-toggle="modal" data-target="#mdleditao" 
                                    data-id_user="<?= $br['id_user'] ?>"
                                    data-name="<?= $br['name'] ?>" data-email="<?= $br['email'] ?>" 
                                    data-date_birth="<?= date('Y-m-d',$br['date_birth']) ?>" 
                                    data-ao_phone="<?= $br['ao_phone'] ?>" 
                                    data-image="<?= $br['image'] ?>" 
                                    data-gender="<?= $br['gender'] ?>">Edit</button>

                                    <button class="delao btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#mdlhapusao" 
                                    data-id_user="<?= $br['id_user'] ?>">Hapus</button>
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



<!-- modal Tambah Mesin -->
<div class="modal fade" id="mdltambahao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-secondary">
                <h3 class="text-light">Tambahkan Account Officer (AO)</h3>
            </div>
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <div class="modal-body">
                        <?= form_open_multipart(base_url('kredit/ao'),['id','formtambahao'])?>                            

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="total_angsuran_bulan" style="color: black;">Nama AO </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="name" placeholder="Full Name " name="name" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> Email </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="email" placeholder="Email " name="email" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> No. Telepon </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="ao_phone" placeholder="Ao Phone " name="ao_phone" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-4">
    
                                    <label for="total_angsuran_bulan" style="color: black;"> Tanggal Lahir</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input class="form-control" data-date="09/07/2023" value="" type="date" id="date_birth" name="date_birth" placeholder="Date Birth">
                                        <!-- menampilkan pesan eror -->
                                        <?= form_error('date_birth', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-4">
    
                                    <label for="total_angsuran_bulan" style="color: black;"> Gender</label>
                                </div>

                                
                                <div class="col-sm-8">

                                    <select class="custom-select" id="gender" name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    
                                </div>
                            </div>
                            

                           <div class="form-group row">
                                <div class="col-sm-4" style="color: black;">Picture</div>
                                <div class="col-sm-8">

                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>

                                </div>
                            </div>

                            
                            
               

            </div>
            <div class="modal-footer row">
                                <div class="col">

                                    <button type="button"  data-dismiss="modal" onclick="$('#formtambahao')[0].reset();" class="btn btn-dark btn-user btn-block">
                                        Close
                                    </button>
                                </div>
                                <div class="col">
                                    
                                    <button type="submit" href="login.html" class="btn btn-success btn-user btn-block">
                                        Register AO
                                    </button>
                                </div>

            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Edit Mesin-->
<div class="modal fade" id="mdleditao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-warning">
                <h5 class="modal-title text-light" id="">Edit Data Account Officer</h5>
            </div>
            <?= form_open_multipart('kredit/ao', ['id' => 'formeditao']) ?>
            <div class="modal-body">

                <div class="form-group row" hidden> 

                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="id_user" placeholder="Full Name " name="id_user" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>

                </div>


                            <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label for="total_angsuran_bulan" style="color: black;">Nama AO </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                                <input type="text" class="form-control" id="name" placeholder="Full Name " name="name" value="">
                                                <!-- menampilkan pesan eror -->
                                                <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                                
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> Email </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="email" placeholder="Email " name="email" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('email', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> No. Telepon </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="ao_phone" placeholder="Ao Phone " name="ao_phone" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>
                            
                            
                            <div class="form-group row">
                                <div class="col-sm-4">
    
                                    <label for="total_angsuran_bulan" style="color: black;"> Tanggal Lahir</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input class="form-control" data-date="09/07/2023" value="" type="date" id="date_birth" name="date_birth" placeholder="Date Birth">
                                        <!-- menampilkan pesan eror -->
                                        <?= form_error('date_birth', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-4">
    
                                    <label for="total_angsuran_bulan" style="color: black;"> Gender</label>
                                </div>

                                
                                <div class="col-sm-8">

                                    <select class="custom-select" id="gender" name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    
                                </div>
                            </div>
                            
                
                            <div class="form-group row">
                                            <div class="col-sm-4" style="color: black;">Picture</div>
                                            <div class="col-sm-8">
                                                <div class="row">

                                                    <div class="col-sm-3">
                                                        <img src="<?= base_url('assets/img/profile/default.jpg')  ?>" class="img-thumbnail" id="fotoao">
                            
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditao')[0].reset();">Close</button>
                    <button type="submit" id="btntambah" class="btn btn-warning" onclick="">Edit</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlhapusao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-danger">
                <h5 class="modal-title text-light" id="">Delete Account Officer</h5>
            </div>
            <?= form_open_multipart('kredit/deleteao', ['id' => 'formhapusao']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_user" name="id_user" value="" hidden>
                    <h5 class="modal-title text-dark" id="">Apakah anda yakin ingin menghapus Account ini?</h5>
                </div>
                <!-- <div class="form-group">
                        <input type="hidden" name="kode" >
                        <select class="form-control" name="status" required>
                        <option value="" selected disabled="">-Pilih Status-</option>
                        <option value="1" >Online</option>
                        <option value="2" >Offline</option>
                        </select>
				</div> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formhapusao')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-danger" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

                    </div>