<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>Log</h1>
</div>

<h4 class="pl-4 mt-4">Administrator Log</h4>
<span class="pl-4">Silahkan tekan tombol "+" untuk melihat detail waktu dari kejadian tersebut.</span>
<div class="container px-2 mt-4" id="admin-announce">
    <table id="table_log_admin" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Log</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($log as $key => $value) {
                echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>' . $value->V_log . '</td>
                                <td>' . $value->T_waktu . '</td>
                            </tr>
                        ';
            }
            ?>
        </tbody>
    </table>
</div>

</div>
<!-- Penutup div wrapper -->
</div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#table_log_admin').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 5,
            lengthMenu: [
                [5, 10],
                [5, 10]
            ]
        });
    });
</script>