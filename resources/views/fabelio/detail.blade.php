<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>Fabelio Scraper</title>
    <link href="css/main.css" rel="stylesheet">
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
    <section id="button">
      <p><a href="/">Submit New Product</a></p>
      <p><a href="/products">List All Products</a></p>
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