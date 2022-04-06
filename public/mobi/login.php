<? include $_SERVER['DOCUMENT_ROOT']."/../components/__Header.php"; ?>
        <script>
            let choice_school = 0;
            $(function() {
                $('#savedata').on('click', function() {
                    let agree = $(this).data('id');
                    if(agree == 0) {
                        $('input:checkbox[id=chkAgreement]').prop('checked', false)
                    } else {
                        $('input:checkbox[id=chkAgreement]').prop('checked', true)
                    }
                })
                $('#txtSchoolname').keyup(function() {
                    var api_school = "";
                    if(choice_school == 0) {
                        $.ajax({
                            type: 'GET',
                            url: '/api/getSchoolInfo',
                            data: { schoolname: $('#txtSchoolname').val() },
                            dataType: "json"
                        }).done(function(json) {
                            $.each(json.schoolinfo, function(index, item) {
                                if((item['name'] != undefined) && (item['code'] != undefined)) {
                                    api_school += "<a href=\"javascript:;\" onclick class=\"item choice\"><span class='txtSchoolname'>" + item['name'] + "</span><span class='school-code' style='text-indent:-9999px;display:block;position:absolute'>"+ item['code'] + "</span></a>\n";
                                }
                            });
                            if($('#txtSchoolname').val().length == 0) $('.results').html("");
                            else $('.results').html('<div class="dropdown_q">' + api_school + '</div>');
                        });
                    }
                })
                /*$('input:checkbox[name=chkAgreement]').on('change', function() {
                    const message = "사용자 정보제공 및 단말기 저장에 관한 동의\n본 시스템은 사용자의 기본정보 및 건강상태진단을 수집하며, 사용자의 편의를 위해 사용자정보 일부를 단말기에 저장하고 있습니다.\n단말기에 저장되는 정보는 암호화된 세션 인증코드이며, 개인정보의 접근 차단을 위해 사용자가 지정한 2차 인증정보를 입력해야만 시스템에 접근할 수 있도록 하였습니다.\n시스템에 저장되는 항목은 아래와 같습니다.\n1. 소속학교명\n2. 학생성명\n3. 접속IP\n4. 진단항목\n5. 진단일\n\n수집되는 정보는 목적 달성시 담당선생님에 의해 복구할 수 없도록 즉시 파기 됩니다.\n만약 원치 않는 경우 본인의 의사에 따라 직접 삭제를 할 수 있습니다.";
                    if($('input:checkbox[id=chkAgreement]').prop('checked', true)) {
                        if(confirm(message) == false) {
                            $('input:checkbox[id=chkAgreement]').prop('checked', false);
                            alert('정보제공 및 단말기 저장에 관하여 동의하지 않으셨기 때문에 이 시스템을 사용할 수 없습니다.')
                            return false;
                        }
                    }
                })*/
                $(document).on("click", '.item.choice', function() {
                    choice_school = 1;
                    $('input#txtSchoolname').val($(this).children('span.txtSchoolname').text());
                    $('input#school-code').val($(this).children('span.school-code').text());
                    $('.results').html("")
                });

                $('input[name=txtSchoolname]').on("click", function() {
                    $(this).val('');
                    choice_school = 0;
                })

                $('#btn-submit').on('click', function(){
                    if(!window.localStorage){
                        alert('본 사이트를 이용할 수 없는 브라우저 입니다.');
                        return false;
                    }
                    if(($('input[name=txtSchoolname]').val() == "") || ($('input[name=school_code]').val() =="")) {
                        alert('소속학교를 선택하세요.');
                        $('#txtSchoolname').focus();
                        return false;
                    }
                    if($('input[name=student_name]').val() == "") {
                        alert('학생성명을 입력하여 주십시요.');
                        $('input[name=txtUsername]').focus();
                        return false;
                    }

                    let userinfo = {
                        'username': $('input[name=txtUsername]').val(),
                        'schoolcode' : $('input[name=school_code]').val()
                    };

                    $.ajax({
                        type: 'POST',
                        data: userinfo,
                        dataType: 'json',
                        url: '/api/getUserToken',
                        success:function(data) {
                            console.log(data.token);
                            if((data.code == 200) && (data.token != false)) {
                                localStorage.setItem('JWT', data.token);
                                location.href = "/mobi/userPassword";
                            } else if((data.code == 200) && (data.token == false)) {
                                alert('토큰서버에 문제가 발생하였습니다.\n이 문제가 계속 발생할 경우 선생님께 문의하세요.');
                                return false;
                            } else {
                                
                            }
                        }, error: function(err, data){
                            console.log(err);
                        }
                    });
                })
            })
        </script>
        <script>
            window.onload = function() {
                if(localStorage.getItem('JWT')) window.location.href = "/mobi/userPassword";
            }
        </script>
        <style>
            .dropdown_q{width:100%;height:auto;overflow:auto;max-height:160px;border-left:1px solid #ccc;border-right:1px solid #ccc;border-radius:4px;position:absolute;background:#fff}
            .dropdown_q span{display:block;padding:6px 8px;border-bottom:1px solid #ccc;}
            .dropdown_q span:hover{background:#f1f1f1}
        </style>

            <div class="appsBody">
                <header class="d-flex justify-content-between bd-highlight mb-2">
                    <h3 class="p-2 h3 align-left">로그인</h3>
                </header>
                <section class="p-1">
                    <form id="frmLogin">
                        <div class="card m-1 p-2">
                            <div class="rows p-3 text-dark" id="sheet1">
                                <label for="txtSchoolname" class="form-label">학교명</label>
                                <input type="text" id="txtSchoolname" name="txtSchoolname" class="form-control" autocomplete="off"/>
                                <input type="hidden" id="school-code" name="school_code">
                                <div class="results text-black"></div> 
                            </div>
                            <div class="rows p-3 text-dark" id="sheet1">
                                <label for="txtUsername" class="form-label">학생성명</label>
                                <input type="text" id="txtUsername" name="txtUsername" class="form-control" autocomplete="off"/>
                            </div>
                            <div class="rows p-3 text-dark" id="sheet1">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="chkAgreement" data-bs-toggle="modal" data-bs-target="#modal"/>
                                    <label for="chkAgreement" class="form-check-label"> 시스템 이용동의</label>
                                </div>
                            </div>
                            <div class="rows p-3 text-dark d-grid gap-2">
                                <button type="button" id="btn-submit" class="btn btn-primary p-3">로그인</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
<!-- Modal -->
        <div class="modal" id="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black">사용자 정보 제공 및 저장에 관한 동의</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-black">
                        본 시스템은 사용자의 기본정보 및 건강상태진단결과를 수집하며, 사용자의 편의를 위해 사용자정보 일부를 단말기에 저장하고 있습니다.<br/>
                        단말기에 저장되는 정보는 암호화된 세션 인증코드이며, 개인정보의 접근 차단을 위해 사용자가 지정한 2차 인증정보를 입력해야만<br/>
                        시스템에 접근할 수 있도록 하였습니다.<br/><br/>
                        시스템에 저장되는 항목은 아래와 같습니다.<br/>
                        1. 소속학교명<br/>
                        2. 학생성명<br/>
                        3. 접속IP<br/>
                        4. 접속단말종류(iOS, Android, Windows)<br/>
                        5. 진단항목 및 진단일<br/>>
                        <br/>
                        수집되는 정보는 목적 달성시 담당선생님에 의해 복구할 수 없도록 즉시 파기 됩니다.<br/>
                        만약 원치 않는 경우 본인의 의사에 따라 직접 삭제를 할 수 있습니다.
                    </div>
                    <div class="modal-footer">
                        <button id="savedata" type="button" class="btn btn-secondary" data-id="0" data-savedata="disagree" data-bs-dismiss="modal">동의하지않습니다.</button>
                        <button id="savedata" type="button" class="btn btn-primary" data-id="1" data-savedata="agree" data-bs-dismiss="modal">동의합니다.</button>
                    </div>
                </div>
            </div>
        </div>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__Footer.php"; ?>