<?php
require __DIR__ . "/inc/DB.php";
require __DIR__ . "/inc/database.php";
require __DIR__ . "/inc/helpers.php";
error_reporting(E_ALL);
ini_set("error_reporting",1);
if ($_POST) {
    $type = post("type");

    switch ($type) {
        case "login":
            $email = post("email");
            $password = post("password");
            if (!$email || !$password) {
                $json = [
                    "type" => "error",
                    "text" => "Lütfen boş alan bırakmayınız!"
                ];
            } else {
                $row = $db->from("admins")->where("email", $email)->first();
                if ($row) {
                    if (password_verify($password, $row['password'])) {
                        $_SESSION[md5("email")] = $row['email'];
                        $json = [
                          "type" => "success",
                          "text" => "Giriş başarılı!",
                          "redirect" => 1,
                          "url" => $siteUrl,
                          "time" => 1000
                        ];
                    } else {
                        $json = [
                            "type" => "error",
                            "text" => "Şifreniz uyuşmuyor!"
                        ];
                    }
                } else {
                    $json = [
                        "type" => "error",
                        "text" => "Email adresiniz sistemde kayıtlı değil!"
                    ];
                }
            }
            break;
        case "delete":
            $delete = post("delete");
            $data = post("id");
            if ($delete == "dykt") {
                $dbName = "workers";
                $column = "id";
            }else if ($delete == 'pmf'){
                $dbName = "pmf_workers";
                $column = "id";
            }else if ($delete == 'doeswork'){
                $dbName = "doeswork";
                $column = "id";
            }
            if ($dbName && $column) {
                $delete = $db->delete($dbName)->where($column,$data)->done();
                if ($delete) {
                    $json['text'] = "Silindi!";
                    $json['type'] = "success";
                }else {
                    $json['text'] = "Sistemsel bir hata oluştu!";
                    $json['type'] = "warning";
                }
            }
            break;

        case "password" :
            $password = password_hash(post("value"),PASSWORD_DEFAULT);
            $json['type'] = "success";
            $json['text'] = $password;
            break;
    }

    echo json_encode($json);
}
