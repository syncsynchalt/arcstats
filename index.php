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
        <li><a href="export/requested-quarter.php">Request backlog (quarter)</a></li>
        <li><a href="export/requested-week.php">Request backlog (week)</a>
            <small>
                <span title="US requests"><?=
                `cat \$(ls ~mdriscoll/spurge/arc* | tail -n 1) |
                    perl -ne '\$p=1 if /All export requests/; \$p=0 if /^\$/; print if \$p' |
                    grep ' requested ' | wc -l `
                ?></span>
                /
                <span title="int'l requests"><?=
                `cat \$(ls ~mdriscoll/spurge/arc* | tail -n 1) |
                    perl -ne '\$p=1 if /All export requests/;
                        \$p=2 if \$p && /^ intern/;
                        \$p=0 if \$p==2 && /^\$/;
                        print if \$p==2' |
                    grep ' requested ' | wc -l `
                ?></span>
                /
                <span title="total requests"><?=
                `cat \$(ls ~mdriscoll/spurge/arc* | tail -n 1) | grep ' requested ' | wc -l `
                ?></span>
            </small>
        </li>
        <li><a href="export/done.php">Done per day</a></li>
        <li><a href="export/requests-count.php">US Requests (count per day)</a></li>
        <li><a href="export/requests-seqs.php">US Requests (seqs per day)</a></li>
    </ul>
    </div>
</div>
<div class="group">
    <h2>Workers</h2>
    <div class="inset">
    <ul class="list-unstyled">
        <li><a href="workers/avgspeed-week.php">Average US worker speed (week)</a></li>
        <li><a href="workers/avgspeed-month.php">Average US worker speed (month)</a></li>
        <li><a href="workers/avgspeed-anz.php">Average ANZ worker speed (week)</a></li>
    </ul>
    </div>
</div>
<div class="group">
    <h2>Storage</h2>
    <div class="inset">
    <h5>active</h5>
    <ul class="list-unstyled">
        <li><a href="store/ewl-na1-export.php">EWL NA1 export</a></li>
        <li><a href="store/ewl-na2-export.php">EWL NA2 export</a></li>
        <li><a href="store/lvs-na1-export.php">LVS NA1 export</a></li>
        <li><a href="store/lvs-na2-export.php">LVS NA2 export</a></li>
        <li><a href="store/ewl-zfs.php">EWL ZFS</a></li>
        <li><a href="store/lvs-zfs.php">LVS ZFS</a></li>
    </ul>
    <h5>drainstore</h5>
    <ul class="list-unstyled">
        <li><a href="store/ba-latisys2.php">latisys2</a></li>
        <li><a href="store/ba-englewood.php">englewood</a></li>
    </ul>
    <h5>inactive</h5>
    <ul class="list-unstyled">
        <li><a href="store/lvs-export.php">LVS ZFS export</a></li>
        <li><a href="store/ewl-export.php">EWL ZFS export</a></li>
        <li><a href="store/ba-export.php">EWL BA5 export</a></li>
    </ul>
    </div>
</div>
<p>last update <?= `ls ~mdriscoll/spurge/arc* | tail -n 1 | sed -e 's/.*arc_report_//' `; ?></p>
</div>
</body>
</html>
