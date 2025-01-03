<?php
namespace Joinbiz\Utility\Parser\Ofx\Entities\Investment\Transaction;

use SimpleXMLElement;

/**
 * OFX 203 doc:
 * 13.9.2.4.3 Investment Buy/Sell Aggregates <INVBUY>/<INVSELL>
 *
 * Properties found in the <INVBUY> aggregate.
 * Used for "other securities" BUY activities and provides the 
 * base properties to extend for more specific activities.
 *
 * Required:
 * <INVTRAN> aggregate
 * <SECID> aggregate
 * <UNITS>
 * <UNITPRICE>
 * <TOTAL>
 * <SUBACCTSEC>
 * <SUBACCTFUND>
 *
 * Optional:
 * ...many...
 *
 * Partial implementation.
 */
class BuySecurity extends Investment
{
    /**
     * Traits used to define properties
     */
    use InvTran;
    use SecId;
    use Pricing;

    /**
     * @var string
     */
    public $nodeName = 'BUYOTHER';

    /**
     * Imports the OFX data for this node.
     * @param SimpleXMLElement $node
     * @return $this
     */
    public function loadOfx(SimpleXMLElement $node)
    {
        // Transaction data is nested within <INVBUY> child node
        $this->loadInvTran($node->INVBUY->INVTRAN)
            ->loadSecId($node->INVBUY->SECID)
            ->loadPricing($node->INVBUY);

        return $this;
    }
}

