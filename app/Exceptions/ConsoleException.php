<?php namespace Ox\Exceptions;

use Exception;
use Ox\Contracts\Exceptions\ConsoleException as ConsoleExceptionContract;

class ConsoleException extends Exception implements ConsoleExceptionContract
{
    private $exitCode;

    private $headers;

    /**
     * ConsoleException constructor.
     *
     * @param int $exitCode
     * @param string|null $message
     * @param \Exception|null $previous
     * @param array $headers
     * @param int code
     */
    public function __construct(
        int $exitCode, string $message = null, array $headers = [], \Exception $previous = null, ?int $code = 0
    ) {
        $this->exitCode = $exitCode;
        $this->headers = $headers;

        parent::__construct($message, $code, $previous);
    }

    public function getExitCode(): int
    {
        return $this->exitCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): ConsoleExceptionContract
    {
        $this->headers = $headers;

        return $this;
    }
}
