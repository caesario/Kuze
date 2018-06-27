var app = angular.module('admFashionGrosir', ['ngRoute', 'rzModule', 'ui.bootstrap']);

// FACTORY
app.factory('LoadingListener', ['$q', '$rootScope', function ($q, $rootScope) {
    var reqsActive = 0;

    function onResponse() {
        reqsActive--;
        if (reqsActive === 0) {
            $rootScope.$broadcast('loading:completed');
        }
    }

    return {
        'request': function (config) {
            if (reqsActive === 0) {
                $rootScope.$broadcast('loading:started');
            }
            reqsActive++;
            return config;
        },
        'response': function (response) {
            if (!response || !response.config) {
                return response;
            }
            onResponse();
            return response;
        },
        'responseError': function (rejection) {
            if (!rejection || !rejection.config) {
                return $q.reject(rejection);
            }
            onResponse();
            return $q.reject(rejection);
        },
        isLoadingActive: function () {
            return reqsActive === 0;
        }
    };
}]);

app.factory('Page', function () {
    var title = 'Default';
    return {
        title: function () {
            return title;
        },
        setTitle: function (newTitle) {
            title = newTitle;
        }
    };
});

app.factory('Key', ['$http', function ($http) {
    var key = {};

    key.kategori = function () {
        return $http.get(base_url + 'adm.php/kategori/get_key')
    };

    key.item = function () {
        return $http.get(base_url + 'adm.php/item/get_key')
    };

    return key;
}]);
// END FACTORY

// DIRECTIVE
app.directive('loadingListener', ['$rootScope', 'LoadingListener', function ($rootScope, LoadingListener) {
    return {
        restrict: 'CA',
        link: function linkFn(scope, elem, attr) {
            if (!LoadingListener.isLoadingActive()) {
                $('.loading-content').LoadingOverlay('hide');
            }

            $rootScope.$on('loading:started', function () {
                $('.loading-content').LoadingOverlay('show', {
                    image: "",
                    fontawesome: "fa fa-cog fa-spin"
                });
            });
            $rootScope.$on('loading:completed', function () {
                $('.loading-content').LoadingOverlay('hide');
            });
        }
    };
}]);

