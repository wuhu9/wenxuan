function setCookie(key, val, expires, path = "/") {
    if (expires != undefined) { // 有参数
        var date = new Date();
        date.setSeconds(date.getSeconds() + expires);
        document.cookie = key + "=" + encodeURIComponent(val) + "; expires=" + date.toUTCString() + "; path=" + path;
    } else {
        document.cookie = key + "=" + encodeURIComponent(val) + "; path=" + path;
    }
}



// getCookie(key)

// function getCookie(key) {
//     var cookie = document.cookie;
//     var data = {};
//     if (cookie) {
//         var list = cookie.split("; ");
//         // console.log(list);
//         for (var i = 0; i < list.length; i++) {
//             var item = list[i]; // 'user=a123123', 'pwd=123123'
//             var name = item.split("=")[0];
//             var val = item.split("=")[1];
//             data[name] = val;
//         }
//     }
//     // console.log(data);
//     return data[key] ? data[key] : "";
// }

function getCookie(key) { // 传入的键名
    var cookie = document.cookie;
    if (cookie) {
        var list = cookie.split("; ");
        // console.log(list);

        for (var i = 0; i < list.length; i++) {
            var item = list[i]; // 'user=a123123', 'pwd=123123'
            var name = item.split("=")[0];  // 解析的键名
            var val = item.split("=")[1];

            if (name === key) {
                return decodeURIComponent(val);
            }
        }
    }
    // console.log(data);
    return "";
}


function delCookie(key) {
    setCookie(key, "", -1);
}