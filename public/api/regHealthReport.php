<?
	@header("Content-Type:application/json");
	
    include_once $_SERVER["DOCUMENT_ROOT"]."/../components/refererBlock.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/../components/dbconn.php";

    //user_ssn, user_name, user_schoolcode, user_schoolname, user_q1, user_q2, user_q3, user_val, regdate, regdatetime
    
    $arr = array();

    $ssn = $_POST['user_ssn'];
    $name = $_POST['username'];
    $schoolcode = $_POST['schoolcode'];
    $schoolname = $_POST['schoolname'];
    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];
    $q3 = $_POST['q3'];
    $q4 = 0;
    $val = $_POST['val'];
    $regdate = date('Y-m-d');
    $datetime = date('Y-m-d H:i:s');

	if(($name) && ($schoolcode)){
        
        $sql = "SELECT COUNT(*) as cnt FROM check_report WHERE user_ssn = '".$ssn."' AND user_schoolcode = '".$schoolcode."' AND regdate = '".$regdate."'";
        $qry = $db->query($sql)->fetch_assoc()[cnt];

		if($qry >= 1) {
            $sql = "UPDATE check_report SET user_q1 = '$q1', user_q2 = '$q2', user_q3 = '$q3', user_val = '$val', regdatetime = '$datetime' WHERE user_ssn = '".$ssn."' AND user_schoolcode = '".$schoolcode."' AND regdate = '".$regdate."'";
            $qry = $db->query($sql);

            if($qry) {
			    $arr["code"] = 200;
			    $arr["message"] = "OK";
            } else {
                $arr["code"] = 400;
                $arr["message"] = "ERROR";
            }

		} else {
            $sql = "INSERT INTO check_report (user_ssn, user_name, user_schoolname, user_schoolcode, user_q1, user_q2, user_q3, user_q4, user_val, regdate, regdatetime) VALUES ";
            $sql.= "('$ssn', '$name', '$schoolname', '$schoolcode', '$q1', '$q2', '$q3', '$q4', '$val', '$regdate', '$datetime')";

            if($db->query($sql)) {
			    $arr["code"] = 200;
			    $arr["message"] = "OK";
            } else {
                $arr["code"] = 400;
                $arr["message"] = "ERROR";
            }
		}

	} else {
		$arr["code"] = 204;
		$arr["message"] = "No Content";
	}

	//if($arr == null) $arr["code"] = "403";

    //return $token;

	print_r(json_encode($arr, JSON_UNESCAPED_UNICODE));
?>