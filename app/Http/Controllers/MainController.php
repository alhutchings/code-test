<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App;

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

        if (isset($request->with)) {

            $withs = explode(',', $request->with);

            foreach ($withs as $with) {
                $records = $records->with($with);
            }

        }

        foreach ($this->model->allowedFilters as $filter) {

            if (isset($request->{str_replace(".", "_", $filter)})) {

                if (str_contains($filter, ".")) {
                    $filterArray = explode(".", $filter);
                    $records = $records->with([$filterArray[0] => function($query) use ($filterArray, $request, $filter) {
                        $query->where($filterArray[1], $request->{str_replace(".", "_", $filter)});
                   }]);
                } else {
                    $records = $records->where(
                        $filter, 
                        $request->{$filter}
                    );
                }
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

        foreach ($data as $key => $row) {
            if (in_array($key, array_keys($this->model->foreign))) {
                $childModel = App::make($this->model->foreign[$key]);
                $childRecord = $childModel->firstOrCreate($row);
                $data[$key . '_id'] = $childRecord->id;
                unset($data[$key]);
            }
        }

        $record = $this->model->create($data);

        return $record;
    }
}
