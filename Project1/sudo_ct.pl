#!/usr/bin/perl
$prefix = "; COMMAND"; # every occurrence of this string denotes 1 sudo usage
my $output = `sudo grep sudo /var/log/auth.log`; # store the unfiltered output (contextually to this script)
my @temp_array = $output =~ /$prefix/g;
my $sudo_ct = @temp_array;
print $sudo_ct;
