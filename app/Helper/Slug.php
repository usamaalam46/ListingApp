<?php
namespace App\Helper;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class Slug
{
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($type, $title, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug($type, '-');
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($type, $slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10000; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }
    protected function getRelatedSlugs($type, $slug, $id = 0)
    {
        if($type == 'user') {

            return User::select('slug')->where('slug', 'like', $slug.'%')
                        ->where('id', '<>', $id)
                        ->get();

        }else if($type == 'category') {

            return Category::select('slug')->where('slug', 'like', $slug.'%')
                        ->where('id', '<>', $id)
                        ->get();

        }else if($type == 'product') {

            return Product::select('slug')->where('slug', 'like', $slug.'%')
                        ->where('id', '<>', $id)
                        ->get();
        }

    }

}