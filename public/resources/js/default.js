var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Default;
(function (Default) {
    var PageComponentBase = /** @class */ (function () {
        function PageComponentBase(dom) {
            this.dom = dom;
            this.window = $(window);
        }
        PageComponentBase.prototype.getDOM = function () {
            return this.dom;
        };
        PageComponentBase.prototype.addClass = function (className) {
            this.dom.addClass(className);
        };
        PageComponentBase.prototype.removeClass = function (className) {
            this.dom.removeClass(className);
        };
        return PageComponentBase;
    }());
    var Header = /** @class */ (function (_super) {
        __extends(Header, _super);
        function Header() {
            var _this = _super.call(this, $("#header")) || this;
            _this.mobileMenu = new MobileMenu();
            _this.cart = new Cart();
            _this.setEventHandlers();
            return _this;
        }
        Header.prototype.setEventHandlers = function () {
            var _this = this;
            this.window.on("scroll", function () {
                var scrolled = _this.window.scrollTop();
                var headerHeight = _this.dom.height();
                if (scrolled > 0)
                    _this.dom.addClass("bottom-bordered");
                else if (scrolled < headerHeight)
                    _this.dom.removeClass("bottom-bordered");
            });
        };
        return Header;
    }(PageComponentBase));
    var MobileMenu = /** @class */ (function (_super) {
        __extends(MobileMenu, _super);
        function MobileMenu() {
            var _this = _super.call(this, $("#mobile-menu")) || this;
            _this.button = $("#mobile-menu-button");
            _this.content = $("#content-footer");
            _this.isOpened = false;
            _this.setEventHandlers();
            return _this;
        }
        MobileMenu.prototype.hide = function () {
            var _this = this;
            this.dom.fadeOut("0.5s", function () {
                _this.content.fadeIn("0.5s");
                _this.window.scrollTop(_this.scrolled);
            });
            this.isOpened = false;
        };
        MobileMenu.prototype.show = function () {
            var _this = this;
            this.scrolled = this.window.scrollTop();
            this.content.fadeOut("1s", function () {
                _this.dom.fadeIn("1s");
            });
            this.isOpened = true;
        };
        MobileMenu.prototype.setEventHandlers = function () {
            var _this = this;
            this.button.on("click", function () {
                _this.button.css("::focus", "false");
                if (_this.isOpened)
                    _this.hide();
                else
                    _this.show();
            });
            MediaQuery.addOnMD(function () {
                _this.hide();
            });
            MediaQuery.addOnLG(function () {
                _this.hide();
            });
            MediaQuery.addOnXL(function () {
                _this.hide();
            });
        };
        return MobileMenu;
    }(PageComponentBase));
    var Cart = /** @class */ (function (_super) {
        __extends(Cart, _super);
        function Cart() {
            var _this = _super.call(this, $("#cart")) || this;
            _this.cartButton = $("#open-cart-button");
            _this.cartButtonImage = $("#cart-button-image");
            _this.emptynessMessage = $("#cart-emptyness");
            _this.isOpened = false;
            _this.isEmpty = true;
            if (_this.isEmpty)
                _this.showEmptynessMessage();
            _this.setEventHandlers();
            return _this;
        }
        Cart.prototype.showEmptynessMessage = function () {
            this.emptynessMessage.show();
        };
        Cart.prototype.hideEmptynessMessage = function () {
            this.emptynessMessage.hide();
        };
        Cart.prototype.setEventHandlers = function () {
            var _this = this;
            this.cartButton.on("click", function () {
                _this.isOpened = !_this.isOpened;
                _this.width = _this.dom.width();
                _this.dom.on("transitionend webkitTransitionEnd oTransitionEnd", function () {
                    if (!_this.isOpened) {
                        _this.dom.css("display", "none");
                        _this.dom.removeClass("left-bordered");
                        _this.dom.removeClass("top-bordered");
                    }
                });
                if (_this.isOpened) {
                    _this.cartButtonImage.removeClass(Cart.CART_BUTTON_CLOSED);
                    _this.cartButtonImage.addClass(Cart.CART_BUTTON_OPENED);
                    _this.dom.css("display", "block");
                    _this.dom.addClass("left-bordered");
                    _this.dom.addClass("top-bordered");
                    _this.dom.css("right", 0);
                }
                else {
                    _this.cartButtonImage.removeClass(Cart.CART_BUTTON_OPENED);
                    _this.cartButtonImage.addClass(Cart.CART_BUTTON_CLOSED);
                    _this.dom.css("right", -2 * _this.width);
                }
            });
        };
        Cart.CART_BUTTON_OPENED = "fa-times";
        Cart.CART_BUTTON_CLOSED = "fa-shopping-cart";
        return Cart;
    }(PageComponentBase));
    var Core = /** @class */ (function (_super) {
        __extends(Core, _super);
        function Core(debug) {
            if (debug === void 0) { debug = false; }
            var _this = _super.call(this, null) || this;
            _this.header = new Header();
            _this.debug = debug;
            //			if( this.debug )
            //			{
            _this.info = $("#debug");
            //			this.info.show();
            //			}
            var width = $(window).width();
            _this.info.text("XS | Width: " + width + "px");
            _this.setEventHandlers();
            return _this;
        }
        Core.prototype.setEventHandlers = function () {
            var _this = this;
            var jWindow = $(window);
            if (this.debug) {
                MediaQuery.addOnXS(function () {
                    var width = jWindow.width();
                    _this.info.text("XS | Width: " + width + "px");
                });
                MediaQuery.addOnSM(function () {
                    var width = jWindow.width();
                    _this.info.text("SM | Width: " + width + "px");
                });
                MediaQuery.addOnMD(function () {
                    var width = jWindow.width();
                    _this.info.text("MD | Width: " + width + "px");
                });
                MediaQuery.addOnLG(function () {
                    var width = jWindow.width();
                    _this.info.text("LG | Width: " + width + "px");
                });
                MediaQuery.addOnXL(function () {
                    var width = jWindow.width();
                    _this.info.text("XL | Width: " + width + "px");
                });
            }
        };
        return Core;
    }(PageComponentBase));
    var SignController = /** @class */ (function (_super) {
        __extends(SignController, _super);
        function SignController() {
            return _super.call(this, $("#")) || this;
        }
        SignController.prototype.setEventHandlers = function () {
        };
        return SignController;
    }(PageComponentBase));
    var MediaQuery = /** @class */ (function () {
        function MediaQuery() {
        }
        MediaQuery.init = function () {
            var jWindow = $(window);
            jWindow.on("resize", function () {
                var windowWidth = jWindow.width();
                if (windowWidth >= MediaQuery.XS && windowWidth < MediaQuery.SM) {
                    MediaQuery._onXS.forEach(function (handler) {
                        handler();
                    });
                    return;
                }
                if (windowWidth >= MediaQuery.SM && windowWidth < MediaQuery.MD) {
                    MediaQuery._onSM.forEach(function (handler) {
                        handler();
                    });
                    return;
                }
                if (windowWidth >= MediaQuery.MD && windowWidth < MediaQuery.LG) {
                    MediaQuery._onMD.forEach(function (handler) {
                        handler();
                    });
                    return;
                }
                if (windowWidth >= MediaQuery.LG && windowWidth < MediaQuery.XL) {
                    MediaQuery._onLG.forEach(function (handler) {
                        handler();
                    });
                    return;
                }
                if (windowWidth >= MediaQuery.XL) {
                    MediaQuery._onXL.forEach(function (handler) {
                        handler();
                    });
                    return;
                }
            });
        };
        MediaQuery.addOnXS = function (handler) {
            MediaQuery._onXS.push(handler);
        };
        MediaQuery.addOnSM = function (handler) {
            MediaQuery._onSM.push(handler);
        };
        MediaQuery.addOnMD = function (handler) {
            MediaQuery._onMD.push(handler);
        };
        MediaQuery.addOnLG = function (handler) {
            MediaQuery._onLG.push(handler);
        };
        MediaQuery.addOnXL = function (handler) {
            MediaQuery._onXL.push(handler);
        };
        MediaQuery.XS = 0;
        MediaQuery.SM = 576;
        MediaQuery.MD = 768;
        MediaQuery.LG = 992;
        MediaQuery.XL = 1200;
        MediaQuery._onXS = new Array(0);
        MediaQuery._onSM = new Array(0);
        MediaQuery._onMD = new Array(0);
        MediaQuery._onLG = new Array(0);
        MediaQuery._onXL = new Array(0);
        return MediaQuery;
    }());
    var core = null;
    var DEBUG = true;
    $(function () {
        MediaQuery.init();
        core = new Core(DEBUG);
    });
})(Default || (Default = {}));
String.prototype.hashCode = function () {
    var result, char, length;
    result = char = 0;
    length = this.length;
    if (length === 0)
        return result;
    for (var i = 0; i < length; i++) {
        char = this.charCodeAt(i);
        result = result * 31 + char;
        result |= 0;
    }
    return result;
};
//# sourceMappingURL=default.js.map