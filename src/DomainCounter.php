<?php

namespace App;

use PDO;

/**
 * Class DomainCounter
 * @package App
 */
class DomainCounter
{
    /**
     * @var DB
     */
    private $db;

    /**
     * DomainCounter constructor.
     *
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $chunkSize
     *
     * @return array
     */
    public function calculate(int $chunkSize) : array
    {
        $offset = 0;
        $result = [];

        while ($userEmails = $this->getEmails($chunkSize, $offset)) {
            foreach ($userEmails as $emails) {
                $emails = explode(',', $emails);

                foreach (array_unique(array_filter($emails)) as $email) {
                    list($firstPart, $domain) = explode('@', $email);

                    if (!array_key_exists($domain, $result)) {
                        $result[$domain] = 1;
                    } else {
                        $result[$domain]++;
                    }
                }
            }

            $offset += $chunkSize;
        }

        return $result;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getEmails(int $limit, int $offset)
    {
        return $this->db->getInstance()->query("
            SELECT users.id, users.email FROM users JOIN 
            (SELECT id FROM users ORDER BY id LIMIT $offset, $limit) as u ON u.id = users.id
        ")->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}