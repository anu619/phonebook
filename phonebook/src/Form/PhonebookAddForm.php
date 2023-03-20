<?php
/**
 * @file
 * Contains Drupal\phonebook\Form\PhonebookAddForm.
 */
namespace Drupal\phonebook\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class PhonebookAddForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'phonebook';
  }
  
  /**
   * Build Phonebook form
   */

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['phonebook_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Name:'),
      '#required' => TRUE,
      '#attributes' => array('class' => array('sg-element')),
    );
    $form['phonebook_number'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Phone Number:'),
      '#required' => TRUE,
      '#attributes' => array('class' => array('sg-element'),'placeholder' => t('+44 123456789')),
    ); 
    $form['phonebook_email'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter Email:'),
      '#required' => TRUE,
      '#attributes' => array('class' => array('sg-element'),'placeholder' => t('example@exampl.com')), // Add classess
    );       
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
      '#attributes' => array('class' => array('sg-btn', 'sg-without-icon', 'sg-btn-primary')), //Add classes
    );
    return $form;
  }

  /**
   * Vailidate the phonebook entry
   */
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
      
     // Get all the form enter value and stored
      $mobile = $form_state->getValue(['phonebook_number']);
      $name = $form_state->getValue(['phonebook_name']);
      $email = $form_state->getValue(['phonebook_email']);
      // Check name field is empty or not
      if (empty($name)) {
        $form_state->setErrorByName('phonebook_name', t('Name field required.'));
      }
      // Check name field contain only letters
      if (!preg_match ("/^[a-zA-Z\s]+$/",$name)) {
        $form_state->setErrorByName('phonebook_name', t('Name must only contain letters!'));
      }
      //Check phone number filed is empty or not
      if (empty($mobile)) {
        $form_state->setErrorByName('phonebook_number', t('Number field required.'));
      }
      $number = preg_replace("/[^0-9]/", "", $mobile); // Validate numeric
      $number = preg_replace('/\s+/', '', $number); // Check the space and plus 
      $mobile_length = strlen((string) $number); // Get Length of number
      // Check phone number length below 6
      if ($mobile_length < 6){
        $form_state->setErrorByName('phonebook_number', t('Number field have atleast 6 digits.'));
      }
      //Check a valid number
      if (!preg_match("/^[- +]*[0-9][- +0-9]*$/", $mobile)) {
        $form_state->setErrorByName('phonebook_number', t('Please enter a valid phone number.'));
      }
      //Check email field is empty or not
      if (empty($email)) {
        $form_state->setErrorByName('phonebook_email', t('Number field required.'));
      }
      //Check email format is bvalid or not
      if (!\Drupal::service('email.validator')->isValid($email)) {
        $form_state->setErrorByName('phonebook_email', t('The email address %mail is not valid.', array('%mail' => $email)));
      }
    
  }
  
  /**
   * Phonebook submit and insert into the database
   */

  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    try{
      $connection = \Drupal::service('database');      // Connect database service
      $data = $form_state->getValues();     // Get all values 
      $current_user = \Drupal::currentUser(); // Get Logged user details
      $uid = $current_user->id(); 
      
      // Stored in to the variable
      $options["user_id"] = $uid;
      $options["name"] = $data['phonebook_name'];
      $options["number"] = $data['phonebook_number'];
      $options["email"] = $data['phonebook_email'];
      
      $connection->insert('phonebook')
          ->fields($options)->execute(); // Insert in to the database
      \Drupal::messenger()->addMessage($this->t('The Phonebook data has been succesfully saved'));
       
    } catch(Exception $ex){
      \Drupal::logger('phonebook')->error($ex->getMessage()); // Stored in to the watchdog
    }
      
  }
  

}