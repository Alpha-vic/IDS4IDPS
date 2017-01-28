<?php
namespace App\Models;

use App\Models\Traits\ModelHelpers;
use App\Relations\HasManyThroughBelongsTo;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Model
 *
 * @package App\Models
 */
abstract class Model extends EloquentModel
{
    use ModelHelpers;

    public function forceDelete()
    {
        if (trait_exists('Photo'))
        {
            //Unlink photo
            $this->deletePhoto();
            //Unlink thumbnail
            $this->deleteThumbnail();
        }

        return parent::forceDelete();
    }

    /**
     * Define a has-many-through relationship through belongs-to
     *
     * @param string $relatedModel
     * @param string $pivotModel
     * @param string|null $firstKey
     * @param string|null $secondKey
     *
     * @return HasManyThroughBelongsTo
     */
    public function hasManyThroughBelongTo($relatedModel, $pivotModel, $firstKey = null, $secondKey = null)
    {
        $through = new $pivotModel;
        $related = new $relatedModel;
        $firstKey = $firstKey ?: $this->getForeignKey();
        $secondKey = $secondKey ?: $related->getForeignKey();

        return new HasManyThroughBelongsTo($related->newQuery(), $this, $through, $firstKey, $secondKey);
    }

}
