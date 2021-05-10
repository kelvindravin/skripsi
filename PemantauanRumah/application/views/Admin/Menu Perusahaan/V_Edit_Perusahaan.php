<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Perusahaan | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>Edit Perusahaan</h1>
</div>

<div class="container px-2 mt-4" id="edit-perusahaan">
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
    <?php } else if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
    <?php } ?>
    <table id="table_edit_perusahaan" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Logo Perusahaan</th>
                <th>Nama Perusahaan</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daftarPerusahaan as $key => $value) {
                $statusPerusahaan = "";
                if($value->V_masaSelesai > date("Y-m-d")){
                    $statusPerusahaan = "<span class=\"badge badge-success\"> aktif </span> ";
                }else{
                    $statusPerusahaan = "<span class=\"badge badge-danger\"> expired </span> ";
                }

                echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td><div class="text-center"><img src="./assets/uploadedFiles/' . $value->V_logoPerusahaan . '" width="30"/></div></td>
                                <td>' . $value->V_namaPerusahaan . '</td>
                                <td> '. $statusPerusahaan .' </td>
                                <td> <button onclick="edit(' . $value->idPerusahaan . ')"  data-toggle="modal" data-target="#modal_user" class="btn btn-primary mx-1">Edit</button></td>
                                <td>
                                    <form id="' . $value->idPerusahaan . '" action="' . base_url('delete-perusahaan') . '">
                                    <input type="hidden" name="id" value="' . $value->idPerusahaan . '">
                                    <button class="btn btn-danger" type="button" onClick="batal(' . $value->idPerusahaan . ')"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        ';
            }
            ?>
        </tbody>
    </table>
</div>

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
        var table = $('#table_edit_perusahaan').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ]
        });
    });

    function edit(idPerusahaan) {
        $.ajax({
            // Tampilan dari Edit Perusahaan dapat dilihat pada folder views/Admin/Menu Perusahaan/Edit Perusahaan Action
            url: "<?php echo base_url('edit-perusahaan'); ?>",
            method: "POST",
            data: {
                idPerusahaan: idPerusahaan
            },
            success: function(data) {
                $("#action_view").html(data);
            }
        });
    }

    function batal(id){
        let r = confirm("Apakah anda yakin ingin menghapus Perusahaan tersebut?");
        if(r){
            document.getElementById(id).submit();
        }
    }
</script>