function getOrcamentos() {
    try {
        var hoje = DataHora.hoje();
        var arr_hoje = hoje.split('/');
        var strpar = query_string({
            'ano': '2018'/*arr_hoje[2]*/,
            'mes': '08'/*arr_hoje[1]*/
        });
        ajax('relatorios/orcamentos/orcamento.json.php', strpar, function (json) {
            try {
                var r = JSON.parse(json);
                if (!r.erro) {
                    document.getElementById('ctn_cards').style.display = 'flex';
                    drawChart('PieChart', 'ctrl_orcamento', r.dados);
                } else {
                    document.getElementById('ctn_cards').style.display = 'none';
                }
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function drawChart(chart_type, container, data) {
    try {
        switch (chart_type) {
            case 'PieChart':
                var dados = google.visualization.arrayToDataTable([
                    ['Receitas', 'Despesas'],
                    ['Receitas', data.Receitas],
                    ['Despesas', data.Despesas]
                ]);
                var options = {
                    width: 380,
                    height: 200,
                    /*title: 'Receitas x Despesas - 01/2019',*/
                    pieHole: 0.4,
                    backgroundColor: '#f1f1f1',
                    chartArea: {left: 10, top: 15},
                    pieSliceTextStyle: {color: 'black', bold: true}
                };
                var chart = new google.visualization.PieChart(document.getElementById(container));
                document.getElementById('lbl_card').innerHTML = (data.ano != '' && data.mes != '') ? data.mes + '/' + data.ano : '';
                chart.draw(dados, options);
                break;
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

google.charts.load("current", {packages: ["corechart"]});
google.charts.setOnLoadCallback(getOrcamentos);