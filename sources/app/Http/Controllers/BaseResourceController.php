<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\BaseResourceRequest;
use App\Http\Requests\SortRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

abstract class BaseResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @var Model;
     */
    protected $Model;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->_setData();
    }

    abstract protected function _setData();

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() : Response
    {
        $AllData = $this->Model->all();
        $AllData = $this->preIndexResponse($AllData);
        return response($AllData);
    }
    protected function preIndexResponse ($AllData)
    {
        return $AllData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BaseResourceRequest $request
     * @return Response
     */
    public function store(BaseResourceRequest $request) : Response
    {
        $Data = new $this->Model();
        $RequestData = $request->all();
        if (isset($RequestData['_token'])) {
            unset($RequestData['_token']);
        }
        $Data->fill($RequestData);

        if (property_exists($this->Model,'useUpdateUserId') && $this->Model::$useUpdateUserId) {
            $Data->created_user_id = Auth::id();
            $Data->updated_user_id = Auth::id();
        }
        if (property_exists($this->Model,'useOrganization') && $this->Model::$useOrganization && isset($RequestData['organization_id'])) {
            $Data->organization_id = $RequestData['organization_id'];
        }
        if (property_exists($this->Model,'useSortOrder') && $this->Model::$useSortOrder) {
            $Data->sort_order = $this->Model::max('id');
        }

        $Data = $this->preStore($Data, $request);
        $Data->save();
        $Data = $this->afterStore($Data, $request);
        return response($Data);
    }
    protected function preStore(Model $Data, BaseResourceRequest $request) : Model
    {
        return $Data;
    }
    protected function afterStore(Model $Data, BaseResourceRequest $request) : Model
    {
        return $Data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(int $id) : Response
    {
        $Data = $this->Model->find($id);
        $Data = $this->preShowResponse($Data);
        return response($Data);
    }
    public function preShowResponse(Model $Data) : Model
    {
        return $Data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BaseResourceRequest  $request
     * @param  int $id
     * @return Response
     */
    public function update(BaseResourceRequest $request, int $id)  : Response
    {
        $Data = $this->Model->find($id);
        $RequestData = $request->all();
        if (isset($RequestData['_token'])) {
            unset($RequestData['_token']);
        }
        $Data->fill($RequestData);
        if (property_exists($this->Model,'useUpdateUserId') && $this->Model::$useUpdateUserId) {
            $Data->updated_user_id  = Auth::id();
        }
        $Data = $this->preUpdate($Data, $request);
        $Data->update();
        $Data = $this->afterUpdate($Data, $request);

        return response($Data);
    }
    protected function preUpdate(Model $Data, BaseResourceRequest $request) : Model
    {
        return $Data;
    }
    protected function afterUpdate(Model $Data, BaseResourceRequest $request) : Model
    {
        return $Data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(int $id) : Response
    {
        $Data = $this->Model->find($id);
        $Data = $this->preDestroy($Data);
        $Data->delete();
        $Data = $this->afterDestroy($Data);
        return response($Data);
        //
    }
    protected function preDestroy(Model $Data) : Model
    {
        return $Data;
    }
    protected function afterDestroy(Model $Data) : Model
    {
        return $Data;
    }

    /**
     * sort resource
     *
     * @param  SortRequest  $request
     * @return Response
     */
    public function updateSort(SortRequest $request) : Response
    {
        $List = $request->input('id_list');
        $num = 1;
        foreach ($List as $id) {
            $Data = $this->Model->find($id);
            $Data->sort_order = $num;
            $Data->update();
            $num++;
        }
        return response($request);
    }
}
