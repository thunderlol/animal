<?php
// FUNCTIONS.php

// clean the form data to prevent injections

/*  Built in functions used:
    trim()
    stripslashes()
    htmlspecialchars()
    strip_tags()
    str_replace()
*/

function validateFormData($formData) {
    $formData = trim( stripslashes( htmlspecialchars( strip_tags( str_replace( array( '(', ')' ), '', $formData ) ), ENT_QUOTES ) ) );
    return $formData;
}


function validate($formData) {
  $formData = trim($formData);
  $formData = stripslashes($formData);
  return $formData;
}


?>