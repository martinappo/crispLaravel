angular.module('artworkService', [])

	.factory('artwork', function($http) {

		return {
			// get one artwork
			getOne : function(artworkId) {
				return $http({
					method: 'Get',
					url: '/allArtworks/' + artworkId,
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				});
			},

			// get all artworks
			get : function() {
				return $http.get('/allArtworks');
			},

			// save an artwork
			save : function(artworkData) {
				return $http({
					method: 'POST',
					url: '/portfolio',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(artworkData)
				});
			},

			// edit an artwork
			update : function(artworkData) {
				return $http({
					method: 'PUT',
					url: '/portfolio/' + artworkData.id,
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(artworkData)
				});
			},

			// destroy an artwork
			destroy : function(id) {
				return $http.delete('/portfolio/' + id);
			},

			// destroy an image
			destroyImage : function(id) {
				return $http.delete('/image/' + id);
			},
		}

	});