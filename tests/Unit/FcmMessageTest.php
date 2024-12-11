<?php

namespace AhmedHegazy\FcmHelper\Tests\Unit;

use AhmedHegazy\FcmHelper\FcmAndroid;
use AhmedHegazy\FcmHelper\FcmApn;
use AhmedHegazy\FcmHelper\FcmData;
use AhmedHegazy\FcmHelper\FcmMessage;
use AhmedHegazy\FcmHelper\FcmNotification;
use AhmedHegazy\FcmHelper\Tests\TestCase;

class FcmMessageTest extends TestCase
{
    private FcmNotification $notification;

    private FcmMessage $message;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notification = new FcmNotification('Test Title', 'Test Body');
        $this->message = new FcmMessage($this->notification);
    }

    /** @test */
    public function it_can_set_fcm_token()
    {
        $token = 'test-token';
        $this->message->setFcmToken($token);

        $messageArray = $this->message->toArray();
        $this->assertEquals($token, $messageArray['token']);
    }

    /** @test */
    public function it_can_set_fcm_topic()
    {
        $topic = 'test-topic';
        $this->message->setFcmTopic($topic);

        $messageArray = $this->message->toArray();
        $this->assertEquals($topic, $messageArray['topic']);
    }

    /** @test */
    public function it_can_set_fcm_data()
    {
        $data = new FcmData();
        $data->add('key1', 'value1')
            ->add('key2', 'value2');

        $this->message->setFcmData($data);

        $messageArray = $this->message->toArray();
        $this->assertArrayHasKey('data', $messageArray);
        $this->assertEquals('value1', $messageArray['data']['key1']);
        $this->assertEquals('value2', $messageArray['data']['key2']);
    }

    /** @test */
    public function it_can_set_apn_config()
    {
        $apn = new FcmApn;
        $apn->setPriority(10)
            ->setSound('default.caf')
            ->setCategory('NEW_MESSAGE');

        $this->message->setApn($apn);

        $messageArray = $this->message->toArray();
        $this->assertArrayHasKey('apns', $messageArray);
        $this->assertEquals(10, $messageArray['apns']['headers']['apns-priority']);
    }

    /** @test */
    public function it_can_set_android_config()
    {
        $android = new FcmAndroid;
        $android->setSound('test-collapse.wav');

        $this->message->setAndroid($android);

        $messageArray = $this->message->toArray();
        $this->assertArrayHasKey('android', $messageArray);
        $this->assertEquals('test-collapse.wav', $messageArray['android']['notification']['sound']);
    }

    /** @test */
    public function it_converts_to_array_with_all_components()
    {
        $token = 'test-token';
        $data = new FcmData();
        $data->add('key', 'value');

        $this->message->setFcmToken($token)
            ->setFcmData($data);

        $messageArray = $this->message->toArray();

        $this->assertArrayHasKey('token', $messageArray);
        $this->assertArrayHasKey('notification', $messageArray);
        $this->assertArrayHasKey('data', $messageArray);
        $this->assertEquals($token, $messageArray['token']);
        $this->assertEquals('Test Title', $messageArray['notification']['title']);
        $this->assertEquals('Test Body', $messageArray['notification']['body']);
        $this->assertEquals('value', $messageArray['data']['key']);
    }
}
