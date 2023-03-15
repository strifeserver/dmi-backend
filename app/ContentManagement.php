<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Route;

class ContentManagement extends Model
{
    use HasFactory;
    protected $table = 'content_managements';

    protected $fillable = [
        'content_thumbnail',
        'content_title',
        'content_url',
        'content_schedule',
        'content_start_time',
        'content_end_time',
        'content_location',
        'content_time',
        'content_images',
        'content_description',
        'content_category',
        'content_tags',
        'content_files',
        'is_live',
        'content_status',
        'created_by',
        'updated_by',
    ];
    // private $currentPath;
    // public function __construct()
    // {
    //     $route = Route::current();
    //     $this->currentPath = $route->uri;
    // }
    public function cleanImageInsert($imageRaw)
    {
        $fixedImage = [];
        if (!is_array($imageRaw)) {
            $imageRaw = explode(',', $imageRaw);
        } else {
        }
        foreach ($imageRaw as $key => $imageval) {
            if (!empty($imageval)) {
                $fixedImage[] = $imageval;
            }
        }
        return $fixedImage;
    }

    public function setContentFilesAttribute($value)
    {
        if($value){
            $this->attributes['content_files'] = json_encode($value);
        }else{
            $this->attributes['content_files'] = null;
        }
    }
    public function getContentFilesAttribute($value)
    {
        if($value){
            $value = json_decode($value, true);
            $value = implode(',', $value);
        }
        return $value;
    }
    public function setContentImagesAttribute($value)
    {
        $fixedImage = $this->cleanImageInsert($value);

        $route = Route::current();
        if($route){
            $currentPath = $route->uri;
            $return = $value;
    
            switch ($currentPath) {
                case 'api/get_contents':
                    $this->attributes['content_images'] = $value;
    
                    break;
    
                default:
                    if (empty($fixedImage)) {
                        $this->attributes['content_images'] = '';
                    } else {
                        $this->attributes['content_images'] = json_encode($fixedImage);
                    }
                    break;
            }
        }
        return $value;

    }
    public function setCreatedByAttribute($value)
    {
        $this->attributes['created_by'] = auth()->id();
    }
    public function setUpdatedByAttribute($value)
    {
        $this->attributes['updated_by'] = auth()->id();
    }
    public function getCreatedAtAttribute($value)
    {
        return date('m-d-Y h:i:s A', strtotime($value));
    }
    public function getContentTagsAttribute($value)
    {
        $currentURL = \URL::current();
        $ex = explode('/',    $currentURL);
        $app_env = config('app.app_env');
        $index_id = 0;
        if($app_env == 'local'){
            $index_id = 4;
        }
        if($app_env == 'production'){
            $index_id = 5;
        }
        $current_url = @$ex[$index_id];
 
        switch ($current_url) {
            case 'get_contents':
                $tags_raw = explode(',', $value);
                $value = $tags_raw;
            break;
            default:
            
            break;
        }
        return $value;
        // return date('m-d-Y h:i:s A', strtotime($value));
    }
    public function getUpdatedAtAttribute($value)
    {
        return date('m-d-Y h:i:s A', strtotime($value));
    }
    public function setContentScheduleAttribute($value)
    {
        if(!empty($value)){
            $schedule = explode('-',$value);
            $month = $schedule[0];
            $day = $schedule[1];
            $year = $schedule[2];
            $formatted = $year.'-'.$month.'-'.$day.' 00:00:00';
            $this->attributes['content_schedule'] = $formatted;
        }

    }
    public function getContentScheduleAttribute($value)
    {
        
        return date('m-d-Y', strtotime($value));
    }
    public function getContentDescriptionAttribute($value)
    {
        $route = Route::current();
        $currentPath = $route->uri;
        $return = $value;
      
        switch ($currentPath) {
            case 'api/get_contents':
                $return = json_decode($value,true);
                break;
        }
        return $return;
    }
    public function getContentStatusAttribute($value)
    {
        $route = Route::current();
        $currentPath = $route->uri;
        $return = $value;
        switch ($currentPath) {
            case 'paginate/content_management':
                if ($value == '1') {
                    $return = 'Active';
                }
                if ($value == '0') {
                    $return = 'Inactive';
                }
                break;
        }
        return $return;
    }
}
