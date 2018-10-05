
(function ($) {
    $(function(){

        $('#status-message').modal('show');
        $('[data-toggle="anchor"]').click(function () {
            var scroll_el = $(this).attr('href');
            if ($(scroll_el).length !== 0) {
                $('html, body').animate({scrollTop: $(scroll_el).offset().top }, 1000);
            }
            return false;
        });
        
        // Init submenus on mobile
        $('.toggle-submenu').click(function() {
            $(this)
                .toggleClass('open')
                .parent()
                .find('.dropdown-menu')
                .toggleClass('visible');
        });

        // custom function for expand all and collapse all button
        $('#expandAlltop').on('click',function(){
            var GetID = $(this).attr("data-target");
            $('#' + GetID +' '+'a[data-toggle="collapse"]').each(function(){
                var objectID=$(this).attr('href');
                if($(objectID).hasClass('in')===false)
                {
                    $(objectID).collapse('show');
                    $(objectID).parent().addClass("active");
                }
            });
        });
        $('#expandAllbottom').on('click',function(){
            var GetID = $(this).attr("data-target");
            $('#' + GetID +' '+'a[data-toggle="collapse"]').each(function(){
                var objectID=$(this).attr('href');
                if($(objectID).hasClass('in')===false)
                {
                    $(objectID).collapse('show');
                    $(objectID).parent().addClass("active");
                }
            });
        });
        // collapse
        $('#collapseAlltop').on('click',function(){
            var GetID = $(this).attr("data-target");
            $('#' + GetID +' '+ 'a[data-toggle="collapse"]').each(function(){
                var objectID=$(this).attr('href');
                $(objectID).collapse('hide');
                $(objectID).parent().removeClass("active");
            });
        });
        $('#collapseAllbottom').on('click',function(){
            var GetID = $(this).attr("data-target");
            $('#' + GetID +' '+ 'a[data-toggle="collapse"]').each(function(){
                var objectID=$(this).attr('href');
                $(objectID).collapse('hide');
                $(objectID).parent().removeClass("active");
            });
        });

        $(window).on("scroll",function() {
            var pageScroll = $(this).scrollTop();
            if (pageScroll > 50) {
                // alert('test');
                if ( $('[data-toggle="header-menu"]').hasClass('primary-navbar')){
                    $('.header__navbar').addClass("navbar-fix");
                    $('.header__navbar').removeClass("navbar-top");
                }
            } else {
                if ( $('[data-toggle="header-menu"]').hasClass('primary-navbar')){
                    $('.header__navbar').removeClass("navbar-fix");
                    $('.header__navbar').addClass("navbar-top");
                }
            }
        });

    });
})(jQuery);