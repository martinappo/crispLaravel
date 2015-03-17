var portfolioApp = angular.module('portfolioApp', ['portfolioCtrl', 'singlePortfolioCtrl', 'artworkService', 'ui.sortable']);

portfolioApp.directive('backImg', function(){
	return function(scope, element, attrs){
		var url = attrs.backImg;
		element.css({
			'background-image': 'url(' + url +')',
		});
	};
});