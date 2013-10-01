<?php // TO DO - Clean this up!

namespace Drupal\bartender\Form;

use Drupal\Core\Config\ConfigFactory;
// TO DO - Find out of this is necessary, and what it does.
use Drupal\Core\Config\Context\ContextInterface;
/* This provides us with some useful form functions, and does some container magic compared with our controller.
Unfortunately this also makes things more confusing, because they are less consistent. */
use Drupal\system\SystemConfigFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BartenderConfigForm extends SystemConfigFormBase {

  public function __construct(ConfigFactory $configFactory, ContextInterface $context) {
    parent::__construct($configFactory, $context);
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('config.factory'), $container->get('config.context.free'));
  }

  public function getFormID() {
    return 'bartender.settings';
  }

  public function buildForm(array $form, array &$form_state) {
    $config = $this->configFactory->get('bartender.settings');
    $allow_use_profile_values = $config->get('allow_use_profile_values');
    $form['allow_use_profile_values'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Allow authenticated users to get a recommendation based on their default profile values?'),
      '#default_value' => $allow_use_profile_values,
      '#description' => $this->t('Users will be able to fill out a default profile, regardless.'),
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, array &$form_state) {
    // This is the process for writing configuration.
    $this->configFactory->get('bartender.settings')
      ->set('allow_use_profile_values', $form_state['values']['allow_use_profile_values'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}