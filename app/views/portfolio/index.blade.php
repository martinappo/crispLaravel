@extends('layouts.default')
@section('head')
	[[ HTML::script('js/controllers/portfolioCtrl.js') ]]
	[[ HTML::script('js/services/artworkService.js') ]]
	[[ HTML::script('js/app.js') ]]
	[[ HTML::script('js/angular-file-upload.min.js') ]]
	[[ HTML::script('js/jquery-ui.min.js') ]]
	[[ HTML::script('js/min/angular-ui-sortable.min.js') ]]
@stop
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
			<!-- Modal -->
			<div class="modal fade" id="addWork" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Kinni</span></button>
							<h4 class="modal-title" id="myModalLabel">
								Lisa töö
								<span class="label label-success pull-right" ng-show="loading">Laadib...</span>
								<span class="label label-success pull-right" ng-show="done">Korras!</span>
							</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<input class="form-control" type="file" nv-file-select uploader="uploader" multiple/><br>

								<table class="table">
									<tr>
										<th>Nimi</th>
										<th>Hover</th>
										<th>Cover</th>
										<th>Eemalda</th>
									</tr>
									<tr ng-repeat="item in uploader.queue" class="upladedItem">
										<td ng-bind="item.file.name"></td>
										<td><input type="radio" name="hover" ng-value="item.file.name" ng-model="artworkData.hover" ng-change="radioChanged()"></td>
										<td><input type="radio" name="cover" ng-value="item.file.name" ng-model="artworkData.cover" ng-change="radioChanged()"></td>
										<td>
											<button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
												<span class="glyphicon glyphicon-trash"></span>Remove
											</button>
										</td>
									</tr>
								</table>
								<span class="label label-warning" ng-show="!filesValidator">Hover ja cover peavad olema valitud. Üks pilt peab olema ilma hoveri või coverita.</span>
							</div>
							<hr>
							<form ng-submit="addWork()" name="addWorkForm" novalidate>
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Pealkiri" name="title" ng-model="artworkData.title" required />
									<div ng-show="submitted || addWorkForm.title.$dirty">
										<span class="label label-warning" ng-show="addWorkForm.title.$error.required">Kirjuta siia pealkiri, palun!</span>
									</div>
								</div>
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Alampealkiri" name="subtitle" ng-model="artworkData.subtitle">
								</div>
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Klient" name="client" ng-model="artworkData.client">
								</div>
								<div class="form-group">
									<textarea class="form-control" name="description" cols="30" rows="10" ng-model="artworkData.description" placeholder="Kirjeldus"></textarea>
								</div>
								<div class="form-group">
									<input class="form-control" type="url" placeholder="Link lehele" name="url" ng-model="artworkData.url">
								</div>
								<div class="input-group">
									<span class="input-group-addon">Tüüp</span>
									<select class="form-control" name="type" id="type" ng-model="artworkData.type" required>
										<option value="logo">Logo</option>
										<option value="web">Veeb</option>
										<option value="poster">Poster</option>
										<option value="other">Midagi muud</option>
									</select>
								</div>
								<br>
								<div ng-show="submitted || addWorkForm.type.$dirty">
									<span class="label label-warning" ng-show="addWorkForm.type.$error.required">Tüüp on kah vajalik!</span>
								</div>
								<br>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Minek!</button>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Kinni</button>
						</div>
					</div>
				</div>
			</div>
			<!-- modal edit -->
			<div class="modal fade" id="editWork" tabindex="-1" role="dialog" aria-labelledby="editWork" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Kinni</span></button>
							<h4 class="modal-title" id="editWork">
								Lisa töö
								<span class="label label-success pull-right" ng-show="loading">Laadib...</span>
							</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<input class="form-control" type="file" nv-file-select uploader="uploader" multiple/><br>
								<table class="table">
									<tr>
										<th>Nimi</th>
										<th>Hover</th>
										<th>Cover</th>
										<th>Eemalda</th>
									</tr>
									<tr ng-repeat="item in uploader.queue" class="upladedItem">
										<td ng-bind="item.file.name"></td>
										<td><input type="radio" name="hover" ng-value="item.file.name" ng-model="artworkData.hover" ng-change="radioChanged()" ng-click></td>
										<td><input type="radio" name="cover" ng-value="item.file.name" ng-model="artworkData.cover" ng-change="radioChanged()" ng-click></td>
										<td>
											<button type="button" class="btn btn-danger btn-xs" ng-click="remove(item)">
												<span class="glyphicon glyphicon-trash"></span>Remove
											</button>
										</td>
									</tr>
								</table>
								<span class="label label-warning" ng-show="!filesValidator">Hover ja cover peavad olema valitud. Üks pilt peab olema ilma hoveri või coverita.</span>
							</div>
							<hr>
							<form ng-submit="editWork()" name="editWorkForm" novalidate>
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Pealkiri" name="title" ng-model="artworkData.title" required />
									<div ng-show="submitted || editWorkForm.title.$dirty">
										<span class="label label-warning" ng-show="editWorkForm.title.$error.required">Kirjuta siia pealkiri, palun!</span>
									</div>
								</div>
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Alampealkiri" name="subtitle" ng-model="artworkData.subtitle">
								</div>
								<div class="form-group">
									<input class="form-control" type="text" placeholder="Klient" name="client" ng-model="artworkData.client">
								</div>
								<div class="form-group">
									<textarea class="form-control" name="description" cols="30" rows="10" ng-model="artworkData.description" placeholder="Kirjeldus"></textarea>
								</div>
								<div class="form-group">
									<input class="form-control" type="url" placeholder="Link lehele" name="url" ng-model="artworkData.url">
								</div>
								<div class="input-group">
									<span class="input-group-addon">Tüüp</span>
									<select class="form-control" name="type" id="type" ng-model="artworkData.type" required>
										<option value="logo">Logo</option>
										<option value="web">Veeb</option>
										<option value="poster">Poster</option>
										<option value="other">Midagi muud</option>
									</select>
								</div>
								<br>
								<div ng-show="submitted || editWorkForm.type.$dirty">
									<span class="label label-warning" ng-show="editWorkForm.type.$error.required">Tüüp on kah vajalik!</span>
								</div>
								<br>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Minek!</button>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Kinni</button>
						</div>
					</div>
				</div>
			</div>
		@endif
		@if ($artworks->count())
			<div class="portfolio" ui-sortable="sortableOptions" ng-model="artworks">
				@if ($auth)
					<div ng-repeat="artwork in artworks" class="el pic col-lg-4 col-md-5 col-sm-10" style="background-image: url(uploads/{{artwork.cover.url}});" ng-class="{logo: artwork.type=='logo'}">
				@else
					<a ng-repeat="artwork in artworks" href="[[ URL::to('portfolio/{{ artwork.id }}') ]]">
					<div class="el pic col-lg-4 col-md-5 col-sm-10" style="background-image: url(uploads/{{artwork.cover.url}});" ng-class="{logo: artwork.type=='logo'}">
				@endif
					

						<img ng-if="artwork.type=='logo'" class="logo" height="40%" src="uploads/{{artwork.cover.url}}" alt="{{ artwork.subtitle }}">
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
						<div class="hoverpic" ng-class="{logo: artwork.type=='logo'}" style="background-image: url(uploads/{{artwork.hover.url}});"></div>
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
	</div>
@stop