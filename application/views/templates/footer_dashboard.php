<!-- Modal cetak pembayaran-->
<div class="modal fade" id="mdllihatterminadm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg w-70">
        <div class="modal-content">
            <div class="modal-header  bg-primary ">
                <h5 class="modal-title text-light mx-auto" id=""><b>Riwayat Pembayaran</b> </h5>
            </div>

            <div class="modal-body">
                <div>
                    <table class="table table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Id Penjualan</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nama Perusahaan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Bukti</th>
                                <th scope="col">Lihat Invoice</th>
                            </tr>
                        </thead>
                        <tbody id="daftartermin">


                        </tbody>
                    </table>

                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Web Musfiul Chaggi <?= date('Y') ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?php echo base_url() ?>assets/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->

<!-- mapbox -->


<!-- chart -->
<script>
// getdata hist AJAX
$(document).ready(function () {
        //nasabah
    var tablenasabah = $('#tblNasabah1').DataTable({
        responsive: true,
        pageLength: 5,
        lengthMenu: [
            [3, 5, 10, 20, -1],
            [3, 5, 10, 20, 'Todos']
        ]
    })

    function getdataajax(id_penawaran){

        // ajax get data histori
        $.ajax({
            type: "POST",
            url: "<?= base_url('promo/getdatapromokredit')?>",
            data: {
                'id_penawaran':id_penawaran
            },
            dataType: "JSON",
            success: function (response) {
    
                console.log(response)
    
                $('#terkirimtop').html(response.totalhist.terkirim)
                $('#dikliktop').html(response.totalhist.diklik)
                $('#diajukantop').html(response.totalhist.diajukan)
                $('#terealisasitop').html(response.totalhist.terealisasi)


                
                setbarchart(response)
                setpiechart(response)
                let html = '' 
    
                // menghapus isi dataTable
                tablenasabah.clear().draw();
    
                // membuat array data table
                
                
                let no = 1;
                $.each(response.nasabah, function(i,item){
                    var myArray = [];
                    // set data nasabah (table)
                    
                    myArray.push(no);
                    myArray.push(item.name);
                    myArray.push(item.email);
                    myArray.push(item.nama_kredit);
                    
                    
                    if(item.terkirim == 1){
                        myArray.push(
                        `
                            
                                <button class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-check"></i>
                                </button>
                            
                            
                        `)
                            
                    }else{
                        myArray.push(
                        `
                            
                                <button class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            
                            
                        `)
                            
                    }
    
                    if(item.diklik == 1){
                        myArray.push(
                        `
                            
                                <button class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-check"></i>
                                </button>
                            
                            
                        `)
                            
                    }else{
                        myArray.push(
                        `
                            
                                <button class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            
                            
                        `)
                            
                    }
    
                    if(item.diajukan == 1){
                        myArray.push(
                        `
                            
                                <button class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-check"></i>
                                </button>
                            
                            
                        `)
                            
                    }else{
                        myArray.push(
                        `
                            
                                <button class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            
                            
                        `)
                            
                    }
    
                    if(item.terealisasi == 1){
                        myArray.push(
                        `
                            
                                <button class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-check"></i>
                                </button>
                            
                            
                                `)
                            
                    }else{
                        myArray.push(
                        `
                            
                                <button class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            
                                `)
                            
                    }
    
                    myArray.push(change_time(item.tgl_pengiriman)) 
    
                    // menambahkan data kedalam table
                    tablenasabah.row.add(myArray).draw();
                    
                    no+=1;
                        
                  
                })
            }
        });
    }

    function getdataajaxKreditActive(){

        // ajax get data histori
        $.ajax({
            type: "POST",
            url: "<?= base_url('kredit/getDataChartKreditActive')?>",
            data: {
            },
            dataType: "JSON",
            success: function (response) {
    
                // console.log(response)

                setbarchartKreditActive(response)
                // setpiechart(response)

            }
        });
    }


    // get uri from admin chart kredit active
    var currentPath = window.location.pathname;


    if ($.fn.DataTable.isDataTable('#tblNasabah1')) {
            getdataajax('all')
    }else if(currentPath == '/aplikasi_kasir/kredit/listKreditActive'){
        getdataajaxKreditActive()
    }

    // set data pencarian
    $('#histpromoselect').on('change', function(){
        var selectedOption = $(this).find('option:selected');
        var selectedValue = selectedOption.val();
        var selectedText = selectedOption.text();

        var title = 'History Promo Kredit'
        $('#titlepromo').html(title+ ` 
        <span class="text-medium text-warning">( <b>`+selectedText+`</b> )</span>
        `)

        var url = '<?= base_url('promo/exportpromo/')?>'
        $('#btngenerateexcel').attr('href',url+selectedValue+'/')

        getdataajax(selectedValue);     
    })
    
});



// function change format time() php
// Membuat objek Date berdasarkan timestamp di JavaScript
function change_time(time){
    var date = new Date(time * 1000); // Konversi timestamp ke milidetik (karena JavaScript menggunakan timestamp dalam milidetik)

    // Mengubah format tanggal menggunakan metode-metode Date pada JavaScript
    return formattedDate = `${date.getDate()}-${date.getMonth()+1}-${date.getFullYear()}`;
}
function change_date(time){
    var date = new Date(time * 1000); // Konversi timestamp ke milidetik (karena JavaScript menggunakan timestamp dalam milidetik)

    // Mengubah format tanggal menggunakan metode-metode Date pada JavaScript
    var month = date.getMonth()+1
    var twoDigitMonth = month < 10 ? "0" + month : month;
    return formattedDate = `${date.getFullYear()}-${twoDigitMonth}-${date.getDate()}`;
}


// <!-- chart bar -->
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }

        return s.join(dec);
    }


    function setbarchart(response){
        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Terkirim", "Diklik", "Diajukan",  "Terealisasi"],
                datasets: [{
                    label: "Total action : ",
                    backgroundColor: ['red', 'blue', 'green', 'yellow'], // Warna latar belakang bar
                    borderColor: ['black', 'black', 'black', 'black'], // Warna border bar
                    hoverBackgroundColor: ['red', 'blue', 'green', 'yellow'],
                    data: [response.totalhist.terkirim, response.totalhist.diklik, response.totalhist.diajukan, response.totalhist.terealisasi],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
                },
                scales: {
                    xAxes: [{
                        time: {
                        unit: 'Action'
                        },
                        gridLines: {
                        display: false,
                        drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                            },
                        maxBarThickness: 50,
                    }],
                    yAxes: [{
                        ticks: {
                        min: 0,
                        max: Math.ceil(response.totalhist.terkirim / 10) * 10,
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return  number_format(value);
                        }
                        },
                        gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel +  number_format(tooltipItem.yLabel);
                        }
                    }
                },
            }
        });


        
    }

    function setbarchartKreditActive(response){
        var ctx = document.getElementById("myBarChart2");
        var labels = [
            "January", "February", "March",
            "April", "May", "June",
            "July", "August", "September",
            "October", "November", "December"
        ];

        var datasemua = [];
        var dataregular = [];
        var datapromo = [];
        var dataNew = [];

        $.each(response, function(i, item){
                datasemua.push(item['semua'])
                dataregular.push(item['regular'])
                datapromo.push(item['promo'])
        })

        dataNew.push(datasemua)
        dataNew.push(dataregular)
        dataNew.push(datapromo)


        var datasets = [];
        var maxNum = 0;
        var angka = 0;

        var dataName = ['Semua Kredit', 'Kredit Regular', 'Kredit Promo']
        var backgroundColor = ['rgb(250,128,114)', 'rgb(0,0,139)', 'rgb(50,205,50)']
        var stack = ['Stack 0', 'Stack 1', 'Stack 2']

        $.each(dataName, function(i, item){

            datasets.push({
                    label: dataName[i],
                    backgroundColor: backgroundColor[i], // Warna latar belakang
                    data: dataNew[i],
                    stack: stack[i],
                })

            angka = Math.max.apply(Math, dataNew[i])

            if(maxNum < angka){

                maxNum = angka
            }
                
        })


        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets,              
                maxBarThickness: 500,
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 5,
                        right: 5,
                        top: 10,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                        unit: 'Action'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: true
                        },
                        ticks: {
                            maxTicksLimit: 12
                            },
                        maxBarThickness: 200,
                    }],
                    yAxes: [{
                        ticks: {
                        min: 0,
                        max: Math.ceil(maxNum / 1000000) * 1000000,
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return  number_format(value);
                        }
                        },
                        gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                        
                        }
                    }],
                },
                legend: {
                    display: true
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: true,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Rp. ' +  number_format(tooltipItem.yLabel);
                        }
                    }
                },
                
            }
        });
    }
    


    // <!-- chart pie -->

    function setpiechart(response){
        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Terkirim", "Diklik", "Diajukan",  "Terealisasi"],
            datasets: [{
            data: [response.totalhist.terkirim, response.totalhist.diklik, response.totalhist.diajukan, response.totalhist.terealisasi],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','green'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', 'green'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
            display: false
            },
            cutoutPercentage: 80,
        },
        });

    }


</script>

<!-- Tambah dan Edit data Nasabah Admin -->
<script>

    $('.editNsbAdmin').on('click', function(){
        $('#formTmbEdtNasabahAdmin')[0].reset();
        
        var email = $(this).data('email');
        var idnasabah = $(this).data('idnasabah');
        
        $('#formTmbEdtNasabahAdmin #email').append(`<option class="text-dark font-weight-bolder" value="`+email+`">
                                      `+email+`
                                  </option>`);
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('nasabah/getDataNasabah')?>",
            data: {
                'email':email,
                'idnasabah':idnasabah
            },
            dataType: "JSON",
            success: function (response) {
                
                $('#mdlTambahNsb #email').val(response.email).change();
                // $('#mdlTambahNsb #email').attr('disabled', true);

                $('#mdlTambahNsb #no_hp').attr('value', response.no_hp);
                $('#mdlTambahNsb #income').attr('value', response.income);
                $('#mdlTambahNsb #pengeluaran').attr('value', response.pengeluaran);
                $('#mdlTambahNsb #pendidikan').val(response.pendidikan).change();

                $('#mdlTambahNsb #pekerjaan').attr('value', response.pekerjaan);
                $('#mdlTambahNsb #nama_ibu_kandung').attr('value', response.nama_ibu_kandung);
                $('#mdlTambahNsb #no_ktp').attr('value', response.no_ktp);

                $('#mdlTambahNsb #foto_ktp').next('.custom-file-label').addClass("selected").html(response.foto_ktp);
                
                $('#mdlTambahNsb #alamat_ktp').attr('value', response.alamat_ktp);

                $('#mdlTambahNsb #foto_kk').next('.custom-file-label').addClass("selected").html(response.foto_kk);

                $('#mdlTambahNsb #lattitude').attr('value', response.lattitude);
                $('#mdlTambahNsb #longitude').attr('value', response.longitude);

                var long = parseFloat(response.longitude)
                var lat = parseFloat(response.lattitude)
                
                marker.setLngLat([long, lat]).addTo(map);


                $('#mdlTambahNsb #statusAdm').val( response.status).change();

                if(response.status == 'Menikah'){
                    $('#data_pasangan').attr('hidden', false)
                }else{
                    $('#data_pasangan').attr('hidden', true)
                }

                $('#mdlTambahNsb #nama_pasangan').attr('value', response.nama_pasangan);

                let date_lahr_pas = change_date(response.date_birth_pasangan);
                $('#mdlTambahNsb #date_birth_pasangan').attr('value', date_lahr_pas).change();
                $('#mdlTambahNsb #pekerjaan_pasangan').attr('value', response.pekerjaan_pasangan);
                $('#mdlTambahNsb #no_ktp_pasangan').attr('value', response.no_ktp_pasangan);

                $('#mdlTambahNsb #foto_ktp_pasangan').next('.custom-file-label').addClass("selected").html(response.foto_ktp_pasangan);
                $('#mdlTambahNsb #jumlah_anak').attr('value', response.jumlah_anak);

                $('#mdlTambahNsb #foto_buku_nikah').next('.custom-file-label').addClass("selected").html(response.foto_buku_nikah);

            }
        });

      
    })
</script>


<!-- ckeditor -->

