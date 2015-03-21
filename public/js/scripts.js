angular.module('portfolioCtrl', ['angularFileUpload'])

	// inject the artwork service into our controller
	.controller('portfolioController', function($scope, $http, artwork, FileUploader) {
		var uploader = $scope.uploader = new FileUploader({
			url: '/upload'
		});
		// object to hold all the data for the new artwork form
		$scope.artworkData = {};
		$scope.submitted = false;
		$scope.master = {};
		$scope.loading = false;
		$scope.uploads = {};
		$scope.filesValidator = false;
		$scope.addedArtworkId = 0;

		//After repeaters have completed
		$scope.$on('onRepeatLast', function(scope, element, attrs){

			$(window).scroll(function() {
				if($(window).width() < 768){
					$('.el').each(function(index, el){
						var posTop = $(el).position().top;
						var posBottom = posTop + $(el).height();
						var currentTop = $(window).scrollTop();
						var height = $(window).height();
						var currentBottom = currentTop + height;

						if((posTop > currentTop) && (posBottom < currentBottom)) {
							$(el).addClass("hovered");
						} else {
							$(el).removeClass("hovered");
						}
					});
				} //less than 500
			});// on scroll

		}); //On last repeat

		// GET ALL artworkS =====================================================
		artwork.get()
			.success(function(data) {
				$scope.artworks = data;
				$scope.loading = false;
			});

		// SAVE An artwork ======================================================
		$scope.addWork = function() {
			$scope.loading = true;
			$scope.artworkData.order = 999;
			artwork.save($scope.artworkData)
				.success(function(data) {
					if(data.success) {
						artwork.get()
							.success(function() {
								$scope.addedArtworkId = data.artworkId;
								uploader.uploadAll();
							});
					}
					else {
						$scope.submitted = true;
						$scope.loading = false;
					}
				})
				.error(function(data) {
					console.log(data);
				});
		}

		// DELETE An artwork ====================================================
		$scope.deleteWork = function(id) {
			$scope.loading = true; 
			artwork.destroy(id)
				.success(function(data) {
					artwork.get()
						.success(function(getData) {
							$scope.artworks = getData;
							$scope.loading = false;
						});
				});
		};

		// FILL edit artwork =====================================================

		$scope.fillEditWork = function(id) {
			console.log('filling fields..');
			//Fill fields
			artwork.getOne(id)
				.success(function(data) {
					$scope.artworkData = data;
					//Fill files
					$.each($scope.artworkData.images, function(index, imageData) {
						var item = new FileUploader.FileItem(uploader, {
							lastModifiedDate: new Date(),
							name: imageData.url,
						});

						item.formData.push({id: imageData.id});

						console.log('pushing item to queue: ' + JSON.stringify(item.file.name));
						uploader.queue.push(item);
					});
					console.log('fields filled')
					$scope.loading = false;
				});

		}

		$('#editWork').on('hidden.bs.modal', function () {
			$scope.reset();
		})

		// UPDATE An artwork ======================================================
		$scope.editWork = function(event) {
			$scope.loading = true;

			artwork.update($scope.artworkData)
				.success(function(data) {
					if(data.success) {
						artwork.get()
							.success(function() {
								console.log('Update item success. ArtworkId: ' + data.artworkId);
								$scope.addedArtworkId = data.artworkId;
								console.log('starting to upload files');
								uploader.uploadAll();
							});
					}
					else {
						$scope.submitted = true;
						$scope.loading = false;
					}
				})
				.error(function(data) {
					console.log(data);
				});
				try {
					event.preventDefault();
				}
				catch(err) {
					console.log('Couldnt prevent default');
				}
			
		}

		// RESET the form ========================================================
		$scope.reset = function () {
			$scope.artworkData = angular.copy($scope.master);
			$scope.submitted = false;
			$scope.addWorkForm.title.$dirty = false;
			$scope.addWorkForm.type.$dirty = false;
			$scope.loading = false;
			uploader.clearQueue();
			//reload artwokrs
			artwork.get()
			.success(function(data) {
				$scope.artworks = data;
				$scope.loading = false;
			});
		}

		//SORTING artworks ========================================================
		$scope.sortableOptions = {
			stop: function(e, ui) {
				var order = 0;
				var artworksOrder = $scope.artworks.map(function(item){
					item.order = order;
					order ++;
					artwork.update(item)
						.success(function(data) {
							if(data.success) {
								artwork.get()
									.success(function() {
										console.log('Update item success. ArtworkId: ' + data.artworkId);
									});
							}
							else {
								$scope.submitted = true;
								$scope.loading = false;
							}
						})
						.error(function(data) {
							console.log(data);
						});
				});

			}
		};

		//Remove item =============================================================
		$scope.remove = function (item) {
			var id = item.formData[0].id;
			if (id != false){
				console.log('deleting item: ' + JSON.stringify(id));

				if (item.file.name == $scope.artworkData.hover) {
					$scope.artworkData.hover = '';
				}
				if (item.file.name == $scope.artworkData.cover) {
					$scope.artworkData.cover = '';
				}

				artwork.destroyImage(id)
				.success(function(data) {
					artwork.get()
						.success(function(getData) {
							$scope.artworks = getData;
						});
				});
			}
			else {
				console.log('removing item: ' +  item.file.name);
			}
			item.remove();
		}

		//Radio button changed
		$scope.radioChanged = function () {
			$scope.filesValidator = ($scope.artworkData.hover + '').length & ($scope.artworkData.cover + '').length;
		}

		// File upload responses ==================================================
		uploader.onAfterAddingFile = function(item) {
			console.info('onAfterAddingFile');
			item.formData.push({id:false}); //initializing id variable
		};

		uploader.onSuccessItem = function(fileItem, response, status, headers) {
			console.log("on success item");

			console.info("response: " + JSON.stringify(response));
		};

		uploader.onCompleteAll = function() {
			console.log("on complete all uploads");
			$('#addWork').modal('hide');
			$('#editWork').modal('hide');
			$scope.reset();
		}

		uploader.onErrorItem = function(fileItem, response, status, headers) {
			console.log("error item: ");
			console.info('onErrorItem', JSON.stringify(response));
		};

		uploader.onBeforeUploadItem = function(item) {
			item.formData.push({artworkId: $scope.addedArtworkId});
			item.formData.push({hover: $scope.artworkData.hover});
			item.formData.push({cover: $scope.artworkData.cover});
			console.log("Starting to upload: " + item.file.name + " id: " + JSON.stringify(item.formData));
		};

	});






