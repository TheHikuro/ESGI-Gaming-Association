<?php

namespace App\Tests\Unit\Controller\Admin;

use App\Service\User\UserService;
use PHPUnit\Framework\TestCase;

class ProfileControllerTest extends TestCase
{
  // ...

  public function test()
  {
    $this->assertArrayHasKey('bar', ['bar' => 'baz']);
  }
}
