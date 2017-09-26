<?php
/**
 * Created by PhpStorm.
 * User: santiagotoledobrokoli
 * Date: 20/09/17
 * Time: 13:12
 */

namespace Santiagotoledo91\SimpleSOAP;

class SimpleSOAP extends \SoapClient
{
    private $authentication;

    private $debugging = false;

    public function __construct()
    {
        $this->setAuthentication([
            'user' => config('simplesoap.user'),
            'key' => config('simplesoap.key')
        ]);

        parent::__construct(config('simplesoap.wsdl'), ['trace' => 1]);
    }

    /**
     * Overrides the __call magic method functionality in order to add authentication on every request
     *
     * @param string $function
     * @param string $parameters_array
     * @return mixed
     */
    public function __call($function, $parameters_array)
    {
        // Check if we are recieving a parameter object with an "all" method, if so, retrieves the input
        if (count($parameters_array) === 1 && is_object($parameters_array[0]) && method_exists($parameters_array[0], 'all')) {
            $parameters = $parameters_array[0]->all();
        } else {
            $parameters = [];
        }

        // Always set the authentication credentials
        $parameters['authentication'] = $this->getAuthentication();

        // Executes the function and returns the result
        return $this->__soapCall($function, [$parameters]);
    }


    /**
     *
     * Overwrites the default __doRequest functionality in order to add debugging capabilities
     *
     * @param string $request
     * @param string $location
     * @param string $action
     * @param int $version
     * @param int $one_way
     * @return string
     */
    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {

        // Check if we have to print the request XML
        if ($this->isPrintXML()) {
            // Prints the XML to the browser instead of making the request
            $doc = new \DOMDocument();
            $doc->preserveWhiteSpace = false;
            $doc->loadxml($request);
            $doc->formatOutput = true;
            $out = $doc->savexml();
            dd($out);
        } else {
            // Run the parent method normally
            return parent::__doRequest($request, $location, $action, $version, $one_way);
        }
    }

    /**
     * @return mixed
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * @param mixed $authentication
     */
    public function setAuthentication($authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @return bool
     */
    public function isDebugging()
    {
        return $this->debugging;
    }

    /**
     * @param bool $printXML
     */
    public function setDebugging($debugging)
    {
        $this->debugging = $debugging;
    }
}