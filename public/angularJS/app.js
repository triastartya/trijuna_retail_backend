var app = angular.module("app", [],function($interpolateProvider,$locationProvider,$provide){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    $locationProvider.html5Mode(true);
    var PLURAL_CATEGORY = {ZERO: "zero", ONE: "one", TWO: "two", FEW: "few", MANY: "many", OTHER: "other"};
    $provide.value("$locale", {
        "DATETIME_FORMATS": {
        "AMPMS": [
        "AM",
        "PM"
        ],
        "DAY": [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu"
        ],
        "ERANAMES": [
        "Sebelum Masehi",
        "Masehi"
        ],
        "ERAS": [
        "SM",
        "M"
        ],
        "FIRSTDAYOFWEEK": 6,
        "MONTH": [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
        ],
        "SHORTDAY": [
        "Min",
        "Sen",
        "Sel",
        "Rab",
        "Kam",
        "Jum",
        "Sab"
        ],
        "SHORTMONTH": [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Agt",
        "Sep",
        "Okt",
        "Nov",
        "Des"
        ],
        "STANDALONEMONTH": [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
        ],
        "WEEKENDRANGE": [
        5,
        6
        ],
        "fullDate": "EEEE, dd MMMM y",
        "longDate": "d MMMM y",
        "medium": "d MMM y HH.mm.ss",
        "mediumDate": "d MMM y",
        "mediumTime": "HH.mm.ss",
        "short": "dd/MM/yy HH.mm",
        "shortDate": "dd/MM/yy",
        "shortTime": "HH.mm"
    },
    "NUMBER_FORMATS": {
        "CURRENCY_SYM": "Rp",
        "DECIMAL_SEP": ",",
        "GROUP_SEP": ".",
        "PATTERNS": [
        {
            "gSize": 3,
            "lgSize": 3,
            "maxFrac": 3,
            "minFrac": 0,
            "minInt": 1,
            "negPre": "-",
            "negSuf": "",
            "posPre": "",
            "posSuf": ""
        },
        {
            "gSize": 3,
            "lgSize": 3,
            "maxFrac": 0,
            "minFrac": 0,
            "minInt": 1,
            "negPre": "-\u00a4",
            "negSuf": "",
            "posPre": "\u00a4",
            "posSuf": ""
        }
        ]
    },
    "id": "id-id",
    "localeID": "id_ID",
    "pluralCat": function(n, opt_precision) {  return PLURAL_CATEGORY.OTHER;}
    });
});

app.factory('API', function($rootScope, $http){
    var factory = {};
    return factory;
})

app.directive('myEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
});

app.directive('format', ['$filter', function ($filter) {
    return {
        require: '?ngModel',
        link: function (scope, elem, attrs, ctrl) {
            if (!ctrl) return;

            ctrl.$formatters.unshift(function (a) {
                return $filter(attrs.format)(ctrl.$modelValue)
            });

            elem.bind('blur', function(event) {
                var plainNumber = elem.val().replace(/[^\d|\-+|\.+]/g, '');
                elem.val($filter(attrs.format)(plainNumber));
            });
        }
    };
}]);

// Directive
app.directive('inputCurrency', ['$locale', '$filter', function($locale, $filter) {

    // For input validation
    var isValid = function(val) {
        return angular.isNumber(val) && !isNaN(val);
    };

    // Helper for creating RegExp's
    var toRegExp = function(val) {
        var escaped = val.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        return new RegExp(escaped, 'g');
    };

    // Saved to your $scope/model
    var toModel = function(val) {
        // Locale currency support
        var decimal = toRegExp($locale.NUMBER_FORMATS.DECIMAL_SEP);
        var group = toRegExp($locale.NUMBER_FORMATS.GROUP_SEP);
        var currency = toRegExp($locale.NUMBER_FORMATS.CURRENCY_SYM);
        // Strip currency related characters from string
        val = val.replace(decimal, '').replace(group, '').replace(currency, '').trim();
        return parseInt(val, 10);
    };

    // Displayed in the input to users
    var toView = function(val) {
        return $filter('currency')(val, '', 0);
    };

    // Link to DOM
    var link = function($scope, $element, $attrs, $ngModel) {
        $ngModel.$formatters.push(toView);
        $ngModel.$parsers.push(toModel);
        $ngModel.$validators.currency = isValid;

        $element.on('keyup', function() {
            $ngModel.$viewValue = toView($ngModel.$modelValue);
            $ngModel.$render();
        });
    };

    return {
        restrict: 'A',
        require: 'ngModel',
        link: link
    };
}]);

app.directive('onlyNumbers', function () {
    return  {
        restrict: 'A',
        link: function (scope, elm, attrs, ctrl) {
            elm.on('keydown', function (event) {
                if(event.shiftKey){event.preventDefault(); return false;}
                //console.log(event.which);
                if ([8, 13, 27, 37, 38, 39, 40].indexOf(event.which) > -1) {
                    // backspace, enter, escape, arrows
                    return true;
                } else if (event.which >= 48 && event.which <= 57) {
                    // numbers
                    return true;
                } else if (event.which >= 96 && event.which <= 105) {
                    // numpad number
                    return true;
                }
                // else if ([110, 190].indexOf(event.which) > -1) {
                //     // dot and numpad dot
                //     return true;
                // }
                else {
                    event.preventDefault();
                    return false;
                }
            });
        }
    }
});

app.directive('noFloat', function () {
    return  {
        restrict: 'A',
        link: function (scope, elm, attrs, ctrl) {
            elm.on('keydown', function (event) {
                if ([110, 190].indexOf(event.which) > -1) {
                    // dot and numpad dot
                    event.preventDefault();
                    return false;
                }
                else{
                    return true;
                }
            });
        }
    }
});

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *     example 10: number_format('1.20', 2);
    // *     returns 10: '1.20'
    // *     example 11: number_format('1.20', 4);
    // *     returns 11: '1.2000'
    // *     example 12: number_format('1.2000', 3);
    // *     returns 12: '1.200'
    var n = number, prec = decimals;

    var toFixedFix = function (n,prec) {
        var k = Math.pow(10,prec);
        return (Math.round(n*k)/k).toString();
    };

    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = toFixedFix(Math.abs(n), prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
            _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    var decPos = s.indexOf(dec);
    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
    }
    else if (prec >= 1 && decPos === -1) {
        s += dec+new Array(prec).join(0)+'0';
    }
    return s;
}