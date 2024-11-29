<?php
class BaseContrller
{
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    protected function getUriSegements()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);

        return $uri;
    }

    protected function getQueryStringParams($query)
    {
        return pause_str($_SERVER['QUERY_STRING'], $query);
    }

    protected function sendOutput($data, $httpHeaders = array())
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders) > 0) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
    }
}
?>