<?php
class Integer {

	public static function between( $integer, $minimum, $maximum = null ) {
		if( is_int($integer) ) {

			if( is_int($maximum) ) {
				if( $minimum > $maximum ) {
					$t = $maximum;
					$maximum = $minimum;
					$minimum = $t;
				}
				if( $minimum !== $maximum ) {
					return ( $integer >= $minimum && $integer <= $maximum ) ? true : false;
				} else { // $minimum === $maximum
					return ( $integer === $minimum ) ? true : false;
				}
			} else { // $maximum is unusable data
				return ( $integer >= $minimum ) ? true : false;
			}
		}
		return false;
	}
}