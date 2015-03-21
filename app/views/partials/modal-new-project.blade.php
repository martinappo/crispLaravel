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