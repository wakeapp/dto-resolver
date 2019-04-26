<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function array_flip;
use function array_intersect_key;
use function array_keys;
use function get_object_vars;
use function lcfirst;
use function property_exists;
use function str_replace;
use function strpos;
use function ucwords;

trait DtoResolverTrait
{
    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param array $data
     * @param OptionsResolver|null $resolver
     *
     * @throws ExceptionInterface
     */
    public function __construct(array $data, ?OptionsResolver $resolver = null)
    {
        $resolver = $resolver ?? new OptionsResolver();
        $resolver->setDefined(array_keys($this->toArray(false)));

        $this->configureOptions($resolver);

        $this->optionsResolver = $resolver;

        $this->resolve($data);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array
    {
        $data = get_object_vars($this);

        unset($data['optionsResolver']);

        if ($onlyDefinedData) {
            return $this->getOnlyDefinedData($data);
        }

        return $data;
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function getOnlyDefinedData(array $data): array
    {
        return array_intersect_key($data, array_flip($this->getOptionResolver()->getDefinedOptions()));
    }

    /**
     * @return OptionsResolver
     */
    protected function getOptionResolver(): OptionsResolver
    {
        return $this->optionsResolver;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function normalizeDefinedKey(string $key): string
    {
        $needNormalization = false;

        if (strpos($key, '_') !== false) {
            $key = str_replace('_', ' ', $key);
            $needNormalization = true;
        }

        if (strpos($key, '-') !== false) {
            $key = str_replace('-', ' ', $key);
            $needNormalization = true;
        }

        if ($needNormalization) {
            $key = ucwords($key);
            $key = str_replace(' ', '', $key);
            $key = lcfirst($key);
        }

        return $key;
    }

    /**
     * @param array $data
     */
    protected function resolve(array $data): void
    {
        $normalizedData = [];

        foreach ($data as $propertyName => $value) {
            $normalizedPropertyName = $this->normalizeDefinedKey($propertyName);
            $normalizedData[$normalizedPropertyName] = $value;
        }

        $resolvedData = $this->getOptionResolver()->resolve($this->getOnlyDefinedData($normalizedData));

        foreach ($resolvedData as $propertyName => $value) {
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }
}
