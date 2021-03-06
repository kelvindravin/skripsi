<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Cari</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <h1 class="text-center mt-5 mb-5">
            History Pemantauan Rumah
        </h1>
    </header>

    <content>
        <!-- Search Monitoring -->
        <div class="container">
            <form method="POST" action="filterMonitoring" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="">Dari Tanggal</div>
                        <input type="date" class="form-control border" name="tanggalMulai"/>
                    </div>
                    <div class="col-sm-6">
                        <div class="">Hingga Tanggal</div>
                        <input type="date" class="form-control border" name="tanggalSelesai"/>
                    </div>
                </div>
                <br>
                <div>
                Pilih Parameter Sensor*
                <div class="text text-danger">*Kosongkan untuk menampilkan seluruh parameter sensor</div>
                
                    <?php 
                    
                        foreach ($listSensors as $key => $value) {
                            echo '
                                <input type="checkbox" name="parameter[]" value="'.$value['identitasSensor'].'"> '.$value['identitasSensor'].' <br>
                            ';
                        }
                    ?>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-info">Cari</button>
                </div>
            </form>
        </div>
    </content>
</body>

</html>
