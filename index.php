<?php
require __DIR__ . "/inc/DB.php";
require __DIR__ . "/inc/database.php";
require __DIR__ . "/inc/helpers.php";

if (empty($_SESSION[md5("email")]) && htmlspecialchars($_GET['url']) !== "login") {
    header("location:" . $siteUrl . "login");
}
if (!empty($_SESSION[md5("email")])) {
    $user = $db->from("admins")->where("email", $_SESSION[md5("email")])->first();
}
?>
<!doctype html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">


    <title>İşçi Bilgi Formu</title>
</head>

<body>
<?php if (!empty($_SESSION[md5("email")])) : require __DIR__ . "/pages/static/nav-bar.php";
endif; ?>

<?php
switch (htmlspecialchars($_GET['url'])):
    case "":
        require __DIR__ . "/pages/homepage.php";
        break;
    case "tazminat/destekten-yolsun-kalma":
        require __DIR__ . "/pages/destekten-yoksun-kalma-tazminati.php";
        break;
    case 'tazminat/pmf-1931':
        require_once __DIR__ . '/pages/pmf-1931.php';
        break;
    case 'tazminat/is-gormez':
        require_once __DIR__ . '/pages/is-gormez.php';
        break;
    case 'tazminat/is-gormez-1-8':
        require_once __DIR__ . '/pages/is-gormez-1-8.php';
        break;
    case 'tazminat/is-gormez/list':
        require_once __DIR__ . '/pages/is-gormez-list.php';
        break;
    case 'tazminat/is-gormez-1-8/list':
        require_once __DIR__ . '/pages/is-gormez-list-1-8.php';
        break;
    case "login":
        require __DIR__ . "/pages/login.php";
        break;
    case "logout":
        unset($_SESSION[md5("email")]);
        header("location:" . $siteUrl . "login");
        break;
    case "tazminat/destekten-yolsun-kalma/list":
        require __DIR__ . "/pages/destekten-yoksun-kalma-tazminati-list.php";
        break;
    case 'tazminat/pmf-1931/list':
        require __DIR__ . "/pages/pmf-1931-list.php";
        break;
    case "tazminat/destekten-yolsun-kalma/edit":
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("workers")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");
        require __DIR__ . "/pages/dykt-edit.php";
        break;
    case "tazminat/is-gormez/edit":
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("doeswork")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");
        require __DIR__ . "/pages/doeswork-edit.php";
        break;
    case "tazminat/is-gormez-1-8/edit":
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("doeswork")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");
        require __DIR__ . "/pages/doeswork-edit.php";
        break;
    case "dokum":
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("workers")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");

        $hesapFark = date_diff(date_create($data['workstartdate']), date_create($data['workenddate']));

        $ageofWorker = date_diff(date_create($data['birthday']), date_create($data['workstartdate']));

        $aktifid = date_diff(date_create($data['workenddate']), date_create($data['workstartdate']."-1 months"));

        $isciBakiye = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofWorker->y)->first()[($data['gender'] == "men") ? "erkek" : "kadin"]);
        $isciBakiye = explode(".", $isciBakiye);
        
        $aktifIslemisDonem = date_diff(date_create(date("y-m-d", strtotime($data['birthday'] . "+ 60 year"))), date_create($data['workenddate']));
        

        $pasifTotalİsci = date_diff(date_create(date("Y-m-d", strtotime("+ $isciBakiye[0] years " . (floor((($isciBakiye[1] / 100) * 360) / 30)) . " months", $data['workstartdate']))), date_create(date("Y-m-d", strtotime("+ " . $aktifIslemisDonem->y . " years " . $aktifIslemisDonem->m . " months ", $data['workstartdate']))));

        // Es Bilgisi
        $spouse = json_decode($data['spouse'], true);
        $ageofSpouse = date_diff(date_create($spouse['birthday']), date_create($data['workstartdate']));

        $spouseBakiye = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofSpouse->y)->first()[($data['gender'] == "men") ? "kadin" : "erkek"]);
        $spouseBakiye = explode(".", $spouseBakiye);

        $ageofSpouseH = date_diff(date_create($spouse['birthday']), date_create(date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", strtotime($data['workstartdate'])))));

        $spouseBakiyeH = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofSpouseH->y)->first()[($data['gender'] == "men") ? "kadin" : "erkek"]);

        $childers = json_decode($data['childs'], true);

        $dadMom = [
            [
                "prefix" => "ANNE",
                "name" => $data['momname'],
                "birthday" => $data["mombirdthday"],
                "gender" => "women"
            ],
            [
                "prefix" => "BABA",
                "name" => $data['dadname'],
                "birthday" => $data['dadbirdthday'],
                "gender" => "men"
            ]
        ];

        $ageofDad = date_diff(date_create($dadMom[1]['birthday']), date_create($data['workstartdate']));

        $ageofMom = date_diff(date_create($dadMom[0]['birthday']), date_create($data['workstartdate']));
        
        $agiorani = $db->from("agiler")->where("cocuk_sayi", $data['agisec'])->first()['yuzde'];
        $agicarpan= (1+($agiorani/100));
        
        $isciBakiyeDad = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofDad->y)->first()[($data['gender'] == "men") ? "erkek" : "kadin"]);

        $isciBakiyeMom = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofMom->y)->first()[($data['gender'] == "men") ? "erkek" : "kadin"]);

        //işlemiş dönem
        $asgeriUcret = $db->from("asgari_ucret")->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
            ->where("donemler", date("Y", strtotime($data['workenddate'])) . ((date("m", strtotime($data['workenddate'])) <= 6) ? 1 : 2), "<=")->all();

        $islemisDonemPay = number_format((($aktifid->y * 360 + $aktifid->m * 30 + $aktifid->d) / 360), 2, ".", ",");

        // Aktif Dönem
        $yil = date("Y", strtotime($data['workenddate']));
        $yas = $ageofWorker->y . "." . (360 / ($ageofWorker->d + ($ageofWorker->m * 30)));
        $omur = $isciBakiye[0] . "." . $isciBakiye[1];

        // Pasif Dönem
        $pasifOmur = number_format($pasifTotalİsci->y . ".00" + ((($pasifTotalİsci->m * 30) + $pasifTotalİsci->d) / 360), 2);
        $pasifOmur1 = number_format($pasifTotalİsci->y . ".00" + ((($pasifTotalİsci->m * 30) + $pasifTotalİsci->d) / 360), 2);


        require_once __DIR__ . "/pages/dokum.php";
        break;
    case "pmf":
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("pmf_workers")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");

        $ageofWorker = new DateDifference($data['birthday'], $data['workstartdate']);
        $aktifid = new DateDifference($data['workenddate'], $data['workstartdate']);
        $isciBakiye = $db->from("pmf_bakiyeomur")->where("yas", $ageofWorker->y)->first()['omurtablosu'];
        $isciBakiye = explode(".", $isciBakiye);

        
        
        $aktifIslemisDonem = new DateDifference(date("y-m-d", strtotime($data['birthday'] . "+ 60 year")), $data['workstartdate']);
        $aktifIslemisDonem->d -= $aktifid->d;
        if($aktifIslemisDonem->d < 0) { $aktifIslemisDonem->d += 30; $aktifIslemisDonem->m--; }
        $aktifIslemisDonem->m -= $aktifid->m;
        if($aktifIslemisDonem->m < 0) { $aktifIslemisDonem->m += 12; $aktifIslemisDonem->y--; }
        $aktifIslemisDonem->y -= $aktifid->y;
        if($aktifIslemisDonem->y < 0) { $aktifIslemisDonem = FALSE; }
        
        $pasifTotalİsci = new DateDifference(date("Y-m-d", strtotime("+ $isciBakiye[0] years " . (floor((($isciBakiye[1] / 100) * 360) / 30)) . " months " . $data['workstartdate'])), date("Y-m-d", strtotime("+ 60 years " . $data['birthday'])));
        
        // Es Bilgisi
        if ($data['marital'] == 'single'){
            $spouse = array(
                "name" => "Farazi Eş",
                "birthday" => $data['birthday']
            );
            $ageofSpouse = date_diff(date_create($spouse['birthday']), date_create($data['workstartdate']));
            $ageUntilMarried = date_diff(date_create($data['workstartdate']), date_create(date('Y-m-d', strtotime(($data['gender'] == 'men' ? '+ 27 years ' : '+ 25 years ') . $data['birthday']))));
            if($ageUntilMarried->invert) {
                $marriedDate = strtotime('+ 2 years ' . $data['workstartdate']);
            } else {
                $marriedDate = strtotime(($data['gender'] == 'men' ? '+ 27 years ' : '+ 25 years ') . $data['birthday']);
            }
            if($ageUntilMarried->invert) {
                // Erkekse yaşı 27'den büyüktür, kadınsa yaşı 25'ten büyüktürs
                $childers = array(
                    array(
                        "name" => "Farazi Çocuk (1)",
                        "birthday" => date('Y-m-d', strtotime('+ 4 years ' . $data['workstartdate'])),
                        "gender" => "men"
                    ),
                    array(
                        "name" => "Farazi Çocuk (2)",
                        "birthday" => date('Y-m-d', strtotime('+ 6 years ' . $data['workstartdate'])),
                        "gender" => "women"
                    )
                );
            } else {
                // Erkekse yaşı 27'den küçüktür, kadıns yaı 25'ten küçüktür
                if($data['gender'] == 'men') {
                    $childers = array(
                        array(
                            "name" => "Farazi Çocuk (1)",
                            "birthday" => date('Y-m-d', strtotime('+ 29 years ' . $data['birthday'])),
                            "gender" => "men"
                        ),
                        array(
                            "name" => "Farazi Çocuk (2)",
                            "birthday" => date('Y-m-d', strtotime('+ 31 years ' . $data['birthday'])),
                            "gender" => "women"
                        )
                    );
                } else {
                    $childers = array(
                        array(
                            "name" => "Farazi Çocuk (1)",
                            "birthday" => date('Y-m-d', strtotime('+ 27 years ' . $data['birthday'])),
                            "gender" => "men"
                        ),
                        array(
                            "name" => "Farazi Çocuk (2)",
                            "birthday" => date('Y-m-d', strtotime('+ 29 years ' . $data['birthday'])),
                            "gender" => "women"
                        )
                    );
                }
            }
        } else {
            $spouse = json_decode($data['spouse'], true);
            $ageofSpouse = new DateDifference($spouse['birthday'], $data['workstartdate']);
            $childers = json_decode($data['childs'], true);
        }

        $spouseBakiye = $db->from("pmf_bakiyeomur")->where("yas", $ageofSpouse->y)->first()['omurtablosu'];
        $spouseBakiye = explode(".", $spouseBakiye);
        $ageofSpouseH = new DateDifference($spouse['birthday'], date("d.m.Y", strtotime("+ $aktifIslemisDonem->y years $aktifIslemisDonem->m months $aktifIslemisDonem->d days", $data['workstartdate'])));
        $spouseBakiyeH = $db->from("pmf_bakiyeomur")->where("yas", $ageofSpouseH->y)->first()['omurtablosu'];

        $dadMom = [
            [
                "prefix" => "ANNE",
                "name" => $data['momname'],
                "birthday" => $data["mombirdthday"],
                "gender" => "women"
            ],
            [
                "prefix" => "BABA",
                "name" => $data['dadname'],
                "birthday" => $data['dadbirdthday'],
                "gender" => "men"
            ]
        ];

        $ageofDad = new DateDifference($dadMom[1]['birthday'], $data['workstartdate']);
        $ageofMom = new DateDifference($dadMom[0]['birthday'], $data['workstartdate']);

        $isciBakiyeDad = $db->from("pmf_bakiyeomur")->where("yas", $ageofDad->y)->first()['omurtablosu'];
        $isciBakiyeMom = $db->from("pmf_bakiyeomur")->where("yas", $ageofMom->y)->first()['omurtablosu'];

        // İşlemiş Dönem
        $asgeriUcret = $db->from("asgari_ucret")->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
            ->where("donemler", date("Y", strtotime($data['workenddate'])) . ((date("m", strtotime($data['workenddate'])) <= 6) ? 1 : 2), "<=")->all();

        $islemisDonemPay = number_format(($aktifid->days / 360), 2);

        // Aktif Dönem
        $yil = date("Y", strtotime($data['workenddate']));
        $yas = $ageofWorker->y . "." . (360 / ($ageofWorker->d + ($ageofWorker->m * 30)));
        $omur = $isciBakiye[0] . "." . $isciBakiye[1];

        // Pasif Dönem
        $pasifOmur = number_format($pasifTotalİsci->y . ".00" + ((($pasifTotalİsci->m * 30) + $pasifTotalİsci->d) / 360), 2);
        $pasifOmur1 = number_format($pasifTotalİsci->y . ".00" + ((($pasifTotalİsci->m * 30) + $pasifTotalİsci->d) / 360), 2);


        require_once __DIR__ . "/pages/pmf.php";
        break;
    case 'tazminat/pmf-1931/edit':
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("pmf_workers")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");
        require __DIR__ . "/pages/pmf-edit.php";
        break;
    case 'is-gormez':
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("doeswork")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");

        if ($data['type'] == 'trh') :

            $hesapFark = date_diff(date_create($data['workstartdate']), date_create($data['workenddate']));

            $ageofWorker = date_diff(date_create($data['birthday']), date_create($data['workstartdate']));

            $aktifid = date_diff(date_create(date('d-m-Y', strtotime("+{$data['doesworktime']} days " . $data['workstartdate']))), date_create($data['workenddate']));

            $isciBakiye = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofWorker->y)->first()[($data['gender'] == "men") ? "erkek" : "kadin"]);
            $isciBakiye = explode(".", $isciBakiye);

            $aktifIslemisDonem = date_diff(date_create(date("y-m-d", strtotime($data['birthday'] . "+ 60 year"))), date_create($data['workstartdate']));

            $pasifTotalisci = date_diff(date_create(date("Y-m-d", strtotime("+ $isciBakiye[0] years " . (floor((($isciBakiye[1] / 100) * 360) / 30)) . " months", strtotime($data['workstartdate'])))), date_create(date("Y-m-d", strtotime("+ " . $aktifIslemisDonem->y . " years " . $aktifIslemisDonem->m . " months ", strtotime($data['workstartdate'])))));

            //işlemiş dönem
            $asgariUcret = $db->from("asgari_ucret")->where("donemler", date("Y", strtotime("+{$data['doesworktime']} days " . $data['workstartdate'])) . ((date("m", strtotime("+{$data['doesworktime']} days " . $data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime($data['workenddate'])) . ((date("m", strtotime($data['workenddate'])) <= 6) ? 1 : 2), "<=")->all();


            $isgoremezasgari = $db->from("asgari_ucret")
                ->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) . ((date("m", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) <= 6) ? 1 : 2), "<=")
                ->all();


            $islemisDonemPay = number_format((($aktifid->y * 360 + $aktifid->m * 30 + $aktifid->d) / 360), 2, ".", ",");

            // Aktif Dönem
            $yil = date("Y", strtotime($data['workenddate']));
            $yas = $ageofWorker->y . "." . (360 / ($ageofWorker->d + ($ageofWorker->m * 30)));
            $omur = $isciBakiye[0] . "." . $isciBakiye[1];

            // Pasif Dönem
            $pasifOmur = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);
            $pasifOmur1 = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);

        else :
            $hesapFark = date_diff(date_create($data['workstartdate']), date_create($data['workenddate']));

            $ageofWorker = date_diff(date_create($data['birthday']), date_create($data['workstartdate']));

            $aktifid = date_diff(date_create($data['workenddate']), date_create($data['workstartdate']));

            $isciBakiye = $db->from("pmf_bakiyeomur")->where("yas", $ageofWorker->y)->first()['omurtablosu'];
            $isciBakiye = explode(".", $isciBakiye);

            $aktifIslemisDonem = date_diff(date_create(date("y-m-d", strtotime($data['birthday'] . "+ 60 year"))), date_create($data['workstartdate']));

            $pasifTotalisci = date_diff(date_create(date("Y-m-d", strtotime("+ $isciBakiye[0] years " . (floor((($isciBakiye[1] / 100) * 360) / 30)) . " months", strtotime($data['workstartdate'])))), date_create(date("Y-m-d", strtotime("+ " . $aktifIslemisDonem->y . " years " . $aktifIslemisDonem->m . " months ", strtotime($data['workstartdate'])))));

            //işlemiş dönem
            $asgariUcret = $db->from("asgari_ucret")->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime($data['workenddate'])) . ((date("m", strtotime($data['workenddate'])) <= 6) ? 1 : 2), "<=")->all();

            $isgoremezasgari = $db->from("asgari_ucret")
                ->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) . ((date("m", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) <= 6) ? 1 : 2), "<=")
                ->all();

            $islemisDonemPay = number_format((($aktifid->y * 360 + $aktifid->m * 30 + $aktifid->d) / 360), 2, ".", ",");

            // Aktif Dönem
            $yil = date("Y", strtotime($data['workenddate']));
            $yas = $ageofWorker->y . "." . (360 / ($ageofWorker->d + ($ageofWorker->m * 30)));
            $omur = $isciBakiye[0] . "." . $isciBakiye[1];

            // Pasif Dönem
            $pasifOmur = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);
            $pasifOmur1 = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);

        endif;
        require_once __DIR__ . "/pages/isgormez.php";
        break;
    case 'is-gormez-1-8':
        $id = htmlspecialchars($_GET['id']);
        $data = $db->from("doeswork")->where("id", $id)->first();
        if (!$data)
            header("location:" . $siteUrl . "");

        if ($data['type'] == 'trh') :

            $hesapFark = date_diff(date_create($data['workstartdate']), date_create($data['workenddate']));

            $ageofWorker = date_diff(date_create($data['birthday']), date_create($data['workstartdate']));

            $aktifid = date_diff(date_create(date('d-m-Y', strtotime("+{$data['doesworktime']} days " . $data['workstartdate']))), date_create($data['workenddate']));

            $isciBakiye = str_replace(",", ".", $db->from("bakiye_omur")->where("yas", $ageofWorker->y)->first()[($data['gender'] == "men") ? "erkek" : "kadin"]);
            $isciBakiye = explode(".", $isciBakiye);

            $aktifIslemisDonem = date_diff(date_create(date("y-m-d", strtotime($data['birthday'] . "+ 60 year"))), date_create($data['workstartdate']));

            $pasifTotalisci = date_diff(date_create(date("Y-m-d", strtotime("+ $isciBakiye[0] years " . (floor((($isciBakiye[1] / 100) * 360) / 30)) . " months", strtotime($data['workstartdate'])))), date_create(date("Y-m-d", strtotime("+ " . $aktifIslemisDonem->y . " years " . $aktifIslemisDonem->m . " months ", strtotime($data['workstartdate'])))));

            //işlemiş dönem
            $asgariUcret = $db->from("asgari_ucret")->where("donemler", date("Y", strtotime("+{$data['doesworktime']} days " . $data['workstartdate'])) . ((date("m", strtotime("+{$data['doesworktime']} days " . $data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime($data['workenddate'])) . ((date("m", strtotime($data['workenddate'])) <= 6) ? 1 : 2), "<=")->all();


            $isgoremezasgari = $db->from("asgari_ucret")
                ->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) . ((date("m", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) <= 6) ? 1 : 2), "<=")
                ->all();


            $islemisDonemPay = number_format((($aktifid->y * 360 + $aktifid->m * 30 + $aktifid->d) / 360), 2, ".", ",");

            // Aktif Dönem
            $yil = date("Y", strtotime($data['workenddate']));
            $yas = $ageofWorker->y . "." . (360 / ($ageofWorker->d + ($ageofWorker->m * 30)));
            $omur = $isciBakiye[0] . "." . $isciBakiye[1];

            // Pasif Dönem
            $pasifOmur = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);
            $pasifOmur1 = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);

        else :
            $hesapFark = date_diff(date_create($data['workstartdate']), date_create($data['workenddate']));

            $ageofWorker = date_diff(date_create($data['birthday']), date_create($data['workstartdate']));

            $aktifid = date_diff(date_create($data['workenddate']), date_create($data['workstartdate']));

            $isciBakiye = $db->from("pmf_bakiyeomur")->where("yas", $ageofWorker->y)->first()['omurtablosu'];
            $isciBakiye = explode(".", $isciBakiye);

            $aktifIslemisDonem = date_diff(date_create(date("y-m-d", strtotime($data['birthday'] . "+ 60 year"))), date_create($data['workstartdate']));

            $pasifTotalisci = date_diff(date_create(date("Y-m-d", strtotime("+ $isciBakiye[0] years " . (floor((($isciBakiye[1] / 100) * 360) / 30)) . " months", strtotime($data['workstartdate'])))), date_create(date("Y-m-d", strtotime("+ " . $aktifIslemisDonem->y . " years " . $aktifIslemisDonem->m . " months ", strtotime($data['workstartdate'])))));

            //işlemiş dönem
            $asgariUcret = $db->from("asgari_ucret")->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime($data['workenddate'])) . ((date("m", strtotime($data['workenddate'])) <= 6) ? 1 : 2), "<=")->all();

            $isgoremezasgari = $db->from("asgari_ucret")
                ->where("donemler", date("Y", strtotime($data['workstartdate'])) . ((date("m", strtotime($data['workstartdate'])) <= 6) ? 1 : 2), ">=")
                ->where("donemler", date("Y", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) . ((date("m", strtotime('+'. $data['doesworktime'] .' days '. $data['workstartdate'])) <= 6) ? 1 : 2), "<=")
                ->all();

            $islemisDonemPay = number_format((($aktifid->y * 360 + $aktifid->m * 30 + $aktifid->d) / 360), 2, ".", ",");

            // Aktif Dönem
            $yil = date("Y", strtotime($data['workenddate']));
            $yas = $ageofWorker->y . "." . (360 / ($ageofWorker->d + ($ageofWorker->m * 30)));
            $omur = $isciBakiye[0] . "." . $isciBakiye[1];

            // Pasif Dönem
            $pasifOmur = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);
            $pasifOmur1 = number_format($pasifTotalisci->y . ".00" + ((($pasifTotalisci->m * 30) + $pasifTotalisci->d) / 360), 2);

        endif;
        require_once __DIR__ . "/pages/isgormez-1-8.php";
        break;

    default:
        require __DIR__ . "/pages/static/404.php";
        break;


