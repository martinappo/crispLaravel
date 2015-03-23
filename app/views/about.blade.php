@extends('layouts.default')

@section('content')

	<div class="container-fluid">
		<section class="content col-lg-14 col-centered">
			<div class="inner">
				<div class="col-md-10 about-description">
					<h1>
						<span class="bold">
							Veebiloome &amp; <br>
							graafiline disain
						</span>
					</h1>
					<article class="text">
						<p>
							Crisp on loovkollektiiv, mille tõukeallikaks on 
							hea ja arusaadava kuvandi ning tugeva
							kommunikatiivse keskkonna loomine. 
						</p>

					</article>
				</div>

				<div class="col-md-10 about persons">
					<div class="col-md-10 person">
						<a href="mailto:martin.appo@crisp.ee">
							<div class="person-foto" style="background-image: url(../img/m_icon.png);"></div>
						</a>
						<div class="person-name person-info">Martin Appo</div>
						<div class="preson-desc person-info">Veebiarendus</div>
					</div>

					<div class="col-md-10 person">
						<a href="mailto:heigo.heinleht@crisp.ee">
							<div class="person-foto" style="background-image: url(../img/h_icon.png);"></div>
						</a>
						<div class="person-name person-info">Heigo Heinleht</div>
						<div class="preson-desc person-info">Graafiline disain</div>
					</div>

					<div class="col-md-10 person">
						<a href="mailto:tanel.tomson@crisp.ee">
							<div class="person-foto" style="background-image: url(../img/t_icon.png);"></div>
						</a>
						<div class="person-name person-info">Tanel Tomson</div>
						<div class="preson-desc person-info">Veebiarendus</div>
					</div>
				</div>
			</div>
		</section>
	</div>

@stop