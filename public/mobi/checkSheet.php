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
                    <section class="p-1" id="sheetBody">
                        <form onsubmit="return chkSheet();">
                        <div class="card m-1 p-2">
                            <div class="rows p-3 text-dark group" id="sheet1">
                                <label for="exampleFormControlTextarea1" class="form-label d-block">
                                    1. <span class="q1_question">학생 본인이 코로나19가 의심되는 아래의 임상증상<sup>*</sup>이 있나요?</span><br/>
                                    * (주요임상증상) 발열(37.5℃ 이상), 기침, 호흡곤란, 오한, 근육통, 두통, 인후통, 후각·미각소실<br/>
                                    ※ 단 학교에서 선별진료소 검사결과(음성)을 확인 후 등교를 허용한 경우, 또는 선천성질환·만성질환(천식 등)으로 인한 증상인 경우 &#039;아니오&#039;를 선택하세요.
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="chkQ1" id="chkq1_Y" value="1" />
                                    <label class="form-check-label d-block" for="chkq1_Y">예</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="chkQ1" id="chkQ1_N" value="0"/>
                                    <label class="form-check-label d-block" for="chkQ1_N">아니오</label>
                                </div>
                            </div>
                            <div class="rows p-3 text-dark group" id="sheet2">
                                <label for="exampleFormControlTextarea1" class="form-label">
                                    2. <span class="q2_question">학생 본인은 오늘(어제 저녁 포함) 신속항원검사(자가진단)를 실시했나요?</span><br/>
                                    ※ 코로나19 완치자의 경우, 확진일로부터 45일간 신속항원검사(자가진단)는 실시하지 않음(&#039;검사하지 않음&#039;으로 선택)
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="chkQ2" id="chkq2_N" value="-1"/>
                                    <label class="form-check-label d-block" for="chkq2_N">검사하지않음</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="chkQ2" id="chkQ2_Negative" value="0"/>
                                    <label class="form-check-label d-block" for="chkQ2_Negative">음성</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="chkQ2" id="chkQ2_Benign" value="1"/>
                                    <label class="form-check-label d-block" for="chkQ2_Benign">양성</label>
                                </div>
                            </div>
                            <div class="rows p-3 text-dark group" id="sheet3">
                                <label for="exampleFormControlTextarea1" class="form-label d-block">
                                    3. <span class="q3_question">학생 본인이 PCR등 검사를 받고 그 결과를 기다리고 있나요?</span>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="chkQ3" id="chkq3_Y" value="1"/>
                                    <label class="form-check-label d-block" for="chkq3_Y">예</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="chkQ3" id="chkQ3_N" value="0"/>
                                    <label class="form-check-label d-block" for="chkQ3_N">아니오</label>
                                </div>
                            </div>
                            <div class="rows p-3 text-red text-center group">
                                <strong>[나의 동거인이 확진자인 경우]</strong><br/>
                                나의 동거인이 확진되어 재택치료중인 경우 10일간 수동감시 대상이 됩니다.<br/>
                                * 확진자의 검사일(검체채취일) 기준 3일 내 PCR 검사(지정의료기관에 방문하여 전문가용 신속항원검사 대체 가능) 권고 및 6~7일차 신속항원검사 권고<br/>
                                * 검사결과 확인시까지 등교 중지(자택 대기) 권고<br/>
                                (동거인이 PCR 검사 또는 전문가용 신속항원검사를 받고 그 결과를 기다리고 있는 경우를 포함하되, 감염취약시설 종사자로 선제 검사를 실시한 경우는 제외)
                            </div>
                            <div class="rows p-3 text-dark d-grid gap-2">
                                <button type="submit" id="btn-submit" class="btn btn-primary p-3 btn-lg">제&nbsp;출</button>
                            </div>
                        </div>
                    </form>
                    </section>

                    <section class="p-1" id="sheetOk">
                        <div class="card m-1 rows p-4 text-dark">
                            <div class="text-center">
                                <i class="display-3 bi" id="icons"></i>
                                <div class="display-6 mt-2">
                                    자가진단 완료
                                </div>
                                <div class="d-block">
                                    오늘의 자가진단 참여를 완료하였습니다.
                                </div>
                                <div class="d-block text-center mt-2">
                                    <a href="/mobi/main"><span class="btn btn-primary">확&nbsp;인</span></a>
                                </div>
                                
                                <div class="mt-3 hidden-class" id="health-danger">
                                    <span class="badge bg-danger mt-1 mb-2">유증상</span>
                                    <span class="d-block text-danger">
                                        현재 귀하의 건강상태는 가정내에서 관리가 필요한 상황이므로 주변분들의 건강한 학교생활을 위해 잠시 등교하지 않도록 협조하여 주시기 바랍니다.<br/>
                                        발열, 호흡기 증상 등 코로나19가 의심되는 증상이 있는 경우 콜센터(1339, 지역번호+120) 또는 관할보건소에 문의하고 선별진료소 방문 후 진료·검사받기 등 안내에 따라주시기 바랍니다.
                                    </span>
                                </div>
                                <div class="mt-3 hidden-class" id="health-ok">
                                    <span class="badge bg-success mt-1 mb-2">등교가능</span>
                                    <span class="d-block text-success">
                                        코로나19 예방을 위한 자가진단 설문결과 의심 증상에 해당되는 항목이 없어 등교가 가능함을 안내드립니다.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>
</div>
<script>

    function moveTo (sheet_id, msg) {
        let sheetid = '#sheet' + sheet_id;
        alert('[오류!]\n' + sheet_id + '번 항목(' + msg + ')을 확인해주세요!');
        $('.appsBody').animate({
            scrollTop: $(sheetid).position().top
        }, 500);
    }

    function chkSheet() {
       if(!$('input:radio[name=chkQ1]').is(':checked')) {
           this.moveTo(1, $('.q1_question').text());
           return false;
       }
       if(!$('input:radio[name=chkQ2]').is(':checked')) {
           this.moveTo(2, $('.q2_question').text());
           return false;
       }
       if(!$('input:radio[name=chkQ3]').is(':checked')) {
           this.moveTo(3, $('.q3_question').text());
           return false;
       }
        else {
            if (window.confirm('작성하신 내용을 확인하셨습니까?') == true){
                let sheetQ1 = $('input[name=chkQ1]:checked').val();
                let sheetQ2 = $('input[name=chkQ2]:checked').val();
                if(sheetQ2 == -1) sheetQ2 = 0;
                else if(sheetQ2 == 0) sheetQ2 = 0;
                else sheetQ2 = 1;
                let sheetQ3 = $('input[name=chkQ3]:checked').val();

                let healthResult = parseInt(sheetQ1)+parseInt(sheetQ2)+parseInt(sheetQ3);

                $('#sheetBody').css('display', 'none');
                $('#sheetOk').css('display', 'block');

                if(healthResult == 0) {
                    $('#icons').addClass('bi-check-circle');
                    $('#icons').css('color', 'green');
                    $('#health-ok').removeClass('hidden-class')
                } else {
                    $('#icons').addClass('bi-x-circle');
                    $('#icons').css('color', 'red');
                    $('#health-danger').removeClass('hidden-class')
                }
            } else {
                
                return false;
            }
        }
        return false;
        //return true;
    }
</script>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__LoginFooter.php"; ?>