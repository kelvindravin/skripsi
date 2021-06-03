<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Viewing</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <h1 class="text-center mt-1">
            Status Pemantauan Rumah
        </h1>
        <div class="text-center mb-2">
            <h5>
                Status Sensor :
            </h5>
            <span id="statusSensing">N/A</span>
        </div>
    </header>

    <content>
        <div class="container-fluid mb-4">
            <div class="row text-center d-flex align-items-center justify-content-center">
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Temperatur Udara</h5>
                            <h7 class="text text-info"><span id="temperature_loc"></span></h7>
                            <hr>
                            <span id="temperature" class="sensing-value"><strong>N/A</strong></span> °C
                            <br>
                            <span id="temperature_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_temperature">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kelembaban Udara</h5>
                            <h7 class="text text-info"><span id="humidity_loc"></span></h7>
                            <hr>
                            <span id="humidity" class="sensing-value"><strong>N/A</strong></span> RH
                            <br>
                            <span id="humidity_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_humidity">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas LPG</h5>
                            <h7 class="text text-info"><span id="lpg_loc"></span></h7>
                            <hr>
                            <span id="lpg" class="sensing-value"><strong>N/A</strong></span> PPM
                            <br>
                            <span id="lpg_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_lpg">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Gas Karbon</h5>
                            <h7 class="text text-info"><span id="carbon_loc"></span></h7>
                            <hr>
                            <span id="carbon" class="sensing-value"><strong>N/A</strong></span> PPM
                            <br>
                            <span id="carbon_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_carbon">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kadar Asap</h5>
                            <h7 class="text text-info"><span id="smoke_loc"></span></h7>
                            <hr>
                            <span id="smoke" class="sensing-value"><strong>N/A</strong></span> PPM
                            <br>
                            <span id="smoke_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_smoke">N/A</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center d-flex align-items-center justify-content-center mt-4">
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">pH Air</h5>
                            <h7 class="text text-info"><span id="ph_loc"></span></h7>
                            <hr>
                            <span id="ph" class="sensing-value"><strong>N/A</strong></span>
                            <br>
                            <span id="ph_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_ph">N/A</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kekeruhan Air</h5>
                            <h7 class="text text-info"><span id="turbidity_loc"></span></h7>
                            <hr>
                            <span id="turbidity" class="sensing-value"><strong>N/A</strong></span> NTU
                            <br>
                            <span id="turbidity_warning"></span>
                            <hr>
                            Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_turbidity">N/A</span>
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
            // realtime update from server
            $.ajax({
                url: "<?= site_url('C_Home/getRealtimeUpdate') ?>",
                type: "POST",
                dataType: "json",
                data: {},
                success: function(data) {
                    // counting violation of detection for parameters
                    if (data.newLPG > 100) {
                        document.getElementById("lpg_warning").innerHTML = "<span class=\"badge badge-danger\">Kandungan LPG melebihi batas</span>";
                    } else {
                        document.getElementById("lpg_warning").innerHTML = "<span class=\"badge badge-success\">Kandungan LPG tidak terdeteksi</span>";
                    }

                    if (data.newSmoke >= 100) {
                        document.getElementById("smoke_warning").innerHTML = "<span class=\"badge badge-danger\">Kandungan asap melebihi batas</span>";
                    } else {
                        document.getElementById("smoke_warning").innerHTML = "<span class=\"badge badge-success\">Kandungan asap tidak terdeteksi</span>";
                    }

                    if (data.newCO >= 25) {
                        document.getElementById("carbon_warning").innerHTML = "<span class=\"badge badge-danger\">Kandungan CO melebihi batas</span>";
                    } else {
                        document.getElementById("carbon_warning").innerHTML = "<span class=\"badge badge-success\">Kandungan CO tidak terdeteksi</span>";
                    }

                    if (data.newTemperature > 25) {
                        document.getElementById("temperature_warning").innerHTML = "<span class=\"badge badge-warning\">Suhu diatas suhu normal</span>";
                    } else {
                        document.getElementById("temperature_warning").innerHTML = "<span class=\"badge badge-success\">Suhu ruangan normal</span>";
                    }

                    if (data.newHumidity > 70) {
                        document.getElementById("humidity_warning").innerHTML = "<span class=\"badge badge-danger\">Kelembaban terlalu tinggi</span>";
                    } else if (data.newHumidity < 20) {
                        ocument.getElementById("humidity_warning").innerHTML = "<span class=\"badge badge-danger\">Kelembaban terlalu rendah</span>";
                    } else {
                        document.getElementById("humidity_warning").innerHTML = "<span class=\"badge badge-success\">Kelembaban normal</span>";
                    }

                    if (data.newPh < 7) {
                        document.getElementById("ph_warning").innerHTML = "<span class=\"badge badge-warning\">pH air terlalu asam</span>";
                    } else if (data.newPh > 8) {
                        document.getElementById("ph_warning").innerHTML = "<span class=\"badge badge-warning\">pH air terlalu basa</span>";
                    } else {
                        document.getElementById("ph_warning").innerHTML = "<span class=\"badge badge-success\">pH air netral</span>";
                    }

                    if (data.newTurbidity > 0) {
                        document.getElementById("turbidity_warning").innerHTML = "<span class=\"badge badge-warning\">Air terpantau keruh</span>";
                    } else {
                        document.getElementById("turbidity_warning").innerHTML = "<span class=\"badge badge-success\">Air terpantau jernih</span>";
                    }

                    //current time for sensor activity check
                    var currentTime = Date.now();
                    
                    // replace all values and refresh the display, and check if the diff between current time and sensing time 
                    // divided by 1000 (to make it in seconds)
                    // is more than 5 minutes (if > 5 minutes, then the sensor will be marked as N/A)
                    
                    var checkTemperatureTime = (new Date(data.timestampTemperature) / 1000 ) + "000";
                    if((currentTime - checkTemperatureTime) / 1000 > 300){
                        document.getElementById("temperature").innerHTML = "N/A";
                        document.getElementById("temperature_loc").innerHTML = "N/A";
                        document.getElementById("monitoring_time_temperature").innerHTML = data.timestampTemperature;
                        document.getElementById("temperature_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";
                    }else{
                        document.getElementById("temperature").innerHTML = data.newTemperature;
                        document.getElementById("temperature_loc").innerHTML = data.newTemperatureLoc;
                        document.getElementById("monitoring_time_temperature").innerHTML = data.timestampTemperature;
                    }

                    var checkHumidityTime = (new Date(data.timestampHumidity) / 1000 ) + "000";
                    if((currentTime - checkHumidityTime) / 1000  > 300){
                        document.getElementById("humidity").innerHTML = "N/A";
                        document.getElementById("humidity_loc").innerHTML = "N/A";
                        document.getElementById("monitoring_time_humidity").innerHTML = data.timestampHumidity;
                        document.getElementById("humidity_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";
                    }else{
                        document.getElementById("humidity").innerHTML = data.newHumidity;
                        document.getElementById("humidity_loc").innerHTML = data.newHumidityLoc;
                        document.getElementById("monitoring_time_humidity").innerHTML = data.timestampHumidity;
                    }
                    
                    var checkpHTime = (new Date(data.timestampPh) / 1000 ) + "000";
                    if((currentTime - checkpHTime) / 1000  > 300){
                        document.getElementById("ph").innerHTML = "N/A";
                        document.getElementById("ph_loc").innerHTML = "N/A";
                        document.getElementById("monitoring_time_ph").innerHTML = data.timestampPh;
                        document.getElementById("ph_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";
                    }else{
                        document.getElementById("ph").innerHTML = data.newPh;
                        document.getElementById("ph_loc").innerHTML = data.newPhLoc;
                        document.getElementById("monitoring_time_ph").innerHTML = data.timestampPh;

                    }

                    var checkTurbidityTime = (new Date(data.timestampTurbidity) / 1000 ) + "000";
                    if((currentTime - checkTurbidityTime) / 1000  > 300){
                        document.getElementById("turbidity").innerHTML = "N/A";
                        document.getElementById("turbidity_loc").innerHTML = "N/A";
                        document.getElementById("monitoring_time_turbidity").innerHTML = data.timestampTurbidity;
                        document.getElementById("turbidity_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";
                    }else{
                        document.getElementById("turbidity").innerHTML = data.newTurbidity;
                        document.getElementById("turbidity_loc").innerHTML = data.newTurbidityLoc;
                        document.getElementById("monitoring_time_turbidity").innerHTML = data.timestampTurbidity;
                    }    
                        
                    var checkLPGTime = (new Date(data.timestampLPG) / 1000 ) + "000";
                    if((currentTime - checkLPGTime) / 1000  > 300){
                        document.getElementById("lpg").innerHTML = "N/A";
                        document.getElementById("lpg_loc").innerHTML = "N/A";
                        document.getElementById("monitoring_time_lpg").innerHTML = data.timestampLPG;
                        document.getElementById("lpg_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";
                    }else{
                        document.getElementById("lpg").innerHTML = data.newLPG;
                        document.getElementById("lpg_loc").innerHTML = data.newLPGLoc;
                        document.getElementById("monitoring_time_lpg").innerHTML = data.timestampLPG;
                    }
                    
                    var checkCOTime = (new Date(data.timestampCO) / 1000 ) + "000";
                    if((currentTime - checkLPGTime) / 1000  > 300){
                        document.getElementById("carbon").innerHTML = "N/A";
                        document.getElementById("carbon_loc").innerHTML = "N/A";
                        document.getElementById("monitoring_time_carbon").innerHTML = data.timestampCO;
                        document.getElementById("carbon_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";
                    }else{
                        document.getElementById("carbon").innerHTML = data.newCO;
                        document.getElementById("carbon_loc").innerHTML = data.newCOLoc;
                        document.getElementById("monitoring_time_carbon").innerHTML = data.timestampCO;
                    }

                    var checkSmokeTime = (new Date(data.timestampSmoke) / 1000 ) + "000";
                    if((currentTime - checkSmokeTime) / 1000  > 300){
                        document.getElementById("smoke").innerHTML = "N/A";
                        document.getElementById("smoke_loc").innerHTML = "N/A";
                        document.getElementById("monitoring_time_smoke").innerHTML = data.timestampSmoke;
                        document.getElementById("smoke_warning").innerHTML = "<span class=\"badge badge-danger\">OFFLINE</span>";
                    }else{
                        document.getElementById("smoke").innerHTML = data.newSmoke;
                        document.getElementById("smoke_loc").innerHTML = data.newSmokeLoc;
                        document.getElementById("monitoring_time_smoke").innerHTML = data.timestampSmoke;
                    }
                }
            });

            // checking sensing status
            $.ajax({
                url: "<?= site_url('C_Home/getSensingStatus') ?>",
                type: "POST",
                dataType: "json",
                data: {},
                success: function(status) {
                    // finding difference between now and last timestamp
                    var last_timestamp = new Date(status.sensingStatus);
                    var last_timestamp_seconds = (last_timestamp.getTime() / 1000) + "000";
                    var curr_timestamp = Date.now();
                    var difference = curr_timestamp - last_timestamp_seconds;

                    //printing offline if the time diff is more than 5 minutes
                    if ((difference / 1000) >= 300) {
                        document.getElementById("statusSensing").innerHTML = "<span class=\"badge badge-danger\">Offline</span>"
                    } else {
                        document.getElementById("statusSensing").innerHTML = "<span class=\"badge badge-success\">Online</span>"
                    }
                }
            });
        }, 5000);
    })
</script>
