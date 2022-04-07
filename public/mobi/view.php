<?
    include_once $_SERVER['DOCUMENT_ROOT']."/../components/dbconn.php";
    include $_SERVER['DOCUMENT_ROOT']."/../components/__Header.php";

    if($_SESSION['user_ssn'] == false) {
        @header('Location: /mobi/login');
    }

    $userinfo = $db->query("SELECT * FROM chk_user WHERE user_ssn = '".$_SESSION['user_ssn']."'")->fetch_assoc();
    if($userinfo['user_trustd'] == 0) {
        echo "<script>\nalert('사용자 확인이 필요합니다.\\n담당선생님꼐 문의하세요.');\nwindow.location.href='/mobi/noti';\n</script>\r";
        exit();
    }

    $noti = $db->query("SELECT * FROM covid19_notice WHERE id = '".$_GET['id']."'")->fetch_assoc();
?>
<div class="appsBody">
<header class="d-flex justify-content-between bd-highlight mb-2">
    <h3 class="p-2 h3 align-left">알림함</h3>
    <div class="p-2">
    <ul class="apps-header-quick d-flex justify-content-between bd-highlight mb-2">
                                <li class="p-2">
                                    <a href="/mobi/noti">
                                        <i class="bi bi-bell"></i>
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="/mobi/myinfo">
                                        <i class="bi bi-person-bounding-box"></i>
                                    </a>
                                </li>
                            </ul>
    </div>
</header>
<section class="p-1">
    <div class="card m-1">
        <ul class="d-flex justify-content-between bd-highlight mb-2 text-dark" style="list-style:none">
            <li class="mt-4 mb-2"><?=$noti['b_sbj'];?></li>
            <li class="mt-4 mb-2"><?=$noti['b_regdate'];?></li>
        </ul>
    </div>
    <div class="card m-1 mt-3">
        <div class="rows text-dark p-4">
            <?=nl2br($noti['b_content']);?>
        </div>
    </div>
</section>
</div>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__LoginFooter.php"; ?>