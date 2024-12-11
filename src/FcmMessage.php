<?php

namespace AhmedHegazy\FcmHelper;

class FcmMessage
{
    private ?FcmApn $apn = null;

    private ?FcmAndroid $android = null;

    private ?string $fcmToken = null;

    private ?string $fcmTopic = null;

    public function __construct(
        private FcmNotification $fcmNotification,
    ) {}

    public function setApn(FcmApn $apn): self
    {
        $this->apn = $apn;

        return $this;
    }

    public function setAndroid(FcmAndroid $android): self
    {
        $this->android = $android;

        return $this;
    }

    public function setFcmToken(string $fcmToken): self
    {
        $this->fcmToken = $fcmToken;

        return $this;
    }

    public function setFcmTopic(string $fcmTopic): self
    {
        $this->fcmTopic = $fcmTopic;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'notification' => $this->fcmNotification->toArray(),
        ];
        if (! \is_null($this->fcmToken)) {
            $data['token'] = $this->fcmToken;
        }
        if (! \is_null($this->fcmTopic)) {
            $data['topic'] = $this->fcmTopic;
        }
        if (! empty($this->apn)) {
            $data['apns'] = $this->apn->toArray();
        }
        if (! empty($this->android)) {
            $data['android'] = $this->android->toArray();
        }

        return $data;
    }
}
