<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Benefit | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>Edit Benefit Perusahaan</h1>
</div>
<?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
<?php } else if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
<?php } ?>

<div class="container px-2 mt-4" id="edit-perusahaan">
    <table id="table_edit_benefit" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Logo Perusahaan</th>
                <th>Nama Perusahaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daftarPerusahaan as $key => $value) {
                echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td><div class="text-center"><img src="./assets/uploadedFiles/' . $value->V_logoPerusahaan . '" width="30"/></div></td>
                                <td>' . $value->V_namaPerusahaan . '</td>
                                <td>
                                    <button onclick="edit(' . $value->idPerusahaan . ')"  data-toggle="modal" data-target="#modal_user" class="btn btn-primary mx-1">Edit</button>
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
        var table = $('#table_edit_benefit').DataTable({
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
            url: "<?php echo base_url(); ?>" + "status-benefit/edit-benefit",
            method: "POST",
            data: {
                idPerusahaan: idPerusahaan
            },
            success: function(data) {
                $("#action_view").html(data);
            }
        });
    }
</script>