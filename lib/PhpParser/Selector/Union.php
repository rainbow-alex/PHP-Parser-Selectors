<?php

namespace PhpParser\Selector;

class Union implements Selector {
	
	private $selectors;
	
	public function __construct( array $selectors ) {
		$this->selectors = $selector;
	}
	
	public function match( array $parentNodes, \PhpParser\NodeAbstract $node ) {
		
		foreach( $this->selectors as $selector ) {
			if( $selector->match( $parentNodes, $node ) ) {
				return TRUE;
			}
		}
		
		return FALSE;
	}
}
