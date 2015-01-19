@extends('layouts.default')
@section('head')
	[[ HTML::script('js/controllers/singlePortfolioCtrl.js') ]]
	[[ HTML::script('js/services/artworkService.js') ]]
	[[ HTML::script('js/app.js') ]]
	[[ HTML::script('js/jquery-ui.min.js') ]]
@stop
@section('content')
	<div class="container portfolio-single col-lg-14 col-centered" ng-controller="singlePortfolioController" ng-app="singlePortfolioApp">
		<div id="artworks">
			<ul id="arworks-ul">
				<li ng-repeat="artwork in artworks" on-last-repeat><a href="#artworks-{{ artwork.id }}">{{ artwork.name }}</a></li>
				<div id="next"></div>
				<div id="prev"></div>
			</ul>

			<div ng-repeat="artwork in artworks" class="portfolio-element" id="artworks-{{ artwork.id }}" on-last-repeat>

				<div class="col-md-6 portfolio-sidebar">
					<header>
						<p class="kategooria">{{ artwork.type }}</p>
						<p class="work"><b>{{ artwork.title }}</b></p>
						<p class="klient">{{ artwork.client }}</p>
					</header>

					<p class="desc">
						{{ artwork.description }}
					</p>
				</div>
				<div class="col-md-13 col-md-offset-1 portfolio-image">
					<ul class="images-ul">
						<li ng-repeat="image in artwork.images"><a href="#artworks-{{image.artwork_id}}-image-{{image.id}}"></a></li>
					</ul>

					<div ng-repeat="image in artwork.images" id="artworks-{{image.artwork_id}}-image-{{image.id}}">
						<img src="/uploads/{{image.url}}"/>
					</div>

				</div>

				<div class="clearfix"></div>
			</div>
		</div><!-- artworks -->
	</div><!-- container -->
@stop