<!DOCTYPE HTML>
<html lang="en">
  <head>
    <title>Test Page</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width">
  </head>
  <body>
<?php
  require_once('student.php');
  echo "    <h1>Chapters 5 & 6 </h1>";
  $students = array(
    new student("Dominic", "Gena", 393556, array("CPSC222" => 76, "LIT104" => 82, "CPSC428" => 97)),
    new Student("Sarah", "Miller", 401223, array( "MATH101" => 88,  "PHYS201" => 92,  "ENGL110" => 85 )),
    new Student("Marcus", "Thorne", 382991, array( "HIST202" => 74,  "PSYC101" => 89,  "CPSC150" => 95 )),
    new Student("Elena", "Rodriguez", 415667, array( "BIO101" => 91, "CHEM102" => 84, "SPAN201" => 98 )),
  );

  $end = count($students);
  
  for($x=0; $x<$end; $x++) {
    $students[$x]->format_student();
  }
?>
  </body>
</html>