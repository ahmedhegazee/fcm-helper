<?php

namespace AhmedHegazy\FcmHelper;

class FCMDTO
{
    private array $data = [
        'is_hidden' => '0',
        'notify_type' => 'general',
    ];

    private ?string $fcmToken = null;

    private ?string $imageUrl = null;

    public function __construct(
        private string $title,
        private string $body
    ) {}

    /**
     * return notification body
     */
    public function getNotification(): array
    {
        $notification = [
            'body' => $this->body,
            'title' => $this->title,
        ];
        if (! is_null($this->imageUrl)) {
            $notification['image'] = $this->imageUrl;
        }

        return $notification;
    }

    /**
     * set fcm token
     */
    public function setFcmToken(string $fcmToken): self
    {
        $this->fcmToken = $fcmToken;

        return $this;
    }

    /**
     * set image url
     */
    public function setImage(string $image): self
    {
        $this->imageUrl = $image;

        return $this;
    }

    /**
     * get fcm token
     */
    public function getFcmToken(): ?string
    {
        return $this->fcmToken;
    }

    /**
     * hide notification
     */
    public function hide(): self
    {
        $this->data['is_hidden'] = '1';

        return $this;
    }

    /**
     * show notification
     */
    public function show(): self
    {
        $this->data['is_hidden'] = '0';

        return $this;
    }

    /**
     * add data to notification
     */
    public function addData(string $key, string $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * change notification type
     */
    public function setType(string $type): self
    {
        $this->data['notify_type'] = $type;

        return $this;
    }

    /**
     * get fcm notification data
     */
    public function getData(): array
    {
        return $this->data;
    }
}