<?php

namespace MikeFrancis\Uploadable\Observers;

use Illuminate\Database\Eloquent\Model;

class UploadableObserver
{
    /**
     * Trigger function when saving a model (creating/editing).
     *
     * @param  Model $model
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function saving(Model $model)
    {
        /** @var \MikeFrancis\Uploadable\Uploadable $model */
        $model->performUploads();
    }

    /**
     * Trigger function when deleting a model.
     *
     * @param  Model  $model
     *
     * @return void
     */
    public function deleting(Model $model)
    {
        /** @var \MikeFrancis\Uploadable\Uploadable $model */
        $model->performDeletes();
    }
}
