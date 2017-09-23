<?php

namespace Dhawton\LaravelLb;

use Dhawton\LaravelLb\LogicBoxes;

class LogicBoxesDomain extends LogicBoxes
{
    private $domainname = "";

	public function __construct($domainname='')
    {
        parent::__construct();

        $this->resource = "domains";
        $this->domainname = $domainname;

    }

    public function getDomainname()
    {
        return $this->domainname;
    }

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

    public function checkAvailability($domain, $tld, $suggestions = 'false')
    {
        $method = "available";
        $this->setAppends(['domain-name' => $domain, 'tlds' => $tld]);
        $response = $this->get($this->resource, $method, ['suggestions' => $suggestions]);
        return $this;
    }

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

    public function search($parameters)
    {
      $method = 'search';
      $response = $this->get($this->resource, $method, $parameters);
      return $this;
    }

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

    public function modifyContact(array $parameters) {
        $method = 'modify-contact';
        $this->post($this->resource, $method, $parameters);
        return $this;
    }

    public function renew($parameters) {
        $method = "renew";
        $this->post($this->resource, $method, $parameters);
    }
}
