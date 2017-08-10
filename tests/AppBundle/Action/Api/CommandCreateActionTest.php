<?php

namespace Test\AppBundle\Action\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandCreateActionTest extends WebTestCase
{
    public function testCreateCommand()
    {
        $client = static::createClient();
        $client->request('POST',
            '/api/command',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '[{
              "first_name": "marc",
              "last_name": "Do lugar",
              "birthday": "2017-08-09",
              "country": "France",
              "reduction": false,
              "price": 10,
              "type": "Journée",
              "entry_at": "2017-08-20"
            },{
              "first_name": "marc",
              "last_name": "Do lugar",
              "birthday": "2017-08-09",
              "country": "France",
              "reduction": false,
              "price": 10,
              "type": "Journée",
              "entry_at": "2017-08-20"
            }]'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testCreateBadCommand()
    {
        $client = static::createClient();
        $client->request('POST',
            '/api/command',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '[{
              "first_name": "",
              "last_name": "Do lugar",
              "birthday": "2017-08-09",
              "country": "France",
              "reduction": false,
              "price": 10,
              "type": "Journée",
              "entry_at": "2017-08-20"
            },{
              "first_name": "marc",
              "last_name": "Do lugar",
              "birthday": "2017-08-09",
              "country": "France",
              "reduction": false,
              "price": 10,
              "type": "Journée",
              "entry_at": "2017-08-20"
            }]'
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
