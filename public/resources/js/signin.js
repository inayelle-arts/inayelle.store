var SignIn;
(function (SignIn) {
    var Form = /** @class */ (function () {
        function Form() {
            this.loginFormDOM = $("#login-form");
            this.loginDOM = $("#login");
            this.passwordDOM = $("#password");
            this.submitButton = $("#login-form-submit");
            this.titleDOM = $("#sign-title");
            this.resetPasswordFormDOM = $("#reset-form");
            this.resetPassowordButtonDOM = $("#forgot-pass-button");
            this.backToSignInButtonDOM = $("#back-to-sign-in");
            this.resetFormSubmit = $("#reset-form-submit");
            this.resetLoginInputDOM = $("#reset-login");
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
            this.backToSignInButtonDOM.on("click", function () {
                _this.titleDOM.fadeOut("0.5s", function () {
                    _this.titleDOM.text("Sign in");
                    _this.titleDOM.fadeIn("0.5s");
                });
                _this.resetPasswordFormDOM.fadeOut("0.5s", function () {
                    _this.loginFormDOM.fadeIn("0.5s");
                    _this.loginFormDOM.css("display", "flex");
                });
            });
            this.resetPassowordButtonDOM.on("click", function () {
                _this.titleDOM.fadeOut("0.5s", function () {
                    _this.titleDOM.text("Reset password");
                    _this.titleDOM.fadeIn("0.5s");
                });
                _this.loginFormDOM.fadeOut("0.5s", function () {
                    _this.resetPasswordFormDOM.fadeIn("0.5s");
                    _this.resetPasswordFormDOM.css("display", "flex");
                });
            });
            this.submitButton.on("click", function () {
                if (!_this.loginFormDOM.valid())
                    return;
                var login = _this.loginDOM.val();
                var password = _this.passwordDOM.val();
                var passHash = password.hashCode();
                var data = "{\"login\": \"" + login + "\", \"password_hash\": \"" + passHash + "\"}";
                $.ajax({
                    url: "/sign/signin",
                    method: "post",
                    data: { data: data },
                    success: function (response) {
                        if (response === "success")
                            window.location.href = "/";
                        else
                            _this.errorField.text(response);
                    },
                    error: function () {
                        _this.errorField.text("Server does not respond");
                    },
                    timeout: 5000
                });
            });
            this.resetLoginInputDOM.on("change paste keyup", function () {
                _this.resetLoginInputDOM.valid();
            });
            this.resetFormSubmit.on("click", function () {
                if (!_this.resetLoginInputDOM.valid())
                    return;
                var email = _this.resetLoginInputDOM.val();
                var data = "{\"email\": \"" + email + "\"}";
                $.ajax({
                    url: "/sign/reset",
                    method: "POST",
                    data: { data: data },
                    success: function (response) {
                        $("#email-error").text(response);
                    },
                    error: function () {
                        $("#email-error").text("Server does not respond.");
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
})(SignIn || (SignIn = {}));
//# sourceMappingURL=signin.js.map