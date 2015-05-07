<?php namespace MikeFrancis\Uploadable;

use Illuminate\Database\Eloquent\Model;

class UploadableObserver {

  public function saving(Model $model)
  {
    $model->performUploads();
  }

  public function deleting(Model $model)
  {
    $model->performDeletes();
  }

}