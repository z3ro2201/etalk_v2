<?
    include_once $_SERVER['DOCUMENT_ROOT']."/../components/dbconn.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/../components/__Header.php";

    if($_SESSION['user_ssn'] == false) {
        @header('Location: /mobi/login');
    }

    $userinfo = $db->query("SELECT * FROM chk_user WHERE user_ssn = '".$_SESSION['user_ssn']."'")->fetch_assoc();
?>
<div class="appsBody">
<header class="d-flex justify-content-between bd-highlight mb-2">
    <h3 class="p-2 h3 align-left">나의정보</h3>
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
        <div class="rows p-4 text-dark">
            <a href="/mobi/logout">로그아웃</a>
        </div>
    </div>
    <div class="card m-1">
        <div class="rows p-4 text-dark">
            <a href="/mobi/changeUserPassword">비밀번호 변경</a>
        </div>
    </div>
</section>
</div>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__LoginFooter.php"; ?>