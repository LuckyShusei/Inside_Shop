<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseResourceRequest;
use App\Models\SysFile;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Auth;

class SysFilesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @var Model;
     */
    protected $Model;

    public function __construct()
    {
        $this->_setData();
    }

    protected function _setData()
    {
        $this->Model = new SysFile();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BaseResourceRequest $request
     * @return Response
     */
    public function store(BaseResourceRequest $request, $expired_at = null)
    {
        $this->middleware('auth:api');
        $uploadedFile = $request->file('input_file');
        try {
            $FileData = FileService::uploadFile($uploadedFile);
            $FileData['expired_at'] = $expired_at;

            $Res  = ['id' => $FileData['id'], 'mime_type' => $FileData['mime_type']];

            $file_blob = FileService::resizeImage($FileData['name'], $FileData['thumbnail_uri']);
            $Res['data'] = base64_encode($file_blob);

            $Data = new $this->Model();
            $Data->fill($FileData);
            $Data->id = $FileData['id'];
            if ($this->Model::$useUpdateUserId) {
                $Data->created_user_id = Auth::id();
                $Data->updated_user_id = Auth::id();
            }
            if ($this->Model::$useOrganization && isset($RequestData['organization_id'])) {
                $Data->organization_id = $RequestData['organization_id'];
            }
            $Data->save();
            return response($Res);
        } catch (FileNotFoundException $e) {
            return response([
                'error' => [
                    'message' => 'failed',
                    'status_code' => '500'
                ]
            ]);
        }
    }

    public function register(BaseResourceRequest $request)
    {
        $this->middleware('auth:api');

        $id = $request->get('id');

        $Data = $this->Model->find($id);
        $Data->expired_at = null;
        if ($this->Model::$useUpdateUserId) {
            $Data->updated_user_id = Auth::id();
        }
        $Data->update();
        return response(['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->middleware('auth:api');

        $Data = $this->Model->find($id);
        $Data['expired_at'] = date('Y-m-d H:i:s');
        if ($this->Model::$useUpdateUserId) {
            $Data->updated_user_id = Auth::id();
        }
        $Data->update();
        return response(['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BaseResourceRequest $request
     * @return Response
     */
    public function temp(BaseResourceRequest $request)
    {
        $this->middleware('auth:api');
        return $this->store($request, date('Y-m-d H:i:s', strtotime('+1hour')));
    }

    public function showThumbnail($id)
    {
        $this->middleware('auth:api');
        $Data = $this->Model->find($id);
        if ($Data['expired_at'] === null || strtotime($Data['expired_at']) > time()) {
            $Res = [
                'id' => $Data['id'],
                'mime_type' => $Data['mime_type'],
                'data' => base64_encode(FileService::getData($Data['thumbnail_uri']))
            ];
        } else {
            $Res = [];
        }
        return response($Res);
    }

    public function show($id)
    {
        $this->middleware('auth:api');
        $Data = $this->Model->find($id);
        if ($Data['expired_at'] === null || strtotime($Data['expired_at']) > time()) {
            $Res = [
                'id' => $Data['id'],
                'mime_type' => $Data['mime_type'],
                'name' => $Data['client_name'],
                'size' => $Data['size'],
                'data' => base64_encode(FileService::getData($Data['link_uri']))
            ];
        } else {
            $Res = [];
        }
        return response($Res);
    }

    public function raw ($id)
    {
        $Data = $this->Model->find($id);

        if ($Data['expired_at'] === null || strtotime($Data['expired_at']) > time()) {
            $path = $Data['name'];
            $disk = \Storage::disk('upload');
            $filename = $Data['client_name'];
            return response($disk->get($path))
                ->header('Content-Type', $Data['mime_type']
                ->header('Content-Disposition'. 'attachment; filename*=UTF-8\'\''.rawurlencode($filename))
                );
        }
        return response('');
    }
}
