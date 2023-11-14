@extends('layouts.main')

@section('main-content')
<link rel="stylesheet" href="{{asset('client/css/style.css')}}">
<link rel="stylesheet" href="{{asset('client/css/admin_style.css')}}">
<style>
	section.ftco-section {
		background-image: url(images/register_BG-01.png);
		min-height: auto;
		background-position: center;
		background-repeat: no-repeat;
		background-size: cover;
	}
	.col-lg-4.custom-website {
	color:#ffffff;
	}
	h6.total-clss {
	color:#100f0f;
		background: #ffffff;
		width: 200px;
		height: 33px;
		padding-top: 7px;
		border-radius: 8px;
	text-align: center;
	}
	h6.urll-clss {
		color: #ffffff;
		text-align: right;
	}
	.row.custom-top {
		padding-bottom: 64px;
	}

	@media (max-width: 600px) {
		h6.urll-clss {
			text-align: center;
		}
		h6.total-clss {
		text-align: center;
		}
		h6.website-clss {
		text-align: center;
		}
		.col-lg-4.custom-total {
		margin-left: 130px;
		}

	}
</style>

    <!-- ======= Header ======= -->
    <div class="container">
		<div class="row">
		    <div class="col-lg-4"></div>
			<div class="col-lg-4">
			    <a href="#" class="logo me-auto"><img src="{{asset('client/images/logo.png')}}" alt="" class="img"></a>
			</div>
			<div class="col-lg-4"></div>
		</div>
    </div>
 <!-- ======= Header ======= -->
