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
var Cart = /** @class */ (function () {
    function Cart() {
        var _this = this;
        //	private isCached: boolean = false;
        this.isClosed = true;
        this.dom = $("#cart");
        this.openCartDOM = $("#open-cart-button");
        var storageString = localStorage.getItem("CART-ID-ARRAY");
        if (storageString === null) {
            this.ids = new Array(0);
            storageString = JSON.stringify(this.ids);
            localStorage.setItem("CART-ID-ARRAY", storageString);
        }
        else
            this.ids = JSON.parse(storageString);
        this.idCount = this.ids.length;
        this.openCartDOM.on("click", function () {
            _this.isClosed = !_this.isClosed;
            var data = JSON.stringify(_this.ids);
            console.log(data);
            $.ajax({
                url: "/product/getEntitiesById",
                method: "POST",
                data: { data: data },
                success: function (response) {
                    if (response === "noitems") {
                        console.log(response);
                        return;
                    }
                    console.log(response);
                    var data = JSON.parse(response);
                    var products = new Array(0);
                    data.forEach(function (value) {
                        products.push(new Product(value));
                    });
                    products.forEach(function (product) {
                        console.log(product);
                        //							                  product.createDOM();
                        //this.container.append( product.getDOM() );
                    });
                }
            });
        });
    }
    Cart.prototype.put = function (id) {
        this.ids.push(id);
        var storageString = JSON.stringify(this.ids);
        localStorage.setItem("CART-ID-ARRAY", storageString);
        console.log(storageString);
    };
    Cart.prototype.remove = function (id) {
        delete this.ids[this.ids.indexOf(id)];
        var storageString = JSON.stringify(this.ids);
        localStorage.setItem("CART-ID-ARRAY", storageString);
    };
    return Cart;
}());
var globalCart = null;
$(function () {
    globalCart = new Cart();
    console.log("CART CREATED");
});
//# sourceMappingURL=cart.js.map