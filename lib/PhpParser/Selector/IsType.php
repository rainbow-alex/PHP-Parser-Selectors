<?php

namespace PhpParser\Selector;

class IsType implements Selector {
	
	private $type;
	
	public function __construct( $type ) {
		$this->type = $type;
	}
	
	public function match( array $parentNodes, \PhpParser\NodeAbstract $node ) {
		return $node->getType() === $this->type;
	}
}
