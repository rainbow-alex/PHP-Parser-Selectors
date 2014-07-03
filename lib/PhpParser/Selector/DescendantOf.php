<?php

namespace PhpParser\Selector;

class DescendantOf implements Selector {
	
	private $selector;
	
	public function __construct( Selector $selector ) {
		$this->selector = $selector;
	}
	
	public function match( array $parentNodes, \PhpParser\NodeAbstract $node ) {
		
		for( $i = count( $parentNodes ) - 1 ; $i >= 0 ; $i -= 1 ) {
			if( $this->selector->match( array_slice( $parentNodes, 0, $i ), $parentNodes[ $i ] ) ) {
				return TRUE;
			}
		}
		
		return FALSE;
	}
}
