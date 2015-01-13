<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		[[ HTML::style('bootstrap-3.3.1/dist/css/bootstrap.css') ]]
		[[ HTML::style('css/style.css') ]]
		[[ HTML::script('js/jquery.min.js') ]]
		[[ HTML::script('js/angular.min.js') ]]
		[[ HTML::script('bootstrap-3.3.1/dist/js/bootstrap.min.js') ]]
		@yield('head')

	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header col-md-10 col-sm-10">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand col-sm-10 col-md-10 col-xs-10" href="[[ URL::to('/') ]]"></a>
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<!-- 
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="#">Meist</a></li>
							<li><a href="#">Portfolio</a></li>
							<li><a href="#">Kontakt</a></li>
						</ul>
						-->
					</div><!--/.nav-collapse -->
				</div><!--/.container-fluid -->
			</nav>
		</div>
		@yield('content')
	</body>
</html> 
