<?php

namespace EmailTemplates;

enum MailFrom: string
{
    case NOREPLY = "noreply@thesixthstring.store";
    case ADMIN = "Beheerder@sixthstring.onmicrosoft.com";

    public function getName(): string
    {
        return match ($this) {
            self::NOREPLY => 'NOREPLY',
            self::ADMIN => 'ADMIN',
        };
    }
}
