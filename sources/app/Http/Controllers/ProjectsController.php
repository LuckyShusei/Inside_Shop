<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;


class ProjectsController extends BaseResourceController
{
    protected function _setData()
    {
        $this->Model = new Project();
    }

    public function show($id) : Response
    {
        $Data = Project::with(['items'])->find($id);
        return response($Data);
    }
}
