<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - History</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <h1 class="text-center mt-5 text-white" style=" color: white; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
            History of Pemantauan
        </h1>
    </header>

    <content>
        <div class="container">
            <table id="table_history" class="table table-striped dt-responsive nowrap container-fluid">
                <thead>
                    <tr>
                        <th>Timestamp Pemantauan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dataPengukuran as $key => $value) {
                    ?>
                        <tr>
                            <td><?php echo $value->timestamp; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </content>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table_history').DataTable()
    });
</script>