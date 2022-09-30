$(function () {

    /* cookie账号显示 */

    var lgc = getCookie("lgc");
    if (lgc) {
        $('.user').text(lgc);
        $('.reg').css({ display: "none" })
    }
 
    function search() {
        $(".search-click").click(function () {
            let kw = $(".keyword").val();
            console.log(kw);
            location.href = `../html/list.html?kw=${kw}`
        })
    }

    /*        渲染             */

    var kw = location.search;
    var wd = kw.split("?")[1].split("=")[1];  // 全局变量 搜索的关键词(默认查询所有)
    var col = "price"; // 全局变量 排序的列名(默认按id)
    var type = "asc"; // 全局变量 排序的方式(默认升序)
    var page = 1;   // 全局变量 记录页码(默认显示第一页)
    var size = 5;    // 全局变量 每页显示多少条 (默认5条)


    loadGrade();
    search();



    $('.tip').on("click", searchHandler);
    function searchHandler(e) {
        var e = e || window.event;
        var target = e.target || e.srcElement;
        // console.log(target);
        if (target.className == "orderType_one") {
            console.log(target.className);
            type = target.value;
            loadGrade();
        } else if (target.className == "orderType_two") {
            console.log(target.className);
            type = target.value;
            loadGrade();
        } else if (target.className == "resetGrade") {
            $('.orderType_one').prop('checked', true);
            wd = "";  // 全局变量 搜索的关键词(默认查询所有)
            col = "price"; // 全局变量 排序的列名(默认按id)
            type = "asc"; // 全局变量 排序的方式(默认升序)
            page = 1;   // 全局变量 记录页码(默认显示第一页)
            size = 5;    // 全局变量 每页显示多少条 (默认5条)
            loadGrade();
        }
    }

    $(".showSel").off().change(function () {
        size = $(this).val();
        // page = 1;
        loadGrade();
    });

    async function loadGrade() {   /*  按关键词搜索*/
        var result = await searchOrderLimit({ wd, col, type, page, size });
        var { status, message, list, total, maxPage, current } = result;
        console.log(current, wd, col, type, page, size);

        if (status) {
            if (list) {

                var html = "";

                list.forEach(({ id, title, img, price, priceo, author, press }) => {
                    html += `
                    <li>
                    <div class="cell">
                        <div class="img"> 
                            <a href="../html/details.html?id=${id}">
                                <img src="${img}"> 
                            </a>
                        </div>
                        <div class="price"> 
                            <span class="price-n">
                            ${price}
                            </span>
                            <span class="price-o">
                            ${priceo}
                            </span>
                        </div>
                        <div class="name">
                             <a>${title}</a> 
                        </div>
                        <div class="_author">
                             <a>${author}</a> 
                        </div>
                        <div class="publisher">
                             <a>${press}</a>
                        </div>
                    </div>
                </li>`
                })
                $('.group-ul').html(html);

                // 问题: 
                // 页码多的 向 页码少 的切换时,如果全局page超出 页码少的数据的maxPage => 切换过程也会出现问题

                // 解决方法:   如果超出最大页 就赋值为最大页 否则显示原页码
                page = page > maxPage ? maxPage : page;


                $('#page').text(`${current}/${maxPage}`);

                $('.prev').off().click(function () {
                    if (page <= 1) return false;
                    page--;
                    loadGrade();
                });
                $('.next').off().click(function () {
                    if (page >= maxPage) return false;
                    page++;
                    loadGrade();
                });

            } else {
                $('.group-ul').text("暂无数据");
            }
        }

    }


})
