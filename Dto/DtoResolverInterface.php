<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Symfony\Component\OptionsResolver\OptionsResolver;
use JsonSerializable;

interface DtoResolverInterface extends JsonSerializable
{
    /**
     * Inject custom resolver
     *
     * @param OptionsResolver $resolver
     */
    public function injectResolver(OptionsResolver $resolver): void;

    /**
     * Resolves received data into EntryDTO
     *
     * @param array $data
     */
    public function resolve(array $data): void;

    /**
     * Returns DTO properties as array
     *
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array;
}
