<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table="students";
    protected $fillable=["id","firstname","lastname","email","phone"];
}
