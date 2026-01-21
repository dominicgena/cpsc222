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
