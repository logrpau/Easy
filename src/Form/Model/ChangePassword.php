<?php

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Contraseña actual incorrecta"
     * )
     */
     private $oldPassword;

    /**
     *@Assert\Length(
     *      min = 6,
     *      max = 30,
     *      minMessage = "La contraseña debe tener mínimo {{ limit }} caracteres",
     *      maxMessage = "La logitud de la contraseña no puede ser mayor a {{ limit }} caracteres"
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