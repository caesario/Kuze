var app = angular.module('admFashionGrosir', []);

app.controller('LoginController', function ($scope, $http) {
    angular.element(document).ready(function () {
        $scope.loginValidation = function (valid) {
            if (valid) {
                var data = $.param(
                    {
                        ecommerce_eazy: hashing,
                        loginUsername: $scope.loginUsername,
                        loginPassword: $scope.loginPassword
                    }
                );

                var post = {
                    method: "POST",
                    url: base_url + "adm.php/auth/login",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                    },

                    data: data
                };

                $http(post).then(function success(res) {
                    console.log(res.data);
                    $scope.xxx = res.data;
                    window.location.href = base_url + "adm.php#!/dashboard";
                }, function error(res) {
                    console.log(res);
                });
            } else {

            }
        }
    });
});