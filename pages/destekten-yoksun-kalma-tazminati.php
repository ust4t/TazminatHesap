<div id="child-blank" style="visibility: hidden; display: none">
    <div>
        <button class="btn btn-danger btn-sm mb-3" onclick="remove(this)">Kaldır</button>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="#label9" class="form-label">Çocuk Adı : </label>
                    <input type="text" class="form-control" id="label9"
                           name="childs[][name]"
                           placeholder="Çocuğunuzun adı">
                </div>
                <div class="col-md-6">
                    <label for="#label10" class="form-label">Çocuk Doğum tarihi : </label>
                    <input type="date" class="form-control" id="label10"
                           name="childs[][birthday]">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="#label" class="form-label">Çocuk Cinsiyeti : </label>
                    <select name="childs[][gender]" id="label" class="form-select">
                        <option value="men">ERKEK</option>
                        <option value="women">KIZ</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 mt-4 form-check">
                    <input type="checkbox" name="childs[][uni]" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Üniversite Öğrencisi</label>
                </div>
                <div class="mb-3 mt-4 form-check">
                    <input type="checkbox" name="childs[][disabled]" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Engelli Çocuk</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="agi-blank" style="visibility: hidden; display: none">
    <div>
        <div class="mb-3">
            <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="#label" class="form-label">Agi Seçeneği : </label>
                    <select name="agis[gender]" id="label" class="form-select">
                        <option value="">---Seçiniz---</option>
                        <option value="1">Bekar asgari ücretli</option>
                        <option value="2">Asgari ücretli evli</option>
                        <option value="3">Asgari ücretli evli ve 1 çocuklu</option> 
                        <option value="4">Asgari ücretli evli 2 çocuklu</option>
                        <option value="5">Asgari ücretli evli 3 çocuklu</option>
                        <option value="6">Asgari ücretli 4 çocuklu</option>
                    </select>
                </div>
            </div>
               
               
            </div>
        </div>
        
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-center mt-5 mb-5">
                <div class="card w-75">
                    <div class="card-header">
                        <h5>trh 2010 progressive run - İşçi Kayıt Formu</h5>
                    </div>
                    <div class="card-body">
                        <a href="<?=$siteUrl."tazminat/destekten-yolsun-kalma/list"?>" class="btn btn-sm btn-outline-primary">
                            Kayıları Görüntüle
                        </a>
                        <p>Lütfen aşağıdaki alanları uygun şekilde doldurunuz!</p>
                        <form onsubmit="return false" id="form">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label1" class="form-label">ADI SOYADI</label>
                                        <input type="text" class="form-control" id="label1" name="namesurname"
                                               placeholder="Destek Kişinin Adı Soyadı">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label2" class="form-label">DOĞUM TARİHİ</label>
                                        <input type="date" class="form-control" id="label2" name="birthday">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="#label3" class="form-label">OLAY TARİHİ</label>
                                <input type="date" class="form-control" id="label3" name="workstartdate">
                            </div>
                            <div class="mb-3">
                                <label for="#label4" class="form-label">HESAP TARİHİ</label>
                                <input type="date" class="form-control" id="label4" name="workenddate">
                            </div>
                            <div class="mb-3">
                                <label for="#label5" class="form-label">CİNSİYET</label>
                                <select name="gender" id="label5" class="form-select">
                                    <option value="men">ERKEK</option>
                                    <option value="women">KADIN</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="#label6" class="form-label">MEDENİ DURUMU : </label>
                                <select name="marital" id="label6" class="form-select">
                                    <option value="single">BEKAR</option>
                                    <option value="married">EVLİ</option>
                                </select>
                            </div>
                            <div id="marital">
                            </div>
                            <div id="childs">
                                <button id="add" onclick="addChild()" class="btn btn-success btn-sm mb-3">Yeni Çocuk Alanı Ekle
                                </button>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label12" class="form-label">ANNE ADI</label>
                                        <input type="text" class="form-control" id="label12" name="momname"
                                               placeholder="Anne Adı">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label13" class="form-label">ANNE DOĞUM TARİHİ</label>
                                        <input type="date" class="form-control" id="label13" name="mombirdthday">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label14" class="form-label">BABA ADI</label>
                                        <input type="text" class="form-control" id="label14" name="dadname"
                                               placeholder="Baba Adı">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label15" class="form-label">BABA DOĞUM TARİHİ</label>
                                        <input type="date" class="form-control" id="label15" name="dadbirdthday">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label16" class="form-label">NET MAAŞ</label>
                                        <input type="number" class="form-control" id="label16" name="netpay"
                                               placeholder="Net maaş">
                                    </div>
                                    <div class="col-md-6">
                                        <div style="display: flex; align-items: flex-end; height: 100%" class="">
                                            <button id="asgari-ucret" class="btn btn-outline-primary btn-sm mb-1" step="0.01" onclick="addAgi()" style="display: block; width: 100%">Asgari Maaş</button
                                        </div>
                                    </div>
                                    <!--
                                    <div class="col-md-6">
                                        <label for="#label17" class="form-label">ASGARİ ÜCRET AGİ EKSİZ</label>
                                        <input type="number" class="form-control" id="label17" name="grosspay"
                                               placeholder="Asgari Ücret Agi Eksiz">
                                    </div>
                                    -->
                                </div>

                            </div>
                            
                            
                             <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                                <label for="#label" class="form-label">Agi Seçeneği : </label>
                                                <select name="agisec" id="label" class="form-select">
                                                    <option value="">---Agi Yok---</option>
                                                    <option value="-1">Bekar asgari ücretli</option>
                                                    <option value="0">Asgari ücretli evli</option>
                                                    <option value="1">Asgari ücretli evli ve 1 çocuklu</option> 
                                                    <option value="2">Asgari ücretli evli 2 çocuklu</option>
                                                    <option value="3">Asgari ücretli evli 3 çocuklu</option>
                                                    <option value="4">Asgari ücretli 4 çocuklu</option>
                                                </select>
                                    </div>
                                    
                                </div>

                            </div>
                            
                            
                            
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label18" class="form-label">KATSAYI</label>
                                        <input type="text" class="form-control" id="label18" name="factor"
                                               placeholder="Katsayı">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label19" class="form-label">KUSUR ORANI</label>
                                        <input type="text" class="form-control" id="label19" name="rate"
                                               placeholder="Kusur Oranı">
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
