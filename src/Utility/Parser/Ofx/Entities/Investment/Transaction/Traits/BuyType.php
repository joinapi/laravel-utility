<?php
namespace Joinbiz\Utility\Parser\Ofx\Entities\Investment\Transaction\Traits;
use SimpleXMLElement;

trait BuyType
{
    /**
     * Type of purchase: BUY, BUYTOCOVER
     * @var string
     */
    public $buyType;

    /**
     * @param SimpleXMLElement $node
     * @return $this for chaining
     */
    protected function loadBuyType(SimpleXMLElement $node)
    {
        $this->buyType = (string) $node->BUYTYPE;

        return $this;
    }
}