<script>
    // 
    // tambah promo
    //

    // <!-- ckeditor diinisialisasi didalam view promo/buatpromo.php
    var element = document.querySelector('[name="text_penawaran"]');
    var element2 = document.querySelector('[name="text_penawaran_edit"]');

    var editor 
    var editor2 

    if (element) {
        editor = CKEDITOR.replace( 'text_penawaran' );
    } 

    if (element2) {
        editor2 = CKEDITOR.replace( 'text_penawaran_edit' );
    } 

    

    $('#btnbuatpromo').on('click', function(){
        // langsung kirim data melalui form
        console.log()
    })



    
    // get priview  tambah promo
    function getpriviewtambahpromo(){
        var linkurl = $('#urlgambar').val()
        var namapromo = $('#nama_kredit').val()
        var bunga = $('#jumlah_bunga_persen').val()
        var totalangs = $('#total_angsuran_bulan').val()
        var tgl_dimulai = $('#tgl_penawaran').val()
        var tgl_berakhir = $('#tgl_berakhir').val()
        var textpenawaran = editor.getData()

        $.ajax({
            type: "POST",
            url: "<?= base_url('tampilemail/viewemail')?>",
            data: {
               'linkurl':linkurl,
               'namapromo':namapromo,
               'bunga':bunga,
               'totalangs':totalangs,
               'tgl_dimulai':tgl_dimulai,
               'tgl_berakhir':tgl_berakhir,
               'textpenawaran':textpenawaran,

            },
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                var myFrame = $("#iframepreview").contents().find('body');
                var html = response.html;
                myFrame.html(html);
                
            }
        });
    }

    $('#btnrefresh').on('click', function () {
        getpriviewtambahpromo()
    })

    $('#mdltambahpromo').on('change', function () {
        getpriviewtambahpromo() 
    })

    if (typeof editor !== 'undefined') {
        console.log('salah')
        editor.on('change', function() {  
            getpriviewtambahpromo() 
        });
    } 

    // edit promo
    $('.btneditpromo').on('click', function(){

        console.log($(this).data('id_penawaran'))
        
        $('#mdleditpromo #id_penawaran_edit').attr('value',$(this).data('id_penawaran') )
        $('#mdleditpromo #id_jenis_kredit_edit').attr('value',$(this).data('id_jenis_kredit') )
        $('#mdleditpromo #urlgambar_edit').val($(this).data('urlgambar'))
        $('#mdleditpromo #nama_kredit_edit').val($(this).data('nama_kredit'))
        $('#mdleditpromo #jumlah_bunga_persen_edit').val($(this).data('jumlah_bunga_persen'))
        $('#mdleditpromo #total_angsuran_bulan_edit').val($(this).data('total_angsuran_bulan')).change()
        $('#mdleditpromo #tgl_penawaran_edit').val($(this).data('tgl_penawaran'))
        $('#mdleditpromo #tgl_berakhir_edit').val($(this).data('tgl_berakhir'))
        $('#mdleditpromo #keterangan_jenis_kredit_edit').val($(this).data('keterangan_jenis_kredit'))
        $('#mdleditpromo #admin_edit').val($(this).data('admin'))
        $('#mdleditpromo #denda_edit').val($(this).data('denda'))
        $('#mdleditpromo #gambarpenawaranpreviewedit').attr('src', '<?= base_url('assets/img/promo_kredit/')?>'+$(this).data('gambar_penawaran') )
       
        editor2.setData($(this).data('text_penawaran'))
       
    })


    // get priview
    function getprivieweditpromo(){
        var linkurl = $('#urlgambar_edit').val()
        var namapromo = $('#nama_kredit_edit').val()
        var bunga = $('#jumlah_bunga_persen_edit').val()
        var totalangs = $('#total_angsuran_bulan_edit').val()
        var tgl_dimulai = $('#tgl_penawaran_edit').val()
        var tgl_berakhir = $('#tgl_berakhir_edit').val()
        var textpenawaran = editor2.getData()

        $.ajax({
            type: "POST",
            url: "<?= base_url('tampilemail/viewemail')?>",
            data: {
               'linkurl':linkurl,
               'namapromo':namapromo,
               'bunga':bunga,
               'totalangs':totalangs,
               'tgl_dimulai':tgl_dimulai,
               'tgl_berakhir':tgl_berakhir,
               'textpenawaran':textpenawaran,

            },
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                var myFrame = $("#iframepreview_edit").contents().find('body');
                var html = response.html;
                myFrame.html(html);
                
            }
        });
    }

    $('#inputeditpromo').on('change', function () {
    
        getprivieweditpromo()
    })

    $('#btnrefresh_edit').on('click', function () {
        getprivieweditpromo()
    })

    if (typeof editor2 !== 'undefined') {
        editor2.on('change', function() {  
        getprivieweditpromo() 
        });
    } 
    

    // Fungsi untuk menampilkan konfirmasi generate nasabah di kirim promo
    $(document).ready(function() {
        // Menggunakan event click pada tombol dengan id "btnkirim"
        $('#btngeneratenasabahpromo').on('click', function() {
            // menghilangkan fungsi bawaan
            event.preventDefault()

            // Menggunakan SweetAlert2 untuk menampilkan dialog konfirmasi
            Swal.fire({
                title: 'Konfirmasi Generate Kategori',
                text: 'Apakah Anda ingin mengirim permintaan generate kategori nasabah?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                // Jika konfirmasi diterima
                if (result.isConfirmed) {
                        // Menampilkan alert loading
                        Swal.fire({
                        title: 'Loading',
                        text: 'Mengirim permintaan ke Server... Mohon tunggu.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Melakukan AJAX request menggunakan jQuery
                    $.ajax({
                        url: '<?= base_url('promo/generateKategori')?>',
                        type: 'POST',
                        data: "",
                        success: function(response) {

                            $('#tbodynasabahkirimpromo').html('');
                            
                            var jsonStr = response
                            var jsonData = JSON.parse(jsonStr);

                            console.log(jsonData[0])

                            // penggunaan data JSON
                            for (var i = 0; i < jsonData.length; i++) {
                                var idNasabah = jsonData[i].id_nasabah;
                                var nama = jsonData[i].name;
                                var email = jsonData[i].email;

                                if(jsonData[i].kategori_nasabah == 1){

                                    var date = new Date(jsonData[i].date_created * 1000); 
                                    var year = date.getFullYear(); 
                                    var month = date.toLocaleString('default', { month: 'long' }); 
                                    var day = date.getDate(); 
                                    var hours = date.getHours(); 
                                    var minutes = date.getMinutes(); 
                                    var seconds = date.getSeconds();
                                    
                                    let html = ` <tr>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ (i+1) +`</td>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ jsonData[i].id_nasabah +`</td>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ jsonData[i].name +`</td>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ jsonData[i].gender+`</td>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ formatRupiah( jsonData[i].income) +`</td>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ jsonData[i].status +`</td>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ jsonData[i].pendidikan +`</td>
                                            <!-- <td class="font-weight-normal" style="color: black; font-size:smaller;"> </td> -->
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;">`+ month+`-`+year +`</td>
                                            <td class="font-weight-normal" style="color: black; font-size:smaller;"> `+ jsonData[i].kemacetan_kredit +`</td>`
                                            
                                        if(jsonData[i].kategori_nasabah == 1){
                                                        html+=`
                                                        <td class="font-weight-normal text-light text-center align-middle" style="background-color:#4dff4d">Lancar</td> 
                                                        `;
                                        } else if (jsonData[i].kategori_nasabah == 0){
                                                html+=`
                                                        <td class="font-weight-normal text-light text-center align-middle" style="background-color:#fcf403">Tidak Lancar</td>
                                                        `;
                                        } else {
                                                html+=`
                                                        <td class="font-weight-normal bg-dark text-light text-center align-middle"  style="font-size:smaller;">tdk memiliki transaksi</td>    
                                                `;
        
                                        }
                                            
                                    $('#tbodynasabahkirimpromo').append(html);
                                    
                                    
                                }

                                if(jsonData[i].update_kategori_at != null ) {
                                    var date = new Date(jsonData[i].update_kategori_at * 1000); 
                                    var year = date.getFullYear(); 
                                    var month = date.toLocaleString('default', { month: 'long' }); 
                                    var day = date.getDate(); 
                                    var hours = date.getHours(); 
                                    var minutes = date.getMinutes(); 
                                    var seconds = date.getSeconds();

                                    $('#spanupdateat').html(day+'-'+month+'-'+year);
                                }
                                
                            }

                            // Menghapus alert loading setelah mendapatkan respons success
                            Swal.fire({
                            title: 'Permintaan Berhasil!',
                            text: 'Generate kategori nasabah berhasil!',
                            icon: 'success'
                            });

                            location.reload()//reload page
                        },
                        error: function() {
                            // Menampilkan pesan error jika request gagal
                            Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengirim permintaan.',
                            icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });


    // hide card detail promo kirim promo
    $(document).ready(function () {

        $('#carddetailpromo').hide()

        // 
        // fungsi kirim email ke nasabah lancar
        // 
        // 
        $('#btnkirimpenawaran').on('click', function() {
            // menghilangkan fungsi bawaan
            event.preventDefault()
            
            let id_penawaran = $(this).data('id_penawaran') 
            
            // Menggunakan SweetAlert2 untuk menampilkan dialog konfirmasi
            Swal.fire({
                title: 'Konfirmasi Kirim Penawaran',
                text: 'Apakah Anda yakin ingin mengirim promo kredit ini sekarang?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                // Jika konfirmasi diterima
                if (result.isConfirmed) {
                        // Menampilkan alert loading
                        Swal.fire({
                        title: 'Loading',
                        text: 'Mengirim email promo ke Nasabah Lancar... Mohon tunggu.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Melakukan AJAX request menggunakan jQuery
                    $.ajax({
                        url: '<?= base_url('promo/sendpromo')?>',
                        type: 'POST',
                        data: {
                            'id_penawaran':id_penawaran
                        },
                        success: function(response) {

                            var jsonStr = response
                            var jsonData = JSON.parse(jsonStr);

                            // Menghapus alert loading setelah mendapatkan respons success
                            Swal.fire({
                            title: 'Pengiriman Email Berhasil!',
                            text: 'Email promo kredit berhasil dikirimkan kepada '+jsonData.jumlah+' nasabah!',
                            icon: 'success'
                            });
                        },
                        error: function() {
                            // Menampilkan pesan error jika request gagal
                            Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengirim permintaan.',
                            icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    })

    // get priview
    $('.btnpilihpromo').on('click', function () {
        var linkurl = $(this).data('urlgambar') 
        var namapromo = $(this).data('nama_kredit')
        var bunga = $(this).data('jumlah_bunga_persen')
        var totalangs = $(this).data('total_angsuran_bulan')
        var tgl_dimulai = $(this).data('tgl_penawaran')
        var tgl_berakhir = $(this).data('tgl_berakhir')
        var textpenawaran = $(this).data('text_penawaran')

        $.ajax({
            type: "POST",
            url: "<?= base_url('tampilemail/viewemail')?>",
            data: {
               'linkurl':linkurl,
               'namapromo':namapromo,
               'bunga':bunga,
               'totalangs':totalangs,
               'tgl_dimulai':tgl_dimulai,
               'tgl_berakhir':tgl_berakhir,
               'textpenawaran':textpenawaran,

            },
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                var myFrame = $("#iframepreview").contents().find('body');
                var html = response.html;
                myFrame.html(html);
                
            }
        });

        $('#detailcardtampilpromo #nama_kredit').val($(this).data('nama_kredit'))
        $('#detailcardtampilpromo #jumlah_bunga_persen').val($(this).data('jumlah_bunga_persen')+' persen')
        $('#detailcardtampilpromo #total_angsuran_bulan').val($(this).data('total_angsuran_bulan')+' bulan').change()
        $('#detailcardtampilpromo #tgl_penawaran').val($(this).data('tgl_penawaran'))
        $('#detailcardtampilpromo #tgl_berakhir').val($(this).data('tgl_berakhir'))
        $('#detailcardtampilpromo #keterangan_jenis_kredit').val($(this).data('keterangan_jenis_kredit'))
        $('#detailcardtampilpromo #admin').val($(this).data('admin')+' persen')
        $('#detailcardtampilpromo #denda').val($(this).data('denda')+' persen')
        $('#detailcardtampilpromo #gambarpenawaranpreview').attr('src', '<?= base_url('assets/img/promo_kredit/')?>'+$(this).data('gambar_penawaran') )
        $('#carddetailpromo #btnkirimpenawaran').attr('data-id_penawaran', $(this).data('id_penawaran') )

        
    })

   



</script>

<!-- datatables -->
<script src="<?= base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- pusher -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('8459db692d2df931dcd7', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(pesan) {

        // alert(pesan.message);

        xhr = $.ajax({
            type: "POST",
            url: "<?= base_url('user/tampil_notif') ?>",
            success: function(response) {
                console.log(response)
                $('.list-notifikasi').html(response);
            }
        });
    });

    var channel2 = pusher.subscribe('my-channel2');
    channel2.bind('my-event2', function(pesan) {

        // alert(pesan.message);

        xhr = $.ajax({
            type: "POST",
            url: "<?= base_url('user/tampil_notif') ?>",
            success: function(response) {
                console.log(response)
                $('.list-notifikasi').html(response);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        loadKeranjang();
        $('#tblRiwayatTrans').DataTable();
        $('#tblMember').DataTable();


        var table = $('#tblBarang').DataTable({
            responsive: true,
            pageLength: 3,
            lengthMenu: [
                [3, 5, 10, 20, -1],
                [3, 5, 10, 20, 'Todos']
            ]
        })

        var table2 = $('#transsu').DataTable({
            responsive: true,
            pageLength: 3,
            lengthMenu: [
                [3, 5, 10, 20, -1],
                [3, 5, 10, 20, 'Todos']
            ]
        })

        //nasabah
        var table = $('#tblNasabah').DataTable({
            responsive: true,
            pageLength: 5,
            lengthMenu: [
                [3, 5, 10, 20, -1],
                [3, 5, 10, 20, 'Todos']
            ]
        })

    });




    //untuk mangakali upload file edit profile
    $('.custom-file-input').on('change', function() {
        let filename = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(filename);
    })


    // unuk mengakali saat terjadi perubahan di form check role
    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeAccess') ?>",
            type: 'POST',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                // meredirect halaman ke roleaccess
                document.location.href = "<?= base_url('admin/roleAccess/') ?>" +
                    roleId;
            }
        });
    })


    // menambahkan pilihan mesin kekeranjang
    // agar jquery bisa mencari multiple atribut menggunakan class.
    // tidak menggunakan # (id) yang bisa hanya satu atribut
    $('.memilih').on('click', function() {
        let nama = $(this).data('nama');
        let harga = $(this).data('harga');
        let gambar = $(this).data('gambar');
        let id = $(this).data('id');

        $('#pilihMesin #gambar').attr('src', gambar);
        $('#pilihMesin #namamesin').html(nama);
        $('#pilihMesin #harga').html(harga);

        $('#btntambah').attr('onclick', 'tambahKeranjang(' + id + ')')
    })

    function tambahKeranjang($id) {

        let id = $id;
        let jumlah = $('#jumlah').val();


        $.ajax({
            type: "POST",
            url: "<?= base_url('transaksi/simpanKeranjang') ?>",
            data: {
                "id": id,
                "jumlah": jumlah
            },
            dataType: "JSON",
            success: function(response) {

                $('#pilihMesin').modal('hide');
                // alert(response.message);
                $('#daftarKeranjang').html('');
                loadKeranjang();

            }
        });
    }

    function loadKeranjang() {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Transaksi/loaddaftar') ?>",
            data: "",
            dataType: "JSON",
            success: function(response) {

                // console.log(response);

                if (response.message == 'Data Kosong') {

                    $('#daftarKeranjang').html(`<h5 class="card-title text-center">Daftar Kosong</h5>`);
                } else {
                    $('#daftarKeranjang').html('');


                    //looping ke daftar keranjang 
                    $.each(response, function(i, item) {
                        $('#daftarKeranjang').append(`
                                                        <div class="row">
                                                            <h5 class="card-title col-lg-8">` + item['nama_mesin'] + `</h5>
                                                            <div class="col-lg-4">
                                                                <b> X ` + item['jumlah_mesin'] + `</b>
                                                            </div>
                                                           
                                                        </div>
                                                       
                                                        <div class="row ">
                                                            <div class="col-lg-9"
                                                             <small>   <b>` + formatRupiah(item['subtotal']) + `</b></small>
                                                            </div>
                                                            <button class="btn btn-sm btn-danger mr-1" onclick="hapusDaftar(` + item['id_penjualan'] + `,` + item['id_mesin'] + `)"><b>X</b></button>
                                                        </div> 
                                                        <hr>`);

                    });


                    $('#daftarKeranjang').append(`
                                            <div class="row justify-content-center">
                                                <button class="btn btn-warning" id="btnLanjutPembayaran" data-toggle="modal" data-target="#modallanjutPembayaran" data-idjual="` + response[0]['id_penjualan'] + `">Lanjutkan Pembayaran</button>
                                            </div>
                    `);


                }







            }
        });



    }

    function hapusDaftar($id_penjualan, $id_mesin) {
        let id_penjualan = $id_penjualan;
        let id_mesin = $id_mesin;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Transaksi/hapusDaftar') ?>",
            data: {
                'id_penjualan': id_penjualan,
                'id_mesin': id_mesin
            },
            dataType: "JSON",
            success: function(response) {

                console.log(response)
                loadKeranjang();

            }
        });
    }

    function formatRupiah(money) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }

    $('#daftarKeranjang').on('click', '#btnLanjutPembayaran', function() {
        let idPenjualan = $(this).data('idjual');
        let total = 0;

        $.ajax({
            type: "POST",
            url: "<?= base_url('transaksi/lanjutPembayaran') ?>",
            data: {
                'idJual': idPenjualan,
                'proses': 'tampil'
            },
            dataType: "JSON",
            success: function(response) {
                $('#cardLanjutPembayaran').html('');

                console.log(response);

                // menampilkan mesin di form pembeli di modal lanjutpembayaran
                $.each(response, function(i, item) {
                    total += parseInt(item['harga'] * item['jumlah_mesin']);

                    $('#cardLanjutPembayaran').append(`<div class="row mb-3">
                                                        <div class="col-lg-4">
                                                            <img src="<?= base_url('assets/img/mesin/') ?>` + item['gambar'] + `" class="img img-thumbnail">
                                                                </div>
                                                                    <div class="col-lg-8" style="font-size: 30px;">
                                                                        <div class="row ">
                                                                            <p><b>` + item['nama_mesin'] + `</b></p>
                                                                            
                                                                        </div>
                                                                        <span style="font-size: 15px;" class="text-left">( x : ` + item['jumlah_mesin'] + `) </span>
                                                                        <span style="font-size: 20px;" class="text-right font-weight-bold"> ` + formatRupiah(item['harga'] * item['jumlah_mesin']) + `</span>
    
                                                                         </div>
                                                        </div>
    
                                                        `);

                });

                $('#cardLanjutPembayaran').append(`<div class="col text-center bg-warning">
                                                    <span style="font-size: 30px; color:black;" > Total = ` + formatRupiah(total) + `</span>
                </div>`)

                $('#idJual').attr('value', response[0]['id_penjualan']);
                $('#totalPembayaran').attr('value', total);


            }
        });
    })

    $('#formIsiPembeli').submit(function() {
        var nama = $('#customername').val().length;
        var address = $('#address').val().length;
        var city = $('#city').val().length;
        var province = $('#province').val().length;
        var phone = $('#phone').val().length;

        if (nama == 0) {
            $('#validationname').addClass('text-danger');
            return false;
        } else if (address == 0) {
            $('#validationaddress').addClass('text-danger');
            return false;

        } else if (city == 0) {
            $('#validationcity').addClass('text-danger');
            return false;

        } else if (phone == 0) {
            $('#validationphone').addClass('text-danger');
            return false;

        } else if (province == 0) {
            $('#validationprovince').addClass('text-danger');
            return false;

        }
    })
</script>

<script>
    $('.transEdit').on('click', function() {
        $id = $(this).data('id');
        $total = $(this).data('total');
        $Sdate = $(this).data('shipdate');
        $Svia = $(this).data('shipvia');
        $Sfob = $(this).data('fob');
        $term = $(this).data('term');
        $ongkir = $(this).data('ongkir');


        console.log($id + $total);

        $('#editTransaksi #idPenjualan').attr('value', $id);
        $('#editTransaksi #totalTrans').attr('value', $total);
        $('#editTransaksi #shipVia').attr('value', $Svia);
        $('#editTransaksi #ongkir').attr('value', $ongkir);
        $('#editTransaksi #shipDate').val($Sdate);
        $('#editTransaksi #fob').attr('value', $Sfob);
        $('#editTransaksi #term').attr('value', $term);
    })
    // menambahkan idPJL pada form input modal tambah invoice
    $('.tambahbukti').on('click', function() {
        let id = $(this).data('idpjl');
        console.log(id);

        $('#modalTambahPembayaran #idPJL').attr('value', id);
    })

    $('#formTambahPMB').submit(function() {
        let jumlah = $('#modalTambahPembayaran #jumlahPMB').val().length;
        let terbilang = $('#modalTambahPembayaran #terbilang').val();



        if (jumlah == 0) {
            $('#modalTambahPembayaran #jumlahPMB').val(0);
            return false;

        } else if (terbilang.length == 0 || terbilang == 'Inputan Salah!') {
            $('#modalTambahPembayaran #terbilang').val('Inputan Salah!');
            return false;
        }
    })

    $('.edittermin').on('click', function() {
        let termin = $(this).data('termin');
        let id = $(this).data('idpjl');
        let gambar = $(this).data('gambar');
        let jumlah = $(this).data('jumlah');
        let terbilang = $(this).data('terbilang');
        let ket = $(this).data('keterangan');


        $('#modalEditPembayaran #idPJL').attr('value', id);
        $('#modalEditPembayaran #termin').attr('value', termin);
        $('#modalEditPembayaran #jumlahPMB').attr('value', jumlah);
        $('#modalEditPembayaran #terbilang').attr('value', terbilang);
        $('#modalEditPembayaran #ketTermin').attr('value', ket);
        $('#modalEditPembayaran .edit').html(gambar);
    })

    $('.cetaktermin').on('click', function() {

        let idPJL = $(this).data('idpenjualan');
        let termin = $(this).data('termin');

        $.ajax({
            type: "post",
            url: "<?= base_url('transaksi/praCetakInvoice') ?>",
            data: {
                'idpjl': idPJL,
                'termin': termin
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);

                $('#modalCetakTermin #idPJL').attr('value', idPJL)
                $('#modalCetakTermin #termin').attr('value', termin);

                $('#modalCetakTermin #namaCust').html(response.penjualan_cust.nama);
                $('#modalCetakTermin #TglCust').html(response.penjualan_cust.tanggal);
                $('#modalCetakTermin #BuktiCust').html('<img src="<?= base_url('assets/img/bukti_pembayaran/') ?>' + response.termin.gambar_transfer + '" class="img-thumbnail" style="height:150px; object-fit: cover;">');

                $('#modalCetakTermin #jumlahPMBCTK').val(formatRupiah(response.termin.jumlah));
                $('#modalCetakTermin #terbilangCTK').val(response.termin.terbilang);
                $('#modalCetakTermin #ketTermin').val(response.termin.keterangan);
                $('#modalCetakTermin #komentar1').val('Pembayaran dengan giro atau check dianggap sah setelah diuangkan');
            }
        });
    })
</script>

<script>

    //edit nasabah
    $('.editNsb').on('click', function() {

    $('#mdlEditNasabah #id_nasabah').attr('value', $(this).data('idnasabah'));
    $('#mdlEditNasabah #id_user').attr('value', $(this).data('id-user'));
    $('#mdlEditNasabah #income').attr('value', $(this).data('income'));
    $('#mdlEditNasabah #status').attr('value', $(this).data('status'));
    $('#mdlEditNasabah #pendidikan').attr('value', $(this).data('pendidikan'));
    $('#mdlEditNasabah #pengeluaran').attr('value', $(this).data('pengeluaran'));
    // $('#mdlEditNasabah #kemacetan_kredit').attr('value', $(this).data('kemacetan-kredit'));
    // $('#mdlEditNasabah #kategori_nasabah').attr('value', $(this).data('kategori-nasabah'));
    })

    //edit jenis kredit
    $('.editJnsKredit').on('click', function() {

        $('#mdlEditJenisKredit #id_jenis_kredit').attr('value', $(this).data('id-jenis-kredit'));
        $('#mdlEditJenisKredit #total_angsuran_bulan').attr('value', $(this).data('total-angsuran-bulan'));
        $('#mdlEditJenisKredit #jumlah_bunga_persen').attr('value', $(this).data('jumlah-bunga-persen'));
        $('#mdlEditJenisKredit #nama_kredit').attr('value', $(this).data('nama-kredit'));
        $('#mdlEditJenisKredit #denda_persen').attr('value', $(this).data('denda_persen'));
    })

    // tambah pengajuan kredit user
    $(document).ready(function () {
        $('#collapseCardExample').collapse({
            hide: true
        })
    });

    //edit pengajuan kredit user
    $('.editPlyKredit').on('click', function() {
        
        $('#mdlEditPengajuanKredit #id_pengajuan').attr('value', $(this).data('id-pengajuan'));
        $('#mdlEditPengajuanKredit #id_nasabah').attr('value', $(this).data('id-nasabah'));
        $('#mdlEditPengajuanKredit #id_jenis_kredit').attr('value', $(this).data('id-jenis-kredit'));
        $('#mdlEditPengajuanKredit #jumlah_pinjaman').attr('value', $(this).data('jumlah-pinjaman'));

        $.ajax({
            type: "POST",
            url: "<?= base_url('pelayanan/getDataPengajuan') ?>",
            data: {
                'id_pengajuan': $(this).data('id-pengajuan'),
                'id_nasabah': $(this).data('id-nasabah'),
            },
            dataType: "JSON",
            success: function (response) {

            // change selected value .val.change()
            $("#mdlEditPengajuanKredit #id_jenis_kredit").val(response.pengajuan.id_jenis_kredit).change();

            //  clear isi foto
            $("#mdlEditPengajuanKredit #daftar_foto_bpkb").html('').change();
            $("#mdlEditPengajuanKredit #daftar_foto_stnk").html('').change();
            $("#mdlEditPengajuanKredit #daftar_foto_jaminan").html('').change();
            $("#mdlEditPengajuanKredit #daftar_foto_shm").html('').change();


            
            $.each(response.daftar_jaminan, function(i, item){
                // aktifkan nav pilihan jaminan
                if(item.kode_jaminan == "SHM/SHGB"){
                    // nilai shm
                    $("#inputjaminanshmedit").attr('hidden', false)   
                    $('#inputjaminankendaraanedit').attr('hidden', true )
                    $('#navkendaraanedit').removeClass('active').addClass('');
                    $('#navshmedit').removeClass('').addClass('active');

                    // mengubah nilai taksasi
                    $('#id_jaminan_shm2').attr('value',item.taksasi.id_jaminan)
                    $('#taksasishm2').val(formatRupiah(item.taksasi))
                    $('#luastanah2').val(item.luas_tanah)
                    $('#inputmaksshm2').val(formatRupiah(item.taksasi*item.luas_tanah))
                    $("#mdlEditPengajuanKredit #id_jaminan_shm2").attr('value',item.id_jaminan);

                    // menghilangkan upload bpkb
                    $('#suratshmedit').attr('hidden', false  )
                    $('#suratkendaraanedit').attr('hidden', true  )
                    
                    // mengganti label
                    $('#labelnomoredit').html('Nomor SHM/SHGB')
                    $('#labelatasnamaedit').html('Atas Nama (SHM/SHGB)')

                }else{
                    // nilai kendaraan
                    $('#inputjaminanshmedit').attr('hidden', true)
                    $('#inputjaminankendaraanedit').attr('hidden', false)
                    $('#navshmedit').removeClass('active').addClass('');
                    $('#navkendaraanedit').removeClass('').addClass('active');

                    $("#mdlEditPengajuanKredit #nama_kendaraan2").attr('value',item.nama_jaminan);
                    $("#mdlEditPengajuanKredit #taksasi2").attr('value',formatRupiah(item.taksasi));
                
                    // menghilangkan upload bpkb
                    $('#suratshmedit').attr('hidden', true )
                    $('#suratkendaraanedit').attr('hidden', false  )
                    
                    // mengganti label
                    $('#labelnomoredit').html('Nomor BPKB')
                    $('#labelatasnamaedit').html('Atas Nama (BPKB)')

                    $('#id_jaminan_shm2').attr('value','')
                }
                

                // console.log(item.nama_jaminan)
                
                $("#mdlEditPengajuanKredit #dimiliki_tahun").val(item.dimiliki_tahun).change();
                $("#mdlEditPengajuanKredit #id_jaminan2").attr('value',item.id_jaminan);
                
                $("#mdlEditPengajuanKredit #nomor_surat_kepemilikan").val(item.nomor_surat_kepemilikan).change();
                $("#mdlEditPengajuanKredit #nomor_surat_kepemilikan").attr('value',item.nomor_surat_kepemilikan);
                $("#mdlEditPengajuanKredit #atas_nama").val(item.atas_nama).change();
                $("#mdlEditPengajuanKredit #atas_nama").attr('value',item.atas_nama);
                $("#mdlEditPengajuanKredit #harga_beli").val(item.harga_beli).change();
                $("#mdlEditPengajuanKredit #harga_beli").attr('value',item.harga_beli);
                $("#mdlEditPengajuanKredit #diperoleh_dengan").val(item.diperoleh_dengan).change();
                // $("#mdlEditPengajuanKredit #diperoleh_dengan").attr('value',item.diperoleh_dengan);

            })

            $.each(response.daftar_foto_surat_kepemilikan[0], function(i, item){
                // console.log(item.nama_jaminan)
                if(item.nama_surat == 'BPKB'){
                    console.log(item.nama_surat)
                        $("#mdlEditPengajuanKredit #daftar_foto_bpkb").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`" 
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                }else if(item.nama_surat == 'STNK'){
                    $("#mdlEditPengajuanKredit #daftar_foto_stnk").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`"
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }else if(item.nama_surat == "SHM/SHGB" ){
                    $("#mdlEditPengajuanKredit #daftar_foto_shm").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`"
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }


            })

            $.each(response.daftar_foto_jaminan[0], function(i, item){
                // console.log(item.nama_jaminan)
                        $("#mdlEditPengajuanKredit #daftar_foto_jaminan").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapusjaminan close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotojaminan"  
                                                    data-id_daftar_foto_jaminan="`+item.id_daftar_foto_jaminan+`" 
                                                    data-foto_jaminan="`+item.foto_jaminan+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_jaminan+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                

            })

                
            }
        });
    })

    //edit pengajuan kredit Admin
    $('.editPlyKreditAdmin').on('click', function() {
        
        $('#mdlEditPengajuanKredit #id_pengajuan').attr('value', $(this).data('id-pengajuan'));
        $('#mdlEditPengajuanKredit #id_nasabah').val( $(this).data('id-nasabah')).change();
        $('#mdlEditPengajuanKredit #id_jenis_kredit').attr('value', $(this).data('id-jenis-kredit'));
        $('#mdlEditPengajuanKredit #jumlah_pinjaman').attr('value', $(this).data('jumlah-pinjaman'));

        $.ajax({
            type: "POST",
            url: "<?= base_url('kredit/getDataPengajuan') ?>",
            data: {
                'id_pengajuan': $(this).data('id-pengajuan'),
                'id_nasabah': $(this).data('id-nasabah'),
            },
            dataType: "JSON",
            success: function (response) {

            // change selected value .val.change()
            $("#mdlEditPengajuanKredit #id_jenis_kredit").val(response.pengajuan.id_jenis_kredit).change();

            //  clear isi foto
            $("#mdlEditPengajuanKredit #daftar_foto_bpkb").html('').change();
            $("#mdlEditPengajuanKredit #daftar_foto_stnk").html('').change();
            $("#mdlEditPengajuanKredit #daftar_foto_jaminan").html('').change();


            
            $.each(response.daftar_jaminan, function(i, item){
                // aktifkan nav pilihan jaminan
                if(item.kode_jaminan == "SHM/SHGB"){
                    // nilai shm
                    $("#inputjaminanshmedit").attr('hidden', false)   
                    $('#inputjaminankendaraanedit').attr('hidden', true )
                    $('#navkendaraanedit').removeClass('active').addClass('');
                    $('#navshmedit').removeClass('').addClass('active');

                    // mengubah nilai taksasi
                    $('#id_jaminan_shm2').attr('value',item.taksasi.id_jaminan)
                    $('#taksasishm2').val(formatRupiah(item.taksasi))
                    $('#luastanah2').val(item.luas_tanah)
                    $('#inputmaksshm2').val(formatRupiah(item.taksasi*item.luas_tanah))
                    $("#mdlEditPengajuanKredit #id_jaminan_shm2").attr('value',item.id_jaminan);

                    // menghilangkan upload bpkb
                    $('#suratshmedit').attr('hidden', false  )
                    $('#suratkendaraanedit').attr('hidden', true  )
                    
                    // mengganti label
                    $('#labelnomoredit').html('Nomor SHM/SHGB')
                    $('#labelatasnamaedit').html('Atas Nama (SHM/SHGB)')

                }else{
                    // nilai kendaraan
                    $('#inputjaminanshmedit').attr('hidden', true)
                    $('#inputjaminankendaraanedit').attr('hidden', false)
                    $('#navshmedit').removeClass('active').addClass('');
                    $('#navkendaraanedit').removeClass('').addClass('active');

                    $("#mdlEditPengajuanKredit #nama_kendaraan2").attr('value',item.nama_jaminan);
                    $("#mdlEditPengajuanKredit #taksasi2").attr('value',formatRupiah(item.taksasi));
                
                    // menghilangkan upload bpkb
                    $('#suratshmedit').attr('hidden', true )
                    $('#suratkendaraanedit').attr('hidden', false  )
                    
                    // mengganti label
                    $('#labelnomoredit').html('Nomor BPKB')
                    $('#labelatasnamaedit').html('Atas Nama (BPKB)')

                    $('#id_jaminan_shm2').attr('value','')
                }
                

                // console.log(item.nama_jaminan)
                
                $("#mdlEditPengajuanKredit #dimiliki_tahun").val(item.dimiliki_tahun).change();
                $("#mdlEditPengajuanKredit #id_jaminan2").attr('value',item.id_jaminan);
                
                $("#mdlEditPengajuanKredit #nomor_surat_kepemilikan").val(item.nomor_surat_kepemilikan).change();
                $("#mdlEditPengajuanKredit #nomor_surat_kepemilikan").attr('value',item.nomor_surat_kepemilikan);
                $("#mdlEditPengajuanKredit #atas_nama").val(item.atas_nama).change();
                $("#mdlEditPengajuanKredit #atas_nama").attr('value',item.atas_nama);
                $("#mdlEditPengajuanKredit #harga_beli").val(item.harga_beli).change();
                $("#mdlEditPengajuanKredit #harga_beli").attr('value',item.harga_beli);
                $("#mdlEditPengajuanKredit #diperoleh_dengan").val(item.diperoleh_dengan).change();
                // $("#mdlEditPengajuanKredit #diperoleh_dengan").attr('value',item.diperoleh_dengan);

            })

            $.each(response.daftar_foto_surat_kepemilikan[0], function(i, item){
                // console.log(item.nama_jaminan)
                if(item.nama_surat == 'BPKB'){
                    console.log(item.nama_surat)
                        $("#mdlEditPengajuanKredit #daftar_foto_bpkb").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`" 
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                }else if(item.nama_surat == 'STNK'){
                    $("#mdlEditPengajuanKredit #daftar_foto_stnk").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`"
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }else if(item.nama_surat == "SHM/SHGB" ){
                    $("#mdlEditPengajuanKredit #daftar_foto_shm").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`"
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }


            })

            $.each(response.daftar_foto_jaminan[0], function(i, item){
                // console.log(item.nama_jaminan)
                        $("#mdlEditPengajuanKredit #daftar_foto_jaminan").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapusjaminan close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotojaminan"  
                                                    data-id_daftar_foto_jaminan="`+item.id_daftar_foto_jaminan+`" 
                                                    data-foto_jaminan="`+item.foto_jaminan+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_jaminan+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                

            })

                
            }
        });
    })

    $('#daftar_foto_bpkb').on('click','.btnhapussurat', function(){
        
        $('#mdlhapusfotosurat #id_daftar_foto_surat_kepemilikan').attr('value',$(this).data('id_daftar_foto_surat_kepemilikan'));
        $('#mdlhapusfotosurat #detailfotosurat').html( `<img src="<?= base_url('assets/img/pengajuan/')?>`+$(this).data('foto_surat')+`" class="mx-auto img-fluid" alt="...">`);
        
    })
    
    $('#daftar_foto_stnk').on('click','.btnhapussurat', function(){
        
        $('#mdlhapusfotosurat #id_daftar_foto_surat_kepemilikan').attr('value',$(this).data('id_daftar_foto_surat_kepemilikan'));
        $('#mdlhapusfotosurat #detailfotosurat').html( `<img src="<?= base_url('assets/img/pengajuan/')?>`+$(this).data('foto_surat')+`" class="mx-auto img-fluid" alt="...">`);
    })

    $('#daftar_foto_shm').on('click','.btnhapussurat', function(){
        
        $('#mdlhapusfotosurat #id_daftar_foto_surat_kepemilikan').attr('value',$(this).data('id_daftar_foto_surat_kepemilikan'));
        $('#mdlhapusfotosurat #detailfotosurat').html( `<img src="<?= base_url('assets/img/pengajuan/')?>`+$(this).data('foto_surat')+`" class="mx-auto img-fluid" alt="...">`);
    })


    $('#daftar_foto_jaminan').on('click','.btnhapusjaminan', function(){
        
        $('#mdlhapusfotojaminan #id_daftar_foto_jaminan').attr('value',$(this).data('id_daftar_foto_jaminan'));
        $('#mdlhapusfotojaminan #detailfotojaminan').html( `<img src="<?= base_url('assets/img/pengajuan/')?>`+$(this).data('foto_jaminan')+`" class="mx-auto img-fluid" alt="...">`);
    })


     //hapus foto surat
    $('#mdlhapusfotosurat #btnhapusfotosurat').on('click', function() {
        
        let id_daftar_foto_surat_kepemilikan = $('#id_daftar_foto_surat_kepemilikan').val()
        let id_pengajuan = $('#mdlEditPengajuanKredit #id_pengajuan').val()
        let id_nasabah = $('#mdlEditPengajuanKredit #id_nasabah').val()
        
        // melihat apakah ini dari user atau admin
        var pageTitle = $('title').text();
        console.log(pageTitle);

        var url = '<?= base_url('') ?>'

        if(pageTitle != 'List Pengajuan Kredit'){
            url+='pelayanan/hapusfotosurat'
        }else{
            url+='kredit/hapusfotosurat'
        }

        console.log(url)

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_daftar_foto_surat_kepemilikan': id_daftar_foto_surat_kepemilikan,
                'id_pengajuan': id_pengajuan,
                'id_nasabah': id_nasabah,
            },
            dataType: "JSON",
            success: function (response) {
            console.log(response)

            //  clear isi foto
            $("#mdlEditPengajuanKredit #daftar_foto_bpkb").html('').change();
            $("#mdlEditPengajuanKredit #daftar_foto_stnk").html('').change();
            $("#mdlEditPengajuanKredit #daftar_foto_shm").html('').change();


            
            $.each(response.daftar_foto_surat_kepemilikan[0], function(i, item){
                // console.log(item.nama_jaminan)
                if(item.nama_surat == 'BPKB'){
                    console.log(item.nama_surat)
                        $("#mdlEditPengajuanKredit #daftar_foto_bpkb").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`" 
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                }else if(item.nama_surat == 'STNK'){
                    $("#mdlEditPengajuanKredit #daftar_foto_stnk").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`"
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }else if(item.nama_surat == "SHM/SHGB" ){
                    $("#mdlEditPengajuanKredit #daftar_foto_shm").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapussurat close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotosurat"  
                                                    data-id_daftar_foto_surat_kepemilikan="`+item.id_daftar_foto_surat_kepemilikan+`"
                                                    data-foto_surat="`+item.foto_surat+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }


            })

            // close modal $('#myModal').modal('hide')
            $('#mdlhapusfotosurat').modal('hide')


                
            }
        });
    })

        //hapus foto jaminan
    $('#mdlhapusfotojaminan #btnhapusfotojaminan').on('click', function() {
        
        let id_daftar_foto_jaminan = $('#id_daftar_foto_jaminan').val()
        let id_pengajuan = $('#mdlEditPengajuanKredit #id_pengajuan').val()
        let id_nasabah = $('#mdlEditPengajuanKredit #id_nasabah').val()

        console.log(id_daftar_foto_jaminan+id_pengajuan+id_nasabah)
        
        // melihat apakah ini dari user atau admin
        var pageTitle = $('title').text();
        console.log(pageTitle);

        var url = '<?= base_url('') ?>'

        if(pageTitle != 'List Pengajuan Kredit'){
            url+='pelayanan/hapusfotojaminan'
        }else{
            url+='kredit/hapusfotojaminan'
        }

        console.log(url)

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id_daftar_foto_jaminan': id_daftar_foto_jaminan,
                'id_pengajuan': id_pengajuan,
                'id_nasabah': id_nasabah,
            },
            dataType: "JSON",
            success: function (response) {
            console.log(response)

            //  clear isi foto
            $("#mdlEditPengajuanKredit #daftar_foto_jaminan").html('').change();


            
             $.each(response.daftar_foto_jaminan[0], function(i, item){
                // console.log(item.nama_jaminan)
                        $("#mdlEditPengajuanKredit #daftar_foto_jaminan").append(
                            `<div class="col-6 mb-2">
                                                    <button type="button" class="btnhapusjaminan close" aria-label="Close" data-toggle="modal" 
                                                    data-target="#mdlhapusfotojaminan"  
                                                    data-id_daftar_foto_jaminan="`+item.id_daftar_foto_jaminan+`" 
                                                    data-foto_jaminan="`+item.foto_jaminan+`">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_jaminan+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                

            })

            // close modal $('#myModal').modal('hide')
            $('#mdlhapusfotojaminan').modal('hide')


                
            }
        });
    })


    //terima pengajuan kredit
    $('.terimaPlyKredit').on('click', function() {
        $('#mdlTerimaPengajuanKredit #id_pengajuan').attr('value', $(this).data('id-pengajuan'));
    })

    //tolak pengajuan kredit
    $('.tolakPlyKredit').on('click', function() {
        $('#mdlTolakPengajuanKredit #id_pengajuan').attr('value', $(this).data('id-pengajuan'));
    })

    //batalkan pengajuan kredit
    $('.batalkanPlyKredit').on('click', function() {
        $('#mdlbatalkanPengajuanKredit #id_pengajuan').attr('value', $(this).data('id-pengajuan'));
    })

    //terima angsuran
    $('.terimaAgs').on('click', function() {
        $('#mdlTerimaAngsuran #id_angsuran').attr('value', $(this).data('id-angsuran'));
    })

    //tolak angsuran
    $('.tolakAgs').on('click', function() {
        $('#mdlTolakAngsuran #id_angsuran').attr('value', $(this).data('id-angsuran'));
    })

    //edit promo kredit
    $('.editPrmKredit').on('click', function() {
    $('#mdlEditPromoKredit #id_penawaran').attr('value', $(this).data('id-penawaran'));
    $('#mdlEditPromoKredit #gambar_penawaran').attr('value', $(this).data('gambar-penawaran'));
    $('#mdlEditPromoKredit #dikonfirmasi').attr('value', $(this).data('dikonfirmasi'));
    $('#mdlEditPromoKredit #tgl_penawaran').attr('value', $(this).data('tgl-penawaran'));
    })

    //kirim promo
    $('.kirimPromo').on('click', function() {
        $('#mdlkirimPromo #id_penawaran').attr('value', $(this).data('id-penawaran'));
    })
    //menu promo kredit terima kredit
    $('.mdlajukanKredit').on('click', function() {
        $('#mdlAjukanKredit #id_jenis_kredit').attr('value', $(this).data('id-jenis-kredit'));
        $('#mdlAjukanKredit #nama_kredit').attr('value', $(this).data('nama-kredit'));
    })

    $('.editMsn').on('click', function() {

        $('#mdlEditMsn #id_mesin').attr('value', $(this).data('idmesin'));
        $('#mdlEditMsn #nama_mesin').attr('value', $(this).data('namamesin'));
        $('#mdlEditMsn #harga_mesin').attr('value', $(this).data('hargamesin'));
        $('#mdlEditMsn #gambar_mesin').html($(this).data('gambarmesin'));
        $('#mdlEditMsn #kapasitas_mesin').attr('value', $(this).data('kapasitasmesin'));
    })

    $('.editStatus').on('click', function() {
        console.log($(this).data('iduser'));
        $('#mdlEditUser #id_user').attr('value', $(this).data('iduser'));
        $('#mdlEditUser #nama_user').attr('value', $(this).data('namauser'));
        $('#mdlEditUser #email_user').attr('value', $(this).data('emailuser'));
        $('#mdlEditUser #status_user').attr('value', $(this).data('statususer'));
    })

    $('.list-notifikasi').on('click', '#alertsDropdown', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('user/bukanotif') ?>",
            data: {
                'id_user': $(this).data('id')
            },
            dataType: "JSON",
            success: function(response) {
                $('.badge').html('');

            }
        });
    })
    let url = $('.exportlap').attr('href');
    $('#selecttrans').on('change', function() {
        $('#tabeltrans').html('');

        let pilihan = $(this).val();

        if (pilihan == 1) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/pilihanTrans/1') ?>",
                dataType: "JSON",
                success: function(response) {
                    let no = 1;
                    $.each(response, function(i, item) {
                        let dibayarkan = 0;

                        if (item['dibayarkan']) {
                            dibayarkan = item['dibayarkan'];
                        }

                        $('#tabeltrans').append(`
                            <tr>
                                    <td class="font-weight-normal" style="color: black; ">` + no + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['id_penjualan'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['total']) + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(dibayarkan) + `</td>
                                    <td class="font-weight-normal" style="color: black; ">` + item['name'] + ` </td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama_mesin'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['harga']) + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['jumlah_mesin'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama_perusahaan'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nomor_wa'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['ongkir']) + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['ship_date'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['ship_via'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['fob'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['term'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['sales'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['keterangan'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> <button class="lihatterminadm btn btn-primary btn-sm" data-toggle="modal" data-target="#mdllihatterminadm" data-idpjl="` + item['id_penjualan'] + `"><small>Lihat</small></button> </td>



                                </tr>
                        `)
                        no++;
                    })

                }
            });
            let url2 = url;
            url2 = url2 + pilihan;
            $('.exportlap').attr('href', url2);

        } else if (pilihan == 2) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/pilihanTrans/2') ?>",
                dataType: "JSON",
                success: function(response) {
                    let no = 1;
                    $.each(response, function(i, item) {
                        let dibayarkan = 0;

                        if (item['dibayarkan']) {
                            dibayarkan = item['dibayarkan'];
                        }

                        $('#tabeltrans').append(`
                            <tr>
                                    <td class="font-weight-normal" style="color: black; ">` + no + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['id_penjualan'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['total']) + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(dibayarkan) + `</td>
                                    <td class="font-weight-normal" style="color: black; ">` + item['name'] + ` </td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama_mesin'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['harga']) + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['jumlah_mesin'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama_perusahaan'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nomor_wa'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['ongkir']) + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['ship_date'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['ship_via'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['fob'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['term'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['sales'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['keterangan'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> <button class="lihatterminadm btn btn-primary btn-sm" data-toggle="modal" data-target="#mdllihatterminadm" data-idpjl="` + item['id_penjualan'] + `"><small>Lihat</small></button> </td>



                                </tr>
                        `)
                        no++;
                    })

                }
            });
            let url2 = url;
            url2 = url2 + pilihan;
            $('.exportlap').attr('href', url2);

        } else {

            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/pilihanTrans/') ?>",
                dataType: "JSON",
                success: function(response) {
                    let no = 1;
                    $.each(response, function(i, item) {
                        let dibayarkan = 0;

                        if (item['dibayarkan']) {
                            dibayarkan = item['dibayarkan'];
                        }

                        $('#tabeltrans').append(`
                            <tr>
                                    <td class="font-weight-normal" style="color: black; ">` + no + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['id_penjualan'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['total']) + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(dibayarkan) + `</td>
                                    <td class="font-weight-normal" style="color: black; ">` + item['name'] + ` </td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama_mesin'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['harga']) + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['jumlah_mesin'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nama_perusahaan'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['nomor_wa'] + `</td>
                                    <td class="font-weight-normal text-right" style="color: black; "> ` + formatRupiah(item['ongkir']) + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['ship_date'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['ship_via'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['fob'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['term'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['sales'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> ` + item['keterangan'] + `</td>
                                    <td class="font-weight-normal" style="color: black; "> <button class="lihatterminadm btn btn-primary btn-sm" data-toggle="modal" data-target="#mdllihatterminadm" data-idpjl="` + item['id_penjualan'] + `"><small>Lihat</small></button> </td>


                                </tr>
                        `)
                        no++;
                    })

                }
            });
            $('.exportlap').attr('href', url);

        }


    })
</script>

<script>
    $('#tabeltrans').on('click', '.lihatterminadm', function() {
        $idpjl = $(this).data('idpjl');
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/dataTermin/') ?>",
            data: {
                'idpjl': $idpjl
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                let no = 1;
                let gambar = "";

                $('#daftartermin').html('');
                $.each(response, function(i, item) {
                    if (item['gambar_transfer'] == '-') {
                        gambar = "pointer-events: none; cursor: default;"
                    }
                    $('#daftartermin').append(`
                            <tr>
                                <td>` + no + `</td>
                                <td>` + item['id_penjualan'] + `</td>
                                <td>` + item['nama'] + `</td>
                                <td>` + item['nama_perusahaan'] + `</td>
                                <td>` + item['tanggal'] + `</td>
                                <td>` + formatRupiah(item['jumlah']) + `</td>
                                <td><a href="<?= base_url('assets/img/bukti_pembayaran/') ?>` + item['gambar_transfer'] + `" target="_blank" style="` + gambar + `">` + item['gambar_transfer'] + `</a></td>
                                <td><a  class="btn btn-primary btn-sm" href="<?= base_url('admin/lihatTermin/') ?>` + item['id_penjualan'] + `/` + item['termin'] + `" target="_blank" >Lihat Termin</a></td>
                            </tr>
                    `);
                    no++;
                })

            }
        });
    })
</script>

<script>
    $('.list-notifikasi').on('click', '.lihatterminadm', function() {
        $idpjl = $(this).data('idpjl');
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/dataTermin/') ?>",
            data: {
                'idpjl': $idpjl
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                let no = 1;
                let gambar = "";

                $('#daftartermin').html('');
                $.each(response, function(i, item) {
                    if (item['gambar_transfer'] == '-') {
                        gambar = "pointer-events: none; cursor: default;"
                    }
                    $('#daftartermin').append(`
                            <tr>
                                <td>` + no + `</td>
                                <td>` + item['id_penjualan'] + `</td>
                                <td>` + item['nama'] + `</td>
                                <td>` + item['nama_perusahaan'] + `</td>
                                <td>` + item['tanggal'] + `</td>
                                <td>` + formatRupiah(item['jumlah']) + `</td>
                                <td><a href="<?= base_url('assets/img/bukti_pembayaran/') ?>` + item['gambar_transfer'] + `" target="_blank" style="` + gambar + `">` + item['gambar_transfer'] + `</a></td>
                                <td><a  class="btn btn-primary btn-sm" href="<?= base_url('admin/lihatTermin/') ?>` + item['id_penjualan'] + `/` + item['termin'] + `" target="_blank" >Lihat Termin</a></td>
                            </tr>
                    `);
                    no++;
                })

            }
        });
    })
</script>

<!-- fungsi di admin BPR Amira-->
<script>
// $('.detailPengajuanKredit').on('click', function() {
//         $id_pengajuan = $(this).data('id-pengajuan');
        
//         $.ajax({
//             type: "POST",
//             url: "<?= base_url('kredit/lihatDetailPengajuan/') ?>",
//             data: {
//                 'id_pengajuan': $id_pengajuan
//             },
//             dataType: "JSON",
//             success: function(response) {
//                 console.log(response);
//                 let no = 1;
//                 let gambar = "";

//                 // $('#daftartermin').html('');

//                 let url_jaminan = '<?= base_url('assets/img/pengajuan/')?>';

//                 $('#mdlDetailPengajuanKredit #name').attr('value', response['name']);
//                 $('#mdlDetailPengajuanKredit #email').attr('value', response['email']);
//                 $('#mdlDetailPengajuanKredit #jumlah_bunga_persen').attr('value', response['jumlah_bunga_persen']);
//                 $('#mdlDetailPengajuanKredit #total_angsuran_bulan').attr('value', response['total_angsuran_bulan']);
//                 $('#mdlDetailPengajuanKredit #nama_kredit').attr('value', response['nama_kredit']);
//                 $('#mdlDetailPengajuanKredit #foto_kk').attr('src', url_jaminan+response['foto_kk']);
//                 $('#mdlDetailPengajuanKredit #foto_ktp').attr('src', url_jaminan+response['foto_ktp']);
//                 $('#mdlDetailPengajuanKredit #foto_surat_jaminan').attr('src', url_jaminan+response['foto_surat_jaminan']);

//             }
//         });
//     })


// detail kredit active
$('.mdlDetailKredit').on('click', function() {
        $id_kredit = $(this).data('id-transaksi-kredit');
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('kredit/listKreditActiveDetail/') ?>",
            data: {
                'id_transaksi_kredit': $id_kredit
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                let no = 1;
                let gambar = "";


                $('#mdlDetailKreditActive #name').attr('value', response['name']);
                $('#mdlDetailKreditActive #nama_kredit').attr('value', response['nama_kredit']);
                $('#mdlDetailKreditActive #jumlah_bunga_persen').attr('value', response['jumlah_bunga_persen']);
                $('#mdlDetailKreditActive #jumlah_pinjaman').attr('value', formatRupiah(response['jumlah_pinjaman']));
                $('#mdlDetailKreditActive #tgl_pengajuan').attr('value', response['tgl_pengajuan']);
                $('#mdlDetailKreditActive #tgl_realisasi_kredit').attr('value', response['tgl_realisasi_kredit']);
                $('#mdlDetailKreditActive #keterangan_kredit').attr('value', response['keterangan_kredit']);
                $('#mdlDetailKreditActive #lunas').attr('value', response['lunas']);

            }
        });
})

// detail pengajuan kredit - Pelayanan
    $('.detailPlyKredit').on('click', function() {
        let id_pengajuan = $(this).data('id-pengajuan');
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('pelayanan/pengajuanKreditDetail/') ?>",
            data: {
                'id_pengajuan': id_pengajuan
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                let url_jaminan = '<?= base_url('assets/img/pengajuan/')?>';
                let url_nasabah = '<?= base_url('assets/img/nasabah/')?>';

                $('#mdldetailPengajuanKredit #id_nasabah_detail').attr('value', response['nasabah']['id_nasabah']+' - '+response['user']['name']);
                $('#mdldetailPengajuanKredit #email_detail').attr('value',response['user']['email']);
                $('#mdldetailPengajuanKredit #no_hp_detail').attr('value',response['nasabah']['no_hp']);
                $('#mdldetailPengajuanKredit #income_detail').attr('value',formatRupiah(response['nasabah']['income']));
                $('#mdldetailPengajuanKredit #pengeluaran_detail').attr('value',formatRupiah(response['nasabah']['pengeluaran']));
                $('#mdldetailPengajuanKredit #pendidikan_detail').val(response['nasabah']['pendidikan']).change();
                $('#mdldetailPengajuanKredit #pekerjaan_detail').attr('value',response['nasabah']['pekerjaan']);
                $('#mdldetailPengajuanKredit #no_ktp_detail').attr('value',response['nasabah']['no_ktp']);
                $('#mdldetailPengajuanKredit #alamat_ktp_detail').html(response['nasabah']['alamat_ktp']);
                $('#mdldetailPengajuanKredit #foto_ktp_detail').attr('src', url_nasabah + response['nasabah']['foto_ktp']);
                $('#mdldetailPengajuanKredit #foto_kk_detail').attr('src', url_nasabah + response['nasabah']['foto_kk']);
                $('#mdldetailPengajuanKredit #nama_ibu_kandung_detail').attr('value', response['nasabah']['nama_ibu_kandung']);
                $('#mdldetailPengajuanKredit #status_detail').val(response['nasabah']['status']).change();
                $('#mdldetailPengajuanKredit #id_jenis_kredit_detail').attr('value', response['pengajuan']['id_jenis_kredit']);
                $('#mdldetailPengajuanKredit #id_jenis_kredit_detail').val( response['pengajuan']['id_jenis_kredit']).change();
                $('#mdldetailPengajuanKredit #jumlah_pinjaman_detail').attr('value', formatRupiah(response['pengajuan']['jumlah_pinjaman']));
                $('#mdldetailPengajuanKredit #nomor_surat_kepemilikan_detail').attr('value', response['daftar_jaminan'][0]['nomor_surat_kepemilikan']);
                $('#mdldetailPengajuanKredit #dimiliki_tahun_detail').val( response['daftar_jaminan'][0]['dimiliki_tahun']).change();
                $('#mdldetailPengajuanKredit #atas_nama_detail').attr('value', response['daftar_jaminan'][0]['atas_nama']);
                $('#mdldetailPengajuanKredit #harga_beli_detail').attr('value', response['daftar_jaminan'][0]['harga_beli']);
                $('#mdldetailPengajuanKredit #diperoleh_dengan_detail').val( response['daftar_jaminan'][0]['diperoleh_dengan']).change();
                
                
                // navbar pilihan jaminan kendaraan/SHM
                $.each(response.daftar_jaminan, function(i,item){
                    
                    if(item.kode_jaminan != 'SHM/SHGB'){
                        // kendaraan
                        $('#inputjaminanshm_detail').attr('hidden', true)
                        $('#inputjaminankendaraan_detail').attr('hidden', false)

                        $('#suratshm_detail').attr('hidden', true)

                        $('#navshm_detail').removeClass('active').addClass('');
                        $('#navkendaraan_detail').removeClass('').addClass('active');
                        
                        // menghilangkan upload bpkb
                        $('#suratshm_detail').attr('hidden', true )
                        $('#suratkendaraan_detail').attr('hidden', false  )
                        
                        // mengganti label
                        $('#labelnomor_detail').html('Nomor BPKB')
                        $('#labelatasnama_detail').html('Atas Nama (BPKB)')

                        $('#id_jaminan_shm').attr('value','')

                        
                        $('#mdldetailPengajuanKredit #nama_kendaraan_detail').attr('value', item['nama_jaminan']);
                        $('#mdldetailPengajuanKredit #taksasi_detail').attr('value', formatRupiah(item['taksasi']));

                        
                        

                    }else{
                        // SHM

                        $('#inputjaminanshm_detail').attr('hidden', false)
                        $('#inputjaminankendaraan_detail').attr('hidden', true )

                        $('#suratkendaraan_detail').attr('hidden', true )
                        
                        $('#navkendaraan_detail').removeClass('active').addClass('');
                        $('#navshm_detail').removeClass('').addClass('active');

                        // menghilangkan upload bpkb
                        $('#suratshm_detail').attr('hidden', false)
                        $('#suratkendaraan_detail').attr('hidden', true )

                        // mengganti label
                        $('#labelnomor_detail').html('Nomor SHM/SHGB')
                        $('#labelatasnama_detail').html('Atas Nama (SHM/SHGB)')

                        $('#mdldetailPengajuanKredit #luastanah_detail').attr('value', item['luas_tanah']);
                        $('#mdldetailPengajuanKredit #taksasishm_detail').attr('value', formatRupiah(item['taksasi']));
                        $('#mdldetailPengajuanKredit #inputmaksshm_detail').attr('value', formatRupiah(item['taksasi']*item['luas_tanah']));
                    }
                })
                

                 $.each(response.daftar_jaminan, function(i, item){
                // console.log(item.nama_jaminan)
                        $("#mdldetailPengajuanKredit #daftar_foto_jaminan_detail").append(
                            `<div class="col-6 mb-2">              
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_jaminan+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                

                })


                $.each(response.daftar_surat_jaminan, function(i, item){
                // console.log(item.nama_jaminan)
                if(item.nama_surat == 'BPKB'){
                    console.log(item.nama_surat)
                        $("#mdldetailPengajuanKredit #daftar_foto_bpkb_detail").append(
                            `<div class="col-6 mb-2">
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                }else if(item.nama_surat == 'STNK'){
                    $("#mdldetailPengajuanKredit #daftar_foto_stnk_detail").append(
                            `<div class="col-6 mb-2">
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }else if(item.nama_surat == "SHM/SHGB" ){
                    $("#mdldetailPengajuanKredit #daftar_foto_shm_detail").append(
                            `<div class="col-6 mb-2">
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }


            })

           

            }
        });
    })

// detail pengajuan kredit - Kredit
    $('.detailPengajuanKredit').on('click', function() {
        let id_pengajuan = $(this).data('id-pengajuan');
        let id_nasabah = $(this).data('id-nasabah');
        
        $.ajax({
            type: "POST",
            url: "<?= base_url('kredit/pengajuanKreditDetail/') ?>",
            data: {
                'id_pengajuan': id_pengajuan,
                'id_nasabah': id_nasabah,
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                let url_jaminan = '<?= base_url('assets/img/pengajuan/')?>';
                let url_nasabah = '<?= base_url('assets/img/nasabah/')?>';

                $('#mdldetailPengajuanKredit #id_nasabah_detail').attr('value', response['nasabah']['id_nasabah']+' - '+response['user']['name']);
                $('#mdldetailPengajuanKredit #email_detail').attr('value',response['user']['email']);
                $('#mdldetailPengajuanKredit #no_hp_detail').attr('value',response['nasabah']['no_hp']);
                $('#mdldetailPengajuanKredit #income_detail').attr('value',formatRupiah(response['nasabah']['income']));
                $('#mdldetailPengajuanKredit #pengeluaran_detail').attr('value',formatRupiah(response['nasabah']['pengeluaran']));
                $('#mdldetailPengajuanKredit #pendidikan_detail').val(response['nasabah']['pendidikan']).change();
                $('#mdldetailPengajuanKredit #pekerjaan_detail').attr('value',response['nasabah']['pekerjaan']);
                $('#mdldetailPengajuanKredit #no_ktp_detail').attr('value',response['nasabah']['no_ktp']);
                $('#mdldetailPengajuanKredit #alamat_ktp_detail').html(response['nasabah']['alamat_ktp']);
                $('#mdldetailPengajuanKredit #foto_ktp_detail').attr('src', url_nasabah + response['nasabah']['foto_ktp']);
                $('#mdldetailPengajuanKredit #foto_kk_detail').attr('src', url_nasabah + response['nasabah']['foto_kk']);
                $('#mdldetailPengajuanKredit #nama_ibu_kandung_detail').attr('value', response['nasabah']['nama_ibu_kandung']);
                $('#mdldetailPengajuanKredit #status_detail').val(response['nasabah']['status']).change();
                $('#mdldetailPengajuanKredit #id_jenis_kredit_detail').attr('value', response['pengajuan']['id_jenis_kredit']);
                $('#mdldetailPengajuanKredit #id_jenis_kredit_detail').val( response['pengajuan']['id_jenis_kredit']).change();
                $('#mdldetailPengajuanKredit #jumlah_pinjaman_detail').attr('value', formatRupiah(response['pengajuan']['jumlah_pinjaman']));
                $('#mdldetailPengajuanKredit #nomor_surat_kepemilikan_detail').attr('value', response['daftar_jaminan'][0]['nomor_surat_kepemilikan']);
                $('#mdldetailPengajuanKredit #dimiliki_tahun_detail').val( response['daftar_jaminan'][0]['dimiliki_tahun']).change();
                $('#mdldetailPengajuanKredit #atas_nama_detail').attr('value', response['daftar_jaminan'][0]['atas_nama']);
                $('#mdldetailPengajuanKredit #harga_beli_detail').attr('value', response['daftar_jaminan'][0]['harga_beli']);
                $('#mdldetailPengajuanKredit #diperoleh_dengan_detail').val( response['daftar_jaminan'][0]['diperoleh_dengan']).change();
                
                
                // navbar pilihan jaminan kendaraan/SHM
                $.each(response.daftar_jaminan, function(i,item){
                    
                    if(item.kode_jaminan != 'SHM/SHGB'){
                        // kendaraan
                        $('#inputjaminanshm_detail').attr('hidden', true)
                        $('#inputjaminankendaraan_detail').attr('hidden', false)

                        $('#suratshm_detail').attr('hidden', true)

                        $('#navshm_detail').removeClass('active').addClass('');
                        $('#navkendaraan_detail').removeClass('').addClass('active');
                        
                        // menghilangkan upload bpkb
                        $('#suratshm_detail').attr('hidden', true )
                        $('#suratkendaraan_detail').attr('hidden', false  )
                        
                        // mengganti label
                        $('#labelnomor_detail').html('Nomor BPKB')
                        $('#labelatasnama_detail').html('Atas Nama (BPKB)')

                        $('#id_jaminan_shm').attr('value','')

                        
                        $('#mdldetailPengajuanKredit #nama_kendaraan_detail').attr('value', item['nama_jaminan']);
                        $('#mdldetailPengajuanKredit #taksasi_detail').attr('value', formatRupiah(item['taksasi']));

                        
                        

                    }else{
                        // SHM

                        $('#inputjaminanshm_detail').attr('hidden', false)
                        $('#inputjaminankendaraan_detail').attr('hidden', true )

                        $('#suratkendaraan_detail').attr('hidden', true )
                        
                        $('#navkendaraan_detail').removeClass('active').addClass('');
                        $('#navshm_detail').removeClass('').addClass('active');

                        // menghilangkan upload bpkb
                        $('#suratshm_detail').attr('hidden', false)
                        $('#suratkendaraan_detail').attr('hidden', true )

                        // mengganti label
                        $('#labelnomor_detail').html('Nomor SHM/SHGB')
                        $('#labelatasnama_detail').html('Atas Nama (SHM/SHGB)')

                        $('#mdldetailPengajuanKredit #luastanah_detail').attr('value', item['luas_tanah']);
                        $('#mdldetailPengajuanKredit #taksasishm_detail').attr('value', formatRupiah(item['taksasi']));
                        $('#mdldetailPengajuanKredit #inputmaksshm_detail').attr('value', formatRupiah(item['taksasi']*item['luas_tanah']));
                    }
                })
                

                 $.each(response.daftar_jaminan, function(i, item){
                // console.log(item.nama_jaminan)
                        $("#mdldetailPengajuanKredit #daftar_foto_jaminan_detail").append(
                            `<div class="col-6 mb-2">              
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_jaminan+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                

                })


                $.each(response.daftar_surat_jaminan, function(i, item){
                // console.log(item.nama_jaminan)
                if(item.nama_surat == 'BPKB'){
                    console.log(item.nama_surat)
                        $("#mdldetailPengajuanKredit #daftar_foto_bpkb_detail").append(
                            `<div class="col-6 mb-2">
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );

                }else if(item.nama_surat == 'STNK'){
                    $("#mdldetailPengajuanKredit #daftar_foto_stnk_detail").append(
                            `<div class="col-6 mb-2">
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }else if(item.nama_surat == "SHM/SHGB" ){
                    $("#mdldetailPengajuanKredit #daftar_foto_shm_detail").append(
                            `<div class="col-6 mb-2">
                                <img src="<?= base_url('assets/img/pengajuan/')?>`+item.foto_surat+`" class="mx-auto img-fluid" alt="...">
                            </div> `

                        );
                }


            })

           

            }
        });
    })

      
                                                   
// bayar angsuran dari nasabah
    $('.byrAngsuran').on('click', function() {
        $('#mdlBayarAngsuran #id_transaksi_kredit').attr('value', $(this).data('id-transaksi-kredit'));
        console.log($(this).data('id-transaksi-kredit'));

        $.ajax({
            type: "POST",
            url: "<?= base_url('pelayanan/getDataModalPembayaran') ?>",
            data: {
                'id_transaksi_kredit': $(this).data('id-transaksi-kredit')
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                
                let angsuran = response['angsuran'];
                let kredit = response['kredit'];
                let detailangsuran = response['detailangsuran'];

                // htmlFormAngsuran

                if(angsuran['keterangan_angsuran_terakhir'] === "0"){

                    $('#mdlBayarAngsuran #htmlFormAngsuran').html('');
                    $('#mdlBayarAngsuran #htmlFormAngsuran').html(`<div class="col text-center my-5 ">
                                                                            <div class="alert alert-primary mw-75" role="alert" >
                                                                                <span for="id_transaksi_kredit" class="text-center text-dark">Mohon tunggu, Angsuran anda sedang di proses.</span>
                                                                            </div>                                                
                                                                </div>`);

                    $('#mdlBayarAngsuran #htmlFormAngsuran').append(`<div class="form-group row px-3 justify-content-end">
                                        <div class="col-sm-8 text-right" id="footertambahangsuran">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>`);
                                            
                                            
                                            $('#mdlBayarAngsuran #mdlnama').html(kredit['name']);
                                            $('#mdlBayarAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                                            $('#mdlBayarAngsuran #notlp').html(kredit['no_hp']);
                                            $('#mdlBayarAngsuran #mdlnamakredit').html(kredit['nama_kredit']);

                                            $('#mdlBayarAngsuran #mdlangsuran').html('')
                                            $.each(detailangsuran.angsuran, function(i,item){
                                                $('#mdlBayarAngsuran #mdlangsuran').append(item+'</br>');
                                                
                                            })

                                            $('#mdlBayarAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                                            $('#mdlBayarAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                                            $('#mdlBayarAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                                            $('#mdlBayarAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                                            $('#mdlBayarAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                                            $('#mdlBayarAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                                            // $('#mdlBayarAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                                            // $('#mdlBayarAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                                            $('#mdlBayarAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                                            $('#mdlBayarAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                                            $('#mdlBayarAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                                            $('#mdlBayarAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);
                    }else{

                    $('#mdlBayarAngsuran #mdlnama').html(kredit['name']);
                    $('#mdlBayarAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                    $('#mdlBayarAngsuran #notlp').html(kredit['no_hp']);
                    $('#mdlBayarAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    
                    $('#mdlBayarAngsuran #mdlangsuran').html('')
                    $.each(detailangsuran.angsuran, function(i,item){
                        $('#mdlBayarAngsuran #mdlangsuran').append(item+'</br>');
                        
                    })

                    $('#mdlBayarAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                    $('#mdlBayarAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                    $('#mdlBayarAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    $('#mdlBayarAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                    $('#mdlBayarAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                    $('#mdlBayarAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                    // $('#mdlBayarAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    // $('#mdlBayarAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    $('#mdlBayarAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    $('#mdlBayarAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    $('#mdlBayarAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    $('#mdlBayarAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);


                    
                    // $('#mdlBayarAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    // $('#mdlBayarAngsuran #mdljumlahpinjaman').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    // $('#mdlBayarAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    // $('#mdlBayarAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    // $('#mdlBayarAngsuran #mdlbungaperbulan').html(formatRupiah(angsuran['jumlah_bunga_angsuran']) );
                    // $('#mdlBayarAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    // $('#mdlBayarAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    // $('#mdlBayarAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    
                    
                    $('#mdlBayarAngsuran #tgl_mengangsur').attr('value', angsuran['tgl_mengangsur']);
                    $('#mdlBayarAngsuran #jumlah_pokok_angsuran').attr('value', angsuran['jumlah_pokok_angsuran']) ;
                    $('#mdlBayarAngsuran #status_keterlambatan').attr('value', angsuran['status_keterlambatan']);
                    $('#mdlBayarAngsuran #tgl_jatuh_tempo').attr('value', angsuran['tgl_jatuh_tempo']);
                    $('#mdlBayarAngsuran #jumlah_bunga_angsuran').attr('value', angsuran['jumlah_bunga_angsuran'] );
                    $('#mdlBayarAngsuran #dendaperhari').attr('value', angsuran['denda_perhari']) ;
                    $('#mdlBayarAngsuran #keterlambatanhari').attr('value', angsuran['jumlah_keterlambatan_hari']);
                    $('#mdlBayarAngsuran #denda_total').attr('value', angsuran['denda_total']) ;
                    $('#mdlBayarAngsuran #jumlah_total_angsuran').attr('value', formatRupiah(angsuran['jumlah_total_angsuran']) );
                
                }

            }
        });
    })


// bayar edit angsuran dari nasabah
    $('.editangs').on('click', function() {
        $('#mdlEditAngsuran #id_transaksi_kredit').attr('value', $(this).data('id_transaksi_kredit'));
        $('#mdlEditAngsuran #id_angsuran').attr('value', $(this).data('id_angsuran'));
        console.log($(this).data('id_transaksi_kredit'));

        $.ajax({
            type: "POST",
            url: "<?= base_url('pelayanan/getDataModalPembayaran') ?>",
            data: {
                'id_transaksi_kredit': $(this).data('id_transaksi_kredit'),
                'id_angsuran': $(this).data('id_angsuran'),

            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                
                let angsuran = response['angsuran'];
                let angsuran_for_edit = response['angsuran_for_edit'];
                let kredit = response['kredit'];
                let detailangsuran = response['detailangsuran'];

                // htmlFormAngsuran

                if(angsuran_for_edit['keterangan_angsuran'] === "1" || angsuran_for_edit['keterangan_angsuran'] === "2"){

                    $('#mdlEditAngsuran #htmlFormAngsuran').html('');
                    $('#mdlEditAngsuran #htmlFormAngsuran').html(`<div class="col text-center my-5 ">
                                                                            <div class="alert alert-warning mw-75" role="alert" >
                                                                                <span for="id_transaksi_kredit" class="text-center text-dark">Maaf, Angsuran sudah tidak dapat diubah.</span>
                                                                            </div>                                                
                                                                </div>`);

                    $('#mdlEditAngsuran #htmlFormAngsuran').append(`<div class="form-group row px-3 justify-content-end">
                                        <div class="col-sm-8 text-right" id="footertambahangsuran">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>`);
                                            
                                            
                                            $('#mdlEditAngsuran #mdlnama').html(kredit['name']);
                                            $('#mdlEditAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                                            $('#mdlEditAngsuran #notlp').html(kredit['no_hp']);
                                            $('#mdlEditAngsuran #mdlnamakredit').html(kredit['nama_kredit']);

                                            $('#mdlEditAngsuran #mdlangsuran').html('')
                                            $.each(detailangsuran.angsuran, function(i,item){
                                                $('#mdlEditAngsuran #mdlangsuran').append(item+'</br>');
                                                
                                            })

                                            $('#mdlEditAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                                            $('#mdlEditAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                                            $('#mdlEditAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                                            $('#mdlEditAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                                            $('#mdlEditAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                                            $('#mdlEditAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                                            // $('#mdlEditAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                                            // $('#mdlEditAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                                            $('#mdlEditAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                                            $('#mdlEditAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                                            $('#mdlEditAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                                            $('#mdlEditAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);
                }else{

                    $('#mdlEditAngsuran #mdlnama').html(kredit['name']);
                    $('#mdlEditAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                    $('#mdlEditAngsuran #notlp').html(kredit['no_hp']);
                    $('#mdlEditAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    
                    $('#mdlEditAngsuran #mdlangsuran').html('')
                    $.each(detailangsuran.angsuran, function(i,item){
                        $('#mdlEditAngsuran #mdlangsuran').append(item+'</br>');
                        
                    })

                    $('#mdlEditAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                    $('#mdlEditAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                    $('#mdlEditAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    $('#mdlEditAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                    $('#mdlEditAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                    $('#mdlEditAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                    // $('#mdlEditAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    // $('#mdlEditAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    $('#mdlEditAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    $('#mdlEditAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    $('#mdlEditAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    $('#mdlEditAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);


                    
                    // $('#mdlEditAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    // $('#mdlEditAngsuran #mdljumlahpinjaman').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    // $('#mdlEditAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    // $('#mdlEditAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    // $('#mdlEditAngsuran #mdlbungaperbulan').html(formatRupiah(angsuran['jumlah_bunga_angsuran']) );
                    // $('#mdlEditAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    // $('#mdlEditAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    // $('#mdlEditAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    
                    
                    $('#mdlEditAngsuran #tgl_mengangsur').attr('value', angsuran_for_edit['tanggal']);
                    $('#mdlEditAngsuran #jumlah_pokok_angsuran').attr('value', parseInt(angsuran_for_edit['jumlah_pokok'])) ;
                    $('#mdlEditAngsuran #status_keterlambatan').attr('value', angsuran_for_edit['status_keterlambatan']);
                    $('#mdlEditAngsuran #tgl_jatuh_tempo').attr('value', angsuran_for_edit['tgl_jatuh_tempo']);
                    $('#mdlEditAngsuran #jumlah_bunga_angsuran').attr('value', parseInt(angsuran_for_edit['jumlah_bunga']) );
                    $('#mdlEditAngsuran #dendaperhari').attr('value', angsuran['denda_perhari']) ;
                    $('#mdlEditAngsuran #keterlambatanhari').attr('value', angsuran_for_edit['jumlah_keterlambatan_hari']);
                    $('#mdlEditAngsuran #denda_total').attr('value', parseInt(angsuran_for_edit['denda'])) ;
                    $('#mdlEditAngsuran #jumlah_total_angsuran').attr('value', formatRupiah(parseInt(angsuran_for_edit['jumlah_pokok'])+parseInt(angsuran_for_edit['jumlah_bunga'])+parseInt(angsuran_for_edit['denda'])) );
                    $('#mdlEditAngsuran #bukti_trans_edit').attr('src', '<?= base_url('assets/img/angsuran/')?>'+angsuran_for_edit['bukti_angsuran'] );
                
                }

            }
        });
    })
// bayar detail angsuran dari nasabah
    $('.detailangs').on('click', function() {
        $('#mdlDetailAngsuran #id_transaksi_kredit').attr('value', $(this).data('id_transaksi_kredit'));
        $('#mdlDetailAngsuran #id_angsuran').attr('value', $(this).data('id_angsuran'));
        console.log($(this).data('id_transaksi_kredit'));

        $.ajax({
            type: "POST",
            url: "<?= base_url('pelayanan/getDataModalPembayaran') ?>",
            data: {
                'id_transaksi_kredit': $(this).data('id_transaksi_kredit'),
                'id_angsuran': $(this).data('id_angsuran'),

            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                
                let angsuran = response['angsuran'];
                let angsuran_for_edit = response['angsuran_for_edit'];
                let kredit = response['kredit'];
                let detailangsuran = response['detailangsuran'];

                // htmlFormAngsuran

                if(angsuran_for_edit['keterangan_angsuran'] === "1" || angsuran_for_edit['keterangan_angsuran'] === "2"){

                    $('#mdlDetailAngsuran #mdlnama').html(kredit['name']);
                    $('#mdlDetailAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                    $('#mdlDetailAngsuran #notlp').html(kredit['no_hp']);
                    $('#mdlDetailAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    
                    $('#mdlDetailAngsuran #mdlangsuran').html('')
                    $.each(detailangsuran.angsuran, function(i,item){
                        $('#mdlDetailAngsuran #mdlangsuran').append(item+'</br>');
                        
                    })

                    $('#mdlDetailAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                    $('#mdlDetailAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                    $('#mdlDetailAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    $('#mdlDetailAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                    $('#mdlDetailAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                    $('#mdlDetailAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                    // $('#mdlDetailAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    // $('#mdlDetailAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    $('#mdlDetailAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    $('#mdlDetailAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    $('#mdlDetailAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    $('#mdlDetailAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);


                    
                    // $('#mdlDetailAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    // $('#mdlDetailAngsuran #mdljumlahpinjaman').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    // $('#mdlDetailAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    // $('#mdlDetailAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    // $('#mdlDetailAngsuran #mdlbungaperbulan').html(formatRupiah(angsuran['jumlah_bunga_angsuran']) );
                    // $('#mdlDetailAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    // $('#mdlDetailAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    // $('#mdlDetailAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    
                    
                    $('#mdlDetailAngsuran #tgl_mengangsur').attr('value', angsuran_for_edit['tanggal']);
                    $('#mdlDetailAngsuran #jumlah_pokok_angsuran').attr('value', parseInt(angsuran_for_edit['jumlah_pokok'])) ;
                    $('#mdlDetailAngsuran #status_keterlambatan').attr('value', angsuran_for_edit['status_keterlambatan']);
                    $('#mdlDetailAngsuran #tgl_jatuh_tempo').attr('value', angsuran_for_edit['tgl_jatuh_tempo']);
                    $('#mdlDetailAngsuran #jumlah_bunga_angsuran').attr('value', parseInt(angsuran_for_edit['jumlah_bunga']) );
                    $('#mdlDetailAngsuran #dendaperhari').attr('value', angsuran['denda_perhari']) ;
                    $('#mdlDetailAngsuran #keterlambatanhari').attr('value', angsuran_for_edit['jumlah_keterlambatan_hari']);
                    $('#mdlDetailAngsuran #denda_total').attr('value', parseInt(angsuran_for_edit['denda'])) ;
                    $('#mdlDetailAngsuran #jumlah_total_angsuran').attr('value', formatRupiah(parseInt(angsuran_for_edit['jumlah_pokok'])+parseInt(angsuran_for_edit['jumlah_bunga'])+parseInt(angsuran_for_edit['denda'])) );
                    $('#mdlDetailAngsuran #bukti_trans_edit').attr('src', '<?= base_url('assets/img/angsuran/')?>'+angsuran_for_edit['bukti_angsuran'] );
                
                }

            }
        });
    })
    
// bayar detail angsuran dari nasabah (ADMIN)
    $('.detailangsadmin').on('click', function() {
        $('#mdlDetailAngsuran #id_transaksi_kredit').attr('value', $(this).data('id_transaksi_kredit'));
        $('#mdlDetailAngsuran #id_angsuran').attr('value', $(this).data('id_angsuran'));
        console.log($(this).data('id_transaksi_kredit'));

        $.ajax({
            type: "POST",
            url: "<?= base_url('kredit/getDataModalPembayaran') ?>",
            data: {
                'id_transaksi_kredit': $(this).data('id_transaksi_kredit'),
                'id_angsuran': $(this).data('id_angsuran'),

            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                
                let angsuran = response['angsuran'];
                let angsuran_for_edit = response['angsuran_for_edit'];
                let kredit = response['kredit'];
                let detailangsuran = response['detailangsuran'];

                // htmlFormAngsuran

                if(angsuran_for_edit['keterangan_angsuran'] === "1" || angsuran_for_edit['keterangan_angsuran'] === "2" || angsuran_for_edit['keterangan_angsuran'] === "0"){

                    $('#mdlDetailAngsuran #mdlnama').html(kredit['name']);
                    $('#mdlDetailAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                    $('#mdlDetailAngsuran #notlp').html(kredit['no_hp']);
                    $('#mdlDetailAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    
                    $('#mdlDetailAngsuran #mdlangsuran').html('')
                    $.each(detailangsuran.angsuran, function(i,item){
                        $('#mdlDetailAngsuran #mdlangsuran').append(item+'</br>');
                        
                    })

                    $('#mdlDetailAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                    $('#mdlDetailAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                    $('#mdlDetailAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    $('#mdlDetailAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                    $('#mdlDetailAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                    $('#mdlDetailAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                    // $('#mdlDetailAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    // $('#mdlDetailAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    $('#mdlDetailAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    $('#mdlDetailAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    $('#mdlDetailAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    $('#mdlDetailAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);


                    
                    // $('#mdlDetailAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    // $('#mdlDetailAngsuran #mdljumlahpinjaman').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    // $('#mdlDetailAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    // $('#mdlDetailAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    // $('#mdlDetailAngsuran #mdlbungaperbulan').html(formatRupiah(angsuran['jumlah_bunga_angsuran']) );
                    // $('#mdlDetailAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    // $('#mdlDetailAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    // $('#mdlDetailAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    
                    
                    $('#mdlDetailAngsuran #tgl_mengangsur').attr('value', angsuran_for_edit['tanggal']);
                    $('#mdlDetailAngsuran #jumlah_pokok_angsuran').attr('value', parseInt(angsuran_for_edit['jumlah_pokok'])) ;
                    $('#mdlDetailAngsuran #status_keterlambatan').attr('value', angsuran_for_edit['status_keterlambatan']);
                    $('#mdlDetailAngsuran #tgl_jatuh_tempo').attr('value', angsuran_for_edit['tgl_jatuh_tempo']);
                    $('#mdlDetailAngsuran #jumlah_bunga_angsuran').attr('value', parseInt(angsuran_for_edit['jumlah_bunga']) );
                    $('#mdlDetailAngsuran #dendaperhari').attr('value', angsuran['denda_perhari']) ;
                    $('#mdlDetailAngsuran #keterlambatanhari').attr('value', angsuran_for_edit['jumlah_keterlambatan_hari']);
                    $('#mdlDetailAngsuran #denda_total').attr('value', parseInt(angsuran_for_edit['denda'])) ;
                    $('#mdlDetailAngsuran #jumlah_total_angsuran').attr('value', formatRupiah(parseInt(angsuran_for_edit['jumlah_pokok'])+parseInt(angsuran_for_edit['jumlah_bunga'])+parseInt(angsuran_for_edit['denda'])) );
                    $('#mdlDetailAngsuran #bukti_trans_edit').attr('src', '<?= base_url('assets/img/angsuran/')?>'+angsuran_for_edit['bukti_angsuran'] );
                
                }

            }
        });
    })


    $('.mdlDeletePromo').on('click', function() {
       $('#mdlDeletePromo #id_penawaran').attr('value',$(this).data('id-penawaran') );
    })
    
    $('#btncarikredit').on('click', function() {
        let id_nasabah = $('#id_nasabah_select').val();
        // let $id_nasabah = $('#mdlTambahAngs #id_nasabah').find(":selected").val();
        console.log(id_nasabah);

        $.ajax({
            type: "POST",
            url: "<?= base_url('kredit/carikredit/') ?>",
            data: {
                'id_nasabah': id_nasabah
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                //looping ke daftar keranjang 
                $('.modal-footer #daftarkredit').html('');

                    $.each(response, function(i, item) {

                        let buttontext = '';

                        if(item['lunas']== "0")
                        {
                            buttontext = `<div class="row justify-content-end"><button class="bayarangs col-3 btn btn-success btn-block" data-toggle="modal" data-target="#mdlBayarAngsuran" 
                                            data-id-transaksi="`+item['id_transaksi_kredit']+`">Bayar</button></div>`
                        }else{
                            buttontext = `<div class="alert alert-success" role="alert">
                                                Credit already finished.
                                            </div>`
                        }

                        $('.modal-footer #daftarkredit').append(`
                                                         <div class="card border-success mb-3">
                                                            <div class="card-header bg-success border-success"><span class="text-light">`+item['name']+`</span></div>
                                                                <div class="card-body text-success">
                                                                    <h3 class="text-dark text-center">`+item['nama_kredit']+`</h3>
                                                                    <p class="text-dark">Id Transaksi: `+item['id_transaksi_kredit']+`</p>
                                                                    <p class="text-dark">Id Pengajuan: `+item['id_pengajuan']+`</p>
                                                                    <p class="text-dark">Total Pinjaman: `+item['jumlah_pinjaman']+`</p>
                                                                </div>
                                                            <div class="card-footer bg-transparent border-success ">`+buttontext+`</div>
                                                        </div>`);

                    });
            }
        });
    }) 


    // bayar angsuran kredit didalam admin (kredit menu) 
    $('#daftarkredit').on('click','.bayarangs', function() {
        $('#mdlBayarAngsuran #id_transaksi_kredit').attr('value', $(this).data('id-transaksi'));
        console.log($(this).data('id-transaksi'));

        $.ajax({
            type: "POST",
            url: "<?= base_url('kredit/getDataModalPembayaran') ?>",
            data: {
                'id_transaksi_kredit': $(this).data('id-transaksi')
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                
                let angsuran = response['angsuran'];
                let kredit = response['kredit'];
                let detailangsuran = response['detailangsuran'];

                // htmlFormAngsuran

                if(angsuran['keterangan_angsuran_terakhir'] === "0"){

                    $('#mdlBayarAngsuran #htmlFormAngsuran').html('');
                    $('#mdlBayarAngsuran #htmlFormAngsuran').html(`<div class="col text-center my-5 ">
                                                                            <div class="alert alert-primary mw-75" role="alert" >
                                                                                <span for="id_transaksi_kredit" class="text-center text-dark">Angsuran belum selesai dikonfirmasi.</span>
                                                                            </div>                                                
                                                                </div>`);
                    $('#mdlBayarAngsuran #htmlFormAngsuran').append(`<div class="form-group row px-3 justify-content-end">
                                        <div class="col-sm-8 text-right" id="footertambahangsuran">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#formtambahangsuran')[0].reset();">Close</button>
                                        </div>
                                    </div>`);
                                            
                                            
                                            $('#mdlBayarAngsuran #mdlnama').html(kredit['name']);
                                            $('#mdlBayarAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                                            $('#mdlBayarAngsuran #notlp').html(kredit['no_hp']);
                                            $('#mdlBayarAngsuran #mdlnamakredit').html(kredit['nama_kredit']);

                                            $('#mdlBayarAngsuran #mdlangsuran').html('')
                                            $.each(detailangsuran.angsuran, function(i,item){
                                                $('#mdlBayarAngsuran #mdlangsuran').append(item+'</br>');
                                                
                                            })

                                            $('#mdlBayarAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                                            $('#mdlBayarAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                                            $('#mdlBayarAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                                            $('#mdlBayarAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                                            $('#mdlBayarAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                                            $('#mdlBayarAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                                            // $('#mdlBayarAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                                            // $('#mdlBayarAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                                            $('#mdlBayarAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                                            $('#mdlBayarAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                                            $('#mdlBayarAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                                            $('#mdlBayarAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);
                    }else{

                    $('#mdlBayarAngsuran #mdlnama').html(kredit['name']);
                    $('#mdlBayarAngsuran #mdlalamat').html(kredit['alamat_ktp']);
                    $('#mdlBayarAngsuran #notlp').html(kredit['no_hp']);
                    $('#mdlBayarAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    
                    $('#mdlBayarAngsuran #mdlangsuran').html('')
                    $.each(detailangsuran.angsuran, function(i,item){
                        $('#mdlBayarAngsuran #mdlangsuran').append(item+'</br>');
                        
                    })

                    $('#mdlBayarAngsuran #mdlmulaitanggal').html(detailangsuran['mulaitanggalangs'] );
                    $('#mdlBayarAngsuran #mdlnokredit').html(kredit['id_transaksi_kredit'] );
                    $('#mdlBayarAngsuran #mdlpokokpinjamn').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    $('#mdlBayarAngsuran #mdltotalbunga').html("Rp "+detailangsuran['bunga'] );
                    $('#mdlBayarAngsuran #mdltotalpinjaman').html("Rp "+detailangsuran['totalpinjaman'] );
                    $('#mdlBayarAngsuran #mdldendaperhari').html(formatRupiah(angsuran['denda_perhari']) );
                    // $('#mdlBayarAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    // $('#mdlBayarAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    $('#mdlBayarAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    $('#mdlBayarAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    $('#mdlBayarAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    $('#mdlBayarAngsuran #mdlangsuranke').html(angsuran['angsuran_ke']);


                    
                    // $('#mdlBayarAngsuran #mdlnamakredit').html(kredit['nama_kredit']);
                    // $('#mdlBayarAngsuran #mdljumlahpinjaman').html(formatRupiah(kredit['jumlah_pinjaman']) );
                    // $('#mdlBayarAngsuran #mdltgl_realisasi_kredit').html(kredit['tgl_realisasi_kredit']);
                    // $('#mdlBayarAngsuran #mdljatuhtempo').html(angsuran['tgl_jatuh_tempo']);
                    // $('#mdlBayarAngsuran #mdlbungaperbulan').html(formatRupiah(angsuran['jumlah_bunga_angsuran']) );
                    // $('#mdlBayarAngsuran #mdltgl_pengajuan').html(kredit['tgl_pengajuan'] );
                    // $('#mdlBayarAngsuran #mdldenda').html(formatRupiah( angsuran['denda_total']));
                    // $('#mdlBayarAngsuran #mdljumlah_keterlambatan_hari').html(angsuran['jumlah_keterlambatan_hari']);
                    
                    
                    $('#mdlBayarAngsuran #tgl_mengangsur').attr('value', angsuran['tgl_mengangsur']);
                    $('#mdlBayarAngsuran #jumlah_pokok_angsuran').attr('value', angsuran['jumlah_pokok_angsuran']) ;
                    $('#mdlBayarAngsuran #status_keterlambatan').attr('value', angsuran['status_keterlambatan']);
                    $('#mdlBayarAngsuran #tgl_jatuh_tempo').attr('value', angsuran['tgl_jatuh_tempo']);
                    $('#mdlBayarAngsuran #jumlah_bunga_angsuran').attr('value', angsuran['jumlah_bunga_angsuran'] );
                    $('#mdlBayarAngsuran #dendaperhari').attr('value', angsuran['denda_perhari']) ;
                    $('#mdlBayarAngsuran #keterlambatanhari').attr('value', angsuran['jumlah_keterlambatan_hari']);
                    $('#mdlBayarAngsuran #denda_total').attr('value', angsuran['denda_total']) ;
                    $('#mdlBayarAngsuran #jumlah_total_angsuran').attr('value', formatRupiah(angsuran['jumlah_total_angsuran']) );
                
                }

            }
        });
    })


    $(document).ready(function(){
        // let elementSuami= $("#data_pasangan").html();
        let elementSuami= `
            <div class="card">
                    <div class="card-header">
                        Data Suami/Istri
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_pasangan" name="nama_pasangan" value="<?php if(isset($nasabah['nama_pasangan'])){ echo ($nasabah['nama_pasangan']);}  ?>">
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
                                <input type="text" class="form-control" id="pekerjaan_pasangan" name="pekerjaan_pasangan" value="<?php if(isset($nasabah['pekerjaan_pasangan'])){ echo ($nasabah['pekerjaan_pasangan']);}  ?>">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('pekerjaan_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">NIK Suami/Istri</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_ktp_pasangan" name="no_ktp_pasangan" value="<?php if(isset($nasabah['no_ktp_pasangan'])){ echo ($nasabah['no_ktp_pasangan']);}  ?>">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('no_ktp_pasangan', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Foto KTP Suami/Istri</div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="<?php if(isset($nasabah['foto_ktp_pasangan'])){ echo (base_url('assets/img/nasabah/') . $nasabah['foto_ktp_pasangan']);}  ?>" class="img-thumbnail">

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
                                <input type="text" class="form-control" id="jumlah_anak" name="jumlah_anak" value="<?php if(isset($nasabah['jumlah_anak'])){ echo ($nasabah['jumlah_anak']);}else{echo '0';}  ?>">
                                <!-- menampilkan pesan eror -->
                                <?= form_error('jumlah_anak', '<div><small class="text-danger pl-3">', '</small></div>') ?>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">Foto Buku Nikah</div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="<?php if(isset($nasabah['foto_buku_nikah'])){ echo (base_url('assets/img/nasabah/') . $nasabah['foto_buku_nikah']);}  ?>" class="img-thumbnail">

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
        
        `;


        $("#status").change(function(){

            if($(this).val() == 'Menikah'){
                $("#data_pasangan").html(elementSuami)
            }else if($(this).val() == 'Belum Menikah'){
                // menghilangkan isi elemen html
                $("#data_pasangan").html('');
                // $("#data_pasangan").empty();
            }
        });
        
        $("#statusAdm").change(function(){

            if($(this).val() == 'Menikah'){
                $("#data_pasangan").attr('hidden', false)
            }else if($(this).val() == 'Belum Menikah'){
                // menghilangkan isi elemen attr('hidden', true)
                $("#data_pasangan").attr('hidden', true)
                // $("#data_pasangan").empty();
            }
        });

        // 
        // 
        // 
        // tambah data pengajuan kredit (pelayanan/pengajuankredit)
        // tambah data pengajuan kredit(PROMO) (pelayanan/promokredit)
        // 
        // 
        // 

        // 
        // promo kredit disini
        // 

        // cari promo kredit
        function getdatapromo(id_history) {  
            $.ajax({
                type: "POST",
                url: "<?= base_url('pelayanan/getdatapromo')?>",
                data: {
                    'id_history':id_history
                },
                dataType: "JSON",
                success: function (response) {
                    prosesresponpromo(response)
                }
            });
        }

        $(document).ready(function () {
            
            $("#dftrkendaraantbl").attr("hidden",true);

            let akses = $('#mdlAjukanKredit').data('akses')
            let id_history = $('#mdlAjukanKredit').data('id_history')

            // make select jenis promo with value fixed
            // Disable the select element
            if(akses == '1'){
                getdatapromo(id_history);
            }

        });

        function prosesresponpromo (response){

            console.log(response)
            // menampilkan modal
            $('#mdlAjukanKredit').modal('show')
            $('#mdlAjukanKredit #id_jenis_kredit').val(response.id_jenis_kredit).change();
            $('#mdlAjukanKredit #id_jenis_kredit').prop('disabled', true);
        }

        // navbar pilihan jaminan kendaraan/SHM
        $('#navkendaraan').on('click', function(){
            $('#inputjaminanshm').attr('hidden', true)
            $('#inputjaminankendaraan').attr('hidden', false)
            $('#navshm').removeClass('active').addClass('');
            $('#navkendaraan').removeClass('').addClass('active');
            
            // menghilangkan upload bpkb
            $('#suratshm').attr('hidden', true )
            $('#suratkendaraan').attr('hidden', false  )
            
            // mengganti label
            $('#labelnomor').html('Nomor BPKB')
            $('#labelatasnama').html('Atas Nama (BPKB)')

             $('#id_jaminan_shm').attr('value','')

        })

        $('#navshm').on('click', function(){
            $('#inputjaminanshm').attr('hidden', false)
            $('#inputjaminankendaraan').attr('hidden', true )
            
            $('#navkendaraan').removeClass('active').addClass('');
            $('#navshm').removeClass('').addClass('active');

            // menghilangkan upload bpkb
            $('#suratshm').attr('hidden', false)
            $('#suratkendaraan').attr('hidden', true )

            // mengganti label
            $('#labelnomor').html('Nomor SHM/SHGB')
            $('#labelatasnama').html('Atas Nama (SHM/SHGB)')
            
            // mendapatkan harga jaminan shm
            $.ajax({
                type: "POST",
                url: "<?= base_url('pelayanan/carikendaraan')?>",
                data: {
                    'nama':'SHM/SHGB'
                },
                dataType: "JSON",
                success: function (response) {
                    $('#id_jaminan_shm').attr('value',response.kendaraan[0].id_jaminan)
                    $('#taksasishm').val(formatRupiah(response.kendaraan[0].taksasi))



                }
            });
        })
        
        // 
        // 
        // change format rupiah to number
        // 
        // 
       function rupiahToNumber(money) {
            var cleanNumber = money.replace(/[^0-9.-]+/g, '');
            var cleanNumber = cleanNumber.replace('.', '');
            var cleanNumber = cleanNumber.replace(',', '.');

            var number = parseFloat(cleanNumber);
            
            console.log(number)
            return number;
        }

        // cari kendaraan
        let pabrikan="";
        let roda="";
        let nama="";
        
        // insert data pengajuan
        
        $('#pabrikan').change(function(){

            pabrikan = $(this).val();
        })

        $('#jenis_kendaraan').change(function(){

            roda = $(this).val();
        })

        $('#merk').change(function(){

            nama = $(this).val();
        })

        $('#luastanah').keypress(function(event) {
            return event.charCode >= 48 && event.charCode <= 57
        });

         $('#luastanah').on('change', function() {
            var luas = $(this).val();
            var taksasi = rupiahToNumber($('#taksasishm').val())

            $('#inputmaksshm').attr('value',formatRupiah(luas*taksasi))
        });

        // insert promo
        $('.btnterimapromo').on('click', function(){
            $('#dftrkendaraantbl').attr('hidden', true);

            $.ajax({
                type: "POST",
                url: "<?= base_url('pelayanan/insertclick')?>",
                data: {
                    'id_jenis_kredit': $(this).data('id_jenis_kredit')
                },
                dataType: "dataType",
                success: function (response) {
                    console.log(response)
                    
                    
                }
            });

            // change selected jenis_kredit
            $('#mdlAjukanKredit #id_jenis_kredit').val($(this).data('id_jenis_kredit')).change();
            $('#mdlAjukanKredit #id_jenis_kredit').prop('disabled', true);
        })

        // edit data pengajuan
        // navbar pilihan jaminan kendaraan/SHM
        $('#navkendaraanedit').on('click', function(){
            $('#inputjaminanshmedit').attr('hidden', true)
            $('#inputjaminankendaraanedit').attr('hidden', false)
            $('#navshmedit').removeClass('active').addClass('');
            $('#navkendaraanedit').removeClass('').addClass('active');
            
            // menghilangkan upload bpkb
            $('#suratshmedit').attr('hidden', true )
            $('#suratkendaraanedit').attr('hidden', false  )
            
            // mengganti label
            $('#labelnomoredit').html('Nomor BPKB')
            $('#labelatasnamaedit').html('Atas Nama (BPKB)')

            $('#id_jaminan_shm2').attr('value','')

        })

        $('#navshmedit').on('click', function(){
            $('#inputjaminanshmedit').attr('hidden', false)
            $('#inputjaminankendaraanedit').attr('hidden', true )
            
            $('#navkendaraanedit').removeClass('active').addClass('');
            $('#navshmedit').removeClass('').addClass('active');

            // menghilangkan upload bpkb
            $('#suratshmedit').attr('hidden', false)
            $('#suratkendaraanedit').attr('hidden', true )

            // mengganti label
            $('#labelnomoredit').html('Nomor SHM/SHGB')
            $('#labelatasnamaedit').html('Atas Nama (SHM/SHGB)')
            
            // mencari judul web untuk admin
            var pageTitle = $('title').text();
            console.log(pageTitle);

            if(pageTitle == 'List Pengajuan Kredit'){
                // mendapatkan harga jaminan shm
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('kredit/carikendaraan')?>",
                    data: {
                        'nama':'SHM/SHGB'
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $('#id_jaminan_shm2').attr('value',response.kendaraan[0].id_jaminan)
                        $('#taksasishm2').val(formatRupiah(response.kendaraan[0].taksasi))
    
    
    
                    }
                });
                
            }else{
                
                // mendapatkan harga jaminan shm
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('pelayanan/carikendaraan')?>",
                    data: {
                        'nama':'SHM/SHGB'
                    },
                    dataType: "JSON",
                    success: function (response) {
                        $('#id_jaminan_shm2').attr('value',response.kendaraan[0].id_jaminan)
                        $('#taksasishm2').val(formatRupiah(response.kendaraan[0].taksasi))
    
    
    
                    }
                });
            }
        })

        $('#pabrikan2').change(function(){

            pabrikan = $(this).val();
        })

        $('#jenis_kendaraan2').change(function(){

            roda = $(this).val();
        })

        $('#merk2').change(function(){

            nama = $(this).val();
        })

        // change luas tanah dan taksasi SHM
        $('#luastanah2').keypress(function(event) {
            return event.charCode >= 48 && event.charCode <= 57
        });

         $('#luastanah2').on('change', function() {
            var luas = $(this).val();
            var taksasi = rupiahToNumber($('#taksasishm2').val())

            $('#inputmaksshm2').attr('value',formatRupiah(luas*taksasi))
        });

        // cari dari user + tambah
        $('#btn_cari').on('click',function(){
            $("#dftrkendaraantbl").attr("hidden",false);
            cari('#tbl_daftar_jaminan')
            
        })
        // cari dari user - edit
        $('#btn_cari2').on('click',function(){
            $("#dftrkendaraantbl2").attr("hidden",false);
            cari('#tbl_daftar_jaminan2')
            
        })

        function cari(input){
            // console.log(pabrikan+roda+nama)
            $.ajax({
                type: "POST",
                url: "<?= base_url('pelayanan/carikendaraan')?>",
                data: {
                    'pabrikan':pabrikan,
                    'roda':roda,
                    'nama':nama
                },
                dataType: "JSON",
                success: function (response) {
                    console.log(response)
                    //looping ke daftar keranjang 
                    $(input).html('')
                    
                    if($.trim(response.kendaraan)){
                        $(input).html(`
                                    <table class="table table-sm table-striped" id="tbldaftarkendaraan">
                                            <thead class="thead-dark  ">
                                                <tr class="" style="">
                                                    <th scope="col" style="font-size:small; ">Kode</th>
                                                    <th scope="col" style="font-size:small; ">Merk</th>
                                                    <th scope="col" style="font-size:small; ">Nama Kendaraan</th>
                                                    <th scope="col" style="font-size:small; ">Harga</th>
                                                    <th scope="col" style="font-size:small; ">Taksasi</th>
                                                    <th scope="col" class="" style="font-size:small;">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                                <tbody class="bg-light" id="isi_tbl" style="font-size:12px;">
                                            </tbody>
                                        </table>
                        `)
                        

                                
                                
                    }else{
                         $(input).html(`
                                    <table class="table table-sm table-striped">
                                            <thead class="thead-dark " style="background-color: blue;">
                                                <tr class="" style="">
                                                    <th scope="col" style="font-size:small; ">Kode</th>
                                                    <th scope="col" style="font-size:small; ">Merk</th>
                                                    <th scope="col" style="font-size:small; ">Nama Kendaraan</th>
                                                    <th scope="col" style="font-size:small; ">Harga</th>
                                                    <th scope="col" style="font-size:small; ">Taksasi</th>
                                                    <th scope="col" class="" style="font-size:small;">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody class="bg-light" id="isi_tbl" style="font-size:12px; text-align:center;">
                                                <tr>
                                                    <td scope="col" colspan="6" >Data Kosong</td>
                                                
                                                </tr>
                                            </tbody>
                                        </table>
                        `)
                    }

                        console.log(response.kendaraan)


                        $.each(response.kendaraan, function(i, item) {
                       
                            if(item['merk'] != 'SHM/SHGB'){
                                $('#isi_tbl').append(`
                                        <tr>
                                            <td>`+item['kode_jaminan']+`</td>
                                            <td>`+item['merk']+`</td>
                                            <td>`+item['nama_jaminan']+`</td>
                                            <td>`+item['harga']+`</td>
                                            <td>`+item['taksasi']+`</td>
                                            <th class="" scope="col"><button type="button" class="pilihkdr btn btn-sm btn-primary btn-block " data-idkendaraan="`+item['id_jaminan']+`" data-nama-kendaraan="`+item['nama_jaminan']+`" data-taksasi="`+item['taksasi']+`">
                                                <span><i class="far fa-hand-point-up"></i></span>
                                            </button></th>
                                        </tr>
                                                            
                                `);

                            }
                        

                    });

                    
                    // $('#tbldaftarkendaraan').DataTable();

                    

                }
            });
        }

        // cari dari Admin + tambah
        $('#btn_cari_admin').on('click',function(){
            $("#dftrkendaraantbl").attr("hidden",false);
            cariAdmin('#tbl_daftar_jaminan')
            
        })
        // cari dari Admin - edit
        $('#btn_cari2_admin').on('click',function(){
            $("#dftrkendaraantbl2").attr("hidden",false);
            cariAdmin('#tbl_daftar_jaminan2')
            
        })

        function cariAdmin(input){
            // console.log(pabrikan+roda+nama)
            $.ajax({
                type: "POST",
                url: "<?= base_url('kredit/carikendaraan')?>",
                data: {
                    'pabrikan':pabrikan,
                    'roda':roda,
                    'nama':nama
                },
                dataType: "JSON",
                success: function (response) {
                    console.log(response)
                    //looping ke daftar keranjang 
                    $(input).html('')
                    
                    if($.trim(response.kendaraan)){
                        $(input).html(`
                                    <table class="table table-sm table-striped" id="tbldaftarkendaraan">
                                            <thead class="thead-dark  ">
                                                <tr class="" style="">
                                                    <th scope="col" style="font-size:small; ">Kode</th>
                                                    <th scope="col" style="font-size:small; ">Merk</th>
                                                    <th scope="col" style="font-size:small; ">Nama Kendaraan</th>
                                                    <th scope="col" style="font-size:small; ">Harga</th>
                                                    <th scope="col" style="font-size:small; ">Taksasi</th>
                                                    <th scope="col" class="" style="font-size:small;">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                                <tbody class="bg-light" id="isi_tbl" style="font-size:12px;">
                                            </tbody>
                                        </table>
                        `)
                        

                                
                                
                    }else{
                         $(input).html(`
                                    <table class="table table-sm table-striped">
                                            <thead class="thead-dark " style="background-color: blue;">
                                                <tr class="" style="">
                                                    <th scope="col" style="font-size:small; ">Kode</th>
                                                    <th scope="col" style="font-size:small; ">Merk</th>
                                                    <th scope="col" style="font-size:small; ">Nama Kendaraan</th>
                                                    <th scope="col" style="font-size:small; ">Harga</th>
                                                    <th scope="col" style="font-size:small; ">Taksasi</th>
                                                    <th scope="col" class="" style="font-size:small;">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody class="bg-light" id="isi_tbl" style="font-size:12px; text-align:center;">
                                                <tr>
                                                    <td scope="col" colspan="6" >Data Kosong</td>
                                                
                                                </tr>
                                            </tbody>
                                        </table>
                        `)
                    }

                        console.log(response.kendaraan)


                        $.each(response.kendaraan, function(i, item) {
                       
                            if(item['merk'] != 'SHM/SHGB'){
                                $('#isi_tbl').append(`
                                        <tr>
                                            <td>`+item['kode_jaminan']+`</td>
                                            <td>`+item['merk']+`</td>
                                            <td>`+item['nama_jaminan']+`</td>
                                            <td>`+item['harga']+`</td>
                                            <td>`+item['taksasi']+`</td>
                                            <th class="" scope="col"><button type="button" class="pilihkdr btn btn-sm btn-primary btn-block " data-idkendaraan="`+item['id_jaminan']+`" data-nama-kendaraan="`+item['nama_jaminan']+`" data-taksasi="`+item['taksasi']+`">
                                                <span><i class="far fa-hand-point-up"></i></span>
                                            </button></th>
                                        </tr>
                                                            
                                `);

                            }
                        

                    });

                    
                    // $('#tbldaftarkendaraan').DataTable();

                    

                }
            });
        }

        $('#tbl_daftar_jaminan').on('click','.pilihkdr', function(){
            let id_kendaraan = $(this).data('idkendaraan');
            let nama_kendaraan = $(this).data('nama-kendaraan');
            let taksasi = $(this).data('taksasi');
            console.log(id_kendaraan)
            $('#id_jaminan').attr('value',id_kendaraan);
            $('#nama_kendaraan').attr('value',nama_kendaraan);
            $('#taksasi').attr('value',formatRupiah(taksasi) );
            
        })

        $('#tbl_daftar_jaminan2').on('click','.pilihkdr', function(){
            let id_kendaraan = $(this).data('idkendaraan');
            let nama_kendaraan = $(this).data('nama-kendaraan');
            let taksasi = $(this).data('taksasi');

            console.log(id_kendaraan+nama_kendaraan+taksasi)
            $('#id_jaminan2').val(id_kendaraan);
            $('#nama_kendaraan2').val(nama_kendaraan);
            $('#taksasi2').val(formatRupiah(taksasi) );
            
        })
    });

    // multiple file input
    
        $(function () {

            // insert data pengajuan
            $(document).on('click', '.btn-add', function (e) {
                e.preventDefault();

                var controlForm = $('.controls:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });

            $(document).on('click', '.btn-add2', function (e) {
                e.preventDefault();

                var controlForm = $('.controls2:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add2')
                    .removeClass('btn-add2').addClass('btn-remove2')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove2', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
            
            $(document).on('click', '.btn-add3', function (e) {
                e.preventDefault();

                var controlForm = $('.controls3:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add3')
                    .removeClass('btn-add3').addClass('btn-remove3')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove3', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });

            // edit data pengajuan
            $(document).on('click', '.btn-add4', function (e) {
                e.preventDefault();

                var controlForm = $('.controls4:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add4')
                    .removeClass('btn-add4').addClass('btn-remove4')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove4', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });

            $(document).on('click', '.btn-add5', function (e) {
                e.preventDefault();

                var controlForm = $('.controls5:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add5')
                    .removeClass('btn-add5').addClass('btn-remove5')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove5', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
            
            $(document).on('click', '.btn-add6', function (e) {
                e.preventDefault();

                var controlForm = $('.controls6:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add6')
                    .removeClass('btn-add6').addClass('btn-remove6')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove6', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });

            $(document).on('click', '.btn-add7', function (e) {
                e.preventDefault();

                var controlForm = $('.controls7:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add7')
                    .removeClass('btn-add7').addClass('btn-remove7')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove7', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });

            $(document).on('click', '.btn-add8', function (e) {
                e.preventDefault();

                var controlForm = $('.controls8:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                newEntry.find('label').html('Choose File');

                controlForm.find('.entry:not(:last) .btn-add8')
                    .removeClass('btn-add8').addClass('btn-remove8')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove8', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });


            //untuk mangakali upload file edit profile
            $('.multiinput').on('change','.custom-file-input', function() {
                let filename = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(filename);
            })
            
        });

        // modal freeze 
        $('.modal').on("hidden.bs.modal", function (e) { 
            if ($('.modal:visible').length) { 
                $('body').addClass('modal-open');
            }
        });





    
    
</script>

<script>
     

    // AO dan Jamnian(Agunan)
    $(document).ready(function () {
        
        // del AO
        $('.delao').on('click', function(){
            let id_user = $(this).data('id_user')

            $('#mdlhapusao #id_user').attr('value',id_user);
        })

        // edit AO
        $('.edtao').on('click', function() {
        let id_user = $(this).data('id_user');
        let name = $(this).data('name');
        let email = $(this).data('email');
        let date_birth = $(this).data('date_birth');
        let gender = $(this).data('gender');
        let ao_phone = $(this).data('ao_phone');
        let image = $(this).data('image');


        $('#mdleditao #id_user').attr('value', id_user);
        $('#mdleditao #name').attr('value', name);
        $('#mdleditao #email').attr('value', email);
        $('#mdleditao #date_birth').val(date_birth);
        $('#mdleditao #gender').val( gender).change();
        $('#mdleditao #ao_phone').attr('value',ao_phone);
        $('#mdleditao #fotoao').attr('src', '<?= base_url('assets/img/profile/')  ?>'+image);
       
        })

       // del Jaminan
        $('.deljmn').on('click', function(){
            let id_jaminan = $(this).data('id_jaminan')

            console.log(id_jaminan)
            $('#mdlhapusjmn #id_jaminan').attr('value',id_jaminan);
        })
        
        //nasabah
        var table = $('#tblagunan').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [10, 20, 30, -1],
                [10, 20, 30,'Todos']
            ]
        })


        // edit Jaminan
        $("#tblagunan").on('click', '.edtjmn', function() {

            let id_jaminan = $(this).data('id_jaminan');
            let kode_jaminan = $(this).data('kode_jaminan');
            let tgl_berlaku = $(this).data('tgl_berlaku');
            let roda = $(this).data('roda');
            let merk = $(this).data('merk');
            let harga = $(this).data('harga');
            let taksasi = $(this).data('taksasi');
            let nama_jaminan = $(this).data('nama_jaminan');

            console.log(id_jaminan)


            $('#mdleditjmn #id_jaminan').attr('value', id_jaminan);
            $('#mdleditjmn #kode_jaminan').attr('value', kode_jaminan);
            $('#mdleditjmn #merk').attr('value', merk.toUpperCase());
            // $('#mdleditjmn #tgl_berlaku').attr('value', tgl_berlaku);
            $('#mdleditjmn #roda').val(roda).change();
            $('#mdleditjmn #harga').val( harga);
            $('#mdleditjmn #taksasi').attr('value',taksasi);
            $('#mdleditjmn #nama_jaminan').html( nama_jaminan);
       
        })


    });

</script>


</body>

</html>