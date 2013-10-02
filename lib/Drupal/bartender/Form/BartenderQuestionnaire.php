<?php

namespace Drupal\bartender\Form;

use Drupal\Core\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BartenderQuestionnaire implements FormInterface {

  public static function create(ContainerInterface $container) {
    return new static($container->get('config.factory'), $container->get('config.context.free'));
  }

  public function getFormID() {
    return 'bartender.questionnaire';
  }
  public function buildForm(array $form, array &$form_state) {
    $form['test'] = array(
      '#markup' => 'Questionnaire Placeholder'
    );
    return $form;
  }
  public function validateForm(array &$form, array &$form_state) {

  }
  public function submitForm(array &$form, array &$form_state) {

  }
}