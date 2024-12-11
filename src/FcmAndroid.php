<?php

namespace AhmedHegazy\FcmHelper;

class FcmAndroid
{
    private ?int $ttl = null;
    //enables only .wav
    private string $sound = "";
    private string $channelID = "iss";
    private string $clickAction = "TOP_STORY_ACTIVITY";
    public function setTtl(int $seconds): self
    {
        $this->ttl = $seconds;
        return $this;
    }
    public function setSound(string $sound): self
    {
        $this->sound = $sound;
        return $this;
    }
    public function setChannelID(string $channelID): self
    {
        $this->channelID = $channelID;
        return $this;
    }
    public function setClickAction(string $clickAction): self
    {
        $this->clickAction = $clickAction;
        return $this;
    }
    public function toArray(): array
    {
        $config = [];
        if (!empty($this->sound)) {
            $config['sound'] = $this->sound;
        }
        if (!empty($this->channelID)) {
            $config['channel_id'] = $this->channelID;
        }
        if (!empty($this->clickAction)) {
            $config['click_action'] = $this->clickAction;
        }
        $data = [
            "notification" => $config
        ];
        if (!empty($this->ttl)) {
            $data['ttl'] = $this->ttl;
        }
        return $data;
    }
}
