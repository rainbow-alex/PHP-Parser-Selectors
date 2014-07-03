<?php

use PhpParser\Selector;

class FindTest extends PHPUnit_Framework_TestCase {
	
	public function testFind() {
		
		$source = <<<'CODE'
<?php
$foo = 3;
$bar = 1;
function foo() {
	$baz = 2;
}
CODE;
		
		$stmts = ( new PhpParser\Parser( new PhpParser\Lexer ) )->parse( $source );
		
		$this->assertCount( 3, Selector\Find::all( "Expr_Variable", $stmts ) );
		$this->assertCount( 1, Selector\Find::all( "Stmt_Function Expr_Variable", $stmts ) );
	}
}
