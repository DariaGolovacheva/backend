<?php
function print_error($error)
{
    print($error);
    exit();
}

function validate_data($data)
{
    $errors = [];
    $all_names = ["name", "phone", "email", "dob", "gender", "favourite_language", "bio", "contract"];
    $re_patterns = ['name' => '/^[\w\s]+$/',
        'phone' => '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/',
        'email' => '/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/'];
    $size_limits = ['name' => 255, 'email' => 255, 'bio' => 512];
    foreach ($all_names as $name) {
        if (empty($data[$name])) {
            $errors[$name] = "Field {$name} is empty.";
        } elseif (in_array($name, array_keys($size_limits))
            && strlen($data[$name]) > $size_limits[$name]) {
            $errors[$name] = "Length of the contents of the field {$name} more than {$size_limits[$name]} symbols.";
        } elseif (in_array($name, array_keys($re_patterns))
            && !preg_match($re_patterns[$name], $data[$name])) {
            $errors[$name] = "Invalid {$name}.";
        } elseif ($name == 'dob') {
            if (!strtotime($data[$name]) ||
                strtotime('1900-01-01') > strtotime($data[$name]) ||
                strtotime($data[$name]) > time()) {
                $errors[$name] = "Invalid {$name}.";
            }
        }
    }

    if (!empty($errors)) {
        setcookie('errors', serialize($errors), 0);
        setcookie('incor_data', serialize($data), 0);
        header("Location:" . parse_url($_SERVER['REQUEST_URI'])['path'] . "?errors_flag=true");
        exit();
    }
}

function save_to_database($data)
{
    $user = 'u67498';
    $pass = '2427367';
    $dbname = 'u67498';
    try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $names_data_for_app = ['name', 'phone', 'email', 'dob', 'gender', 'bio'];
        $app_req = "INSERT INTO application (" . implode(', ', $names_data_for_app) .
            ") VALUES (";
        $data_for_app = [];
        foreach ($names_data_for_app as $name) {
            $data_for_app[] = "'" . $data[$name] . "'";
        }
        $app_req = $app_req . implode(', ', $data_for_app) . ");";
        $app_stmt = $db->prepare($app_req);
        $app_stmt->execute();

        $last_app_id = $db->lastInsertId();
        $link_req = "INSERT INTO app_link_lang (id_app, id_prog_lang) VALUES ";
        $data_for_link = [];
        foreach ($data["favourite_language"] as $lang) {
            $data_for_link[] = "(" . $last_app_id . ", " . $lang . ")";
        }
        $link_req = $link_req . implode(", ", $data_for_link) . ";";
        $link_stmt = $db->prepare($link_req);
        $link_stmt->execute();
    } catch (PDOException $e) {
        print_error($e->getMessage());
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include('form.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $all_names = ["name", "phone", "email", "dob", "gender", "favourite_language", "bio", "contract"];
    $form_data = array_fill_keys($all_names, "");
    $form_data['favourite_language'] = [];
    foreach ($_POST as $key => $val) {
        if (!empty($val)) {
            if ($key == 'favourite_language') {
                $form_data[$key] = explode(',', $val);
            } else {
                $form_data[$key] = $val;
            }
        }
    }
    validate_data($form_data);
    save_to_database($form_data);
    setcookie('cor_data', serialize($form_data), time() + 3600 * 24 * 365);
    header("Location:" . parse_url($_SERVER['REQUEST_URI'])['path'] . "?success_flag=true");
}
?>
