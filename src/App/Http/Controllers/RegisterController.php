<?php
namespace Http\Controllers;
use Lib\MVCCore\Controller;
use Lib\MVCCore\Routers\Responses\Response;
use Lib\MVCCore\Routers\Responses\ViewResponse;

class RegisterController extends Controller{
    public function register(): ?Response{
        $Response = new ViewResponse();
        $Response->setBody(view(VIEWS_PATH . 'Register.view.php', [] )->withLayout(VIEWS_PATH . 'Layouts/Main.layout.php'));
        return $Response;
    }

public function get(): ?Response{
    $request = $this->currentRequest;
    if ($request->hasPostObject()) {
        //dumpDie($request->getPostObject()->body());
        redirect('/RegisterSucces');
    }
}



public function post(): ?Response {
    unset($_SESSION['error'], $_SESSION['success']);
    $postObject = $this->currentRequest->getPostObject();

    // List of input fields
    $fields = array(
        'firstname',
        'middlename',
        'lastname',
        'zipcode',
        'housenumber',
        'addition',
        'street',
        'city',
        'country',
        'phonenumber',
        'birthdate',
        'email',
        'wachtwoord',
        'herhalen wachtwoord',
    );

    // Initialize the formData array
    $formData = array();

    // Initialize the notFilledFields array
    $notFilledFields = array();

    // Flag to check if all fields are filled
    $allFieldsFilled = true;

    // Loop through each field and retrieve the data
    foreach ($fields as $field) {
        // Check if the field is set in the POST data
        if (isset($_POST[$field])) {
            // Store the field data in the array
            $formData[$field] = $_POST[$field];
        } else {
            // If the field is not set, you can set a default value or leave it empty
            $formData[$field] = '';

            // Set the flag to false if any field is not filled
            $allFieldsFilled = false;

            // Add the field to the notFilledFields array
            $notFilledFields[] = $field;
        }
    }

    // Check the selected radio button
    if (isset($_POST['inlineRadioOptions'])) {
        $selectedRadioButton = $_POST['inlineRadioOptions'];
        echo "Selected radio button: " . $selectedRadioButton;
    } else {
        echo "No radio button selected";
        $allFieldsFilled = false; // Set the flag to false if radio button is not selected
    }

    // Store the form data in the session
    $_SESSION['formData'] = $formData;

    // Redirect to the same page if not all fields are filled
    if (!$allFieldsFilled) {
        $_SESSION['notFilledFields'] = $notFilledFields;
        redirect('/Register');
    }

    // Return a response if needed
    // return new Response();
}


}








?>