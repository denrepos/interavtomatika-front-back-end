var $ = jQuery.noConflict();

jQuery(function($){

    //correct content block height
    var content_height = $('.content').height();
    var aside_height =  $('aside').height();

    if($(window).width() > 639){
        $('.content').css('min-height',aside_height);
    }

    //correct height of category preview

    correctHeightInRow();

    $(window).resize(function(){
        $('.product-category-preview').css('height','');
        correctHeightInRow();
    });


    function correctHeightInRow() {
        var rows;
        if ($(window).width() > 1099) {
            rows = splitByRows('.product-category-preview', 3);
        } else if ($(window).width() > 819) {
            rows = splitByRows('.product-category-preview', 2);
        }else{
            $('.product-category-preview').css('height','');
        }

        if (rows) {
            for (var i = 0; i < rows.length; i++) {

                var height = rows[i].reduce(function (prevHeight, current) {
                    return $(current).height() > prevHeight ? $(current).height() : prevHeight;
                }, 0);
                $(rows[i]).height(height);
            }
        }
    }

    function splitByRows(selector,num){

        var previews = $(selector);

        var rows = [];
        for(var i = 0; previews.length; i++){
            rows[i] = previews.splice(0,num);
        }
        return rows;
    }

    //close popaps when click on body and so
    $('body').click(function(event) {

        if(!$(event.target).closest('.popup').length){

            if ($(window).width() >= 530 && $(window).width() <= 767) {
                $('.popup').not('.additional-contacts').fadeOut(200);
            } else {
                $('.plus-before').removeClass('minus-before');
                $('.popup').fadeOut(200, function () {
                    $(this).css('display', '')
                });
            }
        }
    });

    //show language popup
    $('.current-language').click(function(e){
        $('.language-switch-hidden').fadeIn(200);
        e.stopPropagation();
    });

    //show more contacts block
    $('#more-contacts').click(function(e){

        var selector = $(this).data('hide-show');

        var block = $(selector);

        if (block.is(':visible')) {
            $('.plus-before').removeClass('minus-before');
            block.fadeOut(200);
        } else {
            $('.plus-before').addClass('minus-before');
            block.fadeIn(200);
        }
        e.stopPropagation();
    });

    //show minimized menu
    $('#main-menu-button').click(function(e){

        $(this).next().slideToggle();
        $('.opacity').css('z-index','20').fadeIn();
        e.stopPropagation();
    })

    //show first block of catalog menu
    $('.catalog-menu').click(function(){

        if(!$('.submenu').length) {
            var offset = $(this).offset();

            var y = offset.top + $(this).height() + 3;

            $('.opacity').fadeIn(200);

            makeSubmenu(false, offset.left, y);
            $('.submenu').fadeIn(200);
        }else{
            $('.submenu').fadeOut(function(){$(this).remove()});
            $('.opacity').fadeOut();
        }
    });

    //add submenu to catalog menu
    $('.absolute-elements').on('click','.submenu-item',function(){

        var thisHasClassActive = $(this).hasClass('active');
        var a = $(this).find('a');
        var x,y;

        if(a[0]){
            window.location = a.attr('href');
            return;
        }

        var offset = $(this).offset();
        var dp = String($(this).closest('ul').data('path'));
        var submenusDel = $('ul[data-path^='+dp+']').slice(1);

        var heightDel = 0;
        if(submenusDel[0]) {
            heightDel = $(submenusDel[0]).outerHeight();
        }



        submenusDel.fadeOut(100,function(){$(this).remove()});

        deactivateItem($(this).closest('ul').find('.active'));


        if($(window).width() <= 1099){

            var ul = $(this).closest('ul');
            var leftIndent = 20;
            var width = ul.width() - leftIndent;

            x = offset.left + leftIndent;
            y = offset.top + $(this).outerHeight();

            var siblinSpace =  $(this).prevAll('.submenu-space');

            if(siblinSpace.length){
                y -= siblinSpace.outerHeight();
            }

            $(this).next().siblings('.submenu-space').slideToggle(function(){$(this).remove()});

            var sm_height = 0;

            if(!thisHasClassActive){
                sm_height = makeSubmenu(this,x,y,width).outerHeight();
            }else{
                deactivateItem($(this));
            }

            if(!$(this).next('.submenu-space')[0]) {
                $(this).after('<li class="submenu-space" style="height:' + sm_height + 'px;display:none"></li>').next().slideToggle();
            }

            var dpLength = String(dp).length;

            $('.submenu-space').each(function(index){


                var currentPathLength = String($(this).closest('ul').data('path')).length;

                if(currentPathLength<=dpLength) {

                    if ($(this).siblings('.submenu-space')[0]) {
                        heightDel = 0;
                    }

                    var finallyHeight = $(this).outerHeight() + sm_height - heightDel;
                    $(this).animate({height: finallyHeight + 'px'}, 300, function () {

                        if(finallyHeight < 3){
                            $(this).remove();
                        }

                        $('.submenu').fadeIn(150);

                    });
                }
            });

        }else{

            x = offset.left + $(this).closest('ul').width() + 3;
            y = offset.top;

            makeSubmenu(this,x,y);
            $('.submenu').fadeIn(300);
        }
        if(sm_height != 0){
            activateItem($(this));
        }
    });

    function activateItem(item){
        item.addClass('active');
        if($(window).width() < 1100) {
            item.find('.submenu-item-arrow').removeClass('glyphicon-menu-right').addClass('glyphicon-menu-up');
        }
    }

    function deactivateItem(item){
        item.removeClass('active');
        if($(window).width() < 1100) {
            item.find('.submenu-item-arrow').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-right');
        }
    }

    //click on opacity actions
    $('.absolute-elements').on('click','.opacity',function(){
        $('.submenu').fadeOut(300,function(){$('.submenu').remove();});
        $('.main-menu-items-for-button').fadeOut(200);
        $('.opacity').fadeOut(function(){$(this).css('z-index','')});
    });

    // scroll to top
    $('.upstairs-button').click(function(){
        $('body,html').stop().animate({scrollTop:0}, '500', 'swing');
    });

    //
    $('.banner-carousel-img-wrap img').click(function(){
        $('#image-modal .modal0-dialog').width($(this).width());
        $('#image-modal .modal0-dialog .modal-content').width($(this).width());
        $(this).attr('src');
    });

    //
    $('.banner-carousel-img-wrap img').click(function(){

        var title = $(this).closest('.item').find('.banner-carousel-title a').text();

        $.colorbox({
            href:$(this).attr('src'),
            className: 'certificate',
            opacity: 0.5,
            close: '×',
            title: title,
            transition: 'fade',
            initialWidth: 50,
            initialHeight: 100,
            fixed: true,
            onComplete: function(){$('#colorbox')[0].style.setProperty( 'visibility', 'visible', 'important' );}
        });

    })

    //init preview slider

    PreviewSlider.init();

    //clear search field when focus

    $('.header-search input').focus(function(){$(this).val('')});

    //expand search field

    var headerSearchFocus = false;
    var headerSearchWidth;
    var headerSearchPaddingLeft;
    var headerSearchMarginLeft;

    $(window).on('resize load',function(){

        headerSearchWidth = $('.header-search').css('width');
        headerSearchPaddingLeft = $('.header-search').css('padding-left');
        headerSearchMarginLeft = $('.header-search').css('margin-left');

    });


    $('.header-search').on('click focusout',function (e) {

        var self = this;
        var maxWidth479 = $(window).width() <= 479;
        var clickButton = false;

        if(e.type == 'click' && maxWidth479) {

            if(headerSearchFocus && e.target.localName == 'button'){
                $(this).find('input').val('search');
                headerSearchFocus = false;


            }else if(!headerSearchFocus) {
                $(this).animate({
                    width: '100%',
                    'padding-left': 0,
                    'margin-left': 0
                })
                    .addClass('expanded').find('input').val('').focus();
                headerSearchFocus = true;
            }

        }else
        if(e.type == 'focusout' && maxWidth479){


            if(headerSearchFocus) {

                $(self).animate({
                    width: headerSearchWidth,
                    'padding-left': headerSearchPaddingLeft,
                    'margin-left': headerSearchMarginLeft
                }, function () {
                    $(this).css({
                        width: '',
                        'padding-left': '',
                        'margin-left': '',
                        'text-align': ''
                    }).removeClass('expanded');
                });
                setTimeout(function(){
                    headerSearchFocus = false;
                },300);
            }
        }
    });

    // vertical align modal window of bootstrap

    (function ($) {
        "use strict";
        function centerModal() {
            $(this).css('display', 'block');
            var $dialog  = $(this).find(".modal-dialog"),
                offset       = ($(window).height() - $dialog.height()) / 2,
                bottomMargin = parseInt($dialog.css('marginBottom'), 10);

            // Make sure you don't hide the top part of the modal w/ a negative margin if it's longer than the screen height, and keep the margin equal to the bottom margin of the modal
            if(offset < bottomMargin) offset = bottomMargin;
            $dialog.css("margin-top", offset);
        }

        $(document).on('show.bs.modal', '.modal', centerModal);
        $(window).on("resize", function () {
            $('.modal:visible').each(centerModal);
        });
    }(jQuery));

    //sort another brands on banner

    $(".sort-button").click(function () {

        var desc;
        if($(this).hasClass('desc')){
            $(this).removeClass('desc');
            desc = false;
        }else{
            $(this).addClass('desc');
            desc = true;
        }

        var mylist = $('.banner.another-brands .banner-content .items-wrap');
        var listitems = mylist.children('div').get();
        listitems.sort(function(a,b) {

            if(desc){
                var temp = a;
                a = b;
                b = temp;
            }

            var compA = $(a).find('.brand-name').text().toUpperCase();
            var compB = $(b).find('.brand-name').text().toUpperCase();
            return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
        })
        $.each(listitems, function(idx, itm) { mylist.append(itm); });
    });

    //Show more brands
    $('.all-brands-page .manufacturers .general-button').click(function(){
        if($('.brand-previews-more:visible').is(':visible')){
            $('html, body').animate({scrollTop: $('.manufacturers-previews').offset().top - $(window).height()/6});
        }
        $('.brand-previews-more').slideToggle(function(){
            var button = $('.all-brands-page .manufacturers .general-button');
            if($(this).is(':hidden')){
                button.text(button.data('show-text'));
            }else{
                button.text(button.data('hide-text'));
            }
        });
    });

    //show articles/products in search results

    $('.found-title-wrap .look').click(function(){

        if($('.search-results-products').is(':visible')){
            $('.search-results-products').fadeOut();
            $('.found-articles-title').fadeOut(function(){
                $('.search-results-text').fadeIn();
                $('.found-products-title').fadeIn();
            });
        }else{
            $('.search-results-text').fadeOut();
            $('.found-products-title').fadeOut(function(){
                $('.search-results-products').fadeIn();
                $('.found-articles-title').fadeIn();
            });
        }
    });

    //make checkbox as radio
    $('.filter-brand .filter-item').click(function(){
        if($(this).find('input:checked')[0]){

            var changedElement = $('.filter-brand .filter-item input').not($(this).find('input')).filter(':checked');

            $('.filter-brand .filter-item input').not($(this).find('input')).prop('checked',false);

            changedElement.trigger('change');
        }
    });

    //

    //display checked filter items under title
    $('#filter input').change(function(){

        var chacked = $(this).is(':checked');
        var index = $(this).closest('.filter-item').index()+1;
        var name = $(this).closest('.filter-item').find('.item-name').text();
        var filterSetClass = $(this).closest('.filter-items').attr('data-filter-class');
        var filterParametersDelete = $('.filter-parameters-delete');
        var bodyHeight = $('body').height();

        if(chacked){
            var greaterItems = filterParametersDelete.find('.'+filterSetClass+' .item').filter(function(el,item){
                if(parseInt($(item).data('index')) > parseInt(index)){
                    return true;
                }else{
                    return false;
                }
            });

            if(greaterItems.length != 0){
                $(greaterItems[0]).before('<div class="item" data-index="'+index+'"><div class="cross-button"></div><span>'+name+'</span></div>');
            }else{
                filterParametersDelete.find('.'+filterSetClass).append('<div class="item" data-index="'+index+'"><div class="cross-button"></div><span>'+name+'</span></div>');
            }

        }else{
            filterParametersDelete.find('.'+filterSetClass).find('.item[data-index='+index+']').remove();
        }


        //if($(window).width() < 640) {
        //
        //    var scrollTop = $(window).scrollTop() + ($('body').height() - bodyHeight);
        //
        //    $('body,html').scrollTop(scrollTop);
        //}
    });

    //remove filter items

    $('.filter-parameters-delete').on('click','.item',function(e){

        var target = $(e.target).closest('.item');
        var filterSetClass = $(target).parent().attr('class');
        var index = $(target).data('index');

        $('.'+filterSetClass+' .filter-item:nth-child('+index+') input').prop('checked',false);
        $(target).remove();
    });

    //expand brands in filter
    $('.another-brands').click(function(){

        var hiddenItems = $('.filter-brand .filter-item').not(':visible');
        var filterItems = $('.filter-brand .filter-items');

        if(hiddenItems[0]) {

            var itemHeight = hiddenItems.first().outerHeight();

            var height = itemHeight * hiddenItems.length + filterItems.height();

            filterItems.animate({'height': height});

            hiddenItems.fadeIn();

        }else{

            var willHidden =  $('.filter-brand .filter-item:gt(6)');

            willHidden.fadeOut(function(){

                if(!willHidden.filter(':visible')[0]) {

                    var visibleItems = filterItems.find('.filter-item:visible');
                    var height = visibleItems.first().outerHeight() * visibleItems.length;

                    filterItems.animate({height: height});

                    $('body,html').animate({scrollTop:filterItems.offset().top-100}, '500', 'swing');
                }
            });

        }

    });

    // switch main images on product page

    $('.product-col-image .small-images .img-wrap').click(function(){

        $(this).append(
            $('.product-col-image .big-image img').replaceWith(
                $(this).find('img')
            )
        );
        magnifyingGlassEffect($('.product-col-image .big-image img'));
    });


    //magnifying glass effect on product page
    magnifyingGlassEffect($('.product-col-image .big-image img'));

    function magnifyingGlassEffect(jqObjqct) {
        var magnify_native_width = 0;
        var magnify_native_height = 0;
        var magnify_mouse = {x: 0, y: 0};
        var magnify;
        var magnify_cur_img;

        var ui = {
            magniflier: jqObjqct
        }

        // Добавляем увеличительное стекло
        if (ui.magniflier.length) {
            var div = document.createElement('div');
            div.setAttribute('class', 'glass');
            ui.glass = $(div);

            //$('body').append(div);
            ui.magniflier.parent().append(div);
        }

        // Определяем положение курсора
        var mouseMove = function (e) {
            var $el = $(this);

            // Получаем отступы до края картинки слева и сверху
            var magnify_offset = magnify_cur_img.offset();

            // Позиция курсора над изображением
            // pageX/pageY - это значения по х и у положения курсора от краев браузера
            magnify_mouse.x = e.pageX - magnify_offset.left;
            magnify_mouse.y = e.pageY - magnify_offset.top;

            // Увеличительное стекло должно отображаться только когда указатель мыши находится над картинкой
            // При отводе курсора от картинки происходит плавное затухание лупы
            // Поэтому необходимо проверить, не выходит ли за границы картинки положение курсора
            if (
                magnify_mouse.x < magnify_cur_img.width() &&
                magnify_mouse.y < magnify_cur_img.height() &&
                magnify_mouse.x > 0 &&
                magnify_mouse.y > 0
            ) {
                // Если условие истинно то переходим дальше
                magnify(e);
            }
            else {
                // иначе скрываем
                //ui.magniflier.css('opacity',1);
                //ui.glass.fadeOut(100);
            }

            return;
        };
        //    Следующим шагом является, расчет положения лупы над картинкой и положение изображения в лупе (т.к. увеличенная область изображения будет являться фоном для блока glass). После расчета полученные значения присваиваем CSS свойствам блока glass:

        var magnify = function (e) {

            // Основное изображение будет в качестве фона в блоке div glass
            // поэтому необходимо рассчитать положение фона в этом блоке
            // относительно положения курсора над картинкой
            //
            // Таким образом мы рассчитываем положение фона
            // и заносим полученные данные в переменную
            // которая будет использоваться в качестве значения
            // свойства background-position

            var rx = Math.round(magnify_mouse.x / magnify_cur_img.width() * magnify_native_width - ui.glass.width() / 2) * -1;
            var ry = Math.round(magnify_mouse.y / magnify_cur_img.height() * magnify_native_height - ui.glass.height() / 2) * -1;
            var bg_pos = rx + "px " + ry + "px";

            // Теперь определим положение самого увеличительного стекла
            // т.е. блока div glass
            // логика простая: половину ширины/высоты лупы вычитаем из
            // положения курсора на странице

            //var glass_left = e.pageX - ui.glass.width() / 2;
            //var glass_top  = e.pageY - ui.glass.height() / 2;

            // Теперь присваиваем полученные значения css свойствам лупы
            ui.glass.css({
                //left: glass_left,
                //top: glass_top,
                backgroundPosition: bg_pos
            });

            return;
        };

        // Движение курсора над изображению
        $(ui.magniflier).on('mousemove', function () {


            if(ui.magniflier[0].naturalWidth < ui.magniflier.parent().width() && ui.magniflier[0].naturalHeight < ui.magniflier.parent().height()){
                return;
            }

            // Плавное появление лупы
            ui.magniflier.animate({'opacity': 0}, 300);
            //ui.magniflier.next().animate({'opacity':0},300);
            ui.glass.fadeIn(300);
            // Текущее изображение
            magnify_cur_img = $(this);
            // определяем путь до картинки
            var src = magnify_cur_img.attr('src');
            // Если существует src, устанавливаем фон для лупы
            if (src) {
                ui.glass.css({
                    'background-image': 'url(' + src + ')',
                    'background-repeat': 'no-repeat'
                });
            }

            // Проверяем есть ли запись о первоначальном размере картинки magnify_native_width/magnify_native_height
            // если нет, значит вычисляем и создаем об этом запись для каждой картинки
            // иначе показываем лупу с увеличением

            if (!magnify_cur_img.data('magnify_native_width')) {

                // Создаем новый объект изображение, с актуальной идентичный актуальному изображению
                // Это сделано для того чтобы получить реальные размеры изображения
                // сделать напрямую мы этого не может, так как в атрибуте width указано др значение

                var image_object = new Image();

                image_object.onload = function () {

                    // эта функция выполнится только тогда после успешной загрузки изображения
                    // а до тех пор пока загружается magnify_native_width/magnify_native_height равны 0

                    // определяем реальные размеры картинки
                    magnify_native_width = image_object.width;
                    magnify_native_height = image_object.height;

                    // Записываем эти данные
                    magnify_cur_img.data('magnify_native_width', magnify_native_width);
                    magnify_cur_img.data('magnify_native_height', magnify_native_height);

                    // Вызываем функцию mouseMove и происходит показ лупы
                    mouseMove.apply(this, arguments);
                    ui.glass.on('mousemove', mouseMove);

                };

                image_object.src = src;

                return;
            } else {
                // получаем реальные размеры изображения
                magnify_native_width = magnify_cur_img.data('magnify_native_width');
                magnify_native_height = magnify_cur_img.data('magnify_native_height');
            }

            // Вызываем функцию mouseMove и происходит показ лупы
            mouseMove.apply(this, arguments);
            ui.glass.on('mousemove', mouseMove);
        });

        $(ui.glass).on('mouseleave', function () {
            ui.glass.fadeOut(300);
            ui.magniflier.animate({'opacity': 1});
            //ui.magniflier.next().animate({'opacity':1});
        });
    }

    //for scroll-button
    $('.scroll-button').click(function(){
        var scroll = $($(this).data('scroll-to')).offset().top - 30;
        $('body,html').stop().animate({scrollTop:scroll}, '500', 'swing');
    });

    //plus and minus one to product quantity
    $('.results-products-items .quantity .plus').click(function(){
        $(this).siblings('.number-field').val(parseInt($(this).siblings('.number-field').val())+1);
    });
    $('.results-products-items .quantity .minus').click(function(){
        var pn = parseInt($(this).siblings('.number-field').val());
        if(pn>1) $(this).siblings('.number-field').val(pn-1);
    });

    // 0 - value in quantity input if it is empty
    $('.results-product-item .number-field').on('focusout',function(){
        if(isNaN(parseInt($(this).val()))){
            $(this).val('0');
        }else{
            $(this).val(parseInt($(this).val()));
        }
    });

    //remove product in cart
    $('.results-products-items .delete-button').click(function(){
        if(confirm($(this).closest('.results-products-items').data('delete-confirm-text'))){
            if($('.results-product-item').length>1)$(this).closest('.results-product-item').remove();
        }
    });

    $('.modal-cart .delete-all-products').click(function(){
        if(confirm($(this).data('delete-confirm-text')))
            $(this).closest('.modal-body').find('.results-product-item').remove();
    });

    //bootstrap collapse feature customization

    $('.collapse-marker').each(function(){
        var target = $(this).data('target');
        if($(target).filter('.collapse').not('.in')[0]){
            $(this).addClass('collapsed');
        }
    });

    $('[data-toggle="collapse"]').click(function(){
        var target = $(this).data('target');

        if(!$(target).hasClass('in')){
            $('.collapse-marker').filter('[data-target="'+target+'"]').removeClass('collapsed');
        }else{
            $('.collapse-marker').filter('[data-target="'+target+'"]').addClass('collapsed');
        }

        var accordion = $(this).closest($(this).data('parent'));

        if(accordion[0]){
            accordion.find('.collapse-marker').not('[data-target="'+target+'"]').addClass('collapsed');
        }
    });

    //cancel event and highlight invalid input for .green-button (not .active )
    $('.green-button,.modal-content .send').click(function(e){
        var notValidate = $(this).closest('.panel .tab-pane.in, form').find('.input-required:not(.valid) input:visible:not(.disabled), .input-required:not(.valid) textarea:visible, .input-required:not(.valid) input:not(.disabled) ~ .required-highlight');
        if(notValidate[0]){
            notValidate.css({'background-color':'#fecccc'});
            e.stopImmediatePropagation();
            return false;
        }
    });

    //form validation

    var validationMasks = {
        phone:'^[0-9,\\-,(,),+,\\s]{10,}$',
        moreThen3Char:'^.{3,}$',
        email:'^[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$'
    }

    $('.ordering .next-button').click(function(){

        setTimeout(function() {

            $('.os-2-content .tab-pane.in form').each(function () {

                activeButtonIfAllValid($(this));
            });
        });

        if($(window).width() < 530){
            var scroll = $('.ordering .ordering-title').offset().top - 20;
            $('body,html').stop().animate({scrollTop:scroll}, '500', 'swing');
        }

    });

    $('.os-2-content ul.nav li div').on('shown.bs.tab',function(){
        $('.os-2-content .tab-pane.in form').each(function () {

            activeButtonIfAllValid($(this));
        });
    });

    $('.os-1-content, .os-2-content').on('hidden.bs.collapse',function(e){

        $(this).find('.input-required input[type=text]').css({'background-color':''});
        $(this).find('.required-highlight').css({'background-color':''});
    });

    $('.input-required input[type=text], .input-required textarea').on('input focus',function(){
        var regexp = validationMasks[$(this).data('validation-mask')];
        var val = $(this).val();

        if(val.match(regexp)){
            $(this).siblings('input').css({'background-color':''});
            $(this).css({'background-color':''}).closest('.input-wrap').removeClass('invalid').addClass('valid');
        }else{
            $(this).closest('.input-wrap').removeClass('valid').addClass('invalid');
        }

        activeButtonIfAllValid($(this).closest('form'));
    });

    $('.ordering .input-required input[type=radio]').on('click',function(){
        $(this).closest('.input-required').addClass('valid').find('.required-highlight').css({'background-color':''});
        activeButtonIfAllValid($(this).closest('form'));
    });

    $('.ordering .input-required input[type=text]').each(function(i){
        if($(this).val() != ''){
            $(this).focus().blur();
        }
        $('body,html').scrollTop(0);
    });

    $('.ordering .input-required input[type=radio]:checked').click();

    activeButtonIfAllValid($('.ordering form'));

    function activeButtonIfAllValid(form){

        var allInputWraps = form.find('.input-required:visible');
        var button = form.find('.next-button, .checkout-button', '.validate-button');

        if(allInputWraps.not('.valid')[0]){
            button.removeClass('active');
        }else{
            button.addClass('active');
        }
    }

    //switch between inputs in block
    $('.send-me-invoice input').focus(function(){
        $(this).removeClass('disabled');
        $('.send-me-invoice input').not(this).addClass('disabled');
    });

    // hide/show payment type depending on entity
    $('[data-target="#legal-entity"]').on('shown.bs.tab', function (e) {
        if($('.os-1-content').attr('aria-expanded') == 'false') {
            $('.os-edit-button.link-button').click();
        }
        $('.for-legal-entity').show();
        $('.for-individual-entity').hide();
    });
    $('[data-target="#individual-entity"]').on('shown.bs.tab', function (e) {
        if($('.os-1-content').attr('aria-expanded') == 'false') {
            $('.os-edit-button.link-button').click();
        }
        $('.for-legal-entity').hide();
        $('.for-individual-entity').show();
    });

    //custom select on cart page (choose city)
    $('.input-and-select-in-one input + ul li').click(function(){

        if($(this).hasClass('another')){
            $(this).closest('.input-wrap').find('input').val('').focus();
            $(this).parent().css({'max-height':0,'opacity':0});
        }else{
            $(this).closest('.input-wrap').find('input').val($(this).text()).trigger('input');
        }
    });

    $('.input-and-select-in-one .glyphicon-menu-down').click(function(){

        if($(this).closest('.input-wrap').find('ul').css('height') != '2px'){
            $(this).next().blur();
        }else{
            $(this).closest('.input-wrap').find('ul').css({'max-height':'','opacity':''});
            $(this).next().focus();
        }
    });

    $('.input-and-select-in-one input').on('focusout',function(){
        $(this).closest('.input-wrap').find('ul').css({'max-height':'','opacity':''});
    });

    //send invoice without shipping
    $('.send-invoice-without-shipping input').change(function(){
        if($(this).prop('checked')){
            $('#legal-entity .next-button').fadeOut();
            $('#legal-entity .checkout-block').fadeIn();
        }else{
            $('#legal-entity .next-button').fadeIn();
            $('#legal-entity .checkout-block').fadeOut();
        }
    });

    //hide / show comment on cart page

    $('.add-comment-title').click(function(){
        $(this).animate({'opacity':0},'fast',function(){
            var tmp = $(this).text();
            $(this).text($(this).data('text'));
            $(this).data('text',tmp).animate({'opacity':1},'fast');
        }).next().slideToggle()
    });

    //customize textarea
    $(function() {
        $(document).on('mousemove', 'textarea', function(e) {
            var a = $(this).offset().top + $(this).outerHeight() - 16,  //  top border of bottom-right-corner-box area
                b = $(this).offset().left + $(this).outerWidth() - 16;  //  left border of bottom-right-corner-box area
            $(this).css({
                cursor: e.pageY > a && e.pageX > b ? 'nw-resize' : ''
            });
        })
    });

    //show modal windows

    $('.modal').on('hidden.bs.modal', function (e) {
        $('body').css({padding:''});
    });

    $('.leave-feedback-button').click(function () {
        $('#product-comment').modal('show');
    });

    $('.response-to-comment').click(function () {
        $('#response-to-comment').modal('show');
    });

    $('.modal-product-comment .send').click(function () {
        $('.modal').modal('hide');
        setTimeout(function() {


            $('#general-modal-window')
                .find('.modal-dialog')
                .css({'max-width': '420px'})
                .find('.modal-body')
                .empty()
                .append('Спасибо, Ваш отзыл добавлен и будет опубликован после проверки модератором');
            $('#general-modal-window').modal('show');
        },500);
        return false;
    });


    $('.cart-popup-button').click(function () {
        $('#cart-popup').find('.modal-dialog').css({width:$('.content').width()});
        $('#cart-popup').modal('show');
    });

    $('.clarify-price-button').click(function () {
        $('#clarify-cost').modal('show');
    });




    //$('#general-modal-window')
    //    .find('.modal-dialog')
    //    .css({'max-width':'420px'})
    //    .find('.modal-body')
    //    .append('Спасибо, Ваш отзыл добавлен и будет опубликован после проверки модератором');
    //$('#general-modal-window').modal('show');

    //$('#product-comment').modal('show');

    //$('#response-to-comment').modal('show');

    $('#cart-popup').find('.modal-dialog').css({width:$('.content').width()});
    //$('#cart-popup').modal('show');

    //$('#clarify-cost').modal('show');


    //ajax pagination


    $('.advanced-pagination-all-wrap').bind('DOMNodeInserted', function(e) {
        var length = $(this).find('.advanced-pagination-item').length;
        var first = parseInt($(this).find('.found-title .first').text());
        $(this).find('.found-title .last').text(first + length - 1);
    });

    if(!$('.woocommerce-pagination:visible .current').parent().next().find(':not(.next)')[0]){
        $('.pagination-loading-more:visible').css({visibility: 'hidden'});
    }

    $('.pagination-loading-more').click(function () {

        $('.malinky-load-more a').click();
        $(".malinky-ajax-pagination-loading").show();

        var middle = false;
        var dots = $($('.woocommerce-pagination:visible')[0]).find('.dots');
        var dotsParent = $(dots[1]).parent();
        var lastMiddle = parseInt(dotsParent.prev().find('.page-numbers').text());
        var beginning = ($($('.woocommerce-pagination:visible li .page-numbers:not(.prev)')[1]).text() == 2);

        if(!dots[1] && !beginning){

            switchNextCurrent();

        }else if(beginning){

            $('.woocommerce-pagination:visible').each(function(){

                var lastMiddleFrom_1 = $(this).find('.dots').parent().prev();
                var num = parseInt(lastMiddleFrom_1.find('.page-numbers').text()) + 1;

                var clone = lastMiddleFrom_1.clone();

                var  href = clone.find('.page-numbers').attr('href');
                if (href) {

                    clone.find('.page-numbers').attr({
                        'href': href.match(/.*\//) + num
                    });
                }
                clone.find('.page-numbers').text(num);

                lastMiddleFrom_1.after(clone);

                switchNextCurrent();

                if(num > 6){
                    $($(this).find('li')[2]).replaceWith($($(this).find('.dots').parent()[0]).clone());
                }


            });

        }else{


            $('.woocommerce-pagination li').each(function () {

                if ($(this).find('.dots')[0]) {

                    middle = !middle;
                    return true;
                }

                if (middle) {

                    var middleItem = $(this).find('.page-numbers');

                    nextNumber = parseInt($(this).find('.page-numbers').text()) + 1;

                    middleItem.text(nextNumber);

                    var href = middleItem.attr('href');

                    changeHref(middleItem,href,nextNumber);


                }

            });

        }

        if( lastMiddle + 2 == parseInt(dotsParent.next().find('.page-numbers').text()) ){

            $(dots[1]).parent().remove();

        }


        if(!$('.woocommerce-pagination:visible .current').parent().next().find(':not(.next)')[0]){
            $('.pagination-loading-more:visible').css({visibility: 'hidden'});
        }

        function changeHref(obj,href,num){

            if (href) {

                obj.attr({
                    'href': href.match(/.*\//) + num
                });
            }
        }

        function switchNextCurrent(){
            var current = $('.woocommerce-pagination:visible .current');
            current.removeClass('current');

            var currentNext = current.parent().next().find('.page-numbers');
            currentNext.addClass('current').prev();

            var href = currentNext.attr('href');

            changeHref(current,href,current.text());
            replaceTagName(current,'a');
            replaceTagName(currentNext,'span');

        }

    });

});

function makeSubmenu(context,x,y,width){

    var width = width != undefined ? 'width:'+width+'px;' : '';

    if(context){
        var i = $(context).data('i');
        var dataPath = 'data-path="';
        var path = String($(context).closest('ul').data('path'));
    }else{
        var i = '';
        var dataPath = 'data-path="1';
        var path = '';
    }

    dataPath += path + String(i);
    dataPath += '"';

    var style = ' style="display:none;position:absolute;top:'+y+'px;left:'+x+'px;'+width+'" ';
    var submenu = '<ul class="submenu" '+ dataPath + style + '>';

    var subArr = [0,0,'',arr];
    if(context){
        path = path + String($(context).data('i'));
        for (var i = 1; i < path.length; i++) {
            subArr = subArr[3][path[i]];
        }
    }

    if(!subArr[3]) return;

    var glyphiconClass = $(window).width() < 1100 ? 'glyphicon-menu-down' : 'glyphicon-menu-right';
    subArr[3].forEach(function(item,i){

        var black = ' black', arrow = '', a1 = '', a2 = '';
        if(item[3] != undefined && arr.length){
            black = '';
            arrow = '<span class="submenu-item-arrow glyphicon '+glyphiconClass+'"></span>';
        }else{
            a1 = '<a class="link-blue-text" href="'+item[2]+'">';
            a2 = '</a>';
        }
        submenu += '<li class="submenu-item" data-i='+i+'>' +
        a1 +
        '<span class="submenu-item-title">'+item[0]+'</span>' +
        '<div class="submenu-products-number">' +
        '<span class="submenu-item-number'+black+'">'+item[1]+'</span>' +
        arrow +
        '</div>' +
        a2 +
        '</li>';
    });
    submenu += '</ul>';
    submenu = $(submenu);
    $('.absolute-elements').append(submenu);

    return submenu;
}

arr = [
    ['Автоматика',75,'/'],
    ['Пневматика и гидравлика',34,'/',[
        ['Датчики',230,'/'],
        ['Коммутаторы Ethernet',75,'/'],
        ['Контроль, управление, питание',440,'/'],
        ['Преобразователи измерительных сигналов',5,'/'],
        ['Промышленная безопастность',75,'/'],
        ['Сигнальная арматура',34,'/',[
            ['Автоматика',75,'/'],
            ['Пневматика и гидравлика',34,'/',[
                ['Автоматика',75,'/'],
                ['Пневматика и гидравлика',34,'/'],
                ['Электроника',23,'/'],
                ['Производство ТЕНов',45,'/',[
                    ['Автоматика',75,'/'],
                    ['Пневматика и гидравлика',34,'/'],
                    ['Электроника',23,'/'],
                    ['Производство ТЕНов',45,'/'],
                    ['Наши разработки',56,'/'],
                ]],
                ['Наши разработки',56,'/'],
            ]],
            ['Электроника',23,'/'],
            ['Производство ТЕНов',45,'/',[
                ['Автоматика',75,'/'],
                ['Пневматика и гидравлика',34,'/'],
                ['Электроника',23,'/'],
                ['Производство ТЕНов',45,'/'],
                ['Наши разработки',56,'/'],
            ]],
            ['Наши разработки',56,'/'],
        ]],
        ['Система дистанционного управления',45,'/'],
        ['Электропривод',45,'/'],
        ['Энкодеры',12,'/'],
    ]],
    ['Электроника',34,'/'],
    ['Производство ТЕНов',45,'/',[
        ['Датчики',230,'/'],
        ['Коммутаторы Ethernet',75,'/'],
        ['Контроль, управление, питание',440,'/'],
        ['Преобразователи измерительных сигналов',5,'/'],
        ['Промышленная безопастность',75,'/'],
        ['Сигнальная арматура',34,'/',[
            ['Автоматика',75,'/'],
            ['Пневматика и гидравлика',34,'/'],
            ['Электроника',23,'/'],
            ['Производство ТЕНов',45,'/',[
                ['Автоматика',75,'/'],
                ['Пневматика и гидравлика',34,'/'],
                ['Электроника',23,'/'],
                ['Производство ТЕНов',45,'/'],
                ['Наши разработки',56,'/'],
            ]],
            ['Наши разработки',56,'/'],
        ]],
        ['Система дистанционного управления',45,'/'],
        ['Электропривод',45,'/'],
        ['Энкодеры',12,'/'],
    ]],
    ['Наши разработки',56,'/'],
];

function PreviewSlider(slider,windowPadding) {

    var self = this;

    this.windowPadding = 0;

    if($(window).width() <= 639){
        this.windowPadding = 600;
    }else
    if ($(window).width() <= 1099){
        this.windowPadding = 85;
    }

    this.window = $(slider);
    this.windowWidth = this.window.width();
    this.scrollStep = this.window.data('scroll-step');
    this.container = this.window.find('.slider-container');
    this.left = this.container.position().left;
    this.containerChildrens = this.container.children();
    this.previewWidth = this.containerChildrens.first().outerWidth(true);
    this.containerWidth = this.previewWidth * this.containerChildrens.length;
    this.numSections = Math.floor((this.windowWidth - this.windowPadding) / this.previewWidth);
    this.scrollStep = this.scrollStep != undefined ? this.scrollStep : this.numSections;
    this.scrollStep = this.scrollStep ? this.scrollStep : 1;
    this.offset = this.previewWidth * this.scrollStep;
    this.previosPositionX = 0;
    this.previosPositionY = 0;
    this.swipeOffset = 0;
    this.animateDone = true;
    this.itemInserted = false;

    this.nextBlock = function(speed,loop){

        loop = 'wheel';

        var speed = speed || 'slow';
        var loop = loop !== undefined ? loop : false;
        var offsetEnd = this.containerWidth + this.left;
        var left = this.left - this.offset;

        if(offsetEnd - this.offset  < this.windowWidth ){

            if(loop){

                if(loop == 'line') {

                    left = 0;

                }else if(loop == 'wheel'){

                    this.container.append(this.container.children().slice(0,this.scrollStep));
                    this.container.css('left',this.left + this.offset);
                    left += this.offset;

                }else {

                    left = this.offset - this.containerWidth;
                }
            }
        }

        this.container.animate({left:left+'px'},speed).queue(function(){
            $(this).clearQueue();
            $(this).dequeue();
        });
    }

    this.prevBlock = function(speed,loop){

        loop = 'wheel';

        var speed = speed || 'slow';
        var loop = loop !== undefined ? loop : false;
        var left = this.left + this.offset;

        if(this.left >= 0){

            if(loop){

                if(loop == 'line'){

                    left = 0 - this.containerWidth + this.offset;

                }else if(loop == 'wheel') {

                    this.prependItem();
                    left -= this.offset;

                }else{

                    left = 0;
                }
            }
        }

        this.container.animate({left:left+'px'},speed).queue(function(){
            $(this).clearQueue();
            $(this).dequeue();
        });
    }

    this.changePosition = function(e) {

        if (this.previosPositionX){

            this.swipeOffset += e.changedTouches[0].clientX - this.previosPositionX;

            this.container.css({left:this.left + this.swipeOffset});
        }

        this.previosPositionX = e.changedTouches[0].clientX;

    }

    this.moveToTouchstartOffset = function(){
        this.animateDone = false;

        this.container.animate({'left':this.left},function(){
            self.animateDone = true;
        });
    }

    this.prependItem = function(){
        this.container.prepend(this.container.children().slice( - this.scrollStep));
        this.container.css('left',this.left -= this.offset);
    }
}
PreviewSlider.init = function(){

    $('.slider-window').each(function() {

        var v_window = $(this);
        var windowWidth = v_window.width();
        var container = v_window.find('.slider-container');
        var containerChildrens = container.children();
        var previewWidth = containerChildrens.first().outerWidth(true);
        var containerWidth = previewWidth * containerChildrens.length;
        var numSections = Math.floor(windowWidth / previewWidth);
        var offset = previewWidth * numSections;

        if (containerWidth < windowWidth) {
            v_window.nextAll('.right-rewind-blue, .right-rewind-grey, .left-rewind-blue, .left-rewind-grey').hide();
        } else {

            if (offset * 2 > containerWidth) {

                container.append(container.children().clone());
                container.width(containerWidth * 2 + 5);
            }
        }
    });

    $('.left-rewind-blue').click(function(){

        var slider = $(this).parent().find('.slider-window');

        var sp = new PreviewSlider(slider);
        sp.prevBlock();
    });

    $('.right-rewind-blue').click(function(){

        var slider = $(this).parent().find('.slider-window');

        var sp = new PreviewSlider(slider);
        sp.nextBlock();
    });

    //for touchscreen

    var swipe;
    var previewSlider;


    //to have a possibility scroll top
    jQuery('.slider-window')
        .on('movestart', function(e) {
            // If the movestart is heading off in an upwards or downwards
            // direction, prevent it so that the browser scrolls normally.
            if ((e.distX > e.distY && e.distX < -e.distY) ||
                (e.distX < e.distY && e.distX > -e.distY)) {
                e.preventDefault();
            }
        });

    $(".slider-window").on("touchstart swiperight swipeleft swipeup swipedown touchmove touchend",function(e){
 
        //e.preventDefault();

        if(previewSlider && !previewSlider.animateDone){
            return;
        }

        if(e.type == 'touchstart'){

            previewSlider = new PreviewSlider(e.delegateTarget);

            previewSlider.previosPositionX = e.changedTouches[0].clientX;
            previewSlider.previosPositionY = e.changedTouches[0].clientY

            swipe = false;
        }else
        if(e.type == 'touchend'){
            setTimeout(function(){
                if(!swipe){
                    previewSlider.moveToTouchstartOffset();
                }
            },100);
        }
        if(e.type == '___touchmove'){

            if(Math.abs(previewSlider.previosPositionY - e.changedTouches[0].clientY) < Math.abs(previewSlider.previosPositionX - e.changedTouches[0].clientX)){

                if(!previewSlider.itemInserted){
                    previewSlider.prependItem();
                    previewSlider.itemInserted = true;
                }
                previewSlider.changePosition(e);
            }

        }else
        if(e.type == 'swiperight'){
           
            previewSlider.prevBlock(1000,false);
            swipe = true;
        }else
        if(e.type == 'swipeleft'){
           
            previewSlider.nextBlock('fast',false);
            swipe = true;
        }
    });

}

//raplace tag name
function concatHashToString(hash){
    var emptyStr = '';
    $.each(hash, function(index){
        emptyStr += ' ' + hash[index].name + '="' + hash[index].value + '"';
    });
    return emptyStr;
}
function replaceTagName(targetId, replaceWith){
    $(targetId).each(function(){
        
        var attributes = concatHashToString(this.attributes);
        var replacingStartTag = '<' + replaceWith + attributes +'>';
        var replacingEndTag = '</' + replaceWith + '>';
       
        $(this).replaceWith($(replacingStartTag + $(this).html() + replacingEndTag));
    });
}



function decodeEntities(encodedString) {
    return encodedString;
}
/*
 //disable text selection
 $.fn.disableSelection = function() {
 function preventDefault () {
 return false;
 }
 $(this).attr('unselectable', 'on')
 .css('-moz-user-select', 'none')
 .css('-khtml-user-select', 'none')
 .css('-o-user-select', 'none')
 .css('-msie-user-select', 'none')
 .css('-webkit-user-select', 'none')
 .css('user-select', 'none')
 .mousedown(preventDefault);
 .each(function() {
 this.onselectstart = preventDefault;
 });
 };
 */
