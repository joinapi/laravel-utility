<?php
namespace Joinapi\Utility\Parser\Ofx\Entities;
use Joinapi\Utility\Parser\Ofx\Entities\AbstractEntity;

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
