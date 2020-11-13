Number.prototype.pad = function(size) {
    var s = String(this);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
}

MainLineChart = {
    Labels: [],
    oChart: null,
    Xhr: function (options) {
        let settings = $.extend({
            url: "/dashboard/analytics",
            type: 'post',
            dataType: 'json'
        }, options);

        $.ajax(settings);
    },
    addDataSet: function (FieldName, Name, RGB){
        if (FieldName !== ""){
            aData = [];
            $.each(MainLineChart.Labels, function (i, date){
                var strDate = date.getDate().pad(2) + "-" +(date.getMonth()+1).pad(2) +"-"+ date.getFullYear();
                if (typeof  aTimeLineData[strDate] === "undefined"){
                    aData[i] = 0;
                } else {
                    aData[i] = aTimeLineData[strDate][FieldName];
                }
            });
            this.oChart.data.datasets.push({
                data: aData,
                borderColor: "rgb("+RGB+")",
                backgroundColor: "rgba("+RGB+",0.5)",
                label: Name
            })
            this.oChart.update();
        }
    },
    Types:{
        Humidity: function (){
            if (true){
                MainLineChart.addDataSet("Humidity", "Humidity", "0,0,0");
            }
        },
        Luminosity: function (){
            if (true){
                MainLineChart.addDataSet("Luminosity", "Luminosity", "255,255,255");
            }
        },
    },
    init: function (){

    }
}
aTimeLineData = JSON.parse(sJsonTimeLineData);
console.log(aTimeLineData);
for (var i = 0; i < 14; i++){
    var tempDate = new Date();
    tempDate.setDate((new Date).getDate()-i);
    MainLineChart.Labels.push(tempDate);
}
MainLineChart.oChart = new Chart($(".TimeLine")[0],{
    type: 'line',
    data:{
        labels: MainLineChart.Labels
    },
    options: {
        scaleGridLineWidth: 1,
        scaleFontSize: 10,
        scaleShowHorizontalLines: false,
        scaleShowVerticalLines: false,
        scaleBeginAtZero: true,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'day',
                    round: "day",
                    tooltipFormat: "D-M-Y",
                    displayFormats: {
                        day: "D-M-Y"
                    }
                },
                gridLines: {
                    display: false
                },
                ticks: {
                    source: 'labels',
                    fontColor: "#fff"
                }
            }],
            yAxes: [{
                ticks: {
                    Min: 0,
                    suggestedMax: 10,
                    display: false
                },
                gridLines: {
                    drawBorder: false,
                    drawTicks: false,
                    display: false
                }
            }]
        },
        legend:{
            position: "bottom",
            align: "start",
            labels:{
                fontColor: "#fff"
            }

        }
    }
});
MainLineChart.Types.Humidity();
MainLineChart.Types.Luminosity()