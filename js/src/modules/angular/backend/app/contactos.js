var candidaturas = angular.module('appContactos', ['appServices']);


    candidaturas.directive('dirListaContactos', ['$rootScope', '$injector', '$filter', '$sce', function($rootScope, $injector, $filter, $sce) {
        return {
            restrict: 'C',
            templateUrl: window.pluginsDir+'/templates/backend/dir_lista_contactos.php',
            compile: function(e, a){
                //console.log($(e).html(), arguments);
                return function(scope, element, attrs) {

                }
            }
        };
    }]);
	
	//generic controlers go here
    candidaturas.controller('listaContactosController', ['$scope', '$rootScope', 'dataService', function($scope, $rootScope, dataService) {

		$scope.state = 'todos';

		$scope.$watch('state', function(newValue, oldValue){
			$scope.contacts = [];
			if(newValue == 'todos'){
				$scope.getMessages();
			}
			if(newValue == 'arquivo'){
				$scope.getArquivo();
			}
		});

		$scope.setState = function(state){
			$scope.state = state;
		}

		$scope.getMessages = function(){
			dataService.getData({
				action : 'getContacts'
			}).then(function(data){
				$scope.contacts = data;
				$scope.currentPage = 0;
			});
		}

		$scope.getArquivo = function(){
			dataService.getData({
				action : 'getArquivoContacts'
			}).then(function(data){
				$scope.contacts = data;
				$scope.currentPage = 0;
			});
		}

		$scope.deleteContact = function(id){
			for(var i = 0; i < $scope.contacts.length; i++){
				if($scope.contacts[i].iIDContacto == id){
					$scope.contacts[i].delleting = true;
				}
			}

			dataService.getData({
				action : 'deleteContact',
				msgId : id
			}).then(function(data){
				if(data == 1 && $scope.state == 'todos'){ 
					$scope.getMessages(); 
				}
				if(data == 1 && $scope.state == 'arquivo'){ 
					$scope.getArquivo(); 
				}
			});
		}

		$scope.arquivarContact = function(id){
			for(var i = 0; i < $scope.contacts.length; i++){
				if($scope.contacts[i].iIDContacto == id){
					$scope.contacts[i].delleting = true;
				}
			}

			dataService.getData({
				action : 'arquivarContact',
				msgId : id
			}).then(function(data){
				if(data == 1 && $scope.state == 'todos'){ 
					$scope.getMessages(); 
				}
				if(data == 1 && $scope.state == 'arquivo'){ 
					$scope.getArquivo(); 
				}
			});
		}

		$scope.restaurarContact = function(id){
			for(var i = 0; i < $scope.contacts.length; i++){
				if($scope.contacts[i].iIDContacto == id){
					$scope.contacts[i].delleting = true;
				}
			}

			dataService.getData({
				action : 'restaurarContact',
				msgId : id
			}).then(function(data){
				if(data == 1){ 
					$scope.getMessages(); 
					$scope.state = 'todos';
				}
			});
		}

		$scope.getDate = function(time){
			var date = new Date(time*1000);
			return date.getDate()+'/'+(date.getMonth()+1)+'/'+date.getFullYear() +' - '+ date.getHours()+':'+date.getMinutes();
		}

	}]);