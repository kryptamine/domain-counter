<?php

require_once __DIR__ . '/../../vendor/autoload.php';

/** @var PDO $db */
$db = new \App\DB('localhost', 'test_task', 'root', 'root');

$stmt = $db->getInstance()->prepare("INSERT INTO users (name, gender, email) VALUES (:name, :gender, :email)");

function generateEmails()
{
    $domains = ['bk', 'mail', 'yandex'];
    $result  = [];

    foreach (range(0, rand(0, 3)) as $number) {
        if ($number == 3) {
            return '';
        }

        $result[] = sprintf('%s@%s.ru', substr(md5(mt_rand()), 0, 7), $domains[rand(0, 2)]);;
    }

    return implode(',', $result);
}

for ($i = 0; $i <= 1000; $i++) {
    $name   = substr(md5(mt_rand()), 0, 7);
    $gender = rand(1, 2);
    $emails = generateEmails();

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':email', $emails);
    $stmt->execute();
}