<?
    include_once $_SERVER['DOCUMENT_ROOT']."/../components/dbconn.php";
    include $_SERVER['DOCUMENT_ROOT']."/../components/__Header.php";

    if($_SESSION['user_ssn'] == false) {
        @header('Location: /mobi/login');
    }

    $userinfo = $db->query("SELECT * FROM chk_user WHERE user_ssn = '".$_SESSION['user_ssn']."'")->fetch_assoc();
?>
<div class="appsBody">
<header class="d-flex justify-content-between bd-highlight mb-2">
    <h3 class="p-2 h3 align-left">자가진단</h3>
    <div class="p-2">
        <ul class="apps-header-quick d-flex justify-content-between bd-highlight mb-2">
            <li class="p-2">
                <a href="/">
                    <i class="bi bi-bell"></i>
                </a>
            </li>
            <li class="p-2">
                <a href="/myinfo">
                    <i class="bi bi-person-bounding-box"></i>
                </a>
            </li>
        </ul>
    </div>
</header>
<section class="p-1">
    <div class="card m-1">
        <div class="rows text-dark p-4">
            <?=$userinfo['user_name'];?>님<br/>
            <?=$userinfo['user_schoolname'];?>
        </div>
    </div>
    <div class="card m-1 mt-3">
        <a href="/mobi/checkSheet" class="rows text-dark p-4">
            자가진단진행하기
        </a>
    </div>
    <div class="card m-1 mt-3">
        <div class="rows text-dark p-4">
            <?
                $sql = "SELECT * FROM check_report WHERE user_ssn = '".$_SESSION['user_ssn']."' AND regdate = '".date('Y-M-D')."'";
                $result = $db->query($sql)->fetch_assoc();

                if($result == true) {
                    if($result['user_val'] !== 0) $val = "등교중지";
                    else $val = "정상";
                    $msg = "자가진단 완료 ($val)";
                } else {
                    $msg = "자가진단 미실시";
                }
                echo date('Y년 m월 d일')." $msg\n\r";
            ?>
        </div>
    </div>
</section>
</div>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__LoginFooter.php"; ?>