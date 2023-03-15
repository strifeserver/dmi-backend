<?php

namespace App\Services;

use App\Services\AuditService; ##AUDITING / COMMON
use App\Services\DataStatusService; ## STATUS RETURNS / COMMON
use App\Services\ImageService; 
use App\CoreSetting;
use App\Repositories\SettingRepository;
class SettingService
{
    protected $settings;
    protected $dataStatusService;

    public function __construct(CoreSetting $settings, SettingRepository $repository, DataStatusService $dataStatusService, AuditService $auditService, ImageService $imageService)
    {
        $this->db_table = $settings;
        $this->repository = $repository;
        $this->dataStatusService = $dataStatusService;
        $this->auditService = $auditService;
        $this->imageService = $imageService;
    }
    public function getBySettingName($settingName){
        $repository = $this->repository->getBySettingName($settingName);
        return $repository;
    } 

    public function store($request)
    {
        $data = $this->db_table;
        $fields = $data->getFillable();
        $submittedData = $request->only($fields);

        $description = [];
        if ($submittedData['category'] == 2) {
            $path = ($request->input('file_path'));
            $image = $submittedData['img']->getClientOriginalName();
            $newExtension = $this->imageService->imagePngToFile($submittedData['img']);
            $newProfileImage = 'login.' . $newExtension;
            $move = $submittedData['img']->storeAs($path, $newProfileImage);
            $description = [
                'description' => $submittedData['setting_description'],
                'path' => $path,
            ];
        }

        $submittedData = [
            'setting_name' => $submittedData['setting_name'],
            'setting_value' => ($submittedData['category'] == 2) ? $newProfileImage : $submittedData['setting_value'],
            'setting_description' => ($submittedData['category'] == 2) ? json_encode($description, true) : $submittedData['setting_description'],
            'category' => $submittedData['category'],
        ];
        
        $execute = $data->create($submittedData);
        $executeStatus = ($execute) ? 1 : 0;
  
        $auditing = $this->auditService->created_data($submittedData, $execute);
        $status = $this->dataStatusService->data_status($executeStatus);
        return $status;

    }



    public function update($request)
    {
        $id = $request->input('id');
        $data = $this->db_table->findOrFail($id);
        $fields = $this->db_table->getFillable();
        $submittedData = $request->only($fields);

        if ($submittedData['category'] == 2) {
            if ($submittedData['img'] == null || empty($submittedData['img'])) {
                $submittedData['setting_value'] = $data->setting_value;
                $submittedData['setting_description'] = $data->setting_description;
            } else {
                $path = ($request->input('file_path'));

                $image = $submittedData['img']->getClientOriginalName();

                $newExtension = $this->imageService->imagePngToFile($submittedData['img']);
                $newProfileImage = 'login.' . $newExtension;
                $move = $submittedData['img']->storeAs($path, $newProfileImage);

                $description = [
                    'description' => $submittedData['setting_description'],
                    'path' => $path,
                ];

                $submittedData['setting_value'] = $newProfileImage;
                $submittedData['setting_description'] = json_encode($description, true);
            }
        }
        $before_update = $data->toArray();
        $auditing = $this->auditService->auditing($before_update, $submittedData);

        unset($submittedData['file_path']);

        $update = $data->update($submittedData);
        $status = $this->dataStatusService->data_status($update);
        return $status;
    }


    public function destroy($id){
        $data = $this->db_table->findOrFail($id);
        $saving = $data->delete();
        $status = $this->dataStatusService->data_status($saving);
        return $status;
        
    }



}
