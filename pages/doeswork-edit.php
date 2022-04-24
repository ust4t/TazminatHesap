<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-center mt-5 mb-5">
                <div class="card w-75">
                    <div class="card-header">
                        <h5>İş Göremezlik Formu</h5>
                    </div>
                    <div class="card-body">
                        <p>Lütfen aşağıdaki alanları uygun şekilde doldurunuz!</p>
                        <form onsubmit="return false" id="form">
                            <input type="hidden" name="type" value="does-not-work-edit">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label1" class="form-label">ADI SOYADI</label>
                                        <input type="text" class="form-control" id="label1" name="namesurname" placeholder="Destek Kişinin Adı Soyadı" value="<?=$data['namesurname']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label2" class="form-label">DOĞUM TARİHİ</label>
                                        <input type="date" class="form-control" id="label2" name="birthday" value="<?= $data['birthday'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="#label3" class="form-label">OLAY TARİHİ</label>
                                <input type="date" class="form-control" id="label3" name="workstartdate" value="<?= $data['workstartdate'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="#label4" class="form-label">HESAP TARİHİ</label>
                                <input type="date" class="form-control" id="label4" name="workenddate" value="<?= $data['workenddate'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="#label5" class="form-label">CİNSİYET</label>
                                <select name="gender" id="label5" class="form-select">
                                    <option value="men" <?php echo ($data['gender'] == 'men') ? 'selected' : null; ?>>ERKEK</option>
                                    <option value="women" <?php echo ($data['gender'] == 'women') ? 'selected' : null; ?>>KADIN</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="#label6" class="form-label">MEDENİ DURUMU : </label>
                                <select name="marital" id="label6" class="form-select">
                                    <option value="single" <?php echo ($data['marital'] == 'single') ? 'selected' : null; ?>>BEKAR</option>
                                    <option value="married" <?php echo ($data['marital'] == 'married') ? 'selected' : null; ?>>EVLİ</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label16" class="form-label">NET MAAŞ</label>
                                        <input type="number" class="form-control" id="label16" name="netpay" placeholder="Net maaş" value="<?= $data['netpay'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <div style="display: flex; align-items: flex-end; height: 100%" class="">
                                            <button id="asgari-ucret" class="btn btn-outline-primary btn-sm mb-1" style="display: block; width: 100%">Asgari Ücret</button>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="col-md-6">
                                        <label for="#label17" class="form-label">ASGARİ ÜCRET AGİ EKSİZ</label>
                                        <input type="number" class="form-control" id="label17" name="grosspay" placeholder="Asgari Ücret Agi Eksiz">
                                    </div>
                                    -->
                                </div>

                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label18" class="form-label">KATSAYI</label>
                                        <input type="text" class="form-control" id="label18" name="factor" placeholder="Katsayı" value="<?= $data['factor'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label19" class="form-label">KUSUR ORANI</label>
                                        <input type="text" class="form-control" id="label19" name="rate" placeholder="Kusur Oranı" value="<?= $data['rate'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label19" class="form-label">Daimi İş Göremezlik</label>
                                        <input type="number" class="form-control" id="label19" name="jobrate" placeholder="Daimi İş Göremezlik" value="<?= $data['jobrate'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label">Hesap Türü</label>
                                        <select name="formtype" class="form-control" id="">
                                            <option value="">Hesap Tipini Seçiniz</option>
                                            <option value="trh" <?php echo ($data['type'] == 'trh') ? 'selected' : null; ?>>TRH 2010</option>
                                            <option value="pmf" <?php echo ($data['type'] == 'pmf') ? 'selected' : null; ?>>PMF 1931 Prograsif Rant</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label19" class="form-label">Geçiçi İş Göremezlik Süresi (Ay)</label>
                                        <input type="number" class="form-control" id="label19" name="doesworktime" placeholder="Geçiçi iş göremezlik süresi" value="<?= $data['doesworktime'] ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="#label19" class="form-label">GİG Ödemesi (Varsa)</label>
                                        <input type="number" class="form-control" id="label19" name="gig" placeholder="Gig ödemesi" value="<?= $data['gig'] ?>">
                                    </div>
                                </div>
                            </div>

                        </form>
                        <button id="submit-btn" class="btn btn-success">KAYDET</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>