<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Serializer;

use FOS\RestBundle\Serializer\Normalizer\FlattenExceptionNormalizer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ValidationFailedExceptionNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private FlattenExceptionNormalizer $fosRestExceptionNormalizer;

    /**
     * @param FlattenExceptionNormalizer $fosRestExceptionNormalizer
     */
    public function __construct(FlattenExceptionNormalizer $fosRestExceptionNormalizer)
    {
        $this->fosRestExceptionNormalizer = $fosRestExceptionNormalizer;
    }

    /**
     * @param FlattenException $object
     * @param string|null $format
     * @param array $context
     *
     * @throws ExceptionInterface
     *
     * @return array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = $this->fosRestExceptionNormalizer->normalize($object, $format, $context);

        if (isset($context['exception']) && $context['exception'] instanceof ValidationFailedException) {
            $data = $this->normalizer->normalize($context['exception']->getViolations());
        }

        return $data;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     *
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->fosRestExceptionNormalizer->supportsNormalization($data, $format);
    }
}
