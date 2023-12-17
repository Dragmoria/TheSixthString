<?php

namespace Models;

class MediaElementModel
{
    public function __construct(string $title, string $url)
    {
        $this->title = $title;
        $this->url = $url;
    }
    public string $title = "";
    public string $url = "";
}
