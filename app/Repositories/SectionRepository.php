<?php
namespace App\Repositories;

use App\Repositories\Interfaces\SectrionRepositoryInterface;
use App\Models\Section;

class SectionRepository implements SectrionRepositoryInterface
{

    function index()
    {
        $section = Section::all();
        return $section;
    }
    public function store($data)
    {
        // dd('hhhhh');



        try {
            $sectionData = new Section;
            $imageName = '';
            if ($data['section_image']) {
                $image = $data['section_image'];
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('images/backend/section', $imageName);
                
                $sectionData->section_image = $imageName;
            }
         
            $sectionData->section_name = $data['section_name'];
            $sectionData->section_slug = $data['section_slug'];
            $sectionData->section_discount = $data['section_discount'];
            $sectionData->meta_title = $data['meta_title'];
            $sectionData->meta_description = $data['meta_description'];
            $sectionData->meta_kaywords = $data['meta_kaywords'];
            $sectionData->status = $data['status'];
            $sectionData->description = $data['description'];
            $sectionData->save();
            return $sectionData;
        } catch (\Exception $e) {
          
            \DB::rollback();

            return false;
        }

    }
}