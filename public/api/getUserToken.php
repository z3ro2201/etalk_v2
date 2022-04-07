<?
	@header("Content-Type:application/json;charset=utf-8");
	
    include_once $_SERVER["DOCUMENT_ROOT"]."/../components/refererBlock.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/../components/dbconn.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/../components/jwt.php";

    $jwt = new JWT();

	$arr = array();

    $name = $_POST['username'];
    $sname = $_POST['schoolname'];
    $scode = $_POST['schoolcode'];

	if(($name) && ($scode)){
        
        $sql = "SELECT COUNT(*) as cnt FROM chk_user WHERE user_schoolcode = '".$scode."' AND user_name = '".$name."'";
        $qry = $db->query($sql)->fetch_assoc()[cnt];

		if($qry >= 1) {
            $sql = "SELECT * FROM chk_user WHERE user_schoolcode = '".$scode."' AND user_name = '".$name."'";
            $qry = $db->query($sql);
            $id = $qry->fetch_assoc()['user_ssn'];

			$arr["code"] = 200;
			$arr["message"] = "OK";

            // user info
            $token = $jwt -> hashing(array(
                'iss' => '2ero.dev',
                'exp' => time() + (360 * 30), // expired day
                'iat' => time(), // make date,
                'username' => $name,
                'uid' => $id
            ));
            
            $sql = "UPDATE chk_user SET sessid = '$token' WHERE user_schoolcode = '$scode' AND user_name = '$name'";
            $qry = $db->query($sql);

            if($qry) $arr['token'] = $token;

		} else {
            $sql = "SELECT COUNT(*) AS cnt FROM chk_user WHERE user_schoolcode = '$school_code'";
            $count = (int)$db->query($sql)->fetch_assoc()['cnt'] + 1;
            //$new_ssn = base64_encode(hash('sha256', $school_code . "_STD_" . $count, true));
            $new_ssn = $school_code."_STD_".$count;

            $sql = "INSERT INTO chk_user (user_ssn, user_name, user_passwd, user_schoolcode, user_schoolname, user_trustd, sessid, login_ip) VALUES ";
            $sql.="('$new_ssn', '$name', '', '$scode', '$sname', '0', '', '')";
            $qry = $db->query($sql);

            if(!$qry) {
                $arr["code"] = 400;
                $arr["message"] = "ERROR";
            } else {
                $arr["code"] = 201;
                $arr["message"] = "OK";
            }

            // user info
            $token = $jwt -> hashing(array(
                'iss' => '2ero.dev',
                'exp' => time() + (360 * 30), // expired day
                'iat' => time(), // make date,
                'username' => $name,
                'uid' => $id
            ));
            
            $sql = "UPDATE chk_user SET sessid = '$token' WHERE user_schoolcode = '$scode' AND user_name = '$name'";
            $qry = $db->query($sql);

            if($qry) $arr['token'] = $token;
		}

	} else {
		$arr["code"] = 204;
		$arr["message"] = "No Content";
	}

	//if($arr == null) $arr["code"] = "403";

    //return $token;

	print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
?>

