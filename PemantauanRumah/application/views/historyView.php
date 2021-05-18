<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - History</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <h1 class="text-center mt-5 mb-5">
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
                            <td><?php echo $value->timestamp; ?></td>
                            <td><?php echo $value->sensorPengukur; ?></td>
                            <td><?php echo $value->pengukuran; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
			<a href="<?php echo base_url('history'); ?>" class="btn btn-danger">Kembali</a>
        </div>
    </content>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table_history').DataTable({
            pageLength: 5,
            ordering: false,
            lengthMenu: [
                [5, 10],
                [5, 10]
            ]
        })
    });
</script>
