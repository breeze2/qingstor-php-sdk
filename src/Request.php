<?php

namespace BL\QingStor;

use GuzzleHttp\Psr7\Request as Psr7Request;

class Request extends Psr7Request
{
	public function __construct($method, $uri, array $headers = [], $body = null, $version = '1.1')
	{
		array_key_exists('Date', $headers) ? null : $headers['Date'] = gmdate('D, d M Y H:i:s T');
		array_key_exists('Content-Type', $headers) ? null : $headers['Content-Type'] = 'application/octet-stream';
		parent::__construct($method, $uri, $headers, $body, $version);
	}

    public function getDate()
    {
        return $this->getHeaderLine('Date');
    }

    public function getContentMD5()
    {
        return $this->getHeaderLine('Content-MD5');
    }

    public function getContentType()
    {
        return $this->getHeaderLine('Content-Type');
    }

    public function getCanonicalizedHeaders()
    {
        $header = $this->getHeaders();
        $keys   = array();
        foreach ($header as $key => $value) {
            if (!strncasecmp(strtolower($key), 'x-qs-', 5)) {
                $keys[trim(strtolower($key))] = trim($value[0]);
            }
        }
        ksort($keys);
        $canonicalizedHeaders = '';
        if (count($keys) > 0) {
            foreach ($keys as $key => $value) {
                $canonicalizedHeaders = $canonicalizedHeaders . $key . ':' . $value . "\n";
            }
        }

        return $canonicalizedHeaders;
    }

    public function getCanonicalizedResource()
    {
        $uri   = $this->getUri();
        $path  = $uri->getPath();
        $query = explode('&', $uri->getQuery());
        $keys  = array();
        foreach ($query as $values) {
            $values = explode('=', $values);
            if ($this->isSubResource($values[0])) {
                if (count($values) > 1) {
                    $keys[] = $values[0] . '=' . urldecode($values[1]);
                } else {
                    $keys[] = $values[0];
                }
            }
        }
        sort($keys);
        $joinedKeys = implode('&', $keys);
        if ($joinedKeys !== '') {
            $path = $path . '?' . $joinedKeys;
        }

        return $path;
    }

    public function isSubResource($key)
    {
        $keysMap = array(
            'acl',
            'cors',
            'delete',
            'mirror',
            'part_number',
            'policy',
            'stats',
            'upload_id',
            'uploads',
            'response-expires',
            'response-cache-control',
            'response-content-type',
            'response-content-language',
            'response-content-encoding',
            'response-content-disposition',
            'image',
            'lifecycle',
            'notification',
        );

        return in_array($key, $keysMap);
    }
}
