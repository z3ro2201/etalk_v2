<?
	@header("Content-Type:application/json");
	
    include_once $_SERVER["DOCUMENT_ROOT"]."/../components/refererBlock.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/../components/dbconn.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/../components/jwt.php";

    $jwt = new JWT();

	$arr = array();

    $name = $_POST['username'];
    $code = $_POST['schoolcode'];

	if(($name) && ($code)){
        
        $sql = "SELECT COUNT(*) as cnt FROM chk_user WHERE user_schoolcode = '".$code."' AND user_name = '".$name."'";
        $qry = $db->query($sql)->fetch_assoc()[cnt];

		if($qry >= 1) {
            $sql = "SELECT * FROM chk_user WHERE user_schoolcode = '".$code."' AND user_name = '".$name."'";
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
            
            $sql = "UPDATE chk_user SET sessid = '$token' WHERE user_schoolcode = '$code' AND user_name = '$name'";
            $qry = $db->query($sql);

            if($qry) $arr['token'] = $token;

		} else {
			$arr["code"] = 204;
			$arr["message"] = "No User";
		}

	} else {
		$arr["code"] = 204;
		$arr["message"] = "No Content";
	}

	//if($arr == null) $arr["code"] = "403";

    //return $token;

	print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
?>

