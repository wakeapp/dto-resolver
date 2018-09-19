<?php

declare(strict_types=1);

namespace Wakeapp\Component\DtoResolver\Dto;

use JsonSerializable;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractDtoResolver implements DtoResolverInterface, JsonSerializable
{
    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * {@inheritdoc}
     *
     * @return self
     */
    public function injectResolver(OptionsResolver $resolver): self
    {
        $this->optionsResolver = $resolver;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     *
     * @return self
     */
    public function resolve(array $data): self
    {
        $resolver = $this->getOptionsResolver();
        $resolvedData = $resolver->resolve($this->getOnlyDefinedData($data));

        foreach ($resolvedData as $propertyName => $value) {
            $propertyName = $this->normalizeDefinedKey($propertyName);

            $this->$propertyName = $value;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
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
     * @param OptionsResolver $options
     */
    protected function configureOptions(OptionsResolver $options): void
    {
        $options->setDefined(array_keys($this->toArray(false)));
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

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->optionsResolver = $resolver;

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
