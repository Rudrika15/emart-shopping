<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Optiongroup;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class OptiongroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.optionGroup.index');
    }

    public function getAllData(Request $request)
    {
        if ($request->ajax()) {

            $data = Optiongroup::with('option')->with('category')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . URL::route('optionGroup.edit', $row->id) . '"data-toggle="tooltip" data-original-title="Edit" class="btn btn-primary  me-2 btn-sm editOptiongGrp">Edit</a>';
                    $btn = $btn . '<a href="javascript:void(0)"  data-id="' . $row->id . '" class="deleteOption btn btn-danger  me-2 btn-sm">Delete</a>';
                    $btn = $btn . '<a href="' . URL::route('option.create', $row->id) . '" class="AddOption  me-2 btn btn-info btn-sm">Add Variant</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.optionGroup.create', compact('category'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $this->validate($request, [
        //     'optionGroupName' => '',
        // ]);

        $optionGroup = new Optiongroup();
        $optionGroup->optionGroupName = $request->optionGroupName;
        $optionGroup->categoryId = $request->categoryId;

        // $optionGroup->optionId = $request->optionId;
        $optionGroup->save();

        return redirect()->route('optionGroup.index')->with('status', 'Data saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Optiongroup $optiongroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $optionGroup = Optiongroup::find($id);
        $category = Category::all();
        return view('admin.optionGroup.edit', compact('optionGroup', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->optiongroup_id;
        $optionGroup =  Optiongroup::find($id);
        $optionGroup->optionGroupName = $request->optionGroupName;
        $optionGroup->categoryId = $request->categoryId;
        // $optionGroup->optionId = $request->optionId;
        $optionGroup->save();
        return response()->json([
            'success' => true,
            'message' => 'Details Edited Successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Optiongroup::find($id)->delete();
    }
}
