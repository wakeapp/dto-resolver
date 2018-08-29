<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Symfony\Component\OptionsResolver\OptionsResolver;

interface DtoResolverInterface
{
    /**
     * Inject custom resolver
     *
     * @param OptionsResolver $resolver
     */
    public function injectResolver(OptionsResolver $resolver);

    /**
     * Resolves received data into EntryDTO
     *
     * @param array $data
     */
    public function resolve(array $data);

    /**
     * Returns DTO properties as array
     *
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array;
}
