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
    <?if($userinfo['user_trustd'] == 0) { ?>
    <div class="card m-1 mt-3">
        <div class="rows text-dark p-4">
            사용자확인이 필요합니다.<br/>
            담당선생님께 문의해주세요.
        </div>
    </div>
    <? } else {
        $total = $db->query("SELECT COUNT(*) AS tot FROM covid19_notice WHERE (1)")->fetch_assoc();
        $qry = $db->query("SELECT * FROM covid19_notice ORDER BY id DESC");
        while($data = $qry->fetch_assoc()) {?>
    <div class="card m-1 mt-3">
        <div class="rows text-dark p-4">
            <a href="/mobi/view?id=<?=$data['id'];?>"><?=$data['b_sbj'];?></a><br/>
            <?=$data['b_regdate'];?>
        </div>
    </div>
    <? } }?>
</section>
</div>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__LoginFooter.php"; ?>