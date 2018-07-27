<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
          'cursol' => 'integer|min:0',
        ]);

        $Image = Image::where('delete_flg', false)->orderBy('id', 'desc');
        if ($request->cursol){
          $images = $Image->where('id', '>=', $request->cursol)->get();
        } else {
          $images = $Image->get();
        }
        return response()->json($images);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $UPLOAD_FILESIZE_MAX = env("UPLOAD_FILESIZE_MAX");
      # バリデーション
      $user_id = auth()->id() ?? NULL;
      $this->validate($request, [
        'name' => "required|string|max:255",
        'file' => "required|image|max:${UPLOAD_FILESIZE_MAX}"
      ]);
      #
      if ($request->file('file')->isValid([])) {
          DB::beginTransaction();

          $filename = null;

          try {
            // ファイル名の決定
            $currenttime_withmicro = Carbon::now()->timestamp . Carbon::now()->micro;
            $extention = $request->file('file')->getClientOriginalExtension();
            $filename = "{$user_id}_{$currenttime_withmicro}.{$extention}";

            // ストレージに保存
            $filepath = $request->file->storeAs(
              'public', $filename
            );
            $filepath = preg_replace('/^public/', '', $filepath);

            // DBにinsertするデータの準備と保存
            $image = new Image;
            $image->name = $request->name;
            $image->author_id = $user_id;
            $image->author_ip = \Request::ip();
            $image->path = $filepath;
            $image->save();
            DB::commit();

            return response()->json([
              'success' => true,
              'uploadTo' => $filepath
            ], 200);

          } catch (\Exception $e) {
            // 失敗時はロールバックと保存してしまったデータを削除
            DB::rollback();
            if ($filepath) {
              Storage::delete($filepath);
            }
          }
      }

      return response()->json([
        'success' => false,
        'error' => 'アップロードに失敗しました'
      ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      Validator::make(['id' => $id], [
        'id' => 'integer|min:0'
      ])->validate();

      $image = Image::find($id);
      return response()->json($image);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
      Validator::make(['id' => $id], [
        'id' => 'integer|min:0'
      ])->validate();

      try {
        $image = Image::find($id);
        $image->delete_flg = true;
        $image->save();
        return response()->json([
          'success' => true
        ], 200);

      } catch (\Exception $e) {
        // 失敗時
        Log::error($e);
        return response()->json([
          'success' => false,
          'error' => '削除に失敗しました'
        ], 500);
      }
    }
}
