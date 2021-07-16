<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Tests\Mock;

use ArrayAccess;
use Wakeapp\Component\DtoResolver\Dto\DtoArrayAccessTrait;
use Wakeapp\Component\DtoResolver\Dto\DtoResolverInterface;
use Wakeapp\Component\DtoResolver\Dto\DtoResolverTrait;

class DtoClass implements DtoResolverInterface, ArrayAccess
{
    use DtoResolverTrait;
    use DtoArrayAccessTrait;

    public $publicProperty;
    protected $protectedProperty;
    private $privateProperty;

    public function getPublicProperty()
    {
        return $this->publicProperty;
    }

    public function getProtectedProperty()
    {
        return $this->protectedProperty;
    }

    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }
}
