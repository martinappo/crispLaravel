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
		$scope.editWork = function() {
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