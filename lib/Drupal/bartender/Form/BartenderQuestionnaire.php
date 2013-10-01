<?php // TO DO - Should I be using FormBase instead?

namespace Drupal\bartender\Form;

use Drupal\Core\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Config\Context\ContextInterface;

class BartenderQuestionnaire implements FormInterface {
  public function __construct(ConfigFactory $configFactory, ContextInterface $context) {
    //parent::__construct($configFactory, $context);
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('config.factory'), $container->get('config.context.free'));
  }

  public function getFormID() {
    return 'bartender.questionnaire';
  }
  public function buildForm(array $form, array &$form_state) {
    $form['test'] = array(
      '#type' => 'markup'
    );

    //return parent::buildForm($form, $form_state);
  }
  public function validateForm(array &$form, array &$form_state) {
    //parent::submitForm($form, $form_state);
  }
  public function submitForm(array &$form, array &$form_state) {
    //parent::submitForm($form, $form_state);
  }
}