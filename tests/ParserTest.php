<?php

use PhpParser\Selector;
use PhpParser\Selector\Token;

class ParserTest extends PHPUnit_Framework_TestCase {
	
	public function testTokenize() {
		
		$parser = new Selector\Parser;
		
		$tokens = $parser->tokenize( "foo" );
		$this->assertCount( 1, $tokens );
		$this->assertEquals( $tokens[0]->type, Token::IDENTIFIER );
		$this->assertEquals( $tokens[0]->value, "foo" );
		
		$tokens = $parser->tokenize( "foo bar" );
		$this->assertCount( 3, $tokens );
		$this->assertEquals( $tokens[0]->type, Token::IDENTIFIER );
		$this->assertEquals( $tokens[0]->value, "foo" );
		$this->assertEquals( $tokens[1]->type, Token::WHITESPACE );
		$this->assertEquals( $tokens[1]->value, NULL );
		$this->assertEquals( $tokens[2]->type, Token::IDENTIFIER );
		$this->assertEquals( $tokens[2]->value, "bar" );
	}
	
	public function testParseIsType() {
		
		$parser = new Selector\Parser;
		
		$selector = $parser->parse( "foo" );
		$this->assertInstanceOf( Selector\IsType::class, $selector );
		$this->assertEquals( "foo", $this->readAttribute( $selector, "type" ) );
	}
}
