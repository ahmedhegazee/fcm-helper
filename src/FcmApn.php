<?php

namespace AhmedHegazy\FcmHelper;

class FcmApn
{
    private ?int $priority = null;

    //enables only .caf
    private string $sound = '';

    private string $category = 'NEW_MESSAGE_CATEGORY';

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function setSound(string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];
        if (! empty($this->priority)) {
            $config['priority'] = $this->priority;
        }
        if (! empty($this->sound)) {
            $config['sound'] = $this->sound;
        }
        if (! empty($this->category)) {
            $config['category'] = $this->category;
        }
        $data = [
            'payload' => [
                'aps' => $config,
            ],
        ];
        if (! is_null($this->priority)) {
            $data['headers'] = [
                'apns-priority' => $this->priority,
            ];
        }

        return $data;
    }
}
