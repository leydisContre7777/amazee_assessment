(function ($) {
    $(function(){

        var swiperQuote = new Swiper('[data-swiper="swiper-quote"]', {
            observer: true,
            observeParents: true,
            loop: true,
            loopFillGroupWithBlank: true,
            slidesPerView: 1,
            spaceBetween: 0,
            parallax: true,
            speed: 1000,
            effect: 'coverflow',
            slidesOffsetBefore: 0,
            slidesOffsetAfter: 0,
            paginationClickable: true,
            coverflow: {
                rotate: 0,
                stretch: 0,
                depth: 80,
                modifier: 1,
                slideShadows: false
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        });

    });
})(jQuery);