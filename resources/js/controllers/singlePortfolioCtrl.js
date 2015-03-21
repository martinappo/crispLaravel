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