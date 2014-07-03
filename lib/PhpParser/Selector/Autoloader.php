<?php

namespace PhpParser\Selector;

class Autoloader {
	
	private $namespace;
	private $directory;
	
	public function __construct( $namespace, $directory ) {
		$this->namespace = trim( $namespace, '\\' ) . '\\';
		$this->directory = $directory;
	}
	
	public function install() {
		spl_autoload_register( [ $this, "autoload" ] );
	}
	
	public function autoload( $className ) {
		
		$className = trim( $className, '\\' );
		
		if( substr( $className, 0, strlen( $this->namespace ) ) === $this->namespace ) {
			$file = str_replace( '\\', '/', substr( $className, strlen( $this->namespace ) ) ) . '.php';
			include __DIR__ . '/' . $file;
		}
	}
}
