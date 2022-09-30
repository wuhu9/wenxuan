$(async function () {

    var lgc = getCookie("lgc");
    if (lgc) {
        $('.user').text(lgc);
        $('.reg').css({ display: "none" })
    }


    //购物车渲染
    $(async function () {
        var lgc = getCookie("lgc");

        if (lgc) {
            var result = await searchShoppingCarByUser({ user: lgc });
            console.log(result);
            var { status, message, list } = result;

            if (status) {
                if (list) {

                    var html = "";
                    list.forEach(({ id, gid, title, img, price, num }) => {
                        html += `<tr class="par" data-id="${id}" >
                        <td class="checkbox"><input class="check-one check" type="checkbox" /></td>
                        <td class="goods"><img src="${img}" alt="" /><span>${title}</span></td>
                        <td class="price">${price}</td>
                        <td class="count"><span class="reduce"  data-id="${id}"></span>
                            <input class="count-input" type="text" value="${num}" />
                            <span class="add"  data-id="${id}">+</span>
                        </td>
                        <td class="subtotal">${price.substring(1, price.length)}</td>
                        <td class="operation"><span class="delete"  data-id="${id}">删除</span></td>
                    </tr>`
                    })
                    $("tbody").html(html);
                } else {
                    // 还未购买任何商品!!!
                }
            } else {
                alert(message);
            }

            $(document).on("click", ".fl", async function () {
                console.log($(".check-one:checked").parent().parent().attr("data-id"));
                var list = $(".check-one:checked").parents("tr").map(function () {
                    return $(this).attr("data-id")
                }).get();
                console.log(list);
                if (list.length > 0) {
                    var result = await deleteShoppingCarBySid({ id: list.join(",") })
                    var { status, message } = result;
                    if (status) {
                        $(".check-one:checked").parents(".par").remove();
                    }
                }
            })



        } else {
            // 没有登录 => 去登录 => 按照正常流程登录成功去主页面 => 有问题?
            // 怎么解决?
            // 跳转登录的同时携带数据 ReturnUrl=当前页面url => 登录页就会有数据?
            // 1. 登录页没有数据ReturnUrl => 去主页面3
            // 2. 有数据  ReturnUrl  => 回ReturnUrl对应的地址
            // location.href = "../html/honor_login.html?ReturnUrl=" + encodeURIComponent(location.href);
        }






        //购物车操作

        $(".check-all").click(function () {
            // 全选状态
            // var status = this.checked;  // 原生(元素节点的属性)

            var status = $(this).prop("checked");
            console.log(status);

            $(".check-one").prop("checked", status);

            getTotal();
        })

        $(".check-one").click(function () {
            // 是否反选
            // 选中单选框 和 所有的单选数量相同

            //  $(".check-one:checked")  选中状态的check-one
            var flag = $(".check-one:checked").length === $(".check-one").length ? true : false;
            flag = $(".check-one").length > 0 ? flag : false;

            $(".check-all").prop("checked", flag);
            getTotal();
        })

        $(".delete").click(function () {
            let id = $(this).attr("data-id")
            console.log($(this).attr("data-id"));
            if (confirm("是否删除当前商品?")) {
                $(this).parents(".par").remove();
                deleteShoppingCarByUser({id:id});
                location.reload()
                isAllChecked();
                getTotal();
            }
        })

        $("#deleteAll").click(function () {
            if (confirm("是否删除选中商品?")) {
                $(".check-one:checked").parents(".trow").remove();
                isAllChecked();
                getTotal();
            }
        })

        $(".add").click(function () {
            var num1 = $(this).prev().val();
            num1++;
            let id = $(this).attr("data-id");
            console.log(id);
            $(this).prev().val(num1);
            addToShoppingCar({
                user: lgc,
                gid: id,
                num:1,
            })
            var price = $(this).parent().prev().text();
            var subtotal = (num1 * price.substring(1, price.length)).toFixed(2);
            $(this).parent().next().text(subtotal);


            $(this).prevAll(".reduce").text("-");
            getTotal();
        })


        $(".reduce").click(function () {
            var num = $(this).next().val();
            if (num <= 1) return false;
            num--;
            let id = $(this).attr("data-id");
            if (num == 1) {
                $(this).text("");
            }
            addToShoppingCar({ num: -1, user: lgc, gid: id })
            $(this).next().val(num);

            var price = $(this).parent().prev().text();
            var subtotal = (num * price.substring(1, price.length)).toFixed(2);
            $(this).parent().next().text(subtotal);

            getTotal();
        })

        function getTotal() {
            var sum = 0;
            var allPrice = 0;
            $(".check-one:checked").each(function () {
                var parenTr = this.parentElement.parentElement;
                var countInput = parenTr.getElementsByClassName("count-input")[0];
                var subtotalTd = parenTr.getElementsByClassName("subtotal")[0];
                var num = countInput.value * 1;
                var subtotal = subtotalTd.innerHTML * 1;

                sum += num;
                allPrice += subtotal;
            })
            $("#selectedTotal").text(sum);
            $("#priceTotal").text(allPrice.toFixed(2));
        }



        function isAllChecked() {
            // var flag = $(".check-one:checked").length === $(".check-one").length ? true : false;
            // flag = $(".check-one").length > 0 ? flag : false;
            // $(".check-all").prop("checked", flag);

            var flag = $(".check-one").is(":not(:checked)") ? false : true;   //是否存在未选中的单选框
            flag = $(".check-one").length > 0 ? flag : false;
            $(".check-all").prop("checked", flag);


        }




        $('.closing').click(function () {
            alert('结算功能请关注后续更新')
        })


    })





})
