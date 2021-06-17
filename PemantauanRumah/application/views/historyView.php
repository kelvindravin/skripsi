<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - History</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <h1 class="text-center mt-1 mb-1">
            History Pemantauan Rumah
        </h1>
    </header>

    <content>
        <!-- View Monitoring -->
        <div class="container">
            <table id="table_history" class="table table-striped dt-responsive nowrap container-fluid">
                <thead>
                    <tr>
                        <th>Timestamp Pemantauan</th>
                        <th>Tipe Sensor</th>
                        <th>Nilai Pengukuran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dataHistory as $key => $value) {
                    ?>
                        <tr>
                            <td><?php echo $value->waktu; ?></td>
                            <td><?php echo $value->identitasSensor; ?></td>
                            <td><?php echo $value->nilaiPengukuran; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mb-4">
			<a href="<?php echo base_url('history'); ?>" class="btn btn-danger">Kembali</a>
        </div>
    </content>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table_history').DataTable({
            pageLength: 7,
            ordering: false,
            lengthMenu: [
                [7, 14],
                [7, 14]
            ]
        })
    });
</script>
