<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\DataHistory;
use Illuminate\Support\Facades\Crypt;
use App\Mail\EnhancedEmail;
use Illuminate\Support\Facades\Mail;

class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function send_enhance_mail($id)
    {
        // Send Mail to Support
        $website = Website::where('id',$id)->get();
        $email = $website[0]->getClient->getUser->email;
        // $email      = "kesavaram@vservesolution.com";
        $website    = Website::where('id',$id)->value('website');
        $encrypted  = Crypt::encryptString($id);
        $url        = config('app.url').'public/client/result/'.$encrypted;
        $mailData = [
            'title'     => 'Hai, Enhancing is completed for ' . $website. '. Please check with this below URL.',
            'website'   => $website,
            'url'       => $url,
        ];
        Mail::to($email)->send(new EnhancedEmail($mailData));
        
        // Add Data History
        $user_id = auth()->user()->id;
        $data_history = DataHistory::create([
            'user_id'       => $user_id,
            'website_id'    => $id,
            'action'        => 'sent enhance report to client mail'
        ]);

        return redirect()->route('website.index')->with('success','Mail sent Successfully');
    }
}
