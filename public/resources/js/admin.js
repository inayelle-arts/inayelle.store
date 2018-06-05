var Admin;
(function (Admin_1) {
    var Admin = /** @class */ (function () {
        function Admin() {
            this.tableSelectDOM = $("#table-select");
            this.tableDOM = $("#table");
            this.tableHeadDOM = $("#table-head");
            this.tableBodyDOM = $("#table-body");
            this.saveChangesButtonDOM = $("#save-changes-button");
            this.addRowButtonDOM = $("#add-row-button");
            this.rowList = new Array(0);
            this.setEventHandlers();
        }
        //todo: save changes
        Admin.prototype.setEventHandlers = function () {
            var _this = this;
            this.tableSelectDOM.on("change", function () {
                _this.loadTable();
            });
            this.saveChangesButtonDOM.on("click", function () {
                var success = true;
                var updated = false;
                _this.rowList.forEach(function (value) {
                    var url = "/admin/";
                    if (value.pendingDelete === true)
                        url += "delete";
                    else if (value.pendingCreate === true)
                        url += "create";
                    else if (value.pendingUpdate === true)
                        url += "update";
                    else
                        return;
                    updated = true;
                    var data = value.toJSON();
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: { data: data },
                        success: function (response) {
                            if (response !== "success") {
                                alert(response);
                                success = false;
                            }
                        }
                    });
                });
                if (updated && success)
                    _this.loadTable();
            });
            this.addRowButtonDOM.on("click", function () {
                var row = new Row(-1, _this.tableSelectDOM.val(), true);
                _this.rowList.push(row);
                row.addPrimaryField("generated", "id");
                for (var i = 1; i < _this.fieldList.length; i++)
                    row.addField(null, _this.fieldList[i]);
                _this.tableBodyDOM.append(row.getDOM());
            });
        };
        Admin.prototype.loadTable = function () {
            var _this = this;
            this.tableHeadDOM.html("");
            this.tableBodyDOM.html("");
            var selected = this.tableSelectDOM.val();
            var data = "{\"table\": \"" + selected + "\"}";
            $.ajax({
                url: "admin/table",
                method: "GET",
                data: { data: data },
                success: function (response) {
                    _this.parseJSON(response);
                },
                error: function () {
                    console.log("Server does not respond");
                },
                timeout: 5000
            });
        };
        Admin.prototype.parseJSON = function (json) {
            var decoded = JSON.parse(json);
            this.parseFieldList(decoded["fieldList"]);
            this.parseEntities(decoded["entities"]);
        };
        Admin.prototype.parseFieldList = function (fields) {
            var _this = this;
            this.fieldList = fields;
            fields.forEach(function (value) {
                var columnNameDOM = $(document.createElement("th"));
                columnNameDOM.attr("scope", "col");
                columnNameDOM.text(value);
                _this.tableHeadDOM.append(columnNameDOM);
            });
        };
        Admin.prototype.parseEntities = function (entities) {
            var _this = this;
            entities.forEach(function (entity) {
                var id = entity["id"];
                delete entity["id"];
                var row = new Row(id, _this.tableSelectDOM.val());
                row.addPrimaryField(id, "id");
                for (var fieldKey in entity)
                    row.addField(entity["" + fieldKey], fieldKey);
                _this.rowList.push(row);
                _this.tableBodyDOM.append(row.getDOM());
            });
        };
        return Admin;
    }());
    var Row = /** @class */ (function () {
        function Row(id, entityName, isNew) {
            if (isNew === void 0) { isNew = false; }
            this.needsUpdate = false;
            this.needsCreate = false;
            this.needsRemove = false;
            this.needsCreate = isNew;
            this.entityName = entityName;
            this.dom = $(document.createElement("tr"));
            this.id = id;
            this.active = false;
            this.fieldList = new Array(0);
            this.deleteButtonDOM = $(document.createElement("div"));
            this.deleteButtonDOM.addClass("hidden btn btn-danger");
            this.deleteButtonDOM.text("delete");
            this.setEventHandlers();
        }
        Row.prototype.setEventHandlers = function () {
            var _this = this;
            this.dom.on("mouseenter", function () {
                _this.dom.addClass(Row.ON_HOVER_STYLE);
                _this.dom.addClass(Row.ON_HOVER_TEXT_STYLE);
            });
            this.dom.on("mouseleave", function () {
                _this.dom.removeClass(Row.ON_HOVER_STYLE);
                _this.dom.removeClass(Row.ON_HOVER_TEXT_STYLE);
            });
            this.dom.on("click", function () {
                if (!(_this.needsCreate || _this.needsRemove))
                    _this.needsUpdate = true;
            });
            this.deleteButtonDOM.on("click", function () {
                _this.needsRemove = !_this.needsRemove;
                if (_this.needsCreate) {
                    _this.needsUpdate = false;
                    _this.needsCreate = false;
                    _this.needsRemove = false;
                    _this.dom.remove();
                    return;
                }
                if (_this.needsUpdate)
                    _this.needsUpdate = false;
                if (_this.needsRemove) {
                    _this.dom.addClass("bg-danger");
                    _this.deleteButtonDOM.text("keep");
                }
                else {
                    _this.dom.removeClass("bg-danger");
                    _this.deleteButtonDOM.text("delete");
                }
            });
        };
        Object.defineProperty(Row.prototype, "pendingUpdate", {
            get: function () {
                return this.needsUpdate;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(Row.prototype, "pendingCreate", {
            get: function () {
                return this.needsCreate;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(Row.prototype, "pendingDelete", {
            get: function () {
                return this.needsRemove;
            },
            enumerable: true,
            configurable: true
        });
        Row.prototype.addPrimaryField = function (value, fieldName) {
            var _this = this;
            var field = new Field(value, fieldName, true);
            var fieldDOM = field.getDOM();
            fieldDOM.append(this.deleteButtonDOM);
            fieldDOM.on("mouseenter", function () {
                field.getValueDOM().addClass("hidden");
                _this.deleteButtonDOM.removeClass("hidden");
            });
            fieldDOM.on("mouseleave", function () {
                _this.deleteButtonDOM.addClass("hidden");
                field.getValueDOM().removeClass("hidden");
            });
            this.fieldList.push(field);
            this.dom.append(field.getDOM());
        };
        Row.prototype.addField = function (value, fieldName) {
            var field = new Field(value, fieldName);
            this.fieldList.push(field);
            this.dom.append(field.getDOM());
        };
        Row.prototype.getDOM = function () {
            return this.dom;
        };
        Row.prototype.toJSON = function () {
            var result = "{\"entityName\": " + JSON.stringify(this.entityName) + ", ";
            this.fieldList.forEach(function (value, index, array) {
                result += value.toJSON();
                if (index < array.length - 1)
                    result += ",";
            });
            result += "}";
            return result;
        };
        Row.ON_HOVER_STYLE = "bg-primary";
        Row.ON_HOVER_TEXT_STYLE = "text-light";
        return Row;
    }());
    var Field = /** @class */ (function () {
        function Field(value, fieldName, primary) {
            if (primary === void 0) { primary = false; }
            this.isActive = false;
            this.columnName = fieldName;
            this.isPrimary = primary;
            this.value = value;
            var tagName = primary ? "th" : "td";
            this.dom = $(document.createElement(tagName));
            this.valueDOM = $(document.createElement("div"));
            if (primary)
                this.dom.attr("scope", "row");
            this.valueDOM.text(value);
            if (!primary)
                this.dom.css("cursor", "pointer");
            this.inputDOM = $(document.createElement("input"));
            this.inputDOM.css({
                height: "100%"
            });
            this.inputDOM.addClass("hidden");
            this.dom.append(this.valueDOM);
            this.dom.append(this.inputDOM);
            if (!primary)
                this.setEventHandlers();
        }
        Field.prototype.setEventHandlers = function () {
            var _this = this;
            this.dom.on("click", function () {
                _this.value = _this.valueDOM.text();
                _this.inputDOM.width(_this.valueDOM.width());
                _this.inputDOM.val(_this.valueDOM.text());
                _this.valueDOM.addClass("hidden");
                _this.inputDOM.removeClass("hidden");
                _this.inputDOM.trigger("focus");
                _this.inputDOM.trigger("select");
            });
            this.inputDOM.on("focusout", function () {
                if (_this.value !== _this.inputDOM.val()) {
                    _this.value = _this.inputDOM.val();
                    _this.dom.addClass("bg-success");
                    _this.dom.addClass("text-light");
                    _this.valueDOM.text(_this.inputDOM.val());
                }
                _this.inputDOM.addClass("hidden");
                _this.valueDOM.removeClass("hidden");
            });
            this.inputDOM.on("keypress", function (keycode) {
                if (keycode.keyCode === 13) {
                    if (_this.value !== _this.inputDOM.val()) {
                        _this.value = _this.inputDOM.val();
                        _this.dom.addClass("bg-success");
                        _this.dom.addClass("text-light");
                        _this.valueDOM.text(_this.inputDOM.val());
                    }
                    _this.inputDOM.addClass("hidden");
                    _this.valueDOM.removeClass("hidden");
                }
            });
        };
        Field.prototype.toJSON = function () {
            var result = "";
            var value = this.valueDOM.text();
            result += "\"" + this.columnName + "\": " + JSON.stringify(value);
            return result;
        };
        Field.prototype.getDOM = function () {
            return this.dom;
        };
        Field.prototype.getValueDOM = function () {
            return this.valueDOM;
        };
        Field.prototype.getValue = function () {
            return this.value;
        };
        return Field;
    }());
    var admin = null;
    $(function () {
        admin = new Admin();
        admin.loadTable();
    });
})(Admin || (Admin = {}));
//# sourceMappingURL=admin.js.map