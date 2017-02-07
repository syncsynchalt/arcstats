<?php

$selfurl = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);

$type = "svg";
$dl = false;
if (array_key_exists('png', $_REQUEST)) {
    $type = "pngcairo";
}
if (array_key_exists('svg', $_REQUEST)) {
    $dl = true;
}

$short = "ewl-na1-export";
$mount = "ewl-na-export01";
$title = "EWL NA1 Export";
$pid = getmypid();

$plotfile = "/tmp/arcstat-$short-$pid.gnuplot";
$csvfile = "/tmp/arcstat-$short-$pid.csv";
$output = "/tmp/arcstat-$short-$pid.svg";
$errlog = "/tmp/arcstat-$short-$pid-error.txt";

system("~mdriscoll/Bin/storereport.pl $mount | tail -n168 | perl ./gapper.pl > $csvfile");
$pf = fopen($plotfile, "w");
$plotcmds = <<<EOT
    set datafile separator ","
    set terminal $type size 800,600 name ""
    set title font ",18"
    set title "$title"
    set xdata time
    set timefmt "%Y-%m-%d %H:%M:%S"
    set format x "%m/%d"
    set format y '%.2s%c'
    set key off
    set grid
    plot "$csvfile" using 1:(\$2) with lines lw 2 lt 2
EOT;
fwrite($pf, $plotcmds);
fclose($pf);

system("gnuplot < $plotfile > $output 2>> $errlog");

if ($type === 'pngcairo') {
    header("Content-Type: image/png");
    $filename = "storage-$short-" . strftime("%Y%m%d%H%M%S") . ".png";
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $f = fopen($output, "r");
    fpassthru($f);
} else if ($dl) {
    header("Content-Type: image/svg+xml");
    $filename = "export-$short-" . strftime("%Y%m%d%H%M%S") . ".svg";
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $f = fopen($output, "r");
    fpassthru($f);
} else {
    header("Content-Type: text/html");
?>
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=800">
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <title><?=$title?></title>
    </head>
    <body>
<?php
    ob_flush();
    $f = fopen($output, "r");
    fpassthru($f);
?>
    <div style="padding-left: 3em">
        <small><a href='<?=$selfurl?>?svg'>download as SVG</a></small>
        <br>
        <small><a href='<?=$selfurl?>?png'>download as PNG</a></small>
        <br>
        <small>last update <?= `ls ~mdriscoll/spurge/arc* | tail -n 1 | sed -e 's/.*arc_report_//' `; ?></small>
    </div>
    </body>
    </html>
<?php
}

@unlink($plotfile);
@unlink($csvfile);
@unlink($output);
@unlink($errlog);

return;