app.directive('realTimeCurrency', function ($filter, $locale) {
    var decimalSep = $locale.NUMBER_FORMATS.DECIMAL_SEP;
    var toNumberRegex = new RegExp('[^0-9\\' + decimalSep + ']', 'g');
    var filterFunc = function (value) {
        return $filter('currency')(value, '');
    };

    function getCaretPosition(input) {
        if (!input) return 0;
        if (input.selectionStart !== undefined) {
            return input.selectionStart;
        } else if (document.selection) {
            // Curse you IE
            input.focus();
            var selection = document.selection.createRange();
            selection.moveStart('character', input.value ? -input.value.length : 0);
            return selection.text.length;
        }
        return 0;
    }

    function setCaretPosition(input, pos) {
        if (!input) return 0;
        if (input.offsetWidth === 0 || input.offsetHeight === 0) {
            return; // Input's hidden
        }
        if (input.setSelectionRange) {
            input.focus();
            input.setSelectionRange(pos, pos);
        }
        else if (input.createTextRange) {
            // Curse you IE
            var range = input.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }

    function toNumber(currencyStr) {
        return parseFloat(currencyStr.replace(toNumberRegex, ''), 10);
    }

    return {
        restrict: 'A',
        require: 'ngModel',
        link: function postLink(scope, elem, attrs, modelCtrl) {
            modelCtrl.$formatters.push(filterFunc);
            modelCtrl.$parsers.push(function (newViewValue) {
                var oldModelValue = modelCtrl.$modelValue;
                var newModelValue = toNumber(newViewValue);
                modelCtrl.$viewValue = filterFunc(newModelValue);
                var pos = getCaretPosition(elem[0]);
                elem.val(modelCtrl.$viewValue);
                var newPos = pos + modelCtrl.$viewValue.length -
                    newViewValue.length;
                if ((oldModelValue === undefined) || isNaN(oldModelValue)) {
                    newPos -= 3;
                }
                setCaretPosition(elem[0], newPos);
                return newModelValue;
            });
        }
    };
});
// END DIRECTIVE

// CONFIG
// app.config('$locationProvider', function ($locationProvider) {
//     $locationProvider.hashPrefix('?');
// });

app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.interceptors.push('LoadingListener');
}]);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/dashboard', {
            templateUrl: base_url + "adm.php/navigasi/dashboard",
            reloadOnSearch: false
        })
        // Item Controller
        .when('/item/kategori/:id', {
            templateUrl: function (param) {
                return base_url + "adm.php/navigasi/item";
            },
            reloadOnSearch: false
        })
        .when('/item/kategori_new', {
            templateUrl: base_url + "adm.php/kategori/baru",
            reloadOnSearch: false
        })
        .when('/item/kategori_edit/:id', {
            templateUrl: function (param) {
                return base_url + "adm.php/kategori/edit/" + param.id
            },
            reloadOnSearch: false
        })
        .when('/item/kategori_hapus/:id', {
            templateUrl: function (param) {
                return base_url + "adm.php/kategori/hapus/" + param.id
            },
            reloadOnSearch: false
        })
        .when('/item/item_new', {
            templateUrl: base_url + "adm.php/item/baru",
            reloadOnSearch: false
        })
        .when('/item/item_edit/:id', {
            templateUrl: function (param) {
                return base_url + "adm.php/item/edit/" + param.id
            },
            reloadOnSearch: false
        })
        .when('/item/item_hapus/:id', {
            templateUrl: function (param) {
                return base_url + "adm.php/item/hapus/" + param.id
            },
            reloadOnSearch: false
        })
        .when('/customers', {
            templateUrl: base_url + "adm.php/navigasi/customers",
            reloadOnSearch: false
        })
        .when('/item/:action/:id', {
            templateUrl: function (param) {
                return base_url + "adm.php/item/" + param.action + "/" + param.id;
            },
            reloadOnSearch: false
        });
});
// END CONFIG


// CONTROLLER
app.controller('MainController', function ($scope, $http, $location, Page) {
    $scope.Page = Page;
    $scope.itemsIsCollapsed = true;
    $scope.transaksiIsCollapsed = true;
    $scope.limitChar = 20;

    angular.element(document).ready(function () {
        $scope.init = function () {
            $http({
                method: "GET",
                url: base_url + "adm.php/get/list_kategori"
            }).then(function (res) {
                $scope.kategories = res.data;
            }, function (res) {
                console.log(res.data);
            });
        };

        $scope.init();
    });
});

app.controller('DashboardController', function ($scope, $http, Page) {
    // judul
    Page.setTitle('Dashboard');
    angular.element(document).ready(function () {
        $http({
            method: "GET",
            url: base_url + "adm.php/get/total_customers"
        }).then(function (res) {
            $scope.total_customers = res.data;
        }, function (res) {
            console.log(res.statusText);
        });

        $http({
            method: "POST",
            url: base_url + "adm.php/dashboard/dashboard_totalitem",
            data: $.param(
                {
                    ecommerce_eazy: hashing
                }
            )
        }).then(function (res) {
            $scope.total_items = res.data;
        }, function (res) {
            console.log(res.statusText);
        });
    });
});

