<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary py-3">
            <h6 class="m-0 font-weight-bold text-light">Jaminan SHM / SHGB</h6>
        </div>
        <div class="card-body">
                <table class="table table-striped table-dark text-center">
                    <thead>
                        <tr>
                        <th scope="col">Nama Jaminan</th>
                        <th scope="col">Kode Jaminan</th>
                        <th scope="col">Taksasi / 1m<sup>2</sup></th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="nama_jaminan_shm"><?= $agunan_shm['nama_jaminan']?></td>
                            <td id="kode_jaminan_shm"><?= $agunan_shm['kode_jaminan']?></td>
                            <td id="taksasi_shm"><?= $agunan_shm['taksasi'] ?></td>

                            <td><button class="edtjmn btn btn-warning btn-block" data-toggle="modal" data-target="#mdleditjmn_shm" 
                                            data-id_jaminan ="<?= $agunan_shm['id_jaminan']?>" 
                                onclick="$('#mdleditjmn_shm #id_jaminan').attr('value', $(this).data('id_jaminan'))
                                $('#mdleditjmn_shm #kode_jaminan').attr('value', $('#kode_jaminan_shm').html())
                                $('#mdleditjmn_shm #nama_jaminan').attr('value', $('#nama_jaminan_shm').html())
                                $('#mdleditjmn_shm #taksasi').attr('value', $('#taksasi_shm').html())">Edit</button></td>
                        </tr>
                       
                    </tbody>
                </table>
        </div>
    </div>

    <div class="card shadow">
        <h5 class="card-header bg-primary text-light">Jaminan Kendaraan</h5>
        <div class="card-body">

            <div class="row justify-content-end">
                
                <div class="col">
                    <button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#mdltambahjmn">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                                <span class="text">Tambahkan Jaminan Kendaraan</span>
                    </button>

                </div>
            </div>

            <div class="card boder-primary mt-4">

                <div class="card-body ">
                    <table id="tblagunan" class="table thead-dark table-striped table-bordered " style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Agunan</th>
                                <th>Merk (Pabrikan)</th>
                                <th>Jenis Kendaraan</th>
                                <th>Harga Jual</th>
                                <th>Nama Agunan</th> 
                                <th>Tanggal Input</th>
                                <th>Taksasi</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($agunan_kendaraan as $br) : ?>
                                <tr>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['kode_jaminan'] ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= strtoupper($br['merk']) ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?php if( $br['roda'] == 2 ){ echo ('Sepeda Motor');}else{echo ('Mobil');} ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"><?= number_format($br['harga'] ,0,',','.')    ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['nama_jaminan'] ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= date('d-m-Y',$br['tgl_berlaku']) ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['taksasi'] ,0,',','.')  ?></td>
                                    <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                        <div class="col">
                                            <button class="edtjmn btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#mdleditjmn" 
                                            data-id_jaminan ="<?= $br['id_jaminan'] ?>"
                                            data-kode_jaminan="<?= $br['kode_jaminan'] ?>" data-merk="<?= $br['merk'] ?>" 
                                            data-tgl_berlaku="<?= date('Y-m-d',$br['tgl_berlaku']) ?>" 
                                            data-roda="<?= $br['roda'] ?>" 
                                            data-harga="<?= $br['harga'] ?>" 
                                            data-taksasi="<?= $br['taksasi'] ?>" 
                                            data-nama_jaminan="<?= $br['nama_jaminan'] ?>">Edit</button>

                                            <button class="deljmn btn btn-info btn-sm btn-block" data-toggle="modal" data-target="#mdlhapusjmn" 
                                            data-id_jaminan ="<?= $br['id_jaminan'] ?>">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div> 
        </div>
    </div>

    

    <div class="row justify-content-center">


    </div>
</div>
<!-- /.container-fluid -->



