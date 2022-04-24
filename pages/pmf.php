<?php

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center mt-5">
                <div class="card-header">
                    BAKİYE ÖMÜR TABLOSU / DESTEK HAK SAHİPLERİ
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">DESTEK ADI</th>
                                <th scope="col">KUSUR ORANI</th>
                                <th scope="col">ÜCRET</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= $data['namesurname'] ?></td>
                                <td>% <?= $data['rate'] ?></td>
                                <td><?= $data['netpay'] ?> TL</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">OLAY TRH.</th>
                                <th scope="col">DOĞUM TRH.</th>
                                <th scope="col">OLAY TRH. YAŞ</th>
                                <th scope="col">OLAY TRH. BAK. Ö.</th>
                                <th scope="col">İŞLEMİŞ D.</th>
                                <th scope="col">AKTİF D.</th>
                                <th scope="col">PASİF D.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= date("d.m.Y", strtotime($data['workstartdate'])) ?></td>
                                <td><?= date("d.m.Y", strtotime($data['birthday'])) ?></td>
                                <td><?= $ageofWorker->y ?> YIL <?= $ageofWorker->m ?> AY</td>
                                <td><?= $isciBakiye[0] ?> YIL <?= (floor((($isciBakiye[1] / 100) * 360) / 30)) ?> AY</td>
                                <td><?= $aktifid->y . " YIL " . $aktifid->m . " AY" ?></td>
                                <td>
                                    <?php
                                        if($aktifIslemisDonem) {
                                            echo $aktifIslemisDonem->y . " YIL " . $aktifIslemisDonem->m . " AY";
                                        } else {
                                            echo "YOK";
                                        }
                                    ?>
                                </td>
                                <td><?= $pasifTotalİsci->y ?> YIL <?= $pasifTotalİsci->m ?> AY</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <br>
                    <br>

                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">YAKINLIK DRC.</th>
                                <th scope="col">PAY SHP.</th>
                                <th scope="col">DOĞUM TRH.</th>
                                <th scope="col">OLAY TRH. YAŞ</th>
                                <th scope="col">OLAY TRH. BAK. Ö.</th>
                                <th scope="col">HESAP TRH. DESTEK SÜRESİ</th>
                                <th scope="col">OLAY TRH. DESTEK SÜRESİ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>EŞ</td>
                                <td><?= $spouse['name'] ?></td>
                                <td><?= date("d.m.Y", ($data['marital'] == 'single') ? strtotime($data['birthday']) : strtotime($spouse['birthday'])) ?></td>
                                <td><?= $ageofSpouse->y ?> YIL <?= $ageofSpouse->m ?> AY</td>
                                <td><?= $spouseBakiye[0] ?> YIL <?= (floor((($spouseBakiye[1] / 100) * 360) / 30)) ?>AY</td>
                                <td>-</td>
                                <td><?php if ($isciBakiye[0] > $spouseBakiye[0]): ?> <?= $spouseBakiye[0] ?> YIL <?= (floor((($spouseBakiye[1] / 100) * 360) / 30)) ?>AY <?php else: ?> <?= $isciBakiye[0]; ?> YIL <?= (floor((($isciBakiye[1] / 100) * 360) / 30)) ?> AY <? endif; ?></td>
                            </tr>

                            <?php
                            foreach ($childers as $key => $child):
                                $ageofChild = date_diff(date_create($child['birthday']), date_create($data['workstartdate']));
                                $childBakiye = $db->from("pmf_bakiyeomur")->where("yas", $ageofChild->y)->first()['omurtablosu'];
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
                                if($ageofChild->invert):
                                ?>
                                <tr>
                                    <td>ÇOCUK <?= $key + 1 ?></td>
                                    <td><?= $child['name'] ?></td>
                                    <td><?= date("d.m.Y", strtotime($child['birthday'])) ?></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            <?php 
                                else:
                            ?>
                                <tr>
                                    <td>ÇOCUK <?= $key + 1 ?></td>
                                    <td><?= $child['name'] ?></td>
                                    <td><?= date("d.m.Y", strtotime($child['birthday'])) ?></td>
                                    <td><?= $ageofChild->y ?> YIL <?= $ageofChild->m ?> AY</td>
                                    <td><?= $childBakiye[0] ?> YIL <?= (floor((($childBakiye[1] / 100) * 360) / 30)) ?>AY
                                    </td>
                                    <td><?= $destek->y; ?> YIL <?= $destek->m ?> AY</td>
                                    <td><?= $destekOlay->y; ?> YIL <?= $destekOlay->m ?> AY</td>
                                </tr>
                            <?php
                                endif;
                            endforeach;
                            ?>

                            <?php
                            foreach ($dadMom as $item):
                                $ageoffamily = date_diff(date_create($item['birthday']), date_create($data['workstartdate']));
                                $familyBakiye = $db->from("pmf_bakiyeomur")->where("yas", $ageoffamily->y)->first()['omurtablosu'];
                                $familyBakiye = explode(".", $familyBakiye);

                                $ageofWorker2 = date_diff(date_create($data['birthday']), date_create($data['workenedate']));
                                $isciBakiye2 = $db->from("pmf_bakiyeomur")->where("yas", $ageofWorker2->y)->first()['omurtablosu'];
                                $isciBakiye2 = explode(".", $isciBakiye2);

                                $destekOlay = date_diff(date_create(date("d-m-Y", strtotime("+ " . ($isciBakiye->y + $ageofWorker->y) . " years " . ($isciBakiye->m + $ageofWorker->m) . " months " . ($isciBakiye->d + $ageofWorker->d) . " days", strtotime($data['workstartdate'])))),
                                    date_create(date("d-m-Y", strtotime("+ $ageoffamily->y years $ageoffamily->m months $ageoffamily->d days", strtotime($data['workstartdate'])))));
                                $destek = date_diff(date_create(date("d-m-Y", strtotime("+ " . ($isciBakiye2->y + $ageofWorker2->y) . " years " . ($isciBakiye2->m + $ageofWorker2->m) . " months " . ($isciBakiye2->d + $ageofWorker2->d) . " days", strtotime($data['workenddate'])))),
                                    date_create(date("d-m-Y", strtotime("+ $ageoffamily->y years $ageoffamily->m months $ageoffamily->d days", strtotime($data['workenddate'])))));

                                ?>
                                <tr>
                                    <td><?= $item['prefix'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= date("d.m.Y", strtotime($item['birthday'])) ?></td>
                                    <td><?= $ageoffamily->y ?> YIL <?= $ageoffamily->m ?> AY</td>
                                    <td><?= $familyBakiye[0] ?> YIL <?= (floor((($familyBakiye[1] / 100) * 360) / 30)) ?>
                                        AY
                                    </td>
                                    <td><?= $destek->y; ?> YIL <?= $destek->m ?> AY</td>
                                    <td><?php if ($destekOlay->y > $familyBakiye[0]): ?> <?= $familyBakiye[0] ?> YIL <?= (floor((($familyBakiye[1] / 100) * 360) / 30)) ?>
                                            AY <?php else: ?> <?= $destekOlay->y; ?> YIL <?= $destekOlay->m ?> AY <?php endif; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <br>
            <hr>
            <br>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist" style="">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                            type="button" role="tab" aria-controls="nav-home" aria-selected="true">İŞLEMİŞ D.H.
                    </button>
                    <?php if($aktifIslemisDonem): ?>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">AKTİF DÖNEM K.T.
                        </button>
                    <?php endif; ?>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                            type="button" role="tab" aria-controls="nav-contact" aria-selected="false">PASİF DÖNEM K. T.
                    </button>
                    <button class="nav-link" id="nav-idp-tab" data-bs-toggle="tab" data-bs-target="#nav-idp"
                            type="button" role="tab" aria-controls="nav-idp" aria-selected="false">İŞLEMİŞ DÖNEM
                        PAYLAŞTIRMA
                    </button>
                    <?php if($aktifIslemisDonem): ?>
                        <button class="nav-link" id="nav-adp-tab" data-bs-toggle="tab" data-bs-target="#nav-adp"
                                type="button" role="tab" aria-controls="nav-idp" aria-selected="false">AKTİF DÖNEM
                            PAYLAŞTIRMA
                        </button>
                    <?php endif; ?>
                    <button class="nav-link" id="nav-pdp-tab" data-bs-toggle="tab" data-bs-target="#nav-pdp"
                            type="button" role="tab" aria-controls="nav-pdp" aria-selected="false">PASİF DÖNEM
                        PAYLAŞTIRMA
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active py-2" id="nav-home" role="tabpanel"
                     aria-labelledby="nav-home-tab">
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
                                        $isLastKey = key(array_slice($asgeriUcret, -1, 1, true));
                                        $gunluk = numberReformat($ucret['gunluknet'], 2);
                                        $donem = array(
                                            'floor' => ((substr($ucret['donemler'], -1) == 1) ? ("01.01." . substr($ucret['donemler'], 0, 4)) : ("01.07." . substr(($ucret['donemler']), 0, 4))),
                                            'ceil' => ((substr($ucret['donemler'], -1) == 1) ? ("01.07." . substr($ucret['donemler'], 0, 4)) : ("01.01." . (substr(($ucret['donemler']), 0, 4) + 1)))
                                        );
                                        if ($key == "0") {
                                            $dateNew = date("d.m.Y", strtotime($data['workstartdate'])) . " - " . $donem['ceil'];
                                            $diff = new DateDifference($data['workstartdate'], $donem['ceil']);
                                            $gun = $diff->days;
                                        } else if ($key == $isLastKey) {
                                            $dateNew = ((substr($asgeriUcret[$key-1]['donemler'], -1) == 2) ? "01.01." . substr(($asgeriUcret[$key-1]['donemler']), 0, 4) : "01.07." . substr($asgeriUcret[$key-1]['donemler'], 0, 4)) . " - " . date("d.m.Y", strtotime($data['workenddate']));
                                            $diff = new DateDifference((substr($asgeriUcret[$key-1]['donemler'], -1) == 2) ? "01.01." . substr(($asgeriUcret[$key-1]['donemler']), 0, 4) : "01.07." . substr($asgeriUcret[$key-1]['donemler'], 0, 4), $data['workenddate']);
                                            $gun = $diff->days;
                                            $sonGunluk = number_format($data['factor'] * $gunluk, 2);
                                            $sonAsgeriGun = number_format($gunluk, 2);
                                        } else {
                                            $dateNew = ((substr($asgeriUcret[$key - 1]['donemler'], -1) == 2) ? "01.01." . (substr($asgeriUcret[$key - 1]['donemler'], 0, 4) + 1) : "01.07." . substr($asgeriUcret[$key - 1]['donemler'], 0, 4)) . " - " . ((substr($ucret['donemler'], -1) == 2) ? "01.01." . (substr(($ucret['donemler']), 0, 4) + 1) : "01.07." . substr($ucret['donemler'], 0, 4));
                                            $gun = (6 * 30);
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
                </div>
                <?php if($aktifIslemisDonem): ?>
                    <div class="tab-pane fade py-2" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                                            $ex = explode('.', $omur);

                                            if (($yil + $i) == (date("Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) + 1)) {
                                                $days = 1 - (($i + $yas) - 60);
                                                $old = 60;
                                            } else if ($ex[1] != 00) {
                                                $days = 1 - (1 - ($ex[1] / 100));
                                                $omur -= $ex[1] / 100;
                                            }

                                            if ($i == 0){
                                                $fark = date_diff(date_create($data['workenddate']), date_create(date('01-01-Y' ,strtotime('+1 years '. $data['workenddate']))));
                                                $days = (($fark->m*30)+$fark->d)/360;
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
                                            if ($old >= 60) {
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
                    </div>
                <?php endif; ?>
                <div class="tab-pane fade py-2" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
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
                                        $ex = explode('.', $pasifOmur);
                                        if ($ex[1] != 00) {
                                            $day = 1 - (1 - ($ex[1] / 100));
                                            $pasifOmur -= $ex[1] / 100;
                                        }

                                        $totalPasif += ($sonAsgeriGun * (360 * $day));
                                        ?>
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
                </div>


                <?php if ($data['marital'] == "married"): ?>
                    <div class="tab-pane fade py-2" id="nav-idp" role="tabpanel" aria-labelledby="nav-idp-tab">
                        <div class="card">
                            <div class="card-header text-center">
                                İŞLEMİŞ DÖNEM (<?= date("d.m.Y", strtotime($data['workstartdate'])) ?>
                                    - <?= date("d.m.Y", strtotime($data['workenddate'])) ?> ARASI) PAYLAŞTIRMA
                            </div>
                            <div class="card-body">
                                <p class="text-center"><b>İŞLEMİŞ DÖNEM KAZANCI : <?= reformatter($totalWork) ?> TL</b>
                                </p>
                                <hr>
                                <div class="table-wrapper">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">DÖNEM</th>
                                            <th scope="col">İŞ. DN.</th>
                                            <th scope="col">DESTEK</th>
                                            <th scope="col">EŞ</th>
                                            <?php
                                                for($i=0; $i < count($childers); $i++):    
                                            ?>
                                                <th scope="col"><?=($i+1) ?>. ÇOCUK</th>
                                            <?php
                                                endfor;
                                            ?>
                                            <th scope="col">ANNE</th>
                                            <th scope="col">BABA</th>
                                            <th scope="col">TOPLAM PAY</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $destekTotal = 0;
                                        if($spouse['name']) $spouse['total'] = 0;
                                        if($dadMom[0]['name']) $dadMom[0]['total'] = 0;
                                        if($dadMom[1]['name']) $dadMom[1]['total'] = 0;
                                        for($i = 0; $i < count($childers); $i++) {
                                            if($childers[$i]['name']) $childers[$i]['total'] = 0;
                                        }
                                        foreach ($asgeriUcret as $key => $ucret):
                                            $minus = 0;
                                            $now = $islemisDonemPay;
                                            $docLater = explode(".", $islemisDonemPay);

                                            $donem = array(
                                                'floor' => substr($ucret['donemler'], -1) == 1 ? "01.01." . substr($ucret['donemler'], 0, 4) : "01.07." . substr($ucret['donemler'], 0, 4),
                                                'ceil' => substr($ucret['donemler'], -1) == 1 ? "01.07." . substr($ucret['donemler'], 0, 4) : "01.01." . (substr($ucret['donemler'], 0, 4) + 1)
                                            );

                                            $isLastKey = $key == key(array_slice($asgeriUcret, -1, 1, true));
                                            
                                            // Dönem hesabı***
                                            if ($key == "0") {
                                                $dateNew =  date("d.m.Y", strtotime($data['workstartdate'])) . " - " . $donem['ceil'];
                                                $diff = new DateDifference($data['workstartdate'], $donem['ceil']);
                                                $gun = $diff->days;
                                            } else if ($key == $isLastKey) {
                                                $dateNew = ((substr($asgeriUcret[$key-1]['donemler'], -1) == 2) ? "01.01." . substr(($asgeriUcret[$key-1]['donemler']), 0, 4) : "01.07." . substr($asgeriUcret[$key-1]['donemler'], 0, 4)) . " - " . date("d.m.Y", strtotime($data['workenddate']));
                                                $diff = new DateDifference((substr($asgeriUcret[$key-1]['donemler'], -1) == 2) ? "01.01." . substr(($asgeriUcret[$key-1]['donemler']), 0, 4) : "01.07." . substr($asgeriUcret[$key-1]['donemler'], 0, 4), $data['workenddate']);
                                                $gun = $diff->days;
                                            } else {
                                                $dateNew = ((substr($asgeriUcret[$key - 1]['donemler'], -1) == 2) ? "01.01." . (substr($asgeriUcret[$key - 1]['donemler'], 0, 4) + 1) : "01.07." . substr($asgeriUcret[$key - 1]['donemler'], 0, 4)) . " - " . $donem['ceil'];
                                                $gun = (6 * 30);
                                            }

                                            $minus = number_format($gun/360, 2);
                                            $islemisDonemPay -= $minus;

                                            $maas = numberReformat($ucret['gunluknet'], 2) * $gun * $data['factor'];
                                            $pay = 4 + ($dadMom[0]['name'] ? 1 : 0) + ($dadMom[1]['name'] ? 1 : 0) + count($childers);
                                            $maasPay = $maas / $pay;

                                            $destekTotal += ($maasPay * 2);
                                            if($spouse['name']) $spouse['total'] += ($maasPay * 2);
                                            if($dadMom[0]['name']) $dadMom[0]['total'] += $maasPay;
                                            if($dadMom[1]['name']) $dadMom[1]['total'] += $maasPay;
                                            for($i = 0; $i < count($childers); $i++) {
                                                if($childers[$i]['name']) $childers[$i]['total'] += $maasPay;
                                            }

                                            if ($docLater[0] == 0 && $docLater[1] == 0)
                                                break;
                                            ?>
                                            <tr>
                                                <td><?= $dateNew ?></td>
                                                <td><?= $now ?> Yıl</td>
                                                <td><?= reformatter($maasPay * 2) ?> TL</td>
                                                <td><?= reformatter($maasPay * 2) ?> TL</td>
                                                <?php
                                                    for($i=0; $i < count($childers); $i++):    
                                                ?>
                                                    <td scope="col"><?= reformatter($maasPay) ?> TL</td>
                                                <?php
                                                    endfor;
                                                ?>
                                                <td><?= $dadMom[0]['name'] ? (reformatter($maasPay) . " TL") : "-" ?></td>
                                                <td><?= $dadMom[1]['name'] ? (reformatter($maasPay) . " TL") : "-" ?></td>
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

                                <b>
                                    DESTEK : <?= reformatter($destekTotal) ?> TL 
                                    <?= $spouse['name'] ? ("| EŞ : " . reformatter($spouse['total']) . " TL") : "" ?>
                                    <?php for ($i = 1; $i <= count($childers); $i++): ?>
                                        | <?= $i ?>. ÇOCUK : <?= reformatter($childers[$i-1]['total']) ?> TL
                                    <?php endfor; ?>
                                    <?= $dadMom[0]['name'] ? ("| ANNE : " . reformatter($dadMom[0]['total']) . " TL") : "" ?>
                                    <?= $dadMom[1]['name'] ? ("| BABA : " . reformatter($dadMom[1]['total']) . " TL") : "" ?>
                                </b>
                            </div>
                        </div>
                    </div>
                    <?php if($aktifIslemisDonem): ?>
                        <div class="tab-pane fade py-2" id="nav-adp" role="tabpanel" aria-labelledby="nav-adp-tab">
                            <div class="card">
                                <div class="card-header text-center">
                                    AKTİF DÖNEM (<?= date("d.m.Y", strtotime($data['workenddate'])) ?>
                                    - <?= date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) ?>
                                    ARASI) PAYLAŞTIRMA
                                </div>
                                <div class="card-body">
                                    <p style="text-align: center;"><b>AKTİF DÖNEM KAZANCI : <?= reformatter($yillikGiren) ?>
                                            TL</b>
                                    </p>
                                    <hr>
                                    <div class="table-wrapper">
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
                                                <?php
                                                    for($i=0; $i < count($childers); $i++):    
                                                ?>
                                                    <th scope="col"><?=($i+1) ?>. ÇOCUK</th>
                                                <?php
                                                    endfor;
                                                ?>
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
                                                $taz = 0;
                                                if (count($childers) == 0) {
                                                    if (4 <= $ii) {
                                                        $pay += 1;
                                                        $childers[] = ["first Child"];
                                                    }
                                                } else if (count($childers) == 1) {
                                                    if ((8) <= $ii) {
                                                        $pay += 1;
                                                        array_push($childers, "second Child");
                                                    }
                                                }
                                                if ($childers[0]['name']):
                                                    foreach ($childers as $key => $child) {
                                                        $ageofChild = date_diff(date_create($child['birthday']), date_create(date("Y-m-d", strtotime(($yil + $ii - 1) . "-" . date("m", strtotime($data['birthday'])) . "-" . date("d", strtotime($data['birthday']))))));
                                                        $childTaz = date_diff(date_create($lastYear), date_create(date("Y-m-d", strtotime(($yil + $ii + 1) . "-" . date("m", strtotime($data['workenddate'])) . "-" . date("d", strtotime($data['workenddate']))))));

                                                        if ($child['disabled'] == 'off') {
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
                                                        } else {
                                                            $pay += 1;
                                                            $payMinus += 1;
                                                            $totalTazChild += 360;
                                                        }

                                                    }
                                                else:
                                                    $pay += count($childers);
                                                    $totalTazChild = 360 * (count($childers));
                                                endif;

                                                $maas = $sonGunluk * 30;
                                                $lastPay = $maas / $pay;
                                                $esKenPay += ($lastPay * 2) * 12;

                                                $cocukPay += (($sonGunluk / $pay) * $totalTazChild);

                                                if (($isciBakiyeDad - $ii) > 0) {
                                                    $personPayDad = ($dadMom[1]['name']) ? ((!$dadMom[0]['name']) ? ($lastPay * 2) * 12 : ($lastPay) * 12) : 0;
                                                    $annebabaPay += ($lastPay * 2) * 12;
                                                } else {
                                                    $personPayDad = 0;
                                                }

                                                if (($isciBakiyeMom - $ii) > 0) {
                                                    $personPayMom = ($dadMom[0]['name']) ? (!$dadMom[1]['name']) ? ($lastPay * 2) * 12 : ($lastPay) * 12 : 0;
                                                } else {
                                                    $personPayMom = 0;
                                                }

                                                if ($isciBakiyeMom - $ii < 0) {
                                                    $personPayDad = $personPayDad * 2;
                                                    $payMinusEk += 1;
                                                }

                                                if ($isciBakiyeDad - $ii < 0) {
                                                    $personPayMom *= 2;
                                                    $payMinusEk += 1;
                                                }
                                                ?>
                                                <tr>
                                                    <td><?= $data['namesurname'] ?></td>
                                                    <td><?= $old ?></td>
                                                    <td><?= reformatter(($lastPay * 2) * 12) ?> TL</td>
                                                    <td><?= $spouse['name'] ?></td>
                                                    <td><?= $ageofSpouse->y + $ii ?></td>
                                                    <td><?= reformatter(($lastPay * 2) * 12) ?> TL</td>
                                                    <?php
                                                        for($i = 0; $i < count($childers); $i++):
                                                            if(!$childers[$i]['name']) break;
                                                            $ageofChild = date_diff(date_create($childers[$i]['birthday']), date_create(date("01-01-" . ($yil + $ii))));
                                                    ?>
                                                        <td>
                                                            <?= $childers[$i]['name'] ?> - <?= $ageofChild->y ?> - <?=reformatter((($sonGunluk / $pay) * $totalTazChild)/count($childers)) ?> TL
                                                        </td>
                                                    <?php
                                                        endfor;
                                                    ?>
                                                    <td><?= ($dadMom[0]['name']) ? $dadMom[0]['name'] : "Ölü" ?></td>
                                                    <td><?= ($dadMom[0]['name']) ? $ageofMom->y + $ii : "0" ?></td>
                                                    <td><?= reformatter($personPayMom) ?>
                                                        TL
                                                    </td>
                                                    <td><?= ($dadMom[1]['name']) ? $dadMom[1]['name'] : "Ölü" ?></td>
                                                    <td><?= ($dadMom[1]['name']) ? $ageofDad->y + $ii : "0" ?></td>
                                                    <td><?= reformatter($personPayDad); ?> TL</td>
                                                    <td><?= $pay ?>
                                                        - <?= (($pay - $payMinus) / 2 + 1) + ($payMinus - $payMinusEk) ?></td>

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
                            </div>
                            <div class="card-footer text-muted text-center">
                                <b>
                                    DESTEK : <?= reformatter($esKenPay) ?> TL | EŞ : <?= reformatter($esKenPay) ?> TL
                                    <? for($i=0; $i < count($childers); $i++): ?> | <?= $i+1 ?>. ÇOCUK : <?= reformatter($cocukPay/count($childers)) ?> TL <?php endfor; ?>
                                    | ANNE : <?= reformatter(($dadMom[1]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?> TL
                                    | BABA : <?= reformatter(($dadMom[0]['name']) ? ($annebabaPay / 2) : $annebabaPay) ?>TL
                                </b>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="tab-pane fade py-2" id="nav-pdp" role="tabpanel" aria-labelledby="nav-adp-pdp">
                        <div class="card">
                            <div class="card-header text-center">
                                PASİF DÖNEM
                                (<?= date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) ?>
                                - <?= date("d.m.Y", strtotime("+ " . ($aktifIslemisDonem->y + $pasifTotalİsci->y) . " years " . ($aktifIslemisDonem->m + $pasifTotalİsci->m) . " months " . ($aktifIslemisDonem->d + $pasifTotalİsci->d) . " days", strtotime($data['workenddate']))) ?>
                                ARASI) PAYLAŞTIRMA
                            </div>
                            <div class="card-body">
                                <p class="text-center"><b>PASİF DÖNEM KAZANCI : <?= reformatter($totalPasif) ?> TL</b>
                                </p>
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
                                            <?php
                                                for($j=0; $j < count($childers); $j++):    
                                            ?>
                                                <th scope="col"><?=($j+1) ?>. ÇOCUK</th>
                                                <th scope="col"><?=($j+1) ?>. Ç. KLN</th>
                                                <th scope="col"><?=($j+1) ?>. Ç. TZM</th>
                                            <?php
                                                endfor;
                                            ?>
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

                                        $ex = explode('.', $pasifOmur1);
                                        if ($ex[1] != 00) {
                                            $day = 1 - (1 - ($ex[1] / 100));
                                            $pasifOmur1 -= $ex[1] / 100;
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
                                        $back = '';

                                        if (!$childers[0]['name'] && count($childers) != 0) {
                                            $childTable = count($childers);
                                            $back = '-';
                                            $payChild = (count($childers)) * $personPay;
                                        } else {
                                            $childTable = '-';
                                            $back = 0;
                                            $payChild = 0;
                                        }

                                        foreach ($childers as $childer) {
                                            if ($childer['disabled'] == 'on') {
                                                $payChild += $personPay;
                                                $childTable .= $childer['name'] . '';
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
                                            <?php
                                                for($j=0; $j < count($childers); $j++):   
                                                    if(!$childers[$j]['name']) break;
                                                    $ageofChild = date_diff(date_create($childers[$j]['birthday']), date_create(date("01-01-" . ($yil + $i))));
                                                    $ageofChild->y += 60 - $ageofWorker->y + $i;
                                            ?>
                                                <td scope="col"><?= $childers[$j]['name'] ?> - <?= $ageofChild->y ?> - 0TL</td>
                                                <td scope="col">0TL</td>
                                                <td><?= reformatter($payChild) ?> TL</td>
                                            <?php
                                                endfor;
                                            ?>
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
                            <div class="text-center"><b>PASİF DÖNEM KAZANCI : <?= reformatter($totalPasifPay) ?> TL</b>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="tab-pane fade py-2" id="nav-idp" role="tabpanel" aria-labelledby="nav-idp-tab">
                        <div class="card">
                            <div class="card-header text-center">
                                İŞLEMİŞ DÖNEM (<?= date("d.m.Y", strtotime($data['workstartdate'])) ?>
                                    - <?= date("d.m.Y", strtotime($data['workenddate'])) ?> ARASI) PAYLAŞTIRMA
                            </div>
                            <div class="card-body">
                                <p class="text-center"><b>İŞLEMİŞ DÖNEM KAZANCI : <?= reformatter($totalWork) ?> TL</b>
                                </p>
                                <hr>
                                <div class="table-wrapper">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">DÖNEM</th>
                                            <th scope="col">İŞ. DN.</th>
                                            <th scope="col">DESTEK</th>
                                            <th scope="col">EŞ</th>
                                            <?php
                                                for($i=0; $i < count($childers); $i++):    
                                            ?>
                                                <th scope="col"><?=($i+1) ?>. ÇOCUK</th>
                                            <?php
                                                endfor;
                                            ?>
                                            <th scope="col">ANNE</th>
                                            <th scope="col">BABA</th>
                                            <th scope="col">TOPLAM PAY</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $destekTotal = 0;
                                        if($spouse['name']) $spouse['total'] = 0;
                                        if($dadMom[0]['name']) $dadMom[0]['total'] = 0;
                                        if($dadMom[1]['name']) $dadMom[1]['total'] = 0;
                                        if($childers[0]['name']) $childers[0]['total'] = 0;
                                        if($childers[1]['name']) $childers[1]['total'] = 0;

                                        $hasFirstChildBorn = FALSE;
                                        $doFirstChildGain = FALSE;
                                        $hasSecondChildBorn = FALSE;
                                        $doSecondChildGain = FALSE;
                                        $hasMarried = FALSE;
                                        $doWifeGain = FALSE;

                                        foreach ($asgeriUcret as $key => $ucret):
                                            $minus = 0;
                                            $now = number_format($islemisDonemPay, 2);
                                            $docLater = explode(".", $islemisDonemPay);

                                            $donem = array(
                                                'floor' => substr($ucret['donemler'], -1) == 1 ? "01.01." . substr($ucret['donemler'], 0, 4) : "01.07." . substr($ucret['donemler'], 0, 4),
                                                'ceil' => substr($ucret['donemler'], -1) == 1 ? "01.07." . substr($ucret['donemler'], 0, 4) : "01.01." . (substr($ucret['donemler'], 0, 4) + 1)
                                            );

                                            $isLastKey = $key == key(array_slice($asgeriUcret, -1, 1, true));
                                            
                                            // Evlenme durumunu kontrol et
                                            $diffMarriedAndDonem = new DateDifference($donem['floor'], date('d.m.Y', $marriedDate));
                                            if($diffMarriedAndDonem->y == 0 && ($diffMarriedAndDonem->m < 6/* || ($diffMarriedAndDonem->m == 6 && $diffMarriedAndDonem->d == 0)*/)) {
                                                // Invert: 1 olan tarih aralığında eş tazminat almaya başlar
                                                if($diffMarriedAndDonem->invert) $doWifeGain = TRUE;
                                                $hasMarried = TRUE;
                                            }
                                            // 1. Çocuğun doğup doğmama durumunu kontrol et
                                            $diffFirstChildBirthdayAndDonem = new DateDifference($donem['floor'], $childers[0]['birthday']);
                                            if($diffFirstChildBirthdayAndDonem->y == 0 && ($diffFirstChildBirthdayAndDonem->m < 6/* || ($diffFirstChildBirthdayAndDonem->m == 6 && $diffFirstChildBirthdayAndDonem->d == 0)*/)) {
                                                if($diffFirstChildBirthdayAndDonem->invert) $doFirstChildGain = TRUE;
                                                $hasFirstChildBorn = TRUE;
                                            }
                                            // 2. Çocuğun doğup doğmama durumunu kontrol et
                                            $diffSecondChildBirthdayAndDonem = new DateDifference($donem['floor'], $childers[1]['birthday']);
                                            if($diffSecondChildBirthdayAndDonem->y == 0 && ($diffSecondChildBirthdayAndDonem->m < 6/* || ($diffSecondChildBirthdayAndDonem->m == 6 && $diffSecondChildBirthdayAndDonem->d == 0)*/)) {
                                                if($diffSecondChildBirthdayAndDonem->invert) $doSecondChildGain = TRUE;
                                                $hasSecondChildBorn = TRUE;
                                            }

                                            // Dönem hesabı@@@
                                            if ($key == "0") {
                                                $dateNew =  date("d.m.Y", strtotime($data['workstartdate'])) . " - " . $donem['ceil'];
                                                $diff = new DateDifference($data['workstartdate'], $donem['ceil']);
                                                $gun = $diff->days;
                                            } else if ($isLastKey) {
                                                if($hasMarried) {
                                                    $dateNew = date('d.m.Y', strtotime($marriedDate)) . " - " . date('d.m.Y', strtotime($data['workenddate']));
                                                    $diff = new DateDifference($marriedDate, $data['workenddate']);
                                                    $gun = $diff->days;
                                                } else if($hasFirstChildBorn) {
                                                    $dateNew = date('d.m.Y', strtotime($childers[0]['birthday'])) . " - " . date('d.m.Y', strtotime($data['workenddate']));
                                                    $diff = new DateDifference($childers[0]['birthday'], $data['workenddate']);
                                                    $gun = $diff->days;
                                                } else if($hasSecondChildBorn) {
                                                    $dateNew = date('d.m.Y', strtotime($childers[1]['birthday'])) . " - " . date('d.m.Y', strtotime($data['workenddate']));
                                                    $diff = new DateDifference($childers[1]['birthday'], $data['workenddate']);
                                                    $gun = $diff->days;
                                                } else {
                                                    $dateNew = ((substr($asgeriUcret[$key-1]['donemler'], -1) == 2) ? "01.01." . substr(($asgeriUcret[$key-1]['donemler']), 0, 4) : "01.07." . substr($asgeriUcret[$key-1]['donemler'], 0, 4)) . " - " . date("d.m.Y", strtotime($data['workenddate']));
                                                    $diff = new DateDifference((substr($asgeriUcret[$key-1]['donemler'], -1) == 2) ? "01.01." . substr(($asgeriUcret[$key-1]['donemler']), 0, 4) : "01.07." . substr($asgeriUcret[$key-1]['donemler'], 0, 4), $data['workenddate']);
                                                    $gun = $diff->days;
                                                }
                                                $sonGunluk = number_format($data['factor'] * $gunluk, 2);
                                                $sonAsgeriGun = number_format($gunluk, 2);
                                            } else {
                                                if($hasMarried) {
                                                    if($diffMarriedAndDonem->days == 0) {
                                                        if(substr($ucret['donemler'], -1) == 1) {
                                                            $dateNew = date('d.m.Y', $marriedDate) . " - " . ("01.07." . substr($ucret['donemler'], 0, 4));
                                                            $diff = new DateDifference(("01.07." . substr($ucret['donemler'], 0, 4)), date('d.m.Y', $marriedDate));
                                                        } else {
                                                            $dateNew = date('d.m.Y', $marriedDate) . " - " . ("01.01." . (substr($ucret['donemler'], 0, 4) + 1));
                                                            $diff = new DateDifference(("01.01." . (substr($ucret['donemler'], 0, 4) + 1)), date('d.m.Y', $marriedDate));
                                                        }
                                                        $gun = $diff->days;
                                                        $doWifeGain = TRUE;
                                                        $hasMarried = FALSE;
                                                    } else {
                                                        $dateNew = (substr($ucret['donemler'], -1) == 1 ? (("01.01." . substr($ucret['donemler'], 0, 4)) . " - " . date('d.m.Y', $marriedDate)) : (date('d.m.Y', $marriedDate) . " - " . ("01.07." . substr($ucret['donemler'], 0, 4))));
                                                        $gun = $diffMarriedAndDonem->days;
                                                    }
                                                } else if($hasFirstChildBorn) {
                                                    if($diffFirstChildBirthdayAndDonem->days == 0) {
                                                        if(substr($ucret['donemler'], -1) == 1) {
                                                            $dateNew = date('d.m.Y', strtotime($childers[0]['birthday'])) . " - " . ("01.07." . substr($ucret['donemler'], 0, 4));
                                                            $diff = new DateDifference(("01.07." . substr($ucret['donemler'], 0, 4)), date('d.m.Y', strtotime($childers[0]['birthday'])));
                                                        } else {
                                                            $dateNew = date('d.m.Y', strtotime($childers[0]['birthday'])) . " - " . ("01.01." . (substr($ucret['donemler'], 0, 4) + 1));
                                                            $diff = new DateDifference(("01.01." . (substr($ucret['donemler'], 0, 4) + 1)), date('d.m.Y', strtotime($childers[0]['birthday'])));
                                                        }
                                                        $gun = $diff->days;
                                                        $doFirstChildGain = TRUE;
                                                        $hasFirstChildBorn = FALSE;
                                                    } else {
                                                        $dateNew = (substr($ucret['donemler'], -1) == 1 ? (("01.01." . substr($ucret['donemler'], 0, 4)) . " - " . date('d.m.Y', strtotime($childers[0]['birthday']))) : (date('d.m.Y', strtotime($childers[0]['birthday'])) . " - " . ("01.07." . substr($ucret['donemler'], 0, 4))));
                                                        $gun = $diffFirstChildBirthdayAndDonem->days;
                                                    }
                                                } else if($hasSecondChildBorn) {
                                                    if($diffSecondChildBirthdayAndDonem->days == 0) {
                                                        if(substr($ucret['donemler'], -1) == 1) {
                                                            $dateNew = date('d.m.Y', strtotime($childers[1]['birthday'])) . " - " . ("01.07." . substr($ucret['donemler'], 0, 4));
                                                            $diff = new DateDifference(("01.07." . substr($ucret['donemler'], 0, 4)), date('d.m.Y', strtotime($childers[1]['birthday'])));
                                                        } else {
                                                            $dateNew = date('d.m.Y', strtotime($childers[1]['birthday'])) . " - " . ("01.01." . (substr($ucret['donemler'], 0, 4) + 1));
                                                            $diff = new DateDifference(("01.01." . (substr($ucret['donemler'], 0, 4) + 1)), date('d.m.Y', strtotime($childers[1]['birthday'])));
                                                        }
                                                        $gun = $diff->days;
                                                        $doSecondChildGain = TRUE;
                                                        $hasSecondChildBorn = FALSE;
                                                    } else {
                                                        $dateNew = (substr($ucret['donemler'], -1) == 1 ? (("01.01." . substr($ucret['donemler'], 0, 4)) . " - " . date('d.m.Y', strtotime($childers[1]['birthday']))) : (date('d.m.Y', strtotime($childers[1]['birthday'])) . " - " . ("01.07." . substr($ucret['donemler'], 0, 4))));
                                                        $gun = $diffSecondChildBirthdayAndDonem->days;
                                                    }
                                                } else { 
                                                    $dateNew = ((substr($asgeriUcret[$key - 1]['donemler'], -1) == 2) ? ("01.01." . (substr($asgeriUcret[$key - 1]['donemler'], 0, 4) + 1)) : ("01.07." . substr($asgeriUcret[$key - 1]['donemler'], 0, 4))) . " - " . ((substr($ucret['donemler'], -1) == 2) ? ("01.01." . (substr(($ucret['donemler']), 0, 4) + 1)) : ("01.07." . substr($ucret['donemler'], 0, 4)));
                                                    $gun = (6 * 30);
                                                }
                                            }
                                            
                                            // Ondalıklı kısım .5 veya .0 değilse, dönem süresinden çıkarmak için
                                            // $minus değişkeninde tut. Eğer .5 veya .0 ise $minus=0.5 şeklinde
                                            // tut. Daha sonra dönem süresinden çıkar.
                                            $minus = number_format($gun/360, 2);
                                            $islemisDonemPay -= $minus;

                                            // Desteğin .5 ya da .xx dönemlik ücreti
                                            $maas = numberReformat($ucret['gunluknet'], 2) * $gun * $data['factor'];
                                            $pay = 2 + ($doWifeGain ? 2 : 0) + ($dadMom[0]['name'] ? 1 : 0) + ($dadMom[1]['name'] ? 1 : 0) + ($doFirstChildGain ? 1 : 0) + ($doSecondChildGain ? 1 : 0);
                                            $maasPay = $maas / $pay;

                                            // Tazminat alıcılarının toplam değerlerine ekleme yap
                                            $destekTotal += 2 * $maasPay;
                                            if($doWifeGain) $spouse['total'] += 2 * $maasPay;
                                            if($doFirstChildGain) $childers[0]['total'] += $maasPay;
                                            if($doSecondChildGain) $childers[1]['total'] += $maasPay;
                                            if($dadMom[0]['name']) $dadMom[0]['total'] += $maasPay;
                                            if($dadMom[1]['name']) $dadMom[1]['total'] += $maasPay;
                                            ?>
                                            <tr>
                                                <td><?= $dateNew . ": " . $gun ?></td>
                                                <td><?= $now ?> Yıl</td>
                                                <td><?= reformatter(2 * $maasPay) ?> TL</td>
                                                <td><?= $doWifeGain ? reformatter(2 * $maasPay) . " TL" : "-" ?></td>
                                                <?php
                                                    for($i=0; $i < count($childers); $i++):    
                                                ?>
                                                    <td scope="col">
                                                        <?php
                                                            if($i == 0) { echo $doFirstChildGain ? reformatter($maasPay) . " TL" : "-"; }
                                                            else { echo $doSecondChildGain ? reformatter($maasPay) . " TL" : "-"; }
                                                        ?>
                                                    </td>
                                                <?php
                                                    endfor;
                                                ?>
                                                <td><?= $dadMom[0]['name'] ? (reformatter($maasPay) . " TL") : "-" ?></td>
                                                <td><?= $dadMom[1]['name'] ? (reformatter($maasPay) . " TL") : "-" ?></td>
                                                <td><?= $pay ?></td>
                                            </tr>
                                            <?php
                                            if($doWifeGain && $hasMarried && !$isLastKey):
                                                $now = number_format($islemisDonemPay, 2);
                                                $dateNew = (substr($ucret['donemler'], -1) == 1 ? ("01.01." . substr($ucret['donemler'], 0, 4) . " - " . "01.07." . substr($ucret['donemler'], 0, 4)) : ("01.07." . substr($ucret['donemler'], 0, 4) . " - " . "01.01." . (substr($ucret['donemler'], 0, 4) + 1)));
                                                $gun = 180;
                                                $minus = number_format($gun/360, 2);
                                                $islemisDonemPay -= $minus;

                                                $maas = numberReformat($ucret['gunluknet'], 2) * $gun * $data['factor'];
                                                $pay = 4 + ($dadMom[0]['name'] ? 1 : 0) + ($dadMom[1]['name'] ? 1 : 0) + ($doFirstChildGain ? 1 : 0) + ($doSecondChildGain ? 1 : 0);
                                                $maasPay = $maas / $pay;
                                                $hasMarried = FALSE;

                                                $destekTotal += 2 * $maasPay;
                                                if($doWifeGain): $spouse['total'] += 2 * $maasPay; endif;
                                                if($doFirstChildGain): $childers[0]['total'] += $maasPay; endif;
                                                if($doSecondChildGain): $childers[1]['total'] += $maasPay; endif;
                                                if($dadMom[0]['name']): $dadMom[0]['total'] += $maasPay; endif;
                                                if($dadMom[1]['name']):  $dadMom[1]['total'] += $maasPay; endif;
                                            elseif($doFirstChildGain && $hasFirstChildBorn && !$isLastKey):
                                                $now = number_format($islemisDonemPay, 2);
                                                $dateNew = substr($ucret['donemler'], -1) == 1 ? ("01.01." . substr($ucret['donemler'], 0, 4) . " - " . "01.07." . substr($ucret['donemler'], 0, 4)) : ("01.07." . substr($ucret['donemler'], 0, 4) . " - " . "01.01." . (substr($ucret['donemler'], 0, 4) + 1));
                                                $gun = 180;
                                                $minus = number_format($gun/360, 2);
                                                $islemisDonemPay -= $minus;

                                                $maas = numberReformat($ucret['gunluknet'], 2) * $gun * $data['factor'];
                                                $pay = 4 + ($dadMom[0]['name'] ? 1 : 0) + ($dadMom[1]['name'] ? 1 : 0) + ($doFirstChildGain ? 1 : 0) + ($doSecondChildGain ? 1 : 0);
                                                $maasPay = $maas / $pay;
                                                $hasFirstChildBorn = FALSE;

                                                $destekTotal += 2 * $maasPay;
                                                if($doWifeGain): $spouse['total'] += 2 * $maasPay; endif;
                                                if($doFirstChildGain): $childers[0]['total'] += $maasPay; endif;
                                                if($doSecondChildGain): $childers[1]['total'] += $maasPay; endif;
                                                if($dadMom[0]['name']): $dadMom[0]['total'] += $maasPay; endif;
                                                if($dadMom[1]['name']):  $dadMom[1]['total'] += $maasPay; endif;
                                            elseif($doSecondChildGain && $hasSecondChildBorn && !$isLastKey):
                                                $now = number_format($islemisDonemPay, 2);
                                                $dateNew = substr($ucret['donemler'], -1) == 1 ? ("01.01." . substr($ucret['donemler'], 0, 4) . " - " . "01.07." . substr($ucret['donemler'], 0, 4)) : ("01.07." . substr($ucret['donemler'], 0, 4) . " - " . "01.01." . (substr($ucret['donemler'], 0, 4) + 1));
                                                $gun = 180;
                                                $minus = number_format($gun/360, 2);
                                                $islemisDonemPay -= $minus;

                                                $maas = numberReformat($ucret['gunluknet'], 2) * $gun * $data['factor'];
                                                $pay = 4 + ($dadMom[0]['name'] ? 1 : 0) + ($dadMom[1]['name'] ? 1 : 0) + ($doFirstChildGain ? 1 : 0) + ($doSecondChildGain ? 1 : 0);
                                                $maasPay = $maas / $pay;
                                                $hasSecondChildBorn = FALSE;

                                                $destekTotal += 2 * $maasPay;
                                                if($doWifeGain): $spouse['total'] += 2 * $maasPay; endif;
                                                if($doFirstChildGain): $childers[0]['total'] += $maasPay; endif;
                                                if($doSecondChildGain): $childers[1]['total'] += $maasPay; endif;
                                                if($dadMom[0]['name']): $dadMom[0]['total'] += $maasPay; endif;
                                                if($dadMom[1]['name']):  $dadMom[1]['total'] += $maasPay; endif;
                                            ?>
                                                <tr>
                                                    <td><?= $dateNew . ": " . $gun ?></td>
                                                    <td><?= $now ?> Yıl</td>
                                                    <td><?= reformatter(2 * $maasPay) ?> TL</td>
                                                    <td><?= $doWifeGain ? reformatter(2 * $maasPay) . " TL" : "-" ?></td>
                                                    <?php
                                                        for($i=0; $i < count($childers); $i++):
                                                    ?>
                                                        <td scope="col">
                                                            <?php
                                                                if($i == 0) { echo $doFirstChildGain ? reformatter($maasPay) . " TL" : "-"; }
                                                                else { echo $doSecondChildGain ? reformatter($maasPay) . " TL" : "-"; }
                                                            ?>
                                                        </td>
                                                    <?php
                                                        endfor;
                                                    ?>
                                                    <td><?= $dadMom[0]['name'] ? (reformatter($maasPay) . " TL") : "-" ?></td>
                                                    <td><?= $dadMom[1]['name'] ? (reformatter($maasPay) . " TL") : "-" ?></td>
                                                    <td><?= $pay ?></td>
                                                </tr>
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-muted text-center">

                                <b>
                                    DESTEK : <?= reformatter($destekTotal) ?> TL 
                                    | EŞ : <?= $spouse['name'] ? (reformatter($spouse['total']) . " TL") : "-" ?>
                                    <?php for ($i = 0; $i < count($childers); $i++): ?>
                                        | <?= ($i+1) ?>. ÇOCUK : <?= $childers[$i]['name'] ? (reformatter($childers[$i]['total']) . " TL") : "-" ?>
                                    <?php endfor; ?>
                                    | ANNE
                                    : <?= $dadMom[0]['name'] ? (reformatter($dadMom[0]['total']) . " TL") : "-" ?> 
                                    | BABA
                                    : <?= $dadMom[1]['name'] ? (reformatter($dadMom[1]['total']) . " TL") : "-" ?>
                                </b>
                            </div>
                        </div>
                    </div>
                    <?php if($aktifIslemisDonem): ?>
                        <div class="tab-pane fade py-2" id="nav-adp" role="tabpanel" aria-labelledby="nav-adp-tab">
                            <div class="card">
                                <div class="card-header text-center">
                                    AKTİF DÖNEM (<?= date("d.m.Y", strtotime($data['workenddate'])) ?>
                                    - <?= date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workenddate']))) ?>
                                    ARASI) PAYLAŞTIRMA
                                </div>
                                <div class="card-body">
                                    <p style="text-align: center;"><b>AKTİF DÖNEM KAZANCI : <?= reformatter($yillikGiren) ?>
                                            TL</b>
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
                                                <?php
                                                    for($i=0; $i < count($childers); $i++):    
                                                ?>
                                                    <th scope="col"><?=($i+1) ?>. ÇOCUK</th>
                                                <?php
                                                    endfor;
                                                ?>
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
                                            $KenPay = 0;
                                            $esPay = 0;
                                            $babaPay = 0;
                                            $annePay = 0;
                                            $cocukPay = 0;
                                            $childPay = [];
                                            $old = $ageofWorker->y;

                                            $lastYear = $data['workenddate'];
                                            for ($ii = 0; $ii < ($isciBakiye[0] + 1); $ii++):
                                                $payMinusEk = 0;

                                                $pay = 2 + (($marriedKey != 0) ? 2 : 0);
                                                $totalTazChild = 0;
                                                $payMinus = 0;

                                                if ($isciBakiyeMom - $ii > 0 || $isciBakiyeDad - $ii > 0) {
                                                    $pay += 2;
                                                } else {

                                                    $payMinusEk += 1;
                                                }


                                                if (count($childers) == 0 && $marriedKey != 0) {
                                                    if ($marriedKey + 2 <= $ii) {
                                                        $childers[] = ["first Child"];
                                                    }
                                                } else if (count($childers) == 1 && $marriedKey != 0) {
                                                    if (($marriedKey + 4) <= $ii) {
                                                        array_push($childers, "second Child");
                                                    }
                                                }


                                                if ($marriedKey != 0) {

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

                                                        if ($marriedKey + 20 > $ii && $marriedKey + 2 <= $ii) {
                                                            $pay += 1;
                                                            $payMinus += 1;
                                                            $childPay[0] += (($sonGunluk / $pay) * 360);
                                                        }

                                                        if (($marriedKey + 22 > $ii) && ($marriedKey + 4 <= $ii)) {
                                                            $pay += 1;
                                                            $payMinus += 1;
                                                            $childPay[1] += (($sonGunluk / $pay) * 360);
                                                        }
                                                    }

                                                }

                                                if (
                                                    ($data['gender'] == "men" && $ageofWorker->y < 27 && 0 == ((27 - ($ageofWorker->y + $ii))))
                                                    || ($data['gender'] == "men" && $ageofWorker->y > 27 && $ii >= 2)
                                                    || ($data['gender'] == "women" && $ageofWorker->y < 24 && $ii >= ((23 - $ageofWorker->y))
                                                        || ($data['gender'] == "women" && $ageofWorker->y > 24 && $ii >= 4))) {

                                                    $marriedKey = $ii;
                                                    $pay += 2;
                                                }

                                                $maas = $sonGunluk * 30;
                                                $lastPay = $maas / $pay;

                                                if ($marriedKey != 0) {
                                                    $KenPay += ($lastPay * 2) * 12;
                                                    $esPay += ($lastPay * 2) * 12;
                                                } else {
                                                    $KenPay += ($lastPay * 2) * 12;
                                                }

                                                $annebabaPay += ($lastPay * 2) * 12;


                                                if (($isciBakiyeDad - $ii) > 0) {
                                                    $personPayDad = ($dadMom[1]['name']) ? ((!$dadMom[0]['name']) ? ($lastPay * 2) * 12 : ($lastPay) * 12) : 0;
                                                } else {
                                                    $personPayDad = 0;
                                                }

                                                if (($isciBakiyeMom - $ii) > 0) {
                                                    $personPayMom = ($dadMom[0]['name']) ? (!$dadMom[1]['name']) ? ($lastPay * 2) * 12 : ($lastPay) * 12 : 0;
                                                } else {
                                                    $personPayMom = 0;
                                                }

                                                if ($isciBakiyeMom - $ii < 0) {
                                                    $personPayDad = $personPayDad * 2;
                                                    $payMinusEk -= 1;
                                                }


                                                if ($isciBakiyeDad - $ii < 0) {
                                                    $personPayMom *= 2;
                                                    $payMinusEk -= 1;
                                                }

                                                $annePay += $personPayMom;
                                                $babaPay += $personPayDad;

                                                ?>
                                                <tr>
                                                    <td><?= $data['namesurname'] ?></td>
                                                    <td><?= $old ?></td>
                                                    <td><?= reformatter(($lastPay * 2) * 12) ?> TL</td>
                                                    <td><?= "-" ?></td>
                                                    <td><?= "-" ?></td>
                                                    <td><?= ($marriedKey != 0) ? reformatter(($lastPay * 2) * 12) : 0 ?> TL</td>
                                                    <?php
                                                        for($j=0; $j < count($childers); $j++):   
                                                            if(!$childers[$j]['name']) break;
                                                            $ageofChild = date_diff(date_create($childers[$j]['birthday']), date_create(date("01-01-" . ($yil + $i))));
                                                            $ageofChild->y += 60 - $ageofWorker->y + $i;
                                                    ?>
                                                        <td scope="col"><?= $childers[$j]['name'] ?> - <?= $ageofChild->y ?> - 0TL</td>
                                                        <td scope="col">0TL</td>
                                                        <td><?= reformatter($payChild) ?> TL</td>
                                                    <?php
                                                        endfor;
                                                    ?>
                                                    <td><?= ($dadMom[0]['name']) ? $dadMom[0]['name'] : "Ölü" ?></td>
                                                    <td><?= ($dadMom[0]['name']) ? $ageofMom->y + $ii : "0" ?></td>
                                                    <td><?= reformatter($personPayMom); ?> TL</td>
                                                    <td><?= ($dadMom[1]['name']) ? $dadMom[1]['name'] : "Ölü" ?></td>
                                                    <td><?= ($dadMom[1]['name']) ? $ageofDad->y + $ii : "0" ?></td>
                                                    <td><?= reformatter($personPayDad); ?> TL</td>
                                                    <td><?= $pay ?>
                                                        - <?= (($pay - $payMinus) / 2 + 1) + ($payMinus + $payMinusEk) ?></td>

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
                                <b>
                                    DESTEK : <?= reformatter($KenPay) ?> TL 
                                    | EŞ : <?= reformatter($esPay) ?> TL 
                                    <? for($i=0; $i < count($childers); $i++): ?> | <?= $i+1 ?>. ÇOCUK : <?= reformatter($cocukPay/count($childers)) ?> TL <?php endfor; ?>
                                    | ANNE : <?= reformatter($annePay); ?> TL 
                                    | BABA : <?= reformatter($babaPay) ?> TL
                                </b>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="tab-pane fade py-2" id="nav-pdp" role="tabpanel" aria-labelledby="nav-adp-pdp">
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
                                        <?php
                                            for($j=0; $j < count($childers); $j++):    
                                        ?>
                                            <th scope="col"><?=($j+1) ?>. ÇOCUK</th>
                                            <th scope="col"><?=($j+1) ?>. Ç. KLN</th>
                                            <th scope="col"><?=($j+1) ?>. Ç. TZM</th>
                                        <?php
                                            endfor;
                                        ?>
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

                                    $ex = explode('.', $pasifOmur1);
                                    if ($ex[1] != 00) {
                                        $day = 1 - (1 - ($ex[1] / 100));
                                        $pasifOmur1 -= $ex[1] / 100;
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
                        <div class="text-center"><b>PASİF DÖNEM KAZANCI : <?= reformatter($totalPasifPay) ?> TL</b>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <br>
        </div>
    </div>
</div>