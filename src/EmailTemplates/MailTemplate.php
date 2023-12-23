<?php

namespace EmailTemplates;

class MailTemplate
{
    private string $templatePath;

    private array $data;

    public function __construct(string $templatePath, array $data = [])
    {
        $this->templatePath = $templatePath;
        $this->data = $data;
    }

    public function render(): string
    {
        extract($this->data);

        ob_start();

        include $this->templatePath;

        return ob_get_clean();
    }
}
