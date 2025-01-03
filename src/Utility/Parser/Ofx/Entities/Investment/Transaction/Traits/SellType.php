<?php

namespace Joinbiz\Utility\Parser\Ofx\Entities\Investment\Transaction\Traits;

use SimpleXMLElement;

trait SellType
{
    /**
     * Type of sell. SELL, SELLSHORT
     * @var string
     */
    public $sellType;

    /**
     * @param SimpleXMLElement $node
     * @return $this for chaining
     */
    protected function loadSellType(SimpleXMLElement $node)
    {
        $this->sellType = (string) $node->SELLTYPE;

        return $this;
    }
}
