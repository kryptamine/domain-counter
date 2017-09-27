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

    const LIMIT = 100000;

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
     * @return array
     */
    public function calculate() : array
    {
        $offset = 0;
        $result = [];

        while ($userEmails = $this->getEmails(static::LIMIT + $offset, $offset)) {
            foreach ($userEmails as $emails) {
                $emails = explode(',', $emails);

                foreach (array_filter($emails) as $email) {
                    list($firstPart, $domain) = explode('@', $email);

                    if (!array_key_exists($domain, $result)) {
                        $result[$domain] = 1;
                    } else {
                        $result[$domain]++;
                    }
                }
            }

            $offset += static::LIMIT;
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
        return $this->db->getInstance()->query("SELECT id, email FROM users WHERE id >= $offset AND id < $limit")->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}