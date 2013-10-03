<?php

namespace Drupal\bartender\Form;

use Drupal\Core\Form\FormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

// The form interface gives us a nice function template.
class BartenderQuestionnaire implements FormInterface {

  public static function create(ContainerInterface $container) {
    return new static($container->get('config.factory'), $container->get('config.context.free'));
  }

  // This defines the form's ID.
  public function getFormID() {
    return 'bartender.questionnaire';
  }

  // This is where you implement form API.
  public function buildForm(array $form, array &$form_state) {

    $form['intro'] = array('#markup' => 'Fill out this questionnaire to get your drink recommendation!');

    $liquors = taxonomy_get_tree('liquors');
    foreach ($liquors as $liquor) {
      $form[$liquor->name] = array(
        '#type' => 'checkbox',
        '#title' => $liquor->name,
      );
    }

    $sweetness = taxonomy_get_tree('sweetness');
    $sweetness_levels = array();
    foreach ($sweetness as $sweetness_level) {
      $sweetness_levels[] = $sweetness_level->name;
    }
    $form['sweetness'] = array(
      '#type' => 'select',
      '#options' => drupal_map_assoc($sweetness_levels),
      '#title' => t('What sweetness level is acceptable?')
    );

    $form['submit'] = array(
      '#type' => 'submit', '#value' => t('Get your drink recommendation!'),
      '#executes_submit_callback' => true
    );
    return $form;
  }

  // Self-explanatory validate function! Unsure whether or not the parent call is needed.. sometimes it errors.
  public function validateForm(array &$form, array &$form_state) {
    if ($form_state['values']['sweetness'] == "Don't Care"
    ) {
      echo 'must supply values';
    }
    parent::validateForm($form, $form_state);
  }

  // Self-explanatory submit function! Unsure whether or not the parent call is needed.. sometimes it errors.
  public function submitForm(array &$form, array &$form_state) {
    parent::submitForm($form, $form_state);
  }
}