/* adaptive nightmare */

$(document).ready(function () {
    $('.add-to-cart').click(function () {
        ym(269955, 'reachGoal', 'addcart');
    });
    $('.buy1click').click(function () {
        ym(269955, 'reachGoal', 'open1ck');
    });
    $('.buy-one-click input[type=submit]').click(function () {
        ym(269955, 'reachGoal', 'send1ck');
    });

});

$(document).ready(function () {


    $('select[name=sort]').change(function () {
        document.location.href = $('#sortirovka option:selected').attr('data-href');
        //location.href="?sort="+$(this).val();
    });


    $('select[name=count]').change(function () {
        console.log('select[name=count]');
        if (location.search == '') {
            location.href = "?count=" + $(this).val();
        } else {
            //location.search +='&count='+$(this).val();
            location = $(this).parents('.count').find('select[name=count] option[value=' + $(this).val() + ']').data('href');
        }
        //
        //location="?count="+$(this).val();
    });

    $('select').niceSelect();
    /*
        $('.top-menu').prepend('<div class="super-top"><a class="mobile-change-city">Барнаул</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+7 (3852) 36-40-80<br>пр-т Строителей, 94<a href="/cart/"><div class="cart"><div class="qty">0</div><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></div></a></div>');
        $('.top-menu').prepend('<div class="super-top__change-city"><div><a href="http://nsk.znakooo.ru">Новосибирск</a></div><div>Барнаул</div><div class="clear"></div></div>');
    */
    $('.header').append('<div class="portrait-search-icon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>');
    $('.header').append('<div class="portrait-catalog-icon"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></div>');
    $('body').append('<div class="openCat"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></div><div class="adapCat"><div class="closeMe"></div></div>');
    $('.footer').before('<div class="adapTt"></div>');
    $('.lb .catalog').clone(true).appendTo('.adapCat');
    $('.three-Things').clone(true).appendTo('.adapTt');


    // $('.catalog li.parent').click(function(){
    // 	var thisLi = $(this);
    // 	if (thisLi.find('.sub-catalog').is(':hidden')) {
    // 		thisLi.addClass('opened');
    // 		$('.adapCat .sub-catalog').hide('fast');
    // 		thisLi.find('.sub-catalog').show('fast');
    // 	} else {
    // 		thisLi.removeClass('opened');
    // 		thisLi.find('.sub-catalog').hide('fast');
    // 	}
    // });


    //категории
    $('.catalog li.parent>a').click(function (e) {
        e.preventDefault();
        var thisLi = $(this);
        if ($('.catalog li.parent a').next('.sub-catalog').hasClass('active-sub')) {
            $('.sub-catalog').removeClass('active-sub');
        }
        ;

        thisLi.next('.sub-catalog').addClass('active-sub');

    });

    $('.sub-catalog__close').click(function (e) {
        console.log($(e.target).closest('.sub-catalog'));
        $(e.target).closest('.sub-catalog').toggleClass('active-sub');
    });
    //


    $('.adapCat .parent > a').on('click', function (e) {
        e.preventDefault();
    });
    $('.portrait-catalog-icon, .openCat').click(function () {
        $('.adapCat').fadeIn('fast');
    });
    $('.closeMe').click(function () {
        $('.adapCat').fadeOut('fast');
    });
    $('.portrait-search-icon').click(function () {
        $('.header .search #title-search-input').slideToggle('fast');
    });
});


$(document).ready(function () {
    // убираем подчеркивание у картинок
    $('a').each(function () {
        var thisA = $(this);
        if (thisA.find('img').length) {
            thisA.addClass('no-border-bottom');
        }
    });

    // появляется кнопка Найти
    $('.header .search input').focus(function () {
        $(this).parent().find('.submit').show();
    }).blur(function () {
        $(this).parent().find('.submit').hide();
    });

    // категории
    // $('.catalog li.parent').mouseenter(function(){
    // 	if ($(window).width() > 1200) {
    // 		var thisLi = $(this);
    // 		if (thisLi.find('.sub-catalog').length) {
    // 			thisLi.find('.sub-catalog').show();
    // 		}
    // 	};
    // }).mouseleave(function(){
    // 	if ($(window).width() > 1200) {
    // 		var thisLi = $(this);
    // 		if (thisLi.find('.sub-catalog').length) {
    // 			thisLi.find('.sub-catalog').hide();
    // 		}
    // 	};
    // });

    $('.catalog .title').click(function () {
        if ($(window).width() < 1200) {
//			if ($('.catalog ul.parent').is(':hidden')) {
            $('.catalog ul.parent').slideToggle('fast');
//			} else {
//				$('.catalog ul.parent').slideUp('fast');
//			};
        }
        ;
    });

    $('.advices-page .item').mouseenter(function () {
        $(this).find('.item-bg').stop().fadeIn('fast');
        $(this).find('.title').stop().animate({top: '33px'}, 'fast');
        $(this).find('.txt').stop().show().animate({top: '63px'}, 'fast');
    }).mouseleave(function () {
        $(this).find('.item-bg').stop().fadeOut('fast');
        $(this).find('.title').stop().animate({top: '173px'}, 'fast');
        $(this).find('.txt').stop().hide().animate({top: '203px'}, 0);
    });

    $('.consultation').click(function () {
        $('.contact-form-modal.orderCall, .black-bg').css('display', 'block');
    });

    //  $('.buy1click').click(function(){
    $('.wrapper').on('click', '.buy1click', function () {
        $('.buy-one-click, .black-bg').css('display', 'block');
        var productID = $(this).data('prod')
        $('.buy-one-click').find('input[name=product]').val(productID);
    });
    $('.black-bg, .close').click(function () {
        if ($(this).hasClass('black-bg_white')) return false;

        $('.contact-form-modal, .black-bg, .contact-success-modal').css('display', 'none');
        location.reload();
    });

    // помещаем в мобильную корзину кол-во товаров при загрузке
    var m_pQty = $('.header .quantity').html().slice(0, 2);
    $('.top-menu .qty').html(m_pQty);

    //$('.add-to-cart').click(function () {
    $('.wrapper').on('click', '.add-to-cart', function () {
        var id = $(this).attr('rel');
        if (!$(this).hasClass('btn_combo')) {
            //если добавляем в корзину не комбо-набор
            var quant = $('#quant' + id).val();


            var product = $(this).closest('.product'),
                modal = $('.modal-add'),
                name = $(product).find('.name').text(),
                image = $(product).find('.image img').clone(),
                link = $(product).find('.name a').attr('href');
            $(modal).find('.modal-add__name').text(name);
            $(modal).find('.modal-add__image').html(image);
            $(modal).find('.modal-add__content a').attr('href', link);
            $(modal).addClass('modal-add_animated');
            $('.black-bg').addClass('black-bg_white');

            setTimeout(function () {
                $(modal).removeClass('modal-add_animated');
                $('.black-bg').removeClass('black-bg_white');
            }, 2000)

            if (!quant) quant = 1;


            $.ajax({
                type: "POST",
                url: "/ajx/add2cart.php",
                data: "id=" + id + "&quant=" + quant,
                success: function (msg) {
                    if (msg != 0) {
                        $("#cart").html(msg);
                        var beginPos = msg.indexOf('quantity') + 10;
                        var endPos = msg.indexOf('товар') - 1;
                        var productQty = msg.substring(beginPos, endPos);
                        //alert(productQty);
                        $('.top-menu .qty').html(productQty);
                        $('.header-fix').html('');
                        $('.header-fix').append($('.header').clone());
                    }
                }
            });

        } else {
            //если добавляем в корзину комбо-набор
            var ids = id.split(',');
            ids.forEach(function (item, i, arr) {
                $.ajax({
                    type: "POST",
                    url: "/ajx/add2cart.php",
                    data: "id=" + item + "&quant=" + 1,
                    success: function (msg) {
                        if (msg != 0) {
                            $("#cart").html(msg);
                            var beginPos = msg.indexOf('quantity') + 10;
                            var endPos = msg.indexOf('товар') - 1;
                            var productQty = msg.substring(beginPos, endPos);
                            //alert(productQty);
                            $('.top-menu .qty').html(productQty);
                            $('.header-fix').html('');
                            $('.header-fix').append($('.header').clone());
                        }
                    }
                });
            });
            alert("Комбо-набор добавлен");
        }
        return false;
    });
    //$('.vacancies-page .form-table').wrap('<form enctype="multipart/form-data" method="POST" action="" id="vac">');

    //$('#pricewrap').wrap('<form enctype="multipart/form-data" method="POST" action="" id="optprice">');
    //$('#dostpricewrap').wrap('<form enctype="multipart/form-data" method="POST" action="" id="dostprice">');
    // $('#feedbackwrap').wrap('<form enctype="multipart/form-data" method="POST" action="" id="feedback">');
    //$('#faqwrap').wrap('<form enctype="multipart/form-data" method="POST" action="" id="faq">');
    $('.filters').wrap('<form name="_form" action="" method="get" class="smartfilter">');
    //$('select[name=sort]').wrap('<form  action="" method="get" id="sort">');
    $('select[name=count]').wrap('<form  action method="get" id="count">');

    // $('select[name=sort]').change(function(){
    // 		document.location.href = $('#sortirovka option:selected').attr('data-href');
// 		//location.href="?sort="+$(this).val();
    // });


    $('a.fancybox').fancybox({
        "padding": 0
    });
    $('#basket input[type=submit]').click(function () {
        var a = true;
        $('#basket input').each(function () {
            if ($(this).val() == '') {
                $(this).css('border', "1px solid red");
                a = false;
            } else {
                $(this).css('border', "1px solid rgb(148,150,152)");
            }
        });
        if (a) {
            var fio = $('#basket input[name=fio]').val();
            var phone = $('#basket input[name=phone]').val();
            var email = $('#basket input[name=email]').val();
            $.ajax({
                type: "POST",
                url: "/ajx/order.php",
                data: "fio=" + fio + "&phone=" + phone + "&email=" + email,
                success: function (msg) {
                    if (msg != 0) {
                        $('#cart').html('	<div class="bg"></div><div class="link-to-cart">В вашей <a href="/cart/" class="g-ffffff">корзине</a></div><div class="quantity">0 товаров</div><div class="order"><a href="/cart/" class="g-ffffff">Оформить заказ</a> &rarr;</div>');
                        $('.black-bg, .contact-success-modal').fadeIn(500);
                    }
                }
            });
        }
        return false;
    });


    $('.contact-form-modal input[type=submit]').click(function () {

        var currForm = $(this).parents('.contact-form-modal');
        var a = true;
        //рег. выражение для e-mail
        var reg_mail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        //рег. выражение для телефона
        var reg_phone = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
        currForm.find('input,textarea,[data-agree-checkbox]').each(function () {
            if (
                ($(this).attr('type') =='checkbox' && !$(this).is(':checked'))
                || $(this).val() == ''
                || (reg_mail.test($(this).val().trim()) == false && $(this).attr('name') == 'email')
                || (reg_phone.test($(this).val()) == false && $(this).attr('name') == 'phone')
            ) {
                $(this).css('outline', "1px solid red");
                $(this).css('border', "1px solid red");
                a = false;
            } else {
                $(this).css("border", "1px solid rgb(148,150,152)");
                $(this).css('outline', "none");
            }
        });
        if (a) {
            var formFields = currForm.find('input,textarea').serialize();
            $.ajax({
                type: 'POST',
                url: '/ajx/feedback.php',
                data: formFields,
                success: function (datta) {
                    //$('.contact-form-modal').fadeOut(0);
                    currForm.fadeOut(0);

                    $('.black-bg, .contact-success-modal').fadeIn(0);
                    $('.black-bg, .contact-success-modal').fadeOut(4000);
                }
                //+'Спасибо!! Ваша заявка принята.'
            });

        }
        return false;
    });

    $('#faqwrap input[type=submit]').click(function () {
        var a = true;
        //рег. выражение для e-mail
        var reg_mail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        //рег. выражение для телефона
        var reg_phone = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
        $('#faqwrap input, #faqwrap textarea').each(function () {
            if ($(this).val() == '' ||
                (reg_mail.test($(this).val().trim()) == false && $(this).attr('name') == 'email') ||
                (reg_phone.test($(this).val()) == false && $(this).attr('name') == 'phone')) {
                $(this).css('border', "1px solid red");
                a = false;
            } else {
                $(this).css("border", "1px solid rgb(148,150,152)");
            }
        });
        if (a) {
            var formFields = $('#faqwrap input,#faqwrap textarea').serialize();
            $.ajax({
                type: 'POST',
                url: '/ajx/faq.php',
                data: formFields,
                success: function (datta) {
                    $('.contact-form-modal').fadeOut(0);
                    $('.black-bg, .contact-success-modal').fadeIn(0);
                }
                //+'Спасибо!! Ваша заявка принята.'
            });

        }
        return false;
    });
    // if($('[name=phone]').length > 0){
    //     $('[name=phone]').mask('+7-999-999-99-99');
    // }


    //фильтр
    $('.f-ilter__submit__show').on('click', function () {

        var values = [];
        values.push("set_filter=y");

        //собираем выставленные значения
        $(".filterValue").each(function (indx, element) {

            if ($(element).hasClass('filterPrice')) {
                values.push($(element).data('prop') + '=' + $(element).val());
            }

            if ($(element).is(':checked')) {
                values.push($(element).data('prop') + '=Y');
            }

        });
        //переводим в строку полученные значения
        var filter_params = values.join('&');
        //добавляем как параметры к url
        window.location.search = filter_params;

        return false;
    });
    $('.f-ilter__submit__reset').on('click', function () {
        window.location.search = "";
        return false;
    });

    $('.f-ilter__more').on('click', function () {
        $(this).closest('.f-ilter__block').toggleClass('f-ilter__block_more');
    })

    $('[data-toggletext]').on('click', function () {
        var data = $(this).data('toggletext'),
            text = $(this).text();
        $(this).text(data);
        $(this).data('toggletext', text);
    });

    $('.f-ilter__open').on('click', function () {
        $('.f-ilter').slideToggle();
    })
});
(function ($) {

    $(function () {

        $('.jcarousel').jcarousel();

        //$('.jcarousel').jcarouselAutoscroll({
        //interval: 6000
        //});

        $('.jcarousel').jcarousel({
            wrap: 'circular'
        });


        $('.logos-list-main-control-next')
            .on('jcarouselcontrol:active', function () {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function () {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-control').each(function () {
            var targetSelector = $(this).data('target-selector'),
                target = $(targetSelector);

            $(this).jcarouselControl({
                target: target
            });
        });

    });

    setTimeout(function () {
        $('.price-range__range').ionRangeSlider({
            type: "double",
            hide_min_max: true,
            hide_from_to: true,
            step: 10
        });

        var range = $('.price-range__range').data("ionRangeSlider");

        if (typeof range == 'undefined') {
            return 0;
        }
        setRange(range);

        $('.price-range__range').on('change', function () {
            setRange(range)
        });

        var timer;

        $('.price-range__inputs input').on('keyup', function (e) {

            e.preventDefault();
            var val = $(this).val(),
                index = $(this).parent().index();
            if (timer) clearTimeout(timer);

            timer = setTimeout(function () {
                if (index === 0) {
                    range.update({
                        from: val
                    });
                } else {
                    range.update({
                        to: val
                    });
                }
            }, 500);

        });

        //$('select').niceSelect();

    }, 1000)

    function setRange(range) {
        var from = range.result.from,
            to = range.result.to;

        $('.price-range__inputs input').each(function (i, input) {
            var val = (i === 0) ? from : to;
            $(input).val(val);
        });
    }

//стрелка "наверх в каталоге"
    $(window).scroll(function () {
        var win_h = $(window).height() * 2;
        if ($(this).scrollTop() > win_h) {
            if ($('.arrowUp').is(':hidden')) {
                $('.arrowUp').css({opacity: 1}).fadeIn('slow');
            }
        } else {
            $('.arrowUp').stop(true, false).fadeOut('fast');
        }
    });


})(jQuery);
