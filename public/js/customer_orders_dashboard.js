$(function () {

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d')
    var pieChart = new Chart(pieChartCanvas)
    var pieChart2 = new Chart(pieChartCanvas2)
    var PieData = [
        {
            value: child_vendors,
            color: '#f56954',
            highlight: '#f56954',
            label: 'Child Vendors'
        },
        {
            value: parent_vendors,
            color: '#00a65a',
            highlight: '#00a65a',
            label: 'Parent Vendors'
        }
    ];

    // var colors = ['#f56954', '#00a65a', '#f39c12'];
    // var vendor_data = [];
    // var vendors = JSON.parse(vendor_product_counts);
    order_data = {
        value = parseInt(order_counts),
        label = 'Orders',
        color: '#f56954',
        highlight: '#f56954'
    };


    var pieOptions = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps: 100,
        //String - Animation easing effect
        animationEasing: 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //String - A legend template
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(order_data, pieOptions);
    pieChart2.Doughnut(order_data, pieOptions);


});
