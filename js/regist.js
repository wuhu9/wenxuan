$(function () {
    var isPwdOk = false;
    var isPhoneOk = false;
    var isCheckPwdOk = false;
    var isUserOk = false;
    $('.phoneInp').blur(function () {
        isPhoneOk = false;
        var phone = $('.phoneInp').val().trim();
        var reg = /^1[3-9]\d{9}$/;

        if (reg.test(phone)) {
            isExistPhone({ phone: phone }).then(result => {
                var { status, result } = result;
                if (status) {
                    $('.phone_span').text("√").css({ color: 'green', fontSize: '12px' });
                    isPhoneOk = true;

                } else {
                    $('.phone_span').text('手机号已被注册').css({ color: 'red', fontSize: '12px' });
                }
            }).catch(err => {
                throw err;
            })
        } else {
            $('.phone_span').text('请输入正确的手机号').css({ color: 'red', fontSize: '12px' });
        }
    })
    $('.username').blur(function () {
        isUserOk = false;
        var username = $('.username').val().trim();
        var reg = /^[a-zA-Z]\w{4,15}$/;

        if (reg.test(username)) {
            isExistUser({ username: username }).then(result => {
                var { status, result } = result;
                if (status) {
                    $('.user_span').text("√").css({ color: 'green', fontSize: '12px' });
                    isUserOk = true;

                } else {
                    $('.user_span').text('用户名已被注册').css({ color: 'red', fontSize: '12px' });
                }
            }).catch(err => {
                throw err;
            })
        } else {
            $('.user_span').text('请输入正确的用户名').css({ color: 'red', fontSize: '12px' });
        }
    })

    $('.pwdInp').blur(function () {
        isPwdOk = false;
        var pwd = $('.pwdInp').val().trim();
        var reg = /^[\w$]{8,}$/;

        if (reg.test(pwd)) {

            var isExistNum = /[0-9]/.test(pwd);
            var isExistSmall = /[a-z]/.test(pwd);
            var isExistBig = /[A-Z]/.test(pwd);
            var isExistSpe = /[_$]/.test(pwd);

            var level = isExistNum + isExistSmall + isExistBig + isExistSpe;

            $('.pwd_span').text("√密码强度:" + level).css({ color: 'green', fontSize: '12px' });
            isPwdOk = true;

        } else {
            $('.pwd_span').text("密码由数字,字母,下划线,$组成,最少8位").css({ color: 'red', fontSize: '12px' });
        }
    })

    $('.checkPwdInp').blur(function () {
        isCheckPwdOk = false;
        var pwd = $('.checkPwdInp').val().trim();

        if (pwd) {
            if (pwd == $('.pwdInp').val().trim()) {

                $('.checkPwd_span').text("输入正确").css({ color: 'green', fontSize: '12px' });
                isCheckPwdOk = true;

            } else {
                $('.checkPwd_span').text("密码输入不一致").css({ color: 'red', fontSize: '12px' });
            }
        } else {
            $('.checkPwd_span').text("密码不能为空").css({ color: 'red', fontSize: '12px' });
        }
    })

    $('.next-btn').click(async function () {
        console.log(isPwdOk, isPhoneOk, isCheckPwdOk,isUserOk);
        if (isPwdOk && isPhoneOk && isCheckPwdOk && isUserOk) {
            // alert("可以注册");

            var pwd = $('.pwdInp').val();
            var phone = $('.phoneInp').val();
            var username = $('.username').val()

            var result = await register({ pwd, phone,username });
            var { status, message } = result;
            if (status) {
                location.href = "../html/login.html";
                // console.log("成功");
            } else {
                alert(message);
            }
        }
    })
})