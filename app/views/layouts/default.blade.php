<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
		<!-- css -->
		[[ HTML::style('css/all.min.css') ]]
		@yield('head')
	</head>
	<body>
		<div class="container-fluid">
			<nav class="navbar navbar-default col-lg-14 col-centered" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header col-md-10 col-sm-10">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand col-sm-10 col-md-5 col-lg-5 col-xs-10" href="[[ URL::to('/') ]]"></a>
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="#">Meist</a></li>
							<li><a href="#">Portfolio</a></li>
							<li><a href="#">Kontakt</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div><!--/.container-fluid -->
			</nav>
		</div>
		@yield('content')
		@yield('footer')
		<!-- js -->
		[[ HTML::script('js/all.min.js') ]]

	</body>
</html> 
