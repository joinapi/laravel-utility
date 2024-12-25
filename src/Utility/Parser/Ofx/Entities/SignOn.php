<?php
namespace Joinbiz\Utility\Parser\Ofx\Entities;

class SignOn extends AbstractEntity
{
    /**
     * @var Status
     */
    public $status;

    /**
     * @var \DateTimeInterface
     */
    public $date;

    /**
     * @var string
     */
    public $language;

    /**
     * @var Institute
     */
    public $institute;
}
