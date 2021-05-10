<div class="modal-header">
    <h5 class="modal-title">Edit Perusahaan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="POST" class="d-flex flex-column" action="updateDataPerusahaan" enctype="multipart/form-data">
        <input type="hidden" name="idPerusahaan" value="<?php echo $dataPerusahaan[0]->idPerusahaan ?>"/>
        <input type="hidden" name="tempLogoPerusahaan" value="<?php echo $dataPerusahaan[0]->V_logoPerusahaan?>"/>
        <input type="hidden" name="tempBuktiPembayaran" value="<?php echo $dataPerusahaan[0]->V_buktiPembayaran?>"/>
        <input type="hidden" name="tempMOU" value="<?php echo $dataPerusahaan[0]->V_mou?>"/>
<?php //print_r($dataPerusahaan);exit();?>
        <div class="container middle-content-form mt-3 py-3 px-3">
            <!-- Data Diri Perusahaan -->
            <hr>
            <div class="row">
                <!-- Logo Perusahaan -->
                <div class="col-sm-5">
                    <div class="row form-group ">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <img id="output" src="./assets/uploadedFiles/<?php echo $dataPerusahaan[0]->V_logoPerusahaan; ?>" width="200">
                            </div>
                            <div class="input-group">
                                <div class="custom-file mt-4">
                                    <input type="file" class="text-center custom-file-input" id="logo" accept="image/*" name='logo' onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                    <label class="custom-file-label" for="logo" aria-describedby="logo">Unggah Logo Perusahaan*</label>
                                </div><br>
                            </div><br>
                            <label for="warningInputLogo" class="text-center text-danger text-bold font-weight-bold">*Maximum Logo Size of 1 MB (JPEG , PNG , JPG)</label>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="paket" class="col-sm-4 col-form-label">Paket</label>

                        <div class="col-sm-8">
                            <select class="selectpicker form-control border rounded" id="inputBidang" name="paket" data-live-search="true" data-size="5" data-style="btn-transparant">
                                <option hidden selected value="<?php echo $dataPerusahaan[0]->V_paket ?>"><?php echo $dataPerusahaan[0]->V_paket ?></option>
                                <option data-tokens='basic' value='basic'>basic</option>
                                <option data-tokens='bronze' value='bronze'>bronze</option>
                                <option data-tokens='silver' value='silver'>silver</option>
                                <option data-tokens='gold' value='gold'>gold</option>
                                <option data-tokens='platinum' value='platinum'>platinum</option>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Identitas Perusahaan -->
                <div class="col-sm-7">

                    <div class="row form-group">
                        <label for="inputNama" class="col-sm-4 col-form-label">Nama Perusahaan</label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Nama Perusahaan" class="form-control border" id="inputNama" name="nama" value="<?php echo $dataPerusahaan[0]->V_namaPerusahaan ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputBidang" class="col-sm-4 col-form-label">Bidang Usaha</label>

                        <div class="col-sm-8">
                            <select class="selectpicker form-control border rounded" id="inputBidang" name="bidang" data-live-search="true" data-size="5" data-style="btn-transparant">
                                <option hidden selected value="<?php echo $dataPerusahaan[0]->V_bidangUsaha ?>"><?php echo $dataPerusahaan[0]->V_bidangUsaha ?></option>
                                <option data-tokens='Pertanian; perikanan; dan kehutanan' value='Pertanian; perikanan; dan kehutanan'>Pertanian; perikanan; dan kehutanan</option>
                                <option data-tokens='Pertambangan dan penggalian,Industri pengolahan' value='Pertambangan dan penggalian,Industri pengolahan'>Pertambangan dan penggalian,Industri pengolahan</option>
                                <option data-tokens='Pengadaan listrik; gas; uap/air panas; dan udara dingin' value='Pengadaan listrik; gas; uap/air panas; dan udara dingin'>Pengadaan listrik; gas; uap/air panas; dan udara dingin</option>
                                <option data-tokens='Pengadaan air;pengelolaan sampah dan daur ulang; pembuangan dan pembersihan limbah dan sampah' value='Pengadaan air;pengelolaan sampah dan daur ulang; pembuangan dan pembersihan limbah dan sampah'>Pengadaan air;pengelolaan sampah dan daur ulang; pembuangan dan pembersihan limbah dan sampah</option>
                                <option data-tokens='Konstruksi dan pembangunan' value='Konstruksi dan pembangunan'>Konstruksi dan pembangunan</option>
                                <option data-tokens='Perdagangan besar dan eceran; reparasi dan perawatan mobil dan sepeda motor' value='Perdagangan besar dan eceran; reparasi dan perawatan mobil dan sepeda motor'>Perdagangan besar dan eceran; reparasi dan perawatan mobil dan sepeda motor</option>
                                <option data-tokens='Transportasi dan pergudangan' value='Transportasi dan pergudangan'>Transportasi dan pergudangan</option>
                                <option data-tokens='Penyediaan akomodasi dan penyediaan makanan dan minuman' value='Penyediaan akomodasi dan penyediaan makanan dan minuman'>Penyediaan akomodasi dan penyediaan makanan dan minuman</option>
                                <option data-tokens='Informasi dan komunikasi' value='Informasi dan komunikasi'>Informasi dan komunikasi</option>
                                <option data-tokens='Jasa keuangan dan asuransi' value='Jasa keuangan dan asuransi'>Jasa keuangan dan asuransi</option>
                                <option data-tokens='Real estate; developer; dan property,Jasa professional; ilmiah dan teknis' value='Real estate; developer; dan property,Jasa professional; ilmiah dan teknis'>Real estate; developer; dan property,Jasa professional; ilmiah dan teknis</option>
                                <option data-tokens='Jasa persewaan dan sewa guna usaha tanpa hak opsi; ketenagakerjaan; agen perjalanan dan penunjang usaha lainnya' value='Jasa persewaan dan sewa guna usaha tanpa hak opsi; ketenagakerjaan; agen perjalanan dan penunjang usaha lainnya'>Jasa persewaan dan sewa guna usaha tanpa hak opsi; ketenagakerjaan; agen perjalanan dan penunjang usaha lainnya</option>
                                <option data-tokens='Administrasi pemerintahan; pertahanan; dan jaminan wajib sosial' value='Administrasi pemerintahan; pertahanan; dan jaminan wajib sosial'>Administrasi pemerintahan; pertahanan; dan jaminan wajib sosial</option>
                                <option data-tokens='Jasa pendidikan' value='Jasa pendidikan'>Jasa pendidikan</option>
                                <option data-tokens='Kesenian; hiburan dan rekreasi' value='Kesenian; hiburan dan rekreasi'>Kesenian; hiburan dan rekreasi</option>
                                <option data-tokens='Kegiatan jasa lainnya' value='Kegiatan jasa lainnya'>Kegiatan jasa lainnya</option>
                                <option data-tokens='Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga' value='Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga'>Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga</option>
                                <option data-tokens='Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya' value='Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya'>Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya</option>
                                <option data-tokens='Kerohanian' value='Kerohanian'>Kerohanian</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputAlamat" class="col-sm-4 col-form-label">Alamat Perusahaan</label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Alamat Perusahaan" class="form-control border" id="inputAlamat" name="alamat" value="<?php echo $dataPerusahaan[0]->V_alamatPerusahaan ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputTelp" class="col-sm-4 col-form-label">Kontak Perusahaan</label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Nomor Kontak Perusahaan" class="form-control border" id="inputTelp" name="telp" value="<?php echo $dataPerusahaan[0]->V_kontakPerusahaan ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputLink" class="col-sm-4 col-form-label">Website Perusahaan</label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Link Website Perusahaan" class="form-control border" id="inputLink" name="link" value="<?php echo $dataPerusahaan[0]->V_websitePerusahaan ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputJumlahKaryawan" class="col-sm-6 col-form-label">Jumlah Karyawan</label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Jumlah Karyawan" class="form-control border" id="inputJumlahKaryawan" name="jumlahKaryawan" value="<?php echo $dataPerusahaan[0]->V_jumlahKaryawan?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputKaryawanUnpar" class="col-sm-6 col-form-label">Jumlah Lulusan UNPAR yang Bekerja Dalam Perusahaan</label>

                        <div class="col-sm-6">
                            <select class="selectpicker form-control border rounded" id="inputKaryawanUnpar" name="jumlahKaryawanUnpar" data-live-search="true" data-size="5" data-style="btn-transparant">
                                <option hidden selected value="<?php echo $dataPerusahaan[0]->V_jumlahLulusanUnpar ?>"><?php echo $dataPerusahaan[0]->V_jumlahLulusanUnpar ?></option>
                                <option data-tokens='1-25' value='1-25'>1 - 25 Orang</option>
                                <option data-tokens='26-50' value='26-50'>26 - 50 Orang</option>
                                <option data-tokens='51-75' value='51-75'>51 - 75 Orang</option>
                                <option data-tokens='> 75 orang' value='> 75 orang'> > 75 Orang</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputNamaPIC" class="col-sm-6 col-form-label">Nama PIC</label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Nama" class="form-control border" id="inputNamaPIC" name="namaPIC" value="<?php echo $dataPerusahaan[0]->V_namaPic ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputEmailPIC" class="col-sm-6 col-form-label">Email PIC</label>

                        <div class="col-sm-6">
                            <input type="email" placeholder="Email" class="form-control border" id="inputEmailPIC" name="emailPIC" value="<?php echo $dataPerusahaan[0]->V_emailPic ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="inputKontakPIC" class="col-sm-6 col-form-label">No Telp/WA PIC</label>

                        <div class="col-sm-6">
                            <input type="tel" placeholder="Telephone / WA" class="form-control border" id="inputKontakPIC" name="kontakPIC" value="<?php echo $dataPerusahaan[0]->V_noTelpPic ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="tglMulai" class="col-sm-6 col-form-label">Masa Berlaku</label>

                        <div class="col-sm-6">
                            <input type="date" class="form-control border" id="tglMulai" name="tglMulai" value="<?php echo $dataPerusahaan[0]->V_masaBerlaku ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="tglSelesai" class="col-sm-6 col-form-label">Masa Selesai</label>

                        <div class="col-sm-6">
                            <input type="date" class="form-control border" id="tglSelesai" name="tglSelesai" value="<?php echo $dataPerusahaan[0]->V_masaSelesai ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="buktiPembayaran" class="col-sm-6 col-form-label">Bukti Pembayaran</label>
                        <div class="col-sm-6">
                            <input type="file" id="buktiPembayaran" name="buktiPembayaran" placeholder="<?php echo $dataPerusahaan[0]->V_buktiPembayaran ?>">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="mou" class="col-sm-6 col-form-label">MOA</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="No MOA" class="form-control border" id="noMOU" name="noMOU" value="<?php echo $dataPerusahaan[0]->V_mouNo ?>">
                            <!-- <input type="file" id="mou" name="mou" placeholder="<?php //echo $dataPerusahaan[0]->V_mou ?>"> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>