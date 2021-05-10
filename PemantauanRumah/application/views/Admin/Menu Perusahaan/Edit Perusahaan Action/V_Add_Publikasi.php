<div class="modal-header">
    <h5 class="modal-title">Add Publikasi Loker</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="POST" class="d-flex flex-column" action="addPublikasi" enctype="multipart/form-data">
        <input type="hidden" name="idPerusahaan" value="<?php echo $dataPerusahaan[0]->idPerusahaan ?>" />
        <div class="container middle-content-form mt-3 py-3 px-3">
            <!-- Data Diri Perusahaan -->
            <hr>
            <div class="row">
                <!-- Logo Perusahaan -->
                <div class="col-sm-3 text-center">
                    <img src="./assets/images/Logo_LPPK_White_Base.png" width="150">
                    <h4 class="mt-4">Member </h4>
                    <h4><span id="tipeMember"><?php echo $dataPerusahaan[0]->V_paket; ?></span></h4>
                </div>

                <!-- Identitas Lowongan -->
                <div class="col-sm-9">
                    <h5>Publikasi Lowongan</h5>
                    <div class="pl-2 mt-2">

                        <div class="row form-group">
                            <label for="judulLowongan" class="col-sm-4 col-form-label">Judul Lowongan</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control border" id="judulLowongan" name="judulLowongan" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="tglPermohonan" class="col-sm-4 col-form-label">Tgl Permohonan</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control border" id="tglPermohonan" name="tglPermohonan" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="tglBatas" class="col-sm-4 col-form-label">Tgl Batas Pendaftaran</label>

                            <div class="col-sm-8">
                                <input type="date" class="form-control border" id="tglBatas" name="tglBatas" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="arsipMateri" class="col-sm-4 col-form-label">Arsip Materi (link)</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control border" id="arsipMateri" name="arsipMateri">
                            </div>
                        </div>
                    </div>


                    <div class="pl-2 mt-2 row">
                        <div class="col-sm-6">
                            <h5>Media Publikasi</h5>
                            <input type="hidden" name="website" value="0">
                            <input type="checkbox" name="website" value="1"> Website
                            <br>
                            <input type="hidden" name="medsos" value="0">
                            <input type="checkbox" name="medsos" value="1"> Media Sosial
                            <br>
                            <input type="hidden" name="bem" value="0">
                            <input type="checkbox" name="bem" value="1"> BEM
                            <br>
                            <input type="hidden" name="fakulUnpar" value="0">
                            <input type="checkbox" name="fakulUnpar" value="1"> Fakultas/UNPAR Official
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mt-2">Add</button>
    </form>
</div>