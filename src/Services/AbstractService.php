<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services;

use Bitrix24\SDK\Core\Contracts\BatchInterface;
use Bitrix24\SDK\Core\Contracts\CoreInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractService
 *
 * @package Bitrix24\SDK\Services
 */
abstract class AbstractService
{
    protected BatchInterface $batch;
    protected CoreInterface $core;
    protected LoggerInterface $log;

    /**
     * AbstractService constructor.
     *
     * @param CoreInterface   $core
     * @param BatchInterface  $batch
     * @param LoggerInterface $log
     */
    public function __construct(CoreInterface $core, BatchInterface $batch, LoggerInterface $log)
    {
        $this->core = $core;
        $this->batch = $batch;
        $this->log = $log;
    }
}