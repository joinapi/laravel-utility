<?php

namespace Joinapi\Utility\Parser\Ofx\Entities;
/**
 * Provides entity inspection for a variety of subclasses.
 */
interface Inspectable
{
    /**
     * Get a list of properties defined for this entity.
     * @return array array('prop_name' => 'prop_name', ...)
     */
    public function getProperties();
}
