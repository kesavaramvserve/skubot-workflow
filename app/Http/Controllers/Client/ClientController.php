<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Hash;
use App\Models\User;
use App\Models\Client;
use App\Models\DataHistory;
use App\Models\Website;
use App\Models\WebsiteRange;
use App\Models\WebsiteData;
use App\Models\WebsiteEnhanceData;
use App\Models\ClientPrice;
use App\Models\Note;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScraperEmail;
use App\Mail\SupportEmail;
use App\Mail\PaymentEmail;
use App\Mail\SubmitThanksEmail;
use App\Mail\EnhanceRequestEmail;
use App\Mail\PaymentInitiateEmail;
use Illuminate\Support\Facades\Crypt;
use App\Models\ClientRequirement;
use App\Models\ClientRequestData;
use App\Exports\DataExport;
use App\Exports\DownloadSkus;
use Excel;
use Session;
use Stripe;
use Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = '';
        return view('client.register',compact('plan'));
    }

    public function client_register_plan($plan)
    {
        return view('client.register',compact('plan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Data Validation
        $this->validate($request, [
            'first_name'    => 'required|min:3',
            'email'         => 'required|email|unique:users,email',
            'company_name'  => 'required',
            'password'      => 'required',
            'c_password'    => 'required|same:password',
            'plan'          => 'required',
        ]);

        // Date Reset
        $password               = $request->password;
        $input                  = $request->all();
        $input['password']      = Hash::make($password);
        $input['first_name']    = $input['first_name'];
        // $input['last_name']     = $input['last_name'];
        $input['plan']          = $input['plan'];
        $input['company_name']  = $input['company_name'];
    
        // Date Store
        DB::beginTransaction();
        try {
            $client_role_id = DB::table('roles')->where('name','Client')->value('id');
            $user = User::create($input);
            $user->assignRole($client_role_id);

            // $client = Client::create([
            //     'user_id'       => $user->id,
            //     'company_name'  => $request->company_name,
            //     'website'       => $request->website
            // ]);

            // $ops_id = User::role('Operation')->value('id');

            // $website = Website::create([
            //     'first_name'    => $request->first_name,
            //     'last_name'     => $request->last_name,
            //     'email'         => $request->email,
            //     'company_name'  => $request->company_name,
            //     'user_id'       => $user->id,
            //     'client_id'     => $client->id,
            //     'website'       => $request->website,
            //     'ops_id'        => $ops_id,
            // ]);

            // Set Default Price
            // $content_id = 1;
            // $range_id = 0;
            // $price = 6;
            // for($i=1;$i<=25;$i++){
            //     $range_id++;
            //     $price--;
            //     if($i==6 || $i==11 || $i==16 || $i==21 || $i==26){
            //         $content_id++;
            //         $range_id = 1;
            //         $price = 5;
            //     }
            //     $client_price = ClientPrice::create([
            //         'client_id'     => $client->id,
            //         'website_id'    => $website->id,
            //         'content_id'    => $content_id,
            //         'range_id'      => $range_id,
            //         'price'         => $price
            //     ]);
            // }   

            // Add Data History
            // $data_history = DataHistory::create([
            //     'user_id'       => $user->id,
            //     'website_id'    => $website->id,
            //     'action'        => 'Client Registered'
            // ]);

            // Send Mail to Scraper
            // $email1 = "testing@vserve.co";
            // $email2 = "kesavaram@vservesolution.com";
            $email = $request->email;
            $mailData = [
                'title'     => 'Hai, New Client want to Check Website Health with our Tool',
                'website'   => $request->website,
                'first_name'=> $request->first_name
            ];
            // Mail::to($email1)->send(new ScraperEmail($mailData));
            // Mail::to($email)->send(new ScraperEmail($mailData));
            Mail::to($email)->send(new SupportEmail($mailData));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        DB::commit();
        if($request->plan == '$49'){
            $sku_count = 500;
        }else if($request->plan == '$249'){
            $sku_count = 5000;
        }else if($request->plan == '$699'){
            $sku_count = '5000 - 20k';
        }else{
            $sku_count = '20k';
        }
        $plan = $request->plan;
        // Log in the user
        Auth::login($user);

        if($request->plan == 'Custom Pricing'){
            return view('client.sku_upload',compact('sku_count'));
        }else{
            return view('client.payment',compact('plan','sku_count'));
        }
    }

    public function sku_selection(Request $request)
    {
            // dd($request);
            // Validate
            // $request->validate([
            //     'website_url'   => 'required',
            //     'file'          => 'file',
            // ]);
            $user_id = auth()->user()->id;
            $validator = Validator::make($request->all(), [
                'file'          => 'file',
                'website'   => [
                                        'required',
                                        Rule::unique('websites')->where(function ($query) use ($request,$user_id) {
                                            return $query->where('user_id',$user_id);
                                        })
                                    ],
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()
                                 ->withErrors($validator)
                                 ->withInput();
            }

            $filename = '';
            if($request->file('file')){
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $filename = uniqid().'.'.$extension;
        
                $destinationPath = 'client-sku-files';
                $file->move($destinationPath,$filename);
            }
            

            $client = Client::create([
                'user_id'       => auth()->user()->id,
                'company_name'  => auth()->user()->company_name,
                'website'       => $request->website
            ]);

            $ops_id = User::role('Operation')->value('id');

            $website = Website::create([
                'first_name'    => auth()->user()->first_name,
                'email'         => auth()->user()->email,
                'company_name'  => auth()->user()->company_name,
                'user_id'       => auth()->user()->id,
                'client_id'     => $client->id,
                'website'       => $request->website,
                'sku_file'      => $filename,
                'audit'         => $request->audit,
                'category'      => $request->category,
                'comments'      => $request->comments,
                'ops_id'        => $ops_id,
            ]);

            // Set Default Price
            $content_id = 1;
            $range_id = 0;
            $price = 6;
            for($i=1;$i<=25;$i++){
                $range_id++;
                $price--;
                if($i==6 || $i==11 || $i==16 || $i==21 || $i==26){
                    $content_id++;
                    $range_id = 1;
                    $price = 5;
                }
                $client_price = ClientPrice::create([
                    'client_id'     => $client->id,
                    'website_id'    => $website->id,
                    'content_id'    => $content_id,
                    'range_id'      => $range_id,
                    'price'         => $price
                ]);
            }   

            // Update sku_selection_status
            User::where('id',auth()->user()->id)->update([
                'sku_selection_status' => 1,
            ]);

            // Add Data History
            $data_history = DataHistory::create([
                'user_id'       => auth()->user()->id,
                'website_id'    => $website->id,
                'action'        => 'Sku Selected Successfully'
            ]);

        return view('client.thanks');
    }

    public function payment(Request $request)
    {
        // dd($request->stripeToken);
        Stripe\Stripe::setApiKey("sk_test_nlUQnIMahUX08N1ctHZhpfTp00P61z3r9G");
        $email = auth()->user()->email;
        $plan_amount = auth()->user()->plan;
        if($plan_amount == '$49'){
            $amount         = 100 * 49;
            $description    = '500 SKUs';
        }else if($plan_amount == '$249'){
            $amount         = 100 * 249;
            $description    = '5000 SKUs';
        }else if($plan_amount   = '$699'){
            $amount         = 100 * 699;
            $description    = '5000 - 20k SKUs';
        }
        // Create a Customer
        $customer = Stripe\Customer::create(array(
            "address" => [
                    "line1" => $request->address,
                    "postal_code" => $request->zip_code,
                    "city" => $request->city,
                    "state" => $request->state,
                    "country" => $request->country,
                ],
            "email" => $email,
            "name" => $request->name,
            "source" => $request->stripeToken
         ));

        // dd($customer);
        // Create a charge
        $charge = Stripe\Charge::create([
            'amount' => $amount, // Amount in cents
            'currency' => 'usd',
            "customer" => $customer->id,
            // 'source' => $request->stripeToken,
            'description' => $description,
            "shipping" => [
                "name" => $request->name,
                "address" => [
                    "line1" => $request->address,
                    "postal_code" => $request->zip_code,
                    "city" => $request->city,
                    "state" => $request->state,
                    "country" => $request->country,
                ],
  
              ]
        ]);

        // Retrieve the payment ID
        $paymentId = $charge->id;
      
        // Session::flash('success', 'Payment successful!');

        User::where('id',auth()->user()->id)->update([
            'payment_status' => 1,
            'payment_id'     => $paymentId
        ]);

        $email = auth()->user()->email;
        $mailData = [
            'website'   => auth()->user()->website,
            'first_name'=> auth()->user()->first_name
        ];
        Mail::to($email)->send(new PaymentEmail($mailData));

        return view('client.payment_thanks');
    }    

    public function sku_upload_view()
    {
        if(auth()->user()->plan == '$49'){
            $sku_count = 500;
        }else if(auth()->user()->plan == '$249'){
            $sku_count = 5000;
        }else if(auth()->user()->plan == '$699'){
            $sku_count = '5000 - 20k';
        }else{
            $sku_count = '20k';
        }
        return view('client.sku_upload',compact('sku_count'));
    }

    public function sku_selection_view()
    {
        if(auth()->user()->plan == '$49'){
            $sku_count = 500;
        }else if(auth()->user()->plan == '$249'){
            $sku_count = 5000;
        }else if(auth()->user()->plan == '$699'){
            $sku_count = '5000 - 20k';
        }else{
            $sku_count = '20k';
        }
        return view('client.sku_selection',compact('sku_count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function client_dashboard(Request $request, $id)
    {
        if(!empty($request->website_id)){
            $website_id = $request->id;
        }else{
            $website_id = Crypt::decryptString($id);
        }

        // Add Data History
        $website = Website::with('getClient')->where('id',$website_id)->get();
        $user_id = $website[0]->getClient->getUser->id;
        $data_history = DataHistory::create([
            'user_id'       => $user_id,
            'website_id'    => $website_id,
            'action'        => 'Client Viewed'
        ]);
        $db_title           = WebsiteRange::where('website_id',$website_id)->where('content','title')->get();
        $db_description     = WebsiteRange::where('website_id',$website_id)->where('content','description')->get();
        $db_feature         = WebsiteRange::where('website_id',$website_id)->where('content','feature')->get();
        $db_specification   = WebsiteRange::where('website_id',$website_id)->where('content','specification')->get();
        $db_image           = WebsiteRange::where('website_id',$website_id)->where('content','image')->get();
        
        $title                      = [$db_title[0]->high_attention_required,$db_title[0]->needs_improvement,$db_title[0]->good_to_improve,$db_title[0]->average_optimized,$db_title[0]->optimized];
        $description                = [$db_description[0]->high_attention_required,$db_description[0]->needs_improvement,$db_description[0]->good_to_improve,$db_description[0]->average_optimized,$db_description[0]->optimized];
        $feature                    = [$db_feature[0]->high_attention_required,$db_feature[0]->needs_improvement,$db_feature[0]->good_to_improve,$db_feature[0]->average_optimized,$db_feature[0]->optimized];
        $specification              = [$db_specification[0]->high_attention_required,$db_specification[0]->needs_improvement,$db_specification[0]->good_to_improve,$db_specification[0]->average_optimized,$db_specification[0]->optimized];
        $image                      = [$db_image[0]->high_attention_required,$db_image[0]->needs_improvement,$db_image[0]->good_to_improve,$db_image[0]->average_optimized,$db_image[0]->optimized];
        // $title                      = [40,60,70,80,81];
        // $description                = [30,60,80,100,101];
        // $feature                    = [0,2,3,4,5];
        // $specification              = [0,2,3,4,5];
        // $image                      = [0,2,3,4,5];
        $title_report               = [0,0,0,0,0];
        $description_report         = [0,0,0,0,0];
        $feature_report             = [0,0,0,0,0];
        $specification_report       = [0,0,0,0,0];
        $image_report               = [0,0,0,0,0];
        $title_pres_report          = [0,0,0,0,0];
        $description_pres_report    = [0,0,0,0,0];
        $feature_pres_report        = [0,0,0,0,0];
        $specification_pres_report  = [0,0,0,0,0];
        $image_pres_report          = [0,0,0,0,0];
        $score                      = [1,2,3,4,5];
        $starter                    = 0;
        $categories                 = WebsiteData::select('category')->where('website_id',$website_id)->where('category','!=',null)->groupBy('category')->get();
        $category_count             = count($categories);
        $brands                     = WebsiteData::select('brand')->where('website_id',$website_id)->where('brand','!=',null)->groupBy('brand')->get();        
        $brand_count                = count($brands);
        $website_name               = Website::where('id',$website_id)->value('website');
        $req_category               = '';
        $req_brand                  = '';
        $price_list                 = ClientPrice::where('website_id',$website_id)->get();
        $data                       = Website::where('id',$website_id)->get();

        if(!empty($request->category)){
            $req_category = $request->category;
        }
        if(!empty($request->brand)){
            $req_brand = $request->brand;
        }

        $query = WebsiteData::where('website_id',$website_id);
        if(!empty($request->category)){
            $query->where('category',$request->category);
        }
        if(!empty($request->brand)){
            $query->where('brand',$request->brand);
        }
        $res_value = $query->count();
        // dd($res_value);

        // title
        foreach($title as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $title ) - 1){
                $query->where('title_character_count','>=',$range);
            }else{
                $query->where('title_character_count','>=',$starter)->where('title_character_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $title_result                   = $query->count();
            $title_report[$range_key]       = $title_result;
            $starter                        = $range + 1;
        }

        // Title Percentage Calculation
        $data_count = array_sum($title_report);
        if($data_count != 0){
            foreach($title as $range_key => $range){
                $number                         = ( $title_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $title_pres_report[$range_key]  = $pers_result;
            }
        }

        // Title Score Calculation
        if($data_count != 0){
            foreach($title_report as $range_key => $title_reports){
                $title_score_arr[] = $title_reports * $score[$range_key];
            }
            $title_score = round(array_sum($title_score_arr) / $data_count, 2);
        }else{
            $title_score = 0.00;
        }

        // description
        $starter = 0;
        foreach($description as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $description ) - 1){
                $query->where('description_word_count','>=',$range);
            }else{
                $query->where('description_word_count','>=',$starter)->where('description_word_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $description_result = $query->count();
            $description_report[$range_key]         = $description_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($description_report);
        if($data_count != 0){
            foreach($description as $range_key => $range){
                $number                                 = ( $description_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $description_pres_report[$range_key]    = $pers_result;
            }
        }

        // Description Score Calculation
        if($data_count != 0){
            foreach($description_report as $range_key => $description_reports){
                $description_score_arr[] = $description_reports * $score[$range_key];
            }
            $description_score = round(array_sum($description_score_arr) / $data_count, 2);
        }else{
            $description_score = 0.00; 
        }

        // feature
        $starter = 0;
        foreach($feature as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $feature ) - 1){
                $query->where('feature_count','>=',$range);
            }else{
                $query->where('feature_count','>=',$starter)->where('feature_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $feature_result = $query->count();
            $feature_report[$range_key]         = $feature_result;
            $starter                            = $range + 1;
        }
        $data_count = array_sum($feature_report);
        if($data_count != 0){
            foreach($feature as $range_key => $range){
                $number                             = ( $feature_report[$range_key] / $data_count ) * 100;
                $string                             = floatval($number);
                $pers_result                        = number_format($string, 2, '.', '');
                $feature_pres_report[$range_key]    = $pers_result;
            }
        }

        // Feature Score Calculation
        if($data_count != 0){
            foreach($feature_report as $range_key => $feature_reports){
                $feature_score_arr[] = $feature_reports * $score[$range_key];
            }
            $feature_score = round(array_sum($feature_score_arr) / $data_count, 2);
        }else{
            $feature_score = 0.00;
        }

        // specification
        $starter = 0;
        foreach($specification as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $specification ) - 1){
                $query->where('specification_count','>=',$range);
            }else{
                $query->where('specification_count','>=',$starter)->where('specification_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $specification_result = $query->count();
            $specification_report[$range_key]       = $specification_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($specification_report);
        if($data_count != 0){
            foreach($specification as $range_key => $range){
                $number                                 = ( $specification_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $specification_pres_report[$range_key]  = $pers_result;
            }
        }

        // Specification Score Calculation
        if($data_count != 0){
            foreach($specification_report as $range_key => $specification_reports){
                $specification_score_arr[] = $specification_reports * $score[$range_key];
            }
            $specification_score = round(array_sum($specification_score_arr) / $data_count, 2);
        }else{
            $specification_score = 0.00;
        }

        // image
        $starter = 0;
        foreach($image as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $image ) - 1){
                $query->where('image_count','>=',$range);
            }else{
                $query->where('image_count','>=',$starter)->where('image_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $image_result = $query->count();
            $image_report[$range_key]       = $image_result;
            $starter                        = $range + 1;
        }
        $data_count = array_sum($image_report);
        if($data_count != 0){
            foreach($image as $range_key => $range){
                $number                         = ( $image_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $image_pres_report[$range_key]  = $pers_result;
            }
        }

         // Image Score Calculation
        if($data_count != 0){
            foreach($image_report as $range_key => $image_reports){
                $image_score_arr[] = $image_reports * $score[$range_key];
            }
            $image_score = round(array_sum($image_score_arr) / $data_count, 2);
        }else{
            $image_score = 0.00;
        }

        $content_score = 0;
        $content_count = 0;
        if($data[0]->title_status == 1){
            $content_score = $content_score + $title_score;
            $content_count++;
        }
        if($data[0]->description_status == 1){
            $content_score = $content_score + $description_score;
            $content_count++;
        }
        if($data[0]->feature_status == 1){
            $content_score = $content_score + $feature_score;
            $content_count++;
        }
        if($data[0]->specification_status == 1){
            $content_score = $content_score + $specification_score;
            $content_count++;
        }
        if($data[0]->image_status == 1){
            $content_score = $content_score + $image_score;
            $content_count++;
        }

        // Over All Score Calculation
        $overall_score = $content_score / $content_count;
        $overall_score = round($overall_score, 2);

        $total_sku = array_sum($title_report);
        
        $Chart_notes = Note::where('website_id',$website_id)->get(); 
        if(blank($Chart_notes)){
            // Declare Title Notes
            if($title_report[0] > 0){
                $title_notes0 = "<li>".$title_report[0]." SKUs - High Attention Required: The character count of the title must be increased to effectively communicate vital information about these products and their usage. It will ensure they catch the eye of potential customers and provide essential information.";
            }else{
                $title_notes0 = "";
            }

            if($title_report[1] > 0){
                $title_notes1 = "<li> ".$title_report[1]." SKUs - Needs Improvement: These titles require some adjustments to their character count. It's essential to edit them to ensure they are concise, informative, and optimized to increase the CTR of potential customers.";
            }else{
                $title_notes1 = "";
            }

            if($title_report[2] > 0){
                $title_notes2 = "<li> ".$title_report[2]." SKUs - Good to Improve: These products have titles of acceptable length but must be edited for better clarity. Clear and attention-grabbing titles are crucial in effectively promoting products in this industry.";
            }else{
                $title_notes2 = "";
            }

            if($title_report[3] > 0){
                $title_notes3 = "<li> ".$title_report[3]." SKUs - Average Optimized: While these SKU titles meet the acceptable length criteria, there is an opportunity for enhancement. By highlighting key details about the product, potential buyers can be enticed to click on the product listings.";
            }else{
                $title_notes3 = "";
            }

            // Declare Description Notes
            if($description_report[0] > 0){
                $description_notes0 = "<li> ".$description_report[0]." SKUs - High Attention Required: Close attention needs to be paid to the word count in the descriptions for these specific SKUs. Ensuring that the descriptions are detailed and informative will assist potential customers in making well-informed decisions.";
            }else{
                $description_notes0 = "";
            }

            if($description_report[1] > 0){
                $description_notes1 = "<li> ".$description_report[1]." SKUs - Needs Improvement: Thoroughly reviewing and revising the word count of these specific SKUs' descriptions is essential. By doing so, potential customers can make informed decisions through the information provided.";
            }else{
                $description_notes1 = "";
            }

            if($description_report[2] > 0){
                $description_notes2 = "<li> ".$description_report[2]." SKUs - Good to Improve: Enhancing these SKUs to be more informative and ensuring all necessary details about the product are included will make them stand out to potential customers.";
            }else{
                $description_notes2 = "";
            }

            if($description_report[3] > 0){
                $description_notes3 = "<li> ".$description_report[3]." SKUs - Average Optimized: Although these SKU descriptions meet the required length, their impact can be enhanced. Cover all essential product details so that potential customers can confidently make informed decisions.";
            }else{
                $description_notes3 = "";
            }

            // Declare Feature Notes
            if($feature_report[0] > 0){
                $feature_notes0 = "<li> ".$feature_report[0]." SKUs - High Attention Required: It is crucial to add feature bullets for these SKUs. Feature bullets ensure that you present all essential information about the product to assist potential customers in making well-informed decisions.";
            }else{
                $feature_notes0 = "";
            }

            if($feature_report[1] > 0){
                $feature_notes1 = "<li> ".$feature_report[1]." SKUs - Needs Improvement: The number of feature bullets for these SKUs should be increased. This helps potential consumers make informed judgments about the product by being given complete information.";
            }else{
                $feature_notes1 = "";
            }

            if($feature_report[2] > 0){
                $feature_notes2 = "<li> ".$feature_report[2]." SKUs - Good to Improve: Although the feature bullets for these SKUs are within the range, there is room for improvement. Additional features will make your products stand out from the competition and draw in new customers.";
            }else{
                $feature_notes2 = "";
            }

            if($feature_report[3] > 0){
                $feature_notes3 = "<li> ".$feature_report[3]." SKUs - Average Optimized: The feature bullet counts for these SKUs are within the required range. However, giving prospective customers all the facts about the product can assist them in making purchasing decisions.";
            }else{
                $feature_notes3 = "";
            }

            // Declare Specification Notes
            if($specification_report[0] > 0){
                $specification_notes0 = "<li> ".$specification_report[0]." SKUs - High Attention Required: It is crucial to add specifications for these SKUs. Specifications help your customers to make informed decisions and improve customer satisfaction.";
            }else{
                $specification_notes0 = "";
            }

            if($specification_report[1] > 0){
                $specification_notes1 = "<li> ".$specification_report[1]." SKUs - Needs Improvement: These SKUs need more specifications added. When more specifications are provided, it increases the buyer's chances to buy the product and increases sales.";
            }else{
                $specification_notes1 = "";
            }

            if($specification_report[2] > 0){
                $specification_notes2 = "<li> ".$specification_report[2]." SKUs - Good to Improve: Increase specifications to be comprehensive and informative, incorporating crucial product details. This differentiation will attract potential customers and set the product apart from competitors.";
            }else{
                $specification_notes2 = "";
            }

            if($specification_report[3] > 0){
                $specification_notes3 = "<li> ".$specification_report[3]." SKUs - Average Optimized: The product specifications of these SKUs meet count criteria but can be improved for comprehensive information. This enables well-informed decisions by potential customers regarding the product.";
            }else{
                $specification_notes3 = "";
            }

            // Declare Image Notes
            if($image_report[0] > 0){
                $image_notes0 = "<li> ".$image_report[0]." SKUs - High Attention Required: It is critical to add product images for these SKUs. A visual depiction of your product is vital in online selling to ensure customers can make quick buying decisions.";
            }else{
                $image_notes0 = "";
            }

            if($image_report[1] > 0){
                $image_notes1 = "<li> ".$image_report[1]." SKUs - Needs Improvement: The image count for these SKUs needs to be increased. Additional images increase the chance of purchasing by your customers and improve their experience.";
            }else{
                $image_notes1 = "";
            }

            if($image_report[2] > 0){
                $image_notes2 = "<li> ".$image_report[2]." SKUs - Good to Improve: While there are acceptable image counts in SKUs, there is room for improvement. Prioritize high-quality images to make an impact on potential customers.";
            }else{
                $image_notes2 = "";
            }

            if($image_report[3] > 0){
                $image_notes3 = "<li> ".$image_report[3]." SKUs - Average Optimized: The image counts of these SKUs are satisfactory, but adding more images will support sales and improve your customers' impression of your e-store.";
            }else{
                $image_notes3 = "";
            }

            $title_notes            = $title_notes0.$title_notes1.$title_notes2.$title_notes3;
            $description_notes      = $description_notes0.$description_notes1.$description_notes2.$description_notes3;
            $feature_notes          = $feature_notes0.$feature_notes1.$feature_notes2.$feature_notes3;
            $specification_notes    = $specification_notes0.$specification_notes1.$specification_notes2.$specification_notes3;
            $image_notes            = $image_notes0.$image_notes1.$image_notes2.$image_notes3;
            $overall_notes          = "<li> ".$overall_score." SKU's - High Attention Required: These SKUs require the highest attention, as their overall rating is below the ideal. It is recommended to revise the title, description, features, specifications, and images in order to improve the overall rating.";
        
            Note::create([
                'website_id'            => $website_id,
                'title_notes'           => $title_notes,
                'description_notes'     => $description_notes,
                'feature_notes'         => $feature_notes,
                'specification_notes'   => $specification_notes,
                'image_notes'           => $image_notes,
                'overall_notes'         => $overall_notes,
            ]);

        }else{
            $title_notes = $Chart_notes[0]->title_notes;
            $description_notes = $Chart_notes[0]->description_notes;
            $feature_notes = $Chart_notes[0]->feature_notes;
            $specification_notes = $Chart_notes[0]->specification_notes;
            $image_notes = $Chart_notes[0]->image_notes;
            $overall_notes = $Chart_notes[0]->overall_notes;
        }
        
        return view('client.report',compact('id','title_report','description_report','feature_report',
        'specification_report','image_report','title_pres_report','description_pres_report','data',
        'feature_pres_report','specification_pres_report','image_pres_report','total_sku','price_list',
        'categories','brands','website_id','title','description','feature','specification','image',
        'req_category','req_brand','website_name','category_count','brand_count','title_score','res_value',
        'description_score','feature_score','specification_score','image_score','overall_score',
        'title_notes','description_notes','feature_notes','specification_notes','image_notes','overall_notes'));
    }

    public function view_cost(Request $request)
    {
        $website_id             = $request->website_id;
        $category               = $request->category;
        $brand                  = $request->brand;
        // dd($request);
        $website_name           = Website::where('id',$website_id)->value('website');
        $title                  = $request->title;
        $description            = $request->description;
        $feature                = $request->feature;
        $specification          = $request->specification;
        $image                  = $request->image;
        $title_prices           = ClientPrice::where('website_id',$website_id)->where('content_id',1)->get();
        $description_prices     = ClientPrice::where('website_id',$website_id)->where('content_id',2)->get();
        $feature_prices         = ClientPrice::where('website_id',$website_id)->where('content_id',3)->get();
        $specification_prices   = ClientPrice::where('website_id',$website_id)->where('content_id',4)->get();
        $image_prices           = ClientPrice::where('website_id',$website_id)->where('content_id',5)->get();
        $title_total            = [0,0,0,0,0];
        $description_total      = [0,0,0,0,0];
        $feature_total          = [0,0,0,0,0];
        $specification_total    = [0,0,0,0,0];
        $image_total            = [0,0,0,0,0];
        $req_title              = [$request->title1,$request->title2,$request->title3,$request->title4,$request->title5];
        $req_description        = [$request->description1,$request->description2,$request->description3,$request->description4,$request->description5];
        $req_feature            = [$request->feature1,$request->feature2,$request->feature3,$request->feature4,$request->feature5];
        $req_specification      = [$request->specification1,$request->specification2,$request->specification3,$request->specification4,$request->specification5];
        $req_image              = [$request->image1,$request->image2,$request->image3,$request->image4,$request->image5];
        $data                   = Website::where('id',$website_id)->get();

        // Title Calculation
        if($data[0]->title_status == 1){
            foreach($title as $key => $titles){
                if($req_title[$key] != null){
                    $total              = $title_prices[$key]->price * $titles;
                    $string             = floatval($total);
                    $total              = number_format($string, 2, '.', '');
                    $title_total[$key]  = $total;
                }
            }
        }

        // Description Calculation
        if($data[0]->description_status == 1){
            foreach($description as $key => $descriptions){
                if($req_description[$key] != null){
                    $total                      = $description_prices[$key]->price * $descriptions;
                    $string                     = floatval($total);
                    $total                      = number_format($string, 2, '.', '');
                    $description_total[$key]    = $total;
                }
            }
        }

        // Feature Calculation
        if($data[0]->feature_status == 1){
            foreach($feature as $key => $features){
                if($req_feature[$key] != null){
                    $total                  = $feature_prices[$key]->price * $features;
                    $string                 = floatval($total);
                    $total                  = number_format($string, 2, '.', '');
                    $feature_total[$key]    = $total;
                }
            }
        }

        // Specification Calculation
        if($data[0]->specification_status == 1){
            foreach($specification as $key => $specifications){
                if($req_specification[$key] != null){
                    $total                      = $specification_prices[$key]->price * $specifications;
                    $string                     = floatval($total);
                    $total                      = number_format($string, 2, '.', '');
                    $specification_total[$key]  = $total;
                }
            }
        }

        // Image Calculation
        if($data[0]->image_status == 1){
            foreach($image as $key => $images){
                if($req_image[$key] != null){
                    $total              = $image_prices[$key]->price * $images;
                    $string             = floatval($total);
                    $total              = number_format($string, 2, '.', '');
                    $image_total[$key]  = $total;
                }
            }
        }

        // Sub Total Calculation
        $score1     = $title_total[0] + $description_total[0] + $feature_total[0] + $specification_total[0] + $image_total[0];
        $string     = floatval($score1);
        $score1     = number_format($string, 2, '.', '');
        $score2     = $title_total[1] + $description_total[1] + $feature_total[1] + $specification_total[1] + $image_total[1];
        $string     = floatval($score2);
        $score2     = number_format($string, 2, '.', '');
        $score3     = $title_total[2] + $description_total[2] + $feature_total[2] + $specification_total[2] + $image_total[2];
        $string     = floatval($score3);
        $score3     = number_format($string, 2, '.', '');
        $score4     = $title_total[3] + $description_total[3] + $feature_total[3] + $specification_total[3] + $image_total[3];
        $string     = floatval($score4);
        $score4     = number_format($string, 2, '.', '');
        $score5     = $title_total[4] + $description_total[4] + $feature_total[4] + $specification_total[4] + $image_total[4];
        $string     = floatval($score5);
        $score5     = number_format($string, 2, '.', '');

        // Grand Total Calculation
        $grand_total = $score1 + $score2 + $score3 + $score4 + $score5;
        $string      = floatval($grand_total);
        $grand_total = number_format($string, 2, '.', '');

        // dd($title_total,$description_total,$feature_total,$specification_total,$image_total,$score1 , $score2 , $score3 , $score4 , $score5,$grand_total);
        return view('client.result',compact('website_id','title_total','description_total','feature_total',
        'specification_total','image_total','score1' , 'score2' , 'score3' , 'score4' , 'score5',
        'grand_total','title_prices','description_prices','feature_prices','specification_prices','image_prices',
        'title','description','feature','specification','image','req_title','req_description','req_feature','req_specification',
        'req_image','category','brand','website_name','data'));
    }

    public function client_request(Request $request)
    { 
        // dd('ok');
        $website_id     = $request->website_id;
        $client_id      = Website::where('id',$website_id)->value('client_id');
        $site_prices    = ClientPrice::where('website_id',$website_id)->get();
        $prices         = $request->price;
        $category       = $request->category;
        $brand          = $request->brand;

        $db_title           = WebsiteRange::where('website_id',$website_id)->where('content','title')->get();
        $db_description     = WebsiteRange::where('website_id',$website_id)->where('content','description')->get();
        $db_feature         = WebsiteRange::where('website_id',$website_id)->where('content','feature')->get();
        $db_specification   = WebsiteRange::where('website_id',$website_id)->where('content','specification')->get();
        $db_image           = WebsiteRange::where('website_id',$website_id)->where('content','image')->get();
        
        $title_range            = [$db_title[0]->high_attention_required,$db_title[0]->needs_improvement,$db_title[0]->good_to_improve,$db_title[0]->average_optimized,$db_title[0]->optimized];
        $description_range      = [$db_description[0]->high_attention_required,$db_description[0]->needs_improvement,$db_description[0]->good_to_improve,$db_description[0]->average_optimized,$db_description[0]->optimized];
        $feature_range          = [$db_feature[0]->high_attention_required,$db_feature[0]->needs_improvement,$db_feature[0]->good_to_improve,$db_feature[0]->average_optimized,$db_feature[0]->optimized];
        $specification_range    = [$db_specification[0]->high_attention_required,$db_specification[0]->needs_improvement,$db_specification[0]->good_to_improve,$db_specification[0]->average_optimized,$db_specification[0]->optimized];
        $image_range            = [$db_image[0]->high_attention_required,$db_image[0]->needs_improvement,$db_image[0]->good_to_improve,$db_image[0]->average_optimized,$db_image[0]->optimized];
        
        
        // Insert Data with Validation
        foreach($site_prices as $key => $site_price){
            if($prices[$key] != null){
                ClientRequirement::create([
                    'client_id'         => $client_id,
                    'website_id'        => $website_id,
                    'client_price_id'   => $prices[$key],
                ]);
            }
        }

        $title_sku1 = [];
        $title_sku2 = [];
        $title_sku3 = [];
        $title_sku4 = [];
        $title_sku5 = [];
        $description_sku1 = [];
        $description_sku2 = [];
        $description_sku3 = [];
        $description_sku4 = [];
        $description_sku5 = [];
        $feature_sku1 = [];
        $feature_sku2 = [];
        $feature_sku3 = [];
        $feature_sku4 = [];
        $feature_sku5 = [];
        $specification_sku1 = [];
        $specification_sku2 = [];
        $specification_sku3 = [];
        $specification_sku4 = [];
        $specification_sku5 = [];
        $image_sku1 = [];
        $image_sku2 = [];
        $image_sku3 = [];
        $image_sku4 = [];
        $image_sku5 = [];
        set_time_limit(180000000);
		ini_set('memory_limit', -1);
        $id = $website_id;
        $client_requirements = ClientRequirement::where('website_id',$id)->get();

        foreach($client_requirements as $client_requirement){
            $client_prices[] = ClientPrice::where('id',$client_requirement->client_price_id)->get();
        }

        foreach($client_prices as  $key => $client_price){
            // Get Title SKU's
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 1){
                // $title_sku1 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',0)->where('title_character_count','<=',40)->get();
                $title_sku1 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',0)->where('title_character_count','<=',$title_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 2){
                $title_sku2 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',++$title_range[0])->where('title_character_count','<=',$title_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 3){
                $title_sku3 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',++$title_range[1])->where('title_character_count','<=',$title_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 4){
                $title_sku4 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',++$title_range[2])->where('title_character_count','<=',$title_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 5){
                $title_sku5 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',$title_range[4])->pluck('id')->toArray();
            }

            // Get Description SKU's
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 1){
                $description_sku1 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',0)->where('description_word_count','<=',$description_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 2){
                $description_sku2 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',++$description_range[0])->where('description_word_count','<=',$description_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 3){
                $description_sku3 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',++$description_range[1])->where('description_word_count','<=',$description_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 4){
                $description_sku4 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',++$description_range[2])->where('description_word_count','<=',$description_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 5){
                $description_sku5 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',$description_range[4])->pluck('id')->toArray();
            }

            // Get Feature SKU's
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 1){
                $feature_sku1 = WebsiteData::where('website_id',$id)->where('feature_count','>=',0)->where('feature_count','<=',$feature_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 2){
                $feature_sku2 = WebsiteData::where('website_id',$id)->where('feature_count','>=',++$feature_range[0])->where('feature_count','<=',$feature_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 3){
                $feature_sku3 = WebsiteData::where('website_id',$id)->where('feature_count','>=',++$feature_range[1])->where('feature_count','<=',$feature_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 4){
                $feature_sku4 = WebsiteData::where('website_id',$id)->where('feature_count','>=',++$feature_range[2])->where('feature_count','<=',$feature_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 5){
                $feature_sku5 = WebsiteData::where('website_id',$id)->where('feature_count','>=',$feature_range[4])->pluck('id')->toArray();
            }

             // Get Specification SKU's
             if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 1){
                $specification_sku1 = WebsiteData::where('website_id',$id)->where('specification_count','>=',0)->where('specification_count','<=',$specification_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 2){
                $specification_sku2 = WebsiteData::where('website_id',$id)->where('specification_count','>=',++$specification_range[0])->where('specification_count','<=',$specification_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 3){
                $specification_sku3 = WebsiteData::where('website_id',$id)->where('specification_count','>=',++$specification_range[1])->where('specification_count','<=',$specification_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 4){
                $specification_sku4 = WebsiteData::where('website_id',$id)->where('specification_count','>=',++$specification_range[2])->where('specification_count','<=',$specification_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 5){
                $specification_sku5 = WebsiteData::where('website_id',$id)->where('specification_count','>=',$specification_range[4])->pluck('id')->toArray();
            }

            // Get Image SKU's
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 1){
                $image_sku1 = WebsiteData::where('website_id',$id)->where('image_count','>=',0)->where('image_count','<=',$image_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 2){
                $image_sku2 = WebsiteData::where('website_id',$id)->where('image_count','>=',++$image_range[0])->where('image_count','<=',$image_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 3){
                $image_sku3 = WebsiteData::where('website_id',$id)->where('image_count','>=',++$image_range[1])->where('image_count','<=',$image_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 4){
                $image_sku4 = WebsiteData::where('website_id',$id)->where('image_count','>=',++$image_range[2])->where('image_count','<=',$image_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 5){
                $image_sku5 = WebsiteData::where('website_id',$id)->where('image_count','>=',$image_range[4])->pluck('id')->toArray();
            }
        }

        $filename = uniqid().'.xlsx';
        Excel::store(new DataExport($id,$title_sku1,$title_sku2,$title_sku3,$title_sku4,$title_sku5,
        $description_sku1,$description_sku2,$description_sku3,$description_sku4,$description_sku5,
        $feature_sku1,$feature_sku2,$feature_sku3,$feature_sku4,$feature_sku5,
        $specification_sku1,$specification_sku2,$specification_sku3,$specification_sku4,$specification_sku5,
        $image_sku1,$image_sku2,$image_sku3,$image_sku4,$image_sku5,$category,$brand), 'client-requirements/'.$filename,'real_public');

        ClientRequestData::create([
            'website_id'    => $id, 
            'path'          => $filename,
        ]);

        // Add Data History
        $website = Website::with('getClient')->where('id',$website_id)->get();
        $user_id = $website[0]->getClient->getUser->id;
        $data_history = DataHistory::create([
            'user_id'       => $user_id,
            'website_id'    => $id,
            'action'        => "SKU's Submitted"
        ]);
        $client_mail = $website[0]->getClient->getUser->email;
        // $ops_email = "testing@vserve.co";
        $mailData = [
            'website'   => $website[0]->website,
        ];
        // Mail::to($client_mail)->send(new SubmitThanksEmail($mailData));
        // Mail::to($ops_email)->send(new EnhanceRequestEmail($mailData));
        Mail::to($client_mail)->send(new PaymentInitiateEmail($mailData));

        $grand_total = $request->grand_total;
        return view('client.post_payment',compact('grand_total','website_id'));
        // return redirect()->route('website_list.index')->with('success','Thank you for reaching Merch Metric for content health check!
        // Our team is working on it. You will receive an email once the result is generated.');
    }

    public function post_payment(Request $request)
    {
        
        Stripe\Stripe::setApiKey("sk_test_nlUQnIMahUX08N1ctHZhpfTp00P61z3r9G");
        $email = auth()->user()->email;
        // $plan_amount = auth()->user()->plan;
        // if($plan_amount == '$49'){
        //     $amount         = 100 * 49;
        //     $description    = '500 SKUs';
        // }else if($plan_amount == '$249'){
        //     $amount         = 100 * 249;
        //     $description    = '5000 SKUs';
        // }else if($plan_amount   = '$699'){
        //     $amount         = 100 * 699;
        //     $description    = '5000 - 20k SKUs';
        // }
        $amount         = 100 * $request->grand_total;
        $description    = 'Post Payment';
        // dd($amount);
        // Create a Customer
        $customer = Stripe\Customer::create(array(
            "address" => [
                    "line1" => $request->address,
                    "postal_code" => $request->zip_code,
                    "city" => $request->city,
                    "state" => $request->state,
                    "country" => $request->country,
                ],
            "email" => $email,
            "name" => $request->name,
            "source" => $request->stripeToken
         ));

        // dd($customer);
        // Create a charge
        $charge = Stripe\Charge::create([
            'amount' => $amount, // Amount in cents
            'currency' => 'usd',
            "customer" => $customer->id,
            // 'source' => $request->stripeToken,
            'description' => $description,
            "shipping" => [
                "name" => $request->name,
                "address" => [
                    "line1" => $request->address,
                    "postal_code" => $request->zip_code,
                    "city" => $request->city,
                    "state" => $request->state,
                    "country" => $request->country,
                ],
  
              ]
        ]);

        // Retrieve the payment ID
        $paymentId = $charge->id;
      
        // dd($paymentId);

        Website::where('id',$request->website_id)->update([
            'post_payment_status' => 1,
            'post_payment_id'     => $paymentId
        ]);

        $website = Website::where('id',$request->website_id)->get();
        $client_mail = auth()->user()->email;
        $mailData = [
            'website'   => $website[0]->website,
        ];
        Mail::to($client_mail)->send(new SubmitThanksEmail($mailData));

        return redirect()->route('website_list.index')->with('success','Thank you for reaching Merch Metric for content health check!
        Our team is working on it. You will receive an email once the result is generated.');
    }  

    public function client_result(Request $request, $id)
    {
        if(!empty($request->website_id)){
            $website_id = $request->id;
        }else{
            $website_id = Crypt::decryptString($id);
        }

        // Add Data History
        $website = Website::with('getClient')->where('id',$website_id)->get();
        $user_id = $website[0]->getClient->getUser->id;
        $data_history = DataHistory::create([
            'user_id'       => $user_id,
            'website_id'    => $website_id,
            'action'        => 'Client - Clicking on email to view enhanced data'
        ]);

        $db_title           = WebsiteRange::where('website_id',$website_id)->where('content','title')->get();
        $db_description     = WebsiteRange::where('website_id',$website_id)->where('content','description')->get();
        $db_feature         = WebsiteRange::where('website_id',$website_id)->where('content','feature')->get();
        $db_specification   = WebsiteRange::where('website_id',$website_id)->where('content','specification')->get();
        $db_image           = WebsiteRange::where('website_id',$website_id)->where('content','image')->get();
        
        $title                      = [$db_title[0]->high_attention_required,$db_title[0]->needs_improvement,$db_title[0]->good_to_improve,$db_title[0]->average_optimized,$db_title[0]->optimized];
        $description                = [$db_description[0]->high_attention_required,$db_description[0]->needs_improvement,$db_description[0]->good_to_improve,$db_description[0]->average_optimized,$db_description[0]->optimized];
        $feature                    = [$db_feature[0]->high_attention_required,$db_feature[0]->needs_improvement,$db_feature[0]->good_to_improve,$db_feature[0]->average_optimized,$db_feature[0]->optimized];
        $specification              = [$db_specification[0]->high_attention_required,$db_specification[0]->needs_improvement,$db_specification[0]->good_to_improve,$db_specification[0]->average_optimized,$db_specification[0]->optimized];
        $image                      = [$db_image[0]->high_attention_required,$db_image[0]->needs_improvement,$db_image[0]->good_to_improve,$db_image[0]->average_optimized,$db_image[0]->optimized];
        $title_report               = [0,0,0,0,0];
        $description_report         = [0,0,0,0,0];
        $feature_report             = [0,0,0,0,0];
        $specification_report       = [0,0,0,0,0];
        $image_report               = [0,0,0,0,0];
        $title_pres_report          = [0,0,0,0,0];
        $description_pres_report    = [0,0,0,0,0];
        $feature_pres_report        = [0,0,0,0,0];
        $specification_pres_report  = [0,0,0,0,0];
        $image_pres_report          = [0,0,0,0,0];
        $score                      = [1,2,3,4,5];
        // $overall_data_count         = WebsiteData::where('website_id',$website_id)->count();
        $starter                    = 0;
        $categories                 = WebsiteEnhanceData::select('category')->where('website_id',$website_id)->where('category','!=',null)->groupBy('category')->get();
        $category_count             = count($categories);
        $brands                     = WebsiteEnhanceData::select('brand')->where('website_id',$website_id)->where('brand','!=',null)->groupBy('brand')->get();        
        $brand_count                = count($brands);
        $website_name               = Website::where('id',$website_id)->value('website');
        $req_category               = '';
        $req_brand                  = '';
        $price_status               = ClientPrice::where('website_id',$website_id)->get();
        $website_datas              = Website::with('getEnhancedData')->where('id',$website_id)->get();

        if(!empty($request->category)){
            $req_category = $request->category;
        }
        if(!empty($request->brand)){
            $req_brand = $request->brand;
        }

        $query = WebsiteData::where('website_id',$website_id);
        if(!empty($request->category)){
            $query->where('category',$request->category);
        }
        if(!empty($request->brand)){
            $query->where('brand',$request->brand);
        }
        $res_value = $query->count();

        // title
        foreach($title as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $title ) - 1){
                $query->where('title_character_count','>=',$range);
            }else{
                $query->where('title_character_count','>=',$starter)->where('title_character_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $title_result                   = $query->count();
            $title_report[$range_key]       = $title_result;
            $starter                        = $range + 1;
        }
        // Title Percentage Calculation
        $data_count = array_sum($title_report);
        if($data_count != 0){
            foreach($title as $range_key => $range){
                $number                         = ( $title_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $title_pres_report[$range_key]  = $pers_result;
            }
        }
        // Title Score Calculation
        if($data_count != 0){
            foreach($title_report as $range_key => $title_reports){
                $title_score_arr[] = $title_reports * $score[$range_key];
            }
            $title_score = round(array_sum($title_score_arr) / $data_count, 2);
        }else{
            $title_score = 0.00;
        }

        // description
        $starter = 0;
        foreach($description as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $description ) - 1){
                $query->where('description_word_count','>=',$range);
            }else{
                $query->where('description_word_count','>=',$starter)->where('description_word_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $description_result = $query->count();
            $description_report[$range_key]         = $description_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($description_report);
        if($data_count != 0){
            foreach($description as $range_key => $range){
                $number                                 = ( $description_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $description_pres_report[$range_key]    = $pers_result;
            }
        }
        // Description Score Calculation
        if($data_count != 0){
            foreach($description_report as $range_key => $description_reports){
                $description_score_arr[] = $description_reports * $score[$range_key];
            }
            $description_score = round(array_sum($description_score_arr) / $data_count, 2);
        }else{
            $description_score = 0.00;
        }

        // feature
        $starter = 0;
        foreach($feature as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $feature ) - 1){
                $query->where('feature_count','>=',$range);
            }else{
                $query->where('feature_count','>=',$starter)->where('feature_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $feature_result = $query->count();
            $feature_report[$range_key]         = $feature_result;
            $starter                            = $range + 1;
        }
        $data_count = array_sum($feature_report);
        if($data_count != 0){
            foreach($feature as $range_key => $range){
                $number                             = ( $feature_report[$range_key] / $data_count ) * 100;
                $string                             = floatval($number);
                $pers_result                        = number_format($string, 2, '.', '');
                $feature_pres_report[$range_key]    = $pers_result;
            }
        }
        // Feature Score Calculation
        if($data_count != 0){
            foreach($feature_report as $range_key => $feature_reports){
                $feature_score_arr[] = $feature_reports * $score[$range_key];
            }
            $feature_score = round(array_sum($feature_score_arr) / $data_count, 2);
        }else{
            $feature_score = 0.00;
        }

        // specification
        $starter = 0;
        foreach($specification as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $specification ) - 1){
                $query->where('specification_count','>=',$range);
            }else{
                $query->where('specification_count','>=',$starter)->where('specification_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $specification_result = $query->count();
            $specification_report[$range_key]       = $specification_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($specification_report);
        if($data_count != 0){
            foreach($specification as $range_key => $range){
                $number                                 = ( $specification_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $specification_pres_report[$range_key]  = $pers_result;
            }
        }
        // Specification Score Calculation
        if($data_count != 0){
            foreach($specification_report as $range_key => $specification_reports){
                $specification_score_arr[] = $specification_reports * $score[$range_key];
            }
            $specification_score = round(array_sum($specification_score_arr) / $data_count, 2);
        }else{
            $specification_score = 0.00;
        }

        // image
        $starter = 0;
        foreach($image as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $image ) - 1){
                $query->where('image_count','>=',$range);
            }else{
                $query->where('image_count','>=',$starter)->where('image_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $image_result = $query->count();
            $image_report[$range_key]       = $image_result;
            $starter                        = $range + 1;
        }
        $data_count = array_sum($image_report);
        if($data_count != 0){
            foreach($image as $range_key => $range){
                $number                         = ( $image_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $image_pres_report[$range_key]  = $pers_result;
            }
        }
         // Image Score Calculation
        if($data_count != 0){
            foreach($image_report as $range_key => $image_reports){
                $image_score_arr[] = $image_reports * $score[$range_key];
            }
            $image_score = round(array_sum($image_score_arr) / $data_count, 2);
        }else{
            $image_score = 0.00;
        }

        // Over All Score Calculation
        $overall_score = ( $title_score + $description_score + $feature_score + $specification_score + $image_score ) / 5;
        $overall_score = round($overall_score, 2);

        $total_sku = array_sum($title_report);

        $Chart_notes = Note::where('website_id',$website_id)->where('status',1)->get();

        $title_notes = $Chart_notes[0]->title_notes;

        $description_notes = $Chart_notes[0]->description_notes;

        $feature_notes = $Chart_notes[0]->feature_notes;

        $specification_notes = $Chart_notes[0]->specification_notes;

        $image_notes = $Chart_notes[0]->image_notes;

        $overall_notes = $Chart_notes[0]->overall_notes;

        return view('client.final_result',compact('id','title_report','description_report','feature_report',
        'specification_report','image_report','title_pres_report','description_pres_report',
        'feature_pres_report','specification_pres_report','image_pres_report','total_sku','price_status',
        'categories','brands','website_id','title','description','feature','specification','image',
        'req_category','req_brand','website_name','category_count','brand_count','title_score','res_value',
        'description_score','feature_score','specification_score','image_score','overall_score','website_datas',
        'title_notes','description_notes','feature_notes','specification_notes','image_notes','overall_notes'));
    }

    public function download_sku(Request $request)
    {
        $website_id         = $request->website_id;
        $id                 = $request->website_id;
        $category           = $request->category;
        $brand              = $request->brand;
        $title_sku1         = [];
        $title_sku2         = [];
        $title_sku3         = [];
        $title_sku4         = [];
        $title_sku5         = [];
        $description_sku1   = [];
        $description_sku2   = [];
        $description_sku3   = [];
        $description_sku4   = [];
        $description_sku5   = [];
        $feature_sku1       = [];
        $feature_sku2       = [];
        $feature_sku3       = [];
        $feature_sku4       = [];
        $feature_sku5       = [];
        $specification_sku1 = [];
        $specification_sku2 = [];
        $specification_sku3 = [];
        $specification_sku4 = [];
        $specification_sku5 = [];
        $image_sku1         = [];
        $image_sku2         = [];
        $image_sku3         = [];
        $image_sku4         = [];
        $image_sku5         = [];
        set_time_limit(180000000);
		ini_set('memory_limit', -1);

        $db_title           = WebsiteRange::where('website_id',$website_id)->where('content','title')->get();
        $db_description     = WebsiteRange::where('website_id',$website_id)->where('content','description')->get();
        $db_feature         = WebsiteRange::where('website_id',$website_id)->where('content','feature')->get();
        $db_specification   = WebsiteRange::where('website_id',$website_id)->where('content','specification')->get();
        $db_image           = WebsiteRange::where('website_id',$website_id)->where('content','image')->get();
        
        $title_range            = [$db_title[0]->high_attention_required,$db_title[0]->needs_improvement,$db_title[0]->good_to_improve,$db_title[0]->average_optimized,$db_title[0]->optimized];
        $description_range      = [$db_description[0]->high_attention_required,$db_description[0]->needs_improvement,$db_description[0]->good_to_improve,$db_description[0]->average_optimized,$db_description[0]->optimized];
        $feature_range          = [$db_feature[0]->high_attention_required,$db_feature[0]->needs_improvement,$db_feature[0]->good_to_improve,$db_feature[0]->average_optimized,$db_feature[0]->optimized];
        $specification_range    = [$db_specification[0]->high_attention_required,$db_specification[0]->needs_improvement,$db_specification[0]->good_to_improve,$db_specification[0]->average_optimized,$db_specification[0]->optimized];
        $image_range            = [$db_image[0]->high_attention_required,$db_image[0]->needs_improvement,$db_image[0]->good_to_improve,$db_image[0]->average_optimized,$db_image[0]->optimized];

        // dd($title_range[0]);

        if($request->title1){
            // $title_sku1 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',0)->where('title_character_count','<=',40)->get();
            $title_sku1 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',0)->where('title_character_count','<=',$title_range[0])->pluck('id')->toArray();
        }
        if($request->title2){
            $title_sku2 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',++$title_range[0])->where('title_character_count','<=',$title_range[1])->pluck('id')->toArray();
        }
        if($request->title3){
            $title_sku3 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',++$title_range[1])->where('title_character_count','<=',$title_range[2])->pluck('id')->toArray();
        }
        if($request->title4){
            $title_sku4 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',++$title_range[2])->where('title_character_count','<=',$title_range[3])->pluck('id')->toArray();
        }
        if($request->title5){
            $title_sku5 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',$title_range[4])->pluck('id')->toArray();
        }

        // Get Description SKU's
        if($request->description1){
            $description_sku1 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',0)->where('description_word_count','<=',$description_range[0])->pluck('id')->toArray();
        }
        if($request->description2){
            $description_sku2 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',++$description_range[0])->where('description_word_count','<=',$description_range[1])->pluck('id')->toArray();
        }
        if($request->description3){
            $description_sku3 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',++$description_range[1])->where('description_word_count','<=',$description_range[2])->pluck('id')->toArray();
        }
        if($request->description4){
            $description_sku4 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',++$description_range[2])->where('description_word_count','<=',$description_range[3])->pluck('id')->toArray();
        }
        if($request->description5){
            $description_sku5 = WebsiteData::where('website_id',$id)->where('description_word_count','>=',$description_range[4])->pluck('id')->toArray();
        }

        // Get Feature SKU's
        if($request->feature1){
            $feature_sku1 = WebsiteData::where('website_id',$id)->where('feature_count','>=',0)->where('feature_count','<=',$feature_range[0])->pluck('id')->toArray();
        }
        if($request->feature2){
            $feature_sku2 = WebsiteData::where('website_id',$id)->where('feature_count','>=',++$feature_range[0])->where('feature_count','<=',$feature_range[1])->pluck('id')->toArray();
        }
        if($request->feature3){
            $feature_sku3 = WebsiteData::where('website_id',$id)->where('feature_count','>=',++$feature_range[1])->where('feature_count','<=',$feature_range[2])->pluck('id')->toArray();
        }
        if($request->feature4){
            $feature_sku4 = WebsiteData::where('website_id',$id)->where('feature_count','>=',++$feature_range[2])->where('feature_count','<=',$feature_range[3])->pluck('id')->toArray();
        }
        if($request->feature5){
            $feature_sku5 = WebsiteData::where('website_id',$id)->where('feature_count','>=',$feature_range[4])->pluck('id')->toArray();
        }

         // Get Specification SKU's
         if($request->specification1){
            $specification_sku1 = WebsiteData::where('website_id',$id)->where('specification_count','>=',0)->where('specification_count','<=',$specification_range[0])->pluck('id')->toArray();
        }
        if($request->specification2){
            $specification_sku2 = WebsiteData::where('website_id',$id)->where('specification_count','>=',++$specification_range[0])->where('specification_count','<=',$specification_range[1])->pluck('id')->toArray();
        }
        if($request->specification3){
            $specification_sku3 = WebsiteData::where('website_id',$id)->where('specification_count','>=',++$specification_range[1])->where('specification_count','<=',$specification_range[2])->pluck('id')->toArray();
        }
        if($request->specification4){
            $specification_sku4 = WebsiteData::where('website_id',$id)->where('specification_count','>=',++$specification_range[2])->where('specification_count','<=',$specification_range[3])->pluck('id')->toArray();
        }
        if($request->specification5){
            $specification_sku5 = WebsiteData::where('website_id',$id)->where('specification_count','>=',$specification_range[4])->pluck('id')->toArray();
        }

        // Get Image SKU's
        if($request->image1){
            $image_sku1 = WebsiteData::where('website_id',$id)->where('image_count','>=',0)->where('image_count','<=',$image_range[0])->pluck('id')->toArray();
        }
        if($request->image2){
            $image_sku2 = WebsiteData::where('website_id',$id)->where('image_count','>=',++$image_range[0])->where('image_count','<=',$image_range[1])->pluck('id')->toArray();
        }
        if($request->image3){
            $image_sku3 = WebsiteData::where('website_id',$id)->where('image_count','>=',++$image_range[1])->where('image_count','<=',$image_range[2])->pluck('id')->toArray();
        }
        if($request->image4){
            $image_sku4 = WebsiteData::where('website_id',$id)->where('image_count','>=',++$image_range[2])->where('image_count','<=',$image_range[3])->pluck('id')->toArray();
        }
        if($request->image5){
            $image_sku5 = WebsiteData::where('website_id',$id)->where('image_count','>=',$image_range[4])->pluck('id')->toArray();
        }
        // dd($title_sku5);

        $filename = uniqid().'.xlsx';
        return Excel::download(new DownloadSkus($id,$title_sku1,$title_sku2,$title_sku3,$title_sku4,$title_sku5,
        $description_sku1,$description_sku2,$description_sku3,$description_sku4,$description_sku5,
        $feature_sku1,$feature_sku2,$feature_sku3,$feature_sku4,$feature_sku5,
        $specification_sku1,$specification_sku2,$specification_sku3,$specification_sku4,$specification_sku5,
        $image_sku1,$image_sku2,$image_sku3,$image_sku4,$image_sku5,$category,$brand),$filename, \Maatwebsite\Excel\Excel::XLSX);
        
    }

}
