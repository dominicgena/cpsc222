- In linux (ubuntu), sudo commands are logged in /var/log/auth.log
You can loop through the log file and count the instances of the string "; COMMAND=" (which will be referred to
as the uccurrence prefix). A problem is that sudo is required to run the command that fetches all recorded sudo uses
(sudo grep sudo /var/log/auth.log, which I will call the sudo search command). This issue can be remedied by
subtracting 1 from the final count, or by skipping the last iteration. It can also be remedied by setting the sudo
search command as an exception, but this would present a vulnerability. The simplest thing to do would be just
ignore the last line, because that will always demonstrate the use of the sudo search command. But after some
consideration, the baseline of sudo uses will be modified by the execution of the perl script, which doesn't
affect the script's returned count's ability to be a reliable baseline, so this "problem" is safe to ignore.

In summary: ignoring any command's usage, contextually the sudo search command, presents a vulnerability in the
potential unauthorized modification or bug in the system's original binaries. Also, the effect of this slight
inaccuracy is negligible, and doesn't affect the baseline and outlier retrieval purpose of the script.

Overview of the script's functionality: 
1. Run sudo grep sudo /var/log/auth.log and assign the output to a string
2. Use regex to search the string for the prefix's occurrences and put them in an array
3. Retrieve the length of the array and assign that to a count variable
4. Print the value of that variable

Running the script:
cd <directory containing script/git clone directory>
sudo apt update && sudo apt install perl (if not installed)
chmod +x sudo_ct.pl
./sudo_ct.pl
The script will include your 2 sudo usages, but I'd recommend to never exclude  these from the returned number
to keep the baseline consistent.

SNMP support - 
1. run `sudo apt update`
2. run `sudo apt install libsnmp-perl snmpd snmp`
3. add `extend file-check ~/Desktop/CPSC222/Project1/sudo_ct.pl` to /etc/snmp/snmpd.conf (snmpd.conf)
4. run `sudo systemctl restart snmpd`
5. run `snmpwalk -v2c -c public localhost .1.3.6.1.4.1.8072.1.3.2`
   something like this should be returned: iso.3.6.1.4.1.8072.1.3.2 = No more variables left in this MIB View
   (It is past the end of the MIB tree)
6. Add `view systemonly included .1.3.6.1.4.1.8072` (this might be slightly different for you depending on output
   of previous command) to `view` section of snmpd.conf
7. run `chmod +x /home/{user}/Desktop/CPSC222/Project1/sudo_ct.pl`
8. run `chmod +x /home/{user} /home/{user}/Desktop /home/{user}/Desktop/CPSC222 /home/{user}/Desktop/CPSC222/Project1`
9. Run this to make sure the script and snmpd can read the log that provides the sudo count to the perl script.
   `sudo setfacl -m u:Debian-snmp:r /var/log/auth.log`
10. TEST -
   a. `snmpwalk -v2c -c public localhost .1.3.6.1.4.1.8072.1.3.2`
   b. sudo apt update
   c. run the snmpwalk again, observe the numbers that change. That's the count. More simply, this should be
      the very last line of the output
   Example: 
    Output pre-update: 
     [13 lines of useless info]
     iso.3.6.1.4.1.8072.1.3.2.4.1.2.10.102.105.108.101.45.99.104.101.99.107.1 = STRING: "48"
    Post-update
     [13 lines of useless info]
     iso.3.6.1.4.1.8072.1.3.2.4.1.2.10.102.105.108.101.45.99.104.101.99.107.1 = STRING: "49"
  NOTE - You can also pass the specific OID to make the output cleaner:
       `snmpget -v2c -c public localhost .1.3.6.1.4.1.8072.1.3.2.3.1.1.10.102.105.108.101.45.99.104.101.99.107`
       Output: iso.3.6.1.4.1.8072.1.3.2.3.1.1.10.102.105.108.101.45.99.104.101.99.107 = STRING: "49"
