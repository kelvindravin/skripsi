<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>Dashboard</h1>
</div>

<h4 class="pl-4">Announcement</h4>
<div class="container px-2 mt-4 overflow-auto" id="admin-announce">
    <?php
    $dateNextMonth = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "+1 month"));
    $anyContent = false;
    foreach ($daftarPerusahaan as $key => $value) {
        if ($value->V_masaSelesai <= $dateNextMonth && $value->V_masaSelesai >= date("Y-m-d")) {
            echo 'Perusahaan <span class="text-info">' . $value->V_namaPerusahaan . '</span> <span class="badge badge-danger"> akan expired dalam waktu kurang dari 1 bulan</span> <br>';
            $anyContent = true;
        }
    }

    if($anyContent == false){
        echo 'Tidak ada pengumuman.';
    }
    ?>
</div>

<h4 class="pl-4 mt-4">Benefit Perusahaan</h4>
<div class="container px-2 mt-4" id="admin-announce">
    <table id="tabel_status_benefit_perusahaan" class="display table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Logo Perusahaan</th>
                <th rowspan="2">Nama Perusahaan</th>
                <th rowspan="2">Paket Member</th>
                <th colspan="4" class="text-center">Publikasi Lowongan</th>
                <th rowspan="2">Campus Hiring</th>
                <th rowspan="2">Company Branding</th>
                <th rowspan="2">UNPAR Virtual Job Fair</th>
                <th rowspan="2">Data Wisudawan</th>
            </tr>
            <tr>
                <th>Website</th>
                <th>Media Sosial</th>
                <th>BEM</th>
                <th>Fakultas / UNPAR Official</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($daftarBenefitPerusahaan as $key => $value) {
                echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td><div class="text-center"><img src="./assets/uploadedFiles/' . $value->V_logoPerusahaan . '" width="30"/></div></td>
                                <td class="text-center">' . $value->V_namaPerusahaan . '</td>
                                <td class="text-center">' . $value->V_paket . '</td>
                                <td class="text-center">' . $value->V_website . '</td>
                                <td class="text-center">' . $value->V_medsos . '</td>
                                <td class="text-center">' . $value->V_bem . '</td>
                                <td class="text-center">' . $value->V_fakulUnpar . '</td>
                                <td class="text-center">' . $value->V_campusHiring . '</td>
                                <td class="text-center">' . $value->V_companyBranding . '</td>
                                <td class="text-center">' . $value->V_vjf . '</td>
                                <td class="text-center">' . $value->V_dataWisuda . '</td>
                            </tr>
                        ';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th rowspan="2">Paket Member</th>
                <th colspan="4" class="text-center"></th>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>

</div>
<!-- Penutup div wrapper -->
</div>
</div>
<script>
    $(document).ready(function() {
        $('#tabel_status_benefit_perusahaan').DataTable({
            responsive: true,
            "ordering": false,
            pageLength: 10,
            lengthMenu: [
                [5, 10],
                [5, 10]
            ],
            initComplete: function() {
                this.api().column(3).every(function() {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });
</script>