app.controller('ItemsController', function ($scope, $http, Page, $routeParams, $q) {
    // judul
    Page.setTitle('Items');

    // init
    $scope.init = function () {

        $scope.get_kategori = $http.get(base_url + "adm.php/get/kategori/" + $routeParams.id, {cache: false});
        // $scope.get_range_hrg = $http.get(base_url + "adm.php/item/range_harga", {cache: false});

        $q.all([$scope.get_kategori]).then(function (values) {

            // var min = parseInt(values[1].data.min[0]['item_harga1']);
            // var max = parseInt(values[1].data.max[0]['item_harga1']);
            // $scope.slider = {
            //     minValue: min + 10000,
            //     maxValue: max - 10000,
            //     options: {
            //         floor: min,
            //         ceil: max,
            //         draggableRange: true,
            //         translate: function (value, sliderId, label) {
            //             switch (label) {
            //                 case 'model':
            //                     return '<b>Hrg. min:</b> Rp.' + value;
            //                 case 'high':
            //                     return '<b>Hrg. max:</b> Rp.' + value;
            //                 default:
            //                     return 'Rp.' + value
            //             }
            //         }
            //     }
            // };

            $scope.items = values[0].data;
        });

    };

    $scope.init();

});

app.controller('CustomersController', function ($scope, $http, Page) {
    // judul
    Page.setTitle('Customers');
});

app.controller('CrudKategoriController', function (Page, Key, $scope, $http) {
    Page.setTitle('Items > Kategori');

    $scope.limitChar = 20;
    $scope.showmodal = false;
    $scope.getkey = function () {
        Key.kategori()
            .then(function (res) {
                $scope.primarykey = res.data;
            }, function (error) {
                console.log(error.message)
            })
    };

    $scope.showCRUD = function () {
        $scope.getkey();
        $scope.b_kat_nama = "";
        $scope.b_kat_parent_id = "";
    };

    $scope.ubahKategori = function (index) {
        $scope.init = function () {
            $http({
                method: "GET",
                url: base_url + "adm.php/kategori/get/" + index
            }).then(function (res) {
                $scope.u_kat_nama = res.data.Kat_Nama;
                $scope.u_kat_parent_id = res.data.Kat_Parent_ID;
            }, function (res) {
                console.log(res.data);
            });
        };

        $scope.init();

        // $scope.entt = $scope.kategories[Kat_ID];
        // $scope.u_kat_nama = $scope.entt.Kat_Nama;
        // $scope.u_kat_parent_i = $scope.entt.Kat_Parent_ID;

    };

    $scope.updateKategori = function () {

    };

    $scope.buatKategori = function (valid) {
        if (valid) {
            var data = $.param(
                {
                    ecommerce_eazy: hashing,
                    id: $scope.primarykey,
                    nama: $scope.b_kat_nama,
                    parent: $scope.b_kat_parent_id
                }
            );

            var post = {
                method: "POST",
                url: base_url + "adm.php/kategori/baru",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                },

                data: data
            };
            $http(post).then(function success(res) {
                $scope.kategories.push(
                    {
                        Kat_ID: $scope.primarykey,
                        Kat_Nama: $scope.b_kat_nama,
                        Kat_Parent_ID: $scope.b_kat_parent_id
                    }
                );
            }, function error(res) {
            });
        }
    };


    $scope.hapusKategori = function () {
        var valid = $scope.showmodal;
        var id = $scope.deleted;
        if (valid && id) {
            $scope.init = function () {
                $http({
                    method: "GET",
                    url: base_url + "adm.php/kategori/hapus/" + id
                }).then(function (res) {
                    console.log(res);
                }, function (res) {
                    console.log(res.data);
                });
            };

            $scope.init();
            $scope.kategories.splice(id, 1);
        }

    };

    $scope.konfirmasihapus = function (index) {
        $scope.showmodal = true;
        $scope.deleted = index;
    };

    angular.element(document).ready(function () {
        $scope.init = function () {
            $http({
                method: "GET",
                url: base_url + "adm.php/get/list_kategori"
            }).then(function (res) {
                $scope.kategories = res.data;
            }, function (res) {
                console.log(res.data);
            });
        };

        $scope.init();
    });
});

app.controller('CtrlKategori', function ($scope, $http) {
    $scope.url = kategori;

    $scope.init = function () {
        $http({
            method: "GET",
            url: $scope.url
        }).then(function (res) {
            $scope.kategories = res.data;
        }, function (res) {
            console.log(res.data);
        });
    };

    $scope.init();

});
// END CONTROLLER