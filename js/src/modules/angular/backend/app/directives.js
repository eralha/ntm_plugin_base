var directives = angular.module('appDirectives');

	directives.directive('dirOpenPanel', ['$rootScope', '$injector', '$filter', '$sce', function($rootScope, $injector, $filter, $sce) {
		return {
			restrict: 'A',
			compile: function(e, a){
				  //console.log($(e).html(), arguments);
				  return function(scope, elem, attrs) {

					var $ = jQuery;

					$(elem).click(function(){
						$(this).toggleClass('open');
					});

				  }
			  }
		};
	  }]);


	directives.directive('dirListPager', ['$rootScope', '$injector', '$compile', '$filter', 
		function($rootScope, $injector, $compile, $filter) {
		return {
			restrict: 'EAC',
			compile: function(e, a){
					//console.log($(e).html(), arguments);
					return function(scope, elem, attrs) {

						var $scope = scope;
						var obj = attrs.dirListPager;

						$scope.currentPage = 0;
						$scope.pageSize = 50;

						var pagesLength = $scope[obj];

						$scope.$watch(function(){
							return $scope[obj];
						}, function(newValue){
							pagesLength = newValue.length;
						});

						console.log($scope[obj]);

						pagesLength = pagesLength.length || 0;

						$scope.numberOfPages = function(){
							return Math.ceil(pagesLength/$scope.pageSize);                
						}

						$scope.nextPage = function(){
							if($scope.currentPage >= pagesLength/$scope.pageSize - 1){ return; }
							$scope.currentPage = $scope.currentPage+1;

							$("html, body").stop().animate({scrollTop: 0}, 1000, 'swing');
						}

						$scope.prevPage = function(){
							if($scope.currentPage == 0){ return; }
							$scope.currentPage = $scope.currentPage - 1;

							$("html, body").stop().animate({scrollTop: 0}, 1000, 'swing');
						}
						
					}//end return
			}
		};
	}]);