<?php

namespace EmailTemplates;

class MailTemplate
{
    public string $to;

    public string $subject;

    public Mail $body;

    public MailFrom $from;

    public function __construct(string $to, string $subject, Mail $body, MailFrom $from)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->from = $from;
    }
}
