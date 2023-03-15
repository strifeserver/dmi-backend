<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\ContentManagement;
class ContentManagementFactory extends Factory
{
    protected $model = ContentManagement::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function time_generator(){
        $aftt = ['AM','PM'];
        $aftpm = array_rand($aftt);
        $aftpm = $aftt[$aftpm];

        
        $time_arr = [0,30];
        $time_inc = array_rand($time_arr);
        $time_inc = $time_arr[$time_inc];
        $time_inc = str_pad($time_inc, 2, '0', STR_PAD_LEFT); 

        $hour = $this->faker->numberBetween(1,12);
        $formatted_time = $hour.':'.$time_inc.' '.$aftpm;
        return $formatted_time;
    }

    public function definition()
    {
        date_default_timezone_set('asia/taipei');
        // 
        $generated_url = [];
        $min=1;
        $max=4;
        $gen_count_url = rand($min,$max);
        for ($i=0; $i < $gen_count_url; $i++) { 
            $generated_url[] = $this->faker->url;
        }
        $generated_url = implode(',',$generated_url);
        // 

        // 
        $content_categories = ['event','highlight','gallery'];
        $key = array_rand($content_categories);
        $content_category= $content_categories[$key];
        // 

        // 
        $generated_tags = [];
        $min=1;
        $max=4;
        $gen_count_tags = rand($min,$max);
        for ($i=0; $i < $gen_count_tags; $i++) { 
            $generated_tags[] = strtolower($this->faker->word);
        }
     
        $generated_tags = implode(',',$generated_tags);
        // 
  
        $min=1;
        $max=14;
        $placeholder_images = rand($min,$max);
        $placeholder_images = $placeholder_images.'.jpg';
        
        $generated_html = $this->faker->randomHtml();
        $days = $this->faker->numberBetween(1,27);
        $content_schedule = $this->faker->dateTimeBetween('+0 days', '+'.$days.' days')->format('m-d-Y');


        $aftt = ['AM','PM'];
        $aftpm = array_rand($aftt);
        $aftpm = $aftt[$aftpm];


        $content_start_time = $this->time_generator();
        $content_end_time = $this->time_generator();
        $content_time = $this->time_generator();



        
        return [

            'content_thumbnail' => $placeholder_images,
            'content_title' => $this->faker->word,
            'content_url' => $generated_url,
            'content_schedule' => $content_schedule,
            'content_start_time' => $content_start_time,
            'content_end_time' => $content_end_time,
            'content_location' => $this->faker->word,
            'content_time' => $content_time,
            'content_images' => '',
            'content_description' => $generated_html,
            'content_category' => $content_category,
            'content_tags' => $generated_tags,
            'content_status' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
