<?php

namespace App\Service\User;

use App\Repository\User\UserRepository;

class UserService
{
  public function checkUrlIsValidUsername(string $str, UserRepository $userRepository)
  {
    $strToExplode = explode('.', $str);
    if ($strToExplode === null || count($strToExplode) !== 2) return null;

    $userUrl = $userRepository->findDynamicUrl($strToExplode[0], $strToExplode[1]);
    if ($userUrl === null || count($userUrl) !== 1) return null;

    return $strToExplode;
  }
}
