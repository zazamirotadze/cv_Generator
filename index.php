<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use zazaCv\{Validation,SomeLogic};

$validation = new Validation();
if(empty($_POST['name'])){
    include("redirectTemplate.html");
    exit;
}
$name = $_POST['name'];


$name = filter_var($name, FILTER_SANITIZE_STRING);
$validation->validateNameAndSurname($name);

$surname = $_POST['surname'];
$surname = filter_var($surname, FILTER_SANITIZE_STRING);
$validation->validateNameAndSurname($surname);

$date = $_POST['date'];
$date = filter_var($date, FILTER_SANITIZE_STRING);
$validation->validateDate($date);
$date = SomeLogic::dateFormatter($date);

$relationship_status = $_POST['relationship_status'];
$relationship_status = filter_var($relationship_status, FILTER_SANITIZE_STRING);
$validation->validateRelationshipStatusAndPhoto($relationship_status, SomeLogic::possibleRelValues);

$address = $_POST['address'];
$address = filter_var($address, FILTER_SANITIZE_STRING);

$phone= $_POST['phone'];
$phone = filter_var($phone, FILTER_SANITIZE_STRING);
$validation->validatePhoneandEmail(SomeLogic::phonePattern, $phone);

$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$validation->validatePhoneandEmail(SomeLogic::emailPattern, $email);

$languages = $_POST['languages'];
$languages = filter_var($languages, FILTER_SANITIZE_STRING);
$languages = nl2br($languages);

$education = $_POST['education'];
$education = filter_var($education, FILTER_SANITIZE_STRING);
$education = nl2br($education);

$computer_skills = $_POST['computer_skills'];
$computer_skills = filter_var($computer_skills, FILTER_SANITIZE_STRING);
$computer_skills = nl2br($computer_skills);

$social_accounts = $_POST['social_accounts'];
$social_accounts = filter_var($social_accounts, FILTER_SANITIZE_STRING);
$social_accounts = nl2br($social_accounts);

$work_experience = $_POST['work_experience'];
$work_experience = filter_var($work_experience, FILTER_SANITIZE_STRING);
$work_experience= nl2br($work_experience);

$validation->validateRelationshipStatusAndPhoto($_FILES['image']['type'], SomeLogic::mimeTypes);
$file_tmp_name = $_FILES['image']['tmp_name'];
$imageData = base64_encode(file_get_contents($file_tmp_name));
$photo = 'data:image/jpeg;base64,' . $imageData;

$valuesToReplace = [$name, $surname, $date, $relationship_status, $address, $phone, $email, $languages, $education, $computer_skills, $social_accounts, $work_experience, $photo];

$html = file_get_contents('cvTemplate.html');
$html = str_replace( SomeLogic::patternsToReplace, $valuesToReplace , $html);

$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'landscape');

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->addInfo('Title', 'an example pdf');
$dompdf->stream("{$name}Cv.pdf", ['Attachment'=>0]);