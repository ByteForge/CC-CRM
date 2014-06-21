<?php
class Double {

	public static function between( $double, $minimum, $maximum = null ) {
		if( is_double($double) ) {

			if( is_double($maximum) ) {
				if( $minimum > $maximum ) {
					$t = $maximum;
					$maximum = $minimum;
					$minimum = $t;
				}
				if( $minimum !== $maximum ) {
					return ( $double >= $minimum && $double <= $maximum ) ? true : false;
				} else { // $minimum === $maximum
					return ( $double === $minimum ) ? true : false;
				}
			} else { // $maximum is unusable data
				return ( $double >= $minimum ) ? true : false;
			}
		}
		return false;
	}
}