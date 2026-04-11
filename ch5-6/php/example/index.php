<?php
  require_once('vehicle.php');
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

    for($x = 13; $x > 0; $x-=2) {// loop to determine tax bracket
      if ($grossPay < $topBracket[$x]){ $bracket = $topBracket[$x-1];  }// set bracket corresponding to salary
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

  echo "<table border=1>\n" . "  <tr>\n" . "  <th>" ."Name" . "</th>\n";
  // two spaces of indenting with trailing newline for html readability
  echo "  <th style='padding: 12px;'>" . "Hours Worked" . "</th>\n";
  echo "  <th style='padding: 12px;'>" . "Pay Rate" . "</th>\n";
  echo "  <th style='padding: 12px;'>" . "Gross Pay" . "</th>\n";
  echo "  <th style='padding: 12px;'>" . "Net Pay" . "</th>\n";
  echo "  <th style='padding: 12px;'>" . "Tax Bracket" . "</th>\n";
  echo "  <th style='padding: 12px;'>" . "Deductions" . "</th>" . "</tr>\n\n";

  echo "  <td style='padding: 12px;'>" . $name . "</td>\n";
  echo "  <td style='padding: 12px;'>" . $hoursWorked . "</td>\n";
  echo "  <td style='padding: 12px;'>" . "$" .
    number_format($payRate, 2, '.', '') . "</td>\n";
  echo "  <td style='padding: 12px;'>" . "$" .
    number_format((double) $grossPay, 2, '.', '') . "</td>\n";
  echo "  <td style='padding: 12px;'>" . "$" .
    number_format((double) $netPay, 2, '.', '') . "</td>\n";
  echo "  <td style='padding: 12px;'>" . $taxBracket .
    "%" . "</td>\n";
  echo "  <td style='padding: 12px;'>" . "Federal: " .
    $fedWitholding . "%" . "<br>" . "State: " . $stWitholding . "%" . "<br>" . "Total: " . $totalDeduct . "%" . "</td>\n";
  echo "</table>\n\n";

  echo "<h1>Vehicles</h1>\n";
  // div container for all vehicles
  echo "<div style='margin-left: 12px;'" . 'class="vehicles"' . ">\n";
  $vehicles = array(
    new vehicle("McLaren", "F1", "4837G8394UI3275BF", array("Driver Seat" => "Middle", "A/C" => 1)),
    new vehicle("Chevrolette", "Corvette C6", "2736076087DHWUY837", array("Driver Seat" => "Middle", "A/C" => 1))
  );

  $v_num = 0;// introduce for dynamic div id numbering

  foreach($vehicles as $vehicle) {
    $v_num = $v_num + 1;
    // create new div for this specific vehicle (e.g., vehicle-3)
    echo "  <div id='vehicle-" . $v_num . "'>\n";
    echo "    Make: " . $vehicle->getMake() . "<br>\n";
    echo "    Model: " . $vehicle->getModel() . "<br>\n";
    echo "    VIN: " . $vehicle->getVin() . "<br>\n";

    $features = $vehicle->getFeatures();
    // subtitle for vehicles section, 12px left margin for formatting
    echo "    <h4 style='display: inline;'><b>Features</b></h4>\n" .
      "    <div style='margin: 0 0 0 12px;' class='features'>\n";
    
    $keys = array_keys($vehicle->getFeatures());
    $end = count($keys);
    for($x=0; $x<$end; $x++) {// numerically indexed for loop for associative arrays makes it easier to reference older values if necessary
      echo "      " . $keys[$x] . ": " . $vehicle->getFeatures()[ $keys[$x] ] . "<br>" . "\n";
    }
    // close the features div and the vehicle div
    echo "    </div class='features'>\n  </div id='vehicle-" . $v_num . "'><br>\n";
  }
  echo "</div class='vehicles'>";
?>
