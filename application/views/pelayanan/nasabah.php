<!-- Begin Page Content -->
<div class="container-fluid">
    <?php
        if ($this->session->flashdata('message')) {
            echo '<div class="alert alert-primary" role="alert">' . $this->session->flashdata('message') . '</div>';
        }
    
    ?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center"><?= $title ?></h1>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- bikin form dulu file (action, method, enctype="multipart")-->
            <?= form_open_multipart('pelayanan') ?>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8 ">
                    <input type="text" class="form-control text-center" id="email" name="email" value="<?= $user['email'] ?>" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label for="no_hp" class="col-sm-4 col-form-label">Nomor HP</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php if($nasabah){ echo ($nasabah['no_hp']);}  ?>" placeholder="+62">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('no_hp', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Income Per-bulan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="income" name="income" value="<?php if($nasabah){ echo ($nasabah['income']);}  ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('income', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Pengeluaran Per-bulan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="pengeluaran" name="pengeluaran" value="<?php if($nasabah){ echo ($nasabah['pengeluaran']);}  ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('pengeluaran', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
           

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Pendidikan Terakhir</label>
                <div class="col-sm-8">
                    <select class="custom-select" id="pendidikan" name="pendidikan" value="<?php if($nasabah){ echo ($nasabah['pendidikan']);}  ?>">
                        <option>Pilih Pendidikan Terakhir</option>
                        <option value="SD" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'SD'){echo ('selected');};} ?>>SD</option>
                        <option value="SMP" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'SMP'){echo ('selected');};} ?>>SMP</option>
                        <option value="SMA/SMK" <?php if($nasabah){ if( ($nasabah['pendidikan']) == "SMA/SMK" ){echo ('selected');};} ?>>SMA/SMK</option>
                        <option value="D1" <?php if($nasabah){ if( ($nasabah['pendidikan']) == "D1" ){echo ('selected');};} ?>>D1</option>
                        <option value="D2" <?php if($nasabah){ if( ($nasabah['pendidikan']) == "D2" ){echo ('selected');};} ?>>D2</option>
                        <option value="D3" <?php if($nasabah){ if( ($nasabah['pendidikan']) == "D3" ){echo ('selected');};} ?>>D3</option>
                        <option value="S1" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'S1'){echo ('selected');};} ?>>S1</option>
                        <option value="S2" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'S2'){echo ('selected');};} ?>>S2</option>
                        <option value="S3" <?php if($nasabah){ if( ($nasabah['pendidikan']) == 'S3'){echo ('selected');};} ?>>S3</option>
                    </select>
                    <!-- menampilkan pesan eror -->
                    <?= form_error('pendidikan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Pekerjaan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?php if($nasabah){ echo ($nasabah['pekerjaan']);}  ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('pekerjaan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Ibu Kandung</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_ibu_kandung" name="nama_ibu_kandung" value="<?php if($nasabah){ echo ($nasabah['nama_ibu_kandung']);}  ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('nama_ibu_kandung', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">NIK</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?php if($nasabah){ echo ($nasabah['no_ktp']);}  ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('no_ktp', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

             <div class="form-group row">
                <div class="col-sm-4">Foto KTP</div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?php if($nasabah){ echo (base_url('assets/img/nasabah/') . $nasabah['foto_ktp']);}  ?>" class="img-thumbnail">

                        </div>
                        <div class="col-sm-9">
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
                    <input type="text" class="form-control" id="alamat_ktp" name="alamat_ktp" value="<?php if($nasabah){ echo ($nasabah['alamat_ktp']);}  ?>">
                    <!-- menampilkan pesan eror -->
                    <?= form_error('alamat_ktp', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4">Foto KK</div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src=" <?php if($nasabah){ echo (base_url('assets/img/nasabah/') . $nasabah['foto_kk']);}  ?> " class="img-thumbnail">

                        </div>
                        <div class="col-sm-9">
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
                            <input type="text" class="form-control" id="lattitude" name="lattitude" value="<?php if($nasabah){ echo ($nasabah['lattitude']);}  ?>" readonly>

                        </div>
                        
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col text-center">
                            
                            <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                        </div>
                        <div class="col text-center">

                            <input type="text" class="form-control" id="longitude" name="longitude" value="<?php if($nasabah){ echo ($nasabah['longitude']);}  ?>" readonly>
                        </div>
                        
                    </div>
                </div>

                <div class="col-sm-12"  >
                    <div class="container mt-3">
                        <div id="map" style='height: 350px;'>
    
                        </div>

                    </div>
                </div>

            </div>

           
            <div class="form-group row mt-3">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select class="custom-select" id="status" name="status" value="<?php if($nasabah){ echo ($nasabah['status']);}  ?>">
                        <option >Pilih Status</option>
                        <option value="Menikah" <?php if($nasabah){ if( ($nasabah['status']) == 'Menikah'){echo ('selected');};} ?>>Menikah</option>
                        <option value="Belum Menikah" <?php if($nasabah){ if( ($nasabah['status']) == 'Belum Menikah'){echo ('selected');};} ?>>Belum Menikah</option>
                    </select>
                    <!-- <input type="text" class="form-control" id="status" name="status" value="<?php if($nasabah){ echo ($nasabah['status']);}  ?>"> -->
                    <!-- menampilkan pesan eror -->
                    <?= form_error('status', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                </div>
            </div>
            

            
            <div id="data_pasangan">
                    <?php
                    if($nasabah){
                        if (strtolower($nasabah['status']) == 'menikah') {
                    ?>
                <div class="card">
                    <div class="card-header">
                        Data Suami/Istri
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_pasangan" name="nama_pasangan" value="<?php if($nasabah){ echo ($nasabah['nama_pasangan']);}  ?>">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('nama_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-sm-4 col-form-label">Tgl.lahir Suami/Istri</div>
                            <div class="col-md-8">
                                <input class="form-control" data-date="09/07/2023" value="<?php if($nasabah){echo (date('Y-m-d',$nasabah['date_birth_pasangan'])); }?>" type="date" name="date_birth_pasangan" id="date_birth_pasangan" placeholder="-">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Pekerjaan Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pekerjaan_pasangan" name="pekerjaan_pasangan" value="<?php if($nasabah){ echo ($nasabah['pekerjaan_pasangan']);}  ?>">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('pekerjaan_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">NIK Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_ktp_pasangan" name="no_ktp_pasangan" value="<?php if($nasabah){ echo ($nasabah['no_ktp_pasangan']);}  ?>">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('no_ktp_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Foto KTP Suami/Istri</div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="<?php if($nasabah){ echo (base_url('assets/img/nasabah/') . $nasabah['foto_ktp_pasangan']);}  ?> " class="img-thumbnail">

                                    </div>
                                    <div class="col-sm-9">
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
                                <input type="text" class="form-control" id="jumlah_anak" name="jumlah_anak" value="<?php if($nasabah){ echo ($nasabah['jumlah_anak']);}else{echo '0';}  ?>">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('jumlah_anak', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Foto Buku Nikah</div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="<?php if($nasabah){ echo (base_url('assets/img/nasabah/') . $nasabah['foto_buku_nikah'] );}  ?>" class="img-thumbnail">

                                    </div>
                                    <div class="col-sm-9">
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
                <?php }} ?>
            </div>
            <!-- <div class="form-group row">
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
            </div> -->


            <!-- mangakali bootstrap row rata kanan justify-content-end-->
            <div class="form-group row mt-3 justify-content-end">
                <div class="col-sm-3 text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </div>
            <?= form_close()?>

        </div>
    </div>

</div>
<!-- /.container-fluid -->
<div class="container">

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
    
<!-- End of Main Content -->