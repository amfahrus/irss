/**
 * api mbti
 * dynamic controller
 */


define([

], function () {
    var app = angular.module("app", ['ngRoute','ngAnimate','LocalStorageModule','ngSanitize']);
    app.config(['$routeProvider','$locationProvider','$httpProvider', function($routeProvider,$locationProvider,$httpProvider){
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $routeProvider.when('/:params',
            {
                template    : '<div data-ng-controller="controller" id="view"></div>',
                controller  : 'DynamicController'
            }
        ).when('/:params/:actions',
            {
                template    : '<div data-ng-controller="controller" id="view"></div>',
                controller  : 'DynamicController'
            }
        ).otherwise({ redirectTo: 'mbti' });
        $locationProvider.hashPrefix("!");
    }]);

    app.controller('DynamicController', function ($scope, $routeParams, $compile) {
        $scope.actions = $routeParams['actions'];
        $scope.controller = function(){};
        require([
            './core/controller/ctrl.' + $routeParams['params'],
            'text!./core/view/'  + $routeParams['params'] + '.html'
        ], function(controller, view){
                $scope.controller = controller;

                var v = angular.element("#view").html(view);
                $compile(v)(v.scope());
                $scope.$apply();
            }
        );
    });
    app.filter('temp', function($filter) {
        return function(input, precision) {
            if (!precision) {
                precision = 1;
            }
            var numberFilter = $filter('number');
            return numberFilter(input, precision) + '\u00B0C';
        };
    });
	app.directive('tooltip', function(){
		return {
			restrict: 'A',
			link: function(scope, element, attrs){
				$(element).hover(function(){
					// on mouseenter
					$(element).tooltip('show');
				}, function(){
					// on mouseleave
					$(element).tooltip('hide');
				});
			}
		};
	});
	app.directive('select2', function(){
		return {
			restrict: 'A',
			link: function(scope, element, attrs){
				$(element).select2();
			}
		};
	});
	app.directive('number', function(){
		return {
			restrict: 'A',
			link: function(scope, element, attrs){
				$(element).numeric({ negative : false, decimal : false });
			}
		};
	});
	app.directive('alphanumeric', function(){
		return {
			restrict: 'A',
			link: function(scope, element, attrs){
				$(element).alphanumeric();
			}
		};
	});
	app.directive('datepicker', function(){
		return {
			restrict: 'A',
			link: function(scope, element, attrs){
				$(element).datepicker({
					format: 'yyyy-mm-dd',
					startDate: attrs.startdate,
					endDate: attrs.enddate,
					autoclose: true,
					todayHighlight: true
				});
			}
		};
	});
	/*app.directive('myModal', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				scope.$watch(attrs.myModal, function(value) {
					if (value) element.modal('show');
					else element.modal('hide');
				});
			}
		};
	});*/
	app.directive("modalShow", function ($parse) {
		return {
			restrict: "A",
			link: function (scope, element, attrs) {
				//Hide or show the modal
				scope.showModal = function (visible, elem) {
					if (!elem)
						elem = element;
					if (visible)
						$(elem).modal("show");                     
					else
						$(elem).modal("hide");
				}
				//Watch for changes to the modal-visible attribute
				scope.$watch(attrs.modalShow, function (newValue, oldValue) {
					scope.showModal(newValue, attrs.$$element);
				});
				//Update the visible value when the dialog is closed through UI actions (Ok, cancel, etc.)
				$(element).bind("hide.bs.modal", function () {
					$parse(attrs.modalShow).assign(scope, false);
					if (!scope.$$phase && !scope.$root.$$phase)
						scope.$apply();
				});
			}
		};
	}); 
    app.directive('weatherIcon', function() {
        return {
            restrict: 'E', replace: true,
            scope: {
                cloudiness: '@'
            },
            controller: function($scope) {
                $scope.imgurl = function() {
                    var baseUrl = 'https://ssl.gstatic.com/onebox/weather/128/';
                    if ($scope.cloudiness < 20) {

                        return baseUrl + 'sunny.png';
                    } else if ($scope.cloudiness < 90) {
                        return baseUrl + 'partly_cloudy.png';
                    } else {
                        return baseUrl + 'cloudy.png';
                    }
                };
            },
            template: '<div style="float:left"><img ng-src="{{ imgurl() }}"></div>'
        };
    });
   app.baseUrlServer = 'http://rekrutmen.brantas-abipraya.co.id/aot/';
    return app;
});


