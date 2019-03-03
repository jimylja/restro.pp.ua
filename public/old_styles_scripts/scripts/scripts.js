$(document).ready(
   $('.switcher').click(
		function() {
  		var active = $(this).toggleClass('active').hasClass('active');
  		$(".system_info").css('display', !active ? 'none' : 'block');}
   )
   );


   $(document).ready(
     
    $('#add_product').click(
      function(){
        var input=$("fieldset input").last().clone();
        var select=$("fieldset select").last().clone();
        
        var new_input=input; new_select=select;
        var ingradients=$('[name = "ingradients"]');
        new_input.attr('name', (+input.attr('name')[0]+1)+'_product_quantity');
        new_select.attr('name', (+select.attr('name')[0]+1)+'_product'); 

        new_select.appendTo(ingradients);
        new_input.appendTo(ingradients);

       // console.log (i);
      
      }
    )
     );   



// google.charts.load('current', {packages: ['corechart', 'bar']});
// google.charts.setOnLoadCallback(drawTrendlines);

// function drawTrendlines() {
//   google.charts.load("current", {packages:['corechart']});
//   google.charts.setOnLoadCallback(drawChart);
//   function drawChart() {
//     var data = google.visualization.arrayToDataTable(mydata);
//     var view = new google.visualization.DataView(data);
//     view.setColumns([0, 1,
//                      { calc: "stringify",
//                        sourceColumn: 1,
//                        type: "string",
//                        role: "annotation" },
//                      2]);

//     var options = {
//       title: "Density of Precious Metals, in g/cm^3",
//       width: 600,
//       height: 400,
//       bar: {groupWidth: "95%"},
//       legend: { position: "none" },
//     };
//     var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
//         chart.draw(view, options);

// }
//     }
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

          var data = new google.visualization.DataTable();
      if( typeof(group_by) != "undefined" && group_by=='date') {data.addColumn('date', 'Періоди'); }
        else {data.addColumn('string', 'Період');}    
      
      data.addColumn('number', "Кільк.\nзамов.");
      for (var i=0; i<mydata.length; i++){
        //console.log(new Date(mydata[i][0]));
        var row=[];
        row[0]=new Date(mydata[i][0]);
        row[1]=mydata[i][1];
        console.log('row');
        console.log(group_by);
        if (group_by=='date')
          {data.addRows([[new Date(mydata[i][0]), mydata[i][1]]]);}
          else {data.addRows([[mydata[i][0], mydata[i][1]]]);}


//        data.addRows([[new Date(mydata[i][0]), mydata[i][1]]]);

      }
     
      // data.addRows([
      //   [new Date(2014, 0),  -.5],
      //   [new Date(2014, 1),   .4],
      //   [new Date(2014, 2),   .5],
      //   [new Date(2014, 3),  2.9],
      //   [new Date(2014, 4),  6.3],
      //   [new Date(2014, 5),    9],
      //   [new Date(2014, 6), 10.6],
      //   [new Date(2014, 7), 10.3],
      //   [new Date(2014, 8),  7.4],
      //   [new Date(2014, 9),  4.4],
      //   [new Date(2014, 10), 1.1],
      //   [new Date(2014, 11), -.2]
      // ]);
   
      var options = {
        chart: {
          title: 'Статистика замовлень',
          subtitle: 'Кількість замолених страв за обраний період (шт.)'
        },
        backgroundColor: '#2121211c',
        width: 900,
        height: 500
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }




