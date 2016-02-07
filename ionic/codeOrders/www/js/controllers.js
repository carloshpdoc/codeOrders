/**
 * Created by VBCN on 04/02/2016.
 */

angular.module('starter.controllers',[])

    .controller('LoginCtrl',['$scope','$http','$state','OAuth','OAuthToken',
        function($scope, $http,$state,OAuth,OAuthToken) {

            $scope.login = function (data) {

                OAuth.getAccessToken(data).then(function () {
                   $state.go('tabs.orders');
                 // console.log(OAuthToken.getToken());
                }, function (data) {
                    $scope.error_login = "Usuário ou senha inválidos";
                });
            }
        }
    ])
.controller('OrdersCtrl',['$scope','$http','$state',
    function($scope, $http, $state){

            $scope.getOrders=function(){
                $http.get('http://localhost:8888/orders').then(
                    function(data){
                        $scope.orders = data.data._embedded.orders;
                        //console.log(data.orders);

                })
            };

        $scope.doRefresh = function(){
            $scope.getOrders();
            $scope.$broadcast('scroll.refreshComplete');
        };

        $scope.onOrderDelete =function(data){
          // console.log(data);
            $http.delete('http://localhost:8888/orders/'+data).then(
                function(data) {
                    $scope.getOrders();
                })
        };

        $scope.getOrders();

    }
])