<?php

namespace App\Services;

use App\Repository\ContentManagementRepository;
use App\Services\AuditService; ##AUDITING / COMMON
use App\Services\DataStatusService; ## STATUS RETURNS / COMMON
use App\Services\ImageService;
use App\Services\MailService;
use App\Services\NewsletterSubscriptionService;
use App\Services\AuditTrailService;
use App\Services\ApiService;

class ContentManagementService
{

    public function __construct(ContentManagementRepository $contentManagementRepository, ImageService $imageService, AuditTrailService $audit_service, ApiService $api_service)
    {
        $this->repository = $contentManagementRepository;
        $this->imageService = $imageService;
        $this->audit_service = $audit_service;
        $this->api_service = $api_service;
    }
    

    public function index(): array
    {
        $data = [];
        $itemsPerPage = request('itemsPerPage') ?? 10;
        $filter = request('filter') ?? [];
        $sort = request('sort') ?? [];
        $pagination = request('pagination');
        if (empty($pagination)) {
            $pagination = 0;
        }

        $data['items_per_page'] = $itemsPerPage;
        $data['filters'] = $filter;
        $data['sort'] = $sort;
        $data['pagination'] = $pagination;
        $execution = $this->repository->index($data);
        $execution = $this->change_value($execution);
        
        $tag_parameters = [];
        if(@$filter){

            $tag_filter_raw = json_decode($filter,true);
            unset($tag_filter_raw['all']);
            $tag_filter = json_encode($tag_filter_raw);
          
            $tag_parameters['filters'] = @$tag_filter;
            $tags = $this->repository->index($tag_parameters);
        }
        
        $compiled_tags = [];
        $dataloop = '';
        
        if($pagination){
            $dataloop = $execution['data']['data'];
        }else{
            $dataloop = $execution['data'];
        }
        
        $tags = @$tags['data'];
        if($tags){
            foreach ($tags as $key => $value) {
                if(is_array($value['content_tags'])){
                    $compiled_tags = array_merge($compiled_tags, $value['content_tags']);    
                }else{
                    $tags = explode(',', $value['content_tags']);
                    if($tags && !empty($tags[0])){
                        $compiled_tags = array_merge($compiled_tags, $tags);    
                    }
                }
            }
            $compiled_tags = array_unique($compiled_tags);
        }
        if($pagination){
            $execution['data']['data_tags'] = @$compiled_tags;
        }else{
            $new_execution = [];
            $new_execution['status'] = $execution['status'];
            $new_execution['data']['data'] = $dataloop;
            $new_execution['data']['data_tags'] = @$compiled_tags;
            $execution = $new_execution;
        }
        
        $response = $this->api_service->api_returns($execution);
        return $response;
    }





