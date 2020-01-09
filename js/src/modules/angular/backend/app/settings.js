var settings = angular.module('appSettings', ['appServices']);


    settings.directive('dirListaSettings', ['$rootScope', '$injector', '$filter', '$sce', function($rootScope, $injector, $filter, $sce) {
        return {
            restrict: 'C',
            templateUrl: window.pluginsDir+'/templates/backend/dir_lista_settings.php',
            compile: function(e, a){
                //console.log($(e).html(), arguments);
                return function(scope, element, attrs) {

                }
            }
        };
    }]);
	
	//generic controlers go here
    settings.controller('listaSettingsController', ['$scope', '$rootScope', 'dataService', function($scope, $rootScope, dataService) {

        $scope.formData = {};

		$scope.saveSettings = function(id){

            if($scope.formData.secret == '' || $scope.formData.siteKey == ''){ return; }

			dataService.getData({
				action : 'saveSettings',
                vchCaptchaSecret : $scope.formData.vchCaptchaSecret,
                vchCaptchaSiteKey : $scope.formData.vchCaptchaSiteKey,
                vchFromEmail : $scope.formData.vchFromEmail,
                vchFromName : $scope.formData.vchFromName,
                vchEmailGestao : $scope.formData.vchEmailGestao
			}).then(function(data){
				if(data == 1){ 
					$scope.state = 'success';
				}
				if(data =! 1){ 
					$scope.state = 'error';
				}
			});
		}

		$scope.getSettings = function(id){
			dataService.getData({
				action : 'getSettings'
			}).then(function(data){
                console.log(data);
                if(data.iID){
                    $scope.formData = data;
                }
			});
        }
        //get current settings
        $scope.getSettings();

	}]);