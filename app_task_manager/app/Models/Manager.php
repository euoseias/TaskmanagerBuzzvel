<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    //use HasFactory;
    protected $fillable = ['title', 'description', 'Attachment', 'dateCreated', 'completedDate', 'user'];

    public function rules()
    {
        return [
            'title' => 'required|' . $this->id . '|min:3',
            'description' => 'required|min:3',
            'Attachment' => 'required',
            'dateCreated' => 'required',
            'completedDate' => 'required',
            'user' => 'required',
        ];

    }

    public function feedback()
    {
        return [
            'required' => 'The :attribute field is required',
            'title.unique' => 'title already exists',
            'title.min' => 'The title must be at least 3 characters long',
            'description.min' => 'Description must be at least 3 characters',

        ];
    }

}
