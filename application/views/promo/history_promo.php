<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>
    
    <!-- cari promo kredit -->
    <div class="shadow col p-0 mb-5">
        <div class="card">
            <div class="card-header bg-primary">
                <span class="text-light">
                    History Promo Kredit
                    
                </span>
            </div>

            <div class="card-body">
                <div class="row">
    
                                            <div class="col-sm-7">
                                                <div class="row">
                                                    <div class="col-4">
                                                        
                                                        <label for="promokredit" class="col-form-label  text-left">Pilih Promo Kredit</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <select class="custom-select" id="histpromoselect" name="histpromoselect">
                                                            <option value="all" >All</option>
                                                            <?php foreach($kreditaktif as $ka) :?>
                                                            <option value="<?= $ka['id_penawaran']?>" >
                                                                <?= $ka['nama_kredit'].' ( '. date('d-F-Y',$ka['tgl_penawaran']).' - '.date('d-F-Y',$ka['tgl_berakhir']).' )'?>
                                                            </option>
                                                            <?php endforeach;?>
                                                        </select>
    
                                                    </div>
                                                    <!-- <input type="text" class="form-control" id="pabrikan" name="pabrikan"> -->

                                                </div>
                                            </div>
                                            
                                            <!-- <div class="col-sm-5 ">
                    
                                                <div class="row justify-content-end">
                                                    <div class="col-5 text-right">
                                                        <button type="button" class="btn btn-success btn-block" id="btn_cari" name="btn_cari">
                                                            <span>
                                                                <i class="fas fa-search"></i>
                                                            </span>
                                                        </button>

                                                    </div>

                                                </div>
                                            </div> -->
                                        </div>                
            </div>
        </div>

    </div>

    <!-- card daftar promo - chart -->
    <div class="col text-center p-0 mt-5" id="cardDaftarPembayaran">
        <div class="shadow card">
            <div class="card-header bg-primary"> 
                <div class="row">

                    <span class="text-light text-center align-bottom" id="titlepromo">History Promo Kredit <span class="text-medium text-warning">
                        ( <b>All</b> )
                    </span> </span>
    
                    <div class="col">
                        <div class="col text-right">
                            
                            <a href="<?= base_url('promo/exportpromo/all')?>" class=" btn btn-success btn-icon-split" id="btngenerateexcel">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-file-export" style="color: white;"></i>
                                        </span>
                                        <span class="text">Export History</span>
                            </a>
                               
                        </div>
                    </div>
                </div>
                
            </div>

            
        
        
        <div class="card-body">    
            <div class="row">
                
                
                    <div class="col-12 my-2">

                        <div class="row">

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Terkirim</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="terkirimtop"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-paper-plane fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Total Diklik</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="dikliktop"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="far fa-hand-point-up fa-2x text-gray-300"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Diajukan
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col text-center">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="diajukantop"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                 <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Total Direalisasikan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="terealisasitop"></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Diagram History Promo</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">

                                <div class="row">
                                    <div class="col-6">

                                    <!-- chart pie -->
                                        <div class="chart-pie pt-4 pb-2"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                            <canvas id="myPieChart" style="display: block;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        <div class="mt-4 text-center small">
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-primary"></i> Terkirim
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-success"></i> Diklik
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-info"></i> Diajukan
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-info"></i> Terealisasi
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <!-- chart bar -->
                                        <div class="chart-bar">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class="">

                                                    </div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class="">

                                                    </div>
                                                </div>
                                            </div>
                                        <canvas id="myBarChart" width="668" height="320" style="display: block; width: 668px; height: 320px;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                        
                                    </div>
                                </div>
                                    


                                </div>
                            </div>
                        
                    </div>

               

            </div>
        </div>
    </div>
