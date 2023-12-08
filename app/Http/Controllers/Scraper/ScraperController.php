<?php

namespace App\Http\Controllers\Scraper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\ScraperData;
use App\Models\DataHistory;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportEmail;
use App\Models\CronJob;

class ScraperController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid().'.'.$extension;

        $destinationPath = 'scraper-data';
        $file->move($destinationPath,$filename);

        $scraper = ScraperData::create([
            'scraper_user_id'   => auth()->user()->id,
            'website_id'        => $request->website_id,
            'client_file_id'    => $request->client_file_id,
            'path'              => $filename,
        ]);

        // Website::where('id',$request->website_id)->update([
        //     'status' => 1
        // ]);

        
        $cron_job = CronJob::insert([
            'user_id'           => auth()->user()->id,
            'website_id'        => $request->website_id,
            'client_file_id'    => $request->client_file_id,
            'enhance_status'    => $request->enhance_status,
            'scrappe_file_id'   => $scraper->id,
            'status'            => 0
        ]);

        // Add Data History
        $data_history = DataHistory::create([
            'user_id'       => auth()->user()->id,
            'website_id'    => $request->website_id,
            'action'        => 'Scrape file Uploaded'
        ]);

        return redirect()->back()->with('success','File Uploaded successfully');
    }

}
