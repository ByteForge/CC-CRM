<?php
class String {

	const NUMBERS = 1;
	const LETTERS = 2;	
	const PUNCTUATIONS = 4;

	const NUMBERS_AND_LETTERS = 3;
	const LETTERS_AND_PUNCTUATIONS = 6;

	public static function generate( $length = 16, $criterias = null ) {

	}

	public static function length( $string ) {
		if( $string !== null ) {			
			return strlen( $string );
		}
		return 0;
	}
	
	public static function lengthBetween( $string, $minimum, $maximum = null ) {
		if( $string !== null ) {			
			if( is_int($maximum) ) {
				if( $minimum < 0 ) {
					$minimum = 0;
				}
				if( $maximum < 0 ) {
					$maximum = 0;
				}
				if( $minimum > $maximum ) {
					$t = $maximum;
					$maximum = $minimum;
					$minimum = $maximum;
				}
				$length = strlen($string);
				if( $minimum !== $maximum ) {
					return ( $length >= $minimum && $length <= $maximum ) ? true : false;
				} else { // $minimum === $maximum
					return ( $length === $minimum ) ? true : false;
				}
			} else { // $maximum is unusable data
				if( $minimum < 0 ) {
					$minimum = 0;
				}
				$length = strlen($string);
				return ( $length >= $minimum ) ? true : false;
			}					
		}
		return false;
	}

	/*
		$data can be "string", array(...) and CONST
	*/
	public static function contains( $string, $data ) {
	}

	public static function containsOnly( $string, $data ) {
		if( $string !== null ) {
			if( $string === "" ) { return false; }
			if( is_int( $data ) ) {
				switch( $data ) {
					case self::NUMBERS:
						for( $i = 0, $L = strlen($string); $i < $L; ++$i ) {
							$c = ord( $string[$i] );
							trace( $i, $string[$i], $c );
							if( $c < 48 || $c > 57 ) { /* < '0' || > '9' */
								return false;
							}
						}
						return true; break;

					case self::LETTERS:
						for( $i = 0, $L = strlen($string); $i < $L; ++$i ) {
							$c = ord( $string[$i] );
							trace( $i, $string[$i], $c );
							if(
									( $c < 65 || $c > 90 ) /* < 'A' || > 'Z' */
								&&	( $c < 97 || $c > 122 ) /* < 'a' || > 'z' */
							) { 
								return false;
							}
						}
						return true; break;
						
					case self::PUNCTUATIONS:
						for( $i = 0, $L = strlen($string); $i < $L; ++$i ) {
							$c = ord( $string[$i] );
							trace( $i, $string[$i], $c );
							if(
									( $c < 32 || $c > 47 ) /* < ' ' || > '/' */
								&&	( $c < 58 || $c > 64 ) /* < ':' || > '@' */
								&&	( $c < 91 || $c > 96 ) /* < '[' || > '`' */
								&&	( $c < 123 || $c > 126 ) /* < '{' || > '~' */
							) { 
								return false;
							}
						}
						return true; break;
						
					case self::NUMBERS_AND_LETTERS:
						for( $i = 0, $L = strlen($string); $i < $L; ++$i ) {
							$c = ord( $string[$i] );
							trace( $i, $string[$i], $c );
							if(
									( $c < 48 || $c > 57 ) /* < '0' || > '9' */
								&&	( $c < 65 || $c > 90 ) /* < 'A' || > 'Z' */
								&&	( $c < 97 || $c > 122 ) /* < 'a' || > 'z' */
							) { 
								return false;
							}
						}
						return true; break;						

					case self::LETTERS_AND_PUNCTUATIONS:
						for( $i = 0, $L = strlen($string); $i < $L; ++$i ) {
							$c = ord( $string[$i] );
							trace( $i, $string[$i], $c );
							if(
									( $c < 32 || $c > 47 ) /* < ' ' || > '/' */
								&&	( $c < 58 || $c > 126 ) /* < ':' || > '~' */
							) { 
								return false;
							}
						}
						return true; break;

					default: return false; break;
				}
			} else if( is_array( $data ) ) {
				// iterate through the array
			} else if( is_string( $data ) ) {
				// search for given string only
				$string = str_replace( $data, "", $string );
				return ( strlen( $string ) === 0 ) ? true : false ;
			}
		}
		return false;
	}


	public static function isASCII( $onlyASCII7 = false ) {}
	public static function isUTF8() {}

	public static function toASCII( $toASCII7 = true ) {

	}

	// check if string is empty ("") or filled whitespaces (" ", "\t", etc.)
	public static function isEmpty( $string ) {
		$string = trim((string)$string);
		return ( $string === "" ) ? true : false;
	}

	public static function removeCompoundSpaces( $string ) { // trim than collapse whitespaces
		$string = trim( (string)$string );		
		if( !self::isEmpty( $string ) ) {
			$string = str_replace( array("  ", "\t", "\n", "\r", "\0", "\x0B" ), "", $string );
		}
		return $string;
	}

	public static function removeDiacritics( $string ) {		
	}

	public static function containsNumbers( $string ) { // ASCII numbers only
		if( $string !== null ) {
			for( $i = 0, $L = strlen($string); $i < $L; ++$i ) {
				$c = ord( $string[$i] );
				if( $c >= 48 && $c <= 57 ) { /* between 0-9 */
					return true;
				}
			}
		}
		return false;
	}
	public static function containsLetters( $string ) {}
	public static function containsPunctuations( $string ) {}

	public static function numNumbers( $string ) {}
	public static function numLetters( $string ) {}
	public static function numPunctuations( $string ) {}

	public static function toUpperCase( $string ) {
		if( $string !== null ) {
			return mb_strtoupper( $string, "UTF-8" );
		}
		return "";
	}
	public static function toLowerCase( $string ) {
		if( $string !== null ) {
			return mb_strtolower( $string, "UTF-8" );
		}
		return "";
	}
	public static function toTitleCase( $string, $conjunctions = true ) {}
	public static function toSentenceCase( $string ) {}
	
	public static function toCapitalCase( $string, $firstLetter = false ) {} // backgroundColor
	public static function toDashCase( $string ) {} // background-color


}