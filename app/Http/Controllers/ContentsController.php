<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContentsRequest;
use App\Http\Requests\UpdateContentsRequest;
use App\Http\Resources\ContentsResource;
use App\Models\Contents;
use App\Models\ContentType;
use Carbon\Carbon;
use Faker\Core\File;
use http\Env\Response;
use Illuminate\Http\Request;


class ContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $allContentUploaded = Contents::all();

//        $allContentUploaded['content_image']=url($allContentUploaded['content_image']);
        return ContentsResource::collection($allContentUploaded);
    }

    public function allContentsIds()
    {
        $finalObj=[];

//        $allContentUploaded = Contents::all(['component_id', 'id']);
        $allContentUploaded = ContentType::all();
        $v1=[];
        foreach ($allContentUploaded as $eachIds){
//            echo($eachIds['comp_id'][0]);

            if(!in_array($eachIds['main_comp_id'],$v1)){

//                echo $eachIds['main_comp_id'];
                $eachCompChild=ContentType::where('main_comp_id',$eachIds['main_comp_id'])->get();
//                ContentType::where
//                echo($eachCompChild);
                $eachChildArray=[];
                foreach ($eachCompChild as $eachChild){
//                    echo $eachChild['comp_id'];
                    array_push($eachChildArray,$eachChild['comp_id']);
                }//TODO:finish something here...


                array_push($v1,$eachIds['main_comp_id']);
//                array_push($v1,$eachChildArray);
            }
        }


        return \response()->json(['message' => "all Contents Ids", 'data' => $v1]);
    }


    public function createContents(Request $request)
    {
        if(isset($request->imageFile['fileData']) && isset($request->imageFile['fileType'])){
            $fileSize = (strlen($request->imageFile['fileData']) * (3 / 4) - 2) / 1024;

//            if ($fileSize >= 0.499) {

                $contentPath = public_path() . '/' . env('CONTENT_FILES_DIR');
                if (!\File::exists($contentPath)) {
                    \File::makeDirectory($contentPath);
                } else {
                    if (in_array($request->imageFile['fileType'], explode(',', env('FILE_EXTENSION')))) {
                        if ($fileSize > env('FILE_SIZE_Kb')) {
                            return response()->json(['message' => "" . $fileSize . "Kb File size exceed the limit of " . env('FILE_SIZE_Kb') . "Kb"])->setStatusCode(400);
                        } else {

                            $imageBase64 = $request->imageFile['fileData'];
                            $imageBase64 = str_replace('data:image/png;base64,', '', $imageBase64);
                            $imageBase64 = str_replace(' ', '+', $imageBase64);
                            $currentTime = str_replace(" ", "T", Carbon::now());
                            $imageName = hash('md5', $imageBase64) . $currentTime . '.' . $request->imageFile['fileType'];

                            $newContent = Contents::create([
                                'content_head' => $request->contentHead,
                                'content_body' => $request->contentBody,
                                'component_id' => $request->contentType,
                                'content_image' => $imageName
                            ]);

                            if ($newContent) {
                                $newContent['content_image'] = url('/' . env('CONTENT_FILES_DIR') . '/' . $newContent['content_image']);

                                \File::put($contentPath . '/' . $imageName, base64_decode($imageBase64));
                                return response()->json(['message' => "Content added Successfully", 'data' => $newContent], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

                            } else {
                                return response()->json(['message' => "Something Wrong Here"])->setStatusCode(400);
                            }
                        }
                    } else {
                        return response()->json(['message' => "{" . $request->imageFile['fileType'] . "} File extension not allowed"])->setStatusCode(400);

                    }
                }

        }else{
            $newContent = Contents::create([
                'content_head' => $request->contentHead,
                'content_body' => $request->contentBody,
                'component_id' => $request->contentType,
            ]);

            if ($newContent) {

                return response()->json(['message' => "Content added Successfully", 'data' => $newContent], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            } else {
                return response()->json(['message' => "Something Wrong Here"])->setStatusCode(400);
            }

        }
//

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreContentsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreContentsRequest $request)
    {
        //
        return response()->json(['req' => $request]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Contents $contents
     * @return \Illuminate\Http\Response
     */
    public function show(Contents $contents)
    {


    }

    public function eachContent($contentId)
    {
        $eachContent = Contents::where('component_id','LIKE',$contentId.'%')->get();
        return ContentsResource::collection($eachContent);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Contents $contents
     * @return \Illuminate\Http\Response
     */
    public function edit(Contents $contents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateContentsRequest $request
     * @param \App\Models\Contents $contents
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentsRequest $request, Contents $contents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Contents $contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contents $contents)
    {
        //
    }
}
