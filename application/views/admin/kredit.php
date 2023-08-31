<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 text-center"><?= $title ?></h1>



    <div class="row">

        <div class="col">
            <div class="col-md-4">
                <div class="input-group">
                    <select class="custom-select" id="selecttrans" aria-label="Example select with button addon">
                        <option selected>Semua</option>
                        <option value="1">Lunas</option>
                        <option value="2">Belum Lunas</option>
                    </select>
                    <div class="input-group-append">
                        <a href="<?= base_url('admin/export/') ?>" class="btn btn-success exportlap"> Export Excel <i class="fas fa-file-export"></i></a>


                    </div>
                </div>
            </div>


            <div class="col" style="margin-top: 4rem;">
                <table id="transsu" class="table thead-dark table-striped table-bordered table-responsive" style="font-size:small;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Kredit</th>
                            <th>ID Nasabah</th>
                            <th>Jumlah Kredit</th>
                            <th>Angsuran</th>
                            <th>Jenis Kredit</th>
                            <th>Lihat</th>

                        </tr>
                    </thead>

                    <tbody id="tabeltrans">
                        <?php $no = 1;
                        foreach ($kredit as $ts) : ?>
                            <tr>
                                <td class="font-weight-normal" style="color: black; "> <?= $no ?></td>
                                <td class="font-weight-normal" style="color: black; "> <?= $ts['id_kredit'] ?></td>
                                <td class="font-weight-normal" style="color: black; "> <?= $ts['id_nasabah'] ?></td>
                                <td class="font-weight-normal" style="color: black; "> <?= $ts['jumlah_kredit'] ?></td>
                                <td class="font-weight-normal" style="color: black; "> <?= $ts['angsuran'] ?></td>
                                <td class="font-weight-normal" style="color: black; "> <?= $ts['id_jenis_kredit'] ?></td>
                                <td class="font-weight-normal" style="color: black; "> <button class="lihatterminadm btn btn-primary btn-sm" data-toggle="modal" data-target="#mdllihatterminadm" data-idpjl="<?= $ts['id_kredit'] ?>"><small>Lihat</small></button> </td>


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