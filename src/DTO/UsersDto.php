<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Users;
use Doctrine\Common\Annotations\Annotation\Required;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class UsersDto extends AbstractDto  {

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="250")
     */
    public $firstname;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="250")
     */
    public $lastname;

    /**
     * @var string
     * @Assert\Regex("/^([0-9]{2} ){4}[0-9]{2}/")
     */
    public $phone;

    /**
     * @var string
     * @Assert\NotBlank(groups={"add"})
     */
    public $password;

    /**
     * @var string
     * @Assert\NotBlank(groups={"add"})
     */
    public $passwordConfirm;


    /**
     * @var string
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    public $email;


    /**
     * @param Users $users
     */
    public function setFromEntity(AbstractEntity $user): void {
        $this->firstname = $user->getFirstname();
        $this->lastname = $user->getLastname();
        $this->email = $user->getEmail();
        $this->phone = $user->getPhone();
    }
}
