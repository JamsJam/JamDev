<?php

namespace App\Message;

class MailNotification
{
    private string $subject;
    private string $to;
    private string $from;
    private string $template;
    private array  $parameters;
    

    /**
     * MailNotification constructor.
     * @param string $subject
     * @param string $to
     * @param string $from
     * @param string $template
     */
    public function __construct(string $subject, string $to, string $from, string $template, array $parameters)
    {
        $this->subject = $subject;
        $this->to = $to;
        $this->from = $from;
        $this->template = $template;
        $this->parameters= $parameters;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}