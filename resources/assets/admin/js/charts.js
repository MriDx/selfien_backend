var chart_plot_02_data = [];

for (var i = posts_chart_data.length-1; i >= 0; i--) {
    chart_plot_02_data.push([new Date(posts_chart_data[i][0]).getTime(), posts_chart_data[i][1]]);
}

var chart_plot_02_settings = {
    grid: {
        show: true,
        aboveData: true,
        color: "#3f3f3f",
        labelMargin: 10,
        axisMargin: 0,
        borderWidth: 0,
        borderColor: null,
        minBorderMargin: 5,
        clickable: true,
        hoverable: true,
        autoHighlight: true,
        mouseActiveRadius: 100
    },
    series: {
        lines: {
            show: true,
            fill: true,
            lineWidth: 2,
            steps: false
        },
        points: {
            show: true,
            radius: 4.5,
            symbol: "circle",
            lineWidth: 3.0
        }
    },
    legend: {
        position: "ne",
        margin: [0, -25],
        noColumns: 0,
        labelBoxBorderColor: null,
        labelFormatter: function(label, series) {
            return label + '&nbsp;&nbsp;';
        },
        width: 40,
        height: 1
    },
    colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
    shadowSize: 0,
    tooltip: true,
    tooltipOpts: {
        content: "%s: %y.0",
        xDateFormat: "%d/%m",
        shifts: {
            x: -30,
            y: -50
        },
        defaultTheme: false
    },
    yaxis: {
        min: 0
    },
    xaxis: {
        mode: "time",
        minTickSize: [1, "day"],
        timeformat: "%d/%m/%y",
        min: chart_plot_02_data[0][0],
        max: chart_plot_02_data[chart_plot_02_data.length-1][0]
    }
};

function init_dashboard_index_charts() {
    if ($("#chart_plot_posts").length) {
        console.log('Plot2');

        $.plot($("#chart_plot_posts"),
            [{
                label: "Posts",
                data: chart_plot_02_data,
                lines: {
                    fillColor: "rgba(150, 202, 89, 0.12)"
                },
                points: {
                    fillColor: "#fff"
                }
            }], chart_plot_02_settings);

    }
}

$(document).ready(function() {
    init_dashboard_index_charts();
});