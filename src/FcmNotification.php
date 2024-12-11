<?php

namespace AhmedHegazy\FcmHelper;

class FcmNotification
{
    private ?string $imageUrl = null;

    public function __construct(
        private string $title,
        private string $body
    ) {}

    /**
     * set image url
     */
    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * return notification body
     */
    public function toArray(): array
    {
        $notification = [
            'title' => $this->title,
            'body' => $this->body,
        ];
        if (! is_null($this->imageUrl)) {
            $notification['image'] = $this->imageUrl;
        }

        return $notification;
    }
}
