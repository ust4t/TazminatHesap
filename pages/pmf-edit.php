<?php
/*
Created By PhpStorm
User : Taha KOÇAK
Date : 5/9/2021
File : dykt-edit.php
*/

?>

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
                        <h5>pmf 1931 - İşçi Kayıt Formu</h5>
                    </div>
                    <div class="card-body">
                        <p>Lütfen aşağıdaki alanları uygun şekilde düzenleyiniz!</p>
                        <form onsubmit="return false" id="form">
                            <input type="hidden" name="type" value="pmf-edit">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label1" class="form-label">ADI SOYADI</label>
                                        <input type="text" class="form-control" id="label1" name="namesurname"
                                               placeholder="Destek Kişinin Adı Soyadı" value="<?=$data['namesurname']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label2" class="form-label">DOĞUM TARİHİ</label>
                                        <input type="date" class="form-control" id="label2" name="birthday" value="<?=$data['birthday']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="#label3" class="form-label">OLAY TARİHİ</label>
                                <input type="date" class="form-control" id="label3" name="workstartdate" value="<?=$data['workstartdate']?>">
                            </div>
                            <div class="mb-3">
                                <label for="#label4" class="form-label">HESAP TARİHİ</label>
                                <input type="date" class="form-control" id="label4" name="workenddate" value="<?=$data['workenddate']?>">
                            </div>
                            <div class="mb-3">
                                <label for="#label5" class="form-label">CİNSİYET</label>
                                <select name="gender" id="label5" class="form-select">
                                    <option <?php if ($data['gender'] == "men") echo "selected" ?> value="men">ERKEK</option>
                                    <option <?php if ($data['gender'] == "women") echo "selected" ?> value="women">KADIN</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="#label6" class="form-label">MEDENİ DURUMU : </label>
                                <select name="marital" id="label6" class="form-select">
                                    <option <?php if ($data['marital'] == "selected") echo "selected" ?> value="single">BEKAR</option>
                                    <option <?php if ($data['marital'] == "married") echo "selected" ?> value="married">EVLİ</option>
                                </select>
                            </div>
                            <div id="marital">
                                <?php if ($data['marital'] == "married"):
                                    $spouse = json_decode($data['spouse'],true);
                                    ?>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="#label7" class="form-label">Eşinin adı : </label>
                                                <input type="text" class="form-control" id="label7" name="spouse[name]" value="<?=$spouse['name']?>"
                                                       placeholder="Eşinizin adı">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="#label8" class="form-label">Eşinin doğum tarihi : </label>
                                                <input type="date" class="form-control" id="label8" name="spouse[birthday]" value="<?=$spouse['birthday']?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="childs">
                                        <button id="add" onclick="addChild()" class="btn btn-success btn-sm mb-3">Yeni Çocuk Alanı Ekle</button>
                                        <?php
                                        $childs=json_decode($data['childs'],true);
                                        foreach ($childs as $key => $child):
                                            ?>
                                            <div>
                                                <button class="btn btn-danger btn-sm mb-3" onclick="remove(this)">Kaldır</button>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="#label9" class="form-label">Çocuk Adı : </label>
                                                            <input type="text" class="form-control" id="label9"
                                                                   name="childs[<?=$key?>][name]"
                                                                   placeholder="Çocuğunuzun adı" value="<?=$child['name']?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="#label10" class="form-label">Çocuk Doğum tarihi : </label>
                                                            <input type="date" class="form-control" id="label10"
                                                                   name="childs[<?=$key?>][birthday]" value="<?=$child['birthday']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="#label" class="form-label">Çocuk Cinsiyeti : </label>
                                                            <select name="childs[<?=$key?>][gender]" id="label" class="form-select">
                                                                <option <?php if ($child['gender'] == "men") echo "selected" ?> value="men">ERKEK</option>
                                                                <option <?php if ($child['gender'] == "women") echo "selected" ?> value="women">KIZ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3 mt-4 form-check">
                                                            <input type="checkbox" name="childs[<?=$key?>][uni]" <?php if($child['uni'] == "on") echo "checked" ?> class="form-check-input" id="exampleCheck1">
                                                            <label class="form-check-label" for="exampleCheck1">Üniversite Öğrencisi</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <hr>

                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label12" class="form-label">ANNE ADI</label>
                                        <input type="text" class="form-control" id="label12" name="momname" value="<?=$data['momname']?>"
                                               placeholder="Anne Adı">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label13" class="form-label">ANNE DOĞUM TARİHİ</label>
                                        <input type="date" class="form-control" id="label13" name="mombirdthday" value="<?=$data['mombirdthday']?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label14" class="form-label">BABA ADI</label>
                                        <input type="text" class="form-control" id="label14" name="dadname" value="<?=$data['dadname']?>"
                                               placeholder="Baba Adı">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label15" class="form-label">BABA DOĞUM TARİHİ</label>
                                        <input type="date" class="form-control" id="label15" name="dadbirdthday" value="<?=$data['dadbirdthday']?>">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="#label16" class="form-label">NET MAAŞ</label>
                                        <input type="number" class="form-control" id="label16" name="netpay" value="<?=$data['netpay']?>"
                                               placeholder="Net maaş">
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
                                        <label for="#label18" class="form-label">KATSAYI</label>
                                        <input type="text" class="form-control" id="label18" name="factor" value="<?=$data['factor']?>"
                                               placeholder="Katsayı">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#label19" class="form-label">KUSUR ORANI</label>
                                        <input type="text" class="form-control" id="label19" name="rate" value="<?=$data['rate']?>"
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
