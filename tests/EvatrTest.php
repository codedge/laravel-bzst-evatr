<?php

namespace packages\codedge\evatr\tests;

use Codedge\Evatr\Evatr;
use Orchestra\Testbench\TestCase;

/**
 * EvatrTest.php.
 *
 * @author Holger Lösken <holger.loesken@codedge.de>
 * @copyright See LICENSE file that was distributed with this source code.
 */
class EvatrTest extends TestCase
{
    public function testQuery()
    {
        $evatr = new Evatr();
        $evatr->setOwnUstId('DE185786214');
        $evatr->setForeignUstId('CZ25931610');
        $evatr->setCompanyName('TestCompany Inc.');
        $evatr->setStreet('Buzulucká 786');
        $evatr->setZipCode('50003');
        $evatr->setCity('HRADEC KRÁLOVÉ');
        $evatr->setPrintConfirmation(false);

        $evatr->query();
        $this->assertInstanceOf('Codedge\Evatr\EvatrXmlResponse', $evatr->getResponse());
        $this->assertInstanceOf('PhpXmlRpc\Response', $evatr->getPlainResponse());

        $this->assertSame('DE185786214', $evatr->getResponse()->getOwnUstId());
        $this->assertSame('CZ25931610', $evatr->getResponse()->getForeignUstId());
        $this->assertSame('TestCompany Inc.', $evatr->getResponse()->getCompanyName());
        $this->assertSame('Buzulucká 786', $evatr->getResponse()->getStreet());
        $this->assertSame('HRADEC KRÁLOVÉ', $evatr->getResponse()->getCity());
        $this->assertSame('50003', $evatr->getResponse()->getZipCode());
        $this->assertFalse($evatr->getResponse()->getPrintConfirmation());

        $this->assertSame('A', $evatr->getResponse()->getResponseCity());
        $this->assertSame('B', $evatr->getResponse()->getResponseStreet());
        $this->assertSame('B', $evatr->getResponse()->getResponseZipCode());
        $this->assertSame('B', $evatr->getResponse()->getResponseCompanyName());

        $this->assertSame(200, $evatr->getResponse()->getErrorCode());
    }
}
