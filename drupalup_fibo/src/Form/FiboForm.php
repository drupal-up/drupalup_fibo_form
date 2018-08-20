<?php

namespace Drupal\drupalup_fibo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\drupalup_fibo\FibonacciService;

/**
 * Our simple form class.
 */
class FiboForm extends FormBase {

  protected $fiboService;

  /**
   * {@inheritdoc}
   */
  public function __construct(FibonacciService $fiboService) {
    $this->fiboService = $fiboService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('drupalup_fibo.calc_fibo')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupalup_fibo_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['fibo_numbers'] = [
      '#type' => 'textfield',
      '#title' => $this->t('How many Fibonacci numbers you want to generate?'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Generate!'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message("Our beautiful Fibonacci sequence is: " . implode(',', $this->fiboService->calcSomeFibos($form_state->getValue('fibo_numbers'))));
  }

}
