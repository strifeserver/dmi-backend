<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreUserLevel extends Model
{
    use HasFactory;
    protected $fillable = ['accesslevel_code','accesslevel','allow_module', 'allow_submodule', 'allow_subsub_module', 'add', 'edit', 'delete', 'export', 'import'];
}
