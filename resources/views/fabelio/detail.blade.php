<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>Fabelio Scraper</title>
        <style>
            @font-face 
            {
                /*I obtained from https://fabelio.com/static/version1584632702/frontend/Fabelio/aurela/id_ID/fonts/Fabelio/Regular/Fabelio-45Regular.woff*/
                font-family: Fabelio;
                src: url('{{ asset('fonts/fabelio.woff') }}');
            }

            *
            {
                outline: none;
            }

            html, body
            {
                height: 100%;
                min-height: 100%;
                font-family: Fabelio;
            }

            body
            {
                margin: 0;
                background-color: #fed541;
            }

            .tb
            {
                display: table;
                width: 100%;
            }

            .td
            {
                display: table-cell;
                vertical-align: middle;
            }

            input, button, span
            {
                color: #000;
                padding: 0;
                margin: 0;
                border: 0;
                background-color: transparent;
            }

            .center{
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
            }

            #cover
            {
                width: 850px;
                padding: 35px;
                margin: -83px auto 0 auto;
                background-color: #ffffff;
                border-radius: 20px;
                box-shadow: 0 10px 40px #a0a0a0, 0 0 0 20px #ffffffeb;
                transform: scale(0.6);
            }

            form
            {
                height: 96px;
            }

            input[type="text"]
            {
                width: 100%;
                height: 96px;
                font-size: 60px;
                line-height: 1;
            }

            input[type="text"]::placeholder
            {
                color: #000;
            }

            #s-cover
            {
                width: 1px;
                padding-left: 35px;
            }

            button
            {
                position: relative;
                display: block;
                width: 84px;
                height: 96px;
                cursor: pointer;
            }

            #s-circle
            {
                position: relative;
                top: -8px;
                left: 0;
                width: 43px;
                height: 43px;
                margin-top: 0;
                border-width: 15px;
                border: 15px solid #000;
                background-color: transparent;
                border-radius: 50%;
                transition: 0.5s ease all;
            }

            button span
            {
                position: absolute;
                top: 68px;
                left: 43px;
                display: block;
                width: 45px;
                height: 15px;
                background-color: transparent;
                border-radius: 10px;
                transform: rotateZ(52deg);
                transition: 0.5s ease all;
            }

            button span:before, button span:after
            {
                content: '';
                position: absolute;
                bottom: 0;
                right: 0;
                width: 45px;
                height: 15px;
                background-color: #000;
                border-radius: 10px;
                transform: rotateZ(0);
                transition: 0.5s ease all;
            }

            #s-cover:hover #s-circle
            {
                top: -1px;
                width: 67px;
                height: 15px;
                border-width: 0;
                background-color: #000;
                border-radius: 20px;
            }

            #s-cover:hover span
            {
                top: 50%;
                left: 56px;
                width: 25px;
                margin-top: -9px;
                transform: rotateZ(0);
            }

            #s-cover:hover button span:before
            {
                bottom: 11px;
                transform: rotateZ(52deg);
            }

            #s-cover:hover button span:after
            {
                bottom: -11px;
                transform: rotateZ(-52deg);
            }
            #s-cover:hover button span:before, #s-cover:hover button span:after
            {
                right: -6px;
                width: 40px;
                background-color: #000;
            }

            #message{
                text-align: center;
                margin-left: 40%;
                margin-right: 40%;
                margin-top: 100px;
                font-size: 30px;
            }
            
            .alert{
                color: #ff1a1a;
            }

            .container{
                width: 100%;
            }            

            #gallery{
                padding: 0;
            }

            .item{
                width: 25%;
                float: left;
                margin-bottom: 50px;
            }

            img{
                width: 100%;
            }

            section{
                margin-bottom: 50px;
                text-align: center;
            }

            section h1{
                font-size: 60px;
            }

            section h2{
                font-size: 20px;
            }

            section p{
                margin-left: 25%;
                margin-right: 25%;
            }

            #detail .price{
                font-size: 25px;
            }

            #detail .price .discount{
                text-decoration: line-through;
                color: #ff1a1a;
            }

            .tooltip {
              pointer-events: none;
              position: absolute;
              background-color: white;
              min-width: 100px;
              display: none;
              height: auto;
              text-align: center;
              color: #5B6770;
              box-shadow: 0px 3px 9px 9px rgba(0, 0, 0, .15);
              padding: 15px;
              border-radius: 10px;
            }

            

        </style>
    <script src="https://d3js.org/d3.v3.min.js"></script>
</head>

