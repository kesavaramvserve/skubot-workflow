<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteEnhanceData;
use App\Models\Website;
use App\Models\Client;
use DB;
use DataTables; 
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class WebsiteListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id    = auth()->user()->id;
        $user_role  = auth()->user()->getrole->name;
        $user_where_id = $user_role.'_id';
        if($user_role == 'Client'){
            if(auth()->user()->plan == '$49'){
                $sku_count = 500;
            }else if(auth()->user()->plan == '$249'){
                $sku_count = 5000;
            }else if(auth()->user()->plan == '$699'){
                $sku_count = '5000 - 20k';
            }else{
                $sku_count = '20k';
            }
            $plan = auth()->user()->plan;
            if(auth()->user()->payment_status != 1 && auth()->user()->plan != 'Custom Pricing'){
                return view('client.payment',compact('plan','sku_count'));
            }
            if(auth()->user()->sku_selection_status != 1){
                return view('client.sku_upload',compact('sku_count'));
            }
        }
        // if($user_role == 'Team Lead'){
        //     $datas = Website::where('tl_id',$user_id)->paginate(5);
        // }else if($user_role == 'Client'){
        //     if(auth()->user()->plan == '$49'){
        //         $sku_count = 500;
        //     }else if(auth()->user()->plan == '$249'){
        //         $sku_count = 5000;
        //     }else if(auth()->user()->plan == '$699'){
        //         $sku_count = '5000 - 20k';
        //     }else{
        //         $sku_count = '20k';
        //     }
        //     if(auth()->user()->payment_status != 1){
        //         return view('client.payment',compact('sku_count'));
        //     }
        //     if(auth()->user()->sku_selection_status != 1){
        //         return view('client.sku_upload',compact('sku_count'));
        //     }
        //     $client_id = Client::where('user_id',$user_id)->value('id');
        //     $datas = Website::where('user_id',$user_id)->paginate(5);
        // }
        // else{
        //     $datas = WebsiteEnhanceData::with('getWebsite')->select('*')->where($user_where_id , $user_id)->groupBy('website_id')->paginate(5);
        // }
        // return view('website_list',compact('datas'));
        if ($request->ajax()) {
            if($user_role == 'Team Lead'){ // Team Lead
                $data = Website::where('tl_id',$user_id)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('client_name', function ($data) {
                        $client_name = $data->first_name." ".$data->last_name;
                        return $client_name;
                    })
                    ->editColumn('client_email', function ($data) {
                        $client_email = $data->getClient->getUser->email;
                        return $client_email;
                    })
                    ->editColumn('company_name', function ($data) {
                        $company_name = $data->getClient->company_name;
                        return $company_name;
                    })
                    ->addColumn('action', function($data){
                            $enc_id = Crypt::encryptString($data->id);
                            $btns = '';
                            $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
                            if(!blank($data->getWebsiteEnhancedData)){
                                // Split SKU's 
                                $select .= '<option value="split_sku'.$data->id.'">Split SKU</option>';
                                $btns .= '<a href="'.route('split_sku',$enc_id).'" class="action-button" ><img id="split_sku'.$data->id.'" src="'.asset('client/images/split.png').'" alt="Create Batch" title="Create Batch"></a>';
                                // Batches
                                $select .= '<option value="batch_list'.$data->id.'">Batch List</option>';
                                $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="action-button"><img id="batch_list'.$data->id.'" src="'.asset('client/images/batch.png').'" alt="batch" title="batches"></a>';
                            }else{
                                $select .= '<option value="import_enhance_data'.$data->id.'">Import Enhance Data</option>';
                                $btns .= '<a href="javascript:void(0)" class="enhance-import action-button" data-id="'. $data->id .'"><img id="import_enhance_data'.$data->id.'" src="'.asset('client/images/import.png').'" alt="import" title="Import Enhanced Data"></a>';
                            }
      
                            $select .= '</select>';
                            $select .= $btns;

                            return $select;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }else if($user_role == 'Client'){ // Client
                $data = Website::where('user_id',$user_id)->orderBy('id', 'desc');
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('client_name', function ($data) {
                        $client_name = $data->first_name." ".$data->last_name;
                        return $client_name;
                    })
                    ->editColumn('client_email', function ($data) {
                        $client_email = $data->getClient->getUser->email;
                        return $client_email;
                    })
                    ->editColumn('company_name', function ($data) {
                        $company_name = $data->getClient->company_name;
                        return $company_name;
                    })
                    ->addColumn('action', function($data){
                            $enc_id = Crypt::encryptString($data->id);
                            $btns = '';
                            $option = 0;
                            $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
                            if(!blank($data->getWebsiteData) && blank($data->getClientRequiremnet) && !blank($data->getNotes)){
                                $select .= '<option value="view_report'.$data->id.'">View Report</option>';
                                $btns .= '<a href="'.route('client',$enc_id).'" class="action-button"><img id="view_report'.$data->id.'" src="'.asset('client/images/view.png').'" alt="Scrape Report" title="Scrape Report"></a>';
                                $option = $option + 1;
                            }elseif(!blank($data->getClientRequiremnet)){
                                $select .= '<option value="batches'.$data->id.'">Batches</option>';
                                $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="action-button"><img id="batches'.$data->id.'" src="'.asset('client/images/batch.png').'" alt="batch" title="batches"></a>';
                                $option = $option + 1;
                            }

                            $select .= '</select>';
                            $select .= $btns;

                            if($option > 0){
                                return $select;
                            }
                            
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('website', 'LIKE', "%$search%");                                
                            });
                        }
                        if (!empty($request->get('show'))) {
                            $instance->where(function($w) use($request){
                               $show = $request->get('show');
                               $w->limit($show);                                
                           });
                       }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }else{ // Others
                $data = WebsiteEnhanceData::with('getWebsite')->select('*')->where($user_where_id , $user_id)->groupBy('website_id')->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('client_name', function ($data) {
                        $client_name = $data->getWebsite->first_name;
                        return $client_name;
                    })
                    ->editColumn('client_email', function ($data) {
                        $client_email = $data->getWebsite->email;
                        return $client_email;
                    })
                    ->editColumn('company_name', function ($data) {
                        $company_name = $data->getWebsite->company_name;
                        return $company_name;
                    })
                    ->editColumn('website', function ($data) {
                        $website = $data->getWebsite->website;
                        return $website;
                    })
                    ->addColumn('action', function($data){
                            $enc_id = Crypt::encryptString($data->website_id);
                            $btns = '';
                            $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
                            // Batches
                            $select .= '<option value="batches'.$data->id.'">Batches</option>';
                            $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="action-button" data-id="'. $data->website_id .'"><img id="batches'.$data->id.'" src="'.asset('client/images/batch.png').'" alt="batch" title="batches"></a>';
                            // Upload Enhance Data
                            $select .= '<option value="import_enhance_data'.$data->id.'">Import Enhance Data</option>';
                            $btns .= '<a href="'.route('batch_list.create').'" class="action-button" data-id=""><img id="import_enhance_data'.$data->id.'" src="'.asset('client/images/import.png').'" alt="import" title="Import Enhanced Data"></a>';
      
                            $select .= '</select>';
                            $select .= $btns;

                            return $select;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        
        return view('website_list');
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
        //
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
}
