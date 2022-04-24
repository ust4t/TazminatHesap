<?php
error_reporting(0);
ini_set("error_reporting",0);
// Coder By Taha KOÇAK
session_start();
ob_start();

$db = new DB("localhost","iphonetu_dykt","iphonetu_dykt","Natocams38**");

// https veya http ayarını yapınız!
$siteUrl = "https://".$_SERVER['HTTP_HOST']."/";