<?php namespace MikeFrancis\Uploadable;

use Illuminate\Database\Eloquent\Model;

class UploadableObserver {

  /**
   * Trigger function when saving a model (creating/editing).
   * 
   * @param  Model  $model
   * @return void
   */
  public function saving(Model $model)
  {
    $model->performUploads();
  }

  /**
   * Trigger function when deleting a model.
   * 
   * @param  Model  $model
   * @return void
   */
  public function deleting(Model $model)
  {
    $model->performDeletes();
  }

}