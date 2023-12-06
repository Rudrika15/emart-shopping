<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;

use Illuminate\Support\Facades\DB;
use App\Models\Optiongroup;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;


class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return  view('admin.option.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $optionGroup = Optiongroup::all();

        return  view('admin.option.create', compact('optionGroup'));
    }
    public function getAllData(Request $request)
    { {
            if ($request->ajax()) {
                $data = Option::with('optiongroup')->select('*');
                return \Yajra\DataTables\DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . URL::route('option.edit', $row->id) . '"data-toggle="tooltip" data-original-title="Edit" class="btn btn-primary btn-sm editOption">Edit</a>';
                        $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="deleteOpt btn btn-danger btn-sm">Delete</a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'optionGroupId' => 'required',
            'option' => 'required|array',
        ]);

        $optionGroupId = $request->optionGroupId;
        $options = $request->option;

        // Concatenate options into a single string
        $optionsString = implode(',', $options);

        try {
            Option::create([
                'optionGroupId' => $optionGroupId,
                'option' => $optionsString,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Options saved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error saving options: ' . $e->getMessage(),
            ]);
        }
    }



















    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // Check if 'options' key exists in the request data
    //     // if ($request->has('option')) {
    //     // Assuming 'options' is an array of option data

    //     $this->validate($request, [
    //         'optionGroupId' => 'required',
    //         'option' => 'required|array',
    //     ]);
    //     $optionGroupId = $request->optionGroupId;
    //     $optionList = $request->option;

    //     foreach ($optionList as $opitonIds) {
    //         $optionsData[] = [
    //             'optionGroupId' => $optionGroupId,
    //             'option' => $opitonIds
    //         ];
    //         // $options = new Option();
    //         // $options->optionGroupId = $request->optionGroupId;
    //         // $options->option = $request->$option;
    //         // // dd($option);
    //         // return $options->save();
    //         // return $request->options;
    //         foreach ($optionsData as $data) {
    //             $store =  Option::create($data);
    //         }
    //     }


    //     return "True";
    //     // return response()->json([
    //     //     'status' => 200,
    //     //     'message' => 'Options saved successfully.',
    //     // ]);
    //     // }

    //     return response()->json([
    //         'status' => 400,
    //         'message' => 'No options provided in the request.',
    //     ]);
    // }




    // {
    //     $option =  new Option();
    //     $option->optionGroupId = $request->optionGroupId;
    //     $option->option = $request->option;
    //     $option->save();
    //     return response()->json([
    //         'status' => 200,
    //         $option
    //     ]);
    // }
    /**
     * Display the specified resource.
     */

    public function getOption($id = 0)
    {
        $optionGroupID = $id;
        $option = Option::where('optionGroupId', '=', $optionGroupID)->get();
        print "<select class='form-control'  name='optionIds'>";
        print  " <option selected disble>Select Option</option>";

        foreach ($option as $option) {
            // print "option->option";
            echo "<option value=" . $option->id . ">" . $option->option . "</option>";
        }

        print "</select>";
        return response()->json([
            'status' => 200,
            'Option' => $option
        ]);
    }

    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Option $option)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Option::find($id)->delete();
    }
}
