<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        td {
            font-size: 8px;
        }
    </style>

</head>

<body>
    <table cellpadding="2" width="100%" style="border-collapse: collapse; border: 1px solid black;">
        <tr>
            <td colspan="10" valign="top" style="text-align: center; color:cornflowerblue; font-size:x-large;">Buku Kredit Nasabah BPR Amira</td>
        </tr>
        <tr>
            <td colspan="10"><img src="<?php
                                        // Use this code to convert your image to base64
                                        // Apply this in a view 

                                        $path = base_url('assets/img/profile/logoAmira.jpg'); // Modify this part (your_img.png
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($path);
                                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                        echo $base64;
                                        ?>" alt="" style="height: 75px;"> </td>
        </tr>
        <tr>
            <td colspan="6"> BPR Amira </td>
            <td><b>Date</b> </td>
            <td colspan="3" style="text-align: center;"><?= date('d-M-Y',time()) ?></td>
        </tr>
        <tr>
            <td colspan="10">Jl. A. Yani Ruko Business Center A-3</td>
            <!-- <td><b>Invoice</b> </td>
            <td colspan="3" style="text-align: left;">/INV/IAN/VI/2022</td> -->
        </tr>

        <tr>
            <td colspan="10">Kelurahan Ardirejo, Kepanjen, Kabupaten Malang</td>
        </tr>
        <tr>
            <td colspan="10">office : 0341-3904700</td>
        </tr>
        <tr>
            <td colspan="10"> <a href="bpramira@gmail.com">bpramira@gmail.com</a></td>
        </tr>
        <tr>
            <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
        </tr>

        <tr>
            <td style="background-color: #6495ED;" colspan="3"><b>Nasabah</b></td>
            <td colspan="7"><b>
                    &nbsp;
                </b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Nama</b></td>
            <td colspan="7"><b><?= $user['name'] ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>No. Pengajuan</b></td>
            <td colspan="7"><b><?= $kredit['id_pengajuan'] ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>No. Transaksi</b></td>
            <td colspan="7"><b><?= $kredit['id_transaksi_kredit'] ?></b></td>
        </tr>
        <tr valign="top" style="text-align: left; ">
            <td colspan="3"><b>Tgl. Realisasi</b></td>
            <td colspan="7"><b><?= date('d-m-Y',$kredit['tgl_realisasi_kredit']) ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Bunga</b></td>
            <td colspan="7"><b><?=  $kredit['jumlah_bunga_persen'].' Persen/bulan' ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Denda</b></td>
            <td colspan="7"><b><?=  $kredit['denda_kredit'].' Persen/bulan' ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Total angsuran</b></td>
            <td colspan="7"><b><?=  $kredit['total_angsuran_bulan'].' bulan' ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Total Pinjaman</b></td>
            <td colspan="7"><b><?= "Rp " . number_format($kredit['jumlah_pinjaman'], 0, ',', '.') ?></b></td>  
        </tr>
        <tr>
            <td colspan="3"><b>Total Bunga</b></td>
            <td colspan="7"><b><?= "Rp " . number_format($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100*$kredit['total_angsuran_bulan'], 0, ',', '.') ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Angsuran Pokok</b></td>
            <?php if($kredit['nama_kredit'] == 'Kredit Bunga-Bunga 6 Bulan'){?>
                <td colspan="7"><b><?=  "Rp " . number_format(0/$kredit['total_angsuran_bulan'], 0, ',', '.')?></b></td>
            <?php }else{?>
                <td colspan="7"><b><?=  "Rp " . number_format($kredit['jumlah_pinjaman']/$kredit['total_angsuran_bulan'], 0, ',', '.')?></b></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="3"><b>Angsuran Bunga</b></td>
            <td colspan="7"><b><?= "Rp " . number_format($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100, 0, ',', '.') ?></b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Total Angsuran</b></td>
            <?php if($kredit['nama_kredit'] == 'Kredit Bunga-Bunga 6 Bulan'){?>
                <td colspan="7"><b><?= "Rp " . number_format((0/$kredit['total_angsuran_bulan'])+($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100), 0, ',', '.') ?></b></td>
            <?php }else{?>
                <td colspan="7"><b><?= "Rp " . number_format(($kredit['jumlah_pinjaman']/$kredit['total_angsuran_bulan'])+($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100), 0, ',', '.') ?></b></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="3"><b>Denda/ hari</b></td>
             <?php if($kredit['nama_kredit'] == 'Kredit Bunga-Bunga 6 Bulan'){?>
                <td colspan="7"><b><?= "Rp " . number_format(((0/$kredit['total_angsuran_bulan'])+($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100))*$kredit['denda_kredit']/100, 0, ',', '.') ?></b></td>
            <?php }else{?>
                <td colspan="7"><b><?= "Rp " . number_format((($kredit['jumlah_pinjaman']/$kredit['total_angsuran_bulan'])+($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100))*$kredit['denda_kredit']/100, 0, ',', '.') ?></b></td>
            <?php } ?>
        </tr>
        <!-- <tr>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="18%"><b>
                    &nbsp;
                </b></td>
        </tr> -->
        <tr style="text-align: center;">
            <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
        </tr>
        <tr style="text-align: center;">
            <td width="6%" style="background-color: #6495ED; border: 1px solid black; "><b>No</b></td>
            <td width="10%" style="background-color: #6495ED; border: 1px solid black;"><b>Tgl. Bayar</b></td>
            <td width="10%" style="background-color: #6495ED; border: 1px solid black;"><b>Tgl. Jatuh Tempo</b></td>
            <td width="10%" style="background-color: #6495ED; border: 1px solid black;"><b>Telat/ hari</b></td>
            <td width="11%" style="background-color: #6495ED; border: 1px solid black;"><b>Sisa Pokok</b></td>
            <td width="11%" style="background-color: #6495ED; border: 1px solid black;"><b>Sisa Bunga</b></td>
            <td width="11%" style="background-color: #6495ED; border: 1px solid black;"><b>Pokok</b></td>
            <td width="10%" style="background-color: #6495ED; border: 1px solid black;"><b>Bunga</b></td>
            <td width="10%" style="background-color: #6495ED; border: 1px solid black;"><b>Denda</b></td>
            <td width="11%" style="background-color: #6495ED; border: 1px solid black;"><b>Total Angsuran</b></td>
        </tr>
        <?php
        $no = 1;
        $total_pokok = 0;
        $total_bunga = 0;
        $total_denda = 0;
        for ($i = 0; $i < $kredit['total_angsuran_bulan']; $i++) {
    
                if ($i < count($angsuran)) {
                    echo    '<tr style="text-align: center;">
                                <td width="6%" style="border: 1px solid black;">' . $no . '</td>
                                <td width="10%" style="border: 1px solid black;">'. date('d-M-Y',$angsuran[$i]['tanggal']) .'</td>
                                <td width="10%" style="border: 1px solid black;">' . date('d-M-Y',$angsuran[$i]['tgl_jatuh_tempo']) . '</td>
                                <td width="10%" style="border: 1px solid black;">' . $angsuran[$i]['denda']/(((($kredit['jumlah_pinjaman']/$kredit['total_angsuran_bulan'])+($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100))*$kredit['denda_kredit']/100)) . '</td>
                                
                                <td width="11%" style="border: 1px solid black;"><span>' . "Rp " . number_format(( $kredit['jumlah_pinjaman'])-($kredit['jumlah_pinjaman']/$kredit['total_angsuran_bulan'])*($i+1), 0, ',', '.') . '</span></td> 
                                <td width="11%" style="border: 1px solid black;">' . "Rp " . number_format(($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100*$kredit['total_angsuran_bulan'])-($kredit['jumlah_pinjaman']*$kredit['jumlah_bunga_persen']/100)*($i+1) , 0, ',', '.') . '</td> 
                                
                                <td width="11%" style="border: 1px solid black;"><span>' . "Rp " . number_format($angsuran[$i]['jumlah_pokok'], 0, ',', '.') . '</span></td>
                                <td width="10%" style="border: 1px solid black;">' . "Rp " . number_format($angsuran[$i]['jumlah_bunga'] , 0, ',', '.')  . '</td>
                                <td width="10%" style="border: 1px solid black;">' . "Rp " . number_format($angsuran[$i]['denda'] , 0, ',', '.')  . '</td>
                                <td width="11%" style="border: 1px solid black;">' . "Rp " . number_format($angsuran[$i]['jumlah_pokok'] + $angsuran[$i]['jumlah_bunga']+$angsuran[$i]['denda'] , 0, ',', '.')  . '</td>
                            </tr>';
                    $no++;
                    $total_pokok += $angsuran[$i]['jumlah_pokok'];
                    $total_bunga += $angsuran[$i]['jumlah_bunga'];
                    $total_denda += $angsuran[$i]['denda'];

                } else {
                    echo    '<tr style="text-align: center;">
                                <td width="6%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="10%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="10%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="10%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="11%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="11%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="11%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="10%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="10%" style="border: 1px solid black;"> &nbsp;</td>
                                <td width="11%" style="border: 1px solid black;"> &nbsp;</td>
                            </tr>';
                }
        } 
        ?>



        <!-- end loop -->
        <tr style="text-align: center;">
            <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%" style="border: 1px solid black;"><b>
                    Jumlah
                </b></td>
            <td width="11%" style="border: 1px solid black;">
                    <span><?= "Rp " . number_format($total_pokok, 0, ',', '.')  ?>
                </td>
            <td width="10%" style="border: 1px solid black;">
                   <span><?= "Rp " . number_format($total_bunga, 0, ',', '.')  ?>
                </td>
            <td width="10%" style="border: 1px solid black;">
                <span><?= "Rp " . number_format($total_denda, 0, ',', '.')  ?></span>
            </td>
            <td width="11%" style="border: 1px solid black;">
                <span><?= "Rp " . number_format($total_denda+$total_pokok+$total_bunga, 0, ',', '.')  ?></span>
            </td>
        </tr>
        <!-- <tr>
           <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>Biaya Pengiriman</b></td>
            <td width="18%"><span><?php
                                    // if ($angsuran['ongkir']) {
                                    //     echo  "Rp " . number_format($angsuran['ongkir'], 0, ',', '.');
                                    // } 
                                    ?></span></td>
        </tr>
        <tr>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>DP 50%</b></td>
            <td width="18%"><span><?php
                                    // echo  "Rp " . number_format($angsuran['total'] / 2, 0, ',', '.');
                                    ?></span></td>
        </tr>
        <tr>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>
                    &nbsp;
                </b></td>
            <td width="12%"><b>DP 50%</b></td>
            <td width="18%"><span><?php
                                    // echo  "Rp " . number_format($angsuran['total'] / 2, 0, ',', '.');
                                    ?></span></td>
        </tr> -->
        <tr style="text-align: center;">
           <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
        </tr>
        <tr style="text-align: center;">
           <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
        </tr>
        <tr style="text-align: center;">
            <td width="50%" colspan="5" style="text-align:left; "></td>

            <td width="50%" colspan="5" style="border: 1px solid black;  background-color: #6495ED; ">
                Make all checks payble to

            </td>
        </tr>
        <tr style="text-align: center;">
            <td width="50%" colspan="5" style="text-align:left;  "> &nbsp;</td>

            <td width="50%" colspan="5" style="border: 1px solid black;  ">
                BCA Number : 1238889889
            </td>
        </tr>
        <tr style="text-align: center;">
            <td width="50%" colspan="5" style="text-align:left;  "> &nbsp;</td>

            <td width="50%" colspan="5" style="border: 1px solid black;  ">
                atas nama : BPR ARTHA MITRA RAK
            </td>
        </tr>
        <tr style="text-align: center;">
           <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
        </tr>
        <tr style="text-align: center;">
           <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
        </tr>

        <!-- <tr style="text-align: center;">
            <td width="50%" colspan="4"> &nbsp;</td>

            <td width="50%" colspan="4" style="text-align:left;  ">
                Kepala Cabang Wajak
            </td>
        </tr>
        <tr style="text-align: center;">
            <td width="50%" colspan="4"> &nbsp;</td>

            <td width="50%" colspan="4" style="text-align:left;  ">
               BPR Amira
            </td>
        </tr>
        <tr style="text-align: left;">
            <td width="40%" colspan="4"> &nbsp;</td>

            <td width="60%" colspan="4">
                <img src="<?php
                            //Use this code to convert your image to base64
                            // Apply this in a view 

                            // $path = base_url('assets/img/profile/Signature.png'); // Modify this part (your_img.png
                            // $type = pathinfo($path, PATHINFO_EXTENSION);
                            // $data = file_get_contents($path);
                            // $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            // echo $base64;
                            ?>" alt="" style="height: 100px;">
            </td>
        </tr> -->
        <tr style="text-align: center;">
           <td width="6%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="10%"><b>
                    &nbsp;
                </b></td>
            <td width="11%"><b>
                    &nbsp;
                </b></td>
        </tr>
        <tr style="text-align: center;">
            <td width="100%" colspan="10"> Jika anda punya pertanyaan mengenai buku angsuran ini, mohon menghubungi:</td>


        </tr>
        <tr style="text-align: center;">
            <td width="100%" colspan="10"> Khoirul Anam, 085-100-184-070, <a href="mailto:farizqibp@gmail.com">khoirulanam@gmail.com</a> </td>


        </tr>
        <tr style="text-align: center;">
            <td width="100%" colspan="10">Terimakasih telah menjadi bagian dari kami</td>


        </tr>
        <tr style="text-align: center;">
            <td width="100%" colspan="10">&nbsp;</td>


        </tr>

    </table>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
        $(document).ready(function() {

            $.ajax({
                type: "post",
                url: "<?= base_url('transaksi/praCetakInvoice') ?>",
                data: {
                    'idpjl': 42,
                    'termin': 1
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response)

                }
            });
        });
    </script> -->
</body>

</html>