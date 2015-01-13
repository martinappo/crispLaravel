<?php

class Image extends Eloquent {

	public $timestamps = false;

	public static $rules = [
		'artwork_id' => 'required',
		'url' => 'required',
	];

	protected $fillable = ['url', 'artwork_id', 'hover', 'cover'];

	public $messages;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'images';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function isValid() {
		$validation = Validator::make($this->attributes, static::$rules);

		if ($validation->passes()){
			return true;
		}

		$this->messages = $validation->messages();
		return false;
	}

}