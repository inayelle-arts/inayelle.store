var ResetConfirm;
(function (ResetConfirm) {
    var Form = /** @class */ (function () {
        function Form() {
            this.passwordInputDOM = $("#password");
            this.confirmButtonDOM = $("#confirm-button");
            this.errorField = $("#password-error");
            var codeField = $("#code");
            this.code = codeField.val();
            codeField.remove();
            this.setEventHandlers();
        }
        Form.prototype.setEventHandlers = function () {
            var _this = this;
            this.passwordInputDOM.on("paste keyup change", function () {
                _this.passwordInputDOM.valid();
            });
            this.confirmButtonDOM.on("click", function () {
                if (!_this.passwordInputDOM.valid())
                    return;
                var password = _this.passwordInputDOM.val();
                var passHash = password.hashCode();
                console.log(passHash);
                var data = "{\"password\" : \"" + passHash + "\", \"code\" : \"" + _this.code + "\"}";
                $.ajax({
                    url: "/sign/resetconfirm",
                    method: "POST",
                    data: { data: data },
                    success: function (response) {
                        _this.errorField.text(response);
                        if (response === "success") {
                            _this.passwordInputDOM.attr("disabled");
                            _this.errorField.text("Password was renewed successfully. Please, enter with new password.");
                        }
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
})(ResetConfirm || (ResetConfirm = {}));
//# sourceMappingURL=resetconfirm.js.map