    public function getContents($parameters){
        $getContentsManagementData = $this->repository->getContentByMultipleKey($parameters);
        $baseUrl = $_SERVER['HTTP_HOST']; 
        
        foreach ($getContentsManagementData as $key => $value) {
            // $value['content_description'] = htmlspecialchars($value['content_description'], ENT_QUOTES);

            if(!empty($value->content_images)){
                $formatted = [];
                $json_images = json_decode($value->content_images);
                foreach ($json_images as $key_a => $value_a) {
                    $formatted[] = '/images/contents/'.$value_a;
                }
                $value['content_images'] = $formatted;
            }
            

            
        }

        $content_category = $parameters['content_category'];
        $structure = [
            'images'=>[
              'content_category'=>'',  
              'content_images'=>[

              ],
            ]
            ];
            $structure['images']['content_category'] = $content_category;
        switch ($content_category) {
            case 'event':
            case 'events':
                
                foreach ($getContentsManagementData as $key_a => $value_b) {
                    if(!empty($value_b->content_schedule)){

                        $content_schedule = explode('-',$value_b->content_schedule);
                        if($content_schedule){
                            $month = $content_schedule[0];
                            $day = $content_schedule[1];
                            $year = $content_schedule[2];
                            $date = $day.'-'.$month.'-'.$year;
                            $content_schedule = strtotime($date);
                            $d1 = date("M d Y", $content_schedule);
                            $d1_raw = explode(' ',$d1);
                            $value_b->content_schedule = $d1_raw;
                        }
                    }

                    $arr = [
                        'src'=>'/images/contents/'.$value_b->content_thumbnail,
                        'title'=>$value_b->content_title,
                        'body'=>$value_b->content_description,
                        'date'=>$value_b->content_schedule,
                        'time'=>$value_b->content_time,
                    ];
                    $word = 'https';
                    $is_contain_real = str_contains($value_b->content_thumbnail, $word);
                    if($is_contain_real){
                        $arr['src'] = $value_b->content_thumbnail;
                    }
                    $structure['images']['content_images'][] = $arr;

                }
                $getContentsManagementData = $structure;
                break;
            case 'highlight':
                foreach ($getContentsManagementData as $key_a => $value_b) {
                    $arr = [
                        'src'=>'/images/contents/'.$value_b->content_thumbnail,
                        'title'=>$value_b->content_title,
                        'body'=>$value_b->content_description,
                    ];
                    $word = 'https';
                    $is_contain_real = str_contains($value_b->content_thumbnail, $word);
                    if($is_contain_real){
                        $arr['src'] = $value_b->content_thumbnail;
                    }
                    $structure['images']['content_images'][] = $arr;
                }
                $getContentsManagementData = $structure;
                break;
            case 'gallery':
                foreach ($getContentsManagementData as $key_a => $value_b) {
                    $arr = [
                        'original'=>'/images/contents/'.$value_b->content_thumbnail,
                        'thumbnail'=>'/images/contents/'.$value_b->content_thumbnail,
                        'title'=>$value_b->content_title,
                        'body'=>$value_b->content_description,
                    ];
                    $word = 'https';
                    $is_contain_real = str_contains($value_b->content_thumbnail, $word);
                    if($is_contain_real){
                        $arr['original'] = $value_b->content_thumbnail;
                        $arr['thumbnail'] = $value_b->content_thumbnail;
                    }
                    $structure['images']['content_images'][] = $arr;
                }
                $getContentsManagementData = $structure;
                break;
            
            default:
                
                break;
        }
        return $getContentsManagementData;
    }
    public function cleanImageInsert($imageRaw)
    {
        if($imageRaw){
            $fixedImage = [];
            if (!is_array($imageRaw)) {
                $imageRaw = explode(',', $imageRaw);
            }else{
            }
     
            foreach ($imageRaw as $key => $imageval) {
                if (!empty($imageval)) {
                    $fixedImage[] = $imageval;
                }
            }
        }else{
            $fixedImage = $imageRaw;
        }
        return $fixedImage;
    }

    public function file_processing($request){
        $returns = [];
        $saved_files = [];
        $files = @$request['onboard_content_files'];
        $current_files = $request['content_files'];
        $current_files_raw = explode(',', $current_files);
      

        if($files){
            $fileservice = app(FileService::class);
            foreach ($files as $key => $value) {
                $fileupload = $value;
                $fileProcess = $fileservice->file_uploader($fileupload, 'files/contents/', 'contents/', false, false);
                $saved_files[] = $fileProcess;
            }
        }
        
        $file_name_merge = array_merge($current_files_raw, $saved_files );
        $clean_names = array_filter($file_name_merge);
   
        $request['content_files'] = $clean_names;

        return $request; 
        
    }