endswitch;
?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>
<script>
    function createResult(data) {
        Swal.fire({
            icon: data.type,
            text: data.text,
            confirmButtonText: "Tamam"
        });

        if (data.redirect == 1) {
            setInterval(() => {
                window.location.href = data.url;
            }, data.time);
        }
    }
</script>
<script>
    <?php
    switch (htmlspecialchars($_GET['url'])):
    case "":
    ?>
    $("button#create").on("click", () => {
        $.post("<?= $siteUrl ?>api.php", {
            type: "password",
            value: $("input").val()
        }, (result) => createResult(result), "json")
    });
    <?php
    break;
    case "tazminat/destekten-yolsun-kalma":
    ?>

    function remove(elem) {
        $(elem).parent().remove();
    }

    $("select#label6").on("change", () => {
        let value = $("#label6").val();
        $.post("<?= $siteUrl ?>post.php", {
            type: "marital",
            value: value
        }, (result) => $("#marital").html(result));

    });

    $("#submit-btn").on("click", (e) => {
        e.preventDefault();
        $.post("<?= $siteUrl ?>post.php", $("#form").serialize(), (result) => createResult(result), "json");
    });

    function addChild() {
        let childCount = $("#childs > div").length;
        if (childCount > 15) {
            alert("Maksimum çocuk ekleme sayısına ulaştınız!");
        } else {
            let blank_child = $("#child-blank").html(),
                countDiv = childCount;
            blank_child = blank_child.replace("childs[][name]", "childs[" + (countDiv) + "][name]")
            blank_child = blank_child.replace("childs[][gender]", "childs[" + (countDiv) + "][gender]")
            blank_child = blank_child.replace("childs[][birthday]", "childs[" + (countDiv) + "][birthday]")
            blank_child = blank_child.replace("childs[][uni]", "childs[" + (countDiv) + "][uni]")
            blank_child = blank_child.replace("childs[][uni]", "childs[" + (countDiv) + "][disabled]")

            $('#childs').append(blank_child);
        }
    }

    $("#asgari-ucret").on("click", function () {
        let date = $("input#label3").val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "getNet",
                "date": date
            }, function (result) {
                $("input#label16").val(result);
                $.post("<?= $siteUrl ?>post.php", {
                    "type": "calculateNet",
                    "net": result,
                    "date": date
                }, (result) => $("input#label18").val(result))
            });
        }
    });

    $("input#label16").on("keyup change", function () {
        let date = $("input#label3").val(),
            net = $(this).val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "calculateNet",
                "net": net,
                "date": date
            }, (result) => $("input#label18").val(result))

        }
    });
    <?php
    break;
    case "tazminat/pmf-1931":
    ?>

    function remove(elem) {
        $(elem).parent().remove();
    }

    $("select#label6").on("change", () => {
        let value = $("#label6").val();
        $.post("<?= $siteUrl ?>post.php", {
            type: "marital",
            value: value
        }, (result) => $("#marital").html(result));

    });

    $("#submit-btn").on("click", (e) => {
        e.preventDefault();
        $.post("<?= $siteUrl ?>post.php", $("#form").serialize(), (result) => createResult(result), "json");
    });

    function addChild() {
        let childCount = $("#childs > div").length;
        if (childCount > 15) {
            alert("Maksimum çocuk ekleme sayısına ulaştınız!");
        } else {
            let blank_child = $("#child-blank").html(),
                countDiv = childCount;
            blank_child = blank_child.replace("childs[][name]", "childs[" + (countDiv) + "][name]")
            blank_child = blank_child.replace("childs[][gender]", "childs[" + (countDiv) + "][gender]")
            blank_child = blank_child.replace("childs[][birthday]", "childs[" + (countDiv) + "][birthday]")
            blank_child = blank_child.replace("childs[][uni]", "childs[" + (countDiv) + "][uni]")
            blank_child = blank_child.replace("childs[][uni]", "childs[" + (countDiv) + "][disabled]")

            $('#childs').append(blank_child);
        }
    }

    $("#asgari-ucret").on("click", function () {
        let date = $("input#label3").val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "getNet",
                "date": date
            }, function (result) {
                $("input#label16").val(result);
                $.post("<?= $siteUrl ?>post.php", {
                    "type": "calculateNet",
                    "net": result,
                    "date": date
                }, (result) => $("input#label18").val(result))
            });
        }
    });

    $("input#label16").on("keyup change", function () {
        let date = $("input#label3").val(),
            net = $(this).val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "calculateNet",
                "net": net,
                "date": date
            }, (result) => $("input#label18").val(result))

        }
    });
    <?php
    break;
    case "login":
    ?>
    $("button[type='submit']").on("click", (e) => {
        e.preventDefault();
        let email = $("#floatingInput").val(),
            password = $("#floatingPassword").val();
        $.post("<?= $siteUrl ?>api.php", {
            "type": "login",
            "email": email,
            "password": password
        }, (result) => createResult(result), "json");
    });
    <?php
    break;
    case "tazminat/destekten-yolsun-kalma/list": ?>
    $(document).ready(function () {
        $('#example').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            }
        });
    });

    function deleteTazminat(id) {
        Swal.fire({
            title: 'Silmek istiyor musunuz?',
            showCancelButton: true,
            confirmButtonText: `Evet`
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= $siteUrl ?>api.php", {
                    "type": "delete",
                    "delete": "dykt",
                    "id": id
                }, (result) => createResult(result), "json")
            }
        })

    }
    <?php
    break;
    case "tazminat/pmf-1931/list": ?>
    $(document).ready(function () {
        $('#example').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            }
        });
    });

    function deleteTazminat(id) {
        Swal.fire({
            title: 'Silmek istiyor musunuz?',
            showCancelButton: true,
            confirmButtonText: `Evet`
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= $siteUrl ?>api.php", {
                    "type": "delete",
                    "delete": "pmf",
                    "id": id
                }, (result) => createResult(result), "json")
            }
        })

    }
    <?php
    break;
    case "tazminat/is-gormez/list": ?>
    $(document).ready(function () {
        $('#example').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            }
        });
    });

    function deleteDoesWork(id) {
        Swal.fire({
            title: 'Silmek istiyor musunuz?',
            showCancelButton: true,
            confirmButtonText: `Evet`
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("<?= $siteUrl ?>api.php", {
                    "type": "delete",
                    "delete": "doeswork",
                    "id": id
                }, (result) => createResult(result), "json")
            }
        })

    }
    <?php
    break;
    case "tazminat/destekten-yolsun-kalma/edit":
    ?>

    function remove(elem) {
        $(elem).parent().remove();
    }

    function addChild() {
        let childCount = $("#childs > div").length;
        if (childCount > 15) {
            alert("Maksimum çocuk ekleme sayısına ulaştınız!");
        } else {
            let blank_child = $("#child-blank").html(),
                countDiv = childCount;
            blank_child = blank_child.replace("childs[][name]", "childs[" + (countDiv) + "][name]")
            blank_child = blank_child.replace("childs[][gender]", "childs[" + (countDiv) + "][gender]")
            blank_child = blank_child.replace("childs[][birthday]", "childs[" + (countDiv) + "][birthday]")
            blank_child = blank_child.replace("childs[][uni]", "childs[" + (countDiv) + "][uni]")

            $('#childs').append(blank_child);
        }
    }

    $("input#label16").on("keyup change", function () {
        let date = $("input#label3").val(),
            net = $(this).val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "calculateNet",
                "net": net,
                "date": date
            }, (result) => $("input#label18").val(result))

        }
    });
    $("#submit-btn").on("click", (e) => {
        e.preventDefault();
        $.post("<?= $siteUrl ?>post.php?id=" + <?= $data['id'] ?>, $("#form").serialize(), (result) => createResult(result), "json");
    });
    <?php
    break;
    case "tazminat/pmf-1931/edit":
    ?>
    function remove(elem) {
        $(elem).parent().remove();
    }
 
    function addChild() {
        let childCount = $("#childs > div").length;
        if (childCount > 15) {
            alert("Maksimum çocuk ekleme sayısına ulaştınız!");
        } else {
            let blank_child = $("#child-blank").html(),
                countDiv = childCount;
            blank_child = blank_child.replace("childs[][name]", "childs[" + (countDiv) + "][name]")
            blank_child = blank_child.replace("childs[][gender]", "childs[" + (countDiv) + "][gender]")
            blank_child = blank_child.replace("childs[][birthday]", "childs[" + (countDiv) + "][birthday]")
            blank_child = blank_child.replace("childs[][uni]", "childs[" + (countDiv) + "][uni]")

            $('#childs').append(blank_child);
        }
    }

    $("input#label16").on("keyup change", function () {
        let date = $("input#label3").val(),
            net = $(this).val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "calculateNet",
                "net": net,
                "date": date
            }, (result) => $("input#label18").val(result))

        }
    });
    $("#submit-btn").on("click", (e) => {
        e.preventDefault();
        $.post("<?= $siteUrl ?>post.php", $("#form").serialize(), (result) => createResult(result), "json");
    });
    <?php
    break; case "tazminat/is-gormez/edit":?>

    $("#submit-btn").on("click", (e) => {
        e.preventDefault();
        $.post("<?= $siteUrl ?>post.php", $("#form").serialize(), (result) => createResult(result), "json");
    });


    $("#asgari-ucret").on("click", function () {
        let date = $("input#label3").val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "getNet",
                "date": date
            }, function (result) {
                $("input#label16").val(result);
                $.post("<?= $siteUrl ?>post.php", {
                    "type": "calculateNet",
                    "net": result,
                    "date": date
                }, (result) => $("input#label18").val(result))
            });
        }
    });
    <?php
    break;
    case  'tazminat/is-gormez': ?>

    $("#submit-btn").on("click", (e) => {
        e.preventDefault();
        $.post("<?= $siteUrl ?>post.php", $("#form").serialize(), (result) => createResult(result), "json");
    });

    $("#asgari-ucret").on("click", function () {
        let date = $("input#label3").val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "getNet",
                "date": date
            }, function (result) {
                $("input#label16").val(result);
                $.post("<?= $siteUrl ?>post.php", {
                    "type": "calculateNet",
                    "net": result,
                    "date": date
                }, (result) => $("input#label18").val(result))
            });
        }
    });

    $("input#label16").on("keyup change", function () {
        let date = $("input#label3").val(),
            net = $(this).val();
        if (!date) {
            alert("Olay tarihi boş bırakılarak bu işlem yapılama!");
        } else {
            $.post("<?= $siteUrl ?>post.php", {
                "type": "calculateNet",
                "net": net,
                "date": date
            }, (result) => $("input#label18").val(result))

        }
    });
    <?php
    break;
    endswitch;
    ?>
</script>
</body>

</html>