<?php

class PortfolioController extends \BaseController {

	public function __construct(Artwork $artwork, Image $image) {
		$this->artwork = $artwork;
		$this->image = $image;

		$this->beforeFilter('auth', array('only' => array('upload', 'destroy', 'store', 'destroyImage', 'update')));
	}

	public function index() {
		$artworks = $this->artwork->all();
		$auth = false;
		if (Auth::check()) {
			$auth = true;
		}
		return View::make('portfolio.index', ['artworks' => $artworks, 'auth' => $auth]);
	}


	public function allArtworks() {
		$artworks = $this->artwork->orderBy('order')->get();
		$artworksData = array();

		foreach ($artworks as $key => $artwork) {
			$artworksData[$key] = $artwork;
			$artworksData[$key]['images'] = $this->image->where('artwork_id', $artwork->id)->where('cover' , 0)->where('hover' , 0)->get();
			$artworksData[$key]['hover'] = $this->image->where('artwork_id', $artwork->id)->where('hover' , 1)->first();
			$artworksData[$key]['cover'] = $this->image->where('artwork_id', $artwork->id)->where('cover' , 1)->first();
		}

		return $artworksData;
	}

	public function getArtwork($artworkId) {
		$artwork = $this->artwork->whereId($artworkId)->first();
		$artwork['images'] = $this->image->where('artwork_id', $artworkId)->get();

		$artworkHover = $this->image->where('artwork_id', $artworkId)->where('hover' , 1)->first();
		if ($artworkHover) {
			$artwork['hover'] = $artworkHover->url;
		}

		$artworkCover = $this->image->where('artwork_id', $artworkId)->where('cover' , 1)->first();
		if ($artworkCover) {
			$artwork['cover'] = $artworkCover->url;
		}

		return $artwork;
	}

	public function upload(){
		$file = Input::file('file');
		$artworkId = Input::all()['artworkId'];
		$hover = Input::all()['hover'];
		$cover = Input::all()['cover'];
		$id = Input::all()['id'];

		if ($id != 'false') { //on update
			$this->image = Image::find($id);
			$filename = $this->image->url;
			$this->image->cover = ($cover == $filename);
			$this->image->hover = ($hover == $filename);

			if ( ! $this->image->isValid()) {
				return Response::json(array('error not valid on update' => $this->image->messages), 400);
			}
			$this->image->save();
			return Response::json(array('updated' => $id, 'cover' => $this->image->cover, 'hover' => $this->image->hover), 200);
		}
		elseif ($file) { //on adding
			$destinationPath = public_path() . '/uploads/';
			$filename = $file->getClientOriginalName();
			$upload_success = Input::file('file')->move($destinationPath, $filename);

			if ($upload_success) {
				$this->image->artwork_id = $artworkId;
				$this->image->url = $filename;
				$this->image->cover = ($cover == $filename);
				$this->image->hover = ($hover == $filename);

				if ( ! $this->image->isValid()) {
					return Response::json(array('error not valid on adding' => $this->image->messages), 400);
				}
				$this->image->save();

				return Response::json(array('destinationPath' => 'what'), 200);
			}
			else {
				return Response::json(array('error upload not successful' => $this->image->messages), 400);
			}
		}
		else {
			return Response::json(array('error no file or id' => Input::all()), 400);
		}
	}

	public function show($artwork) {
		$artwork = $this->artwork->whereId($artwork)->first();
		return View::make('portfolio.show', ['artwork' => $artwork]);
	}

	public function destroy($artworkId) {
		$artwork = ArtWork::find($artworkId);
		$artwork->delete();
		return;
	}

	public function destroyImage($imageId) {
		$image = Image::find($imageId);
		$image->delete();
		return;
	}

	public function store() {
		$input = Input::all();
		$this->artwork->fill($input);

		if ( ! $this->artwork->isValid()) {
			return Response::json(array(
				'success' => false,
				'messages' => $this->artwork->messages,
			));
		}

		$this->artwork->save();

		return Response::json(array(
			'success' => true,
			'artworkId' => $this->artwork->id,
		));
	}

	public function update() {
		$input = Input::all();

		$this->artwork = Artwork::find($input['id']);
		$this->artwork->fill($input);

		if ( ! $this->artwork->isValid()) {
			return Response::json(array(
				'success' => false,
				'messages' => $this->artwork->messages,
			));
		}

		$this->artwork->save();

		return Response::json(array(
			'success' => true,
			'artworkId' => $this->artwork->id,
		));
	}

}
