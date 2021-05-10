<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>History Detail Benefit Lainnya | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>History Detail Benefit Lainnya dari <span class="text text-primary"><?php echo $dataPerusahaan[0]->V_namaPerusahaan ?></span></h1>
</div>

<?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
<?php } else if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
<?php } ?>

<div class="text-center">
    <a class="btn btn-info ml-3" id="campHiringToggle" href="#table-history-campHiring" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">Campus Hiring</a>
    <a class="btn btn-info ml-3" id="compBrandingToggle" href="#table-history-compBranding" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">Company Branding</a>
    <a class="btn btn-info ml-3" id="vjfToggle" href="#table-history-vjf" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">VJF</a>
    <a class="btn btn-info ml-3" id="dataWisudaToggle" href="#table-history-dataWisuda" data-toggle="collapse" class="dropdown-toggle" aria-expanded="true">Data Wisuda</a>
    <a class="btn btn-info ml-3 text text-white" onclick="expandAll()">All</a>
</div>

<!-- Campus Hiring -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-campHiring">
    <h4>Campus Hiring</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_campHiring" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Jurusan Sasaran</th>
                    <th>Materi Publikasi</th>
                    <th>Action</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataCampHiring as $key => $value) {

                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_tglPelaksaan . '</td>
                                <td>' . $value->V_jurusanTerlibat . '</td>
                                <td>' . $value->V_linkMateri . '</td>
                                <td>
                                    <button onclick="editCH(' . $value->idBenefit . ')" data-toggle="modal" data-target="#modal_user" class="btn  btn-sm btn-primary mx-1">Edit</button>
                                </td>
                                <td>
                                    <form id="deleteCH" method="POST" action="' . base_url('delete-benefit-ch') . '">
                                        <input type="hidden" name="id" value="' . $value->idBenefit . '">
                                        <input type="hidden" name="idPerusahaan" value="' . $dataPerusahaan[0]->idPerusahaan . '">
                                        <button type="button" onClick="hapusCH(\'deleteCH\')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</ul>

<!-- Company Branding -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-compBranding">
    <h4>Company Branding</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_compBranding" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Jurusan Sasaran</th>
                    <th>Materi Publikasi</th>
                    <th>Action</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataCompBranding as $key => $value) {

                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_tglPelaksaan . '</td>
                                <td>' . $value->V_jurusanTerlibat . '</td>
                                <td>' . $value->V_linkMateri . '</td>
                                <td>
                                    <button onclick="editCB(' . $value->idBenefit . ')" data-toggle="modal" data-target="#modal_user" class="btn  btn-sm btn-primary mx-1">Edit</button>
                                </td>
                                <td>
                                    <form id="deleteCB" method="POST" action="' . base_url('delete-benefit-cb') . '">
                                        <input type="hidden" name="id" value="' . $value->idBenefit . '">
                                        <input type="hidden" name="idPerusahaan" value="' . $dataPerusahaan[0]->idPerusahaan . '">
                                        <button type="button" onClick="hapusCB(\'deleteCB\')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</ul>

<!-- vjf -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-vjf">
    <h4>VJF</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_vjf" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataVjf as $key => $value) {

                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_tglPelaksaan . '</td>
                                <td>
                                    <button onclick="editVJF(' . $value->idBenefit . ')" data-toggle="modal" data-target="#modal_user" class="btn  btn-sm btn-primary mx-1">Edit</button>
                                </td>
                                <td>
                                    <form id="deleteVJF" method="POST" action="' . base_url('delete-benefit-vjf') . '">
                                        <input type="hidden" name="id" value="' . $value->idBenefit . '">
                                        <input type="hidden" name="idPerusahaan" value="' . $dataPerusahaan[0]->idPerusahaan . '">
                                        <button type="button" onClick="hapusVJF(\'deleteVJF\')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        ';
                }
                ?>
            </tbody>
        </table>
    </div>
</ul>

