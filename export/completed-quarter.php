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

$stat = "completed";
$dur = "quarter";
$title = "Completed Trend ($dur)";
$lines = 90*24;
$short = "$stat-$dur";
$pid = getmypid();

$plotfile = "/tmp/arcstat-$short-$pid.gnuplot";
$csvfile = "/tmp/arcstat-$short-$pid.csv";
$output = "/tmp/arcstat-$short-$pid.svg";
$errlog = "/tmp/arcstat-$short-$pid-error.txt";

system("grep -r $stat: ~mdriscoll/old-spurge/ ~mdriscoll/spurge/ | "
    . " perl -ne 's/.*_(\d{4})(\d\d)(\d\d)-(\d\d)(\d\d):.*: (\d+).*/".'$1-$2-$3 $4:$5:00,$6'."/ and print' | "
    . " sort | tail -n$lines > $csvfile");
$pf = fopen($plotfile, "w");
$plotcmds = <<<EOT
    set datafile separator ","
    set terminal $type size 800,500
    set title font ",18"
    set title "$title"
    set xdata time
    set timefmt "%Y-%m-%d %H:%M:%S"
    set format x "%m/%d"
    set format y '%.0f'
    set key off
    set grid
    set style fill transparent solid 0.5
    plot "$csvfile" using 1:2 with lines lt 2, "$csvfile" using 1:2 noautoscale with filledcurves x1 lt 2
EOT;
fwrite($pf, $plotcmds);
fclose($pf);

system("gnuplot < $plotfile > $output 2>> $errlog");

if ($type === 'pngcairo') {
    header("Content-Type: image/png");
    $filename = "export-$short-" . strftime("%Y%m%d%H%M%S") . ".png";
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
    <br>
    <small style="padding-left: 5em"><a href='<?=$selfurl?>?svg'>download as SVG</a></small>
    <br>
    <small style="padding-left: 5em"><a href='<?=$selfurl?>?png'>download as PNG</a></small>
    </body>
    </html>
<?php
}

@unlink($plotfile);
@unlink($csvfile);
@unlink($output);
@unlink($errlog);

return;