<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Viewing</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <h1 class="text-center mt-5">
            Status Pemantauan Rumah
        </h1>
        <div class="text-center mb-5">
            <h5>
                Status Sensing : 
            </h5>
            <span class="badge badge-danger">Offline</span>
        </div>
    </header>

    <content>
        <div class="container">
            <div class="row text-center">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Temperatur Udara</h5>
                            <hr>
                            <span id="temperature" class="sensing-value"><strong>N/A</strong></span> °C
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_temperature">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelembaban Udara</h5>
                            <hr>
                            <span id="humidity" class="sensing-value"><strong>N/A</strong></span> RH
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_humidity">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">pH Air</h5>
                            <hr>
                            <span id="ph" class="sensing-value"><strong>N/A</strong></span>
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_ph">N/A</span>
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
                            <span id="lpg" class="sensing-value"><strong>N/A</strong></span> PPM
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_lpg">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas Karbon</h5>
                            <hr>
                            <span id="carbon" class="sensing-value"><strong>N/A</strong></span> PPM
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_carbon">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Asap</h5>
                            <hr>
                            <span id="smoke" class="sensing-value"><strong>N/A</strong></span> PPM
                            <hr>
                            Timestamp Data : <span class="badge badge-info" id="monitoring_time_smoke">N/A</span>
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
                url: "<?= site_url('C_Home/getRealtimeUpdate') ?>",
                type: "POST",
                dataType: "json",
                data: {},
                success: function(data) {
                    // replace all values and refresh the display
                    document.getElementById("temperature").innerHTML = data.newTemperature;
                    document.getElementById("monitoring_time_temperature").innerHTML = data.timestampTemperature;
                    
                    document.getElementById("humidity").innerHTML = data.newHumidity;
                    document.getElementById("monitoring_time_humidity").innerHTML = data.timestampHumidity;
                    
                    document.getElementById("ph").innerHTML = data.newPh;
                    document.getElementById("monitoring_time_ph").innerHTML = data.timestampPh;
                    
                    document.getElementById("lpg").innerHTML = data.newLPG;
                    document.getElementById("monitoring_time_lpg").innerHTML = data.timestampLPG;
                    
                    document.getElementById("carbon").innerHTML = data.newCO;
                    document.getElementById("monitoring_time_carbon").innerHTML = data.timestampCO;
                    
                    document.getElementById("smoke").innerHTML = data.newSmoke;
                    document.getElementById("monitoring_time_smoke").innerHTML = data.timestampSmoke;
                }
            });
        }, 5000);
    })
</script>
