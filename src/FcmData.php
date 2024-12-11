<?php

namespace AhmedHegazy\FcmHelper;

class FcmData
{
    private array $data = [];

    private string $notifyType = 'general';

    private int $isHide = 0;

    public function add(string $key, string $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function hide()
    {
        $this->isHide = 1;

        return $this;
    }

    public function show()
    {
        $this->isHide = 0;

        return $this;
    }

    public function setNotifyType(string $notifyType): self
    {
        $this->notifyType = $notifyType;

        return $this;
    }

    public function toArray(): array
    {
        $this->data['notify_type'] = $this->notifyType;
        $this->data['is_hidden'] = $this->isHide;

        return $this->data;
    }
}
