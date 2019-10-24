var candidaturas = angular.module('appCandidaturas');


	candidaturas.directive('dirListaCandidaturas', ['$rootScope', '$injector', '$filter', '$sce', function($rootScope, $injector, $filter, $sce) {
		return {
			restrict: 'C',
			templateUrl: window.pluginsDir+'/templates/backend/dir_lista_candidaturas.php',
			compile: function(e, a){
				  //console.log($(e).html(), arguments);
				  return function(scope, element, attrs) {
  
				  }
			  }
		};
	  }]);
	
	candidaturas.controller('listaCandidaturasController', ['$scope', '$rootScope', 'dataService', '$filter', function($scope, $rootScope, dataService, $filter) {

		$scope.state = 'todos';
		$scope.candidaturas = [];
		$scope.pluginsDir = window.pluginsDir;

		//verifica se existe o ID de uma candidatura no URL
		var loc = window.location.href;
		var searchKey = '&idcandidatura=';
		if(loc.indexOf(searchKey) != -1){
			var id = String(window.location).split(searchKey);
				id = id[id.length - 1];
			
			$scope.candidaturaSelectedId = id;
		}

		$scope.$watch('state', function(newValue, oldValue){
			$scope.candidaturas = [];
			if(newValue == 'todos'){
				$scope.getMessages();
			}
			if(newValue == 'arquivo'){
				$scope.getArquivo();
			}
		});

		$scope.setState = function(state){
			$scope.state = state;

			if($scope.candidaturaSelectedId){
				$scope.candidaturaSelectedId = null;
				$scope.getMessages();
			}
		}

		$scope.filtraCandidaturas = function(){
			$scope.candidaturas = angular.copy($scope.dataSet);

			//se o valor for 0 não filtramos nada, o data set fica completo
			if($scope.filtro_oferta_id == ''){ return; }

			console.log($scope.filtro_oferta_id);

			$scope.candidaturas = $filter('filter')($scope.candidaturas, {iIDPost: parseInt($scope.filtro_oferta_id)}, true);
		}

		$scope.getOfertasEmprego = function(){
			dataService.getData({
				action : 'getOfertasEmprego'
			}).then(function(data){
				$scope.ofertasEmprego = data;
			});
		}
		//Vai buscr as ofertas de emprego para filtros
		$scope.getOfertasEmprego();
		
		//vais buscar as candidaturas
		$scope.getMessages = function(){
			dataService.getData({
				action : 'getCandidaturas'
			}).then(function(data){
				$scope.dataSet = data;
				$scope.candidaturas = angular.copy(data);
				$scope.currentPage = 0;

				//mostra apenas a candidatura que tiver ID no URK
				if($scope.candidaturaSelectedId){
					$scope.candidaturas = $filter('filter')($scope.candidaturas, {iIDCandidatura: parseInt($scope.candidaturaSelectedId)}, true);
				}

				console.log($scope.candidaturaSelectedId, $scope.candidaturas);
			});
		}

		$scope.getArquivo = function(){
			dataService.getData({
				action : 'getArquivoCandidaturas'
			}).then(function(data){
				$scope.candidaturas = data;
				$scope.currentPage = 0;
			});
		}

		$scope.deleteCandidatura = function(id){
			for(var i = 0; i < $scope.candidaturas.length; i++){
				if($scope.candidaturas[i].iIDCandidatura == id){
					$scope.candidaturas[i].delleting = true;
				}
			}

			dataService.getData({
				action : 'deleteCandidatura',
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

		$scope.arquivarCandidatura = function(id){
			for(var i = 0; i < $scope.candidaturas.length; i++){
				if($scope.candidaturas[i].iIDCandidatura == id){
					$scope.candidaturas[i].delleting = true;
				}
			}

			dataService.getData({
				action : 'arquivarCandidatura',
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

		$scope.restaurarCandidatura = function(id){
			for(var i = 0; i < $scope.candidaturas.length; i++){
				if($scope.candidaturas[i].iIDCandidatura == id){
					$scope.candidaturas[i].delleting = true;
				}
			}

			dataService.getData({
				action : 'restaurarCandidatura',
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