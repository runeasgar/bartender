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
// TO DO - Describe these
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Config\ConfigFactory;
use Drupal\bartender\Form\BartenderQuestionnaire;

/* LEARN THIS!
OOP: Classes, Properties, Methods, Interfaces, Abstraction
  If you haven't read up on classes, read these. They'll be relevant to a LOT of what you see here.
  http://www.lornajane.net/posts/2012/introduction-to-php-oop
  http://www.lornajane.net/posts/2012/a-little-more-oop-in-php

Interfaces
  An interface is like a required blueprint for a class. It will contain functions that an implementing class
    MUST implement.

MVC: Models, Views, Controllers
  If you haven't read up on MVC, read this:
  http://www.sitepoint.com/the-mvc-pattern-and-php-1 */

/* This is the controller that will do most of the non-hook "work" for our module.
It implements ContainerInjectionInterface so we can get information about the user. */
class BartenderController implements ContainerInjectionInterface {

  /* LEARN THIS!
  Properties & Access
    Properties are essentially class-bound variables.
    Public: Modifiable by other objects via $myBartenderController->user = $whatever;
    Private: Not modifiable in that manner, at all.
    Protected: Modifiable by children (classes that extend this one). */

  // We'll store our dependency-injected objects here so many methods can access them.
  protected $user;
  protected $config;

  /* This special function is called when instantiating a new object - it's an OOP thing.
  TO DO - Figure out what these special comments mean and what they do.. annotations? */
  /**
   * Constructs a \Drupal\bartender\Controller\BartenderController object.
   *
   * @param \Drupal\Core\Session\UserSession $user
   */
  public function __construct(UserSession $userSession, ConfigFactory $configFactory) {

    // Here, we're just assigning the $user parameter that is passed in to the $user property we made earlier.
    $this->userSession = $userSession;
    $this->configFactory = $configFactory;

  }

  /* This special function is what the routing system will use to request instantiation our object.
  TO DO - Figure out what these special comments mean and what they do.. annotations? */
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    /* Here, we're getting and passing the container's current user object into an instantiation
      of our object (__construct). If this seems a little cyclical, it's because it is.
      This is the essence of dependency injection in Drupal 8. */
    return new static($container->get('current_user'), $container->get('config.factory'));

  }

  // This is a function that's going to deliver content for our home page.
  public function home(Request $request) {

    // Thankfully, since we're using a user object, we have access to handy functions like isAuthenticated()!
    if ($this->userSession->isAuthenticated() == 1) {
      $markup = '';
      // This is a basic example of reading a value from configuration.
      if ($this->configFactory->get('bartender.settings')->get('allow_use_profile_values') == 1) {
        $markup .= 'Use Profile Values Button<br />' . PHP_EOL;
      }
      $markup .= <<<EOD
Use Profile Values & Modify Button<br />
Questionnaire
EOD;
      return array('#markup' => $markup);
    } else {
      // Here, we use the request object (always available as a parameter on actions) to check a cookie's existence.
      if (!empty($request->cookies->get('bartender-questionnaire')->value)) {
        $content = array('#markup' => <<<EOD
Retake Questionnaire Button<br />
Previous Results Shown
EOD
        );
        return $content;
      } else {
        return drupal_get_form(new BartenderQuestionnaire());
      }
    }

  }
}