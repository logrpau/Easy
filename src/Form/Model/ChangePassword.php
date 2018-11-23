<?php

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
     private $oldPassword;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Password should by at least 6 chars long"
     * )
     */
     private $newPassword;

     public function setOldPassword(string $password)
     {
         $this->oldPassword = $password;
     }

     public function getOldPassword(): ?string
     {
        return $this->oldPassword;
    }

    public function setNewPassword(string $password)
     {
         $this->newPassword = $password;
     }

     public function getNewPassword(): ?string
     {
        return $this->newPassword;
    }
}