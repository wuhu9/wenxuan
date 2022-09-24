
// 模糊搜索 分页 和排序的组合接口
const all = (params = {}) => request({
    // type: "get",
    url: "../php/all.php",
    data: params,
    dataType: "json",
})
// 添加进购物车
const addToShoppingCar = (params = {}) => request({
    // type: "get",
    url: "../php/addToShoppingCar.php",
    data: params,
    dataType: "json",
})
// 删除接口
const _delete = (params = {}) => request({
    // type: "get",
    url: "../php/delete.php",
    data: params,
    dataType: "json",
})

// 注册接口
const registe = (params = {}) => request({
    type: "post",
    url: "../php/registe.php",
    data: params,
    dataType: "json",
})
// 登录接口
const login = (params = {}) => request({
    type: "post",
    url: "../php/login.php",
    data: params,
    dataType: "json",
})
// 显示购物车接口
const showShoppingCar = (params = {}) => request({
    // type: "get",
    url: "../php/shoppingCar.php",
    data: params,
    dataType: "json",
})
// 详情页接口
const detail = (params = {}) => request({
    // type: "get",
    url: "../php/detail.php",
    data: params,
    dataType: "json",
})







