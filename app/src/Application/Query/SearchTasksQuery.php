<?php

declare(strict_types=1);

namespace TaskManager\Application\Query;

/**
 * @see SearchTasksQueryHandler
 */
final class SearchTasksQuery
{
    /**
     * @var string|null
     */
    private ?string $status;

    /**
     * @param string|null $status
     */
    public function __construct(string $status = null)
    {
        $this->status = $status;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self($data['status'] ?? null);
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return self
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
