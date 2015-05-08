<?php namespace MikeFrancis\Uploadable;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait UploadableTrait {

  /**
   * Where to store any uploads.
   * 
   * @var string
   */
  private $uploadDir = 'uploads';

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
   * Uploadable fields getter.
   * 
   * @return array
   */
  public function getUploadables()
  {
    return $this->uploadables;
  }

  /**
   * When saving a model, upload any 'uploadable' fields.
   * 
   * @return void
   */
  public function performUploads()
  {
    $this->checkForUploadables();
    foreach ($this->getUploadables() as $key)
    {
      if (Request::hasFile($key))
      {
        if ($this->original && $this->original[$key])
        {
          $this->deleteExisting($key);
        }
        $file     = Request::file($key);
        $filename = $this->createFilename($file);
        Storage::put($filename, file_get_contents($file));
        $this->attributes[$key] = $this->getFullPath($filename);
      }
    }
  }

  /**
   * When deleting a model, cleanup the file system too.
   * 
   * @return void
   */
  public function performDeletes()
  {
    $this->checkForUploadables();
    foreach ($this->getUploadables() as $key)
    {
      $this->deleteExisting($key);
    }
  }


  private function checkForUploadables()
  {
    if (! $this->getUploadables())
    {
      throw new NoUploadablesException('Uploadables is blank.');
    }
  }

  /**
   * Create a unique filename.
   * 
   * @param  File   $file
   * @return string
   */
  private function createFilename(File $file)
  {
    $ext = '.' . $file->getClientOriginalExtension();
    return basename($file->getClientOriginalName(), $ext) . '-' . time() . $ext;
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