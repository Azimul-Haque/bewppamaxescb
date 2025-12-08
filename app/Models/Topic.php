<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Topic extends Model
{
    public $timestamps = false;
    
    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

    public function parent()  { 
        return $this->belongsTo(Topic::class, 'parent_id'); 
    }

    public function children() { 
        return $this->hasMany(Topic::class, 'parent_id'); 
    }

    public function getFullPathAttribute(): string
    {
        // Initialize the path collection with the current topic's name
        $path = collect([$this->name]);
        $parent = $this->parent; // Assumes the 'parent' relationship is defined

        // Traverse up the hierarchy
        while ($parent) {
            // Add the parent's name to the beginning of the collection
            $path->prepend($parent->name);
            // Move up to the next parent
            $parent = $parent->parent;
        }

        // Join the path elements with the ' → ' separator
        return $path->join('→');
    }

    public function getTotalQuestionCountAggregated(): int
    {
        // 1. Get the IDs of all descendants (children, grandchildren, etc.).
        // This is the simplest way without using a dedicated Tree package (like Nested Set).
        $descendantIds = $this->getDescendantIds([$this->id]);

        // dd($descendantIds);
        
        // 2. Count all questions where the topic_id is in the list of descendant IDs.
        return DB::table('questions')
                 ->whereIn('topic_id', $descendantIds)
                 ->count();
    }

    /**
     * Helper to recursively collect all descendant IDs.
     */
    protected function getDescendantIds(array $currentIds): array
    {
        $children = $this->children()->whereIn('parent_id', $currentIds)->get();

        if ($children->isEmpty()) {
            return $currentIds;
        }

        $childIds = $children->pluck('id')->toArray();
        $currentIds = array_merge($currentIds, $childIds);
        
        // Recursively call for the next level
        return $this->children()->whereIn('parent_id', $childIds)->get()->reduce(function ($carry, $item) {
            return array_merge($carry, $this->getDescendantIds([$item->id]));
        }, $currentIds);
    }
    
}
