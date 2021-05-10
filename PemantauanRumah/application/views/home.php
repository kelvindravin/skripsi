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
        <h1 class="text-center mt-5 text-white" style=" color: white; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
            Welcome to Pemantauan Rumah
        </h1>
    </header>

    <content>
        <div class="container">
            temperature = <?php echo $temperature[0]->pengukuran ?> <br>
            ph = <?php echo $ph[0]->pengukuran ?> <br>
            humidity = <?php echo $humidity[0]->pengukuran ?> <br>
            lpg = <?php echo $lpg[0]->pengukuran ?> <br>
            carbon = <?php echo $carbon[0]->pengukuran ?> <br>
            smoke = <?php echo $smoke[0]->pengukuran ?> <br>
        </div>
    </content>
</body>

</html>
