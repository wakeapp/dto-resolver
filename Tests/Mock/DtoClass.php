<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Tests\Mock;

use Wakeapp\Component\DtoResolver\Dto\DtoResolverInterface;
use Wakeapp\Component\DtoResolver\Dto\DtoResolverTrait;

class DtoClass implements DtoResolverInterface
{
    use DtoResolverTrait;

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
