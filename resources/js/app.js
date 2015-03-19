var portfolioApp = angular.module('portfolioApp', ['portfolioCtrl', 'singlePortfolioCtrl', 'artworkService', 'ui.sortable']);

portfolioApp.directive('backImg', function(){
	return function(scope, element, attrs){
		var url = attrs.backImg;
		$('<img/>').attr('src', url).load(function() {
			element.css({
				'background-image': 'url(' + url +')',
			});
		});
	};
});

portfolioApp.directive('backImgFade', function(){
	return function(scope, element, attrs){

		var url = attrs.backImgFade;
		element.hide();
		$('<img/>').attr('src', url).load(function() {
			element.css({
				'background-image': 'url(' + url +')',
			});
			element.fadeIn();
		});
	};
});