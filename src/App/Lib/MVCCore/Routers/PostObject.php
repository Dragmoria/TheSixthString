<?php

namespace Lib\MVCCore\Routers;

/**
 * Should only be created if the request is a POST request.
 * It is used to handle various POST request related tasks.
 * 
 * @package Lib\MVCCore
 */
class PostObject {
    /**
     * Can be use to flash the input data to the session. So we can give it back to the user if something goes wrong.
     *
     * @return void
     */
    public function flash(): void {
        $_SESSION['flash'] = [
            'body' => $this->body(),
            'files' => $this->files()
        ];
    }

    /**
     * Will return the old input data if it exists.
     *
     * @return array|null
     */
    public function old(): ?array {
        return $_SESSION['flash'] ?? null;
    }

    /**
     * Will return the old body of the input data if it exists.
     *
     * @return array|null
     */
    public function oldBody(): ?array {
        return $_SESSION['flash']['body'] ?? null;
    }

    /**
     * Will return the old files of the input data if it exists.
     *
     * @return array|null
     */
    public function oldFiles(): ?array {
        return $_SESSION['flash']['files'] ?? null;
    }

    /**
     * Will remove the flashed input data from the session.
     *
     * @return void
     */
    public function flush(): void {
        unset($_SESSION['flash']);
    }

    /**
     * Predicate to check if the post object has a file with the given key.
     *
     * @param string $key The key to check for.
     * @return boolean
     */
    public function hasFile(string $key): bool {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] == 0;
    }

    /**
     * Will return a file from a post with the given key if it exists.
     *
     * @param string $key The key of the file to get.
     * @return array|null
     */
    public function file(string $key): ?array {
        return $_FILES[$key] ?? null;
    }

    /**
     * Will return all files from the post object if there are any.
     *
     * @return array|null
     */
    public function files(): ?array {
        return $_FILES ?? null;
    }

    /**
     * Predicate to check if the post object wants json as a response.
     *
     * @return boolean
     */
    public function wantsJson(): bool {
        return isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
    }

    /**
     * Predicate to check if the post is an ajax request.
     *
     * @return boolean
     */
    public function isAjax(): bool {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Returns the body of the post request if there is any.
     *
     * @return array|null
     */
    public function body(): ?array {
        if ($this->isJson()) {
            $data = file_get_contents('php://input');
            
            return json_decode($data, true);
        }

        return $_POST ?? null;
    }

    /**
     * Predicate to check if the post request is json.
     *
     * @return boolean
     */
    public function isJson(): bool {
        return isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
    }
}