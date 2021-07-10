<?php


namespace Clicars\Domain\Model;


use Clicars\Domain\Interfaces\IMafia;
use Clicars\Domain\Interfaces\IMember;

class Mafia implements IMafia
{

    /** @var IMember $godfather */
    private IMember $godfather;

    /** @var array $members */
    private array $members = [];

    /**
     * Initialize the object
     *
     * @param IMember $godfather
     */
    public function __construct(IMember $godfather)
    {
        $this->godfather = $godfather;
    }

    /**
     * Get the godfather of the organisation
     * @return IMember
     */
    public function getGodfather(): IMember
    {
        return $this->godfather;
    }

    /**
     * Add new member to the net
     *
     * @param IMember $member
     *
     * @return IMember|null
     */
    public function addMember(IMember $member): ?IMember
    {
        $this->members[] = $member;
        return $member;
    }

    /**
     * Get a member by id
     *
     * @param int $id
     *
     * @return IMember|null
     */
    public function getMember(int $id): ?IMember
    {
        foreach ($this->members as $member){
            if ($member->getId() === $id) {
                return $member;
            }
        }
        return null;
    }

    /**
     * Put a member in prison
     *
     * @param IMember $member
     *
     * @return bool
     */
    public function sendToPrison(IMember $member): bool
    {
        // Search member
        foreach ($this->members as $key => $mafiaMember){
            $temporalBoss = $this->searchTemporalBoss($member);
            // Search member to remove form maida and send to jail
            if ($mafiaMember->getId() === $member->getId()) {
                // Remove member of mafia
                unset($this->members[$key]);
                // Add member to jail
                new Jail($member);
            }
            // Search member with boss prisoner and assign new boss
            if ($mafiaMember->getBoss()->getId() === $member->getId()) {
                $mafiaMember->setBoss($temporalBoss);
            }
        }

        return true;
    }

    /**
     * Release a member from the prison
     *
     * @param IMember $member
     *
     * @return bool
     */
    public function releaseFromPrison(IMember $member): bool
    {
        // TODO: Implement releaseFromPrison() method.
    }

    /**
     * Find bosses who have more than required number of subordinates
     *
     * @param int $minimumSubordinates
     *
     * @return IMember[]
     */
    public function findBigBosses(int $minimumSubordinates): array
    {
        // TODO: Implement findBigBosses() method.
    }

    /**
     * Compare two members between them and return the one with the highest level or null if they are equals
     *
     * @param IMember $memberA
     * @param IMember $memberB
     *
     * @return IMember|null
     */
    public function compareMembers(IMember $memberA, IMember $memberB): ?IMember
    {
        // TODO: Implement compareMembers() method.
    }

    /**
     * @param IMember $member
     * @return IMember
     */
    private function searchTemporalBoss(IMember $member): IMember
    {
        // Search with same Boss and older member
        $membersWithSameBoss = [];
        foreach ($this->members as $mafiaMember){
            // Search with same Boss
            if($member->getBoss() == $mafiaMember->getBoss() && $mafiaMember !== $member){
                $membersWithSameBoss[] = $mafiaMember;
            }
        }
        return !empty($membersWithSameBoss)
            ? $this->searchOlderMember($membersWithSameBoss)
            : $this->searchOlderSubordinate($member);
    }

    /**
     * @param array $membersWithSameBoss
     * @return IMember
     */
    private function searchOlderMember(array $membersWithSameBoss): IMember
    {
        return array_reduce($membersWithSameBoss, function($a, $b){
            return $a ? ($a->getAge() > $b->getAge() ? $a : $b) : $b;
        });
        /*$previous = null;
        echo count($membersWithSameBoss);
        foreach ($membersWithSameBoss as $memberWithSameBoss){
            var_dump($previous);
            if(!empty($previous)){
                echo 7;
                if($memberWithSameBoss->getAge() > $previous->getAge()){
                    echo 1;
                    return $memberWithSameBoss;
                } else{
                    echo 2;
                    return $previous;
                }
            }
            $previous = $memberWithSameBoss;
        }*/
    }

    /**
     * @param IMember $member
     * @return IMember
     */
    private function searchOlderSubordinate(IMember $member): IMember
    {
        $subordinates = $member->getBoss()->getSubordinates();
        return array_reduce($subordinates, function($a, $b){
            return $a ? ($a->getAge() > $b->getAge() ? $a : $b) : $b;
        });
    }
}