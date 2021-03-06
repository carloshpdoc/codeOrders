/**
 * Created by VBCN on 04/02/2016.
 */

angular.module('starter.controllers',[])

    .controller('LoginCtrl',['$scope','$http','$state','OAuth','OAuthToken','$localStorage',
        function($scope, $http,$state,OAuth,OAuthToken,$localStorage) {
         /* console.log($localStorage.setObject('oauth',{
              access_token:'asdiasodiasdhasiduohasodi',
              refresh_token:'trooasodqwpejoqdw'
          }));*/
            /*console.log($localStorage.getObject('oauth'));
            console.log($localStorage.getObject('label_2','outroovalor'));*/
            $scope.login = function (data) {

                OAuth.getAccessToken(data).then(function () {

                   $state.go('tabs.orders');
                   // console.log(OAuthToken.getToken());
                }, function (data) {
                    $scope.error_login = data;
                    //$scope.error_login = "Usuário ou senha inválidos";
                });
            }
        }
    ])
.controller('OrdersCtrl',['$scope','$http','$state',
    function($scope, $http, $state){

        $scope.getOrders=function(){

            $http.get('http://192.168.100.9:8888/orders').then(
                function(data){
                    $scope.orders = data.data._embedded.orders;
                    //console.log(data.orders);
            })
        };

        $scope.show = function(order){
            $state.go('tabs.show',{id: order.id})
        };

        $scope.doRefresh = function(){
            $scope.getOrders();
            $scope.$broadcast('scroll.refreshComplete');
        };

        $scope.onOrderDelete =function(data){
            $http.delete('http://192.168.100.9:8888/orders/'+data).then(
                function(data) {
                    $scope.getOrders();
                })
        };

        $scope.getOrders();
    }
])
    .controller('OrderShowCtrl', ['$scope','$http','$stateParams',
        function($scope, $http, $stateParams){

            $scope.getOrder = function(){
                $http.get('http://192.168.100.9:8888/orders/' + $stateParams.id).then(
                    function(data){
                        $scope.order =data.data;
                    }
                )
            };

            $scope.getOrder();
        }
     ])
    .controller('OrdersNewCtrl',['$scope','$http','$state','$window',
        function($scope,$http,$state,$window){

            $scope.clients=[];
            $scope.ptypes =[];
            $scope.products =[];
            $scope.statusList = ["Pedente","Processando", "Entregue"];

            $scope.resetOrder = function(){
                $scope.order ={
                    client_id:'',
                    ptype_id:'',
                    item:[]
                };
            };

            $scope.getClients =function(){
                $http.get('http://192.168.100.9:8888/clients').then(
                    function(data){
                        $scope.clients= data.data._embedded.clients;
                    }
                )
            };

            $scope.getPtypes =function(){
                $http.get('http://192.168.100.9:8888/ptypes').then(
                    function(data){
                        $scope.ptypes= data.data._embedded.ptypes;
                    }
                )
            };

            $scope.getProducts=function(){
                $http.get('http://192.168.100.9:8888/products').then(
                    function(data){
                        $scope.products= data.data._embedded.products;
                    }
                )
            };

            $scope.setPrice = function(index) {
                var product_id = $scope.order.item[index].product_id;
                for (var i in $scope.products) {
                    if ($scope.products.hasOwnProperty(i) && $scope.products[i].id == product_id) {
                        $scope.order.item[index].price = $scope.products[i].price;
                        break;
                    }
                }

                $scope.calculateTotalRow(index);
            };

            $scope.addItem = function(){
                $scope.order.item.push({
                    product_id: '',
                    quantity:'',
                    price: 0,
                    total: 0
                });
            };

            $scope.calculateTotalRow = function(index){
                $scope.order.item[index].total = $scope.order.item[index].quantity * $scope.order.item[index].price;
              //  calculateTotal();
            };

            $scope.calculateTotal = function(){
                $scope.order.total = 0;
                for (var i in $scope.order.item){
                    if($scope.order.item.hasOwnProperty(i)){
                        $scope.order.total += $scope.order.item[i].total;
                    }
                }
            };

            $scope.save = function (){
                $http.post('http://192.168.100.9:8888/orders', $scope.order).then(
                    function (data) {
                        $scope.resetOrder();
                        $state.go('tabs.orders');
                        $window.location.reload(true);
                    }
                )
            };

            $scope.resetOrder();
            $scope.getClients();
            $scope.getPtypes();
            $scope.getProducts();
        }
    ])

    .controller('LogoutCtrl', ['$scope','logout','$state',
       function($scope,logout,$state ){

            $scope.logout = function(){
                logout.logout();
               $state.go('login');
            };
       }
    ])

    .controller('RefreshModalCtrl', [
        '$rootScope','$scope','OAuth','authService','$timeout','$state','OAuthToken','logout',
        function($rootScope,$scope,OAuth,authService,$timeout, $state, OAuthToken, logout){

            function destroyModal(){
              if($rootScope.modal){
                  $rootScope.modal.hide();
                  $rootScope.modal = false;
              }
            }

          $scope.$on('event:auth-loginConfirmed',function(){
             destroyModal();
          });

          $scope.$on('event:auth-loginCancelled',function(){
               destroyModal();
              logout.logout();
          });

          $scope.$on('$stateChangeStart',
                function(event,toState, toParams, fromState, fromParams){
                    if($rootScope.modal){
                        authService.loginCancelled();
                        event.preventDefault();
                        $state.go('login');
                   }
          });

          OAuth.getRefreshToken().then(function(){
            $timeout(function(){
                authService.loginConfirmed();
            },10000)
          },function(){
              authService.loginCancelled();
              $state.go('login');
        });
    }]);