<section class="ftco-section">
    <div class="container">
        <!-- Filter Section -->
        <div class="row">
            <form action="{{route('client',$website_id)}}" method="get">
                @csrf
                @method('GET')
                <input type="hidden" value="{{$website_id}}" name="website_id">
                <input type="hidden" value="{{$title[0]}}" name="title[]">
                <input type="hidden" value="{{$title[1]}}" name="title[]">
                <input type="hidden" value="{{$title[2]}}" name="title[]">
                <input type="hidden" value="{{$title[3]}}" name="title[]">
                <input type="hidden" value="{{$title[4]}}" name="title[]">

                <input type="hidden" value="{{$feature[0]}}" name="feature[]">
                <input type="hidden" value="{{$feature[1]}}" name="feature[]">
                <input type="hidden" value="{{$feature[2]}}" name="feature[]">
                <input type="hidden" value="{{$feature[3]}}" name="feature[]">
                <input type="hidden" value="{{$feature[4]}}" name="feature[]">

                <input type="hidden" value="{{$description[0]}}" name="description[]">
                <input type="hidden" value="{{$description[1]}}" name="description[]">
                <input type="hidden" value="{{$description[2]}}" name="description[]">
                <input type="hidden" value="{{$description[3]}}" name="description[]">
                <input type="hidden" value="{{$description[4]}}" name="description[]">

                <input type="hidden" value="{{$specification[0]}}" name="specification[]">
                <input type="hidden" value="{{$specification[1]}}" name="specification[]">
                <input type="hidden" value="{{$specification[2]}}" name="specification[]">
                <input type="hidden" value="{{$specification[3]}}" name="specification[]">
                <input type="hidden" value="{{$specification[4]}}" name="specification[]">

                <input type="hidden" value="{{$image[0]}}" name="image[]">
                <input type="hidden" value="{{$image[1]}}" name="image[]">
                <input type="hidden" value="{{$image[2]}}" name="image[]">
                <input type="hidden" value="{{$image[3]}}" name="image[]">
                <input type="hidden" value="{{$image[4]}}" name="image[]">
                
                <div class="row">
                    <div class="col-md-6">
                        <label for=""><strong>Select Category</strong></label>
                        <select name="category" id="category">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->category}}" {{$category->category== $req_category ? 'selected' : ''}}>{{substr($category->category, strrpos($category->category, '>') + 1)}}</option>
                            @endforeach
                        </select>
                        <div style="margin-left:25%;">
                            <span>Category Count: {{$category_count}}</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for=""><strong>Select brand</strong></label>
                        <select name="brand" id="brand">
                            <option value="">Select brand</option>
                            @foreach($brands as $brand)
                                <option value="{{$brand->brand}}" {{$brand->brand == $req_brand ? 'selected' : ''}}>{{$brand->brand}}</option>
                            @endforeach
                        </select>
                        <div style="margin-left:25%;">
                            <span>Brand Count: {{$brand_count}}</span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <input type="submit">
                    </div>
                </div>
            </form>
        </div>
        <form action="{{route('client.view_cost')}}" method="post">
            @csrf
            <input type="hidden" value="{{$website_id}}" name="website_id">
            <input type="hidden" value="{{$req_category}}" name="category">
            <input type="hidden" value="{{$req_brand}}" name="brand">
            <input type="hidden" name="title[]" value="{{$title_report[0]}}">
            <input type="hidden" name="title[]" value="{{$title_report[1]}}">
            <input type="hidden" name="title[]" value="{{$title_report[2]}}">
            <input type="hidden" name="title[]" value="{{$title_report[3]}}">
            <input type="hidden" name="title[]" value="{{$title_report[4]}}">
            <input type="hidden" name="description[]" value="{{$description_report[0]}}">
            <input type="hidden" name="description[]" value="{{$description_report[1]}}">
            <input type="hidden" name="description[]" value="{{$description_report[2]}}">
            <input type="hidden" name="description[]" value="{{$description_report[3]}}">
            <input type="hidden" name="description[]" value="{{$description_report[4]}}">
            <input type="hidden" name="feature[]" value="{{$feature_report[0]}}">
            <input type="hidden" name="feature[]" value="{{$feature_report[1]}}">
            <input type="hidden" name="feature[]" value="{{$feature_report[2]}}">
            <input type="hidden" name="feature[]" value="{{$feature_report[3]}}">
            <input type="hidden" name="feature[]" value="{{$feature_report[4]}}">
            <input type="hidden" name="specification[]" value="{{$specification_report[0]}}">
            <input type="hidden" name="specification[]" value="{{$specification_report[1]}}">
            <input type="hidden" name="specification[]" value="{{$specification_report[2]}}">
            <input type="hidden" name="specification[]" value="{{$specification_report[3]}}">
            <input type="hidden" name="specification[]" value="{{$specification_report[4]}}">
            <input type="hidden" name="image[]" value="{{$image_report[0]}}">
            <input type="hidden" name="image[]" value="{{$image_report[1]}}">
            <input type="hidden" name="image[]" value="{{$image_report[2]}}">
            <input type="hidden" name="image[]" value="{{$image_report[3]}}">
            <input type="hidden" name="image[]" value="{{$image_report[4]}}">
            <!-- Sku Details -->
            <div class="row custom-top">
                <div class="col-lg-4 custom-website">
                <h6 class="website-clss" >Company:{{$website_name}}</h6>
                </div>
                <div class="col-lg-4 custom-total">
                <h6 class="total-clss">Total SKU:{{$total_sku}}</h6>
                </div>
                <div class="col-lg-4 custom-url">
                <h6 class="urll-clss">Website URL: {{$website_name}}</h6>
                </div>
            </div>
            <div class="row pos-relative">
                <div class="left-image">
                    <img src="{{asset('client/images/Reports_Bot-01.png')}}" alt="SKUBOT">
                </div>
                <div class="col-sm-12 register-custom-css">
                    <div class="divTable-custom-top">
                        <div class="divTableBody-cusst-cs">
                            <!-- Ranges -->
                            <div class="divTableRow-cust-top">
                                <div class="divTableCell customskana">
                                    <div class="innerWrap">SKU Analysis</div>
                                </div>
                                <div class="divTableCell c1 customhigred"><div class="innerWrap">High attention required<br>1</div></div>
                                <div class="divTableCell c2 customneedimp" ><div class="innerWrap">Needs Improvement<br>2</div></div>
                                <div class="divTableCell c3 customgoodimp" ><div class="innerWrap">Good To Improve<br>3</div></div>
                                <div class="divTableCell c4 customavgopt"><div class="innerWrap">Average Optimized<br>4</div></div>
                                <div class="divTableCell c5 customoptt" ><div class="innerWrap">Optimized<br>5</div></div>
                            </div>
                            <!-- Title -->
                            <div class="divTableRow-cust-top detailsRow">
                                <div class="divTableCell" style="vertical-align: middle;background-color:#5ea3da;">Title Characters</div>
                                <div class="divTableCell c1" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#fa6992;">0 - 40
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="title1" value="{{$price_list[0]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$title_pres_report[0]}}% <br>{{$title_report[0]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c2" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#f2854d;">41 - 60
                                <div class="checkbox">
                                        <input type="checkbox" id="" name="title2" value="{{$price_list[1]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$title_pres_report[1]}}% <br>{{$title_report[1]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c3" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#d7c25d;">61 - 70 
                                    <div class="checkbox">
                                        <input type="checkbox" id="test" name="title3" value="{{$price_list[2]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$title_pres_report[2]}}% <br>{{$title_report[2]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c4" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#4ab06e;">71 - 90 
                                    <div class="checkbox">
                                        <input type="checkbox" id="test" name="title4" value="{{$price_list[3]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$title_pres_report[3]}}% <br>{{$title_report[3]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c5" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#00c028;">80+ 
                                    <div class="checkbox">
                                        <input type="checkbox" id="test" name="title5" value="{{$price_list[4]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$title_pres_report[4]}}% <br>{{$title_report[4]}} SKUs
                                    </div>
                                </div>
                            </div>
                            <!-- Descriptions -->
                            <div class="divTableRow-cust-top detailsRow">
                                <div class="divTableCell" style="vertical-align: middle;background-color:#9ebee5;">Description Words</div>
                                <div class="divTableCell c1" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#fa6992;">0 - 30
                                    <div class="checkbox">
                                        <input type="checkbox" id="test" name="description1" value="{{$price_list[5]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$description_pres_report[0]}}% <br>{{$description_report[0]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c2" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#f2854d;">31 - 60
                                <div class="checkbox">
                                        <input type="checkbox" id="test" name="description2" value="{{$price_list[6]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$description_pres_report[1]}}% <br>{{$description_report[1]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c3" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#d7c25d;">61 - 80 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="description3" value="{{$price_list[7]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$description_pres_report[2]}}% <br>{{$description_report[2]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c4" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#4ab06e;">81 - 100 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="description4" value="{{$price_list[8]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$description_pres_report[3]}}% <br>{{$description_report[3]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c5" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#00c028;">101+ 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="description[]" value="{{$description_report[4]}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$description_pres_report[4]}}% <br>{{$description_report[4]}} SKUs
                                    </div>
                                </div>
                            </div>
                            <!-- Feature -->
                            <div class="divTableRow-cust-top detailsRow">
                                <div class="divTableCell" style="vertical-align: middle;background-color:#7b89d2;">Feature Bullets Count</div>
                                <div class="divTableCell c1" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#fa6992;">0 - 0
                                    <div class="checkbox">
                                        <input type="checkbox" id="test" name="feature1" value="{{$price_list[10]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$feature_pres_report[0]}}% <br>{{$feature_report[0]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c2" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#f2854d;">1 - 2
                                <div class="checkbox">
                                        <input type="checkbox" id="" name="feature2" value="{{$price_list[11]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$feature_pres_report[1]}}% <br>{{$feature_report[1]}} SKUs
                                    </div>
                                </div>
                                <div class="divTableCell c3" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#d7c25d;">3 - 3 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="feature3" value="{{$price_list[12]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$feature_pres_report[2]}}%<br>{{$feature_report[2]}} SKUs
                                    </div>
                                    
                                </div>
                                <div class="divTableCell c4" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#4ab06e;">4 - 4 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="feature4" value="{{$price_list[13]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$feature_pres_report[3]}}% <br>{{$feature_report[3]}} SKUs
                                    </div>
                                    
                                </div>
                                <div class="divTableCell c5" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#00c028;">5+ 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="feature5" value="{{$price_list[14]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$feature_pres_report[4]}}% <br>{{$feature_report[4]}} SKUs
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- Specifications -->
                            <div class="divTableRow-cust-top detailsRow">
                                <div class="divTableCell" style="vertical-align: middle;background-color:#86a8dd;">Prod Specifications Count</div>
                                <div class="divTableCell c1" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#fa6992;">0 - 2
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="specification1" value="{{$price_list[15]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$specification_pres_report[0]}}% <br>{{$specification_report[0]}} SKUs
                                    </div>
                                    
                                </div>
                                <div class="divTableCell c2" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#f2854d;">2 - 2
                                        <div class="checkbox">
                                            <input type="checkbox" id="" name="specification2" value="{{$price_list[16]->id}}">
                                        </div>
                                        <div class="sku-clss">
                                        {{$specification_pres_report[1]}}% <br>{{$specification_report[1]}} SKUs
                                        </div>
                                        
                                </div>
                                <div class="divTableCell c3" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#d7c25d;">3 - 3 
                                    <div class="checkbox">
                                        <input type="checkbox" id="test" name="specification3" value="{{$price_list[17]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$specification_pres_report[2]}}% <br>{{$specification_report[2]}} SKUs
                                    </div>
                                    
                                </div>
                                <div class="divTableCell c4" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#4ab06e;">4 - 4 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="specification4" value="{{$price_list[18]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$specification_pres_report[3]}}% <br>{{$specification_report[3]}} SKUs
                                    </div>
                                    
                                </div>
                                <div class="divTableCell c5" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#00c028;">5+ 
                                    <div class="checkbox">
                                        <input type="checkbox" id="test" name="specification5" value="{{$price_list[19]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$specification_pres_report[4]}}% <br>{{$specification_report[4]}} SKUs
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- Image -->
                            <div class="divTableRow-cust-top detailsRow bottomCell">
                                <div class="divTableCell" style="vertical-align: middle;background-color:#b056c5;">Images Count
                                </div>
                                <div class="divTableCell c1" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#fa6992;">0 - 2
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="image1" value="{{$price_list[20]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$image_pres_report[0]}}% <br>{{$image_report[0]}} SKUs
                                    </div>
                                    
                                    
                                </div>
                                <div class="divTableCell c2" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#f2854d;">2 - 2
                                <div class="checkbox">
                                        <input type="checkbox" id="" name="image2" value="{{$price_list[21]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$image_pres_report[1]}}% <br>{{$image_report[1]}} SKUs
                                    </div>
                                    
                                    
                                </div>
                                <div class="divTableCell c3" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#d7c25d;">3 - 3 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="image3" value="{{$price_list[22]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$image_pres_report[2]}}% <br>{{$image_report[2]}} SKUs
                                    </div>
                                    
                                    
                                </div>
                                <div class="divTableCell c4" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#4ab06e;">4 - 4 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="image4" value="{{$price_list[23]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$image_pres_report[3]}}% <br>{{$image_report[3]}} SKUs
                                    </div>
                                    
                                    
                                </div>
                                <div class="divTableCell c5" style="color:#ffffff;font-size: 16px;font-weight: 600;background-color:#00c028;">5+ 
                                    <div class="checkbox">
                                        <input type="checkbox" id="" name="image5" value="{{$price_list[24]->id}}">
                                    </div>
                                    <div class="sku-clss">
                                    {{$image_pres_report[4]}}% <br>{{$image_report[4]}} SKUs
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <div class="divTableRow-cust-top detailsRow last">
                                <div class="divTableCell">
                                    <div class="cellfooter"><span>Test</span></div>
                                </div>
                                <div class="divTableCell c1">
                                    <div class="cellfooter"><span>Test</span></div>
                                </div>
                                <div class="divTableCell c2">
                                    <div class="cellfooter"><span>Test</span></div>
                                </div>
                                <div class="divTableCell c3">
                                    <div class="cellfooter"><span>Test</span></div>
                                </div>
                                <div class="divTableCell c4">
                                    <div class="cellfooter"><span>Test</span></div>
                                </div>
                                <div class="divTableCell c5">
                                    <div class="cellfooter"><span>Test</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- chart -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4" style="text-align: center;">
                        <div id="overall" style="height: 300px; width: 100%;" class="donutDiv"></div>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="text-align: center;">
                        <div id="titles" class="donutDiv"></div>
                        </div>
                        <div class="col-md-6" style="text-align: center;">
                        <div id="descriptions" class="donutDiv"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="text-align: center;">
                        <div id="feature" class="donutDiv"></div>
                        </div>
                        <div class="col-md-6" style="text-align: center;">
                        <div id="specifications" class="donutDiv"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6" style="text-align: center;">
                        <div id="img" class="donutDiv"></div>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" value="Click here to Enhance your Data" class="btn btn-info">
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{asset('AppAssets/plugins/chart.js/Chart.min.js')}}"></script>
    <script src='https://cdn.plot.ly/plotly-2.16.1.min.js'></script> 
    <script>
        var data = [
                        {
                            domain: { x: [0, 1], y: [0, 1] },
                            value: "{{number_format($overall_score,2)}}",
                            title: { text: "OverAll Score" },
                            type: "indicator",
                            mode: "gauge+number",
                            delta: { relative: false },
                            gauge: {
                            bar: { color: "orange" },
                            bgcolor: "grey",
                            }
                        }
                    ];

        var layout = {  margin: { t: 25, b: 25, l: 25, r: 25 }};
        Plotly.newPlot('overall', data, layout);

        function centerText(chart, idx, X, Y) {
            var cht = document.querySelector(chart);
            var txt = document.querySelectorAll(chart + " text");
            txt[idx].setAttribute('x', X);
            txt[idx].setAttribute('y', Y);
        }
        @if(!isset($nodata))
        // Title Chart
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(titles);


        function titles()
        {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Category');
            data.addColumn('number', 'Titles characters product count');
            data.addColumn({type: 'string', role: 'style'});
            data.addColumn({type: 'string', role: 'annotation'});
    
            data.addRows([
                ['0 - {{$title[0]}} Characters', {{$title_report[0]}} , 'color: red',  "{{$title_pres_report[0]}}%"],
                ['{{++$title[0]}} - {{$title[1]}} Characters',  {{$title_report[1]}}, 'color: orange', "{{$title_pres_report[1]}}%"],
                ['{{++$title[1]}} - {{$title[2]}} Characters',  {{$title_report[2]}}, 'color: #FFDD33', "{{$title_pres_report[2]}}%"],
                ['{{++$title[2]}} - {{$title[3]}} Characters',  {{$title_report[3]}}, 'color: #82E0AA', "{{$title_pres_report[3]}}%"],
                ['{{$title[3]}}+ Characters',  {{$title_report[4]}}, 'color: green', "{{$title_pres_report[4]}}%"],
            ]);
            
    
            var piechart_options = 
            {      
                title:'Title Score \n {{$title_score}}',
                pieHole: 0.6,
                width: '2000px',
                height: '2000px',
                legend: {
                        position: 'none'
                    },
                    colors: ['red', 'orange', '#FFDD33', '#82E0AA', 'green'],
                    titleTextStyle: {
                    fontSize: 12,
                    bold: true,
                    },
            };
            var piechart = new google.visualization.PieChart(document.getElementById('titles'));
            google.visualization.events.addListener(piechart, 'ready', function () {
            // get label copy to change
            var labelContent = piechart_options.title.split('\n');

            // get chart labels
            var labels = piechart.getContainer().getElementsByTagName('text');

            // loop chart title lines, beginning with second line
            for (var l = 1; l < labelContent.length; l++) {
                // find chart label
                for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent === labelContent[l]) {
                    // reduce font size
                    var currentFontSize = parseInt(labels[i].getAttribute('font-size'));
                    labels[i].setAttribute('font-size', currentFontSize + 4);
                    var currentFontColor = labels[i].getAttribute('fill');
                    labels[i].setAttribute('fill', 'red');
                    break;
                }
                }
            }
            });
            piechart.draw(data, piechart_options);
            centerText('#titles', 0, 185, 210);
            centerText('#titles', 1, 200, 230);
        }
  
        // Description Chart
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(descriptions);
        function descriptions()
        {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('number', 'Descriptions prodcut count');
            data.addColumn({type: 'string', role: 'style'});
            data.addColumn({type: 'string', role: 'annotation'});
            data.addRows([
                ['0 - {{$description[0]}} Words', {{$description_report[0]}} , 'color: red',  "{{$description_pres_report[0]}}%"],
                ['{{++$description[0]}} - {{$description[1]}} Words',  {{$description_report[1]}}, 'color: orange', "{{$description_pres_report[1]}}%"],
                ['{{++$description[1]}} - {{$description[2]}} Words',  {{$description_report[2]}}, 'color: #FFDD33', "{{$description_pres_report[2]}}%"],
                ['{{++$description[2]}} - {{$description[3]}} Words',  {{$description_report[3]}}, 'color: #82E0AA', "{{$description_pres_report[3]}}%"],
                ['{{$description[3]}}+ Words',  {{$description_report[4]}}, 'color: green', "{{$description_pres_report[4]}}%"],
            ]);
    
            var piechart_options = {
                                        title:'Description Score\n{{ $description_score }}',
                                        pieHole: 0.6,
                                        //  width:300,
                                        //  height:400,
                                        width: '100%',
                                        height: '500px',
                                        legend: {
                                            position: 'none'
                                        },
                                        colors: ['red', 'orange', '#FFDD33', '#82E0AA', 'green'],
                                        titleTextStyle: {
                                        fontSize: 12,
                                        bold: true,
                                        }
                                    };
            var piechart = new google.visualization.PieChart(document.getElementById('descriptions'));
            google.visualization.events.addListener(piechart, 'ready', function () {
            // get label copy to change
            var labelContent = piechart_options.title.split('\n');

            // get chart labels
            var labels = piechart.getContainer().getElementsByTagName('text');

            // loop chart title lines, beginning with second line
            for (var l = 1; l < labelContent.length; l++) {
                // find chart label
                for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent === labelContent[l]) {
                    // reduce font size
                    var currentFontSize = parseInt(labels[i].getAttribute('font-size'));
                    labels[i].setAttribute('font-size', currentFontSize + 4);
                    var currentFontColor = labels[i].getAttribute('fill');
                    labels[i].setAttribute('fill', 'orange');
                    break;
                }
                }
            }
            });
            piechart.draw(data, piechart_options);
            centerText('#descriptions', 0, 160, 210);
            centerText('#descriptions', 1, 200, 230);
        }

        // Feature Chart
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(feature);
        function feature()
        {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('number', 'Feature Bullet count');
            data.addColumn({type: 'string', role: 'style'});
            data.addColumn({type: 'string', role: 'annotation'});
            data.addRows([
                ['0 - {{$feature[0]}} Count', {{$feature_report[0]}} , 'color: red',  "{{$feature_pres_report[0]}}%"],
                ['{{++$feature[0]}} - {{$feature[1]}} Count',  {{$feature_report[1]}}, 'color: orange', "{{$feature_pres_report[1]}}%"],
                ['{{++$feature[1]}} - {{$feature[2]}} Count',  {{$feature_report[2]}}, 'color: #FFDD33', "{{$feature_pres_report[2]}}%"],
                ['{{++$feature[2]}} - {{$feature[3]}} Count',  {{$feature_report[3]}}, 'color: #82E0AA', "{{$feature_pres_report[3]}}%"],
                ['{{$feature[3]}}+ Count',  {{$feature_report[4]}}, 'color: green', "{{$feature_pres_report[4]}}%"],
            ]);
            
        
            var piechart_options = {
                    title:'Feature Score\n{{ $feature_score }}',
                    pieHole: 0.6,
                    //  width:300,
                    //  height:400,
                        width: '100%',
                        height: '500px',
                    legend: {
                            position: 'none'
                        },
                        colors: ['red', 'orange', '#FFDD33', '#82E0AA', 'green'],
                        titleTextStyle: {
                        fontSize: 12,
                        bold: true,
                        }
                    };
            var piechart = new google.visualization.PieChart(document.getElementById('feature'));
            google.visualization.events.addListener(piechart, 'ready', function () {
            // get label copy to change
            var labelContent = piechart_options.title.split('\n');

            // get chart labels
            var labels = piechart.getContainer().getElementsByTagName('text');

            // loop chart title lines, beginning with second line
            for (var l = 1; l < labelContent.length; l++) {
                // find chart label
                for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent === labelContent[l]) {
                    // reduce font size
                    var currentFontSize = parseInt(labels[i].getAttribute('font-size'));
                    labels[i].setAttribute('font-size', currentFontSize + 4);
                    var currentFontColor = labels[i].getAttribute('fill');
                    labels[i].setAttribute('fill', '#f3d127');
                    break;
                }
                }
            }
            });
            piechart.draw(data, piechart_options);
            centerText('#feature', 0, 170, 210);
            centerText('#feature', 1, 190, 230);
        }

        // Specifications Chart
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(specifications);
        function specifications()
        {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('number', 'Prod Specifications count');
            data.addColumn({type: 'string', role: 'style'});
            data.addColumn({type: 'string', role: 'annotation'});
            data.addRows([
                ['0 - {{$specification[0]}} Count', {{$specification_report[0]}} , 'color: red',  "{{$specification_pres_report[0]}}%"],
                ['{{++$specification[0]}} - {{$specification[1]}} Count',  {{$specification_report[1]}}, 'color: orange', "{{$specification_pres_report[1]}}%"],
                ['{{++$specification[1]}} - {{$specification[2]}} Count',  {{$specification_report[2]}}, 'color: #FFDD33', "{{$specification_pres_report[2]}}%"],
                ['{{++$specification[2]}} - {{$specification[3]}} Count',  {{$specification_report[3]}}, 'color: #82E0AA', "{{$specification_pres_report[3]}}%"],
                ['{{$specification[3]}}+ Count',  {{$specification_report[4]}}, 'color: green', "{{$specification_pres_report[4]}}%"],
            ]);
            
        
            var piechart_options = {
                    title:'Specifications Score\n{{ $specification_score }}',
                    pieHole: 0.6,
                    //  width:300,
                    //  height:400,
                        width: '100%',
                        height: '500px',
                    legend: {
                            position: 'none'
                        },
                        colors: ['red', 'orange', '#FFDD33', '#82E0AA', 'green'],
                        titleTextStyle: {
                        fontSize: 12,
                        bold: true,
                        }
                    };
            var piechart = new google.visualization.PieChart(document.getElementById('specifications'));
            google.visualization.events.addListener(piechart, 'ready', function () {
            // get label copy to change
            var labelContent = piechart_options.title.split('\n');

            // get chart labels
            var labels = piechart.getContainer().getElementsByTagName('text');

            // loop chart title lines, beginning with second line
            for (var l = 1; l < labelContent.length; l++) {
                // find chart label
                for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent === labelContent[l]) {
                    // reduce font size
                    var currentFontSize = parseInt(labels[i].getAttribute('font-size'));
                    labels[i].setAttribute('font-size', currentFontSize + 4);
                    var currentFontColor = labels[i].getAttribute('fill');
                    labels[i].setAttribute('fill', '#82e0aa');
                    break;
                }
                }
            }
            });
            piechart.draw(data, piechart_options);
            centerText('#specifications', 0, 150, 210);
            centerText('#specifications', 1, 200, 230);
        }

        // Image Chart
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(image);
        function image()
        {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('number', 'Image prodcut count');
            data.addColumn({type: 'string', role: 'style'});
            data.addColumn({type: 'string', role: 'annotation'});
            data.addRows([
                ['0 - {{$image[0]}} Count', {{$image_report[0]}} , 'color: red',  "{{$image_pres_report[0]}}%"],
                ['{{++$image[0]}} - {{$image[1]}} Count',  {{$image_report[1]}}, 'color: orange', "{{$image_pres_report[1]}}%"],
                ['{{++$image[1]}} - {{$image[2]}} Count',  {{$image_report[2]}}, 'color: #FFDD33', "{{$image_pres_report[2]}}%"],
                ['{{++$image[2]}} - {{$image[3]}} Count',  {{$image_report[3]}}, 'color: #82E0AA', "{{$image_pres_report[3]}}%"],
                ['{{$image[3]}}+ Count',  {{$image_report[4]}}, 'color: green', "{{$image_pres_report[4]}}%"],
            ]);
            
        
            var piechart_options = {
            title:'Image Score\n{{ $image_score }}',
            pieHole: 0.6,
            //  width:300,
            //  height:400,
            width: '100%',
            height: '500px',
            legend: {
                position: 'none'
            },
            colors: ['red', 'orange', '#FFDD33', '#82E0AA', 'green'],
            titleTextStyle: {
                fontSize: 12,
                bold: true,
            }
            };
            var piechart = new google.visualization.PieChart(document.getElementById('img'));
            google.visualization.events.addListener(piechart, 'ready', function () {
            // get label copy to change
            var labelContent = piechart_options.title.split('\n');

            // get chart labels
            var labels = piechart.getContainer().getElementsByTagName('text');

            // loop chart title lines, beginning with second line
            for (var l = 1; l < labelContent.length; l++) {
                // find chart label
                for (var i = 0; i < labels.length; i++) {
                if (labels[i].textContent === labelContent[l]) {
                    // reduce font size
                    var currentFontSize = parseInt(labels[i].getAttribute('font-size'));
                    labels[i].setAttribute('font-size', currentFontSize + 4);
                    var currentFontColor = labels[i].getAttribute('fill');
                    labels[i].setAttribute('fill', 'green');
                    break;
                }
                }
            }
            });
            piechart.draw(data, piechart_options);
            centerText('#img', 0, 180, 210);
            centerText('#img', 1, 200, 230);
        }
        @endif
    </script>
@endsection