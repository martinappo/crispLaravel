@extends('layouts.default')
@section('content')
	<div ng-controller="portfolioController" ng-app="portfolioApp">
		@if ($auth)
			<div class="container">
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addWork">
					Lisa
				</button>
				<span class="label label-success" ng-show="loading">Laadib...</span>
			</div>
			<br>
		@endif
		@if ($artworks->count())
			<div class="portfolio" ui-sortable="sortableOptions" ng-model="artworks">
				@if ($auth)
					<div ng-repeat="artwork in artworks" class="el pic col-lg-4 col-md-5 col-sm-10" on-last-repeat back-img-fade="/uploads/{{artwork.cover.url}}">
				@else
					<a ng-repeat="artwork in artworks" on-last-repeat href="[[ URL::to('portfolio/{{ artwork.id }}') ]]">
					<div class="el pic col-lg-4 col-md-5 col-sm-10" back-img-fade="/uploads/{{artwork.cover.url}}">
				@endif

						<div class="text">

							@if ($auth)
								<button type="button" class="btn btn-primary edit-work" data-toggle="modal" data-target="#editWork" ng-click="fillEditWork(artwork.id)">Muuda</button>
								<button type="button" class="btn btn-danger delete-work" ng-click="deleteWork(artwork.id)">Kustuta</button>
								<a class="btn btn-primary" href="[[ URL::to('portfolio/{{ artwork.id }}') ]]">Vahi</a>
							@endif

							<h1>
								{{ artwork.title }}
							</h1>
							<div class="desc">
								{{ artwork.subtitle }}
							</div>
						</div>
						<div class="hoverpic" back-img-fade="/uploads/{{artwork.hover.url}}"></div>
					</div>
				@if (!$auth)
					</a>
				@endif
			</div>
		@else
			<div class="container">
				<section class="content">
					Meil ei ole teile veel midagi näidata.<br>
					<span class="bold"><a class="kontakt" href="kontakt.html">Oota päev või kaks.</a></span>
				</br>
				</section>
			</div>
		@endif

		@if ($auth)
			[[ View::make('partials.modal-new-project') ]]
			[[ View::make('partials.modal-edit-project') ]]
		@endif
	</div><!-- controller wrapper -->
@stop