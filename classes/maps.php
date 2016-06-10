<?php

class Maxxdev_Helper_Maps {

	public static function calculateDistance($lat1, $lng1, $lat2, $lng2, $distanceUnit = 'km') {
		$theta = $lng1 - $lng2;
		$dist = (rad2deg(acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta))))) * 60 * 1.1515;

		if ($distanceUnit == "km") {
			$dist *= 1.609344;
		}

		return (round($dist, 2));
	}

}