    public function image_processing($request){
        // Image Processing
  
        $processedImages = [];
        $onboardingImages = $request['onboard_content_image'];
        $content_thumbnail = @$request['content_thumbnail'];
      
        if($onboardingImages){
            foreach ($onboardingImages as $key => $image) {
                $imageProcess = $this->imageService->image_uploader($image, 'images/contents/', 'contents/', false, false);
                if ($imageProcess) {
                    $processedImages[] = $imageProcess;
                }
            }
            if (empty($request['content_images'])) {
                $request['content_images'] = json_encode([]);
            }
            if (!empty($processedImages)) {
                ##merging array
                $decoedImages = json_decode($request['content_images']);
                if(empty($decoedImages)){
                    $decoedImages = [];
                }
                $request['content_images'] = array_merge($decoedImages, $processedImages);
            }
        }
        
        // else{
        //     // $test = json_encode($this->cleanImageInsert($request['content_images']));
        //     // print_r($test);
        //     // exit;

        //     if($type == 'string'){
        //         $request['content_images'] = explode(',', $request['content_images']);
        //         $request['content_images'] = $this->cleanImageInsert($request['content_images']);
        //         // $request['content_images'] = json_encode($request['content_images']);
        //     }
         
        //     // $request['content_images'] = json_decode($request['content_images']);


        // }
        // array ending
        $type = gettype($request['content_images']);
        
        if($type == 'string'){
      
            $is_json = $this->isJson($request['content_images']);
            if($is_json){
                $request['content_images'] = json_decode($request['content_images']);
            }else{
                $request['content_images'] = $this->cleanImageInsert($request['content_images']);
            }
      
        }

        if($content_thumbnail){
            $imageProcess = $this->imageService->image_uploader($content_thumbnail, 'images/contents/', 'contents/', false, false);
        
            if (!empty($imageProcess)) {
                $request['content_thumbnail'] = $imageProcess;
                
            }
        }else{
            // $request['content_thumbnail'] = 'placeholder.webp';
        }
        // Image Processing
  
        return $request;
    }

    public function store($request)
    {
        // $fileservice = app(FileService::class);
        // $fileupload = $request['content_files'];
        // $fileProcess = $fileservice->file_uploader($fileupload, 'files/contents/', 'contents/', false, false);

  
        $audit_data = ['incoming_data' => $request, 'existing_data' => []];
        $audit = $this->audit_service->store($audit_data);

        $request = $this->image_processing($request);
        $request = $this->file_processing($request);
        
        $content_description = [];
        $content_description['sub_content_section'] = @$request['sub_content_section']; 
        $content_description['content_description'] = @$request['content_description']; 
        $content_description['content_invitation'] = @$request['content_invitation']; 
        $content_description['content_footer']  = @$request['content_footer']; 
        
        $request['content_description'] = json_encode($content_description);
        
        // Process Data
        
        $return = $this->repository->store($request);
        if($return){
            $content_category = $request['content_category'];
            if($content_category == 'sermon'){
                $send_newsletter = $this->newsletter_send($request);
            }
        }


        return $return;
    }

    public function update($request)
    {
        
        $request = $this->image_processing($request);
        $request = $this->file_processing($request);
        
        $content_description = [];
        $content_description['sub_content_section'] = @$request['sub_content_section']; 
        $content_description['content_description'] = @$request['content_description']; 
        $content_description['content_invitation'] = @$request['content_invitation']; 
        $content_description['content_footer']  = @$request['content_footer']; 
        
        $request['content_description'] = json_encode($content_description);
        // Process Data
        
        $update = $this->repository->update($request);
        return $update;
    }

    public function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
     }


     public function newsletter_send($data){
        $title = $data['content_title'];
        $body = $data['content_description'];

        $newsletter_service = app(NewsletterSubscriptionService::class);
        $get_subscribers = $newsletter_service->getactivesubscribers()['data'];
        $compile_email = [];
        foreach ($get_subscribers as $sub_key => $sub_value) {
            $compile_email[] = $sub_value['email'];
        }
        if(!empty($compile_email)){
            $mailservice = app(MailService::class);
            $mail = $mailservice->send($compile_email, $title, $body, [],'', '', []);
        }
    }


    public function change_value($data){
        $data_rows = $data['data'];
        foreach ($data_rows as $key => $row){
            if(!empty($row['content_files'])){
                $array_construction = [];
                $content_files = explode(',', $row['content_files']);
              
                foreach ($content_files as $keya => $value) {
                    $content_file_construction_arr = ['filename' => $value,'url' => url('/').'/files/contents/'.$value]; 
                    $array_construction[] = $content_file_construction_arr;
                }
                $data_rows[$key]['content_files'] = $array_construction;
            }
        }   
        $data['data'] = $data_rows;
        return $data;   
    }
}
