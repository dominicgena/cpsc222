<?php
class vehicle {
  private $make='', $model='', $vin='', $features=array();

  function __construct($m, $mo, $v, $f) {
	$this->setMake($m);
	$this->setModel($mo);
	$this->setVin($v);
	$this->setFeatures($f);
  }

  function setMake($m) { $this->make = $m; }
  function setModel($mo) { $this->model = $mo; }
  function setVin($v) { $this->vin = $v; }
  function setFeatures($f) { $this->features = $f; }

  function getMake() { return $this->make; }
  function getModel() { return $this->model; }
  function getVin() { return $this->vin; }
  function getFeatures() { return $this->features; }

	function getVehicle() {
		return $this->getMake() . " " . $this->getModel() . " " .
			$this->getVin();
	}

}
?>
