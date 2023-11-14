<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\WebsiteData;
use App\Models\ClientPrice;
use App\Models\DataHistory;
use App\Models\Note;
use App\Models\User;
use Response;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ops_list    = User::role('Operation')->get();
        $datas      = Website::with('getScrapeData','getClient')->orderBy('id','DESC')->paginate(5);
        return view('super_admin.website.index',compact('datas','ops_list')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $website_id = $request->website_id;
        $ops_id = $request->ops;

        Website::where('id',$website_id)->update([
            'ops_id' => $ops_id,
        ]);

        return redirect()->route('super-admin.index')
                        ->with('success','Operation Assigned successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function manage_content(Request $request)
    {
        $website_id = $request->website_id;
        Website::where('id',$website_id)->update([
            'title_status'          => $request->title_status,
            'description_status'    => $request->description_status,
            'feature_status'        => $request->feature_status,
            'specification_status'  => $request->specification_status,
            'image_status'          => $request->image_status,
        ]);

        return redirect()->back()->with('success','Content Updated successfully');
    }
}
