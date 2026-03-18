<?php
  function getAnnualNetPay($weeklyHours, $hourlyRate, $percentDeductions) {
    $grossIncome = $weeklyHours * $hourlyRate;
    $percentDeductions *= .01;
    return $grossIncome - ($grossIncome * $percentDeductions);
  }

  function getTaxBracket($grossPay) {
    $grossPay *= 52;
    $bracket = 0;
    $topBracket = array(
      10, 11925, 12, 48475, 22, 103350, 24, 197300, 32, 250525, 35, 626350, 37, INF
    );

    for($i = 13; $i > 0; $i-=2) {// loop to determine tax bracket
      if ($grossPay < $topBracket[$i]){ $bracket = $topBracket[$i-1];  }// set bracket corresponding to salary
      else { return $bracket;  }// accept currently set bracket
    }
    return $bracket;
  }

  $name = 'Dominic';
  $hoursWorked = 40.0;
  $payRate = 54.50;
  $grossPay = $payRate * $hoursWorked;

  $fedWitholding = 24.5;
  $stWitholding = 5.5;
  $totalDeduct = $fedWitholding + $stWitholding;
  $netPay = getAnnualNetPay($hoursWorked, $payRate, $totalDeduct);
  $taxBracket = getTaxBracket($grossPay);

  echo "<table border=1>" . "<tr>" . "<th>" ." Name" . "</th>";
  echo "<th style='padding: 12px;'>" . "Hours Worked" . "</th>";
  echo "<th style='padding: 12px;'>" . "Pay Rate" . "</th>";
  echo "<th style='padding: 12px;'>" . "Gross Pay" . "</th>";
  echo "<th style='padding: 12px;'>" . "Net Pay" . "</th>";
  echo "<th style='padding: 12px;'>" . "Tax Bracket" . "</th>";
  echo "<th style='padding: 12px;'>" . "Deductions" . "</th>" . "</tr>";

  echo "<td style='padding: 12px;'>" . $name . "</td>";
  echo "<td style='padding: 12px;'>" . $hoursWorked . "</td>";
  echo "<td style='padding: 12px;'>" . $payRate . "</td>";
  echo "<td style='padding: 12px;'>" . $grossPay . "</td>";
  echo "<td style='padding: 12px;'>" . $netPay . "</td>";
  echo "<td style='padding: 12px;'>" . $taxBracket . "</td>";
  echo "<td style='padding: 12px;'>" . "Federal: " . $fedWitholding . "%" . "<br>" . "State: " . $stWitholding . "%" . "<br>" . "Total: " . $totalDeduct . "%" . "</td>";
  echo "</table>"
?>
