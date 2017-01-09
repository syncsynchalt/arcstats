<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">
<title>Export Progress Grapher</title>
</head>
<body>
<div class="container" style="max-width: 6000px">
<div class="row">
    <h2>Storage</h2>
    <div class="col-sm-offset-1 col-sm-11">
    <ul class="list-unstyled">
        <li><a href="store/ewl-export.php">EWL-export</a></li>
        <li><a href="store/ba-export.php">BA-export</a></li>
        <li><a href="store/ewl-na1-export.php">EWL-NA1-export</a></li>
        <li><a href="store/ewl-na2-export.php">EWL-NA2-export</a></li>
        <li><a href="store/lvs-export.php">LVS-export</a></li>
        <li><a href="store/ewl-zfs.php">EWL ZFS</a></li>
        <li><a href="store/lvs-zfs.php">LVS ZFS</a></li>
    </ul>
    </div>
</div>
<div class="row">
    <h2>Exports</h2>
    <div class="col-sm-offset-1 col-sm-11">
    <ul class="list-unstyled">
        <li><a href="export/completed-quarter.php">Completed trend (quarter)</a></li>
        <li><a href="export/completed-week.php">Completed trend (week)</a></li>
        <li><a href="export/requested-quarter.php">Requested trend (quarter)</a></li>
        <li><a href="export/requested-week.php">Requested trend (week)</a></li>
        <li><a href="export/done.php">Done per day</a></li>
        <li><a href="export/requests-count.php">Requests per day (by count)</a></li>
        <li><a href="export/requests-seqs.php">Request per day (by seqs)</a></li>
    </ul>
    </div>
</div>
<div class="row">
    <h2>Workers</h2>
    <div class="col-sm-offset-1 col-sm-11">
    <ul class="list-unstyled">
        <li><a href="workers/avgspeed-week.php">Average worker speed (week)</a></li>
        <li><a href="workers/avgspeed-month.php">Average worker speed (month)</a></li>
    </ul>
    </div>
</div>
<div class="row">
    <br>
    <p>last update <?= `ls ~mdriscoll/spurge/arc* | tail -n 1 | sed -e 's/.*arc_report_//' `; ?></p>
</div>
</div>
</body>
</html>
