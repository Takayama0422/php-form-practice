<?php
function validatedFormInput(array $input): array {
    foreach (['name', 'email', 'age'] as $field) {
        if (!isset($input[$field]) || !is_string($input[$field])) { throw new InvalidArgumentException('Invalid form input.'); }
    }
    $name=trim($input['name']); $email=trim($input['email']); $age=$input['age'];
    if (!preg_match('/\\A.{1,100}\\z/us', $name) || strlen($email)>254 || !filter_var($email,FILTER_VALIDATE_EMAIL)
        || filter_var($age,FILTER_VALIDATE_INT,['options'=>['min_range'=>0,'max_range'=>150]]) === false) {
        throw new InvalidArgumentException('Invalid form input.');
    }
    return ['name'=>$name,'email'=>$email,'age'=>$age];
}
