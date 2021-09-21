<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SignUp\ByMetamask;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $wallet;
}
