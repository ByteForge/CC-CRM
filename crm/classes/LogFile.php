<?php
class LogFile {

	private
		$_file = null,
		$_opened = false;

	// w

	function __construct( $path ) {				
		//echo "constructed <br />";
		if ( ( $this->_file = fopen( $path, 'at' ) ) !== false ) {
     		$this->_opened = true;
     		//echo "opened <br />";
		}
	}
	function __destruct() {
		if( $this->_opened ) {
			fclose( $this->_file );
		}		
	}
	
	public function append( $string ) {
		if( $this->_opened ) {
			fwrite( $this->_file, $string );
		}
	}
}