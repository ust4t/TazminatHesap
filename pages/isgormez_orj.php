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
                                <th scope="col">HESAP TİPİ</th>
                                <th scope="col">İŞ GÖREMEZ ORANI</th>
                                <th scope="col">İŞ GÖREMEZ SÜRESİ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= $data['namesurname'] ?></td>
                                <td>% <?= $data['rate'] ?></td>
                                <td><?= $data['netpay'] ?> TL</td>
                                <td><?= ucfirst($data['type']) ?></td>
                                <td><?= '%' . $data['jobrate'] ?></td>
                                <td><?= $data['doesworktime'] . ' Gün' ?></td>
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
                                <th scope="col">AKTİF İŞL. D.</th>
                                <th scope="col">PASİF İŞL. D.</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= date("d.m.Y", strtotime($data['workstartdate'])) ?></td>
                                <td><?= date("d.m.Y", strtotime($data['birthday'])) ?></td>
                                <td><?= $ageofWorker->y ?> YIL <?= $ageofWorker->m ?> AY</td>
                                <td><?= $isciBakiye[0] ?> YIL <?= (floor((($isciBakiye[1] / 100) * 360) / 30)) ?> AY</td>
                                <td><?= $aktifid->y ?> YIL <?= $aktifid->m ?> AY</td>
                                <td><?= $aktifIslemisDonem->y ?> YIL <?= $aktifIslemisDonem->m ?> AY</td>
                                <td><?= $pasifTotalisci->y ?> YIL <?= $pasifTotalisci->m ?> AY</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card text-center mt-5">
                <div class="card-header">
                    GEÇİCİ İŞ GÖREMEZLİK DÖNEMİ TABLOSU
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">

                        <tr>
                            <td>DÖNEMLER</td>
                            <td>BRÜT ÜCRET</td>
                            <td>NET ÜCRET</td>
                            <td>KAT SAYI</td>
                            <td>TUTAR</td>
                            <td>GÜN</td>
                        </tr>
                        <?php
                        $total = 0;
                        $totalWork = 0;


                        foreach ($isgoremezasgari as $key => $ucret):
                            $gunluk = numberReformat($ucret['gunluknet'], 2);
                            if ($key == "0") {
                                $ay = ((substr($ucret['donemler'], -1) == 2) ? "12" : "7");
                                $date = date("d.m.Y", strtotime($data['workstartdate']));
                                $gun = abs((date("m", strtotime($data['workstartdate'])) - $ay) * 30) + (30 - date("d", strtotime($data['workstartdate'])));
                            } else if ($key == key(array_slice($isgoremezasgari, -1, 1, true))) {
                                $date = date("d.m.Y", strtotime("+{$data['doesworktime']} days" . $data['workstartdate']));
                                $gun = ((date("m", strtotime($date)) - 1) * 30) + (date("d", strtotime($date)));
                                $sonGunluk = number_format($data['factor'] * $gunluk, 2);
                                $sonAsgeriGun = number_format($gunluk, 2);
                            } else {
                                $date = ((substr($isgoremezasgari[$key - 1]['donemler'], -1) == 2) ? "01.01." . (substr($isgoremezasgari[$key - 1]['donemler'], 0, 4) + 1) : "01.07." . substr($isgoremezasgari[$key - 1]['donemler'], 0, 4));
                                $gun = (6 * 30);
                            }
                            if ($key == key(array_slice($isgoremezasgari, -1, 1, true))) {
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
                                <td><?= number_format($data['factor'], 2, ",", ".") ?></td>
                                <td><?= number_format($data['factor'] * $maas, 2, ",", ".") ?> TL</td>
                                <td><?= $gun ?></td>
                            </tr>

                        <?php endforeach; ?>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOPLAM :</td>
                            <td><?= reformatter($geciciisgoremez = $totalWork) ?> TL</td>
                            <td></td>
                        </tr>

                    </table>
                </div>
                <div class="card-footer text-muted">
                    Bu dönemde mağdur %100 iş göremez sayılmıştır.
                </div>
            </div>

            <br>
            <hr>
            <br>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                            type="button" role="tab" aria-controls="nav-home" aria-selected="true">İŞLEMİŞ DÖNEM HESABI
                    </button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                            type="button" role="tab" aria-controls="nav-profile" aria-selected="false">AKTİF DÖNEM
                        KAZANÇ TABLOSU
                    </button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                            type="button" role="tab" aria-controls="nav-contact" aria-selected="false">PASİF DÖNEM
                        KAZANÇ TABLOSU
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card text-center">
                        <div class="card-header">
                            İŞLEMİŞ DÖNEM HESABI
                        </div>
                        <div class="card-body">
                            <div class="table-wrapper">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><?= date("d.m.Y", strtotime("+{$data['doesworktime']} days" . $data['workstartdate'])) ?>
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

                                    foreach ($asgariUcret as $key => $ucret) :
                                        $gunluk = numberReformat($ucret['gunluknet'], 2);
                                        if ($key == "0") {
                                            $ay = ((substr($ucret['donemler'], -1) == 2) ? "12" : "7");
                                            $date = date("d.m.Y", strtotime("+{$data['doesworktime']} days" . $data['workstartdate']));
                                            $gun = abs((date("m", $date) - $ay) * 30) + (30 - date("d", $date));
                                        } else if ($key == key(array_slice($asgariUcret, -1, 1, true))) {
                                            $date = date("d.m.Y", strtotime($data['workenddate']));
                                            $gun = (6 * 30);
                                            $sonGunluk = number_format($data['factor'] * $gunluk, 2);
                                            $sonAsgeriGun = number_format($gunluk, 2);
                                        } else {
                                            $date = ((substr($asgariUcret[$key - 1]['donemler'], -1) == 2) ? "01.01." . (substr($asgariUcret[$key - 1]['donemler'], 0, 4) + 1) : "01.07." . substr($asgariUcret[$key - 1]['donemler'], 0, 4));
                                            $gun = (6 * 30);
                                        }

                                        if ($key == key(array_slice($asgariUcret, -1, 1, true))) {
                                            $tarihbol = explode(".", $date);
                                            $sene = $tarihbol[2];
                                            $dateNew = "01.07." . $sene . " - " . $date;
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
                                        KAZANCI : <b><?= reformatter($islemisdönemkazanc = $totalWork) ?> TL</b>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                                    for ($i = 0; $i < ($isciBakiye[0] + 1); $i++) :
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

                                        ?>
                                        <tr>
                                            <td><?= number_format(($omur - $i), 2, ",", ".") ?></td>
                                            <td><?= number_format((360 * $days)); ?></td>
                                            <td><?= $yil + $i ?></td>
                                            <td><?= number_format($old, 2, ",", "."); ?></td>
                                            <td><?= number_format($sonGunluk, 2, ",", ".") ?></td>
                                            <td><?= number_format(30 * $sonGunluk, 2, ",", "."); ?></td>
                                            <td><?= number_format($data['factor'], 2, ",", ".") ?></td>
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
                                        AKTİF DÖNEM TOPLAM KAZANCI : <b><?= reformatter($aktifdönemkazanc = $yillikGiren) ?>
                                            TL</b>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
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
                                    for ($i = 0; $i < ($pasifTotalisci->y + 1); $i++) :

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
                                        PASİF DÖNEM TOPLAM KAZANCI : <b><?= reformatter($pasifdonemkazancı = $totalPasif) ?>
                                            TL</b>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
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
                    SONUÇ TABLOSU
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>İŞ DNM. KAZANCI</td>
                            <td>AKT. DNM. KAZANCI</td>
                            <td>PAS. DNM. KAZANCI</td>
                            <td>DNM. KAZ. TOPLAMI</td>
                        </tr>
                        <tr>
                            <td><?= reformatter($islemisdönemkazanc) ?> TL</td>
                            <td><?= reformatter($aktifdönemkazanc) ?> TL</td>
                            <td><?= reformatter($pasifdonemkazancı) ?> TL</td>
                            <td><?= reformatter($islemisdönemkazanc + $aktifdönemkazanc + $pasifdonemkazancı) ?> TL</td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>MALULİYET ORANI</td>
                            <td>MALULİYET ORANTILI TAZM.</td>
                            <td>KUSUR ORANI</td>
                            <td>KUSUR SONRASI TAZM. TUTARI</td>
                        </tr>
                        <tr>
                            <td>%<?= $data['jobrate'] ?></td>
                            <td><?= reformatter((($islemisdönemkazanc + $aktifdönemkazanc + $pasifdonemkazancı) / 100) * 45) ?>
                                TL
                            </td>
                            <td>% <?= $data['rate'] ?></td>
                            <td><?= reformatter(($islemisdönemkazanc + $aktifdönemkazanc + $pasifdonemkazancı - ((($islemisdönemkazanc + $aktifdönemkazanc + $pasifdonemkazancı) / 100) * 10))); ?>
                                TL
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>GEÇİCİ İŞ GÖREMEZLİK KAZANCI</td>
                            <td>KUSUR ORANI</td>
                            <td>GİG TAZMİNATI</td>
                            <td>NET TAZMİNAT</td>
                        </tr>
                        <tr>
                            <td><?= reformatter($geciciisgoremez) ?> TL</td>
                            <td>% <?= $data['rate'] ?></td>
                            <td><?= reformatter(($data['gig']) ? $data['gig'] : 0) ?> TL</td>
                            <td><?= reformatter(($islemisdönemkazanc + $aktifdönemkazanc + $pasifdonemkazancı - ((($islemisdönemkazanc + $aktifdönemkazanc + $pasifdonemkazancı) / 100) * 10)) + $data['gig']); ?>
                                TL
                            </td>
                        </tr>
                    </table>
                    <div class="card-footer text-muted">
                        Bu dönemde davacı %100 malûl kabul edilir.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>