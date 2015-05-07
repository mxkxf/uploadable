<?php namespace MikeFrancis\Uploadable;

use Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait UploadableTrait {

  /**
   * Where to store any uploads.
   * 
   * @var string
   */
  public $uploadDir = 'uploads';

  /**
   * Boot the trait's observer.
   * 
   * @return void
   */
  public static function bootUploadableTrait()
  {
    static::observe(new UploadableObserver);
  }

  /**
   * When saving a model, upload any 'uploadable' fields.
   * 
   * @return bool
   */
  public function performUploads()
  {
    if ($this->uploadable)
    {
      foreach ($this->uploadable as $key => $params)
      {
        if (Request::hasFile($key))
        {
          if ($this->original && $this->original[$key])
          {
            $this->deleteExisting($key);
          }
          $file = Request::file($key);
          $ext = '.' . $file->getClientOriginalExtension();
          $filename = basename($file->getClientOriginalName(), $ext) . '-' . time() . $ext;
          Storage::put($filename, File::get($file));
          $this->attributes[$key] = $this->getFullPath($filename);
        }
      }
    }
  }

  /**
   * When deleting a model, cleanup the file system too.
   * 
   * @return bool|null
   */
  public function performDeletes()
  {
    if ($this->uploadable)
    {
      foreach ($this->uploadable as $key => $params)
      {
        $this->deleteExisting($key);
      }
    }
    return parent::delete();
  }

  /**
   * Delete an existing 'uploadable' file in 
   * the filesystem when deleting a Model.
   *
   * @param   string $key
   * @return  bool
   */
  private function deleteExisting($key)
  {
    $filename = basename($this->original[$key]);
    if (Storage::exists($filename))
    {
      return Storage::delete($filename);
    }
    return false;
  }

  /**
   * Get the full path to a file
   * (until Flysystem returns a full path on upload).
   * 
   * @param  string $filename
   * @return string
   */
  private function getFullPath($filename)
  {
    return $this->uploadDir . '/' . $filename;
  }

}