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

    protected function getDescendantIds(int $topicId): array
    {
        // Start with the current topic's ID
        $ids = [$topicId];
        
        // Fetch direct children of the current ID
        $children = $this->children()->where('parent_id', $topicId)->pluck('id')->toArray();
        
        if (empty($children)) {
            return $ids;
        }
        
        // If children exist, merge their IDs
        $ids = array_merge($ids, $children);

        // Recursively call for each child to get their own descendants
        foreach ($children as $childId) {
            // We need a fresh Topic instance for the childId to use the children() relationship scope properly
            $childTopic = self::find($childId);
            if ($childTopic) {
                $ids = array_merge($ids, $childTopic->getDescendantIds($childId));
            }
        }
        
        // Ensure unique IDs
        return array_unique($ids);
    }


    /**
     * Get the total count of questions for this topic and all its descendants.
     * This is the public method that initiates the process.
     * * @return int
     */
    public function getTotalQuestionCountAggregated(): int
    {
        // 1. Get the IDs of all descendants (current topic ID included).
        // The previous implementation was overly complex; this version starts the streamlined process.
        $descendantIds = $this->getDescendantIds($this->id);
        
        // 2. Count all questions where the topic_id is in the list of descendant IDs.
        // This part remains efficient.
        return DB::table('questions')
                 ->whereIn('topic_id', $descendantIds)
                 ->count();
    }
    
}
