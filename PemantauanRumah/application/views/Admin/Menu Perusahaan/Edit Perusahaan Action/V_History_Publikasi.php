<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>History Detail Benefit | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>History Detail Benefit dari <span class="text text-primary"><?php echo $dataPerusahaan[0]->V_namaPerusahaan ?></span></h1>
</div>

<div class="text-center">
    <a class="btn btn-info ml-3" id="websiteToggle" href="#table-history-website" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">Website</a>
    <a class="btn btn-info ml-3" id="medsosToggle" href="#table-history-medsos" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">Media Sosial</a>
    <a class="btn btn-info ml-3" id="bemToggle" href="#table-history-bem" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">BEM</a>
    <a class="btn btn-info ml-3" id="fakulUnparToggle" href="#table-history-fakulUnpar" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">Fakultas/UNPAR Official</a>
    <a class="btn btn-info ml-3 text text-white" onclick="expandAll()">All</a>
</div>
<!-- website -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-website">
    <h4>Website</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_website" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Lowongan</th>
                    <th>Awal Publikasi</th>
                    <th>Akhir Publikasi</th>
                    <th>Arsip Materi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataWebsite as $key => $value) {
                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_judul . '</td>
                                <td>' . $value->V_tglMulai . '</td>
                                <td>' . $value->V_tglSelesai . '</td>
                                <td>' . $value->V_arsipMateri . '</td>
                                <td><button onclick="edit(' . $value->idPublikasi . ')" data-toggle="modal" data-target="#modal_user" class="btn btn-primary mx-1">Edit</button></td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</ul>

<!-- medsos -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-medsos">
    <h4>Media Sosial</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_medsos" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Lowongan</th>
                    <th>Awal Publikasi</th>
                    <th>Akhir Publikasi</th>
                    <th>Arsip Materi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataMedsos as $key => $value) {
                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_judul . '</td>
                                <td>' . $value->V_tglMulai . '</td>
                                <td>' . $value->V_tglSelesai . '</td>
                                <td>' . $value->V_arsipMateri . '</td>
                                <td><button onclick="edit(' . $value->idPublikasi . ')" data-toggle="modal" data-target="#modal_user" class="btn btn-primary mx-1">Edit</button></td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</ul>

<!-- bem -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-bem">
    <h4>BEM</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_bem" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Lowongan</th>
                    <th>Awal Publikasi</th>
                    <th>Akhir Publikasi</th>
                    <th>Arsip Materi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataBem as $key => $value) {
                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_judul . '</td>
                                <td>' . $value->V_tglMulai . '</td>
                                <td>' . $value->V_tglSelesai . '</td>
                                <td>' . $value->V_arsipMateri . '</td>
                                <td><button onclick="edit(' . $value->idPublikasi . ')" data-toggle="modal" data-target="#modal_user" class="btn btn-primary mx-1">Edit</button></td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</ul>

<!-- fakultas / unpar official -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-fakulUnpar">
    <h4>Fakultas / UNPAR Official</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_fakulUnpar" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Lowongan</th>
                    <th>Awal Publikasi</th>
                    <th>Akhir Publikasi</th>
                    <th>Arsip Materi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataFakulUnpar as $key => $value) {
                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_judul . '</td>
                                <td>' . $value->V_tglMulai . '</td>
                                <td>' . $value->V_tglSelesai . '</td>
                                <td>' . $value->V_arsipMateri . '</td>
                                <td><button onclick="edit(' . $value->idPublikasi . ')" data-toggle="modal" data-target="#modal_user" class="btn btn-primary mx-1">Edit</button></td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</ul>

<!-- Modal for Action -->
<div class="modal fade bd-example-modal-lg" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="modal-user" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" id="action_view">

        </div>
    </div>
</div>
<!-- End of Modal for Action -->

</div>
<!-- Penutup div wrapper -->
</div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#table_history_website').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ]
        });
    });

    $(document).ready(function() {
        var table = $('#table_history_medsos').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ]
        });
    });

    $(document).ready(function() {
        var table = $('#table_history_bem').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ]
        });
    });

    $(document).ready(function() {
        var table = $('#table_history_fakulUnpar').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ]
        });
    });

    function edit(idPublikasi) {
        var idPerusahaan = '<?php echo $dataPerusahaan[0]->idPerusahaan; ?>';
        $.ajax({
            // Tampilan dari Edit Perusahaan dapat dilihat pada folder views/Admin/Menu Perusahaan/Edit Perusahaan Action
            url: "<?php echo base_url('edit-publikasi'); ?>",
            method: "POST",
            data: {
                idPublikasi: idPublikasi,
                idPerusahaan: idPerusahaan
            },
            success: function(data) {
                $("#action_view").html(data);
            }
        });
    }

    $(document).ready(function() {
        $("#websiteToggle").click();
        $("#medsosToggle").click();
        $("#bemToggle").click();
        $("#fakulUnparToggle").click();
    });

    function expandAll() {
        $("#websiteToggle").click();
        $("#medsosToggle").click();
        $("#bemToggle").click();
        $("#fakulUnparToggle").click();
    }
</script>