<body>
    <section>
        <div class="container">
            <section id="detail">
                <h1>{{$result['name']}}</h1>
                <p>{{$result['description']}}</p>
                <p class="price">
                    <b>
                    <span>Price</span>
                    <br>
                    @if($result['regular_price'] != $result['final_price'])
                    <span class="discount">Rp. {{number_format($result['regular_price'])}}</span>
                    <br>
                    @endif
                    <span>Rp. {{number_format($result['final_price'])}}</span>
                    </b>
                </p>
                <p>Last update {{$result['updated_at']}}</p>
            </section>
            <section id="gallery">
                @foreach($result['gallery'] as $gallery)
                <div class="item">
                    <img src="{{$gallery['image_url']}}">
                </div>
                @endforeach
            </section>
            <section id="history">
                <h2>Price History</h2>
                <div id="history">
                    <div id="chart">
                    </div>
                </div>
            </section>
        </div>
    </section>
</body>
<!-- <script type="text/javascript" src="{{asset('/js/price-history.js')}}"></script> -->
<script type="text/javascript">
    var parentDiv = document.getElementById("history");
    //define margin
    var margin = {top:20, right:80, bottom:100, left:80},
      width = parentDiv.clientWidth - margin.left - margin.right,
      height = 300 - margin.top - margin.bottom;
    //==============

    //define svg
    var svg = d3.select('#chart')
      .append('svg')
      .attr({
        "width" : width + margin.left + margin.right,
        "height" : height + margin.top + margin.bottom
      })
      .append('g')
      .attr("transform","translate("+ margin.left + ',' + margin.right + ')');
    //==============

    //define tooltip and detail box
    var tooltip = d3.select("#chart").append("div").attr("class", "tooltip");
    var detail = d3.select("#chart").append("div").attr("class", "detail");
    //==============

    //define scales
    var x_scale = d3.scale.ordinal()
      .rangeRoundBands([0, width], 0.2, 0.2);

    var y_scale = d3.scale.linear()
      .range([height, 0]);

    var x_axis = d3.svg.axis()
      .scale(x_scale)
      .orient("bottom");

    var y_axis = d3.svg.axis()
      .scale(y_scale)
      .orient("left");
    //==============

    //define color
    var color1 = d3.scale.linear()
      .domain([0, 1])
      .range(["#ffffff","#000000"]);
    //==============

    //generate chart
    d3.json("/api/products/{!! json_encode($result['id']) !!}", function(error, data){
      //read each row
      if(error) console.log("Error, file not found");
      data = data.price_history;
      data.forEach(function(d){
        console.log(d.regular_price);
        d.date = d.created_at;
        d.regular_price = +d.regular_price;
        d.final_price = +d.final_price;
        // d.total = +d.total;
      });
      //==============  

      //specify domain of x and y scale
      x_scale.domain(data.map(function(d) { return d.date; }));
      y_scale.domain([0, d3.max(data, function(d) { return d.final_price; })]);
      var max = d3.max(data, function(d) { return d.final_price; });
      //==============

      //draw the bar
      var bar = svg.selectAll('rect')
              .data(data)
              .enter()
              .append('rect')
              .attr("height","0")
              .attr("y",height);

              //transition the bar
              bar.transition().duration(3000)
              .delay(function(d,i){ return i = 200;})
              .attr({
                "x" : function(d) { return x_scale(d.date); },
                "y" : function(d) { return y_scale(d.final_price); },
                "width" : x_scale.rangeBand(),
                "height" : function(d) { return height - y_scale(d.final_price); }
              })
                .attr("fill", function(d){ return color1(d.final_price/max);})
                  .attr("id", function(d, i) {
                      return i;
                  });
              //==============

              bar.on("mouseover", function(d, i) {
                d3.select(this).attr("fill", function() {
                    return '#9c8531';
                });
                // create tooltip when hovering
                tooltip
                  .style("left", d3.event.pageX + "px")
                  .style("top", d3.event.pageY + "px")
                  .style("display", "inline-block")
                  .html(d.date + "<br>" + d.final_price)
                //==============
              })
              .on("mouseout", function(d, i) {
                  d3.select(this).attr("fill", function() {
                return color1(d.final_price/max);
                  });
                  tooltip.style("display", "none");
              });

              //draw x axis
              svg.append("g")
                .attr({
                  "class" : "x axis",
                  "transform" : "translate(0, "+ height +")",
                })
                .call(x_axis)
                .selectAll("text")
                .attr({
                  "dx" : "-1em",
                  "dy" : "1em",
                  "x" : "15px"
                })
                .style({
                  "text-anchor" : "center",
                });
      //==============
    });
    //==============

</script>

</html>