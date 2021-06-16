<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Viewing</title>
</head>

<body class="d-flex flex-column min-vh-100 main-body">
    <content class="main-body">
        <h1 class="text-center mt-1 mb-5 py-2 text text-light bg bg-dark t">
            Status Pemantauan Kondisi Parameter Rumah
        </h1>
        <div class="container-fluid mb-4">
            <?php 
                $colCount = 0;
                foreach ($readings as $value) {
                    if($colCount == 0){
                        echo '<div class="row text-center d-flex align-items-center justify-content-center">'; 
                        $colCount++;
                    }
                    
                    echo '
                                
                            <div class="card mx-2 my-2">
                                <div class="card-body">
                                    <h5 class="card-title">'. $value->identitasLengkap .'</h5>
                                    <h7 class="text text-info"><span id="'. $value->identitasLengkap .'_loc"></span></h7>
                                    <hr>
                                    <span id="'. $value->identitasLengkap .'" class="sensing-value"><strong>N/A</strong></span> '. $value->satuanLengkap .'
                                    <br>
                                    <span id="'. $value->identitasLengkap .'_warning"></span>
                                    <hr>
                                    Pemeriksaan Terakhir : <span class="badge badge-info" id="monitoring_time_'. $value->identitasLengkap .'">N/A</span>
                                </div>
                            </div>
                            
                            ';
                        
                    $colCount++;
                    
                    if($colCount > 5){
                        $colCount = 0;
                        echo '</div>'; 
                    }
                }
            ?>
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
                    /*
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
                    */
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
                    /*
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
                    */
                }
            });
        }, 5000);
    })
</script>
