$(async function () {

    /* cookie账号显示 */






    /* 详情页     对应商品渲染 */
    var id = window.location.search;;
    id = id.replace(/[^0-9]/ig, '')
    console.log(id);

    if (id) {

        // 对应编号获取数据
        var result = await searchGoodById({ id });
        console.log(result);

        // var label3;

        var { status, message, data: { id, title,img, price, priceo, author, press} } = result;


        if (status) {
            $(".product-intro").html(`<div class="preview-wrap">
            <div class="preview">
                <img class="smallImg" src="${img}" alt="">
                <div class="shadow"></div>
            </div>
            <div class="preview-scale">
                <img class="bigImg" src="${img}" alt="">
            </div>
        </div>
        <!--absolute-->
        <div class="itemInfo-wrap">
            <div class="title">
            ${title}
            </div>
            
            <div class="price">
                <span>促&emsp;&emsp;&emsp;销</span>
                ${price}
            </div>
            <div class="promotion">
                <div class="left">价&emsp;&emsp;&emsp;格</div>
                <div class="right">
                    <span>${priceo}</span>
                    <span>${author}</span>
                    <span>${press}</span>
                </div>
            </div>
            <div class="addCar">
                <a href="javascript:;" class="addToShopingCar">加入购物车</a>
            </div>
        </div>`);


            // 等html放到页面中之后在获取元素和绑定事件




            var maxLeft = $('.preview').width() - $('.shadow').width();
            var maxTop = $('.preview').height() - $('.shadow').height();

            var scale = $('.bigImg').width() / $('.smallImg').width();



            //移入
            $('.preview').mouseenter(function () {
                $(".shadow").css({ display: 'block' })
                $(".preview-scale").css({ display: 'block' })
                maxLeft = $('.preview').width() - $('.shadow').width();
                maxTop = $('.preview').height() - $('.shadow').height();

                scale = $('.bigImg').width() / $('.smallImg').width();
            })
            //移动




            $(".preview").mousemove(function (e) {

                var e = e || window.event;
                // console.log(0);

                var x = e.pageX - $('.preview-wrap').offset().left - $('.shadow').width() / 2;
                var y = e.pageY - $('.preview-wrap').offset().top - $('.shadow').height() / 2;

                if (x < 0) x = 0;
                if (x >= maxLeft) x = maxLeft;
                if (y < 0) y = 0;
                if (y >= maxTop) y = maxTop;

                
                // 取值时记得去单位,赋值时记得加单位

                $(".shadow").css({ left: x + 'px' })
                $(".shadow").css({ top: y + 'px' })
                $(".bigImg").css({ left: -(scale * x) + 'px' })
                $(".bigImg").css({ top: -(scale * y) + 'px' })
                // shadow.style.left = x + "px";
                // shadow.style.top = y + "px";
                // bigImg.style.left = -scale * x + "px";
                // bigImg.style.top = -scale * y + "px";
            })






                //移出
            $('.preview').mouseleave(function () {
                $(".shadow").css({ display: 'none' })
                $(".preview-scale").css({ display: 'none' })
            })

        } else {
            location.href = "../html/list.html";
        }



    } else {
        // location.href = "../html/honor_goods.html";
    }

    // 加入购物车  => 需要知道哪些信息?

    // 谁  买了什么东西   买了多少件?
    // 谁           => 当前登录的用户
    // 买了什么东西  => 商品的id (根据id从goodslist找数据)
    // 买了几件      =>  页面中商品的数量

    $(document).on("click", ".addToShopingCar", async function () {
        console.log("准备加入购物车");

        var lgc = getCookie("lgc"); // 获取登录的用户

        if (lgc) {//用户已登录 => 购买 => 加入数据库
            // var buyNum = $(".countInput").val();

            var result = await addToShoppingCar({
                user: lgc,
                gid: id,
                num:1,
            })
            console.log(result);

            var { status, message } = result;

            if (status) {
                if (confirm("加入成功,是否跳转购物车?")) {
                    location.href = "../html/shoppingcar.html";
                }
            } else {
                alert(message);
            }
        } else {
            // 没有登录 => 去登录 => 按照正常流程登录成功去主页面 => 有问题?
            // 怎么解决?
            // 跳转登录的同时携带数据 ReturnUrl=当前页面url => 登录页就会有数据?
            // 1. 登录页没有数据ReturnUrl => 去主页面3
            // 2. 有数据  ReturnUrl  => 回ReturnUrl对应的地址
            location.href = "../html/login.html?ReturnUrl=" + encodeURIComponent(location.href);
        }

    })







})
