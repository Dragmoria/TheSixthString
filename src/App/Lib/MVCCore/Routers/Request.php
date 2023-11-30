<?php

namespace Lib\MVCCore\Routers;

/**
 * Request class. Used as a way to get easy access to all data important to the request. 
 * Enforced singleton pattern.
 * 
 * @package Lib\MVCCore
 */
class Request {
    private static ?Request $instance = null;

    private function __construct() {
    }

    /**
     * Get the instance of the request object. Will create a new one if one does not exist. Will add a post object if the request is a post request.
     *
     * @return Request The request object.
     */
    public static function getInstance(): Request {
        if (self::$instance === null) {
            self::$instance = new Request();

            
            self::$instance->postObject = new PostObject();
        }

        return self::$instance;
    }

    /**
     * Object containing all the post data if the request is a post request.
     *
     * @var PostObject|null null if the request is not a post request.
     */
    private readonly ?PostObject $postObject;

    /**
     * Predicate to check if the request is a post request and has a post object.
     *
     * @return boolean
     */
    public function hasPostObject(): bool {
        return isset($this->postObject);
    }

    /**
     * Gets the post object of the current request.
     *
     * @return PostObject|null null if the request is not a post request.
     */
    public function getPostObject(): ?PostObject {
        return $this->postObject;
    }

    /**
     * Will return the path of the current request.
     * In case of http://localhost:8080/contact?id=3 it will return /contact
     * @return string
     */
    public function path(): string {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Will return the full url of the current request.
     * In case of http://localhost:8080/contact?id=3 it will return http://localhost:8080/contact?id=3
     * @return string
     */
    public function fullUrl(): string {
        return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    /**
     * Will return the url of the current request.
     * In case of http://localhost:8080/contact?id=3 it will return http://localhost:8080/contact
     * @return string
     */
    public function url(): string {
        return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}" . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Returns the request method type of the current request.
     *
     * @return RequestTypes
     */
    public function method(): RequestTypes {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->postObject->body() !== null) {
                return RequestTypes::from($this->postObject->body()['_method'] ?? $_SERVER['REQUEST_METHOD']);
            }
        }

        return RequestTypes::GET;
    }

    /**
     * Will return the value of the given key in the http header object.
     *
     * @param string $key The key to get the value of.
     * @return string|null null if the key does not exist.
     */
    public function header(string $key): ?string {
        $key = strtoupper($key);
        $key = "HTTP_" . $key;

        return $_SERVER[$key] ?? null;
    }

    /**
     * Predicate to check if the given key exists in the http header object.
     *
     * @param string $key
     * @return boolean
     */
    public function hasHeader(string $key): bool {
        $key = strtoupper($key);
        $key = "HTTP_" . $key;

        return isset($_SERVER[$key]);
    }

    /**
     * Will return all headers in the http header object.
     *
     * @return array
     */
    public function allHeaders(): array {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == "HTTP_") {
                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    /**
     * Will return a cookie of a specific key.
     *
     * @param string $key The key of the cookie to get.
     * @return string|null null if the cookie does not exist.
     */
    public function cookie(string $key): ?string {
        return $_COOKIE[$key] ?? null;
    }

    /**
     * Predicate to check if a cookie of a specific key exists.
     *
     * @param string $key The key of the cookie to check.
     * @return boolean
     */
    public function hasCookie(string $key): bool {
        return isset($_COOKIE[$key]);
    }

    /**
     * Will return all cookies.
     *
     * @return array
     */
    public function allCookies(): array {
        return $_COOKIE;
    }

    /**
     * Will return all query params in the url.
     *
     * @return array An associative array of all query params. Empty if there are none.
     */
    public function urlQueryParams(): array {
        $queryString = parse_url($this->fullUrl(), PHP_URL_QUERY);
        $queryParams = [];
        if ($queryString !== null) {
            parse_str($queryString, $queryParams);
        }
        return $queryParams;
    }

    /**
     * Predicate to check if the post object wants json as a response.
     *
     * @return boolean
     */
    public function wantsJson(): bool {
        return isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
    }
}