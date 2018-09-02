<?php

namespace BL\QingStor;

class ObjectFile
{
    private $bucket;
    private $key;

    public function __construct(Bucket $bucket, $key)
    {
        $this->bucket = $bucket;
        $this->key = $key;
    }

    public function getServiceConfig()
    {
        return $this->bucket->getServiceConfig();
    }

    public function getBucketName()
    {
        return $this->bucket->getName();
    }

    public function getBucketZone()
    {
        return $this->bucket->getZone();
    }

    public function getHost()
    {
        $host = $this->getBucketZone().'.'.Config::BASE_HOST;
        return $host;
    }

    public function makeUri($path)
    {
        $uri = $this->getServiceConfig()->getProtocol() . '://';
        $uri .= $this->getHost();
        $uri .= '/' . $this->getBucketName();
        $uri .= '/' . $this->key;
        $uri .= $path;
        return $uri;
    }

    public function sendRequest(Request $request, array $options = [])
    {
        return $this->bucket->sendRequest($request, $options);
    }

    public function head()
    {
        $method = 'HEAD';
        $path   = '';

        $uri     = $this->makeUri($path);
        $request = new Request($method, $uri);
        return $this->sendRequest($request);
    }
}
