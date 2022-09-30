$(function () {

    /* cookie账号显示 */

    var lgc = getCookie("lgc");
    if (lgc) {
        $('.user').text(lgc);
        $('.reg').css({ display: "none" })
    }






    /* 轮播图 */

    $(function () {

        var swiperWidth = $(".banner").width();
        var index = 0; // 全局变量 记录轮播的下标
        var timer = null; // 记录计时器的编号

        // 点击切换
        // 1. nav li 和 section .part  下标一一对应  => 点击对应的点 => 显示对应的图片
        // 2. 点击对应的点 => 下标和图片向左偏移的的数量对应

        autoPlay(); //页面加载时 自动轮播
        tab();
        search();

        $(".nav li").click(function () {
            index = $(this).index();
            $(this).addClass("active").siblings().removeClass("active");
            $(".img-wrap").animate({ left: -swiperWidth * index }, 500);
        })

        $(".banner").hover(function () {
            clearInterval(timer);
        }, function () {
            autoPlay();
        })


        function autoPlay() {
            clearInterval(timer);
            timer = setInterval(function () {
                index++;

                // 问题1：图片向左滚动到第四张,又从第四种直接回滚第一张 => 不好看
                // 0 1 2 3 => 0   
                // 解决方法: 障眼法
                // a. 在第四张之后 添加 第五张图片(同第一张) => 当第四张滚动到第五张(看起来像第四张滚动到第一张)
                // b. 每次滚动完之后 判断是否是第五张(四切五) => 瞬间切回第一张

                // 问题2:
                // 有五张图片 但是之后四个点(0 1 2 3)  => 切换到第五张图片, 点怎么显示?
                // 解决方法: 如果是第五张 把第一个点变为活跃状态

                var activeIndex = index >= $(".nav li").length ? 0 : index;
                $(".nav li").eq(activeIndex).addClass("active").siblings().removeClass("active");

                $(".img-wrap").animate({ left: -swiperWidth * index }, 500, function () {
                    if (index >= $(".nav li").length) {
                        $(".img-wrap").css({ left: 0 });
                        index = 0;
                    }
                });


            }, 3000);

        }

        function tab() {
            $('.tab-item').on('click', function () {
                $(this).addClass('active').siblings().removeClass('active').parents().next().children().removeClass('show').eq($(this).index()).addClass('show');
            })
        }

        function search(){
            $(".search-click").click(function(){
                let kw = $(".keyword").val();
                console.log(kw);
                location.href=`../html/list.html?kw=${kw}`
            })
        }   
    })


})
