<?php

use PhpParser\Selector;
use PhpParser\Node;

class IsTypeTest extends PHPUnit_Framework_TestCase {
	
	public function testIsType() {
		
		$selector = new Selector\IsType( "Stmt_Function" );
		
		$this->assertTrue( $selector->match( [], new Node\Stmt\Function_( "test" ) ) );
		$this->assertFalse( $selector->match( [], new Node\Stmt\Class_( "Test" ) ) );
	}
}
