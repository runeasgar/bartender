<?php

// You are going to be seeing this alot.. think of it like a virtual file system.
namespace Drupal\bartender\Controller;

// Think of these like includes, except they use namespaces.

// This is how dependency injection is accomplished.
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;

class BartenderController {

  protected $user;

  // This is called when instantiating a new object - it's an OOP thing.
  public function __construct(AccountInterface $user) {
    $this->user = $user;
  }

  // This is the function that the routing system will use to request instantiation our object.
  public static function create(ContainerInterface $container) {

    // QQ According to core.services.yml this should work.. why doens't it?
    return new static($container->get('current_user'));

  }

  // This is a function that's going to deliver content for our home page.
  public function home() {

    // This is NOT using dependency injection. See above QQ.
    if ($this->user->isAuthenticated() == 1) {
      $content = array('#markup' => 'Authenticated placeholder.');
      return $content;
    } else {
      $content = array('#markup' => 'Anonymous placeholder.');
      return $content;
    }

  }
}