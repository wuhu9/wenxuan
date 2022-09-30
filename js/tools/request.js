/**
    * 函数注释
    * ajax(type,url, data = "", async = true, dataType = "text", success)  get请求
    * 
    * @params  type    请求的方式(get/post)
    * @params  url     请求的地址
    * @params  data    请求时携带的数据 (string|object)
    * @params  async   是否异步(默认:true)
    * @params  dataType   接口返回的数据类型(text(文本)  html json css script)
    * @params  success   请求成功时执行的回调函数 (回调函数有一个形式参数  用于接收响应数据)
    * 
    **/
// 优化2:  
// 参数数据队列还是需要自己手动拼接 ( `wd=${wd}&col=${col}&type=${type}&page=${page}&size=${size}`) => 太麻烦 

// 怎么解决?
// 参数数据队列也是以键值对的形式存在 排名不分先后 => 可以传入一个对象数据 {wd,col,type,page,size}  => 解析为 参数数据队列  ("wd=${wd}&col=${col}&type=${type}&page=${page}&size=${size}")


// 利用Promise封装 解决ajax异步     => 模拟axios

function request(options = {}) {
    // 默认返回进行中状态的Promise实例  => 请求有结果之后变状态
    return new Promise(function (resolve, reject) {

        var { type = "get", url, data = "", async = true, dataType = "text" } = options;

        if (data instanceof Object) { // 判断数据是否是纯对象 (有问题!后续补充)

            var list = [];

            for (var key in data) {
                var val = data[key];
                list.push(`${key}=${val}`);
            }
            // console.log(list);

            data = list.join("&");

            // console.log(data);
        }


        var xhr = new XMLHttpRequest(); // 0

        if (type.toLowerCase() == "get") {
            xhr.open("get", data ? url + "?" + data : url, async);
            xhr.send();
        } else if (type.toLowerCase() == "post") {
            xhr.open("post", url, async);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  // 将数据格式改为FormData
            xhr.send(data);
        }

        xhr.onreadystatechange = function () { // xhr.readyState状态 改变之后才会执行 (ajax请求时异步操作  => 状态改变时异步的 => )
            try {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText;
                    if (dataType == "json") {
                        result = JSON.parse(result);
                    }
                    resolve(result);
                }
            } catch (err) {
                reject(err);
            }
        }
    })
}






