<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Core\Response;

use Bitrix24\SDK\Core\Response\DTO;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class Response
 *
 * @package Bitrix24\SDK\Core\Response
 */
class Response
{
    /**
     * @var ResponseInterface
     */
    protected $httpResponse;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Response constructor.
     *
     * @param ResponseInterface $httpResponse
     * @param LoggerInterface   $logger
     */
    public function __construct(ResponseInterface $httpResponse, LoggerInterface $logger)
    {
        $this->httpResponse = $httpResponse;
        $this->logger = $logger;
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }

    /**
     * @return DTO\Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getResponse(): DTO\Response
    {
        $resultString = $this->httpResponse->getContent();

        try {
            $result = json_decode($resultString, true, 512, JSON_THROW_ON_ERROR);

            return new DTO\Response(
                new DTO\Result($result['result']),
                new DTO\Time(
                    $result['time']['start'],
                    $result['time']['finish'],
                    $result['time']['duration'],
                    $result['time']['processing'],
                    new \DateTimeImmutable($result['time']['date_start']),
                    new \DateTimeImmutable($result['time']['date_finish'])
                )
            );
        } catch (\JsonException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}