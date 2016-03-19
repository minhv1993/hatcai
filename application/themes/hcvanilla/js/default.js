$(document).ready(function () {
    var parallaxLayer = $(".parallax-layer-1");
    function isInViewport(elem) {
        var vp = $(window),
            top = elem.offset().top,
            bottom = elem.offset().top + elem.height(),
            vpTop = vp.scrollTop(),
            vpBottom = vp.scrollTop() + vp.height();

        return (vpTop < top && vpBottom > bottom) ||
            (vpTop > top && vpTop < bottom) ||
            (vpBottom < bottom && vpBottom > top);
    }

    function parallax(elem) {
        var vp = $(window),
            vpHeight = vp.height(),
            top = (elem.offset().top - vpHeight) < 0 ? 0 : (elem.offset().top - vpHeight),
            percent = vpHeight / (elem.height()/5*2),
            diff = top - vp.scrollTop(),
            move = (diff / percent).toFixed(0);
        elem.css("background-position-y", (move + "px"));
    }

    $(window).on("scroll touchmove", function (data) {
        parallaxLayer.each(function () {
            if (isInViewport($(this))) {
                parallax($(this));
            }
        });
    });
});