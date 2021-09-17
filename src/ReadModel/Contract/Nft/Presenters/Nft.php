<?php
declare(strict_types=1);

namespace App\ReadModel\Contract\Nft\Presenters;


class Nft
{

    public string $id;
    public string $contract_address;
    public int $token_id;
    public array $token_data = [];

    public function __construct(string $id, string $contract_address, int $token_id, array $token_data)
    {

        $this->id = $id;
        $this->contract_address = $contract_address;
        $this->token_id = $token_id;
        $this->token_data = $token_data;
    }


    public function toArray():array
    {
        return (array)$this;
    }
}