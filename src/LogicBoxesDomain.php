<?php

namespace Dhawton\LaravelLb;

use Dhawton\LaravelLb\LogicBoxes;

/**
 * Class LogicBoxesDomain
 * @package Dhawton\LaravelLb
 */
class LogicBoxesDomain extends LogicBoxes
{
    /**
     * @var string
     */
    private $domainname = "";

    /**
     * LogicBoxesDomain constructor.
     * @param string $domainname
     */
    public function __construct($domainname='')
    {
        parent::__construct();

        $this->resource = "domains";
        $this->domainname = $domainname;

    }

    /**
     * @return string
     */
    public function getDomainname()
    {
        return $this->domainname;
    }

    /**
     * @param $domainname
     * @return $this
     */
    public function setDomainname($domainname)
    {
        $this->domainname = $domainname;
        return $this;
    }



    /**
     * Getting Details of the Domain Registration Order using Domain Name .
     * http://manage.netearthone.com/kb/answer/1755
     *
     * @param LogicBoxesReseller
     */
    public function details()
    {
        $method = 'details-by-name';
        $variables = [
            "domain-name" => $this->domainname,
            "options" => "All"

        ];

        $response = $this->get($this->resource, $method, $variables);
        return $this;
    }

    /**
     * @param $domain
     * @param $tld
     * @return $this
     */
    public function checkAvailability($domain, $tld)
    {
        $method = "available";
        $parameters = [
            "domain-name" => $domain,
            "tlds" => $tld,
            "suggestions" => "false"            // Doesn't work in API
        ];
        $response = $this->get($this->resource, $method, $parameters);
        return $this;
    }

    /**
     * @param $orderId
     * @return $this
     */
    public function detailsByOrderId($orderId)
    {
        $method = 'details';
        $variables = [
            "order-id" => $orderId,
            "options" => "All"
        ];

        $response = $this->get($this->resource, $method, $variables);
        return $this;
    }

    /**
     * @param $parameters
     * @return $this
     */
    public function search($parameters)
    {
      $method = 'search';
      $response = $this->get($this->resource, $method, $parameters);
      return $this;
    }

    /**
     * @param $orderId
     * @param $nameServers
     * @return $this
     */
    public function modifyNs($orderId, $nameServers)
    {
        $method = 'modify-ns';

        $parameters = [
            'order-id' => $orderId,
        ];

        $this->setAppends(['ns' => $nameServers]);

        $this->post($this->resource, $method, $parameters);

        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function modifyContact(array $parameters) {
        $method = 'modify-contact';
        $this->post($this->resource, $method, $parameters);
        return $this;
    }

    /**
     * @param array $parameters
     * @return \Dhawton\LaravelLb\LogicBoxes
     */
    public function renew(array $parameters) {
        $method = "renew";
        return $this->post($this->resource, $method, $parameters);
    }


    /**
     * @param string $keyword
     * @param bool $exactMatch
     * @return \Dhawton\LaravelLb\LogicBoxes
     */
    public function suggestions(string $keyword, bool $exactMatch = false) {
        $parameters = [
            'keyword' => $keyword,
            'exact-match' => $exactMatch
        ];
        $method = 'v5/suggest-names';
        return $this->get($this->resource, $method, $parameters);
    }

    /**
     * @param string $domain
     * @param array|string $nameservers
     * @param array $parameters
     *
     * @return \Dhawton\LaravelLb\LogicBoxes
     */
    public function register(string $domain, $nameservers, array $parameters) {
        $method = "register";
        $parameters['domain-name'] = $domain;
        $this->setAppends(['ns' => $nameservers]);
        return $this->post($this->resource, $method, $parameters);
    }

    /**
     * @param int           $orderId
     * @param string        $cns
     * @param string|array  $ip
     *
     * @return \Dhawton\LaravelLb\LogicBoxes
     */
    public function addChildNameServer(int $orderId, string $cns, $ip) {
        $method = "add-cns";
        $this->setAppends(['ip' => $ip]);
        $parameters = [
            'order-id' => $orderId,
            'cns' => $cns
        ];
        return $this->post($this->resource, $method, $parameters);
    }

    /**
     * @param int           $orderId
     * @param string        $cns
     * @param string|array  $ip
     *
     * @return \Dhawton\LaravelLb\LogicBoxes
     */
    public function deleteChildNameServer(int $orderId, string $cns, $ip) {
        $method = "delete-cns-ip";
        $parameters = [
            'order-id' => $orderId,
            'cns' => $cns
        ];
        $this->setAppends(['ip' => $ip]);
        return $this->post($this->resource, $method, $parameters);
    }

    /**
     * @param int    $orderId
     * @param string $oldCns
     * @param string $newCns
     *
     * @return \Dhawton\LaravelLb\LogicBoxes
     */
    public function modifyChildNameServerName(int $orderId, string $oldCns, string $newCns) {
        $parameters = [
            'order-id' => $orderId,
            'old-cns' => $oldCns,
            'new-cns' => $newCns
        ];
        $method = 'modify-cns-name';
        return $this->post($this->resource, $method, $parameters);
    }

    /**
     * @param int    $orderId
     * @param string $cns
     * @param string $oldip
     * @param string $newip
     *
     * @return \Dhawton\LaravelLb\LogicBoxes
     */
    public function modifyChildNameServerIps(int $orderId, string $cns, string $oldip, string $newip) {
        $method = 'modify-cns-ip';
        $parameters = [
            'order-id' => $orderId,
            'cns' => $cns,
            'old-ip' => $oldip,
            'new-ip' => $newip
        ];
        return $this->post($this->resource, $method, $parameters);
    }
}
