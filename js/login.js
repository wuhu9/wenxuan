$(function () {
    $('.login_btn').click(function () {
        console.log(0);
        // 用户输入的
        var account = $('#account').val(); // "a123123"
        var pwd = $('#password').val();

        // 1. 前端传入用户名和密码 
        // 2. 后端接收 -> 对应用户查找是否存在该数据?
        //    a. 不存在 => 未注册  => 失败
        //    b. 存在 => 获取数据 => 对比密码  => 登录成功

        if (account && pwd) {
            console.log(1);
            var xhr = new XMLHttpRequest();

            xhr.open("post", "../php/loginAccount.php", true);

            // FormData
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(`account=${account}&pwd=${pwd}`);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText;

                    result = JSON.parse(result);

                    console.log(result);

                    var { status, message, user} = result;
                    if (status) {
                        console.log(user);
                        setCookie("lgc", user, 31 * 24 * 60 * 60)
                        location.href = "../html/index.html";
                    } else {
                        alert(message);
                    }


                }
            }
        }

    })
})
