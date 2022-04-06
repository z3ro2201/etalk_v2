<?php
@session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/../components/dbinfo.php";

$sha256_key = "3D301EFF008CA2087C0B6EACA0D19C35C32BAF582F28F3EAA8FA2DC08976174E";
$db = new mysqli($host, $dbid, $dbpw, $dbname);
if (mysqli_connect_error()) {
        exit("ERROR");
}

$db->query("SET NAMES utf8");
?>
