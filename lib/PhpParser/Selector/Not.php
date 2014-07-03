<?php

namespace PhpParser\Selector;

class Not implements Selector {
	
	private $selector;
	
	public function __construct( Selector $selector ) {
		$this->selector = $selector;
	}
	
	public function match( array $parentNodes, \PhpParser\NodeAbstract $node ) {
		return ! $this->selector->match( $parentNodes, $node );
	}
}
