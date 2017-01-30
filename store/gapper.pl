#!/usr/bin/perl -w

use strict;
use Time::Local;
use POSIX 'strftime';

my $rcount = 0;
my $last_epoch = undef;
while (<>) {
    if (!$rcount) {
        $rcount = () = ($_ =~ m/,/g);
    }

    my $conv_str;
    my $epoch = $_;
    $epoch =~ s/(^[^,]*),/$1/;
    if ($epoch =~ m/^[0-9]+$/) {
        # do nothing
        $conv_str = '%s';
    } elsif ($epoch =~ m/(\d{4})-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/) {
        # convert to epoch
        $epoch = timelocal($6, $5, $4, $3, $2-1, $1);
        $conv_str = '%Y-%m-%d %H:%M:%S';
    } else {
        # just print and ignore
        print;
        next;
    }

    if ($last_epoch && $epoch > $last_epoch + 86400) {
        print strftime($conv_str, localtime($epoch - 86400));
        for (1..$rcount) {
            print ",x";
        }
        print "\n";
    }
    $last_epoch = $epoch;

    print;
}
