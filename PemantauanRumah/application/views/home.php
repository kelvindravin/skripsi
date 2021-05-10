<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dota 2 Statistics - Home</title>
</head>

<body class="d-flex flex-column min-vh-100" style="
      background-image: url('https://i.pinimg.com/originals/0d/91/db/0d91dbf119a1c9f4cf500aaf7e695539.jpg');
    ">
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
    <?php } ?>
    <header>
        <h1 class="text-center mt-5 text-white" style=" color: white; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
            Welcome to Dota 2 Statistics
        </h1>
    </header>

    <content>
        <div class="container mt-5" style=" color: white; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
            <div class="mt-5">
                <h4 class="text-center">Cari Player Berdasarkan Dota 2 PlayerID</h4>
                <form action="searchByID" class="text-center mt-3" enctype="multipart/form-data" method="post">
                    <input type="text" id="playerid" name="playerid" placeholder="Dota 2 Player ID" required>
                    <input type="submit" class="btn btn-info" value="Cari">
                </form>
            </div>

            <div class="mt-5">
                <h4 class="text-center">Cari Steam PlayerID Berdasarkan Dota 2 Persona Name</h4>
                <form action="searchByPersonaName" class="text-center mt-3" enctype="multipart/form-data" method="post">
                    <input type="text" id="playerpersona" name="playerpersona" placeholder="Dota 2 Persona Name" required>
                    <input type="submit"  class="btn btn-info" value="Cari">
                </form>
            </div>
        </div>
    </content>
</body>

</html>