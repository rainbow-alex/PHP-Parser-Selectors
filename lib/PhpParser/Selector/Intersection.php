<?php

namespace PhpParser\Selector;

class Intersection implements Selector {
	
	public static function merge( Selector $selector1, Selector $selector2 ) {
		if( $selector1 instanceof self ) {
			if( $selector2 instanceof self ) {
				$selector1->selectors = array_merge( $selector1->selectors, $selector2->selectors );
			} else {
				$selector1->selectors[] = $selector2;
			}
		} else if( $selector2 instanceof self ) {
			array_unshift( $selector2->selectors, $selector1 );
		} else {
			return new self( [ $selector1, $selector2 ] );
		}
	}
	
	private $selectors;
	
	public function __construct( array $selectors ) {
		$this->selectors = $selectors;
	}
	
	public function match( array $parentNodes, \PhpParser\NodeAbstract $node ) {
		
		foreach( $this->selectors as $selector ) {
			if( ! $selector->match( $parentNodes, $node ) ) {
				return FALSE;
			}
		}
		
		return TRUE;
	}
}
