<?php

namespace App\Http\Controllers\Api\V1\Portfolio;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\Portfolio\DataInfo\ContactRequest;
use App\Http\Requests\Api\V1\Portfolio\DataInfo\DataRequest;
use App\Models\Portfolio\BlogModel;
use App\Models\Portfolio\CategoryModel;
use App\Models\Portfolio\ContactModel;
use App\Models\Portfolio\DataInfoModel;
use App\Models\Portfolio\IconModel;
use App\Models\Portfolio\ImageModel;
use App\Models\Portfolio\ProjectModel;
use Illuminate\Http\Request;

class DataInfoController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function data(DataRequest $request)
    {
        $data               = null;
        $email              = $request->email;

        $data['data_info']  = DataInfoModel::where('email', $email)->first();
        $data['data_info']->socials         = array_values($data['data_info']->socials);
        $data['data_info']->languages       = array_values($data['data_info']->languages);
        $data['data_info']->skills = array_values($data['data_info']->skills);
        $data['data_info']->extra_skills    = array_values($data['data_info']->extra_skills);
        $data['data_info']->reviews         = array_values($data['data_info']->reviews);
        $data['data_info']->educations      = array_values($data['data_info']->educations);
        $data['data_info']->awards          = array_values($data['data_info']->awards);
        $data['data_info']->work_experience      = array_values($data['data_info']->work_experience);

        $data['images']     = ImageModel::where('email', $email)->orderBy('priority', 'asc')->get();
        // $data['categories'] = CategoryModel::where('email', $email)->where('status', 'active')->orderBy('created_at', 'asc')->get();
        $data['projects']   = ProjectModel::where('email', $email)->orderBy('created_at', 'asc')->get();
        $data['icons']      = IconModel::all();

        $data['categories'] = $data['projects']
                            ->pluck('category')      // Lấy ra mảng các categories
                            ->flatten()                // Làm phẳng mảng 2 chiều thành 1 chiều
                            ->unique()                 // Loại bỏ trùng lặp
                            ->values();


        // $data['data_info']['awards'] = [
        //     [

        //         'name' => "Golden bee Awards",
        //         'location' => "FPT Polytechnic",
        //         'date' => "Sep 2022",
        //         'images' => [
        //             "http://mr-quynh.site:1000/assets/avatar-7c84f781.jpg",
        //             "http://mr-quynh.site:1000/assets/avatar-7c84f781.jpg",
        //             "http://mr-quynh.site:1000/assets/avatar-7c84f781.jpg",
        //         ],
        //         'content' => "Top 150 sinh viên tiêu biểu học kì fall 2024",

        //     ]
        // ];



        // $data['data_info']['work_experience']  = [
        //     [
        //         'company'   => "Chatbyte GmbH",
        //         'location'  => "Remote",
        //         'position'  => "Software Engineer",
        //         'period'    => "Mar 2024 - Present",
        //         'achievements' => [
        //             "Designed and implemented business logic for AWS Lambdas using the Serverless Framework, forming the backbone of the application's functionality and ensuring seamless backend operations.",
        //             "Built a comprehensive admin panel for managing content, user data, and analytics.",
        //             "Contributed to the development and integration of a scalable CMS for managing blog content and other platform data.",
        //             "Reduced database costs by introducing materialized views, optimizing query performance and resource usage.",
        //             "Drove the integration of a custom affiliate marketing system, enabling seamless tracking and reporting of referrals and user activities.",
        //             "Integrated Text-to-Speech (TTS) services for enhanced user experiences, optimizing both frontend and backend systems.",
        //             "Collaborated with cross-functional teams to deliver high-quality features, actively reviewing pull requests to ensure code quality, adherence to standards, and efficient implementation.",
        //         ],
        //     ]
        // ];
        return $this->success('ok', $data);
    }

    public function contact(ContactRequest $request)
    {
        ContactModel::create([
            ...$request->all(),
            'status'        => 'new',
            'created_at'    => now()
        ]);
        return $this->success('Your information has been sent. I will respond as soon as possible.');
    }
    public function blogs(DataRequest $request)
    {
        $data               = null;
        $email              = $request->email;

        $data  = BlogModel::with('creator:id,full_name')->where('email', $email)->orderByDesc('created_at')->get()
        ->map(function($item){
            $item->tags         = array_values($item->tags);
            return $item;
        });




        return $this->success('ok', $data);
    }
    public function blogDetail(DataRequest $request,$slug)
    {
        $data               = null;
        $email              = $request->email;

        $data  = BlogModel::with('creator:id,full_name')->where(['email'=> $email,'slug'=>$slug])->first();
        return $this->success('ok', $data);
    }
}
