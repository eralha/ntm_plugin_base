var app = angular.module('app', ['appServices', 'appDirectives', 'appContactos', 'appSettings']);

	app.filter('startFrom', function() {
		return function(input, start) {
			start = +start; //parse to int
			return input.slice(start);
		}
	});


angular.bootstrap(document, ['app']);