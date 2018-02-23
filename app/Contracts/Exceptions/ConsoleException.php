<?php namespace Ox\Contracts\Exceptions;

use Symfony\Component\Console\Exception\ExceptionInterface;

interface ConsoleException extends ExceptionInterface
{
    /**
     * Returns the exit code.
     *
     * @return int
     */
    public function getExitCode(): int;

    /**
     * Returns the headers.
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Sets the headers.
     *
     * @param array $headers
     *
     * @return ConsoleException
     */
    public function setHeaders(array $headers): ConsoleException;
}
