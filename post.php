<?php

require __DIR__ . "/inc/DB.php";
require __DIR__ . "/inc/database.php";
require __DIR__ . "/inc/helpers.php";

setlocale(LC_MONETARY, 'tr_TR');
if ($_POST) {
    if ($_GET['id']) {
        $namesurname = post("namesurname");
        $birthday = post("birthday");
        $workstartdate = post("workstartdate");
        $workenddate = post("workenddate");
        $gender = post("gender");
        $marital = post("marital");
        $momname = post("momname");
        $mombirdthday = post("mombirdthday");
        $dadname = post("dadname");
        $dadbirdthday = post("dadbirdthday");
        $netpay = post("netpay");
        //$grosspay = post("grosspay");
        $grosspay = "123";
        $factor = post("factor");
        $agisec = post("agisec");
        $rate = post("rate");

        // married
        $spouse = @$_POST['spouse'];
        $childs = @$_POST['childs'];


        if (!$namesurname || !$birthday || !$workstartdate || !$workenddate || !$gender || !$marital || !$netpay || !$grosspay || !$factor) {
            $json['text'] = "Lütfen tüm alanları doldurunuz!";
            $json['type'] = "error";
        } else if ($marital == "married" && (!$spouse['name'] || !$spouse['birthday'])) {
            $json['text'] = "Lütfen tüm alanları doldurunuz!";
            $json['type'] = "error";
        } else {
            $tazminat = 0;

            $insert = $db->update("workers")->where("id", htmlspecialchars($_GET['id']))->set([
                "namesurname" => $namesurname,
                "birthday" => $birthday,
                "workstartdate" => $workstartdate,
                "workenddate" => $workenddate,
                "gender" => $gender,
                "marital" => $marital,
                "momname" => $momname,
                "mombirdthday" => $mombirdthday,
                "dadname" => $dadname,
                "dadbirdthday" => $dadbirdthday,
                "netpay" => $netpay,
                "grosspay" => $grosspay,
                "factor" => $factor,
                    "agisec" => $agisec,
                "rate" => $rate,
                "childs" => json_encode($childs),
                "spouse" => json_encode($spouse),
                "tazminat" => $tazminat
            ]);

            if ($insert) {
                $json['text'] = "Düzenleme Başarılı!";
                $json['type'] = "success";
            } else {
                $json['text'] = "Yazılımcıya ulaşın!";
                $json['type'] = "error";
            }


        }
        echo json_encode($json);
    } else {
        $type = post("type");
        if ($type == "marital") {
            $value = post("value");
            if ($value == "married") {
                ?>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="#label7" class="form-label">Eşinin adı : </label>
                            <input type="text" class="form-control" id="label7" name="spouse[name]"
                                   placeholder="Eşinizin adı">
                        </div>
                        <div class="col-md-6">
                            <label for="#label8" class="form-label">Eşinin doğum tarihi : </label>
                            <input type="date" class="form-control" id="label8" name="spouse[birthday]">
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo " ";
            }

        } else if ($type == "calculateNet") {
            $netMaas = post("net");
            $date = post("date");
            $strDate = strtotime($date);
            $mounth = date("m", $strDate);
            $year = date("Y", $strDate);
            $forrent = ($mounth <= 6) ? 1 : 2;
            $sqlWhere = $year . $forrent;

            $row = $db->from("asgari_ucret")->where("donemler", $sqlWhere)->first();
            $asgerinet = $row['asgariucretnet'];
            echo $netMaas / numberReformat($row['asgariucretnet'], 2);

        } else if ($type == "getNet") {
            $date = post("date");
            $strDate = strtotime($date);
            $mounth = date("m", $strDate);
            $year = date("Y", $strDate);
            $forrent = ($mounth <= 6) ? 1 : 2;
            $sqlWhere = $year . $forrent;
            $row = $db->from("asgari_ucret")->where("donemler", $sqlWhere)->first();
            $asgerinet = $row['asgariucretnet'];

            echo numberReformat($asgerinet, 2);
        } else if ($type == 'pmf-1931') {
            $namesurname = post("namesurname");
            $birthday = post("birthday");
            $workstartdate = post("workstartdate");
            $workenddate = post("workenddate");
            $gender = post("gender");
            $marital = post("marital");
            $momname = post("momname");
            $mombirdthday = post("mombirdthday");
            $dadname = post("dadname");
            $dadbirdthday = post("dadbirdthday");
            $netpay = post("netpay");
            //$grosspay = post("grosspay");
            $grosspay = "123";
            $factor = post("factor");
            $agisec = post("agisec");
            $rate = post("rate");

            // married
            $spouse = @$_POST['spouse'];
            $childs = @$_POST['childs'];


            if (!$namesurname || !$birthday || !$workstartdate || !$workenddate || !$gender || !$marital || !$netpay || !$grosspay || !$factor) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else if ($marital == "married" && (!$spouse['name'] || !$spouse['birthday'])) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else {
                $tazminat = 0;

                $insert = $db->insert('pmf_workers')->set([
                    "namesurname" => $namesurname,
                    "birthday" => $birthday,
                    "workstartdate" => $workstartdate,
                    "workenddate" => $workenddate,
                    "gender" => $gender,
                    "marital" => $marital,
                    "momname" => $momname,
                    "mombirdthday" => $mombirdthday,
                    "dadname" => $dadname,
                    "dadbirdthday" => $dadbirdthday,
                    "netpay" => $netpay,
                    "grosspay" => $grosspay,
                    "factor" => $factor,
                    "agisec" => $agisec,
                    "rate" => $rate,
                    "childs" => json_encode($childs),
                    "spouse" => json_encode($spouse),
                    "tazminat" => $tazminat
                ]);

                if ($insert) {
                    $json['text'] = "Ekeleme Başarılı!";
                    $json['url'] = "/pmf?id=" . $db->lastId();
                    $json['redirect'] = "1";
                    $json['time'] = "500";
                    $json['type'] = "success";
                } else {
                    $json['text'] = "Yazılımcıya ulaşın!";
                    $json['type'] = "error";
                }

            }
            echo json_encode($json);
        }else if ($type == 'does-not-work') {
            $namesurname = post('namesurname');
            $birthday = post('birthday');
            $workstartdate = post('workstartdate');
            $workenddate = post('workenddate');
            $gender = post('gender');
            $marital = post('marital');
            $netpay = post('netpay');
            $factor = post('factor');
                    $agisec = post('agisec');
            $rate = post('rate');
            $jobrate = post('jobrate');
            $formtype = post('formtype');
            $doesworktime = post('doesworktime');
            $gig = post('gig');

            if (!$namesurname || !$birthday || !$workstartdate || !$workenddate || !$gender || !$marital || !$netpay || !$factor) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else {
                $insert = $db->insert('doeswork')->set([
                    "namesurname" => $namesurname,
                    "birthday" => $birthday,
                    "workstartdate" => $workstartdate,
                    "workenddate" => $workenddate,
                    "gender" => $gender,
                    "marital" => $marital,
                    "doesworktime" => $doesworktime,
                    "netpay" => $netpay,
                    "factor" => $factor,
                    "agisec" => $agisec,
                    "rate" => $rate,
                    "type" => $formtype,
                    'jobrate' => $jobrate,
                    'gig' => $gig
                ]);

                if ($insert) {
                    $json['text'] = "Ekeleme Başarılı!";
                    $json['url'] = "/is-gormez?id=" . $db->lastId();
                    $json['redirect'] = "1";
                    $json['time'] = "500";
                    $json['type'] = "success";
                } else {
                    $json['text'] = "Yazılımcıya ulaşın!";
                    $json['type'] = "error";
                }
            }

            echo json_encode($json);
        }else if ($type == 'does-not-work-edit'){
            $id = post('id');
            $namesurname = post('namesurname');
            $birthday = post('birthday');
            $workstartdate = post('workstartdate');
            $workenddate = post('workenddate');
            $gender = post('gender');
            $marital = post('marital');
            $netpay = post('netpay');
            $factor = post('factor');
            $agisec = post('agisec');
            $rate = post('rate');
            $jobrate = post('jobrate');
            $formtype = post('formtype');
            $doesworktime = post('doesworktime');
            $gig = post('gig');

            if (!$namesurname || !$birthday || !$workstartdate || !$workenddate || !$gender || !$marital || !$netpay || !$factor) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else {
                $insert = $db->update('doeswork')->where('id',$id)->set([
                    "namesurname" => $namesurname,
                    "birthday" => $birthday,
                    "workstartdate" => $workstartdate,
                    "workenddate" => $workenddate,
                    "gender" => $gender,
                    "marital" => $marital,
                    "doesworktime" => $doesworktime,
                    "netpay" => $netpay,
                    "factor" => $factor,
                    "agisec" => $agisec,
                    "rate" => $rate,
                    "type" => $formtype,
                    'jobrate' => $jobrate,
                    'gig' => $gig
                ]);

                if ($insert) {
                    $json['text'] = "Güncelleme işlemi başarılı!";
                    $json['url'] = "/is-gormez?id=" . $db->lastId();
                    $json['redirect'] = "1";
                    $json['time'] = "500";
                    $json['type'] = "success";
                } else {
                    $json['text'] = "Yazılımcıya ulaşın!";
                    $json['type'] = "error";
                }
            }

            echo json_encode($json);
        }else if ($type == 'pmf-edit'){
            $id = post('id');
            $namesurname = post("namesurname");
            $birthday = post("birthday");
            $workstartdate = post("workstartdate");
            $workenddate = post("workenddate");
            $gender = post("gender");
            $marital = post("marital");
            $momname = post("momname");
            $mombirdthday = post("mombirdthday");
            $dadname = post("dadname");
            $dadbirdthday = post("dadbirdthday");
            $netpay = post("netpay");
            //$grosspay = post("grosspay");
            $grosspay = "123";
            $factor = post("factor");
            $agisec = post("agisec");
            $rate = post("rate");

            // married
            $spouse = @$_POST['spouse'];
            $childs = @$_POST['childs'];


            if (!$namesurname || !$birthday || !$workstartdate || !$workenddate || !$gender || !$marital || !$netpay || !$grosspay || !$factor) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else if ($marital == "married" && (!$spouse['name'] || !$spouse['birthday'])) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else {
                $tazminat = 0;

                $insert = $db->update("pmf_workers")->where("id", $id)->set([
                    "namesurname" => $namesurname,
                    "birthday" => $birthday,
                    "workstartdate" => $workstartdate,
                    "workenddate" => $workenddate,
                    "gender" => $gender,
                    "marital" => $marital,
                    "momname" => $momname,
                    "mombirdthday" => $mombirdthday,
                    "dadname" => $dadname,
                    "dadbirdthday" => $dadbirdthday,
                    "netpay" => $netpay,
                    "grosspay" => $grosspay,
                    "factor" => $factor,
                    "agisec" => $agisec,
                    "rate" => $rate,
                    "childs" => json_encode($childs),
                    "spouse" => json_encode($spouse),
                    "tazminat" => $tazminat
                ]);

                if ($insert) {
                    $json['text'] = "Düzenleme Başarılı!";
                    $json['type'] = "success";
                } else {
                    $json['text'] = "Yazılımcıya ulaşın!";
                    $json['type'] = "error";
                }


            }
            echo json_encode($json);

        } else {
            $namesurname = post("namesurname");
            $birthday = post("birthday");
            $workstartdate = post("workstartdate");
            $workenddate = post("workenddate");
            $gender = post("gender");
            $marital = post("marital");
            $momname = post("momname");
            $mombirdthday = post("mombirdthday");
            $dadname = post("dadname");
            $dadbirdthday = post("dadbirdthday");
            $netpay = post("netpay");
            //$grosspay = post("grosspay");
            $grosspay = "123";
            $factor = post("factor");
            $agisec = post("agisec");
            $rate = post("rate");

            // married
            $spouse = @$_POST['spouse'];
            $childs = @$_POST['childs'];


            if (!$namesurname || !$birthday || !$workstartdate || !$workenddate || !$gender || !$marital || !$netpay || !$grosspay || !$factor) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else if ($marital == "married" && (!$spouse['name'] || !$spouse['birthday'])) {
                $json['text'] = "Lütfen tüm alanları doldurunuz!";
                $json['type'] = "error";
            } else {
                $tazminat = 0;

                $insert = $db->insert("workers")->set([
                    "namesurname" => $namesurname,
                    "birthday" => $birthday,
                    "workstartdate" => $workstartdate,
                    "workenddate" => $workenddate,
                    "gender" => $gender,
                    "marital" => $marital,
                    "momname" => $momname,
                    "mombirdthday" => $mombirdthday,
                    "dadname" => $dadname,
                    "dadbirdthday" => $dadbirdthday,
                    "netpay" => $netpay,
                    "grosspay" => $grosspay,
                    "factor" => $factor,
                    "agisec" => $agisec,
                    "rate" => $rate,
                    "childs" => json_encode($childs),
                    "spouse" => json_encode($spouse),
                    "tazminat" => $tazminat
                ]);

                if ($insert) {
                    $json['text'] = "Düzenleme Başarılı!";
                    $json['url'] = "/dokum?id=" . $db->lastId();
                    $json['redirect'] = "1";
                    $json['time'] = "500";
                    $json['type'] = "success";
                } else {
                    $json['text'] = "Yazılımcıya ulaşın!";
                    $json['type'] = "error";
                }


            }
            echo json_encode($json);
        }
    }
} else {
    http_response_code(404);
}
