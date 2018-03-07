<?php
/*
* Class for parse array
*/
if( ! class_exists( 'jvbpd_array' ) ) :
	class jvbpd_array{

		public $values = Array();

		public function __construct( $args ) {
			$this->values = (Array) $args;
		}

		public function __get( $key='' ) {
			$default = false;

			if( empty( $key ) || ! is_array( $this->values ) ) {
				return $default;
			}

			if( array_key_exists( $key, $this->values ) ) {
				if( is_numeric( $this->values[ $key ] ) ) {
					return $this->values[ $key ];
				}else{
					if( !empty( $this->values[ $key ] ) ) {
						$default = $this->values[ $key ];
					}
				}
			}
			return $default;
		}

		public function get( $name='', $default=false ){
			$value = $this->__get( $name );
			return $value !== false ? $value : $default;
		}
	}
endif;