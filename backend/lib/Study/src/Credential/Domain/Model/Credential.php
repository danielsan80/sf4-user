<?php

namespace Study\Credential\Domain\Model;

class Credential
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $label;

    /** @var string */
    protected $key;

    /** @var KeyGenerator */
    protected $keyGenerator;


    public function __construct(string $id, string $label, ?string $key=null)
    {
        if ($key === null) {
            $key = $this->keyGenerator()->generate();
        }

        $this->setId($id);
        $this->setLabel($label);
        $this->setKey($key);
    }

    protected function keyGenerator(): KeyGenerator
    {
        if (!$this->keyGenerator) {
            $this->keyGenerator = new KeyGenerator();
        }
        return $this->keyGenerator;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function label(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @param string $id
     */
    private function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

}