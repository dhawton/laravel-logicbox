<?php

namespace Dhawton\LaravelLb;

use Dhawton\LaravelLb\LogicBoxes;

class LogicBoxesContact extends LogicBoxes {

    public $resource;

	public function __construct()
    {
        parent::__construct();

        $this->resource = "contacts";
    }


    /**
     * Getting list of the Contacts using Customer Id .
     * https://manage.netearthone.com/kb/answer/793
     *
     * @param LogicBoxesContact
     * @return $this
     */
    public function search($parameters)
    {
      $method = 'search';
      $response = $this->get($this->resource, $method, $parameters);
      return $this;
    }

    /**
     * Getting Details of the Contact using Contact Id .
     * https://manage.netearthone.com/kb/answer/792
     *
     * @param LogicBoxesContact
     * @return $this
     */
    public function details($contactId)
    {
        $method = 'details';
        $variables = [
            "contact-id" => $contactId,
        ];

        $response = $this->get($this->resource, $method, $variables);
        return $this;
    }

    /* Add new contact
     * @return Dhawton\LaravelLb\LogicBoxes
     */
    public function add($variables) {
        $method = "add";
        $variables = $this->encodeVariables($variables);

        return $this->post($this->resource, $method, $variables);
    }
}
