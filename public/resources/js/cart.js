var Product = /** @class */ (function () {
    function Product(json) {
        for (var field in json)
            this["" + field] = json["" + field];
    }
    Product.prototype.createDOM = function () {
        this.dom = $(document.createElement("div"));
        this.dom.addClass("cart-item");
        this.dom.attr("data-cart-item-id", "" + this.id);
        var html = "<a class=\"cart-item-img\" href=\"/product/see?id=" + this.id + "\" target=\"_blank\">" +
            ("<img src=\"/resources/img/product_repo/" + this.primaryImage + "\" alt=\"alt\">") +
            "</a>" +
            "<div class=\"cart-item-title\">" +
            ("" + this.name) +
            "</div>" +
            "<div class=\"cart-item-cost\">" +
            (this.total_cost / 100.0 + "$") +
            "</div>" +
            ("<div onclick='remove(" + this.id + ")' style=\"cursor: pointer; padding-right: 15px; font-size: 18px\"><i class=\"fas fa-times\"></i></div>");
        this.dom.html(html);
    };
    Product.prototype.getDOM = function () {
        return this.dom;
    };
    return Product;
}());
var Cart = /** @class */ (function () {
    function Cart() {
        var _this = this;
        this.isCached = false;
        this.isClosed = true;
        this.dom = $("#cart");
        this.openCartDOM = $("#open-cart-button");
        this.counterDOM = $("#cart-emptyness");
        this.containerDOM = $("#cart-item-holder");
        this.purchaseButtonDOM = $("#purchase-button");
        var storageString = localStorage.getItem("CART-ID-ARRAY");
        if (storageString === null) {
            this.ids = new Array(0);
            storageString = JSON.stringify(this.ids);
            localStorage.setItem("CART-ID-ARRAY", storageString);
        }
        else
            this.ids = JSON.parse(storageString);
        this.purchaseButtonDOM.on("click", function () {
            var json = JSON.stringify(_this.ids);
            $("#purchase-data").val(json);
            return true;
        });
        this.idCount = this.ids.length;
        if (this.idCount !== 0) {
            this.counterDOM.text(this.idCount + " items");
            this.purchaseButtonDOM.show();
        }
        this.openCartDOM.on("click", function () {
            _this.isClosed = !_this.isClosed;
            _this.load();
        });
    }
    Cart.prototype.load = function () {
        var _this = this;
        if (this.ids.length !== 0 && !this.isCached) {
            var data = JSON.stringify(this.ids);
            $.ajax({
                url: "/product/getEntitiesById",
                method: "POST",
                data: { data: data },
                success: function (response) {
                    if (response === "noitems")
                        return;
                    var data = JSON.parse(response);
                    var products = new Array(0);
                    data.forEach(function (value) {
                        products.push(new Product(value));
                    });
                    products.forEach(function (product) {
                        product.createDOM();
                        _this.containerDOM.append(product.getDOM());
                    });
                    _this.isCached = true;
                }
            });
        }
    };
    Cart.prototype.put = function (id) {
        this.purchaseButtonDOM.show();
        this.isCached = false;
        if (this.ids.indexOf(id) !== -1)
            return;
        this.ids.push(id);
        var storageString = JSON.stringify(this.ids);
        localStorage.setItem("CART-ID-ARRAY", storageString);
        this.idCount = this.ids.length;
        this.counterDOM.text(this.idCount + " items");
        this.load();
    };
    Cart.prototype.remove = function (id) {
        $("div[data-cart-item-id=\"" + id + "\"]").remove();
        var filter = new Array(0);
        var found = false;
        this.ids.forEach(function (value) {
            if (!found && value !== id) {
                filter.push(value);
                found = true;
            }
            else if (found)
                filter.push(value);
        });
        this.ids = filter;
        this.idCount = this.ids.length;
        if (this.idCount === 0) {
            this.purchaseButtonDOM.hide();
            this.counterDOM.text("empty cart");
        }
        else
            this.counterDOM.text(this.ids.length + " items");
        var storageString = JSON.stringify(this.ids);
        localStorage.setItem("CART-ID-ARRAY", storageString);
    };
    Cart.prototype.clear = function () {
        localStorage.removeItem("CART-ID-ARRAY");
        this.ids = new Array(0);
        this.idCount = 0;
        this.isCached = true;
        this.purchaseButtonDOM.hide();
        this.counterDOM.text("empty cart");
        this.containerDOM.children().remove();
    };
    return Cart;
}());
var globalCart = null;
$(function () {
    globalCart = new Cart();
});
function remove(id) {
    globalCart.remove(id);
}
//# sourceMappingURL=cart.js.map