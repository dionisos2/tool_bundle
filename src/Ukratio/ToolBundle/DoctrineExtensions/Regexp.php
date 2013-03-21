<?php

namespace Ukratio\ToolBundle\DoctrineExtensions ;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * RegexpFunction ::= "Regexp" "(" StringPrimary "," StringPrimary ")"
 */
class Regexp extends FunctionNode
{
    public $str = null;
    public $regexp = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->str = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->regexp = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return $this->str->dispatch($sqlWalker) . ' REGEXP ' . $this->regexp->dispatch($sqlWalker) ;
    }
}
