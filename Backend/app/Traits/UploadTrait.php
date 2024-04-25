<?php

namespace App\Traits;
use Str;

trait UploadTrait {

	public function upload($model, $collection, $filename){
		if(request()->hasFile($filename)){
			$file = request()->file($filename);
			$extension = $file->getClientOriginalExtension();
			$name = (string) Str::uuid();
			$fileAdder = $model->addMediaFromRequest($filename)
					->setName($name)
					->setFileName($name .'.'. $extension)
					->toMediaCollection($collection);
	
			return $fileAdder;
		}

		return null;
	}
}