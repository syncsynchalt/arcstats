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

$title = "Completed per day";
$short = "done";
$pid = getmypid();

$plotfile = "/tmp/arcstat-$short-$pid.gnuplot";
$csvfile = "/tmp/arcstat-$short-$pid.csv";
$output = "/tmp/arcstat-$short-$pid.svg";
$errlog = "/tmp/arcstat-$short-$pid-error.txt";

system("for i in ~mdriscoll/spurge/arc_report_*; do grep -H ' done ' \$i; done | "
    . " awk '!x[\$2]++' | sed -e 's,.*arc_report_,,;s/-.*//' | "
    . " uniq -c | tail -n +2 | "
    . " perl -pe 's/ *(\d+) (\d{4})(\d\d)(\d\d)/".'$2-$3-$4,$1'."/' > $csvfile");
$pf = fopen($plotfile, "w");
$plotcmds = <<<EOT
    set datafile separator ","
    set terminal $type size 800,600 name ""
    set title font ",18"
    set title "$title"
    set xdata time
    set timefmt "%Y-%m-%d"
    set format x "%m/%d"
    set format y "%.0s%c"
    set key off
    set boxwidth 86400 absolute
    set style fill solid
    set xtics out
    unset mxtics
    plot "$csvfile" using 1:2 with boxes lt 2
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
