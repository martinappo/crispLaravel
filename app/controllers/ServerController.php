<?php

class ServerController extends BaseController {

	public function deploy() {
		SSH::into('production')->run(array(
			'cd ~/domains/crisp.ee/public_html/crisp',
			'git pull origin master'
		), function ($line) {
			echo $line.PHP_EOL;
		});
	}


}