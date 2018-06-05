var previousImg = null;
$(function () {
    $("[id^='img-']").each(function (index, value) {
        var jImage = $(value);
        jImage.on("click", function () {
            if (previousImg !== null)
                previousImg.removeClass("bordered-image");
            $("#primary-image").attr("src", jImage.attr("src"));
            jImage.addClass("bordered-image");
            previousImg = jImage;
        });
        if (index === 0)
            jImage.trigger("click");
    });
});
//# sourceMappingURL=see.js.map