<?php
namespace Joinbiz\Utility\Parser\Ofx\Entities;
use Joinbiz\Utility\Parser\Ofx\Entities\AbstractEntity;

class AccountInfo extends AbstractEntity
{
    /**
     * @var string
     */
    public $desc;

    /**
     * @var string
     */
    public $number;
}
