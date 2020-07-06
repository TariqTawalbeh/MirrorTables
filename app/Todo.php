<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    
	public function saveQuietly(array $options = [])
	{
	    return static::withoutEvents(function () use ($options) {
	        return $this->update($options);
	    });
	}

	public function deleteQuietly(array $options = [])
	{
	    return static::withoutEvents(function () use ($options) {
	        return $this->delete($options);
	    });
	}

}
