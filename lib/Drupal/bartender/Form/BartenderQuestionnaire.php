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

    $form['intro'] = array('#markup' => 'Fill out this questionnaire to get your drink recommendation!');

    $liquors = taxonomy_get_tree('liquors');
    $liquor_names = array();
    foreach ($liquors as $liquor) {
      $liquor_names[] = $liquor->name;
    }
    $form['liquors'] = array(
      '#type' => 'checkboxes',
      '#options' => drupal_map_assoc($liquor_names),
      '#title' => t('What liquors are acceptable?')
    );

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

    $form['submit'] = array('#type' => 'submit', '#value' => t('Get your drink recommendation!'));
    return $form;
  }
  public function validateForm(array &$form, array &$form_state) {

  }
  public function submitForm(array &$form, array &$form_state) {
    //var_dump($form_state);
    var_dump($form);
    return;
  }
}