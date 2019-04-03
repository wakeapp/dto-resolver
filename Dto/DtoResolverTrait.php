<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use Symfony\Component\OptionsResolver\OptionsResolver;

trait DtoResolverTrait
{
    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param OptionsResolver $resolver
     */
    public function injectResolver(OptionsResolver $resolver): void
    {
        $this->optionsResolver = $resolver;
        $this->optionsResolver->setDefined(array_keys($this->toArray(false)));
        $this->configureOptions($this->optionsResolver);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @param array $data
     */
    public function resolve(array $data): void
    {
        $resolver = $this->getOptionsResolver();

        $normalizedData = [];

        foreach ($data as $propertyName => $value) {
            $normalizedPropertyName = $this->normalizeDefinedKey($propertyName);
            $normalizedData[$normalizedPropertyName] = $value;
        }

        $resolvedData = $resolver->resolve($this->getOnlyDefinedData($normalizedData));

        foreach ($resolvedData as $propertyName => $value) {
            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }
    }

    /**
     * @param bool $onlyDefinedData
     *
     * @return array
     */
    public function toArray(bool $onlyDefinedData = true): array
    {
        $data = get_object_vars($this);

        if ($onlyDefinedData) {
            return $this->getOnlyDefinedData($data);
        }

        unset($data['optionsResolver']);

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
        return array_intersect_key($data, array_flip($this->getOptionsResolver()->getDefinedOptions()));
    }

    /**
     * @return OptionsResolver
     */
    protected function getOptionsResolver(): OptionsResolver
    {
        if (null !== $this->optionsResolver) {
            return $this->optionsResolver;
        }

        $this->optionsResolver = new OptionsResolver();
        $this->optionsResolver->setDefined(array_keys($this->toArray(false)));
        $this->configureOptions($this->optionsResolver);

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
}
