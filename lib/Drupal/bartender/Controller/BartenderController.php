<?php

/* LEARN THIS!
Namespaces
  These are akin to virtual file directories, allowing you to decouple file storage from referencing.
  http://www.sitepoint.com/php-53-namespaces-basics */

namespace Drupal\bartender\Controller;

/* LEARN THIS!
Use Statements
  Similar to include() or require_once(), but they utilize namespaces.
  In many cases, failing to "use" something is why your code isn't working as expected.
  http://us3.php.net/manual/en/language.namespaces.importing.php */

// This provides us with an object type for the parameter in our create function.
use Symfony\Component\DependencyInjection\ContainerInterface;
// This apparently actually provides the container object for the parameter in the create function.
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
// This is the object type that we're grabbing from the container.
use Drupal\Core\Session\UserSession;

/* LEARN THIS!
OOP: Classes, Properties, Methods, Interfaces, Abstraction
  If you haven't read up on classes, read these. They'll be relevant to a LOT of what you see here.
  http://www.lornajane.net/posts/2012/introduction-to-php-oop
  http://www.lornajane.net/posts/2012/a-little-more-oop-in-php */

/* LEARN THIS!
Interfaces
  An interface is like a required blueprint for a class. It will contain functions that an implementing class
    MUST implement. */

/* LEARN THIS!
Controllers
  If you haven't read up on MVC, read this:
  http://www.sitepoint.com/the-mvc-pattern-and-php-1 */

/* This is the class that will do most of the non-hook "work" for our module.
It implements ContainerInjectionInterface so we can get information about the user. */
class BartenderController implements ContainerInjectionInterface {

  /* LEARN THIS!
  Properties & Access
    Properties are essentially class-bound variables.
    Public: Modifiable by other objects via $myBartenderController->user = $whatever;
    Private: Not modifiable in that manner, at all.
    Protected: Modifiable by children (classes that extend this one).
  */

  // We'll store our dependency-injected UserSession object here so many methods
  protected $user;

  /* This special function is called when instantiating a new object - it's an OOP thing.
  TO DO: Figure out what these special comments mean and what they do.. annotations? */
  /**
   * Constructs a \Drupal\bartender\Controller\BartenderController object.
   *
   * @param $user
   */
  public function __construct(UserSession $user) {
    $this->user = $user;
  }

  // This is the function that the routing system will use to request instantiation our object.
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    return new static($container->get('current_user'));

  }

  // This is a function that's going to deliver content for our home page.
  public function home() {

    // Thankfully, since we're using a user object, we have access to handy functions like isAuthenticated()!
    if ($this->user->isAuthenticated() == 1) {
      $content = array('#markup' => 'Authenticated placeholder.');
      return $content;
    } else {
      $content = array('#markup' => 'Anonymous placeholder.');
      return $content;
    }

  }
}