<!-- modal Tambah jaminan -->
<div class="modal fade" id="mdltambahjmn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-warning">
                <h3 class="text-light">Tambahkan Agunan (Jaminan)</h3>
            </div>
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <div class="modal-body">
                        <?= form_open_multipart(base_url('kredit/agunan'),['id','formtambahjmn'])?>                            

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="total_angsuran_bulan" style="color: black;">Kode Agunan</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="kode_jaminan" placeholder="Kode Agunan " name="kode_jaminan" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;">Merk (Pabrikan)</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="merk" placeholder="Pabrikan " name="merk" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
    
                                    <label for="total_angsuran_bulan" style="color: black;">Jenis Kendaraan</label>
                                </div>

                                
                                <div class="col-sm-8">

                                    <select class="custom-select" id="roda" name="roda">
                                        <option value="2">Sepeda Motor</option>
                                        <option value="4">Mobil</option>
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> Harga </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="harga" placeholder="Harga Jual " name="harga" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;">Nama Jaminan</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <textarea type="text" class="form-control" id="nama_jaminan" placeholder="Nama Jaminan" name="nama_jaminan" rows="2"></textarea>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> Taksasi </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="taksasi" placeholder="Harga Jual " name="taksasi" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>
                            
                            <button type="submit" href="login.html" class="btn btn-warning btn-user btn-block">
                                Tambahkan Agunan
                            </button>
                            <button type="button"  data-dismiss="modal" onclick="$('#formtambahjmn')[0].reset();" class="btn btn-danger btn-user btn-block">
                                Close
                            </button>

               

            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Edit jaminan kdr-->
<div class="modal fade" id="mdleditjmn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-primary">
                <h5 class="modal-title text-light" id="">Edit Data Agunan</h5>
            </div>
            <?= form_open_multipart('kredit/agunan', ['id' => 'formeditjmn']) ?>
            <div class="modal-body">

                <div class="form-group row" hidden> 

                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="id_jaminan" placeholder="Full Name " name="id_jaminan" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>

                </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="total_angsuran_bulan" style="color: black;">Kode Agunan</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="kode_jaminan" placeholder="Kode Agunan " name="kode_jaminan" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;">Merk (Pabrikan)</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="merk" placeholder="Pabrikan " name="merk" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
    
                                    <label for="total_angsuran_bulan" style="color: black;">Jenis Kendaraan</label>
                                </div>

                                
                                <div class="col-sm-8">

                                    <select class="custom-select" id="roda" name="roda">
                                        <option value="2">Sepeda Motor</option>
                                        <option value="4">Mobil</option>
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> Harga </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="harga" placeholder="Harga Jual " name="harga" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;">Nama Jaminan</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <textarea type="text" class="form-control" id="nama_jaminan" placeholder="Nama Jaminan" name="nama_jaminan" rows="2"></textarea>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> Taksasi </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="taksasi" placeholder="Harga Jual " name="taksasi" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                            </div>
                                
                                

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditjmn')[0].reset();">Close</button>
                    <button type="submit" id="btntambah" class="btn btn-info" onclick="">Edit</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit jaminan SHM-->
<div class="modal fade" id="mdleditjmn_shm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-primary">
                <h5 class="modal-title text-light" id="">Edit Data Agunan</h5>
            </div>
            <?= form_open_multipart('kredit/agunan', ['id' => 'formeditjmn_shm']) ?>
            <div class="modal-body">

                <div class="form-group row" hidden> 

                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="id_jaminan" placeholder="Full Name " name="id_jaminan" value="">
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>

                </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="total_angsuran_bulan" style="color: black;">Kode Agunan</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="kode_jaminan" placeholder="Kode Agunan " name="kode_jaminan" value="" readonly>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>

                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;">Nama Jaminan</label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="nama_jaminan" placeholder="Nama Jaminan" name="nama_jaminan" rows="2" readonly>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                                
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">

                                    <label for="total_angsuran_bulan" style="color: black;"> Taksasi </label>
                                </div>
                                <div class="col-sm-8">
                                    <!-- untuk mengisi lagi value yang ada dalam form menggunakan set_value() -->
                                    <input type="text" class="form-control" id="taksasi" placeholder="Harga Jual " name="taksasi" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                    <!-- menampilkan pesan eror -->
                                    <?= form_error('name', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                                    
                                </div>
                            </div>
                                
                                

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditjmn_shm')[0].reset();">Close</button>
                    <button type="submit" id="btntambah" class="btn btn-info" onclick="">Edit</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus jaminan-->
<div class="modal fade" id="mdlhapusjmn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-danger">
                <h5 class="modal-title text-light" id="">Delete Agunan</h5>
            </div>
            <?= form_open_multipart('kredit/deletejmn', ['id' => 'formhapusjmn']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_jaminan" name="id_jaminan" value="" hidden>
                    <h5 class="modal-title text-dark" id="">Apakah anda yakin ingin menghapus Agunan ini?</h5>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formhapusjmn')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-danger" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

