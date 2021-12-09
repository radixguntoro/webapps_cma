var app = angular.module('pluginDrtv', []);
var windowHeight = $(window).outerHeight();
var headerHeight = $("header").outerHeight();

app.directive('zurbinit', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            $(document).foundation();
        }
    };
}]).directive('fullpage', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            windowHeight = $(window).outerHeight();
            headerHeight = $(".vs-header").height();
            contentHeight = windowHeight - headerHeight;
            $(".vs-box-page-content").css("min-height", contentHeight - 28);
        }
    };
}]).directive('fullbody', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            windowHeight = $(window).height();
            contentHeight = windowHeight - 56;
            $(".vs-content").css("height", contentHeight);
        }
    };
}]).directive('stickytable', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            theadWidth = $(".vs-table").outerWidth();
            $(".sticky-header").css("width", theadWidth);
        }
    };
}]).directive('fullheight', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var windowHeight = $(window).outerHeight();
            var sidebarHeight = $(".vs-adm-header").outerHeight();
            var footerHeight = $("footer").outerHeight();
            var contentHeight = windowHeight - sidebarHeight - footerHeight - 24;
            $(".vs-adm-page").css("min-height", contentHeight);
        }
    };
}]).directive('fullloader', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var windowHeight = $(window).outerHeight();
            var sidebarHeight = $(".vs-adm-header").outerHeight();
            var footerHeight = $("footer").outerHeight();
            var contentHeight = windowHeight - sidebarHeight - footerHeight - 24;
            $(".vs-adm-loader").css("min-height", contentHeight);
        }
    };
}]).directive('fulltable', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var windowHeight = $(window).outerHeight();
            var sidebarHeight = $(".vs-adm-header").outerHeight();
            var footerHeight = $("footer").outerHeight();
            var subHead = $(".vs-page-header").outerHeight();
            var subNeck = $(".vs-page-subheader").outerHeight();
            var subFoot = $(".vs-page-footer").outerHeight();
            var contentHeight = windowHeight - sidebarHeight - footerHeight - subHead - subNeck - subFoot - 60 - 24;
            $(".vs-box-table").css("min-height", contentHeight);
        }
    };
}]).directive('stickytable', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            $(document).trigger("stickyTable");
        }
    };
}]).directive('squarecol', [function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var widthCol = $(".vs-box-square").innerWidth();
            var contentHeight = widthCol;
            $(".vs-box-square").css("height", contentHeight);
            // $(".vs-box-square-get").css("height", contentHeight + 37);
        }
    };
}]).directive('selectedUser', [function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(val) {
                return parseInt(val, 10);
            });
            ngModel.$formatters.push(function(val) {
                return '' + val;
            });
        }
    };
}]).directive('ngThumb', ['$window', function($window) {
    var helper = {
        support: !!($window.FileReader && $window.CanvasRenderingContext2D),
        isFile: function(item) {
            return angular.isObject(item) && item instanceof $window.File;
        },
        isImage: function(file) {
            var type = '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
            return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
        }
    };

    return {
        restrict: 'A',
        template: '<canvas/>',
        link: function(scope, element, attributes) {
            if (!helper.support) return;

            var params = scope.$eval(attributes.ngThumb);

            if (!helper.isFile(params.file)) return;
            if (!helper.isImage(params.file)) return;

            var canvas = element.find('canvas');
            var reader = new FileReader();

            reader.onload = onLoadFile;
            reader.readAsDataURL(params.file);

            function onLoadFile(event) {
                var img = new Image();
                img.onload = onLoadImage;
                img.src = event.target.result;
            }

            function onLoadImage() {
                var width = params.width || this.width / this.height * params.height;
                var height = params.height || this.height / this.width * params.width;
                canvas.attr({
                    width: width,
                    height: height
                });
                canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
            }
        }
    };
}]).directive('autocompitem', [function($parse) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-item" />',
        link: function(scope, element, attrs) {
            function rupiah(val) {
                var number_string = val.toString();
                var sisa = number_string.length % 3;
                var rupiah = number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchItem,
                    minLength: 3,
                    select: function(event, ui) {
                        event.preventDefault();
                        if (ui.item.id == "0" || ui.item.id == 0) {
                            angular.element('#search-item').val('');
                            return;
                        } else {
                            scope.itemAdd({
                                id: ui.item.id,
                                name: ui.item.name,
                                qty: ui.item.qty > 0 ? 1 : ui.item.qty,
                                price: ui.item.price_sell
                            });
                            angular.element('#search-item').val('');
                        }
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + " - <span class='text-capitalize'>Stock: " + item.qty + "</span>" +"</a>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocompbook', [function($parse) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-book" />',
        link: function(scope, element, attrs) {
            function rupiah(val) {
                var number_string = val.toString();
                var sisa = number_string.length % 3;
                var rupiah = number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchItem,
                    minLength: 3,
                    select: function(event, ui) {
                        event.preventDefault();
                        if (ui.item.id == "0" || ui.item.id == 0) {
                            angular.element('#search-book').val('');
                            return;
                        } else {
                            scope.itemAdd({
                                id: ui.item.id,
                                name: ui.item.name,
                                qty: ui.item.qty > 0 ? 1 : ui.item.qty,
                                price: ui.item.price_sell,
                                deposit_before: 0
                            });
                            angular.element('#search-book').val('');
                        }
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + " - <span class='text-capitalize'>Stock: " + item.qty + "</span>" +"</a>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocompstamp', [function($parse) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-stamp" />',
        link: function(scope, element, attrs) {
            function rupiah(val) {
                var number_string = val.toString();
                var sisa = number_string.length % 3;
                var rupiah = number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchStamp,
                    minLength: 3,
                    select: function(event, ui) {
                        event.preventDefault();
                        if (ui.item.id == "0" || ui.item.id == 0) {
                            angular.element('#search-stamp').val('');
                            return;
                        } else {
                            scope.itemAdd({
                                id: ui.item.id,
                                name: ui.item.name,
                                qty: ui.item.qty,
                                price: ui.item.price_sell
                            });
                            angular.element('#search-stamp').val('');
                        }
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name.replace(regex, "<span class='font-bold'>" + this.term + "</span>") + " - <span class='text-capitalize'>Stock: " + item.qty + "</span>" +"</a>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocomptuition', [function($parse) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-tuition" />',
        link: function(scope, element, attrs) {
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchTuition,
                    minLength: 3,
                    select: function(event, ui) {
                        event.preventDefault();
                        if (ui.item.id == "0" || ui.item.id == 0) {
                            angular.element('#search-tuition').val('');
                            return;
                        } else {
                            scope.tuitionAdd({
                                id: ui.item.id,
                                name: ui.item.name,
                                qty: 1,
                                price: ui.item.price
                            });
                            angular.element('#search-tuition').val('');
                        }
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append(
                            "<div>"
                                + "<a>" +
                                    "<div>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + "</div>"
                                + "</a>" +
                            "</div>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocompstock', [function($parse, $filter) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-stock-opname" />',
        link: function(scope, element, attrs) {
            function rupiah(val) {
                var number_string = val.toString();
                var sisa = number_string.length % 3;
                var rupiah = number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchItem,
                    minLength: 3,
                    select: function(event, ui) {
                        if (ui.item.id == "0" || ui.item.id == 0) {
                            angular.element('#search-stock-opname').val('');
                            return;
                        } else {
                            scope.trStockOpnameAdd({
                                item_id: ui.item.code,
                                price_purchase_app: 0,
                                price_purchase_phx: 0,
                                price_purchase_difference: 0,
                                price_sell_app: ui.item.price_sell,
                                price_sell_phx: 0,
                                price_sell_difference: 0,
                                stock_in_system: ui.item.qty,
                                stock_in_phx: 0,
                                stock_difference: 0,
                                category: ui.item.category,
                            });
                            angular.element('#search-stock-opname').val('');
                        }
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append(
                            "<div>"
                                + "<a>" +
                                    "<div>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + "</div>"
                                + "</a>" +
                            "</div>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocompstudent', [function($parse, $filter) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-student" />',
        link: function(scope, element, attrs) {
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchStudent,
                    minLength: 3,
                    select: function(event, ui) {
                        angular.element('#search-student').val('');
                        scope.getStudent({id: ui.item.id});
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + "</a>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocompurch', [function($parse, $filter) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-tr-purchase-order" />',
        link: function(scope, element, attrs) {
            function rupiah(val) {
                var number_string = val.toString();
                var sisa = number_string.length % 3;
                var rupiah = number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchItem,
                    minLength: 3,
                    select: function(event, ui) {
                        if (ui.item.id == "0" || ui.item.id == 0) {
                            angular.element('#search-tr-purchase-order').val('');
                            return;
                        } else {
                            scope.itemAdd({
                                id: ui.item.id,
                                name: ui.item.name,
                                qty: 1,
                                qty_bonus: 0,
                                price_buy: ui.item.price_buy,
                                // price_buy: ui.item.price_sell - (ui.item.price_sell * 0.25),
                                price_sell: ui.item.price_sell,
                                discount: ui.item.price_sell > 0 ? (ui.item.price_sell - ui.item.price_buy) / ui.item.price_sell : 1
                            });
                            angular.element('#search-tr-purchase-order').val('');
                        }
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append(
                            "<div>"
                                + "<a>" +
                                    "<div>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + "</div>"
                                + "</a>" +
                            "</div>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocompurchstamp', [function($parse, $filter) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-tr-purchase-order-stamp" />',
        link: function(scope, element, attrs) {
            function rupiah(val) {
                var number_string = val.toString();
                var sisa = number_string.length % 3;
                var rupiah = number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchStamp,
                    minLength: 3,
                    select: function(event, ui) {
                        if (ui.item.id == "0" || ui.item.id == 0) {
                            angular.element('#search-tr-purchase-order-stamp').val('');
                            return;
                        } else {
                            scope.stampAdd({
                                id: ui.item.id,
                                name: ui.item.name,
                                qty: 1,
                                price_buy: ui.item.price,
                                discount: 0
                            });
                            angular.element('#search-tr-purchase-order-stamp').val('');
                        }
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append(
                            "<div>"
                                + "<a>" +
                                    "<div>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + "</div>"
                                + "</a>" +
                            "</div>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocompitemcard', [function($parse, $filter) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-item" />',
        link: function(scope, element, attrs) {
            function rupiah(val) {
                var number_string = val.toString();
                var sisa = number_string.length % 3;
                var rupiah = number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchItem,
                    minLength: 0,
                    select: function(event, ui) {
                        scope.cartSelect({
                            id: ui.item.id,
                            name: ui.item.name,
                        });
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name.replace(regex, "<span class='font-bold'>" + this.term + "</span>") + "</a>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]).directive('autocomprepstudent', [function($parse, $filter) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input type="text" id="search-rep-student" />',
        link: function(scope, element, attrs) {
            scope.$watch(attrs.selection, function(selection) {
                // event when select item
                element.on("autocompleteselect", function(e, ui) {
                    e.preventDefault(); // prevent the "value" being written back after we've done our own changes
                    this.value = ui.item.name;
                });

                element.autocomplete({
                    source: scope.searchStudent,
                    minLength: 0,
                    select: function(event, ui) {
                        scope.getStudent({id: ui.item.id});
                    }
                })
                .focus(function () {
                    $(this).autocomplete("search");
                })
                .data("ui-autocomplete")._renderItem = function(ul, item) {
                    var regex = new RegExp(this.term, "gi");
                    if (item.id == 0) {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<div class='text-center text-capitalize'>" + item.name + "</div>")
                        .appendTo(ul);
                    } else {
                        return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.name.replace(regex, "<span class='font-bold text-uppercase'>" + this.term + "</span>") + "</a>")
                        .appendTo(ul);
                    }
                };
            });
        }
    };
}]);
