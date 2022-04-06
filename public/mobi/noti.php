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
    <h3 class="p-2 h3 align-left">알림함</h3>
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
    <div class="card m-1 mt-3">
        <div class="rows text-dark p-4">
            사용자인증을 완료해야 이 기능을 사용할 수 있습니다.
        </div>
    </div>
</section>
</div>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__LoginFooter.php"; ?>