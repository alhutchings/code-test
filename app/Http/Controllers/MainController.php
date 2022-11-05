<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = $this->model;

        foreach ($records->allowedFilters as $filter) {
            if (isset($request->{$filter})) {
                $records = $records->where(
                    $filter, 
                    $request->{$filter}
                );
            }
        }

        return $records->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make(
            $data,
            $this->model->validationFields
        );
 
        if ($validator->fails()) {
            return response(
                [
                    'errors' => $validator->errors()
                ],
                400
            );
        }

        $record = $this->model->create($data);

        return $record;
    }
}
