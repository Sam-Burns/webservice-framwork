<?php
namespace KataApiSdk;

interface ApiClient
{
    public function varDumpThisForMe(string $path, string $method = 'GET');

    public function request(string $path, string $method) : array;
}
