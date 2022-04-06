<?
	include_once $_SERVER["DOCUMENT_ROOT"]."/../components/dbconn.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/../components/jwt.php";

    $jwt = new JWT();

    $setMode = $_POST['proc'];
    
    if($setMode == '2ndlogin') {
        $sessid = $_POST['token'];
        $secondspw = $_POST['passwords'];
        
        $sql = "SELECT * FROM chk_user WHERE sessid = '$sessid' AND user_passwd = SHA2('$secondspw', 512)";
        $result = $db->query($sql)->fetch_assoc();

        if(!$result) {
            echo "<script>\nalert('조작된 로그인정보 또는 잘못된 인증코드입니다.\\n문제가 지속적으로 발생할 경우 담당선생님꼐 문의하시기 바랍니다.')\nwindow.history.back(-1);\n</script>";
            exit();
        }

        $_SESSION['user_ssn'] = $result['user_ssn'];
        echo "<script>window.location.href=\"/mobi/main\";\n</script>";
        exit();
    }
?>