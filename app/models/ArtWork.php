<?php

class Artwork extends Eloquent {

	public $timestamps = false;

	public static $rules = [
		'type' => 'required',
		'title' => 'required',
		'order' => 'required'
	];

	protected $fillable = ['type', 'title', 'subtitle', 'client', 'description', 'url', 'order'];

	public $messages;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'artworks';

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