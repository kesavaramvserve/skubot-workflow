@extends('layouts.main')

@section('main-content')
    <div class="">
        <div class="content-wrapper">
            <form action="{{route('enhance_result',$website_id)}}" method="get">
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <span>Client Wbsite: {{$website_name}}</span>
                    </div>
                    <div class="col-md-6">
                        @if(auth()->user()->getRole->name == 'Reviewer')
                            <a href="{{ route('website.index') }}" class="btn btn-primary" style="margin-left: 50%;">Back</a>
                            <a href="{{route('send_enhance_mail',$website_id)}}" class="btn btn-info" >Send Mail</a>
                        @elseif(auth()->user()->getRole->name == 'Support')
                            <a href="{{ route('website.index') }}" class="btn btn-primary" style="margin-left: 80%;">Back</a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Select Category</label>
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
                        <label for="">Select brand</label>
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
            @if($res_value != 0)
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Total SKU: {{$total_sku}}</h1>
                </div>
            </div>
            <div class="row">
                <table  class="table table-striped">
                    <thead>
                        <tr>
                            <th>SKU Analysis</th>
                            <th>High attention required</th>
                            <th>Needs Improvement</th>
                            <th>Good To Improve</th>
                            <th>Average Optimized</th>
                            <th>Optimized</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Title Characters</td>
                            <td>{{$title_report[0]}} SKUs <br> ({{$title_pres_report[0]}}%)</td>
                            <td>{{$title_report[1]}} SKUs <br> ({{$title_pres_report[1]}}%)</td>
                            <td>{{$title_report[2]}} SKUs <br> ({{$title_pres_report[2]}}%)</td>
                            <td>{{$title_report[3]}} SKUs <br> ({{$title_pres_report[3]}}%)</td>
                            <td>{{$title_report[4]}} SKUs <br> ({{$title_pres_report[4]}}%)</td>
                        </tr>
                        <tr>
                            <td>Description Words</td>
                            <td>{{$description_report[0]}} SKUs <br> ({{$description_pres_report[0]}}%)</td>
                            <td>{{$description_report[1]}} SKUs <br> ({{$description_pres_report[1]}}%)</td>
                            <td>{{$description_report[2]}} SKUs <br> ({{$description_pres_report[2]}}%)</td>
                            <td>{{$description_report[3]}} SKUs <br> ({{$description_pres_report[3]}}%)</td>
                            <td>{{$description_report[4]}} SKUs <br> ({{$description_pres_report[4]}}%)</td>
                        </tr>
                        <tr>
                            <td>Feature Bullets Count</td>
                            <td>{{$feature_report[0]}} SKUs <br> ({{$feature_pres_report[0]}}%)</td>
                            <td>{{$feature_report[1]}} SKUs <br> ({{$feature_pres_report[1]}}%)</td>
                            <td>{{$feature_report[2]}} SKUs <br> ({{$feature_pres_report[2]}}%)</td>
                            <td>{{$feature_report[3]}} SKUs <br> ({{$feature_pres_report[3]}}%)</td>
                            <td>{{$feature_report[4]}} SKUs <br> ({{$feature_pres_report[4]}}%)</td>
                        </tr>
                        <tr>
                            <td>Prod Specifications Count</td>
                            <td>{{$specification_report[0]}} SKUs <br> ({{$specification_pres_report[0]}}%)</td>
                            <td>{{$specification_report[1]}} SKUs <br> ({{$specification_pres_report[1]}}%)</td>
                            <td>{{$specification_report[2]}} SKUs <br> ({{$specification_pres_report[2]}}%)</td>
                            <td>{{$specification_report[3]}} SKUs <br> ({{$specification_pres_report[3]}}%)</td>
                            <td>{{$specification_report[4]}} SKUs <br> ({{$specification_pres_report[4]}}%)</td>
                        </tr>
                        <tr>
                            <td>Images Count</td>
                            <td>{{$image_report[0]}} SKUs <br> ({{$image_pres_report[0]}}%)</td>
                            <td>{{$image_report[1]}} SKUs <br> ({{$image_pres_report[1]}}%)</td>
                            <td>{{$image_report[2]}} SKUs <br> ({{$image_pres_report[2]}}%)</td>
                            <td>{{$image_report[3]}} SKUs <br> ({{$image_pres_report[3]}}%)</td>
                            <td>{{$image_report[4]}} SKUs <br> ({{$image_pres_report[4]}}%)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Chart -->
            <div class="card">
                <div class="card-body">
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
                </div>
            </div>
            <!-- End Chart -->
            @else
            <div class="row mt-5 text-center">
                <h3>No data Found</h3>
            </div>
            @endif
        </div>
    </div>
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