<!-- dataWisuda -->
<ul class="collapse list-unstyled ml-5 mt-5" id="table-history-dataWisuda">
    <h4>Data Wisuda</h4>
    <div class="container px-2 mt-4">
        <table id="table_history_dataWisuda" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Jurusan Sasaran</th>
                    <th>Action</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dataWisuda as $key => $value) {

                    echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_tglPelaksaan . '</td>
                                <td>' . $value->V_jurusanTerlibat . '</td>
                                <td>
                                    <button onclick="editDW(' . $value->idBenefit . ')" data-toggle="modal" data-target="#modal_user" class="btn  btn-sm btn-primary mx-1">Edit</button>
                                </td>
                                <td>
                                    <form id="deleteDW" method="POST" action="' . base_url('delete-benefit-dw') . '">
                                        <input type="hidden" name="id" value="' . $value->idBenefit . '">
                                        <input type="hidden" name="idPerusahaan" value="' . $dataPerusahaan[0]->idPerusahaan . '">
                                        <button type="button" onClick="hapusDW(\'deleteDW\')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
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
        var table = $('#table_history_campHiring').DataTable({
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
        var table = $('#table_history_compBranding').DataTable({
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
        var table = $('#table_history_vjf').DataTable({
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
        var table = $('#table_history_dataWisuda').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ]
        });
    });

    function editCH(idBenefit) {
        var idPerusahaan = '<?php echo $dataPerusahaan[0]->idPerusahaan; ?>';
        $.ajax({
            // Tampilan dari Edit Perusahaan dapat dilihat pada folder views/Admin/Menu Perusahaan/Benefit Lainnya
            url: "<?php echo base_url('editBenefitCH'); ?>",
            method: "POST",
            data: {
                idBenefit: idBenefit,
                idPerusahaan: idPerusahaan
            },
            success: function(data) {
                $("#action_view").html(data);
            }
        });
    }

    function editCB(idBenefit) {
        var idPerusahaan = '<?php echo $dataPerusahaan[0]->idPerusahaan; ?>';
        $.ajax({
            // Tampilan dari Edit Perusahaan dapat dilihat pada folder views/Admin/Menu Perusahaan/Benefit Lainnya
            url: "<?php echo base_url('editBenefitCB'); ?>",
            method: "POST",
            data: {
                idBenefit: idBenefit,
                idPerusahaan: idPerusahaan
            },
            success: function(data) {
                $("#action_view").html(data);
            }
        });
    }

    function editVJF(idBenefit) {
        var idPerusahaan = '<?php echo $dataPerusahaan[0]->idPerusahaan; ?>';
        $.ajax({
            // Tampilan dari Edit Perusahaan dapat dilihat pada folder views/Admin/Menu Perusahaan/Benefit Lainnya
            url: "<?php echo base_url('editBenefitVJF'); ?>",
            method: "POST",
            data: {
                idBenefit: idBenefit,
                idPerusahaan: idPerusahaan
            },
            success: function(data) {
                $("#action_view").html(data);
            }
        });
    }

    function editDW(idBenefit) {
        var idPerusahaan = '<?php echo $dataPerusahaan[0]->idPerusahaan; ?>';
        $.ajax({
            // Tampilan dari Edit Perusahaan dapat dilihat pada folder views/Admin/Menu Perusahaan/Benefit Lainnya
            url: "<?php echo base_url('editBenefitDW'); ?>",
            method: "POST",
            data: {
                idBenefit: idBenefit,
                idPerusahaan: idPerusahaan
            },
            success: function(data) {
                $("#action_view").html(data);
            }
        });
    }

    $(document).ready(function() {
        $("#campHiringToggle").click();
        $("#compBrandingToggle").click();
        $("#vjfToggle").click();
        $("#dataWisudaToggle").click();
    });

    function expandAll() {
        $("#campHiringToggle").click();
        $("#compBrandingToggle").click();
        $("#vjfToggle").click();
        $("#dataWisudaToggle").click();
    }

    function hapusCH(id) {
        let r = confirm("Apakah anda yakin ingin menghapus benefit Campus Hiring tersebut?");
        if (r) {
            document.getElementById(id).submit();
        }
    }

    function hapusCB(id) {
        let r = confirm("Apakah anda yakin ingin menghapus benefit Company Branding tersebut?");
        if (r) {
            document.getElementById(id).submit();
        }
    }

    function hapusVJF(id) {
        let r = confirm("Apakah anda yakin ingin menghapus benefit VJF tersebut?");
        if (r) {
            document.getElementById(id).submit();
        }
    }

    function hapusDW(id) {
        let r = confirm("Apakah anda yakin ingin menghapus benefit Data Wisuda tersebut?");
        if (r) {
            document.getElementById(id).submit();
        }
    }
</script>