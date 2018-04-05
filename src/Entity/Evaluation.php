<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationRepository")
 */
class Evaluation
{
    const STATUTES = [
        0 => 'to do',
        1 => 'done',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $candidate;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question")
     */
    private $questions;

    /**
     * @var Answer[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="evaluation", cascade={"persist", "remove"})
     */
    private $answers;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->status = false;
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getScore()
    {
        $score = 0;
        foreach ($this->answers as $answer) {
            $score += $answer->getValue();
        }

        return $score;
    }

    public function getStatusLabel(): string
    {
        return self::STATUTES[$this->status];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCandidate(): ?string
    {
        return $this->candidate;
    }

    public function setCandidate(string $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
        }

        return $this;
    }

    public function clearAnswers(): self
    {
        foreach ($this->answers as $answer) {
            $this->removeAnswer($answer);
        }

        return $this;
    }
}
