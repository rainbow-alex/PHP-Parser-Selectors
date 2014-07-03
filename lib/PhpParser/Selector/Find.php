<?php

namespace PhpParser\Selector;

class Find extends \PhpParser\NodeVisitorAbstract {
	
	public static function all( $selector, array $stmts ) {
		$nodes = [];
		$traverser = new \PhpParser\NodeTraverser();
		$traverser->addVisitor( new Find( ( new Parser )->parse( $selector ), function( $node ) use ( &$nodes ) {
			$nodes[] = $node;
		} ) );
		$traverser->traverse( $stmts );
		return $nodes;
	}
	
	private $selector;
	private $callback;
	private $parentNodes = [];
	
	public function __construct( Selector $selector, callable $callback ) {
		$this->selector = $selector;
		$this->callback = $callback;
	}
	
	public function enterNode( \PhpParser\Node $node ) {
		
		if( $this->selector->match( $this->parentNodes, $node ) ) {
			call_user_func( $this->callback, $node );
		}
		
		$this->parentNodes[] = $node;
	}
	
	public function leaveNode( \PhpParser\Node $node ) {
		array_pop( $this->parentNodes );
	}
}
