<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>Laporan Kerjasama</h1>
    <h5>Tahun <span id="tahunLaporan"><?php echo $tahunLaporan ?></span></h5>
    <h5>Triwulan <span id="triwulanLaporan"><?php echo $triwulanLaporan ?></span></h5>
</div>

<div class="container px-2 mt-4" id="daftar-perusahaan">
    <table id="table_laporan" class="table table-striped table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th class="text-center">Perusahaan</th>
                <th class="text-center">Member</th>
                <th class="text-center">Berlaku Hingga</th>
                <th class="text-center">Nomor Surat MOA</th>
                <th class="text-center">Website</th>
                <th class="text-center">MedSos</th>
                <th class="text-center">BEM</th>
                <th class="text-center">Fakultas / UNPAR Official</th>
                <th class="text-center">Campus Hiring</th>
                <th class="text-center">Company Branding</th>
                <th class="text-center">UNPAR VJF</th>
                <th class="text-center">Data Wisudawan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($dataLaporan as $key => $value) {
                echo '
                            <tr>
                                <td class="">' . $value->V_namaPerusahaan . '</td>
                                <td class="">' . $value->V_paket . '</td>
                                <td class="text-center">' . $value->V_masaBerlaku . '</td>
                                <td class="text-center">' . $value->V_mouNo . '</td>
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
    </table>
</div>

</div>
<!-- Penutup div wrapper -->
</div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#table_laporan').DataTable({
            "scrollX": true,
            "ordering": false,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ],
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                title: 'Laporan Kerjasama'
            }]
        });
    });
</script>