</div>



    
    <div class="shadow card boder-primary mt-2">
        <div class="card-header bg-primary"> 
                <div class="row">

                    <span class="text-light text-center align-bottom">Daftar Nasabah Penerima Promo</span>
                </div>
                
        </div>

        <div class="card-body ">
            <table id="tblNasabah1" class="table table-responsive thead-dark table-striped table-bordered " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nasabah</th>
                        <th>Email Nasabah</th>
                        <td>Nama Kredit</td>
                        <th>Terkirim</th>
                        <th>Diklik</th>
                        <th>Diajukan</th>
                        <th>Terealisasi</th>
                        <th>Tgl Pengiriman</th>
                    </tr>
                </thead>
                <tbody >
                    
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
<div class="modal fade" id="mdlTambahPrm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-success" >
                <h3 style="color: white;">Tambahkan Promo Kredit</h3>
            </div>
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <?= form_open_multipart('promo/promokredit') ?>
            <div class="modal-body bg-gradient-info">
                <div class="form-group row">
                    <label for="namaKredit" class="col-sm-4 col-form-label text-light ">Nama Kredit</label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="namaKredit" name="namaKredit">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('namaKredit', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_angsuran_bulan" class="col-sm-4 col-form-label text-light ">Total Angsuran</label>
                    <div class="col-sm-8 ">
                        <input type="text" class="form-control " id="totalAngsuran" name="totalAngsuran">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('totalAngsuran', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>
                </div>
                <div class="form-group row">
                <div class="col-sm-4 col-form-label text-light"><b>Bunga Kredit</b></div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control " id="jumlahBunga" name="jumlahBunga">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('jumlahBunga', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>`
                </div>
                <div class="form-group row">
                <div class="col-sm-4 col-form-label text-light"><b>Url Gambar</b></div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control " id="urlgambar" name="urlgambar">
                        <!-- menampilkan pesan eror -->
                        <?= form_error('jumlahBunga', '<div><small class="text-danger pl-3">', '</small></div>') ?>
                    </div>`
                </div>
                <div class="form-group row">
                <label for="gambarPenawaran" class="col-sm-4 col-form-label text-light ">Gambar Promo</label>
                    <div class="col-sm-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gambarPenawaran" name="gambarPenawaran">
                                    <label class="custom-file-label" for="gambarPenawaran">Choose file</label>
                                </div>
                    </div>
                </div>
                <!-- mangakali bootstrap row rata kanan justify-content-end-->
                <div class="form-group row justify-content-end">
                    <div class="col-sm-8 ">
                        <button type="submit" class="btn btn-success text-light"><b>Kirimkan ke-Nasabah Lancar</b></button>
                    </div>

                </div>
                        
            </div>
            <!-- <?= form_close() ?> -->
        </div>
    </div>
</div>

<!-- Modal Edit Mesin-->
<div class="modal fade" id="mdlEditPromoKredit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-warning">
                <h5 class="modal-title text-light" id="">Edit Promo Kredit</h5>
            </div>
            <?= form_open_multipart('promo/editPromoKredit', ['id' => 'formeditpromokredit']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_penawaran" name="id_penawaran" value="" hidden>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">

                        <label for="gambar_penawaran" style="color: black;"> <b>Gambar Penawaran</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="gambar_penawaran" name="gambar_penawaran" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">

                        <label for="dikonfirmasi" style="color: black;"> <b>Dikonfirmasi</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="dikonfirmasi" name="dikonfirmasi" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="tgl_penawaran" style="color: black;"> <b>Tanggal Penawaran</b> </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control " id="tgl_penawaran" name="tgl_penawaran">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formeditpromokredit')[0].reset();">Close</button>
                    <button type="submit" id="btntambah" class="btn btn-warning" onclick="">Edit</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Kirim Penawaran -->
<div class="modal fade" id="mdlkirimPromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-warning">
                <h5 class="modal-title text-light" id="">Apakah anda yakin ingin mengirim promo kredit ini?</h5>
            </div>
            <?= form_open_multipart('promo/kirimPenawaran', ['id' => 'formpromokredit']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control " id="id_penawaran" name="id_penawaran" value="" hidden>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formpromokredit')[0].reset();">Batal</button>
                    <button type="submit" id="btntambah" class="btn btn-warning" onclick="">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>


