<style>
.l{
    border-left:1px solid black;
}
.r{
    border-right:1px solid black;
}
.b{
    border-bottom:1px solid black;
}
.t{
    border-top:1px solid black;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center mt-5">
                <div class="card-header">
                    BAKİYE ÖMÜR TABLOSU / DESTEK HAK SAHİPLERİ 
                </div>
                <div class="card-body">
                    
                    <div class="table-wrapper">
                        <table class="table" style="border:1px solid black;">
                            <thead>
                            <tr>
                                <th rowspan="2" colspan="2">Olay Tarihi : <?= date("d.m.Y", strtotime($data['workstartdate'])) ?></th>
                                <th rowspan="2" class="r">DOĞUM Tarihi</th>
                                <th colspan="2" class="r">OLAY TRH. YAŞ</th>
                                <th colspan="2" class="r">OLAY TRH. BAK. Ö.</th>
                                <th colspan="2" class="r">İŞLEMİŞ DÖNEM</th>
                                <th colspan="2" class="r">AKTİF DÖNEM</th>
                                <th colspan="2" class="r l">PASİF DÖNEM</th>
                            </tr>
                            <tr>
                                
                                <th scope="col" class="l">YIL</th>
                                <th scope="col">AY</th>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col">AY</th>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col">AY</th>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col">AY</th>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col" class="r">AY</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                             
                            <tr class="b">
                                <td><b>DESTEK</b></th>
                                <td><?= $data['namesurname'] ?></th>
                                <td><?= date("d.m.Y", strtotime($data['birthday'])) ?></td>
                                <td class="l"><?= $ageofWorker->y ?></td>
                                <td><?= $ageofWorker->m ?></td>
                                <td class="l"><?= $isciBakiye[0] ?></td>
                                <td><?= (floor((($isciBakiye[1] / 100) * 360) / 30)) ?></td>
                                <td class="l"><?= $aktifid->y ?></td>
                                <td><?= $aktifid->m ?></td>
                                <td class="l"><?= $aktifIslemisDonem->y ?></td>
                                <td><?= $aktifIslemisDonem->m ?></td>
                                <td class="l"><?= $pasifTotalİsci->y ?></td>
                                <td class="r"><?= $pasifTotalİsci->m ?></td>
                            </tr>
                            <tr>
                                <td><b>KUSUR</b></th>
                                <td>% <?= $data['rate'] ?></th>
                                <td colspan="11" rowspan="2" style="border:1px solid black;"></td>
                            </tr>
                            <tr>
                                <td><b>Agi Oranı</b></th>
                                <td><?= $agiorani ?></th>
                            </tr>
                            <tr>
                                <td><b>ÜCRET</b></th>
                                <td><?= $data['netpay'] ?> TL</th>
                            </tr>
                            

                            </tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <div class="table-wrapper">
                        <table class="table" style="border:1px solid black;">
                            <thead class="b">
                            <tr>
                                <th scope="col" rowspan="2" colspan="2">PAY SAHİPLERİ</th>
                                <th scope="col" rowspan="2">DOĞUM TRH.</th>
                                <th scope="col" colspan="2" class="l">OLAY TRH. YAŞ</th>
                                <th scope="col" colspan="2" class="l">OLAY TRH. BAK. Ö.</th>
                                <th scope="col" colspan="2" class="l">HESAP TRH. DESTEK SÜRESİ</th>
                                <th scope="col" colspan="2" class="r l">OLAY TRH. DESTEK SÜRESİ</th>
                            </tr>
                            <tr>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col">AY</th>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col">AY</th>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col">AY</th>
                                <th scope="col" class="l">YIL</th>
                                <th scope="col" class="r">AY</th>
                            </tr>
                            </thead>
                            <tbody class="b">
                            <tr>
                                <td>EŞ</td>
                                <td><?= $spouse['name'] ?></td>
                                <td><?= date("d.m.Y", strtotime($spouse['birthday'])) ?></td>
                                <td class="l"><?= $ageofSpouse->y ?></td>
                                <td><?= $ageofSpouse->m ?></td>
                                <td class="l"><?= $spouseBakiye[0] ?></td>
                                <td><?= (floor((($spouseBakiye[1] / 100) * 360) / 30)) ?></td>
                                <td class="l">-</td>
                                <td>-</td>
                                <td class="l"><?php if ($isciBakiye[0] > $spouseBakiye[0]): ?> <?= $spouseBakiye[0] ?><?php else: ?> <?= $isciBakiye[0]; ?><? endif; ?></td>
                                <td class="r"><?php if ($isciBakiye[0] > $spouseBakiye[0]): ?><?= (floor((($spouseBakiye[1] / 100) * 360) / 30)) ?><?php else: ?><?= (floor((($isciBakiye[1] / 100) * 360) / 30)) ?><? endif; ?></td>
                            </tr>

                            <?php
                            foreach ($childers as $key => $child):
                                
                                
                                $ageofChild = date_diff(date_create($child['birthday']), date_create($data['workstartdate']));
                                $childBakiye = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofChild->y)->first()[($child['gender'] == "men") ? "erkek" : "kadin"]);
                                $childBakiye = explode(".", $childBakiye);

                                if ($child['gender'] == "men" && $ageofChild->y < 18 && !$child['uni']) {
                                    $destek = date_diff(date_create(date("d-m-Y", strtotime("+18 years", strtotime($child['birthday'])))), date_create($data['workenddate']));
                                    $destekOlay = date_diff(date_create(date("d-m-Y", strtotime("+18 years", strtotime($child['birthday'])))), date_create($data['workstartdate']));
                                } else if ($child['uni']) {
                                    $destek = date_diff(date_create(date("d-m-Y", strtotime("+26 years", strtotime($child['birthday'])))), date_create($data['workenddate']));
                                    $destekOlay = date_diff(date_create(date("d-m-Y", strtotime("+26 years", strtotime($child['birthday'])))), date_create($data['workstartdate']));
                                } else if ($child['gender'] == "women" && $ageofChild->y < 22 && !$child['uni']) {
                                    $destek = date_diff(date_create(date("d-m-Y", strtotime("+22 years", strtotime($child['birthday'])))), date_create($data['workenddate']));
                                    $destekOlay = date_diff(date_create(date("d-m-Y", strtotime("+22 years", strtotime($child['birthday'])))), date_create($data['workstartdate']));
                                }
                                ?>
                                <tr>
                                    <td>ÇOCUK <?= $key + 1 ?></td>
                                    <td><?= $child['name'] ?></td>
                                    <td><?= date("d.m.Y", strtotime($child['birthday'])) ?></td>
                                    <td class="l"><?= $ageofChild->format("%r%y") ?></td>
                                    <td><?= $ageofChild->format("%r%m") ?></td>
                                    <td class="l"><?= $childBakiye[0] ?></td>
                                    <td><?= (floor((($childBakiye[1] / 100) * 360) / 30)) ?></td>
                                    <td class="l"><?= $destek->y; ?></td>
                                    <td><?= $destek->m ?></td>
                                    <td class="l"><?= $destekOlay->y; ?></td>
                                    <td class="r"><?= $destekOlay->m ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php
                            foreach ($dadMom as $item):
                                $ageoffamily = date_diff(date_create($item['birthday']), date_create($data['workstartdate']));
                                $familyBakiye = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageoffamily->y)->first()[($item['gender'] == "men") ? "erkek" : "kadin"]);
                                $familyBakiye = explode(".", $familyBakiye);

                                $ageofWorker2 = date_diff(date_create($data['birthday']), date_create($data['workenedate']));
                                $isciBakiye2 = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofWorker2->y)->first()[($data['gender'] == "men") ? "erkek" : "kadin"]);
                                $isciBakiye2 = explode(".", $isciBakiye2);

                                $destekOlay = date_diff(date_create(date("d-m-Y", strtotime("+ " . ($isciBakiye->y + $ageofWorker->y) . " years " . ($isciBakiye->m + $ageofWorker->m) . " months " . ($isciBakiye->d + $ageofWorker->d) . " days", strtotime($data['workstartdate'])))),
                                    date_create(date("d-m-Y", strtotime("+ $ageoffamily->y years $ageoffamily->m months $ageoffamily->d days", strtotime($data['workstartdate'])))));
                                $destek = date_diff(date_create(date("d-m-Y", strtotime("+ " . ($isciBakiye2->y + $ageofWorker2->y) . " years " . ($isciBakiye2->m + $ageofWorker2->m) . " months " . ($isciBakiye2->d + $ageofWorker2->d) . " days", strtotime($data['workenddate'])))),
                                    date_create(date("d-m-Y", strtotime("+ $ageoffamily->y years $ageoffamily->m months $ageoffamily->d days", strtotime($data['workenddate'])))));

                                ?>
                                <tr>
                                    <td><?= $item['prefix'] ?> </td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= date("d.m.Y", strtotime($item['birthday'])) ?></td>
                                    <td class="l"><?= $ageoffamily->y ?></td>
                                    <td><?= $ageoffamily->m ?></td>
                                    <td class="l"><?= $familyBakiye[0] ?></td>
                                    <td><?= (floor((($familyBakiye[1] / 100) * 360) / 30)) ?></td>
                                    <td class="l"><?= $destek->y; ?></td>
                                    <td><?= $destek->m ?></td>
                                    <td class="l"><?php if ($destekOlay->y > $familyBakiye[0]): ?> <?= $familyBakiye[0] ?><?php else: ?> <?= $destekOlay->y; ?><?php endif; ?></td>
                                    <td class="r"><?php if ($destekOlay->y > $familyBakiye[0]): ?><?= (floor((($familyBakiye[1] / 100) * 360) / 30)) ?><?php else: ?><?= $destekOlay->m ?><?php endif; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <br>
            <br>
            <hr>
            <br>
            <br>

            <div class="card text-center">
                <div class="card-header">
                    İŞLEMİŞ DÖNEM HESABI
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?= date("d.m.Y", strtotime($data['workstartdate'])) ?>
                                    - <?= date("d.m.Y", strtotime($data['workenddate'])) ?> ARASI
                                    İŞLEMİŞ DÖNEM
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">DÖNEMLER</th>
                                <th scope="col">BRÜT</th>
                                <th scope="col">NET</th>
                                <th scope="col">GÜNLÜK</th>
                                <th scope="col">SÜRE</th>
                                <th scope="col">TUTAR</th>
                                <th scope="col">KATSAYI</th>
                                <th scope="col">GÜNLÜK</th>
                                <th scope="col">DÖNEM KAZANCI</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $total = 0;
                            $totalWork = 0;
                            foreach ($asgeriUcret as $key => $ucret):
                                $gunluk = numberReformat($ucret['gunluknet'], 2);
                                if ($key == "0") {
                                    $ay = ((substr($ucret['donemler'], -1) == 2) ? "12" : "7");
                                    $date = date("d.m.Y", strtotime($data['workstartdate']));
                                    $gun = abs((date("m", strtotime($data['workstartdate'])) - ($ay -1)) * 30) + (30 - date("d", strtotime($data['workstartdate'])));
                                } else if ($key == key(array_slice($asgeriUcret, -1, 1, true))) {
                                    $date = date("d.m.Y", strtotime($data['workenddate']));
                                    $gun = ((date("m", strtotime($data['workenddate'])) - 1) * 30) + (date("d", strtotime($data['workenddate'])));
                                    $sonGunluk = number_format($data['factor'] * $gunluk, 2);
                                    $sonAsgeriGun = number_format($gunluk, 2);
                                } else {
                                    $date = ((substr($asgeriUcret[$key - 1]['donemler'], -1) == 2) ? "01.01." . (substr($asgeriUcret[$key - 1]['donemler'], 0, 4) + 1) : "01.07." . substr($asgeriUcret[$key - 1]['donemler'], 0, 4));
                                    $gun = (6 * 30);
                                }
                                if ($key == key(array_slice($asgeriUcret, -1, 1, true))) {
                                    $dateNew = $date;
                                } else {
                                    $dateNew = $date . " - " . ((substr($ucret['donemler'], -1) == 2) ? "01.01." . (substr(($ucret['donemler']), 0, 4) + 1) : "01.07." . substr($ucret['donemler'], 0, 4));
                                }

                                $maas = numberReformat(numberReformat($ucret['gunluknet'], 2) * ($gun), 1);
                                $total += $maas;
                                $totalWork += $data['factor'] * $maas;
                                ?>
                                <tr>
                                    <td><?= $dateNew ?></td>
                                    <td><?= $ucret['asgariucretbrut'] ?></td>
                                    <td><?= $ucret['asgariucretnet'] ?></td>
                                    <td><?= number_format($gunluk, 2, ",", ".") ?></td>
                                    <td><?= $gun ?></td>
                                    <td><?= number_format($maas, 2, ",", ".") ?></td>
                                    <td><?= number_format($data['factor'], 2, ",", ".") ?></td>
                                    <td><?= number_format($data['factor'] * $gunluk, 2, ",", ".") ?></td>
                                    <td><?= number_format($data['factor'] * $maas, 2, ",", ".") ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                İŞLEMİŞ DÖNEM TOPLAM KAZANCI : <b><?= number_format($total, 2, ",", ".") ?> TL</b> -
                                KATSAYILI TOPLAM
                                KAZANCI : <b><?= reformatter($totalWork) ?> TL</b>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <br>
            <br>
            <hr>
            <br>
            <br>

            <div class="card text-center">
                <div class="card-header">
                    AKTİF DÖNEM KAZANÇ TABLOSU
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?= date("d.m.Y", strtotime($data['workenddate'])) ?>
                                    - <?= date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) ?>
                                    ARASI KAZANÇ TABLOSU
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">BAKİYE YIL</th>
                                <th scope="col">GÜN</th>
                                <th scope="col">YIL</th>
                                <th scope="col">YAŞ</th>
                                <th scope="col">GÜNLÜK ÜCR.</th>
                                <th scope="col">AYLIK ÜCR.</th>
                                <th scope="col">KATSAYI</th>
                                <th scope="col">KAZANÇ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $yillikGiren = 0;
                            for ($i = 0; $i < ($isciBakiye[0] + 1); $i++):
                                $days = 1;
                                $old = $i + $yas;
                                $ex = explode('.',$omur);
                                if (($yil + $i) == (date("Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) + 1)) {
                                    $days = 1 - (($i + $yas) - 58);
                                    $old = 58;
                                }else if ($ex[1] != 00) {
                                    $days = 1 - (1- ($ex[1]/100));
                                    $omur -= $ex[1]/100;
                                }

                                ?>
                                <tr>
                                    <td><?= number_format(($omur - $i), 2, ",", ".") ?></td>
                                    <td><?= number_format((360 * $days)) ?></td>
                                    <td><?= $yil + $i ?></td>
                                    <td><?= number_format($old, 2, ",", "."); ?></td>
                                    <td><?= number_format($sonGunluk, 2, ",", ".") ?></td>
                                    <td><?= number_format(30 * $sonGunluk, 2, ",", ".") ?></td>
                                    <td>1,000</td>
                                    <td><?= number_format(((360 * $days) * $sonGunluk), 2, ",", ".") ?></td>
                                </tr>
                                <?php
                                if ($old >= 58) {
                                    break;
                                } else {
                                    $yillikGiren += ((360 * $days) * $sonGunluk);
                                }
                            endfor;
                            ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                AKTİF DÖNEM TOPLAM KAZANCI : <b><?= reformatter($yillikGiren) ?> TL</b>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <hr>
            <br>
            <br>

            <div class="card text-center">
                <div class="card-header">
                    PASİF DÖNEM KAZANÇ TABLOSU
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?= date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) ?>
                                    - <?= date("d.m.Y", strtotime("+ " . ($aktifIslemisDonem->y + $pasifTotalİsci->y) . " years " . ($aktifIslemisDonem->m + $pasifTotalİsci->m) . " months " . ($aktifIslemisDonem->d + $pasifTotalİsci->d) . " days", strtotime($data['workenddate']))) ?>
                                    ARASI KAZANÇ TABLOSU
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">KALAN ÖMÜR</th>
                                <th scope="col">GÜN</th>
                                <th scope="col">GÜNLÜK</th>
                                <th scope="col">AYLIK ÜCR.</th>
                                <th scope="col">YILLIK KAZANÇ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalPasif = 0;
                            for ($i = 0; $i < ($pasifTotalİsci->y + 1); $i++):
                            
                                if (($pasifOmur - $i) >= 1) {
                                    $day = 1;
                                } else {
                                    $day = ($pasifOmur - $i);
                                }
                                $ex = explode('.',$pasifOmur);
                                if ($ex[1] != 00) {
                                    $day = 1 - ( 1- ($ex[1]/100));
                                    $pasifOmur -= $ex[1]/100;
                                }

                                $totalPasif += ($sonAsgeriGun * (360 * $day));
                                ?>
                                <?php if ($i >= 1); ?>
                                <tr>
                                    <td><?= number_format(($pasifOmur - $i), 2, ",", ".") ?></td>
                                    <td><?= number_format((360 * $day)) ?></td>
                                    <td><?= number_format($sonAsgeriGun, 2, ",", ".") ?></td>
                                    <td><?= number_format((30 * $sonAsgeriGun), 2, ",", ".") ?></td>
                                    <td><?= number_format($sonAsgeriGun * (360 * $day), 2, ",", ".") ?></td>
                                </tr>
                            <?php endfor; ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                PASİF DÖNEM TOPLAM KAZANCI : <b><?= reformatter($totalPasif) ?> TL</b>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <br>

            <?php if ($data['marital'] == "married"): ?>
                <div class="card">
                    <div class="card-header">
                        <center>İŞLEMİŞ DÖNEM (<?= date("d.m.Y", strtotime($data['workstartdate'])) ?>
                            - <?= date("d.m.Y", strtotime($data['workenddate'])) ?> ARASI) PAYLAŞTIRMA
                        </center>
                    </div>
                    <div class="card-body">
                        <p class="text-center"><b>İŞLEMİŞ DÖNEM KAZANCI : <?= reformatter($totalWork) ?> TL</b></p>
                        <hr>
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">DESTEK</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">EŞ</th>
                                    <th scope="col">İŞ. DNM.</th>
                                    <th scope="col">ÇOCUK</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">ANNE</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">BABA</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">TOPLAM PAY</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $esKenPay = 0;
                                $annebabaPay = 0;
                                $cocukPay = 0;
                                
                                $PayDestek = 2;
                                $PayEs = 2;
                                $PayAnne = 1;
                                $PayBaba = 1;
                                $PayCocuk = 1;
                                
                                
                                foreach ($asgeriUcret as $key => $ucret):
                                    $minus = 0;
                                    $now = $islemisDonemPay;
                                    $docLater = explode(".", $islemisDonemPay);
                                    if ($docLater[1] > 51) {
                                        $islemisDonemPay -= $minus = ($docLater[1] / 100);
                                    } else {
                                        $islemisDonemPay -= $minus = (50 / 100);
                                    }

                                    $maas = numberReformat($ucret['gunluknet'], 2) * ($minus * 360);
                                    $pay = $PayDestek + $PayEs + (($dadMom[0]['name'] || $dadMom[1]['name']) ? 2 : 0) + count($childers);
                                    $maasPay = $maas / $pay;

                                    $esKenPay += ($maasPay * $PayEs);
                                    $cocukPay += ($maasPay * count($childers));
                                    $annebabaPay += ($maasPay * ($PayAnne + $PayBaba));
                                    
                                    if ($docLater[0] == 0 && $docLater[1] == 0)
                                        break;

                                    ?>
                                    <tr>
                                        <td><?= number_format((2 * $maasPay), 2, ".", ",") ?> TL</td>
                                        <td><?= $now ?> Yıl</td>
                                        <td><?= (2 * $maas) ?> TL</td>
                                        <td><?= $now ?> Yıl</td>
                                        <td><?= reformatter($maasPay * count($childers)) ?> TL</td>
                                        <td><?= (count($childers) > 0) ? $now : 0 ?> Yıl</td>
                                        <td><?= reformatter(($dadMom[0]['name']) ? (!$dadMom[1]['name']) ? ($maasPay * 2) : ($maasPay) : 0) ?>
                                            TL
                                        </td>
                                        <td><?= ($dadMom[0]['name']) ? $now : 0 ?> Yıl</td>
                                        <td><?= reformatter(($dadMom[1]['name']) ? (!$dadMom[0]['name']) ? ($maasPay * 2) : ($maasPay) : 0 )?>
                                            TL
                                        </td>
                                        <td><?= ($dadMom[1]['name']) ? $now : 0 ?> Yıl</td>
                                        <td><?= $pay ?></td>
                                    </tr>
                                <?php

                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">

                        <b>DESTEK : <?= reformatter($esKenPay) ?> TL | EŞ : <?= reformatter($esKenPay) ?> TL
                            <?php for ($i = 1; $i <= count($childers); $i++): ?>
                                | ÇOCUK <?= $i ?> : <?= reformatter(($cocukPay / count($childers))) ?> TL
                            <?php endfor; ?>
                            | ANNE : <?= reformatter(($dadMom[1]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?> TL
                            | BABA : <?= reformatter(($dadMom[0]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?>
                            TL</b>
                    </div>
                </div>

                <br>
                <br>
                <br>
                
               
                
                <div class="card">
                    <div class="card-header text-center">
                        AKTİF DÖNEM (<?= date("d.m.Y", strtotime($data['workenddate'])) ?>
                        - <?= date("d.m.Y", strtotime("+ 60 years", strtotime($data['birthday']))) ?>
                        ARASI) PAYLAŞTIRMA 
                    </div>
                    <div class="card-body">
                        <p style="text-align: center;"><b>AKTİF DÖNEM KAZANCI : <?= reformatter($yillikGiren) ?> TL</b>
                        </p>
                        <hr>
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">TARİH</th>
                                    <th scope="col">DESTEK</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">PAY</th>
                                    <th scope="col" class="r">ÜCRET</th>
                                    <th scope="col">EŞİ</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">PAY</th>
                                    <th scope="col" class="r">ÜCRET</th>
                                    <th scope="col">ÇOCUK</th>
                                    <th scope="col">YAŞI</th>
                                    <th scope="col">PAY</th>
                                    <th scope="col" class="r">ÜCRET</th>
                                    <th scope="col">ANNE</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">PAY</th>
                                    <th scope="col" class="r">ÜCRET</th>
                                    <th scope="col">BABA</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">PAY</th>
                                    <th scope="col" class="r">ÜCRET</th>
                                    <th scope="col">PAY</th>
                                    <th scope="col">PAYDAŞ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $esKenPay = 0;
                                $annebabaPay = 0;
                                $cocukPay = 0;
                                $old = $ageofWorker->y;
                                $paydas = 0;
                                
                                $PayDestek = 2;
                                $PayEs = 2;
                                $PayAnne = 0;
                                $PayBaba = 0;
                                
                                
                                $cocuktoplam = 0;
                                $destektoplam = 0;
                                $estoplam = 0;
                                $babatoplam = 0;
                                $annetoplam = 0;


                                $lastYear = $data['workenddate'];
                                for ($ii = 0; $ii < ($isciBakiye[0] + 1); $ii++):

                                    $pay = 2;
                                    $paydas = 1;
                                    $totalTazChild = 0;
                                    $payMinus = 0;
                                    $taz = 0;
                                    if ($data['marital'] == "married"){
                                    $pay += 2;
                                    $paydas += 1;
                                       
                                    }
                                    
                                    if (count($childers) == 0) {
                                        if (2 <= $ii) {
                                            $childers[] = ["first Child"];
                                            $childers[0]['name'] = '**Birinci Çocuk**';
                                            $childers[0]['birthday'] = date("Y-m-d", strtotime(($yil) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday']))));
                                            $childers[0]['gender'] = 'men';
                                        }
                                    } else if (count($childers) == 1) {
                                        if (2 <= $ii) {
                                            array_push($childers[1]['name'] = '**İkinci Çocuk**');
                                            array_push($childers[1]['birthday'] = date("Y-m-d", strtotime(($yil + 2) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday'])))));
                                            array_push($childers[1]['gender'] = 'men');
                                           
                                        }
                                        
                                    } 
                                    
                                    $PayCocuk = 0;
                                    if ($childers[0]['name']):
                                        foreach ($childers as $key => $child) {
                                            
                                            $ageofChild = date_diff(date_create($child['birthday']), date_create(date("Y-m-d", strtotime(($yil + $ii) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday']))))));
                                            
                                            
                                            $childTaz = date_diff(date_create($lastYear), date_create(date("Y-m-d", strtotime(($yil + $ii + 1) . "-" . date("m", strtotime($data['workenddate'])) . "-" . date("d", strtotime($data['workenddate']))))));
                                            
                                            $tarih2 =  date("d-m-Y", strtotime(($yil + $ii) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday']))));
                                            
                                            if (strtotime(date($child['birthday'])) > strtotime($tarih2)) {
                                                $tarih1=date($child['birthday']);
                                            }else{
                                                $tarih1=date("d-m-Y", strtotime(($yil) . "-" . date("m", strtotime($data['workenddate'])) . "-" . date("d", strtotime($data['workenddate']))));
                                            }
                                            
                                            $tarihfarkchild = date_diff(date_create($tarih1), date_create($tarih2));
                                            
                                            $kontrol= strtotime(date($tarih2)) - strtotime($tarih1) ;
                                            $toplamcb = $tarihfarkchild->y * 360 + $tarihfarkchild->m * 30 + $tarihfarkchild->d;
                                                
                                                        
                                                 
                                                 
                                                 if ($toplamcb < 360) {
                                    
                                                    if ($kontrol > 0) {
                                                        $totalTazChild = $toplamcb;
                                                        
                                                    } else {
                                                        $totalTazChild += 360;
                                                       
                                                    } 
                                                    $PayCocuk +=1;
                                                    $pay += 1;
                                                    $paydas += 1;
                                                      
                                                } else {
                                                        
                                                    if ($child['uni'] == "on") {
                                                    
                                                        if (($child['gender'] == "men" && $ageofChild->y <= 22)) {
                                                        
                                                        
                                                        $totalTazChild += 360;
                                                        $PayCocuk +=1;
                                                        $pay += 1;
                                                        $paydas += 1;
                                                        
                                                        }  else if (($child['gender'] == "women" && $ageofChild->y <= 26)) {
                                                            
                                                        $totalTazChild += 360;
                                                        $PayCocuk +=1;
                                                        $pay += 1;
                                                        $paydas += 1;
                                                        
                                                        }  else{
                                                        $totalTazChild = 0;
                                                        
                                                        }
                                                        
                                                     
                                                     }  else {
                                                         
                                                        if ((($child['gender'] == "men") && ($ageofChild->y < 18)) || (($child['gender'] == "women") && ($ageofChild->y <= 22))){ 
                                                            $totalTazChild += 360;
                                                            $PayCocuk +=1;
                                                            $pay += 1;
                                                            $paydas += 1;
                                                            
                                                     
                                                        } else { 
                                                            $totalTazChild = 0;
                                                           
                                                            
                                                        }
                                                     
                                                }
                                                 
                                            }
                                            
                                        }
                                    endif;
                                    
                                    
                                    
                                    $tarihson = date("d-m-Y", strtotime(($yil + $ii) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday']))));
                                    
                                    $tarihfark2 = date_diff(date_create($data['workenddate']), date_create($tarihson));

                                    $kontrol2= strtotime($data['workenddate']) - strtotime(date($tarihson));
                                    
                                    $toplam2 = (($tarihfark2->y * 360) + ($tarihfark2->m * 30) + $tarihfark2->d);
                                        
                                    if ($toplam2 < 360) {
                                        if ($kontrol2 < 0) {
                                            $payyuzde = $toplam2/360;
                                        } else {
                                            $payyuzde = (360-$toplam2)/360;
                                            
                                        }   
                                    } else {
                                        
                                    $payyuzde = 1;
                                    
                                    }

                                    if (($isciBakiyeDad - $ii) > 0) {
                                        
                                        $dadTaz = date_diff(date_create($lastYear), date_create(date("Y-m-d", strtotime(($yil + $ii + 1) . "-" . date("m", strtotime($data['workenddate'])) . "-" . date("d", strtotime($data['workenddate']))))));
                                        $personPayDad = ($dadMom[1]['name']) ? ((!$dadMom[0]['name']) ? ($lastPay * 2*$payyuzde) * 12 : ($lastPay*$payyuzde) * 12) : 0;
                                        $annebabaPay += ($lastPay * 2) * 12;
                                        $pay +=1;
                                        $paydas +=1;
                                        $PayBaba = 1;
                                    } else {
                                        $PayBaba = 0;
                                        $personPayDad = 0;
                                        
                                    }

                                    if (($isciBakiyeMom - $ii) > 0) {
                                        $personPayMom = ($dadMom[0]['name']) ? (!$dadMom[1]['name']) ? ($lastPay * 2) * 12 : ($lastPay) * 12 : 0;
                                        $pay +=1;
                                        $paydas +=1;
                                        $PayAnne = 1;
                                    } else {
                                        $personPayMom = 0;
                                        $PayAnne = 0;
                                    }
                                    if (($isciBakiyeMom - $ii) > 0 && ($isciBakiyeDad - $ii) < 0) {
                                    $PayAnne = 2;
                                    $pay +=1;
                                    }else if (($isciBakiyeMom - $ii) < 0 && ($isciBakiyeDad - $ii) > 0){
                                    $pay +=1;
                                    $PayBaba = 2;
                                    }
                                        
                                    
                                    $maas = $sonGunluk * 30;
                                    $lastPay = $maas / $pay;
                                    $esKenPay += ($lastPay * 2) * 12;

                                    $cocukPay += (($sonGunluk / $pay) * $totalTazChild);
                                   
                                    ?>
                                    <tr>
                                        <td><?= $tarihson ?></td>
                                        <td><?= $data['namesurname'] ?></td>
                                        <td><?= $old ?></td>
                                        <th scope="col"><?= $PayDestek ?></th>
                                        <td class="r"><?= reformatter((($sonGunluk / $pay) * 2) * 360*$payyuzde*$agicarpan) ?> TL</td>
                                        
                                        <td><?= $spouse['name'] ?></td>
                                        <td><?= $ageofSpouse->y + $ii ?></td>
                                        <th scope="col"><?= $PayEs ?></th>
                                        <td class="r"><?= reformatter((($sonGunluk / $pay) * 2) * 360*$payyuzde*$agicarpan) ?> TL</td>
                                        
                                        
                                        <td colspan="2">
                                            <?php foreach ($childers as $child):
                                                
                                                $childname=$child['name'];
                                                $childbirthday=$child['birthday'];
                                                
                                                if (!$child['name'])
                                                    break;
                                                
                                                $ageofChild = date_diff(date_create($child['birthday']), date_create(date("Y-m-d", strtotime(($yil + $ii) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday']))))));

                                                ?>
                                                <div><?= $childname ?> - <?= $ageofChild->y +1 ?></div>
                                            <?php endforeach; ?>
                                        
                                        <th scope="col"><?= $PayCocuk ?> </th>
                                        <td class="r"><?= reformatter(($sonGunluk / $pay) * $totalTazChild*$agicarpan) ?></td>
                                        
                                        <td><?= ($dadMom[0]['name']) ? $dadMom[0]['name'] : "Ölü" ?></td>
                                        <td><?= ($dadMom[0]['name']) ? $ageofMom->y + $ii : "0" ?></td>
                                        <th scope="col"><?= $PayAnne ?></th>
                                        <td class="r"><?= reformatter(($sonGunluk / $pay)*360*$PayAnne*$payyuzde*$agicarpan) ?>  TL </td>
                                        
                                        <td><?= ($dadMom[1]['name']) ? $dadMom[1]['name'] : "Ölü" ?></td>
                                        <td><?= ($dadMom[1]['name']) ? $ageofDad->y + $ii : "0" ?></td>
                                        <th scope="col"><?= $PayBaba ?></th>
                                        <td class="r"><?= reformatter(($sonGunluk / $pay)*360*$PayBaba*$payyuzde*$agicarpan); ?> TL</td>
                                        
                                        <td><?= $pay ?></td>
                                        <td><?= $paydas ?></td>
        
                                    </tr>
                                    <?php
                                    $lastYear = date("Y-m-d", strtotime($data['workenddate'] . " +" . ($ii + 1) . " year"));
                                    $old = ($ii + 1) + $ageofWorker->y;
                                    
                                    $cocuktoplam += ($sonGunluk / $pay) * $totalTazChild*$agicarpan;
                                    $destektoplam += ($sonGunluk / $pay) * 2 * 360*$payyuzde*$agicarpan;
                                    $estoplam += ($sonGunluk / $pay) * 2 * 360*$payyuzde*$agicarpan;
                                    $babatoplam += ($sonGunluk / $pay)*360*$PayBaba*$payyuzde*$agicarpan;
                                    $annetoplam += ($sonGunluk / $pay)*360*$PayAnne*$payyuzde*$agicarpan;
                                    

                                    if ($old > 59)
                                        break;
                                endfor;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    <b>
                        DESTEK : <?= reformatter($destektoplam) ?> TL 
                        | EŞ : <?= reformatter($estoplam) ?> TL
                        | ÇOCUK : <?= reformatter($cocuktoplam) ?> TL
                        | ANNE : <?= reformatter($annetoplam) ?> TL
                        | BABA : <?= reformatter($babatoplam) ?>TL
                    </b>
                </div>
 


                <br>
                <br>
                <br>


                <div class="card">
                    <div class="card-header text-center">
                        PASİF DÖNEM
                        (<?= date("d.m.Y", strtotime("+ 60 years + 1 day", strtotime($data['birthday']))) ?>
                        - <?= date("d.m.Y", strtotime("+ " . ($aktifIslemisDonem->y + $pasifTotalİsci->y) . " years " . ($aktifIslemisDonem->m + $pasifTotalİsci->m) . " months " . ($aktifIslemisDonem->d + $pasifTotalİsci->d) . " days", strtotime($data['workenddate']))) ?>
                        ARASI) PAYLAŞTIRMA
                    </div>
                    <div class="card-body">
                        <p class="text-center"><b>PASİF DÖNEM KAZANCI : <?= reformatter($totalPasif) ?> TL</b></p>
                        <hr>
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">DESTEK YAŞ</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">EŞİ</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">ÇOCUK</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">ANNE</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">BABA</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $totalPasifPay = 0;
                                
                                for ($i = 0;
                                $i < ($pasifTotalİsci->y + 1);
                                $i++):

                                $pay = 4 + (count($childers));

                                if (($pasifOmur1 - $i) >= 1) {
                                    $day = 1;
                                } else {
                                    $day = ($pasifOmur1 - $i);
                                }

                                $ex = explode('.',$pasifOmur1);
                                if ($ex[1] != 00) {
                                    $day = 1 - ( 1- ($ex[1]/100));
                                    $pasifOmur1 -= $ex[1]/100;
                                }
                                $personPay = ($sonAsgeriGun * (360 * $day)) / $pay;

                                $totalPasifPay += $personPay * $pay;


                                if (($kalanS = $spouseBakiyeH - $i) > 0) {
                                    $personPaysSpon = $personPay * 2;
                                } else {
                                    $kalanS = 0;
                                    $personPaysSpon = 0;
                                }

                                $payChild = 0;
                                $childTable = '';
                                $back  = '';

                                if (!$childers[0]['name'] && count($childers) != 0) {
                                    $childTable = count($childers);
                                    $back  = '-';
                                    $payChild = (count($childers))*$personPay;
                                } else {
                                    $childTable = '-';
                                    $back = 0;
                                    $payChild = 0;
                                }

                                foreach ($childers as $childer){
                                    if ($childer['disabled'] == 'on'){
                                        $payChild += $personPay;
                                        $childTable .= $childer['name'].'';
                                        $back = '-';
                                    }
                                }

                                ?>
                                <tr>
                                    <td><?= 60 + $i ?></td>
                                    <td><?= reformatter($pasifOmur - $i) ?></td>
                                    <td><?= reformatter($personPay * 2); ?> TL</td>
                                    <td><?= $ageofSpouseH->y + $i ?></td>
                                    <td><?= reformatter($kalanS) ?></td>
                                    <td><?= reformatter($personPaysSpon); ?> TL</td>
                                    <td><?php foreach ($childers as $child):
                                                
                                                $childname=$child['name'];
                                                $childbirthday=$child['birthday'];
                                                
                                                if (!$child['name'])
                                                    break;
                                                
                                                $ageofChild = date_diff(date_create($child['birthday']), date_create(date("d.m.Y", strtotime("+ 60 years + ".$i." years", strtotime($data['birthday'])))));

                                                ?>
                                                <div><?= $childname ?> - <?= $ageofChild->y +1 ?></div>
                                            <?php endforeach; ?></td>
                                    
                                    <td><?= $back ?></td>
                                    <td><?=reformatter($payChild)?> TL</td>
                                    <td><?= ($dadMom[0]['name']) ? $dadMom[0]['name'] : "Ölü" ?></td>
                                    <td>0</td>
                                    <td><?=reformatter($payMom)?> TL</td>
                                    <td><?= ($dadMom[1]['name']) ? $dadMom[1]['name'] : "Ölü" ?></td>
                                    <td>0</td>
                                    <TD><?=reformatter($payDad)?> TL</TD>
                                </tr>
                                </tbody>
                                <?php endfor; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="text-center"><b>PASİF DÖNEM KAZANCI : <?= reformatter($totalPasifPay) ?> TL</b></div>
                </div>
                
                
                
            <?php else: ?>
                <div class="card">
                    <div class="card-header">
                        <center>İŞLEMİŞ DÖNEM (<?= date("d.m.Y", strtotime($data['workstartdate'])) ?>
                            - <?= date("d.m.Y", strtotime($data['workenddate'])) ?> ARASI) PAYLAŞTIRMA
                        </center>
                    </div>
                    <div class="card-body">
                        <p class="text-center"><b>İŞLEMİŞ DÖNEM KAZANCI : <?= reformatter($totalWork) ?> TL</b></p>
                        <hr>
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">DESTEK</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">EŞ</th>
                                    <th scope="col">İŞ. DNM.</th>
                                    <th scope="col">ÇOCUK</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">ANNE</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">BABA</th>
                                    <th scope="col">İŞ. DN.</th>
                                    <th scope="col">TOPLAM PAY</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $esKenPay = 0;
                                $esPayTo = 0;
                                $annebabaPay = 0;
                                $cocukPay = 0;
                                $marriedKey = 0;
                                foreach ($asgeriUcret as $key => $ucret):
                                    $minus = 0;
                                    $now = $islemisDonemPay;
                                    $docLater = explode(".", $islemisDonemPay);
                                    if ($docLater[1] > 51) {
                                        $islemisDonemPay -= $minus = ($docLater[1] / 100);
                                    } else {
                                        $islemisDonemPay -= $minus = (50 / 100);
                                    }

                                    $maas = numberReformat($ucret['gunluknet'], 2) * ($minus * 360);
                                    $pay = 2 + (($dadMom[0]['name'] || $dadMom[1]['name']) ? 2 : 0) + count($childers);
                                    $maasPay = $maas / $pay;

                                    if (count($childers) == 0) {
                                        if ($marriedKey + 4 <= $key) {
                                            $pay += 1;
                                            $childers[] = ["first Child"];
                                        }
                                    } else if (count($childers) == 1) {
                                        if (($marriedKey + 8) <= $key) {
                                            $pay += 1;
                                            array_push($childers, "second Child");
                                        }
                                    }

                                    if (
                                        ($data['gender'] == "men" && $ageofWorker->y < 27 && $key >= ((25 - $ageofWorker->y * 2)))
                                        || ($data['gender'] == "men" && $ageofWorker->y > 27 && $key >= 4)
                                        || ($data['gender'] == "women" && $ageofWorker->y < 24 && $key >= ((23 - $ageofWorker->y) * 2)
                                            || ($data['gender'] == "women" && $ageofWorker->y > 24 && $key >= 4))) {
                                        if ($marriedKey > $key) {
                                            $marriedKey = $key;
                                        }
                                        $pay = $pay + 2;
                                        $maasPay = $maas / $pay;
                                        $esPay = ($maasPay * 2);
                                        $esPayTo += $maasPay * 2;
                                    } else {
                                        $esPay = 0;
                                    }


                                    $cocukPay += ($maasPay * count($childers));
                                    $esKenPay += ($maasPay * 2);
                                    $annebabaPay += ($maasPay * 2);
                                    if ($docLater[0] == 0 && $docLater[1] == 0)
                                        break;

                                    ?>
                                    <tr>
                                        <td><?= number_format((2 * $maasPay), 2, ".", ",") ?> TL</td>
                                        <td><?= $now ?> Yıl</td>
                                        <td><?= reformatter($esPay) ?> TL</td>
                                        <td><?= $now ?> Yıl</td>
                                        <td><?= reformatter($maasPay * count($childers)) ?> TL</td>
                                        <td><?= (count($childers) > 0) ? $now : 0 ?> Yıl</td>
                                        <td><?= reformatter(($dadMom[0]['name']) ? (!$dadMom[1]['name']) ? ($maasPay * 2) : ($maasPay) : 0) ?>
                                            TL
                                        </td>
                                        <td><?= ($dadMom[0]['name']) ? $now : 0 ?> Yıl</td>
                                        <td><?= reformatter(($dadMom[1]['name']) ? (!$dadMom[0]['name']) ? ($maasPay * 2) : ($maasPay) : 0) ?>
                                            TL
                                        </td>
                                        <td><?= ($dadMom[1]['name']) ? $now : 0 ?> Yıl</td>
                                        <td><?= $pay ?></td>
                                    </tr>
                                <?php

                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">

                        <b>DESTEK : <?= reformatter($esKenPay) ?> TL | EŞ : <?= reformatter($esPayTo) ?> TL
                            <?php for ($i = 1; $i <= count($childers); $i++): ?>
                                | ÇOCUK <?= $i ?> : <?= reformatter(($cocukPay / count($childers))) ?> TL
                            <?php endfor; ?>
                            | ANNE
                            : <?= reformatter(($dadMom[1]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?> TL | BABA
                            : <?= reformatter(($dadMom[0]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?>
                            TL</b>
                    </div>
                </div>

                <br>
                <br>
                <br>

                <div class="card" >
                    <div class="card-header text-center">
                        AKTİF DÖNEM (<?= date("d.m.Y", strtotime($data['workenddate'])) ?>
                        - <?= date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) ?>
                        ARASI) PAYLAŞTIRMA
                    </div>
                    <div class="card-body">
                        <p style="text-align: center;"><b>AKTİF DÖNEM KAZANCI : <?= reformatter($yillikGiren) ?> TL</b>
                        </p>
                        <hr>
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">DESTEK</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">ÜCRET</th>
                                    <th scope="col">EŞİ</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">ÜCRET</th>
                                    <th scope="col">ÇOCUK</th>
                                    <th scope="col">YAŞI</th>
                                    <th scope="col">ÜCRET</th>
                                    <th scope="col">ANNE</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">ÜCRET</th>
                                    <th scope="col">BABA</th>
                                    <th scope="col">YAŞ</th>
                                    <th scope="col">ÜCRET</th>
                                    <th scope="col">PAY</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $esKenPay = 0;
                                $annebabaPay = 0;
                                $cocukPay = 0;
                                $old = $ageofWorker->y;

                                $lastYear = $data['workenddate'];
                                for ($ii = 0; $ii < ($isciBakiye[0] + 1); $ii++):

                                    $pay = 4 + (($dadMom[0]['name'] || $dadMom[1]['name']) ? 2 : 0);
                                    $totalTazChild = 0;
                                    $payMinus = 0;
                                    if ($childers[0]['name']) {
                                        foreach ($childers as $child) {
                                            $ageofChild = date_diff(date_create($child['birthday']), date_create(date("Y-m-d", strtotime(($yil + $ii - 1) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday']))))));
                                            $childTaz = date_diff(date_create($lastYear), date_create(date("Y-m-d", strtotime(($yil + $ii + 1) . "-" . date("m", strtotime($data['workenddate'])) . "-" . date("d", strtotime($data['workenddate']))))));

                                            if ($child['gender'] == "men" && $ageofChild->y <= 18 && $child['uni'] != "on") {
                                                $pay += 1;
                                                $payMinus += 1;
                                                $totalTazChild += ($childTaz->y * 360) + ($childTaz->m * 30) + $childTaz->d;
                                            } else if ($child['uni'] == "on") {
                                                if (($child['gender'] == "women" && $ageofChild->y <= 26) || ($child['gender'] == "men" && $ageofChild->y <= 22)) {
                                                    $pay += 1;
                                                    $payMinus += 1;
                                                    $totalTazChild += ($childTaz->y * 360) + ($childTaz->m * 30) + $childTaz->d;
                                                }
                                            } else if ($child['gender'] == "women" && $ageofChild->y <= 22 && $child['uni'] != "on") {
                                                $pay += 1;
                                                $payMinus += 1;
                                                $totalTazChild += ($childTaz->y * 360) + ($childTaz->m * 30) + $childTaz->d;
                                            }
                                        }
                                    } else {
                                        $totalTazChild = 360;
                                    }

                                    $maas = $sonGunluk * 30;
                                    $lastPay = $maas / $pay;
                                    $esKenPay += ($lastPay * 2) * 12;
                                    $annebabaPay += ($lastPay * 2) * 12;

                                    $cocukPay += (($sonGunluk / $pay) * $totalTazChild);

                                    if (($isciBakiyeDad - $ii) > 0) {
                                        $personPayDad = ($dadMom[1]['name']) ? ((!$dadMom[0]['name']) ? ($lastPay * 2) * 12 : ($lastPay) * 12) : 0;
                                        $annebabaPay += ($lastPay * 2) * 12;
                                    } else {
                                        $personPayDad = 0;
                                    }

                                    if (($isciBakiyeMom - $ii) > 0) {
                                        $personPayMom = ($dadMom[0]['name']) ? (!$dadMom[1]['name']) ? ($lastPay * 2) * 12 : ($lastPay) * 12 : 0;
                                        $annebabaPay += ($lastPay * 2) * 12;
                                    } else {
                                        $personPayMom = 0;
                                    }

                                    if ($isciBakiyeMom - $ii < 0) {
                                        $personPayDad = $personPayDad * 2;
                                        $payMinusEk += 2;
                                    }

                                    if ($isciBakiyeDad - $ii < 0) {
                                        $personPayMom *= 2;
                                        $payMinusEk += 2;
                                    }

                                    ?>
                                    <tr>
                                        <td><?= $data['namesurname'] ?></td>
                                        <td><?= $old ?></td>
                                        <td><?= reformatter(($lastPay * 2) * 12) ?> TL</td>
                                        <td><?= "-" ?></td>
                                        <td><?= "-" ?></td>
                                        <td><?= reformatter(($lastPay * 2) * 12) ?> TL</td>
                                        <td colspan="2">
                                            <?php if ($childers[0]['name']): ?>
                                                <?php foreach ($childers as $child):
                                                    $ageofChild = date_diff(date_create($child['birthday']), date_create(date("01-01-" . ($yil + $ii))));
                                                    ?>
                                                    <div><?= $child['name'] ?> - <?= $ageofChild->y ?></div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?= reformatter((($sonGunluk / $pay) * $totalTazChild)) ?> TL</td>
                                        <td><?= ($dadMom[0]['name']) ? $dadMom[0]['name'] : "Ölü" ?></td>
                                        <td><?= ($dadMom[0]['name']) ? $ageofMom->y + $ii : "0" ?></td>
                                        <td><?= reformatter($personPayMom); ?> TL</td>
                                        <td><?= ($dadMom[1]['name']) ? $dadMom[1]['name'] : "Ölü" ?></td>
                                        <td><?= ($dadMom[1]['name']) ? $ageofDad->y + $ii : "0" ?></td>
                                        <td><?= reformatter($personPayDad); ?> TL</td>
                                        <td><?= $pay ?> - <?= (($pay - $payMinus) / 2 + 1) + $payMinus ?></td>

                                    </tr>
                                    <?php
                                    $lastYear = date("Y-m-d", strtotime($data['workenddate'] . " +" . ($ii + 1) . " year"));
                                    $old = ($ii + 1) + $ageofWorker->y;

                                    if ($old > 59)
                                        break;
                                endfor;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    <b>DESTEK : <?= reformatter($esKenPay) ?> TL | EŞ : <?= reformatter($esKenPay) ?> TL
                        <?php for ($i = 1; $i <= count($childers); $i++): ?>
                            | ÇOCUK <?= $i ?> : <?= reformatter(($cocukPay / count($childers))) ?> TL
                        <?php endfor; ?>
                        | ANNE
                        : <?= reformatter(($dadMom[1]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?> TL | BABA
                        : <?= reformatter(($dadMom[0]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?>
                        TL</b>
                </div>


                <br>
                <br>
                <br>


                <div class="card">
                    <div class="card-header text-center">
                        PASİF DÖNEM
                        (<?= date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) ?>
                        - <?= date("d.m.Y", strtotime("+ " . ($aktifIslemisDonem->y + $pasifTotalİsci->y) . " years " . ($aktifIslemisDonem->m + $pasifTotalİsci->m) . " months " . ($aktifIslemisDonem->d + $pasifTotalİsci->d) . " days", strtotime($data['workenddate']))) ?>
                        ARASI) PAYLAŞTIRMA
                    </div>
                    <div class="card-body">
                        <p class="text-center"><b>PASİF DÖNEM KAZANCI : <?= reformatter($totalPasif) ?> TL</b></p>
                        <hr>
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                <tr>
                                    
                                    <th scope="col">DESTEK YAŞ</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">EŞİ</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">ÇOCUK</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">ANNE</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                    <th scope="col">BABA</th>
                                    <th scope="col">KALAN</th>
                                    <th scope="col">TAZMİNAT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $totalPasifPay = 0;
                                for ($i = 0;
                                $i <= ($pasifTotalİsci->y);
                                $i++):

                                $pay = 4 + count($childers);

                                if (($pasifOmur1 - $i) >= 1) {
                                    $day = 1;
                                } else {
                                    $day = ($pasifOmur1 - $i);
                                }

                                $ex = explode('.',$pasifOmur1);
                                if ($ex[1] != 00) {
                                    $day = 1 - ( 1- ($ex[1]/100));
                                    $pasifOmur1 -= $ex[1]/100;
                                }
                                $personPay = ($sonAsgeriGun * (360 * $day)) / $pay;

                                $totalPasifPay += $personPay * $pay;


                                ?>
                                <tr>
                                    <td><?= 60 + $i ?></td>
                                    <td><?= reformatter($pasifOmur - $i) ?></td>
                                    <td><?= reformatter($personPay * 2); ?> TL</td>
                                    <td><?= "-" ?></td>
                                    <td><?= "-" ?></td>
                                    <td><?= reformatter($personPay * 2); ?> TL</td>
                                    <td><?= count($childers) ?></td>
                                    <td><?= "-" ?></td>
                                    <td><?= reformatter($personPay * 2); ?> TL</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0 TL</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <TD>0 TL</TD>
                                </tr>
                                </tbody>
                                <?php endfor; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="text-center"><b>PASİF DÖNEM KAZANCI : <?= reformatter($totalPasifPay) ?> TL</b></div>
                </div>
            <?php endif; ?>

            <br>
            <br>
            <br>

            <div class="text-center">
                <a href="javascript:if(window.print)window.print()" class="btn btn-outline-primary">DÖKÜMÜ YAZDIR</a>
            </div>
            <br>
        </div>
    </div>
</div>