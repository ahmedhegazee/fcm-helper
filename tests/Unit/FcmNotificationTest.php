<?php

namespace AhmedHegazy\FcmHelper\Tests\Unit;

use AhmedHegazy\FcmHelper\FcmNotification;
use AhmedHegazy\FcmHelper\Tests\TestCase;

class FcmNotificationTest extends TestCase
{

    public function test_can_create_notification_with_title_and_body()
    {
        $notification = new FcmNotification('Test Title', 'Test Body');
        $array = $notification->toArray();

        $this->assertEquals('Test Title', $array['title']);
        $this->assertEquals('Test Body', $array['body']);
    }


    public function test_can_set_image_url()
    {
        $notification = new FcmNotification('Test Title', 'Test Body');
        $imageUrl = 'https://example.com/image.jpg';

        $notification->setImageUrl($imageUrl);
        $array = $notification->toArray();

        $this->assertEquals($imageUrl, $array['image']);
    }


    public function test_returns_array_without_image_when_not_set()
    {
        $notification = new FcmNotification('Test Title', 'Test Body');
        $array = $notification->toArray();

        $this->assertArrayNotHasKey('image', $array);
    }
}
