$(document).ready(function() {
    function clickshow() {
        var data_filter;
        var listProduct = $('.products__list');
        var  dataInit = new Object(),
             ajaxData = new Object();
        thisElem = $(this);
        dataInit = listProduct.data('showmore').split(',');

        ajaxData['page'] = listProduct.data('page');
        ajaxData['allpages'] = dataInit[0];
        ajaxData['idsection'] = dataInit[1];
        ajaxData['elems'] = dataInit[2];
        ajaxData['sort_field'] = dataInit[3];
        ajaxData['sort_order'] = dataInit[4];

        var nextPage = ajaxData['page']+1;
        data_filter =location.search.toString();
        if (data_filter==''){
            data_filter += '?PAGEN_4='+nextPage+'&PAGEN_1='+nextPage+'&PAGEN_2='+nextPage+'&PAGEN_3='+nextPage;
        } else {
            data_filter += '&PAGEN_4='+nextPage+'&PAGEN_1='+nextPage+'&PAGEN_2='+nextPage+'&PAGEN_3='+nextPage;
        }


        //для постраничной навигации
ajaxData['url'] = window.location.pathname;
        $.ajax({
            type: 'POST',
            url: '/ajx/show_more.php'+data_filter,
            data: ajaxData,
            success: function(html) {
                $('.products_other').remove();

                listProduct.append(html);
                listProduct.data('page',nextPage);


                if (nextPage == ajaxData['allpages']){
                    thisElem.hide();
                }
            }
        });
        return false;
    }
    //$('.products__more').bind('click',clickshow());
//показать ещё
  $('.products').on('click','.products__more',function () {
      clickshow();
      return false;
  });

    $('body').on('click','.arrowUp',function() {
        $('html, body').stop().animate({scrollTop : 0}, 600);
    });

    $('.isNovosib .close').on('click',function () {
        $('.isNovosib').find('form').submit();
        return false;
    })

});