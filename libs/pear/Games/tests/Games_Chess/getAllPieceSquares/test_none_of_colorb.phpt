--TEST--
Games_Chess->getAllPieceSquares() no black pieces
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . '/setup.php.inc';
$board->addPiece('W', 'N', 'h5');
$phpunit->assertEquals(array(), $board->_getAllPieceSquares('N', 'B'), 1);
echo 'tests done';
?>
--EXPECT--
tests done