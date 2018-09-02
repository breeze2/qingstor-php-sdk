<?php

namespace BL\QingStor;

class ObjectFile
{
    const BASE_HOST = 'qingstor.com';

    private $access_key_id     = '';
    private $secret_access_key = '';
    private $default_bucket    = '';
    private $default_zone      = '';
    private $protocol          = 'https';

    public function __construct($access_key_id, $secret_access_key, array $options = [])
    {
        $this->access_key_id     = $access_key_id;
        $this->secret_access_key = $secret_access_key;
        if (array_key_exists('bucket', $options)) {
            $this->default_bucket = $options['bucket'];
        }
        if (array_key_exists('zone', $options)) {
            $this->default_zone = $options['zone'];
        }
        if (array_key_exists('protocol', $options)) {
            $this->protocol = $options['protocol'];
        }
    }

    public function getAccessKeyId()
    {
        return $this->access_key_id;
    }

    public function getSecretAccessKey()
    {
        return $this->secret_access_key;
    }

    public function getDefaultBucket()
    {
        return $this->default_bucket;
    }

    public function getDefaultZone()
    {
        return $this->default_zone;
    }
}
