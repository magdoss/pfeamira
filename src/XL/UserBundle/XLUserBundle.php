<?php

namespace XL\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class XLUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
