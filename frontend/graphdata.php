<?php 
require "db.php";
$db = Database::getInstance();
$labels = $db->query("SELECT Date FROM TESTS")->fetchAll();
function array_mapper($data){
    return $data[0];
}
$labels = array_map('array_mapper', $labels);
$downloads = $db->query("SELECT Download FROM TESTS")->fetchAll();
$downloads = array_map('array_mapper', $downloads);
$uploads = $db->query("SELECT Upload FROM TESTS")->fetchAll();
$uploads = array_map('array_mapper', $uploads);
$pings = $db->query("SELECT Ping FROM TESTS")->fetchAll();
$pings = array_map('array_mapper', $pings);
header('Content-Type: application/javascript');
?>
window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
};
var speedtestData = {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
        label: 'Download',
        borderColor: window.chartColors.red,
        backgroundColor: window.chartColors.red,
        fill: false,
        data: <?= json_encode($downloads) ?>,
        yAxisID: 'y-axis-speed',
    }, {
        label: 'Upload',
        borderColor: window.chartColors.blue,
        backgroundColor: window.chartColors.blue,
        fill: false,
        data: <?= json_encode($uploads) ?>,
        yAxisID: 'y-axis-speed'
    }, {
        label: 'Latency',
        borderColor: window.chartColors.green,
        backgroundColor: window.chartColors.green,
        fill: false,
        data: <?= json_encode($pings) ?>,
        yAxisID: 'y-axis-latency'
    }]
};
speedtestData.labels = speedtestData.labels.map(elem => moment(elem));