<?php declare(strict_types=1);

namespace App\Contracts;

interface LookupContract
{
    public function lookup();
    public function getUrl();
    public function getResponse($url);
}
