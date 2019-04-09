<?php

namespace Sari\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SariUserBundle extends Bundle
{
    # Surcharge de FOSUserBundle
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
