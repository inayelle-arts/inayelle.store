var See;
(function (See) {
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
        $("#add-to-card-button").on("click", function () {
            var id = +$("#primary-image").attr("data-id");
            globalCart.put(id);
            console.log("added");
        });
    });
})(See || (See = {}));
//# sourceMappingURL=see.js.map