<?
	include_once $_SERVER["DOCUMENT_ROOT"]."/../components/dbconn.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/../components/jwt.php";

    $jwt = new JWT();

    $setMode = $_POST['proc'];

    if($setMode == 'newAccount') {
        $name = $_POST['name'];
        $sessid = $_POST['token'];
        $secondspw = $_POST['passwords'];

        $ssn = $db->query("SELECT * FROM chk_user WHERE sessid = '$sessid'")->fetch_assoc();
        
        $sql = "UPDATE chk_user SET user_passwd = SHA2('$secondspw', 512) WHERE sessid = '$sessid' AND user_ssn = '".$ssn['user_ssn']."'";
        $result = $db->query($sql);

        if(!$result) {
            echo "<script>\nalert('서버에 문제가 발생하였습니다.\\n 지속적으로 발생할 경우 담당선생님꼐 문의하시기 바랍니다.')\nwindow.history.back(-1);\n</script>";
            exit();
        }

        $_SESSION['user_ssn'] = $result['user_ssn'];
        echo "<script>\nwindow.location.href=\"/mobi/login\";\n</script>";
    }

    if($setMode == 'changePasswd') {
        $sessid = $_POST['token'];
        $userssn = $_POST['ussn'];
        $secondspw = $_POST['passwords'];

        $ssn = $db->query("SELECT * FROM chk_user WHERE sessid = '$sessid'")->fetch_assoc();
        
        $sql = "UPDATE chk_user SET user_passwd = SHA2('$secondspw', 512) WHERE sessid = '$sessid' AND user_ssn = '$userssn'";
        $result = $db->query($sql);

        if(!$result) {
            echo "<script>\nalert('서버에 문제가 발생하였습니다.\\n 지속적으로 발생할 경우 담당선생님꼐 문의하시기 바랍니다.')\nwindow.history.back(-1);\n</script>";
            exit();
        } 
        echo "<script>\nalert('성공적으로 비밀번호가 변경되었습니다.')\nwindow.location.href=\"/mobi/\";\n</script>";
    }
    
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