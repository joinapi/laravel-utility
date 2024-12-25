<?php

namespace Joinbiz\Utility\Parser\Ofx;

use PHPUnit\Framework\TestCase;

class ParserServiceTest extends TestCase
{

    public function testLoadFromFile()
    {
        $parser = new ParserService();
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' .
                            DIRECTORY_SEPARATOR . '..' .
                            DIRECTORY_SEPARATOR . '..' .
                            DIRECTORY_SEPARATOR . 'fixtures/Extrato.ofx';

        $ofx = $parser->loadFromFile($path);

        $account =  count( $ofx->bankAccounts) > 0 ? $ofx->bankAccounts[0]->accountNumber : null ;

        echo 'Account: ' . $account . PHP_EOL;

        self::assertNotNull($account);
    }
}
