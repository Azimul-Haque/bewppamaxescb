<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    
}
