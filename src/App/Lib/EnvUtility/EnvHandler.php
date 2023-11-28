<?php

namespace Lib\EnvUtility;

/**
 * Class used to help with getting environment variables.
 * 
 * @package Lib\EnvUtility
 */
class EnvHandler {
    /**
     * Creates a new instance of the EnvHandler class.
     *
     * @param string $envFilePath The path to the .env file.
     */
    public function __construct(string $envFilePath) {
        $this->loadEnvFile($envFilePath);
    }

    /**
     * Loads the .env file.
     *
     * @param string $envFilePath The path to the .env file.
     * @throws \InvalidArgumentException Thrown if the .env file does not exist.
     */
    private function loadEnvFile(string $envFilePath) {
        if (!file_exists($envFilePath)) {
            throw new \InvalidArgumentException("File {$envFilePath} does not exist");
        }

        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comment lines
            }

            list($name, $value) = explode('=', $line, 2);
            putenv(sprintf('%s=%s', $name, $value));
        }
    }

    /**
     * Gets the value of an environment variable.
     *
     * @param string $envVarName The name of the environment variable.
     * @return string|null Returns the value of the environment variable if it exists, otherwise null.
     */
    public function getEnv(string $envVarName) : ?string {
        return getenv($envVarName) ?? null;
    }
}