var services = angular.module('appServices');

	services.factory('dataService', function($http, $q) {

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