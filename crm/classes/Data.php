<?php
class Data {

	public static function isString( $data, $minimumLength = null, $maximumLength = null ) {
		if( is_string($data) ) {
			$data = trim((string)$data);

			if( $minimumLength === null && $maximumLength === null ) {
				return true;
			} else if( is_int($minimumLength) ) {
				return String::lengthBetween( $data, $minimumLength, $maximumLength );
			}			
		}
		return false;
	}
	public static function isInteger( $data, $minimum = null, $maximum = null ) {
		if( $data !== null ) {
			$data = (int)(trim((string)$data));			
			if( $minimum === null && $maximum === null ) {
				return true;
			} else if( is_int($minimum) ) {
				return Integer::between( $data, $minimum, $maximum );
			}			
		}
		return false;
	}
	public static function isDouble( $data, $minimum = null, $maximum = null ) {
		if( $data !== null ) {
			$data = (double)(trim((string)$data));			
			if( $minimum === null && $maximum === null ) {
				return true;
			} else if( is_double($minimum) ) {
				return Double::between( $data, $minimum, $maximum );
			}			
		}
		return false;
	}
	
	public static function isNumeric( $data, $minimum = null, $maximum = null ) {
		return self::isDouble( $data, $minimum, $maximum );
	}
	

	public static function matches( $data, $array = null, &$key = null, &$value  = null ) {
		if( $data !== null && is_array($array) ) {
			$data = trim((string)$data);			
			foreach ($array as $k => $v) {
				//trace( $k, $v );
				if( $data === $v ) {
					$key = $k;
					$value = $v;
					return true;
				}
			}
		}
		$key = null;
		$value = null;
		return false;
	}

	public static function contains( $data, $value ) {
		if( $data !== null ) {
			$data = trim((string)$data);			
			if( is_string($value) ) {				
				return ( strpos( $data, $value ) !== false ) ? true : false;
			} else if( is_array($value) ) {
				foreach ($value as $v) {
					trace( $v );
					if( $data === $v ) {
						return true;
					}
				}
			}
		}
		return false;
	}

	public static function asString( $data, $validationArray = null ) {
		return (string)$data;		
	}
	public static function asInteger( $data ) {
		$data = (int)(trim((string)$data));
		return $data;
	}
	public static function asDouble( $data ) {
		$data = (double)(trim((string)$data));
		return $data;
	}
	public static function asBoolean( $data ) {
		$data = trim((string)$data);
		if( $data === true || $data === "true" || $data === "True" || $data === "TRUE" ) {
			return true;
		}
		return false;
	}

	// "normal" name, without numbers, spaces and punctuations
	public static function isName( $data ){
		$data = trim((string)$data);
		$result = false;
		for( $i = 0, $L = strlen($data); $i < $L; ++$i ) {
			$c = ord( $data[$i] );
			trace( $c );
			if(
				( ( $c >= 65 && $c <= 90 ) || ( $c >= 97 && $c <= 122 ) ) || /* between "A"-"Z" and "a"-"z" */
				$c > 127 /* 7bit ASCII+  */
					) { 
				$result = true;
			} else {
				$result = false;
				break;
			}
		}
		return $result;
	}

	public static function isEmail( $data ){}
	public static function isURL( $data ){}
	public static function isPhoneNumber( $data ){
		$data = trim((string)$data);
		$result = false;
		for( $i = 0, $L = strlen($data); $i < $L; ++$i ) {
			$c = ord( $data[$i] );
			if(
				($c >= 48 && $c <= 57) /* between 0-9 */
/* + * - {space} */
					) {

			}
		}
		return $result;	
	}
}