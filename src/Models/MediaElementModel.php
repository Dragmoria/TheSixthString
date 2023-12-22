<?php

namespace Models;

class MediaElementModel {
    public function __construct(string $title, string $url) {
        $this->title = $title;
        $this->url = !empty($url) ? $url : null;
    }
    public string $title = "";
    public ?string $url = null;
}
