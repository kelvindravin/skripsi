<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kelola User | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>Kelola User</h1>
</div>

<?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
<?php } else if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
<?php } ?>

<div class="container px-2 mt-4" id="admin-announce">
    <table id="table_auth" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <?php

        foreach ($daftarAdmin as $key => $value) {
            $role = $value->N_statusAdmin;
            if ($role == 0) {
                $roleCall = "superadmin";
            } else {
                $roleCall = "admin";
            }
            echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_email . '</td>
                                <td>' . $roleCall . '</td>
                                <td>
                                    <form id="editAdmin"  method="POST" action="' . base_url('change-authority') . '">
                                        <input type="hidden" name="id" value="' . $value->idAdmin . '">
                                        <input type="hidden" name="currentRole" value="' . $value->N_statusAdmin . '">
                                        <button type="button" onClick="edit(\'editAdmin\')"  class="btn btn-sm btn-warning">Ubah</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="deleteAdmin" method="POST" action="' . base_url('delete-authority') . '">
                                        <input type="hidden" name="id" value="' . $value->idAdmin . '">
                                        <button type="button" onClick="hapus(\'deleteAdmin\')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        ';
        }
        ?>
    </table>
    <br>
    <div class="">
        <h5>Add Admin</h5>
        <form method="POST" action="<?php echo base_url('add-authority') ?>">
            <div class="row form-group">
                <label for="email" class="col-sm-3 col-form-label">Email</label>

                <div class="col-sm-3">
                    <input type="text" placeholder="email" name="email" class="form-control border" required>
                </div>
            </div>

            <div class="row form-group">
                <label for="roleAdmin" class="col-sm-3 col-form-label">Tipe Admin</label>

                <div class="col-sm-3">
                    <select class="selectpicker form-control border rounded" id="roleAdmin" name="roleAdmin" data-live-search="true" data-size="5" data-style="btn-transparant" required>
                        <option disabled hidden selected value="">Pilih Role</option>
                        <option data-tokens='admin' value='1'>Admin</option>
                        <option data-tokens='superadmin' value='0'>Super Admin</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Submit</button>
        </form>
    </div>
</div>


</div>
<!-- Penutup div wrapper -->
</div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#table_auth').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 5,
            lengthMenu: [
                [5, 10],
                [5, 10]
            ]
        });
    });

    function edit(id) {
        let r = confirm("Apakah anda yakin ingin mengubah otoritas admin tersebut?");
        if (r) {
            document.getElementById(id).submit();
        }
    }

    function hapus(id) {
        let r = confirm("Apakah anda yakin ingin menghapus admin tersebut?");
        if (r) {
            document.getElementById(id).submit();
        }
    }
</script>