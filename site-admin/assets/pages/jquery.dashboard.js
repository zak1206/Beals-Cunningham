/**
 * Theme: Minton Admin Template
 * Author: Coderthemes
 * Component: Dashboard
 *
 */
$( document ).ready(function() {

    var DrawSparkline = function() {


        $('#sparkline2').sparkline([10, 8, 7, 8, 6, 8, 7, 5, 10, 7, 1], {
            type: 'bar',
            height: '200',
            barWidth: '25',
            barSpacing: '4',
            barColor: '#f9cd48',
            tooltipFormat: '<span style="color: {{color}}">&#9679;</span> {{offset:names}}',
            tooltipValueLookups: {
                names: {
                    0: 'Automotive',
                    1: 'Locomotive',
                    2: 'Unmotivated',
                    3: 'Three',
                    4: 'Four',
                    5: 'Five',
                    6: 'Five',
                    7: 'Five',
                    8: 'Five',
                    9: 'Five',
                    // Add more here
                }
            }
        });

        $('#sparkline3').sparkline([60, 40], {
            type: 'pie',
            width: '200',
            height: '200',
            sliceColors: ['#98a6ad', '#f9cd48'],
            tooltipFormat: '{{offset:offset}} ({{percent}}%)',
            tooltipValueLookups: {
                'offset': {
                    0: 'New Visitors',
                    1: 'Returning Visitors'
                }
            },
        });


    };


    DrawSparkline();

    var resizeChart;

    $(window).resize(function(e) {
        clearTimeout(resizeChart);
        resizeChart = setTimeout(function() {
            DrawSparkline();
        }, 300);
    });
});