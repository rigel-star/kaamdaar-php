function generateChart(context, label, labels, data)
{
    const chart = new Chart(context, {
        type: "bar",
        data: {
            labels,
            datasets: [{
                label,
                data
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    return chart;
}

function updateChartType(chart, type)
{
    chart.type = type;
}

function updateChart(chart, newdata = [], label = undefined)
{
    if(newdata.length > 0)
    {
        chart.data.datasets.pop();
        chart.data.datasets.push({
            label: label,
            data: newdata
        });
        chart.update();
    }
}