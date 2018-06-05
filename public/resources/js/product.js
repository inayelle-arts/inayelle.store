var Producta;
(function (Producta) {
    var Product = /** @class */ (function () {
        function Product(json) {
            for (var field in json)
                this["" + field] = json["" + field];
        }
        Product.prototype.createDOM = function () {
            this.dom = $(document.createElement("div"));
            this.dom.addClass("col-12 col-md-6 col-lg-4");
            var html = "<div class=\"product\">" +
                "" +
                ("<img class=\"image\" src=\"/resources/img/product_repo" + this.primaryImage + "\">") +
                "" +
                "<div class=\"row\">" +
                "<div class=\"col-12 col-lg-6\">" +
                "<div class=\"name\">" +
                ("" + this.name) +
                "</div>" +
                "</div>" +
                "" +
                "<div class=\"col-12 col-lg-6\">" +
                "<div class=\"cost\">" +
                (this.cost / 100 + "$") +
                "</div>" +
                "</div>" +
                "</div>" +
                "" +
                "<div class=\"row align-items-center\">" +
                "<div class=\"col-12 col-lg-7\">" +
                "<div class=\"description\">" +
                ("" + this.description) +
                "</div>" +
                "</div>" +
                "" +
                "<div class=\"col-12 col-lg-5\">" +
                ("<a class=\"checkout\" href=\"/product/see?id=" + this.id + "\">") +
                "checkout" +
                "</a>" +
                "</div>" +
                "</div>" +
                "" +
                "</div>";
            this.dom.html(html);
        };
        Product.prototype.getDOM = function () {
            return this.dom;
        };
        return Product;
    }());
    var Filter = /** @class */ (function () {
        function Filter() {
            var _this = this;
            this.productCount = 0;
            this.isEmptyCategories = true;
            var urlParams = new URLSearchParams(window.location.search);
            var catId = urlParams.get('cat');
            this.categoriesList = new Array(0);
            var categoryPreparedId;
            if (catId !== null) {
                categoryPreparedId = +catId;
                if (categoryPreparedId !== Number.NaN) {
                    this.categoriesList.push(categoryPreparedId);
                    this.isEmptyCategories = false;
                }
            }
            this.container = $("#products");
            this.updateButton = $("#update-button");
            this.lowerPriceButton = $("#lower-price");
            this.upperPriceButton = $("#upper-price");
            this.applyFiltersButton = $("#apply-filters");
            this.lowerPriceButton.on("change paste keyup", function () {
                if (_this.lowerPriceButton.val() === "")
                    _this.lowerPrice = null;
                else
                    _this.lowerPrice = _this.lowerPriceButton.val();
            });
            this.upperPriceButton.on("change paste keyup", function () {
                if (_this.upperPriceButton.val() === "")
                    _this.upperPrice = null;
                else
                    _this.upperPrice = _this.upperPriceButton.val();
            });
            this.applyFiltersButton.on("click", function () {
                _this.refresh();
            });
            this.updateButton.on("click", function () {
                _this.append();
            });
            $("#categories").find("input").each(function (index, element) {
                var jElem = $(element);
                if (categoryPreparedId === index + 1)
                    jElem.prop("checked", true);
                jElem.on("click", function () {
                    if (jElem.is(":checked")) {
                        _this.categoriesList.push(index + 1);
                        _this.isEmptyCategories = false;
                    }
                    else {
                        delete _this.categoriesList[_this.categoriesList.indexOf(index + 1)];
                        if (_this.categoriesList.length == 0)
                            _this.isEmptyCategories = true;
                    }
                });
            });
        }
        Filter.prototype.showNoMoreItems = function () {
            this.updateButton.text("no more items");
        };
        Filter.prototype.hideNoMoreItems = function () {
            this.updateButton.text("load more");
        };
        Filter.prototype.append = function () {
            var _this = this;
            var categoriesFlag = "";
            if (this.isEmptyCategories)
                categoriesFlag = "\"all\"";
            else
                categoriesFlag = JSON.stringify(this.categoriesList);
            var lowerPrice = (this.lowerPrice == null ? "null" : this.lowerPrice * 100);
            var upperPrice = (this.upperPrice == null ? "null" : this.upperPrice * 100);
            var filters = "{" +
                "\"count\": 3," +
                ("\"offset\": " + this.productCount + ",") +
                "\"categories\" :" +
                categoriesFlag +
                (",\"lowerCost\": " + lowerPrice + ",") +
                ("\"upperCost\": " + upperPrice) +
                "}";
            $.ajax({
                url: "/product/filter",
                method: "POST",
                data: { filters: filters },
                success: function (response) {
                    if (response === "noitems") {
                        _this.showNoMoreItems();
                        return;
                    }
                    var data = JSON.parse(response);
                    var products = new Array(0);
                    data.forEach(function (value) {
                        products.push(new Product(value));
                    });
                    products.forEach(function (product) {
                        product.createDOM();
                        _this.container.append(product.getDOM());
                    });
                    _this.productCount += 3;
                }
            });
        };
        Filter.prototype.refresh = function () {
            this.productCount = 0;
            this.hideNoMoreItems();
            this.container.find(".product").each(function (index, element) {
                $(element).parent().remove();
            });
            this.append();
        };
        return Filter;
    }());
    var filter = null;
    $(function () {
        filter = new Filter();
        filter.append();
    });
})(Producta || (Producta = {}));
//# sourceMappingURL=product.js.map