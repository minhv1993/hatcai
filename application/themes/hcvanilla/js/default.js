$(document).ready(function () {
    function isInViewport(elem) {
        var vp = $(window),
            top = elem.offset().top,
            bottom = elem.offset().bottom + elem.height(),
            vpTop = vp.scrollTop(),
            vpBottom = vp.scrollTop() + vp.height();

        return top < vpBottom || bottom > vpTop;
    }

    function parallax(elem) {
        var vp = $(window),
            divider = 700 - elem.heigt(),
            vpTop = vp.scrollTop(),
            vpHeight = vp.height(),
            top = (elem.offset().top - vpHeight) < 0 ? 0 : (elem.offset().top - vpHeight),
            percent = vpHeight / divider,
            diff = top - vpTop,
            move = diff / percent;
        elem.css("background-position-y", (-move + "px"));
    }

    $(window).on("scroll, touchmove", function (data) {
        var parallaxLayer = $(".parallax-layer-1");
        if (isInViewport(parallaxLayer)) {
            parallax(parallaxLayer);
        }
    });
});