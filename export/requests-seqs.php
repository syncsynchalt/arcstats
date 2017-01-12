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

$rtype = "seqs";
$title = "US Requests by day ($rtype)";
$short = "req-$rtype";
$pid = getmypid();

$plotfile = "/tmp/arcstat-$short-$pid.gnuplot";
$csvfile = "/tmp/arcstat-$short-$pid.csv";
$output = "/tmp/arcstat-$short-$pid.svg";
$errlog = "/tmp/arcstat-$short-$pid-error.txt";

system("cat ~mdriscoll/spurge/\$(ls ~mdriscoll/spurge/ | tail -n1) | "
    . " perl -ne 'print if (\$p); if (/All export requests/) { \$p = 1 }; if (/rows\\)/) { \$p = 0; }' | "
    . " egrep ' (done|active|requested|stalled) ' | "
    . " perl -ne 's!.* (\d+) \| +\d+ \| (\d\d)/(\d\d)/(\d\d) \d\d:\d\d .*!20\$4-\$2-\$3,\$1! and print' | "
    . " perl -e 'while (<>) { (\$d,\$s) = split /,/; \$sums{\$d} += \$s } "
    . "          for my \$day (sort keys %sums) { print \"\$day,\$sums{\$day}\\n\" }' > $csvfile");
$pf = fopen($plotfile, "w");
$plotcmds = <<<EOT
    set datafile separator ","
    set terminal $type size 800,500 name ""
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
    set yrange [0:*<200000000]
    unset mxtics

    #set fit quiet
    #set fit logfile '/dev/null'
    #f(x)=a+b*((x-dday)/86400)+c*((x-dday)/86400)**2+d*((x-dday)/86400)**3
    #dday=1456815600
    #fit f(x) "$csvfile" using 1:2 via a,b,c,d

    #plot "$csvfile" using 1:2 with boxes lt 6, f(x) lt rgb "#888888" lw 2
    plot "$csvfile" using 1:2 with boxes lt 6
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
