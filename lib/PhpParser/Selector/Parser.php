<?php

namespace PhpParser\Selector;

class Parser {
	
	public function parse( $selector ) {
		
		$this->tokens = $this->tokenize( $selector );
		$this->offset = 0;
		
		try {
			$selector = $this->parseGroup();
		} finally {
			unset( $this->tokens );
			unset( $this->offset );
		}
		
		return $selector;
	}
	
	public function tokenize( $selector ) {
		
		$i = 0;
		$tokens = [];
		
		while( $i < strlen( $selector ) ) {
			
			if( $selector[ $i ] === "," ) {
				$tokens[] = new Token( Token::COMMA );
				$i += 1;
			
			} else if( preg_match( "/[ \t]+/A", $selector, $m, 0, $i ) ) {
				$tokens[] = new Token( Token::WHITESPACE );
				$i += strlen( $m[0] );
			
			} else if( preg_match( "/[A-Za-z_]+/A", $selector, $m, 0, $i ) ) {
				$tokens[] = new Token( Token::IDENTIFIER, $m[0] );
				$i += strlen( $m[0] );
			
			} else {
				assert( FALSE ); // TODO
			}
		}
		
		return $tokens;
	}
	
	private function moreTokens() {
		return $this->offset < count( $this->tokens );
	}
	
	private function peek() {
		assert( $this->moreTokens() );
		return $this->tokens[ $this->offset ];
	}
	
	private function expect( $type ) {
		if( $this->moreTokens() && $this->tokens[ $this->offset ]->type !== $type ) {
			throw new \Exception( "TODO" );
		}
	}
	
	private function read() {
		return $this->tokens[ $this->offset++ ];
	}
	
	private function skipWhitespace() {
		if( $this->moreTokens() && $this->peek()->type === Token::WHITESPACE ) {
			$this->read();
		}
	}
	
	private function parseGroup() {
		
		$selectors = [];
		
		for(;;) {
			$selectors[] = $this->parseSelector();
			
			if( ! $this->moreTokens() ) {
				break;
			} else {
				$this->expect( Token::COMMA );
				$this->read();
			}
		}
		
		return count( $selectors ) === 1 ? $selectors[0] : new Group( $selectors );
	}
	
	private function parseSelector() {
		
		$selector = $this->parseSelectorPart();
		$this->skipWhitespace();
		
		while( $this->moreTokens() && $this->peek()->type !== Token::COMMA ) {
			$selector = Intersection::merge( $this->parseSelectorPart(), new DescendantOf( $selector ) );
			$this->skipWhitespace();
		}
		
		return $selector;
	}
	
	private function parseSelectorPart() {
		
		if( ! $this->moreTokens() ) {
			assert( FALSE ); // TODO
		} else if( $this->peek()->type === Token::IDENTIFIER ) {
			return new IsType( $this->read()->value );
		} else {
			assert( FALSE ); // TODO
		}
	}
}

class Token {
	
	const WHITESPACE = 1;
	const IDENTIFIER = 2;
	const COMMA = 3;
	
	public $type;
	public $value;
	
	public function __construct( $type, $value = NULL ) {
		$this->type = $type;
		$this->value = $value;
	}
}
