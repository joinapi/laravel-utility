<?php
namespace Joinbiz\Utility\Parser\Ofx\Entities\Investment;

use Joinbiz\Utility\Parser\Ofx\Entities\Investment;

class Account extends Investment
{
    /**
     * @var string
     */
    public $accountNumber;

    /**
     * @var string
     */
    public $brokerId;

    /**
     * @var Statement
     */
    public $statement;

    /**
     * @var string
     */
    public $transactionUid;

}
