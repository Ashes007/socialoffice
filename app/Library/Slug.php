<?php

namespace App\Library;

//use App\Category;

class Slug
{
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($title,$model, $id = 0, $slug_field = 'slug')
    {

        // Normalize the title
        $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug,$model,$id,$slug_field);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains($slug_field, $slug)){
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains($slug_field, $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $model, $id = 0, $slug_field = 'slug')
    {
        $modelName = '\\App\\'.$model;        
        return $modelName::select($slug_field)->where($slug_field, 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
