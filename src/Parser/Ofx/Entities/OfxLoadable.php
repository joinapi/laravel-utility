<?php
namespace Joinapi\Utility\Parser\Ofx\Entities;
use SimpleXMLElement;

interface OfxLoadable
{
    /**
     * Loads the data from the OFX XML node into the instance properties.
     * @param SimpleXMLElement $node
     * @return mixed
     */
    public function loadOfx(SimpleXMLElement $node);
}
