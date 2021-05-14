<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Viewing</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
    <?php } ?>

    <header>
        <h1 class="text-center mt-5">
            Status Sensor
        </h1>
        <h3 class="text-center mb-4">
            <!-- Insert Sensor Status Here -->
            <span class="badge badge-danger">Offline</span>
        </h3>
    </header>

    <content>
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Temperatur Udara</h5>
                            <hr>
                            <span id="temperature" class="sensing-value"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelembaban Udara</h5>
                            <hr>
                            <span id="humidity" class="sensing-value"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">pH Air</h5>
                            <hr>
                            <span id="ph" class="sensing-value"><strong></strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center mt-4">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas LPG</h5>
                            <hr>
                            <span id="lpg" class="sensing-value"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas Carbon Monoxide</h5>
                            <hr>
                            <span id="carbon" class="sensing-value"><strong></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Asap</h5>
                            <hr>
                            <span id="smoke" class="sensing-value"><strong></strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </content>
</body>

</html>

<!-- Realtime Update Script -->
<script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: "<?= base_url() ?>C_Home/getRealtimeUpdate",
                type: "POST",
                dataType: "json",
                data: {},
                success: function(data) {
                    // replace all values and refresh the display
                    document.getElementById("temperature").innerHTML = data.newTemperature;
                    document.getElementById("humidity").innerHTML = data.newHumidity;
                    document.getElementById("ph").innerHTML = data.newPh;
                    document.getElementById("lpg").innerHTML = data.newLPG;
                    document.getElementById("carbon").innerHTML = data.newCO;
                    document.getElementById("smoke").innerHTML = data.newSmoke;
                }
            });
        }, 10000);
    })
</script>