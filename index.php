<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
    crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1,
                               maximum-scale=1, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<title>Archiving Grapher</title>
<style>
.inset {
    padding-left: 3em;
}
</style>
</head>
<body>
<div class="container-fluid">
<div class="group">
    <h2>Storage</h2>
    <div class="inset">
    <ul class="list-unstyled">
        <li><a href="store/ewl-export.php">EWL-export</a></li>
        <li><a href="store/ba-export.php">BA-export</a></li>
        <li><a href="store/ewl-na1-export.php">EWL-NA1-export</a></li>
        <li><a href="store/ewl-na2-export.php">EWL-NA2-export</a></li>
        <li><a href="store/lvs-export.php">LVS-export</a></li>
        <li><a href="store/ewl-zfs.php">EWL ZFS</a></li>
        <li><a href="store/lvs-zfs.php">LVS ZFS</a></li>
        <li><a href="store/ba-latisys2.php">Drain latisys2</a></li>
        <li><a href="store/ba-englewood.php">Drain englewood</a></li>
    </ul>
    </div>
</div>
<div class="group">
    <h2>Exports</h2>
    <div class="inset">
    <ul class="list-unstyled">
        <li><a href="export/completed-quarter.php">Completed trend (quarter)</a></li>
        <li><a href="export/completed-week.php">Completed trend (week)</a></li>
        <li><a href="export/requested-quarter.php">Request backlog (quarter)</a></li>
        <li><a href="export/requested-week.php">Request backlog (week)</a></li>
        <li><a href="export/done.php">Done per day</a></li>
        <li><a href="export/requests-count.php">Requests (count per day)</a></li>
        <li><a href="export/requests-seqs.php">Requests (seqs per day)</a></li>
    </ul>
    </div>
</div>
<div class="group">
    <h2>Workers</h2>
    <div class="inset">
    <ul class="list-unstyled">
        <li><a href="workers/avgspeed-week.php">Average worker speed (week)</a></li>
        <li><a href="workers/avgspeed-month.php">Average worker speed (month)</a></li>
    </ul>
    </div>
</div>
<div class="group">
    <div class="inset">
    <br>
    <p>last update <?= `ls ~mdriscoll/spurge/arc* | tail -n 1 | sed -e 's/.*arc_report_//' `; ?></p>
    </div>
</div>
</div>
</body>
</html>
