<?php

namespace PhpParser\Selector;

interface Selector {
	public function match( array $parentNodes, \PhpParser\NodeAbstract $node );
}
