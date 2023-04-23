<?php

namespace App\cbr;

class cbrDto {

    private $date;
    private $valute;
    private $save;
    private $comment;
    private $uid;

    /**
     * cbrDto constructor.
     * @param array $params
     */

    public function __construct(
        array $params
    ) {
        $this->date = $params['date'] ?? null;
        $this->valute = $params['valute'] ?? null;
        $this->save = $params['save'] ?? null;
        $this->comment = $params['comment'] ?? null;
        $this->uid = $params['uid'] ?? null;
    }

    /**
     * @return string|null
     */

    public function getDate(): string | null
    {
        return $this->date;
    }

    /**
     * @return string|null
     */

    public function getValute(): string | null
    {
        return $this->valute;
    }

    /**
     * @return string|null
     */

    public function getSave(): string | null
    {
        return $this->save;
    }

    /**
     * @return string|null
     */

    public function getComment(): string | null
    {
        return $this->comment;
    }

    /**
     * @return string|null
     */
    public function getUid(): string | null
    {
        return $this->uid;
    }

}
