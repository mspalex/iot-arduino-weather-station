<?php

    include("includes/daily_data.php");

?>

<!DOCTYPE>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Daily weather</title>
        <script src="js/d3.v3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>

        <div id="head">
            <h1>Daily weather</h1>
            <?php include("includes/nav.php") ?>
				<?php include("includes/nav2.php") ?>
        </div>
        <script>

            var data = <?php echo json_encode($data); ?>;

            var points = [];

            data.forEach(function(d){
		         var t = d.timeStamp.split(/[- :]/);

		         d.timeStamp = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);//t[1]-1 ??

		         points.push(d.temperature);
		         points.push(d.humidity);
            });

            // gets the smallest date of the dataset
				var currDate = new Date(
					d3.min(data, function(d){
						return Math.min(d.timeStamp);
				}));

//			var day = currDate.getDay()-1; //returns the week day in number - sunday is 0
			var day = currDate.getDate();
			var month = currDate.getMonth()+1; //returns 0 - 11
			var year = currDate.getFullYear(); //returns 2013 here
			//console.log(day+" / "+month+" / "+year);

			d3.select("#nav2 #title p").text(day +" / "+ month +" / "+ year);


            //
            // necessary variables
            //
            var margin = {top: 10, right: 0, bottom: 0, left: 40},
                width = 1024 - margin.left - margin.right,
                height = 500 - margin.top - margin.bottom;



            //
            // create scales (x for time, y  for temperature and humidity)
            //
            var x = d3.time.scale()
                .domain([
                    new Date(d3.min(data, function(d){ return Math.min(d.timeStamp); })),
                    new Date(d3.max(data, function(d){ return Math.max(d.timeStamp); }))])
                .range([0, width]);

            var y = d3.scale.linear()
                .domain([
                    new Date(d3.min(data, function(d){ return Math.min(d.temperature); })),
                    new Date(d3.max(data, function(d){ return Math.max(d.temperature); }))])
                .range([height-10, 0]);

            var y1 = d3.scale.linear()
                .domain([
                    new Date(d3.min(data, function(d){ return Math.min(d.humidity); })),
                    new Date(d3.max(data, function(d){ return Math.max(d.humidity); }))])
                .range([height-10, 0]);

            //
            // create axis with the precalculated scales
            //
            var xAxis = d3.svg.axis()
                .tickSize(6)
                .ticks(24)
                .scale(x)
                .tickFormat(d3.time.format("%H:%M"));

            var yAxis = d3.svg.axis()
                .scale(y)
                .tickSize(4)
                .orient("left")
                .tickFormat(function (d) {
                      return d+"ºC";
                });

            var y1Axis = d3.svg.axis()
                .scale(y1)
                .tickSize(4)
                .orient("left")
                .tickFormat(function (d) {
                      return d+"%";
                });

            //
            // create svg: handles object chain
            //
            var svg = d3.select("body").append("svg")
                .attr("width", width + margin.left + margin.right + 50)
                .attr("height", height + margin.top + margin.bottom)
              .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            //
            // chart line1
            //
            var line1 = d3.svg.line()
              .x(function(d,i) { return x(d.timeStamp); })
              .y(function(d) { return y(d.temperature); })
              .interpolate("linear");

            //
            // chart line2
            //
            var line2 = d3.svg.line()
              .x(function(d,i) { return x(d.timeStamp); })
              .y(function(d) { return y1(d.humidity); })
              .interpolate("linear");

            svg.append("path")
                .attr("class","path1")
                .attr("d", line1(data));

            svg.append("path")
                .attr("class","path2")
                .attr("d", line2(data));

            //
            // tooltip for showing point values on mouse hover
            //
            var tooltip = d3.select("body")
                .append("div")
                .attr("class","tooltip")
                .style("position", "absolute")
                .style("z-index", "10")
                .style("visibility", "hidden");

            //
            // create circles for all points
            //
            svg.selectAll("circle")
                .data(points)
                .enter()
                .append("circle")
                .attr("r", 1)
                .attr("cy",function(d,i) {
                    if(i%2!=0){ //impares - humidade
                        d3.select(this).attr("class","circle2");
                        return y1(d);
                    }else{ //pares - temperatura
                        d3.select(this).attr("class","circle1")
                        return y(d);
                    }
                });

            //
            // add specifics to circle1
            //
            svg.selectAll(".circle1")
                .data(data)
                .attr("cx", function(d) {
                     return x(d.timeStamp);
                })
                .on("mouseover",
                    function(){return tooltip.style("visibility", "visible"),d3.select(this).attr("r","5");})
                .on("mousemove",
                    function(d,i){
                        return tooltip
                          .style("top",(d3.event.pageY-45)+"px")
                          .style("left",(d3.event.pageX)+"px")
                          .text(d.temperature +"º C"+" in "+d.timeStamp);
                        })
                .on("mouseout",
                    function(){
                          return tooltip.style("visibility", "hidden"),d3.select(this).attr("r","1");});;

            //
            // add specifics to circle2
            //
            svg.selectAll(".circle2")
                .data(data)
                .attr("cx", function(d) {
                     return x(d.timeStamp);
                })
                .on("mouseover",
                    function(){return tooltip.style("visibility", "visible"),d3.select(this).attr("r","5");})
                .on("mousemove",
                    function(d,i){
                            return tooltip
                              .style("top",(d3.event.pageY-45)+"px")
                              .style("left",(d3.event.pageX)+"px")
                              .text(d.humidity +"% Hum."+" in "+d.timeStamp);
                    })
                .on("mouseout",
                    function(){return tooltip.style("visibility", "hidden"),d3.select(this).attr("r","1");});;

            //
            // append the created axis
            //
            svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis)
                .selectAll("text")
                .attr("class","label")
                .attr("dx", "-20px")
                .attr("dy", "10px")
                .attr("transform", function(d) {
                    return "rotate(-50)"
                });

            //
            // humidity scale
            //
            svg.append("g")
                .attr("class", "y axis")
                .attr("transform", "translate(-25,0)")
                .call(yAxis);

            //
            // temperature scale
            //
            svg.append("g")
                .attr("class", "y1 axis")
                .attr("transform", "translate(-70,0)")
                .call(y1Axis);
            //
            // x axis label (time)
            //
            svg.append("text")
                .attr("x", width +30 )
                .attr("y", height + 10 )
                .style("text-anchor", "middle")
                .attr("class","text_weight")
                .text("Date");

            //
            // y0 axis label (temperature)
            //
            svg.append("text")
                .attr("transform", "rotate(-90)")
                .style("text-anchor", "middle")
                .attr("y", -25 )
                .attr("x", -height -30 )
                .style("text-anchor", "middle")
                .text("Temp. ºC")
                .attr("fill","#F53700")
                .attr("class","text_weight");

            //
            // y1 axis label(humidity)
            //
            svg.append("text")
                .attr("transform", "rotate(-90)")
                .style("text-anchor", "middle")
                .text("Temp. ºC")
                .attr("y", -65 )
                .attr("x", -height -30 )
                .attr("fill","#006F9A")
                .attr("class","text_weight")
                .text("Hum. %");

        </script>
    </body>
</html>
