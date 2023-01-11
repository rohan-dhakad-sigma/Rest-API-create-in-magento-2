<?php

namespace Sigma\CustomerApi\Api;

interface TestInterface
{
    /**
    * POST for test api
    * @param string[] $data
    * @return string
    */
    public function setData($data);
}