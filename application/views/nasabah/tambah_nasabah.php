<!-- Begin Page Content -->
<div class="container-fluid">

    <?php

    if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
    }

    ?>
 
 <div class="col">

     <div class="row justify-content-between">
         
         
             <button  class="btn btn-primary btn-icon-split"  data-toggle="modal" data-target="#mdlTambahNsb" onclick="$('#formTmbEdtNasabahAdmin')[0].reset();">
                     <span class="icon text-white-50">
                         <i class="fas fa-plus"></i>
                     </span>
                     <span class="text">Tambahkan Nasabah</span>
             </button>
                 
               
             <a class="text-light" href="<?= base_url('nasabah/export')?>">
                 <button  class="btn btn-success btn-icon-split"  >
                         <span class="icon text-white-50">
                             <i class="fas fa-file-export"></i>
                         </span>
                         <span class="text">Ekspor Sheet</span>
                 </button>
             </a>     
     </div>
 </div>

<div class="shadow-sm border-left-primary card boder-primary mt-4" style="max-height: 500px;">
    <div class="card-header bg-primary text-light">
            <div class="row">

                <div class="col-6">
                    <span class="align-middle">Daftar Nasabah Lancar - Last Updated at ( <span class="text-center text-warning" id="spanupdateat">
                        <?php 
                            foreach($nasabah as $ktgr){
                                $update = '';
                                if(!empty($ktgr['update_kategori_at']))
                                { 
                                    $update = date('d-F-Y',$ktgr['update_kategori_at']); 
                                }
                            }

                            echo $update;
                        ?></span> )</span>
                    
                </div>
                <div class="col-6 text-right">
                    <a href="" class=" btn btn-success btn-icon-split" id="btngeneratenasabahpromo">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-robot" style="color: white;"></i>
                                        </span>
                                        <span class="text">Generate Kategori</span>
                    </a>
                        
                </div>
            </div>
    </div>

   

    <div class="card boder-primary mt-4">

        <div class="card-body ">
            <table id="tblNasabah" class="table table-responsive thead-dark table-striped table-bordered " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Nasabah</th>
                        <th>ID User</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Income</th>
                        <th>Status</th>
                        <th>Pendidikan</th>
                        <th>Pengeluaran</th>
                        <th>Kemacetan Kredit</th>
                        <th>Confidence</th>
                        <th>Kategori Nasabah</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($nasabah as $br) : ?>
                        <tr>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $no ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_nasabah'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['id_user'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['name'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['email'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?=  number_format($br['income'],0,',','.');  ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['status'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['pendidikan'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= number_format($br['pengeluaran'],0,',','.'); ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['kemacetan_kredit'] ?></td>
                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> <?= $br['confidence'] ?></td>
                            <?php if($br['kategori_nasabah'] == 1) { ?> 
                                <td class="font-weight-normal text-light" style="background-color:#4dff4d">Lancar</td>    
                            <?php }elseif($br['kategori_nasabah'] == 0){ ?> 
                                <td class="font-weight-normal text-light" style="background-color:#fcf403">Tidak Lancar</td>    
                            <?php } else { ?> 
                                <td class="font-weight-normal bg-dark text-light"  style="font-size:smaller;">tdk memiliki transaksi</td>    

                            <?php }?>
                            <td class="font-weight-normal" style="color: black; font-size:smaller; text-align:center;">
                                <div class="col">
                                    <button class="editNsbAdmin btn btn-warning btn-sm " data-toggle="modal" data-target="#mdlTambahNsb" data-idnasabah="<?= $br['id_nasabah'] ?>"
                                    data-email="<?= $br['email'] ?>" data-id-user="<?= $br['id_user'] ?>" >Edit</button>
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
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->

