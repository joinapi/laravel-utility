<?php

namespace Joinbiz\Utility\Parser\Ofx\Entities\Investment\Transaction;
/**
 * OFX 203 doc:
 * 13.9.2.4.3 Investment Buy/Sell Aggregates <INVBUY>/<INVSELL>
 *
 * Same as BUYSTOCK, plus <RELFITID> property.
 */
class BuyMutualFund extends BuyStock
{
    /**
     * @var string
     */
    public $nodeName = 'BUYMF';

    /**
     * RELFITID used to relate transactions associated with mutual fund exchanges.
     * @var string
     */
    public $relatedUniqueId;
}

