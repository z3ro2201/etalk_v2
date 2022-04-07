<? include $_SERVER['DOCUMENT_ROOT']."/../components/__Header.php"; ?>
<script>
    const JWT = localStorage.getItem('JWT');
    let numkey = '';
    let viewkey = '';

    window.onload = function() {
        if(!localStorage.getItem('JWT')) window.location.href = "/mobi/login";
        $('input[name=token]').val(JWT);
    }

    function login() {
        if(document.getElementById('passwords').value.length !== 4) {
            alert('2차 인증코드를 입력하셔야 다음단계로 진행이 가능합니다.');
            return false;
        }
        document.getElementById('frmProc').submit();
    }

    function logout() {
        if(confirm('정말로 로그아웃 하시겠습니까?') == true) {
            localStorage.clear();
            window.location.href = "/mobi/login";
            return false;
        }
    }

    function insertKey(val) {
        if(numkey.length <= 3) {
            numkey+=val;
            viewkey+=0;
            document.getElementById('txtPassword').value = viewkey;
            document.getElementById('passwords').value = numkey;
        }
    }

    function removeKey() {
        numkey=numkey.slice(0,-1);
        viewkey=viewkey.slice(0,-1);
        document.getElementById('txtPassword').value = viewkey;
        document.getElementById('passwords').value = numkey;
    }

    function enterKey() {
        if(numkey.length !== 4) {
            alert('비밀번호는 4자를 입력해야 합니다.');
            return false;
        }
        document.getElementById('secKeypad').style.display = 'none';
    }

    function openPad() {
        numkey = '';
        viewkey = '';
        document.getElementById('txtPassword').value = '';
        document.getElementById('passwords').value = '';
        document.getElementById('secKeypad').style.display = 'block';
    }

    function closePad() {
        document.getElementById('secKeypad').style.display = 'none';
    }
</script>
<style>
#secKeypad{width:330px;height:auto;margin:0 auto;overflow:hidden;border:1px solid #ccc;position:absolute;margin-top:10px;left:calc(50% - 165px);display:none}
#secKeypad .secKeyTitle{background:#ccc;display:flex;justify-content: space-between;}
#secKeypad .cols{float:left;width:calc(328px / 4);}
#secKeypad .cols button{width:100%;height:60px;border-radius:0;border:1px solid #ccc;color:#000}
</style>
                <div class="appsBody">
                <header class="d-flex justify-content-between bd-highlight mb-2">
                    <h3 class="p-2 h3 align-left">비밀번호 생성</h3>
                </header>
                <section class="p-1">
                    <form id="frmProc" action="/mobi/etalkProc" method="post">
                        <div class="card m-1 p-2">
                            <div class="rows p-3 text-dark" id="sheet1">
                                <label For="" class="form-label">사용하실 2차 비밀번호를 입력하세요.</label>
                                <input type="password" name="txtUserpassword" id="txtPassword" class="form-control" onclick="openPad()" readonly/>
                                <input type="hidden" name="token" id="token"/>
                                <input type="hidden" name="passwords" id="passwords"/>
                                <input type="hidden" name="proc" value="newAccount"/>
                                <div id="secKeypad">
                                    <div class="rows p-2 secKeyTitle">
                                        <span>가상키보드</span>
                                        <span><a href="javascript:;" onclick="closePad();">x</a></span>
                                    </div>
                                    <div class="rows">
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="1" onclick="insertKey(this.value)">1</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="2" onclick="insertKey(this.value)">2</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="3" onclick="insertKey(this.value)">3</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="4" onclick="insertKey(this.value)">4</button></div>
                                    </div>
                                    <div class="rows">
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="5" onclick="insertKey(this.value)">5</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="6" onclick="insertKey(this.value)">6</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="7" onclick="insertKey(this.value)">7</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="8" onclick="insertKey(this.value)">8</button></div>
                                    </div>
                                    <div class="rows">
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="9" onclick="insertKey(this.value)">9</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" value="0" onclick="insertKey(this.value)">0</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" onclick="removeKey()">지움</button></div>
                                        <div class="cols"><button type="button" class="btnNumberpad-button" onclick="enterKey()">확인</button></div>
                                    </div>
                                </div>
                            </div>
                            <div class="rows p-3 text-dark d-grid gap-2">
                                <button type="button" id="btnsubmit" onclick="login();" class="btn btn-primary p-3">비밀번호 생성</button>
                            </div>
                        </div>
                    </form>
                </section>
<? include $_SERVER['DOCUMENT_ROOT']."/../components/__Footer.php"; ?>