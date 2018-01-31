<?php

trait Brake {
	private $brakeForce;
	public function slow(): void {
		echo "SLOWING DOWN" . PHP_EOL;
	}
}

class Vehicle {
	protected $licensePlate;

	public function __construct(string $newLicencePlate) {
		try {
			$this->setLicensePlate($newLicencePlate);
		} catch(\InvalidArgumentException| \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	public function getLicensePlate(): string {
		return $this->licensePlate;
	}

	public function setLicensePlate($newLicensePlate): void {
		$newLicensePlate = filter_var($newLicensePlate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$newLicensePlate = strtoupper(trim($newLicensePlate));
		if(preg_match("/^[A-Z]\d{3}$/", $newLicensePlate) !== 1) {
			throw (new \InvalidArgumentException("bad plate number"));
		}
		$this->licensePlate = $newLicensePlate;
	}

	public function accelerate(): void {
		echo("going faster");
	}
}

class Boat extends Vehicle {
	use Brake;

	protected $floatsOnWater;

	public function __construct($newFloatsOnWater, string $newLicencePlate) {
		try {
			parent::__construct($newLicencePlate);
			$this->setFloatsOnWater($newFloatsOnWater);
		} catch(\InvalidArgumentException| \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	public function getFloatsOnWater(): bool {
		return ($this->floatsOnWater);
	}

	public function setFloatsOnWater($newFloatsOnWater): void {
		$newFloatsOnWater = filter_var($newFloatsOnWater, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

		if($newFloatsOnWater === null) {
			throw (new InvalidArgumentException("unable to determine if it floats"));
		}
		$this->floatsOnWater = $newFloatsOnWater;
	}
}