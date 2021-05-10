<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Perusahaan | Formulir Kerjasama Perusahaan</title>
</head>

<div class="text-center">
    <h1>Daftar Perusahaan</h1>
</div>

<div class="container px-2 mt-4" id="daftar-perusahaan">
    <table id="table_daftar_perusahaan" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Logo Perusahaan</th>
                <th>Nama Perusahaan</th>
                <th>Bidang Usaha</th>
                <th>Paket Kerjasama</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Website</th>
                <th>Jml Karyawan</th>
                <th>Jml Lulusan UNPAR</th>
                <th>Nama PIC</th>
                <th>Email</th>
                <th>No HP/WhatsApp</th>
                <th>Masa Berlaku</th>
                <th>Masa Selesai</th>
                <th>Bukti Pembayaran</th>
                <th>No MOA</th>
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
                                <td>' . $value->V_bidangUsaha . '</td>
                                <td>' . $value->V_paket . '</td>
                                <td>' . $value->V_alamatPerusahaan . '</td>
                                <td>' . $value->V_kontakPerusahaan . '</td>
                                <td>' . $value->V_websitePerusahaan . '</td>
                                <td>' . $value->V_jumlahKaryawan . '</td>
                                <td>' . $value->V_jumlahLulusanUnpar . '</td>
                                <td>' . $value->V_namaPic . '</td>
                                <td>' . $value->V_emailPic . '</td>
                                <td>' . $value->V_noTelpPic . '</td>
                                <td>' . $value->V_masaBerlaku . '</td>
                                <td>' . $value->V_masaSelesai . '</td>
                                <td>' . $value->V_buktiPembayaran . '</td>
                                <td>' . $value->V_mouNo . '</td>
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
        var table = $('#table_daftar_perusahaan').DataTable({
            responsive: true,
            "ordering": true,
            pageLength: 10,
            lengthMenu: [
                [10, 20],
                [10, 20]
            ]
        });
    });
</script>