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
        var addButton = $("#add-to-card-button");
        addButton.on("click", function () {
            var id = +$("#primary-image").attr("data-id");
            globalCart.put(id);
            addButton.fadeOut("0.7s", function () {
                addButton.text("added");
                addButton.fadeIn("0.7s", function () {
                    setTimeout(function () {
                        addButton.fadeOut("0.7s", function () {
                            addButton.text("add to cart");
                            addButton.fadeIn("0.7s");
                        });
                    }, 1500);
                });
            });
        });
    });
})(See || (See = {}));
//# sourceMappingURL=see.js.map