angular.module('singlePortfolioCtrl', [])
	.controller('singlePortfolioController', function($scope, $http, artwork) {
		// GET ALL artworkS =====================================================
		artwork.get()
			.success(function(data) {
				$scope.artworks = data;
				$scope.loading = false;
			});
		$('#bodyContainer').hide();
		// After repeaters complete, initiate jquery UI tabs and other logic====
		$scope.$on('onRepeatLast', function(scope, element, attrs){
			$(function() {
				var activeIndex = $('.portfolio-element').index($('div#artworks-'+artworkId));

				var tabs = $( "#artworks" ).tabs({
					show: { effect: "fade", duration: 100 },
					hide: { effect: "fade", duration: 100 },
					select: function(event, ui) {
						jQuery(this).css('height', jQuery(this).height());
						jQuery(this).css('overflow', 'hidden');
					},
					show: function(event, ui) {
						jQuery(this).css('height', 'auto');
						jQuery(this).css('overflow', 'visible');
					},
					active: activeIndex
				});
				var count = $('.portfolio-element').length;

				$('.portfolio-image').each(function(idx, val, f) {
					$( this ).tabs({
						show: { effect: "fade", duration: 100 },
						hide: { effect: "fade", duration: 100 },
						select: function(event, ui) {
							jQuery(this).css('height', jQuery(this).height());
							jQuery(this).css('overflow', 'hidden');
						},
						show: function(event, ui) {
							jQuery(this).css('height', 'auto');
							jQuery(this).css('overflow', 'visible');
						}
					});
				});

				$('#bodyContainer').fadeIn('slow');

				function nextSlide(){
					var selectedTab = tabs.tabs( "option", "active" );
					if (selectedTab+1 < count) {
						tabs.tabs("option", "active", selectedTab + 1);
					}
					else if (selectedTab+1 == count) {
						tabs.tabs("option", "active", 0);
					}
					return false;
				}

				function prevSlide(){
					var selectedTab = tabs.tabs( "option", "active" );
					if (selectedTab > 0) {
						tabs.tabs("option", "active", selectedTab - 1);
					}
					else if (selectedTab == 0){
						tabs.tabs("option", "active", count-1);
					}
					return false;
				}

				function nextImage(){
					var selectedTab = tabs.tabs( "option", "active" );
					var imagesDiv = $("#artworks .portfolio-element:nth-of-type("+(selectedTab+1)+") .portfolio-image");
					var imagesCount = imagesDiv.children('div').length;
					var selectedImageTab = imagesDiv.tabs( "option", "active" );

					if (selectedImageTab+1 < imagesCount) {
						imagesDiv.tabs("option", "active", selectedImageTab + 1);
					}
					else if (selectedImageTab+1 == imagesCount){
						imagesDiv.tabs("option", "active", 0);
					}
					return false;
				}

				function prevImage(){
					var selectedTab = tabs.tabs( "option", "active" );
					var imagesDiv = $("#artworks .portfolio-element:nth-of-type("+(selectedTab+1)+") .portfolio-image");
					var imagesCount = imagesDiv.children('div').length;
					var selectedImageTab = imagesDiv.tabs( "option", "active" );

					if (selectedImageTab > 0) {
						imagesDiv.tabs("option", "active", selectedImageTab - 1);
					}
					else if (selectedImageTab == 0){
						imagesDiv.tabs("option", "active", imagesCount-1);
					}
					return false;
				}

				//Buttons
				$('#next').click(function(e) {
					e.preventDefault();
					nextSlide();
				});

				$('#prev').click(function(e) {
					e.preventDefault();
					prevSlide();
				});

				//Arrow keys
				$(document).keydown(function(e) {
					switch(e.which) {
						case 37: // left
						prevSlide();
						break;

						case 38: // up
						nextImage();
						break;

						case 39: // right
						nextSlide();
						break;

						case 40: // down
						prevImage();
						break;

						default: return; // exit this handler for other keys
					}
					e.preventDefault(); // prevent the default action (scroll / move caret)
				});

				//For mobile ================================================================
					//For project
				$( "#artworks" ).on( "swipeleft", prevSlide );
				$( "#artworks" ).on( "swiperight", nextSlide );
					//For image
				$( ".portfolio-image" ).on( "swipeleft", prevImage );
				$( ".portfolio-image" ).on( "swiperight", nextImage );

			});
		});

	});
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

portfolioApp.directive('onLastRepeat', function() {
	return function(scope, element, attrs) {
		if (scope.$last) setTimeout(function(){
			scope.$emit('onRepeatLast', element, attrs);
		}, 1);
	};
})