var SignUp;
(function (SignUp) {
    var Form = /** @class */ (function () {
        function Form() {
            this.formDOM = $("#form");
            this.loginDOM = $("#login");
            this.passwordDOM = $("#password");
            this.submitButton = $("#sign-up-button");
            this.errorField = $("#password-error");
            this.setEventHandlers();
        }
        Form.prototype.setEventHandlers = function () {
            var _this = this;
            this.loginDOM.on("paste keyup change", function () {
                _this.loginDOM.valid();
            });
            this.passwordDOM.on("paste keyup change", function () {
                _this.passwordDOM.valid();
            });
            this.submitButton.on("click", function () {
                if (!_this.formDOM.valid())
                    return;
                var login = _this.loginDOM.val();
                var password = _this.passwordDOM.val();
                var passHash = password.hashCode();
                var data = "{\"login\": \"" + login + "\", \"password_hash\": \"" + passHash + "\"}";
                $.ajax({
                    url: "/sign/signup",
                    method: "post",
                    data: { data: data },
                    success: function (response) {
                        if (response === "success")
                            window.location.href = "/sign/verify";
                        else
                            _this.errorField.text(response);
                    },
                    error: function () {
                        _this.errorField.text("Server does not respond");
                    },
                    timeout: 5000
                });
            });
        };
        return Form;
    }());
    var form = null;
    $(function () {
        form = new Form();
    });
})(SignUp || (SignUp = {}));
//# sourceMappingURL=signup.js.map