var app = angular.module('erApp', ['formVals']);

	app.factory('dataService', function($http, $q) {

		this.getData = function(postData){

			var defer = $q.defer();
				postData.nonce = window.nonces[postData.action];

			jQuery.post(ajaxurl, postData, function(response) {
				defer.resolve(angular.fromJson(response));
			});

			return defer.promise;

		}

		return this;

	});

	app.directive('erFormContacts', ['$rootScope', '$injector', '$filter', '$sce', function($rootScope, $injector, $filter, $sce) {
	  return {
	  	restrict: 'C',
	  	templateUrl: window.pluginsDir+'/templates/frontend/main.php',
	  	compile: function(e, a){
		        //console.log($(e).html(), arguments);
		        return function(scope, element, attrs) {

		        }
		    }
	  };
	}]);

    //generic controlers go here
    app.controller('myCtrl', ['$scope', '$rootScope', 'dataService', function($scope, $rootScope, dataService) {

        $scope.sendForm = function(){

        	$scope.formContactos.$highlightFields();

        	if($scope.formContactos.$valid){

        		$scope.mensagem = {};
        		$scope.mensagem.clientname = $scope.clientname;
        		$scope.mensagem.last_name = $scope.last_name;
        		$scope.mensagem._email = $scope._email;
        		$scope.mensagem.assunto = $scope.assunto;
        		$scope.mensagem.message = $scope.message;

        		$scope.loading = true;
        		$scope.formError = false;

        		dataService.getData({
					action : 'saveContact',
					data: angular.toJson($scope.mensagem)
				}).then(function(data){
					$scope.loading = false;
					$scope.formSent = false;
					$scope.formError = false;

					if(data == 1){
						//show insertMessage
						$scope.formSent = true;
					}
					if(data == 0){
						//show insertError
						$scope.formError = true;
					}
				});

        	}

        }

    }]);

angular.bootstrap($('.er-form-contacts').get(0), ['erApp']);