<!-- modal Tambah dan Edit Nasabah -->
<div class="modal fade" id="mdlTambahNsb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center bg-success">
                <h3 style="color: white;">Tambahkan Nasabah</h3>
            </div>
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <?= form_open_multipart('nasabah/tambahNasabah', ['id'=>'formTmbEdtNasabahAdmin']) ?>
            <div class="modal-body">

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8 ">
                        <select class="custom-select" id="email" name="email" value="">
                            <option>Pilih Email User</option>
                            <?php
                                foreach ($all_user as $us){
                                    echo '<option value="'.$us['email'].'" class="text-dark font-weight-bolder">'.$us['email'].'</option>';
                                }
                            ?>
                        </select>
                        <!-- menampilkan pesan eror -->
                        <?= form_error('email', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <label for="no_hp" class="col-sm-4 col-form-label">Nomor HP</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="" placeholder="+62">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('no_hp', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Income Per-bulan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="income" name="income" value="">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('income', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Pengeluaran Per-bulan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="pengeluaran" name="pengeluaran" value="">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('pengeluaran', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
           

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Pendidikan Terakhir</label>
                <div class="col-sm-8">
                    <select class="custom-select" id="pendidikan" name="pendidikan" value="">
                        <option>Pilih Pendidikan Terakhir</option>
                        <option value="SD" >SD</option>
                        <option value="SMP" >SMP</option>
                        <option value="SMA/SMK" >SMA/SMK</option>
                        <option value="D1" >D1</option>
                        <option value="D2" >D2</option>
                        <option value="D3" >D3</option>
                        <option value="S1" >S1</option>
                        <option value="S2" >S2</option>
                        <option value="S3" >S3</option>
                    </select>
                    <!-- menampilkan pesan eror -->
                    <?= form_error('pendidikan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Pekerjaan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('pekerjaan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Ibu Kandung</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_ibu_kandung" name="nama_ibu_kandung" value="">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('nama_ibu_kandung', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">NIK</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('no_ktp', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

             <div class="form-group row">
                <div class="col-sm-4">Foto KTP</div>
                <div class="col-sm-8">
                    <div class="row">
                        
                        <div class="col-sm">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_ktp" name="foto_ktp">
                                <label class="custom-file-label" for="foto_ktp">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

             <div class="form-group row">
                <label for="alamat_ktp" class="col-sm-4 col-form-label">Alamat (KTP)</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="alamat_ktp" name="alamat_ktp" value="">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('alamat_ktp', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4">Foto KK</div>
                <div class="col-sm-8">
                    <div class="row">
                     
                        <div class="col-sm">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk">
                                <label class="custom-file-label" for="foto_kk">Choose file</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

           

            <div class="shadow form-group row py-3">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Lokasi Tempat Tinggal</label>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col text-center">
                            <label for="lattitude" class="col-sm-4 col-form-label">Lattitude</label>
                            
                        </div>
                        <div class="col text-center">
                            <input type="text" class="form-control" id="lattitude" name="lattitude" value="" readonly>

                        </div>
                        
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col text-center">
                            
                            <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                        </div>
                        <div class="col text-center">

                            <input type="text" class="form-control" id="longitude" name="longitude" value="" readonly>
                        </div>
                        
                    </div>
                </div>

                <div class="col-sm-12" >
                    <div class="row justify-content-end">
                        <div class="col-sm-8 text-center">
                            <div class="container mt-3">
                                <div id="map" style='height: 350px;'>
            
                                </div>
        
                            </div>
    
                        </div>

                    </div>
                </div>

            </div>

           
            <div class="form-group row mt-3">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select class="custom-select" id="statusAdm" name="status" value="">
                        <option >Pilih Status</option>
                        <option value="Menikah" >Menikah</option>
                        <option value="Belum Menikah" >Belum Menikah</option>
                    </select>
                    <!-- <input type="text" class="form-control" id="status" name="status" value=""> -->
                    <!-- menampilkan pesan eror -->
                    <?= form_error('status', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            

            
            <div id="data_pasangan" hidden>
                   
                <div class="card">
                    <div class="card-header">
                        Data Suami/Istri
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_pasangan" name="nama_pasangan" value="">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('nama_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-sm-4 col-form-label">Tgl.lahir Suami/Istri</div>
                            <div class="col-md-8">
                                <input class="form-control" data-date="09/07/2023" value="" type="date" name="date_birth_pasangan" id="date_birth_pasangan" placeholder="-">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Pekerjaan Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pekerjaan_pasangan" name="pekerjaan_pasangan" value="">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('pekerjaan_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">NIK Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_ktp_pasangan" name="no_ktp_pasangan" value="">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('no_ktp_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Foto KTP Suami/Istri</div>
                            <div class="col-sm-8">
                                <div class="row">
                                   
                                    <div class="col-sm">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_ktp_pasangan" name="foto_ktp_pasangan">
                                            <label class="custom-file-label" for="foto_ktp_pasangan">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Jumlah Anak</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="jumlah_anak" name="jumlah_anak" value="">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('jumlah_anak', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Foto Buku Nikah</div>
                            <div class="col-sm-8">
                                <div class="row">
                             
                                    <div class="col-sm">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_buku_nikah" name="foto_buku_nikah">
                                            <label class="custom-file-label" for="foto_buku_nikah">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    
                        
                    </div>
                </div>
                
            </div>
            <!-- <div class="form-group row">
                <div class="col-sm-2">Picture</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="" class="img-thumbnail">

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


            <!-- mangakali bootstrap row rata kanan justify-content-end-->
            <div class="form-group row mt-3 justify-content-end">
                <div class="col-sm-3 text-right">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" onclick="$('#formTmbEdtNasabahAdmin')[0].reset();">Close</button>
                </div>
                <div class="col-sm-3 text-right">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>

            </div>
            <?= form_close() ?>
        </div>
        </div>
    </div>
</div>


<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoibXVzZml1bGNoYWdnaTAxIiwiYSI6ImNsanBib2FqMTFzanczcW51NDlveWpzOGQifQ.Gx0PV-RqP2h3xzc_weEiMw';
    
    var long = parseFloat('<?php if(isset($nasabah['longitude'])){ echo ($nasabah['longitude']);}else{ echo '112.6326'; }  ?>')
    var lat = parseFloat('<?php if(isset($nasabah['lattitude'])){ echo ($nasabah['lattitude']);}else{ echo '-7.9666'; }  ?>')

    // make marker
    var marker = new mapboxgl.Marker({
            color: '#4668F2',
            // draggable: true
        })

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11', 
        center: [long, lat], // starting position [lng, lat]
        zoom: 14, // starting zoom,

    })
    
    marker.setLngLat([long, lat]).addTo(map);
    

    // inisialisasi geocoder
    var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            
            // Limit seach results to Australia.
            countries: 'id',
            marker: false,
            bbox: [112.4338, -8.6500, 114.8650, -6.7500],//jawatimur
            
            mapboxgl: mapboxgl
    })

    // map add geocoder
    map.addControl(
         geocoder
        );
    
    geocoder.on('result', function(event) {
        // Remove the existing marker, if any
        if (marker) {
            marker.remove();
        }

        console.log(event.result)   

        marker.setLngLat(event.result.geometry.coordinates) // mendapatkan data dari latttidude dan longitude dari search
            .addTo(map);

        $('#longitude').attr('value',event.result.geometry.coordinates[0])
        $('#lattitude').attr('value',event.result.geometry.coordinates[1])
    });

    // Function remove marker
    function removeMarker() {
        if (marker) {
            marker.remove();
        }
    }

    map.on('click', (e) => {
        console.log(e);
        removeMarker();      
        marker.setLngLat([e.lngLat.lng, e.lngLat.lat]).addTo(map);
        $('#longitude').attr('value',e.lngLat.lng)
        $('#lattitude').attr('value',e.lngLat.lat)
    });

     // map get location lat lang need access
    // inisialisasi GeolocateControl
    var geolocate = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true,
                watchPosition: true
            },
                trackUserLocation: true,
                showUserHeading: true
    })

    // map add geocoder
    map.addControl(
         geolocate
    );

    geolocate.on('geolocate', function (position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // console.log('lat, lng', latitude, longitude);
        $('#longitude').attr('value',longitude)
        $('#lattitude').attr('value',latitude)

        marker.setLngLat([longitude, latitude]).addTo(map);
    });

</script>

