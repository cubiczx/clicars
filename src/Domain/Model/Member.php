<?php


namespace Clicars\Domain\Model;


use Clicars\Domain\Interfaces\IMember;

class Member implements IMember
{

    /** @var int $id */
    private int $id;

    /** @var int $age */
    private int $age;

    /** @var IMember $boss */
    private IMember $boss;

    /** @var array $subordinates */
    private array $subordinates;

    /**
     * Initialize the object
     *
     * @param int $id
     * @param int $age
     */
    public function __construct(int $id, int $age)
    {
        $this->id = $id;
        $this->age = $age;
    }

    /**
     * Set member id
     * @param int $id
     * @return IMember
     */
    public function setId(int $id): IMember
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get member id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set member age
     * @param int $age
     * @return IMember
     */
    public function setAge(int $age): IMember
    {
        $this->age = $age;
        return $this;
    }

    /**
     * Get member age
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Add a new subordinate
     *
     * @param IMember $subordinate
     *
     * @return $this
     */
    public function addSubordinate(IMember $subordinate): IMember
    {
        $this->subordinates[] = $subordinate;
        return $this;
    }

    /**
     * Remove a subordinate
     *
     * @param IMember $subordinate
     *
     * @return IMember|null
     */
    public function removeSubordinate(IMember $subordinate): ?IMember
    {
        // TODO: Implement removeSubordinate() method.
    }

    /**
     * Get the list of the subordinates
     * @return IMember[]
     */
    public function getSubordinates(): array
    {
        return $this->subordinates;
    }

    /**
     * Get his boss
     * @return IMember|null
     */
    public function getBoss(): ?IMember
    {
        return $this->boss;
    }

    /**
     * Set boss of the member
     *
     * @param IMember|null $boss
     *
     * @return $this
     */
    public function setBoss(?IMember $boss): IMember
    {
        $this->boss = $boss;
        $this->boss->addSubordinate($this);
        return $this;
    }
}