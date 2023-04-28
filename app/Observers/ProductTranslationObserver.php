<?php

namespace App\Observers;

use App\Contracts\Models\BaseModelObserver;
use App\Models\Product\ProductTranslation;
use App\Traits\SlugifyTrait;

class ProductTranslationObserver extends BaseModelObserver
{
  use SlugifyTrait;

  protected static function model()
  {
    return ProductTranslation::class;
  }

  /**
   * Handle the ProductTranslation "creating" event.
   *
   * @param  \App\Models\Product\ProductTranslation  $productTranslation
   * @return void
   */
  public function creating(ProductTranslation $productTranslation)
  {
    // @TODO: slugify title
    $productTranslation->slug = $this->slugify($productTranslation->title);
  }

  /**
   * Handle the ProductTranslation "created" event.
   *
   * @param  \App\Models\Product\ProductTranslation  $productTranslation
   * @return void
   */
  public function created(ProductTranslation $productTranslation)
  {
    //
  }

  /**
   * Handle the ProductTranslation "updated" event.
   *
   * @param  \App\Models\Product\ProductTranslation  $productTranslation
   * @return void
   */
  public function updated(ProductTranslation $productTranslation)
  {
    //
  }

  /**
   * Handle the ProductTranslation "deleted" event.
   *
   * @param  \App\Models\Product\ProductTranslation  $productTranslation
   * @return void
   */
  public function deleted(ProductTranslation $productTranslation)
  {
    //
  }

  /**
   * Handle the ProductTranslation "restored" event.
   *
   * @param  \App\Models\Product\ProductTranslation  $productTranslation
   * @return void
   */
  public function restored(ProductTranslation $productTranslation)
  {
    //
  }

  /**
   * Handle the ProductTranslation "force deleted" event.
   *
   * @param  \App\Models\Product\ProductTranslation  $productTranslation
   * @return void
   */
  public function forceDeleted(ProductTranslation $productTranslation)
  {
    //
  }
}
