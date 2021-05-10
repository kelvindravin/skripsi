<div class="modal-header">
    <h5 class="modal-title">Edit Benefit VJF</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="POST" class="d-flex flex-column" action="edit-BenefitVJF" enctype="multipart/form-data">
        <input type="hidden" name="idPerusahaan" value="<?php echo $dataPerusahaan[0]->idPerusahaan ?>" />
        <input type="hidden" name="idBenefit" value="<?php echo $benefit[0]->idBenefit ?>" />
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

                <!-- Identitas Benefit -->
                <div class="col-sm-9">
                    <h5>Data Kegiatan</h5>
                    <div class="row form-group">
                        <label for="tglKegiatan" class="col-sm-4 col-form-label">Tgl Kegiatan</label>

                        <div class="col-sm-8">
                            <input type="date" class="form-control border" id="tglKegiatan" name="tglKegiatan" value="<?php echo $benefit[0]->V_tglPelaksaan; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>