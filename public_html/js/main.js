function PortfolioController ($scope, $http) {
	$scope.submitted = false;
	$scope.master = {};

	$http.get('/allArtworks').success(function(artworks) {
		$scope.artworks = artworks;
	});

	$scope.addWork = function() {

		var artwork = {
			title: $scope.work.title,
			type: $scope.work.type,
			subtitle: $scope.work.subtitle,
			description: $scope.work.description,
			url: $scope.work.url,
			client: $scope.work.client
		};

		$http.post('portfolio', artwork).success(function(message) {
			if(message.success) {
				$scope.artworks.push(artwork);
				$scope.reset();
			}
			else {
				alert(JSON.stringify(message.messages));
				$scope.submitted = true;
			}
			
		});
	}

	$scope.reset = function () {
		$scope.work = angular.copy($scope.master);
		$scope.submitted = false;
		$scope.addWorkForm.title.$dirty = false;
		$scope.addWorkForm.type.$dirty = false;
	}

	$scope.deleteWork = function(workId) {

		$http.delete('portfolio/'+workId).success(function(response) {
			$http.get('/allArtworks').success(function(artworks) {
				$scope.artworks = artworks;
			});
		}).
		error(function(response){
			alert(JSON.stringify(response));
		});
	}

}