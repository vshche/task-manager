<?php

declare(strict_types=1);

namespace TaskManager\Application;

interface QueryBusInterface
{
    /**
     * @param object $query
     * @return mixed
     */
    public function query(object $query);
}
