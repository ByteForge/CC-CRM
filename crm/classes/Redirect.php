<?php
class Redirect {

	public static function to( $address = null ) {
		if( $address ) {
			header( "Location: {$address}" );
			exit();
		}
	}
}