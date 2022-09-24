/**
    * 函数注释
    * 
    * @params  type    请求的方式(get/post)
    * @params  url     请求的地址
    * @params  data    请求时携带的数据 (string|object)
    * @params  isAsync   是否异步(默认:true)
    * @params  dataType   接口返回的数据类型(text(文本)  html json css script)
    * 
    **/
   


const request = (opetions = {}) => {

    return new Promise((resolve, reject) => {
        const { type = "get", url, data = "", isAsync = "true", dataType = "text" } = opetions;

        if (data instanceof Object) {
            const list = [];

            for (let key in data) {
                const val = data[key];
                list.push(`${key}=${val}`);
            }

            data = list.join("&");
        }


        const xhr = new XMLHttpRequest();


        if (type.toLowerCase() == "get") {
            xhr.open("get", data ? url + "?" + data : url, isAsync);
            xhr.send();
        } else if (type.toLowerCase() == "post") {
            xhr.open("post", url, isAsync)
            xhr.setRequestHeader("content-type", "x-www-from-urlencoded");
            xhr.send(data);
        }

        xhr.onreadystatechange = () => {
            try { 
                if(xhr.readyState == 4 && xhr.status == 200){
                    const res = xhr.responseText;
                    if(dataType == "json"){
                        res = JSON.parse(res);
                    }
                    resolve(res);
                }
            }catch{
                reject(err);
            }
        }
    })
}

