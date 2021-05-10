<div class="modal-header">
    <h5 class="modal-title">Edit Benefit Perusahaan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="post" class="d-flex flex-column" action="edit-benefit-perusahaan" enctype="multipart/form-data">
        <input type="hidden" name="idPerusahaan" value="<?php echo $dataPerusahaan[0]->idPerusahaan ?>" />
        <div class="container middle-content-form mt-3 py-3 px-3">
            <!-- Data Diri Perusahaan -->
            <hr>
            <div class="row">
                <!-- Logo Perusahaan -->
                <div class="col-sm-3 text-center">
                    <img src="./assets/images/Logo_LPPK_White_Base.png" width="150">
                    <h4 class="mt-4">Member </h4>
                    <h4><span id="tipeMember"><?php echo $dataPerusahaan[0]->V_paket ?></span></h4>
                </div>

                <!-- Identitas Perusahaan -->
                <div class="col-sm-9">
                    <h4>Publikasi Lowongan</h4>
                    <!-- website -->
                    <div class="row form-group">
                        <label for="website" class="col-sm-4 col-form-label">Website</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'website\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_website ?>" class="form-control border" id="website" name="website" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('website')">-</a>
                        </div>
                    </div>

                    <!-- medsos -->
                    <div class="row form-group">
                        <label for="medsos" class="col-sm-4 col-form-label">Medsos</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'medsos\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_medsos ?>" class="form-control border" id="medsos" name="medsos" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('medsos')">-</a>
                        </div>
                    </div>

                    <!-- medsos bem -->
                    <div class="row form-group">
                        <label for="medsosBem" class="col-sm-4 col-form-label">Medsos BEM</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'medsosBem\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_bem ?>" class="form-control border" id="medsosBem" name="medsosBem" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('medsosBem')">-</a>
                        </div>
                    </div>

                    <!-- fakultas / unpar official-->
                    <div class="row form-group">
                        <label for="fakulUnpar" class="col-sm-4 col-form-label">Fakultas / UNPAR Official</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'fakulUnpar\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_fakulUnpar ?>" class="form-control border" id="fakulUnpar" name="fakulUnpar" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('fakulUnpar')">-</a>
                        </div>
                    </div>

                    <!-- campus hiring -->
                    <div class="row form-group">
                        <label for="campHiring" class="col-sm-4 col-form-label">Campus Hiring</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'campHiring\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_campusHiring ?>" class="form-control border" id="campHiring" name="campHiring" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('campHiring')">-</a>
                        </div>
                    </div>

                    <!-- company branding -->
                    <div class="row form-group">
                        <label for="compBranding" class="col-sm-4 col-form-label">Company Branding</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'compBranding\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_companyBranding ?>" class="form-control border" id="compBranding" name="compBranding" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('compBranding')">-</a>
                        </div>
                    </div>

                    <!-- vjf -->
                    <div class="row form-group">
                        <label for="vjf" class="col-sm-4 col-form-label">VJF</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'vjf\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_vjf ?>" class="form-control border" id="vjf" name="vjf" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('vjf')">-</a>
                        </div>
                    </div>

                    <!-- data wisuda -->
                    <div class="row form-group">
                        <label for="dataWisuda" class="col-sm-4 col-form-label">Data Wisuda</label>
                        <?php if($this->session->userdata('usertype') == 'superadmin'){
                            echo '
                            <div class="col-sm-2">
                            <a class="btn btn-primary text text-white" onclick="increaseValue(\'dataWisuda\')">+</a>
                            </div>
                            ';
                        }?>
                        <div class="col-sm-4">
                            <input type="text" value="<?php echo $dataBenefit[0]->V_dataWisuda ?>" class="form-control border" id="dataWisuda" name="dataWisuda" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-danger  text text-white" onclick="decreaseValue('dataWisuda')">-</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>
<script>
    function increaseValue(id) {
        if (document.getElementById(id).value === "Unlimited") {

        } else {
            var value = parseInt(document.getElementById(id).value, 10);
            var result = value + 1;
            document.getElementById(id).value = result;
        }
    }

    function decreaseValue(id) {
        if (document.getElementById(id).value === "Unlimited") {

        } else {
            var value = parseInt(document.getElementById(id).value, 10);
            var result;
            if ((value - 1) < 0) {
                result = 0;
            } else {
                result = value - 1;
            }
            document.getElementById(id).value = result;
        }
    }
</script>