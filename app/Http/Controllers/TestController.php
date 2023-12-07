<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Test;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Str;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pw = $request->input('pw');

        $test = Test::selectRaw("*, password(?) as input_pw", [$pw])->first();

//        Hash::make($pw)
        //
        $result = array();
        $result = Arr::add($result, 'result', 'success');
        $result = Arr::add($result, 'password', $test->input_pw);
        return response()->json($result);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getS3file(Request $request)
    {
        $path = $request->input('path');
        $url = Storage::disk('s3')->temporaryUrl($path, now()->addHour(3));
//        $url = Storage::temporaryUrl(
//            $path, now()->addMinutes(5)
//        );
//        $url = Storage::disk('s3')->url($path);
        return response()->json([$url]);
    }

    public function getS3()
    {
        $allFiles = Storage::disk('s3')->allFiles('');
        var_dump($allFiles);

        $a = "jandariro58!";
        var_dump(base64_encode($a));
    }

    public function putS3(Request $request)
    {
        $path = $request->file('uploadName')->store('test1','s3');
        var_dump($path);

//        $path = Storage::disk('s3')->put('test1', $request->file('uploadName'), 'public');
//        var_dump($path);
    }

    public function putResizeS3(Request $request)
    {
        $uploadName = $request->file('uploadName');
        $file_name = $uploadName->getClientOriginalName();
        $mime_type = $uploadName->getMimeType();
        var_dump($mime_type);
        $extension = $uploadName->getClientOriginalExtension();
        var_dump($extension);


        $img = Image::make($uploadName->path());
        $resizeImage = $img->resize(1920, 1920, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode($extension);

        $path = 'app/test/'.Str::uuid().".".$extension;
        $storageReturn = Storage::disk('s3')->put($path, $resizeImage->stream()->__toString());
        var_dump($storageReturn);
        var_dump($path);
    }

    public function testUpload()
    {
        return view('test/upload');
    }

    public function deleteS3(Request $request)
    {
        $result = [];
        $path = $request->input('path');
        if(Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
            $result = Arr::add($result, 'result', 'success');
        } else {
            $result = Arr::add($result, 'result', 'fail');
        }

        return response()->json($result);
    }

    public function jsErrorLog(Request $request)
    {
        $data = $request->input('data');

        \App::make('helper')->log('fileUploadError', ['message' => $data]);
    }
}
