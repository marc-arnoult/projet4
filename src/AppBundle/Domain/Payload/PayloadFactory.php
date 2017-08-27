<?php


namespace AppBundle\Domain\Payload;


class PayloadFactory
{
    /**
     * @param array $data
     * @return Created
     */
    public function created(array $data)
    {
        return new Created($data);
    }

    /**
     * @param array $data
     * @return BadRequest
     */
    public function badRequest(array $data)
    {
        return new BadRequest($data);
    }

    /**
     * @param array $data
     * @return Found
     */
    public function found(array $data)
    {
        return new Found($data);
    }

    /**
     * @param array $data
     * @return NotFound
     */
    public function notFound(array $data)
    {
        return new NotFound($data);
    }
}
