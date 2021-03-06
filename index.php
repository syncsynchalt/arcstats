<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<title>Archiving Grapher</title>
<style>
.inset {
    padding-left: 3em;
}
.mt-1 {
    margin-top: 1em;
}
</style>
</head>
<body>
<div class="container-fluid">
<div class="group">
    <h2>Exports</h2>
    <div class="inset">
    <ul class="list-unstyled">
        <li><a href="export/completed-quarter.php">Completed trend (quarter)</a></li>
        <li><a href="export/completed-week.php">Completed trend (week)</a></li>
<!--
        <li><a href="export/requested-quarter.php">Request backlog (quarter)</a></li>
        <li><a href="export/requested-week.php">Request backlog (week)</a></li>
-->
        <li><a href="export/done.php">Done per day</a></li>
<!--
        <li><a href="export/requests-count.php">US Requests (count per day)</a></li>
        <li><a href="export/requests-seqs.php">US Requests (seqs per day)</a></li>
-->
        <li><a href="export/inprogress-quarter.php">Inprogress trend (quarter)</a></li>
        <li><a href="export/inprogress-week.php">Inprogress trend (week)</a></li>
        <li><a href="export/us-workers.php">US workers in progress</a></li>
    </ul>
    </div>
</div>
<div class="group">
    <h2>Workers</h2>
    <div class="inset">
    <ul class="list-unstyled">
        <li><a href="workers/avgspeed-week.php">Average US worker speed (week)</a></li>
        <li><a href="workers/avgspeed-month.php">Average US worker speed (month)</a></li>
        <li><a href="workers/avgspeed-quarter.php">Average US worker speed (quarter)</a></li>
<!--
        <li><a href="workers/avgspeed-anz.php">Average ANZ worker speed (week)</a></li>
-->
    </ul>
    </div>
</div>
<div class="group">
    <h2>Storage</h2>
    <div style="max-width: 400px">
    <div class="row">
        <div class="col-xs-3">&nbsp;</div>
        <div class="col-xs-3">ewl</div>
        <div class="col-xs-3">vzn</div>
        <div class="col-xs-3">lvs</div>
    </div>

    <div class="row">
        <div class="col-xs-3">MAS</div>
        <div class="col-xs-3"><a href="store/ewl-mas.php">EWL MAS</a></div>
        <div class="col-xs-3"><a href="store/vzn-mas.php">VZN MAS</a></div>
        <div class="col-xs-3"><a href="store/lvs-mas.php">LVS MAS</a></div>
    </div>
    </div>
</div>
<p class="mt-1">last update <?= `ls ~mdriscoll/spurge/arc* | tail -n 1 | sed -e 's/.*arc_report_//' `; ?></p>
</div>
</body>
</html>
