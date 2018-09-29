<?php

namespace MikeFrancis\Uploadable;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use MikeFrancis\Uploadable\Observers\UploadableObserver;

/**
 * @property $original array
 * @property $attributes array
 */
trait Uploadable
{
    /**
     * Attributes which are uploadable files.
     *
     * @var array
     */
    protected $uploadables = [];

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
     * @return void
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function performUploads()
    {
        foreach ($this->uploadables as $key) {
            if (!Request::hasFile($key)) {
                continue;
            }

            if ($this->original && $this->original[$key]) {
                $this->deleteExisting($key);
            }

            /** @var \Illuminate\Http\UploadedFile $file */
            $file = Request::file($key);
            $filename = $this->createFilename($file->getClientOriginalName());

            Storage::put($filename, $file->get());

            $this->attributes[$key] = $this->getFullPath($filename);
        }
    }

    /**
     * When deleting a model, cleanup the file system too.
     *
     * @return void
     */
    public function performDeletes()
    {
        foreach ($this->uploadables as $key) {
            $this->deleteExisting($key);
        }
    }

    /**
     * Create a unique filename.
     *
     * @param string $filename
     *
     * @return string
     */
    private function createFilename(string $filename)
    {
        $path = pathinfo($filename);

        return $path['filename'] . '-' . time() . '.' . $path['extension'];
    }

    /**
     * Delete an existing 'uploadable' file in
     * the filesystem when deleting a Model.
     *
     * @param string $key
     *
     * @return bool
     */
    private function deleteExisting(string $key)
    {
        $filename = basename($this->original[$key]);

        if (Storage::exists($filename)) {
            return Storage::delete($filename);
        }

        return false;
    }

    /**
     * Get the full path to a file.
     *
     * @param  string $filename
     *
     * @return string
     */
    private function getFullPath($filename)
    {
//        return $this->uploadDir . '/' . $filename;
        return $filename;
    }

}
