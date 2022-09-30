const isExistUser = (params = {}) => request({
    // type: "get",
    url: "../php/isExistUser.php",
    data: params,
    dataType: "json",
})

const isExistPhone = (params = {}) => request({
    // type: "get",
    url: "../php/isExistPhone.php",
    data: params,
    dataType: "json",
})

const isExistEmail = (params = {}) => request({
    // type: "get",
    url: "../php/isExistEmail.php",
    data: params,
    dataType: "json",
})


const register = (params = {}) => request({
    type: "post",
    url: "../php/register.php",
    data: params,
    dataType: "json",
})

const login = (params = {}) => request({
    type: "post",
    url: "../php/login.php",
    data: params,
    dataType: "json",
})

const searchOrderLimit = (params = {}) => request({
    type: "get",
    url: "../php/searchOrderLimit.php",
    data: params,
    dataType: "json",
})

const searchGoodById = (params = {}) => request({
    type: "get",
    url: "../php/searchGoodById.php",
    data: params,
    dataType: "json",
})


const deleteGradeById = (params = {}) => request({
    type: "get",
    url: "../php/deleteGradeById.php",
    data: params,
    dataType: "json",
})

const updateGradeById = (params = {}) => request({
    type: "post",
    url: "../php/updateGradeById.php",
    data: params,
    dataType: "json",
})

const addToShoppingCar = (params = {}) => request({
    type: "post",
    url: "../php/addToShoppingCar.php",
    data: params,
    dataType: "json",
})

const searchShoppingCarByUser = (params = {}) => request({
    type: "get",
    url: "../php/searchShoppingCarByUser.php",
    data: params,
    dataType: "json",
})

const deleteShoppingCarByUser = (params = {}) => request({
    type: "get",
    url: "../php/deleteShoppingCarBySid.php",
    data: params,
    dataType: "json",
})
