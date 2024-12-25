<?php
namespace Joinbiz\Utility\Parser\Ofx\Entities;
class Statement extends AbstractEntity
{
    /**
     * @var string
     */
    public $currency;

    /**
     * @var Transaction[]
     */
    public $transactions;

    /**
     * @var \DateTimeInterface
     */
    public $startDate;

    /**
     * @var \DateTimeInterface
     */
    public $endDate;
}
